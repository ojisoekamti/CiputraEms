<?php
defined('BASEPATH') or exit('No direct script access allowed');

class p_unit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('core/m_unit');
		$this->load->model('m_core');
		global $jabatan;
		$jabatan = $this->m_core->jabatan();
		global $project;
		$project = $this->m_core->project();
		global $menu;
		$menu = $this->m_core->menu();
		global $unit_id;
		$unit_id = $this->m_core->unit_id();
		//var_dump($this->session->userdata('name'));
	}
	public function index($unit_id = 0)
	{
		// $service = $this->m_unit->getService($this->input->get("unit_id"));
		// $tagihan = $this->m_unit->getTagihan($this->input->get("unit_id"));

		// $tmp = $this->m_unit->getUnitBlokKawasan($this->input->get("unit_id"));
		// $unit = $tmp->unit;
		// $kawasan = $tmp->kawasan; 
		// $blok 	 = $tmp->blok;

		// $unit = $this->db   ->select("CONCAT(kawasan.name,' - ',blok.name,' - ',unit.no_unit) as unit")
		//                     ->from('unit')
		//                     ->join('blok',
		//                             'blok.id = unit.blok_id')
		//                     ->join('kawasan',
		//                         'kawasan.id = blok.kawasan_id')
		//                     ->where('unit.project_id',$GLOBALS['project']->id)
		//                     ->get()->result();

		// echo('<pre>');
		//     print_r($unit);
		// echo('</pre>');
		$unit = (object) [];
		if ($unit_id != 0) {
			$unit = $this->db
				->select("unit.id, CONCAT(kawasan.name,'-',blok.name,'/',unit.no_unit,'-',customer.name) as text")
				->from('unit')
				->join(
					'blok',
					'blok.id = unit.blok_id'
				)
				->join(
					'kawasan',
					'kawasan.id = blok.kawasan_id'
				)
				->join(
					'customer',
					'customer.id = unit.pemilik_customer_id'
				)
				->where('unit.project_id', $GLOBALS['project']->id)
				->where("unit.id", $unit_id)
				->get()->row();
		} else {
			$unit->id = 0;
		}
		$this->load->view('core/header');
		$this->load->model('alert');
		$this->alert->css();

		$this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);

		// $this->load->view('core/side_bar_customer',['menu' => $GLOBALS['menu']]);
		$this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
		$this->load->view('unit/dashboard', [
			"unit" => $unit
		]);
		$this->load->view('core/body_footer');
		$this->load->view('core/footer');
	}
	public function ajax_save_kwitansi()
	{
		$pembayaran_id	= $this->input->post("pembayaran_id");
		$no_kwitansi	= $this->input->post("no_kwitansi");

		$kwitansi_referensi_id = $this->db->select("t_pembayaran_detail.kwitansi_referensi_id")
			->from("t_pembayaran")
			->join(
				"t_pembayaran_detail",
				"t_pembayaran_detail.t_pembayaran_id = t_pembayaran.id"
			)
			->where("t_pembayaran.id", $pembayaran_id)
			->get()->row();
		$kwitansi_referensi_id = $kwitansi_referensi_id ? $kwitansi_referensi_id->kwitansi_referensi_id : 0;
		$this->db->set("no_kwitansi", $no_kwitansi);
		$this->db->where("id", $kwitansi_referensi_id);
		$this->db->update("kwitansi_referensi");
		echo json_encode(true);
	}
	public function get_ajax_unit()
	{
		$unit = 
			$this->db->select("unit.id, CONCAT(kawasan.name,'-',blok.name,'/',unit.no_unit,'-',customer.name) as text")
			->from('unit')
			->join(
				'blok',
				'blok.id = unit.blok_id'
			)
			->join(
				'kawasan',
				'kawasan.id = blok.kawasan_id'
			)
			->join(
				'customer',
				'customer.id = unit.pemilik_customer_id'
			)
			->where('unit.project_id', $GLOBALS['project']->id)
			->where("CONCAT(kawasan.name,'-',blok.name,'/',unit.no_unit,'-',customer.name) like '%" . $this->input->get('data') . "%'")
			->get()->result();
		echo json_encode($unit);
	}
	public function get_ajax_unit_detail()
	{
		$project = $this->m_core->project();

		$periode_now = date("Y-m-01");
		$periode_pemakaian = date("Y-m-01", strtotime("-1 Months"));
		$unit_id = $this->input->get('unit_id');
		$unit = $this->db->select("
									pemilik.name as pemilik, 
									penghuni.name as penghuni,
									pemilik.id as pemilik_id,
									penghuni.id as penghuni_id,
									unit.luas_bangunan,
									isnull(unit.luas_taman,0) as luas_taman,
									unit.luas_tanah,
									concat(jenis_golongan.code,' - ',jenis_golongan.description) as golongan,
									'Rumah' as purpose_use,
									'-' as type_unit,
									convert(varchar,tgl_st,103) as tgl_st
									")
			->from('unit')
			->join('customer as pemilik', 'pemilik.id = unit.pemilik_customer_id')
			->join('customer as penghuni', 'penghuni.id = unit.penghuni_customer_id','LEFT')
			->join('jenis_golongan', 'jenis_golongan.id = unit.gol_id')

			->where('unit.id', $unit_id)
			->get()->row();

		// WHEN v_tagihan_air.periode > '$periode_now' THEN 0 -> kalau periode nya lebih dari periode saat ini, denda = 0
		$pemilik = $this->db->select("	isnull(name,' ') as name,
										isnull(email,' ') as email,
										isnull(mobilephone1,' ') as mobilephone1,
										isnull(mobilephone2,' ') as mobilephone2,
										isnull(address,' ') as address")
							->from("customer")
							->where("id",$unit->pemilik_id)
							->get()->row();
		$penghuni = $this->db->select("	isnull(name,' ') as name,
										isnull(email,' ') as email,
										isnull(mobilephone1,' ') as mobilephone1,
										isnull(mobilephone2,' ') as mobilephone2,
										isnull(address,' ') as address")
							->from("customer")
							->where("id",$unit->penghuni_id)
							->get()->row();
		$tagihan_air = $this->db->select("
								'Air' as service,
								v_tagihan_air.periode,
								0 as nilai_penalti,

								(v_tagihan_air.total - v_tagihan_air.total_tanpa_ppn) as ppn,
								DATEADD(
									MONTH, 
									(
										(-1)*(CONVERT(INT,service.jarak_periode_penggunaan))
									),
									v_tagihan_air.periode
								) as periode_pemakaian,
								v_tagihan_air.total_tanpa_ppn,
								isnull(CASE 
								WHEN DATEADD(MONTH, 1,v_tagihan_air.periode) >= '$periode_now' THEN v_tagihan_air.total
								ELSE 0
								END,0) as nilai_tagihan,
								isnull(CASE 
									WHEN DATEADD(MONTH, 1,v_tagihan_air.periode) < '$periode_now' THEN v_tagihan_air.total
									ELSE 0
								END,0) as nilai_tunggakan,
								isnull(CASE
									WHEN v_tagihan_air.nilai_denda_flag = 1 THEN v_tagihan_air.nilai_denda 
									WHEN v_tagihan_air.periode > '$periode_now' THEN 0
									ELSE
										CASE
											WHEN v_tagihan_air.denda_jenis_service = 1 
												THEN v_tagihan_air.denda_nilai_service 
											WHEN v_tagihan_air.denda_jenis_service = 2 
												THEN 
													v_tagihan_air.denda_nilai_service * 
													( DateDiff
														( MONTH, DATEADD(month,service.denda_selisih_bulan,v_tagihan_air.periode), '$periode_now' ) 
														+ IIF(".date("d").">=service.denda_tanggal_jt,1,0) 
													)
											WHEN v_tagihan_air.denda_jenis_service = 3 
												THEN 
													( v_tagihan_air.denda_nilai_service* v_tagihan_air.total/ 100 ) 
													* (DateDiff( MONTH, v_tagihan_air.periode, '$periode_now' ) 
													+ IIF(".date("d").">=service.denda_tanggal_jt,1,0) )
										END 
									END,0) AS nilai_denda,
								isnull(CASE 
									WHEN v_tagihan_air.periode = '$periode_now' THEN v_tagihan_air.total
									ELSE 0
								END,0) +
								isnull(CASE 
									WHEN v_tagihan_air.periode < '$periode_now' THEN v_tagihan_air.total
									ELSE 0
								END,0) +
								isnull(CASE
									WHEN v_tagihan_air.nilai_denda_flag = 1 THEN v_tagihan_air.nilai_denda 
									WHEN v_tagihan_air.periode > '$periode_now' THEN 0
									ELSE
									CASE
										WHEN v_tagihan_air.denda_jenis_service = 1 
										THEN 
											v_tagihan_air.denda_nilai_service 
										WHEN v_tagihan_air.denda_jenis_service = 2 
										THEN 
											v_tagihan_air.denda_nilai_service
												* (DateDiff( MONTH, v_tagihan_air.periode, '$periode_now' ) 
												+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
										WHEN v_tagihan_air.denda_jenis_service = 3 
										THEN 
											( v_tagihan_air.denda_nilai_service* v_tagihan_air.total/ 100 ) 
											* (DateDiff( MONTH, v_tagihan_air.periode, '$periode_now' ) 
											+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
									END 
								END,0) AS total,
								isnull(CONVERT(int,v_pemutihan.nilai_tagihan_type),-1) as pemutihan_nilai_tagihan_type,
								case 
									WHEN isnull(v_pemutihan.nilai_tagihan,-1)>0 THEN isnull(v_pemutihan.nilai_tagihan,-1)
									else 0 
								END as pemutihan_nilai_tagihan,
								isnull(CONVERT(int,v_pemutihan.nilai_denda_type),-1) as pemutihan_nilai_denda_type,
								case 
									WHEN isnull(v_pemutihan.nilai_denda,-1)>0 THEN isnull(v_pemutihan.nilai_denda,-1)
									ELSE 0 
								END  as pemutihan_nilai_denda")
			->from("v_tagihan_air")
			->join(
				"service",
				"service.service_jenis_id = 2
									AND service.project_id = $project->id"
			)
			->join(
				"v_pemutihan",
				"v_pemutihan.masa_akhir >= GETDATE()
									AND v_pemutihan.masa_awal <= GETDATE()
									AND v_pemutihan.periode_akhir >= v_tagihan_air.periode 
									AND v_pemutihan.periode_awal <= v_tagihan_air.periode 
									AND v_pemutihan.service_jenis_id = 1
									AND v_pemutihan.unit_id  = v_tagihan_air.unit_id
									AND v_pemutihan.project_id = service.project_id",
				"LEFT"
			)
			// ->where("v_tagihan_air.periode <= '$periode_now'")
			->where("v_tagihan_air.status_tagihan = 0")
			->where("v_tagihan_air.unit_id = $unit_id")
			->order_by("periode")

			->get()->result();
		// echo($periode_now);
		$tagihan_air_tmp = $tagihan_air;
		$tagihan_air = [];
		$view_pemutihan_nilai_tagihan = 0;
		$view_pemutihan_nilai_denda = 0;
		$sisa_nilai_tagihan = 0;
		$sisa_nilai_denda = 0;
		foreach ($tagihan_air_tmp as $k => $v) {
			if ($v->periode != $tagihan_air_tmp[(count($tagihan_air_tmp) - 1) < ($k + 1) ? (count($tagihan_air_tmp) - 1) : ($k + 1)]->periode || $k == count($tagihan_air_tmp) - 1) {
				// if($v->pemutihan_nilai_tagihan_type = 0){
				// 	$v->view_pemutihan_nilai_tagihan += $v->pemutihan_nilai_tagihan;
				// 	$v->sisa_nilai_tagihan = $v->pemutihan_nilai_tagihan - $v->view_pemutihan_nilai_tagihan;
				// }else{

				// }
				// if($v->pemutihan_nilai_denda_type = 0){

				// }		
				if ($v->pemutihan_nilai_tagihan_type == 0) {
					$view_pemutihan_nilai_tagihan += ((int) $v->pemutihan_nilai_tagihan);
					$sisa_nilai_tagihan += ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				}elseif ($v->pemutihan_nilai_tagihan_type == 1) {
					$view_pemutihan_nilai_tagihan += (((int) $v->pemutihan_nilai_tagihan) * ((int) $sisa_nilai_tagihan) / 100);
					$sisa_nilai_tagihan += ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				}else{
					$view_pemutihan_nilai_tagihan += 0;;
					$sisa_nilai_tagihan +=0;
				}
				if ($v->pemutihan_nilai_denda_type == 0) {
					$view_pemutihan_nilai_denda += ((int) $v->pemutihan_nilai_denda);
					$sisa_nilai_denda += ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				}elseif ($v->pemutihan_nilai_denda_type == 1) {
					$view_pemutihan_nilai_denda += (((int) $v->pemutihan_nilai_denda) * ((int) $sisa_nilai_denda) / 100);
					$sisa_nilai_denda += ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				}else{
					$view_pemutihan_nilai_denda += 0;
					$sisa_nilai_denda += 0;
				}
				$sisa_nilai_tagihan = $sisa_nilai_tagihan > 0 ? $sisa_nilai_tagihan : 0;
				$sisa_nilai_denda = $sisa_nilai_denda > 0 ? $sisa_nilai_denda : 0;

				$v->view_pemutihan_nilai_tagihan	= $view_pemutihan_nilai_tagihan > $v->total_tanpa_ppn ? $v->total_tanpa_ppn : $view_pemutihan_nilai_tagihan;
				$v->view_pemutihan_nilai_denda  	= $view_pemutihan_nilai_denda > $v->nilai_denda ? $v->nilai_denda : $view_pemutihan_nilai_denda;
				$v->sisa_nilai_tagihan 				= $sisa_nilai_tagihan;
				$v->sisa_nilai_denda 				= $sisa_nilai_denda;

				array_push($tagihan_air, $v);
			} else {
				$view_pemutihan_nilai_tagihan = 0;
				$view_pemutihan_nilai_denda = 0;
				$sisa_nilai_tagihan = 0;
				$sisa_nilai_denda = 0;
				if ($v->pemutihan_nilai_tagihan_type == 0) {
					$view_pemutihan_nilai_tagihan = ((int) $v->pemutihan_nilai_tagihan);
					$sisa_nilai_tagihan = ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				} else {
					$view_pemutihan_nilai_tagihan = (((int) $v->pemutihan_nilai_tagihan) * ((int) $v->total_tanpa_ppn) / 100);
					$sisa_nilai_tagihan = ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				}
				if ($v->pemutihan_nilai_denda_type == 0) {
					$view_pemutihan_nilai_denda = ((int) $v->pemutihan_nilai_denda);
					$sisa_nilai_denda = ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				} else {
					$view_pemutihan_nilai_denda = (((int) $v->pemutihan_nilai_denda) * ((int) $v->nilai_denda) / 100);
					$sisa_nilai_denda = ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				}
				$sisa_nilai_tagihan = $sisa_nilai_tagihan > 0 ? $sisa_nilai_tagihan : 0;
				$sisa_nilai_denda = $sisa_nilai_denda > 0 ? $sisa_nilai_denda : 0;

				// echo($view_pemutihan_nilai_tagihan."<br>");
			}
		}
		$tagihan_lingkungan = $this->db->select("
								'lingkungan' as service,
								v_tagihan_lingkungan.total_tanpa_ppn,
								v_tagihan_lingkungan.ppn,
								v_tagihan_lingkungan.periode,
								DATEADD(
									MONTH, 
									(
										(-1)*(CONVERT(INT,service.jarak_periode_penggunaan))
									),
									v_tagihan_lingkungan.periode
								) as periode_pemakaian,
								v_tagihan_lingkungan.tagihan_id,
								1 as service_jenis_id,
								0 as nilai_penalti,
								isnull(CASE 
									WHEN v_tagihan_lingkungan.periode >= '$periode_now' THEN v_tagihan_lingkungan.total
									ELSE 0
								END,0) as nilai_tagihan,
								isnull(CASE 
									WHEN v_tagihan_lingkungan.periode < '$periode_now' THEN v_tagihan_lingkungan.total
									ELSE 0
								END,0) as nilai_tunggakan,
								isnull(CASE
									WHEN v_tagihan_lingkungan.periode <= unit_lingkungan.tgl_mulai_denda THEN
										CASE
											WHEN v_tagihan_lingkungan.denda_jenis_service = 1 
												THEN
													v_tagihan_lingkungan.denda_nilai_service 
											WHEN v_tagihan_lingkungan.denda_jenis_service = 2 
												THEN
													v_tagihan_lingkungan.denda_nilai_service * 
													( 
														DateDiff( MONTH, unit_lingkungan.tgl_mulai_denda, '$periode_now' ) 
														+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) 
													)
											WHEN v_tagihan_lingkungan.denda_jenis_service = 3 
												THEN
													( v_tagihan_lingkungan.denda_nilai_service* v_tagihan_lingkungan.total/ 100 ) 
													* (DateDiff( MONTH, unit_lingkungan.tgl_mulai_denda, '$periode_now' ) 
													+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
										END 	
									WHEN v_tagihan_lingkungan.nilai_denda_flag = 1 THEN v_tagihan_lingkungan.nilai_denda 
									WHEN v_tagihan_lingkungan.periode > '$periode_now' THEN 0
									ELSE
										CASE
											WHEN v_tagihan_lingkungan.denda_jenis_service = 1 
											THEN 
												v_tagihan_lingkungan.denda_nilai_service 
											WHEN v_tagihan_lingkungan.denda_jenis_service = 2 
											THEN 
												v_tagihan_lingkungan.denda_nilai_service * 
												( 
													DateDiff( MONTH, DATEADD(MONTH, service.denda_selisih_bulan, v_tagihan_lingkungan.periode), '$periode_now' ) 
													+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) 
												)
											WHEN v_tagihan_lingkungan.denda_jenis_service = 3 
											THEN 
												( v_tagihan_lingkungan.denda_nilai_service * v_tagihan_lingkungan.total/ 100 ) 
												* (DateDiff( MONTH, DATEADD(MONTH, service.denda_selisih_bulan, v_tagihan_lingkungan.periode), '$periode_now' ) 
												+ IIF(" . date("d") . ">=service.denda_tanggal_jt,1,0) )
										END 
									END,0) AS nilai_denda,
								isnull(CONVERT(int,v_pemutihan.nilai_tagihan_type),-1) as pemutihan_nilai_tagihan_type,
								isnull(v_pemutihan.nilai_tagihan,-1) as pemutihan_nilai_tagihan,
								isnull(CONVERT(int,v_pemutihan.nilai_denda_type),-1) as pemutihan_nilai_denda_type,
								isnull(v_pemutihan.nilai_denda,-1) as pemutihan_nilai_denda
							")
			->from("v_tagihan_lingkungan")
			->join(
				"service",
				"service.service_jenis_id = 1
									AND service.project_id = $project->id"
			)
			->join(
				"unit_lingkungan",
				"unit_lingkungan.unit_id = $unit_id"
			)
			->join(
				"v_pemutihan",
				"v_pemutihan.masa_akhir >= GETDATE()
									AND v_pemutihan.masa_awal <= GETDATE()
									AND v_pemutihan.periode_akhir >= v_tagihan_lingkungan.periode 
									AND v_pemutihan.periode_awal <= v_tagihan_lingkungan.periode 
									AND v_pemutihan.service_jenis_id = 1
									AND v_pemutihan.unit_id  = v_tagihan_lingkungan.unit_id",
				"LEFT"
			)
			// ->where("v_tagihan_lingkungan.periode <= '$periode_now'")
			->where("v_tagihan_lingkungan.status_tagihan = 0")
			->where("v_tagihan_lingkungan.unit_id = $unit_id")
			->order_by("periode")
			->get()->result();
		$tagihan_lingkungan_tmp = $tagihan_lingkungan;
		$tagihan_lingkungan = [];
		$view_pemutihan_nilai_tagihan = 0;
		$view_pemutihan_nilai_denda = 0;
		$sisa_nilai_tagihan = 0;
		$sisa_nilai_denda = 0;
		foreach ($tagihan_lingkungan_tmp as $k => $v) {
			if ($v->periode != $tagihan_lingkungan_tmp[(count($tagihan_lingkungan_tmp) - 1) < ($k + 1) ? (count($tagihan_lingkungan_tmp) - 1) : ($k + 1)]->periode || $k == count($tagihan_lingkungan_tmp) - 1) {
				if ($v->pemutihan_nilai_tagihan_type == 0) {
					$view_pemutihan_nilai_tagihan += ((int) $v->pemutihan_nilai_tagihan);
					$sisa_nilai_tagihan += ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				} else if ($v->pemutihan_nilai_tagihan_type == 1) {
					$view_pemutihan_nilai_tagihan += (((int) $v->pemutihan_nilai_tagihan) * ((int) $sisa_nilai_tagihan) / 100);
					$sisa_nilai_tagihan += ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				}
				if ($v->pemutihan_nilai_denda_type == 0) {
					$view_pemutihan_nilai_denda += ((int) $v->pemutihan_nilai_denda);
					$sisa_nilai_denda += ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				} elseif ($v->pemutihan_nilai_denda_type == 1) {
					$view_pemutihan_nilai_denda += (((int) $v->pemutihan_nilai_denda) * ((int) $sisa_nilai_denda) / 100);
					$sisa_nilai_denda += ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				}
				$sisa_nilai_tagihan = $sisa_nilai_tagihan > 0 ? $sisa_nilai_tagihan : 0;
				$sisa_nilai_denda = $sisa_nilai_denda > 0 ? $sisa_nilai_denda : 0;

				$v->view_pemutihan_nilai_tagihan	= $view_pemutihan_nilai_tagihan > $v->total_tanpa_ppn ? $v->total_tanpa_ppn : $view_pemutihan_nilai_tagihan;
				$v->view_pemutihan_nilai_denda  	= $view_pemutihan_nilai_denda > $v->nilai_denda ? $v->nilai_denda : $view_pemutihan_nilai_denda;
				$v->sisa_nilai_tagihan 				= $sisa_nilai_tagihan;
				$v->sisa_nilai_denda 				= $sisa_nilai_denda;

				array_push($tagihan_lingkungan, $v);
			} else {
				$view_pemutihan_nilai_tagihan = 0;
				$view_pemutihan_nilai_denda = 0;
				$sisa_nilai_tagihan = 0;
				$sisa_nilai_denda = 0;
				if ($v->pemutihan_nilai_tagihan_type == 0) {
					$view_pemutihan_nilai_tagihan = ((int) $v->pemutihan_nilai_tagihan);
					$sisa_nilai_tagihan = ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				} else if ($v->pemutihan_nilai_tagihan_type == 1) {
					$view_pemutihan_nilai_tagihan = (((int) $v->pemutihan_nilai_tagihan) * ((int) $v->total_tanpa_ppn) / 100);
					$sisa_nilai_tagihan = ((int) $v->total_tanpa_ppn) - $view_pemutihan_nilai_tagihan;
				}
				if ($v->pemutihan_nilai_denda_type == 0) {
					$view_pemutihan_nilai_denda = ((int) $v->pemutihan_nilai_denda);
					$sisa_nilai_denda = ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				} elseif ($v->pemutihan_nilai_denda_type == 1) {
					$view_pemutihan_nilai_denda = (((int) $v->pemutihan_nilai_denda) * ((int) $v->nilai_denda) / 100);
					$sisa_nilai_denda = ((int) $v->nilai_denda) - $view_pemutihan_nilai_denda;
				}

				$sisa_nilai_tagihan = $sisa_nilai_tagihan > 0 ? $sisa_nilai_tagihan : 0;
				$sisa_nilai_denda = $sisa_nilai_denda > 0 ? $sisa_nilai_denda : 0;

				// echo($view_pemutihan_nilai_tagihan."<br>");
			}
		}
		$view_pemutihan_nilai_denda = $view_pemutihan_nilai_denda<0?0:$view_pemutihan_nilai_denda;

		$kwitansi_per_service = $this->db
			->select("
										t_pembayaran.id as pembayaran_id,
										t_pembayaran.tgl_bayar,
										service_jenis.id as  service_jenis_id,
										service_jenis.code_default as code_service,
										service_jenis.name_default as name_service,
										sum(isnull(t_pembayaran_detail.bayar,t_pembayaran_detail.bayar_deposit)) as bayar,
										isnull(kwitansi_referensi.no_kwitansi,0) as no_kwitansi")
			->from("t_pembayaran")
			->join(
				"t_pembayaran_detail",
				"t_pembayaran_detail.t_pembayaran_id = t_pembayaran.id"
			)
			->join(
				"service",
				"service.id = t_pembayaran_detail.service_id"
			)
			->join(
				"service_jenis",
				"service_jenis.id = service.service_jenis_id"
			)
			// ->where("no_kwitansi is null")
			->join(
				"kwitansi_referensi",
				"kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id"
			)
			->where("unit_id", $unit_id)
			->group_by("t_pembayaran.id,
												service_jenis.id,
												t_pembayaran.tgl_bayar ,
												service_jenis.code_default, 
												service_jenis.name_default,
												isnull(kwitansi_referensi.no_kwitansi,0),
												isnull(kwitansi_referensi.no_referensi,0)
												")
			->get()->result();
		$kwitansi_deposit = $this->db
			->select("
										t_deposit.id as deposit_id,
										t_deposit_detail.tgl_document as tgl_bayar,
										'Deposit' as name_service,
										t_deposit_detail.nilai as bayar,
										isnull(kwitansi_referensi.no_kwitansi,0) as no_kwitansi")
			->from("t_deposit")
			->join(
				"t_deposit_detail",
				"t_deposit_detail.t_deposit_id = t_deposit.id
											AND t_deposit_detail.nilai > 0"
			)
			->join(
				"kwitansi_referensi",
				"kwitansi_referensi.id = t_deposit_detail.kwitansi_referensi_id"
			)
			->where("t_deposit.customer_id", $unit->pemilik_id)
			->get()->result();

		$jumlah_tagihan_service = 0;
		$jumlah_tunggakan_bulan = 0;
		$jumlah_tunggakan = 0;
		$jumlah_ppn = 0;
		$jumlah_denda = 0;
		$jumlah_penalti = 0;
		$jumlah_tagihan = 0;
		$jumlah_pemutihan_tagihan = 0;
		$jumlah_pemutihan_denda = 0;

		foreach ($tagihan_air as $v) {
			$jumlah_denda += $v->nilai_denda;
			$jumlah_ppn += $v->ppn;
			$jumlah_tagihan += $v->total_tanpa_ppn;
			$jumlah_pemutihan_tagihan += $v->view_pemutihan_nilai_tagihan;
			$jumlah_pemutihan_denda += $v->view_pemutihan_nilai_denda;
	
			if ($v->nilai_denda > 0) {
				$jumlah_tunggakan_bulan++;
				$jumlah_tunggakan += $v->nilai_tunggakan;
			}
		}

		foreach ($tagihan_lingkungan as $k => $v) {
			$jumlah_denda += $v->nilai_denda;
			$jumlah_ppn += $v->ppn;
			$jumlah_tagihan += $v->total_tanpa_ppn;
			$jumlah_pemutihan_tagihan += $v->view_pemutihan_nilai_tagihan;
			$jumlah_pemutihan_denda += $v->view_pemutihan_nilai_denda;

			if ($v->nilai_denda > 0) {
				$jumlah_tunggakan_bulan++;
				$jumlah_tunggakan += $v->nilai_tunggakan;
			}
		}
		if ($tagihan_air)
			$jumlah_tagihan_service++;
		if ($tagihan_lingkungan)
			$jumlah_tagihan_service++;

		$unit->jumlah_tagihan_service = $jumlah_tagihan_service;
		$unit->tagihan_air = $tagihan_air;
		$unit->tagihan_lingkungan = $tagihan_lingkungan;


		$unit->jumlah_tagihan_service 	= $jumlah_tagihan_service;
		$unit->jumlah_tunggakan_bulan 	= $jumlah_tunggakan_bulan;
		$unit->jumlah_tunggakan 		= $jumlah_tunggakan;

		$unit->jumlah_ppn 				= $jumlah_ppn;
		$unit->jumlah_denda 			= $jumlah_denda ? $jumlah_denda : 0;
		$unit->jumlah_penalti 			= $jumlah_penalti;
		$unit->jumlah_tagihan 			= $jumlah_tagihan;
		$unit->jumlah_semua 			= $jumlah_denda + $jumlah_penalti + $jumlah_tagihan + $jumlah_ppn - ($jumlah_pemutihan_tagihan+$jumlah_pemutihan_denda);
		$unit->kwitansi 				= $kwitansi_per_service;
		$unit->kwitansi_deposit 		= $kwitansi_deposit;
		$unit->jumlah_pemutihan_tagihan	= $jumlah_pemutihan_tagihan<0?0:$jumlah_pemutihan_tagihan;
		
		$unit->jumlah_pemutihan_denda	= $jumlah_pemutihan_denda<0?0:$jumlah_pemutihan_denda;
		$unit->pemilik					= $pemilik;
		$unit->penghuni					= $penghuni;
		
		echo json_encode($unit);
		// echo json_encode($tagihan_air);
		// echo("<pre>");
		// print_r($unit);
		// echo("</pre>");

	}
	public function test()
	{
		$this->m_unit->test();
	}
}
