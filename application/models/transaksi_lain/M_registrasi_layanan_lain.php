<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_registrasi_layanan_lain extends CI_Model
{
    public function get()
    {
        $query = $this->db->query('
            SELECT * FROM cara_pembayaran
        ');

        return $query->result_array();
    }

    public function getAll()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT
             t_layanan_lain_registrasi.id as registrasi_id,
              unit.id as unit_id,
              unit.no_unit,
              t_layanan_lain_registrasi.nomor_registrasi,
             pemilik.name
               FROM t_layanan_lain_registrasi
           JOIN unit
        ON unit.id = t_layanan_lain_registrasi.unit_id
           JOIN customer as pemilik
        ON pemilik.id = unit.pemilik_customer_id
          WHERE t_layanan_lain_registrasi.active = 1
          AND t_layanan_lain_registrasi.[delete] = 0
        ");

        return $query->result_array();
    }

    public function getDetailServiceCetak($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $result = $this->db
            ->select("
                        CASE
                            WHEN biaya_pemasangan is null  or  biaya_pemasangan =0 THEN '0'
                            ELSE '1'
                        END as biaya_pemasangan_flag,
                        biaya_pemasangan,
                        t_layanan_lain_registrasi.unit_id,
                        t_layanan_lain_registrasi_detail.biaya_satuan as harga_satuan,
                        t_tagihan_layanan_lain_detail.biaya_registrasi,
                        service.name as service_name,
                        t_layanan_lain_registrasi_detail.*")
            ->from("t_layanan_lain_registrasi")
            ->join(
                " t_layanan_lain_registrasi_detail",
                "t_layanan_lain_registrasi_detail.layanan_lain_registrasi_id = t_layanan_lain_registrasi.id"
            )
            ->join(
                " service",
                "service.id = t_layanan_lain_registrasi_detail.service_id"
            )
            ->join(
                " t_tagihan_layanan_lain",
                "t_tagihan_layanan_lain.layanan_lain_registrasi_detail_id = t_layanan_lain_registrasi_detail.id"
            )
            ->join(
                " t_tagihan_layanan_lain_detail",
                "t_tagihan_layanan_lain_detail.layanan_lain_tagihan_id = t_tagihan_layanan_lain.id"
            )
            ->where("t_layanan_lain_registrasi.id", $id)
            ->order_by('t_layanan_lain_registrasi_detail.id', 'ASC')
            ->distinct()
            ->get()->row();
        // echo("<pre>");
        //     print_r($result);
        // echo("</pre>");

        return $result;
    }

    public function getDetailService($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT
             t_layanan_lain_registrasi_detail.id AS id,
			t_layanan_lain_registrasi.id AS id_registrasi,
             service.id AS service_id,
             paket_service.id AS paket_service_id,
             t_layanan_lain_registrasi_detail.periode_awal,
             t_layanan_lain_registrasi_detail.periode_akhir,
             t_layanan_lain_registrasi_detail.kuantitas,
             t_layanan_lain_registrasi_detail.status_berlangganan,
             paket_service.satuan AS satuan,
             paket_service.biaya_satuan_registrasi as harga_satuan,
             paket_service.biaya_registrasi as biaya_registrasi,
             paket_service.biaya_satuan_tanpa_registrasi as biaya_satuan_tanpa_registrasi,
             paket_service.biaya_pemasangan as biaya_pemasangan,
             paket_service.minimal_langganan as minimal_langganan,
             t_layanan_lain_registrasi_detail.active,
             t_layanan_lain_registrasi.unit_id as unit_id
             
        FROM
        t_layanan_lain_registrasi_detail
        JOIN service 
            ON service.id = t_layanan_lain_registrasi_detail.service_id
        JOIN paket_service 
            ON paket_service.id = t_layanan_lain_registrasi_detail.paket_service_id
					JOIN t_layanan_lain_registrasi
					ON t_layanan_lain_registrasi.id = t_layanan_lain_registrasi_detail.layanan_lain_registrasi_id
        WHERE t_layanan_lain_registrasi_detail.active = 1          
        ");
        $result = $this->db
            ->select("
                        CASE
                            WHEN biaya_pemasangan is null  or  biaya_pemasangan =0 THEN '0'
                            ELSE '1'
                        END as biaya_pemasangan_flag,
                        biaya_pemasangan,
                        t_layanan_lain_registrasi.unit_id,
                        t_layanan_lain_registrasi_detail.biaya_satuan as harga_satuan,
                        t_tagihan_layanan_lain_detail.biaya_registrasi,
                        t_layanan_lain_registrasi_detail.*")
            ->from("t_layanan_lain_registrasi")
            ->join(
                " t_layanan_lain_registrasi_detail",
                "t_layanan_lain_registrasi_detail.layanan_lain_registrasi_id = t_layanan_lain_registrasi.id"
            )
            ->join(
                " t_tagihan_layanan_lain",
                "t_tagihan_layanan_lain.layanan_lain_registrasi_detail_id = t_layanan_lain_registrasi_detail.id"
            )
            ->join(
                " t_tagihan_layanan_lain_detail",
                "t_tagihan_layanan_lain_detail.layanan_lain_tagihan_id = t_tagihan_layanan_lain.id"
            )
            ->where("t_layanan_lain_registrasi.id", $id)
            ->order_by('t_layanan_lain_registrasi_detail.id', 'ASC')
            ->distinct()
            ->get()->result();
        // echo("<pre>");
        //     print_r($result);
        // echo("</pre>");

        return $result;
    }
    public function get_service_non_retribusi()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT
                id,
                name
            FROM service
            WHERE service_jenis_id = 6   
            and project_id = $project->id
        ");

        return $query->result();
    }

    public function get_paket_service_non_retribusi()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT
             id,
             name
         FROM paket_service  
         where project_id = $project->id
        ");
        return $query->result();
    }

    public function getUnit()
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT 
                case 
                    when t_layanan_lain_registrasi.id > 0 THEN '1'
                    else '0'
                END as telah_registrasi,
                project.name as project_name,
                kawasan.name as kawasan_name,
                blok.name as blok_name,
                unit.*
            FROM unit
            join blok 
                on unit.blok_id = blok.id
            join kawasan 
                on blok.kawasan_id = kawasan.id
            join project 
                on project.id = kawasan.project_id 
            join customer
                on customer.id = unit.pemilik_customer_id
            LEFT JOIN t_layanan_lain_registrasi
                on t_layanan_lain_registrasi.unit_id = unit.id
                AND t_layanan_lain_registrasi.[delete] = 0
	            AND t_layanan_lain_registrasi.[active] = 1
            where project.id = $project->id
                   
    
            ");

        return $query->result_array();
    }

    public function getUnitCetak()
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT 
                case 
                    when t_layanan_lain_registrasi.id > 0 THEN '1'
                    else '0'
                END as telah_registrasi,
                project.name as project_name,
                kawasan.name as kawasan_name,
                blok.name as blok_name,
                customer.name as customer_name,
                unit.*
            FROM unit
            join blok 
                on unit.blok_id = blok.id
            join kawasan 
                on blok.kawasan_id = kawasan.id
            join project 
                on project.id = kawasan.project_id 
            join customer
                on customer.id = unit.pemilik_customer_id
            LEFT JOIN t_layanan_lain_registrasi
                on t_layanan_lain_registrasi.unit_id = unit.id
                AND t_layanan_lain_registrasi.[delete] = 0
	            AND t_layanan_lain_registrasi.[active] = 1
            where project.id = $project->id
                   
    
            ");

        return $query->row();
    }
    public function get_paket($id)
    {
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT
                id,
                name
            FROM paket_service
            where service_id = $id
            and project_id = $project->id
        ");

        return $query->result();
    }
    public function get_harga_paket($id)
    {
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT
                harga
            FROM paket_service
            where service_id = $id
            and project_id = $project->id
        ");

        return $query->row();
    }
    public function get_pemilik_penghuni($id)
    {
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT
                pemilik.id as pemilik_kode,
                pemilik.name as pemilik_nama,
                pemilik.mobilephone1 as pemilik_mobile_phone,
                pemilik.homephone as pemilik_home_phone,
                pemilik.email as pemilik_email,
                pemilik.address as pemilik_alamat,
                penghuni.code as penghuni_kode,
                penghuni.name as penghuni_nama,
                penghuni.mobilephone1 as penghuni_mobile_phone,
                penghuni.homephone as penghuni_home_phone,
                penghuni.email as penghuni_email,
                penghuni.address as penghuni_alamat,
                unit.bangunan_type,
                unit.luas_tanah,
                unit.luas_bangunan,
                unit.luas_taman
            FROM unit
            JOIN customer as pemilik
                ON pemilik.id = unit.pemilik_customer_id
            LEFT JOIN customer as penghuni
                ON penghuni.id = unit.penghuni_customer_id
            JOIN blok
                ON blok.id = unit.blok_id
            JOIN kawasan
                ON kawasan.id = blok.kawasan_id
                AND kawasan.project_id = $project->id
            WHERE unit.id = $id
        ");
        return $query->row();
    }
    // public function getparameter(){
    //     $this->load->model('m_core');
    //     $project = $this->m_core->project();

    //     $statusBerlangganan = $this->db->select('value')
    //     -> where('project_id',$project->id)
    //     -> get('parameter_project')
    //     -> row();
    //     $statusBerlangganan = $statusBerlangganan?$statusBerlangganan->value:0;

    //     return $statusBerlangganan;
    // }
    public function get_parameter()
    {
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT id, 
               name,
               value,
               description,
               code
        FROM parameter_project  
        ");
        return $query->row();
    }
    public function hapus()
    {
        $query = $this->db->query("
        SELECT unit_id,
        nomor_registrasi, customer.name
        FROM t_layanan_lain_registrasi
        JOIN customer
        ON customer.id = t_layanan_lain_registrasi.id
        ");
    }
    public function last_id()
    {
        $query = $this->db->query("
            SELECT TOP 1
               id
            FROM t_layanan_lain_registrasi
            order by id desc
        ");
        return $query->row() ? $query->row()->id : 0;
    }

    public function last_id_tagihan()
    {
        $query = $this->db->query("
            SELECT TOP 1
               id
            FROM t_tagihan_layanan_lain
            order by id desc
        ");
        return $query->row() ? $query->row()->id : 0;
    }

    public function get_paket_service($id)
    {
        $query = $this->db->query("
            SELECT
               id,name
            FROM paket_service
            WHERE service_id = $id
            AND active = 1
            AND [delete] = 0
            order by name
        ");
        return $query->result();
    }

    public function get_paket_service_cetak($id)
    {
        $query = $this->db->query("
            SELECT
               id,name
            FROM paket_service
            WHERE service_id = $id
            AND active = 1
            AND [delete] = 0
            order by name
        ");
        return $query->row();
    }
    public function get_info_paket_service($id)
    {
        $query = $this->db->query("
            SELECT
                satuan,
                biaya_satuan_registrasi as harga,
                biaya_registrasi,
                biaya_satuan_tanpa_registrasi,
                minimal_langganan
                FROM paket_service
            WHERE id = $id
        ");
        return $query->row();
    }

    public function get_info_paketservice($id)
    {
        $query = $this->db->query("
            SELECT
                satuan,
                biaya_satuan_registrasi as harga,
                biaya_registrasi,
                biaya_satuan_tanpa_registrasi,
                biaya_pemasangan
                FROM paket_service
            WHERE id = $id
        ");
        return $query->row();
    }

    // public function last_id_tagihan()
    // {
    //     $query = $this->db->query("
    //         SELECT TOP 1 id FROM t_tagihan_layanan_lain
    //         ORDER by id desc
    //     ");
    //     return $query->row() ? $query->row()->id : 0;
    // }


    public function save($dataTmp)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        
        $check_double = $this->db   ->select('count(*) as data_double')
                                    ->from('t_layanan_lain_registrasi')
                                    ->where("nomor_registrasi = '$dataTmp[nomor_registrasi]'")
                                    ->get()->row();
        if ($dataTmp['no_unit'] != 'non_unit' && $check_double->data_double == 0 ) {
            $cek = $this->db->select("count(*) as count")
                        ->from("t_tagihan")
                        ->where("unit_id",$dataTmp['no_unit'])
                        ->where("proyek_id",$project->id)
                        ->where("periode",date("Y-m-01"))
                        ->get()->row()->count;
            if($cek > 0){
                $t_tagihan_id = $this->db->select("id")
                                ->from("t_tagihan")
                                ->where("unit_id",$dataTmp['no_unit'])
                                ->where("proyek_id",$project->id)
                                ->where("periode",date("Y-m-01"))
                                ->get()->row()->id;
            }else{
                $data_t_tagihan = [
                    'proyek_id' => $project->id,
                    'unit_id' => $dataTmp['no_unit'],
                    'periode' => date("Y-m-01")
                ];
                $this->db->insert('t_tagihan', $data_t_tagihan);
                $t_tagihan_id = $this->db->insert_id();
            }
            $dataUnit =
                [
                    'unit_id' => $dataTmp['no_unit'],

                    'project_id' => $project->id,

                    'nomor_registrasi' => $dataTmp['nomor_registrasi'],
                    // 'status_bayar_registrasi' => 0,
                    'active' => 1,
                    'delete' => 0,
                    'log' => 0, //belum dipake juga, belum dibayar jadi nanti bisa di edit karena status nya 0
                ];
            $this->db->insert('t_layanan_lain_registrasi', $dataUnit);
            $last_row = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('t_layanan_lain_registrasi')->row();

            for ($i = 0; $i < count($dataTmp['service_id']); $i++) {
                for ($j = 0; $j < $dataTmp['jumlah_periode'][$i]; $j++) {
                    $service_id =  $dataTmp['service_id'][$i];
                    $paket_service_id = $dataTmp['paket_service_id'][$i];

                    $query = $this->db->query("
                                    SELECT service.name as service_name,
                                            paket_service.name as paket_service_name
                                        FROM service
                                        JOIN paket_service 
                                        ON paket_service.service_id = service.id 
                                    WHERE
                                        service.id = $service_id
                                    AND
                                        paket_service.id = $paket_service_id
                                    ");
                    $paketService = $this->db->select('biaya_satuan_tanpa_registrasi,biaya_satuan_registrasi,minimal_langganan')->where('id', $paket_service_id)->limit(1)->get('paket_service')->row();
                }
                if ($dataTmp['jumlah_periode'][$i] < $paketService->minimal_langganan) {
                    $data_detail_service =
                        [
                            // 'project_id' => $project->id,
                            'service_id' => $dataTmp['service_id'][$i],
                            'paket_service_id' => $dataTmp['paket_service_id'][$i],
                            'layanan_lain_registrasi_id' => $last_row->id,
                            'periode_awal' => date("d-m-Y", (strtotime("01/" . $dataTmp['periode_awal'][$i]))),
                            'periode_akhir' => date("d-m-Y", (strtotime("01/" . $dataTmp['periode_akhir'][$i]))),
                            'kuantitas' => $dataTmp['kuantitas'][$i],
                            'satuan' => $dataTmp['satuan'][$i],
                            // 'harga_satuan' => $dataTmp['harga_satuan'][$i],
                            'biaya_satuan' => $paketService->biaya_satuan_tanpa_registrasi,
                            'status_berlangganan' => $dataTmp['status_berlangganan'][$i] == 'Non Berlangganan' ? 0 : 1,
                            'minimal_langganan' => $paketService->minimal_langganan,
                            // 'biaya_registrasi' => $dataTmp['biaya_registrasi'][$i],
                            // 'harga_bulan_pertama' => $dataTmp['harga_bulan_pertama'][$i],
                            // 'harga_bulanan' => $dataTmp['harga_bulanan'][$i],
                            'active' => 1,
                            'delete' => 0,
                        ];
                } else if ($dataTmp['jumlah_periode'][$i] >= $paketService->minimal_langganan) {

                    if ($j  == 0)   $biaya_satuan_registrasi = $dataTmp['biaya_registrasi'][$i] + $paketService->biaya_satuan_registrasi;
                    else            $biaya_satuan_registrasi = $paketService->biaya_satuan_registrasi;
                    $data_detail_service =
                        [
                            'biaya_satuan' =>  $biaya_satuan_registrasi,
                            'service_id' => $dataTmp['service_id'][$i],
                            'paket_service_id' => $dataTmp['paket_service_id'][$i],
                            'layanan_lain_registrasi_id' => $last_row->id,
                            'periode_awal' => date("d-m-Y", (strtotime("01/" . $dataTmp['periode_awal'][$i]))),
                            'periode_akhir' => date("d-m-Y", (strtotime("01/" . $dataTmp['periode_akhir'][$i]))),
                            'kuantitas' => $dataTmp['kuantitas'][$i],
                            'satuan' => $dataTmp['satuan'][$i],
                            'status_berlangganan' => $dataTmp['status_berlangganan'][$i] == 'Non Berlangganan' ? 0 : 1,
                            'minimal_langganan' => $paketService->minimal_langganan,
                            'active' => 1,
                            'delete' => 0,
                        ];
                }
                $this->db->insert('t_layanan_lain_registrasi_detail', $data_detail_service);

                // $periode_awal = "01/". $dataTmp['periode_awal'][$i];
                $last_row_layananlain_detail = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('t_layanan_lain_registrasi_detail')->row();

                for ($j = 0; $j < $dataTmp['jumlah_periode'][$i]; $j++) {
                    $kode_tagihan = "CG/TLL/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_layanan_lain->last_id_tagihan() + 1);


                    $data_tagihan =
                        [
                            'project_id' => $project->id,
                            'unit_id' => $dataTmp['no_unit'],
                            'layanan_lain_registrasi_detail_id' => $last_row_layananlain_detail->id,
                            'kode_tagihan' => $kode_tagihan,
                            // 'service_id' => $dataTmp['service_id'][$i],
                            // 'paket_service_id' => $dataTmp['paket_service_id'][$i],
                            'periode' => date("d-m-Y", strtotime("+" . $j . "day", strtotime("01/" . $dataTmp['periode_awal'][$i]))),
                            'kuantitas' => $dataTmp['kuantitas'][$i],
                            'status_bayar_flag' => 0,
                            'nilai' => $dataTmp['harga_satuan'][$i] * $dataTmp['kuantitas'][$i],
                            'ppn_flag' => 1
                        ];

                    $this->db->insert('t_tagihan_layanan_lain', $data_tagihan);

                    $last_row_tagihan = $this->db->select('id')->order_by('id', "desc")->limit(1)->get('t_tagihan_layanan_lain')->row();

                    if ($dataTmp['jumlah_periode'][$i] < $paketService->minimal_langganan) {
                        $data_tagihan_detail =
                            [
                                'layanan_lain_tagihan_id' => $last_row_tagihan->id,
                                'project_id' => $project->id,
                                'service_id' => $dataTmp['service_id'][$i],
                                'paket_service_id' => $dataTmp['paket_service_id'][$i],
                                'service_name' => $query->row()->service_name,
                                'paket_service_name' => $query->row()->paket_service_name,
                                'biaya_satuan' => $dataTmp['harga_satuan'][$i] * $dataTmp['kuantitas'][$i],
                                'biaya_registrasi' => $dataTmp['biaya_registrasi'][$i],
                                'biaya_pemasangan' => $dataTmp['biaya_pemasangan_aktif'] ? $dataTmp['biaya_pemasangan_aktif'][$i] : null
                            ];
                    } else if ($dataTmp['jumlah_periode'][$i] >= $paketService->minimal_langganan) {

                      
                        $data_tagihan_detail =
                            [
                                'layanan_lain_tagihan_id' => $last_row_tagihan->id,
                                'biaya_satuan' =>  $dataTmp['harga_satuan'][$i] * $dataTmp['kuantitas'][$i],
                                'project_id' => $project->id,
                                'service_id' => $dataTmp['service_id'][$i],
                                'paket_service_id' => $dataTmp['paket_service_id'][$i],
                                'service_name' => $query->row()->service_name,
                                'paket_service_name' => $query->row()->paket_service_name,
                                'biaya_registrasi' => $dataTmp['biaya_registrasi'][$i],
                                'biaya_pemasangan' => $dataTmp['biaya_pemasangan_aktif'] ? $dataTmp['biaya_pemasangan_aktif'][$i] : null

                            ];
                    }

                    $this->db->insert('t_tagihan_layanan_lain_detail', $data_tagihan_detail);
                }
            }
            return 'success';
        }
        return 'double';
    }


    public function edit($dataTmp)
    {
        $this->load->model('m_core');
        // $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $data =
            [
                'project_id'                => $project->id,
                'coa_mapping_id_service'    => $dataTmp['coa_mapping_id_service'],
                'ppn'                       => $dataTmp['ppn'],
                'coa_mapping_id_ppn'        => $dataTmp['coa_mapping_id_ppn'],
                'denda_parameter'           => $dataTmp['denda_parameter'],
                'denda_jenis'               => $dataTmp['denda_jenis'],
                'denda_minimum'             => $this->m_core->currency_to_number($dataTmp['denda_minimum']),
                'denda_persen'              => $dataTmp['denda_persen'],
                // 'denda_tgl_nonactive'    => $dataTmp['denda_tgl_putus'],
                'description'               => $dataTmp['description'],
                'active'                    => $dataTmp['active'],
                'delete'                    => 0
            ];



        $paket = explode('|', $dataTmp['jenis_paket_id']);

        $this->db->get_where('t_layanan_lain_registrasi', $dataUnit);
        // $id = $this->db->insert_id();
        // $this->db->insert_id('t_layanan_lain_registrasi', $dataUnit);
        return $this;
    }

    public function delete($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $this->db->where('project_id', $project->id);
        $this->db->delete('t_layanan_lain_registrasi');
        // $this->db->from('coa_mapping');
        return this;
        // validasi apakah user dengan project $project boleh edit data ini
        // if ($this->db->count_all_results() != 0) {
        //     validasi Cara Pembayaran
        //     $this->db->where('coa_mapping_id', $dataTmp['id']);
        //     $this->db->from('cara_pembayaran');
        //     if ($this->db->count_all_results() == 0) {
        //         validasi Metode Penagihan
        //         $this->db->where('coa_mapping_id', $dataTmp['id']);
        //         $this->db->from('metode_penagihan');
        //         if ($this->db->count_all_results() == 0) {
        //             $this->db->where('coa_mapping_id_service', $dataTmp['id'])->where('coa_mapping_id_ppn', $dataTmp['id']);
        //             $this->db->from('service');
        //             if ($this->db->count_all_results() == 0) {
        //                 $before = $this->mapping_get_log($dataTmp['id']);
        //                 $this->db->where('id', $dataTmp['id']);
        //                 $this->db->update('coa_mapping', ['delete' => 1]);
        //                 $after = $this->mapping_get_log($dataTmp['id']);

        //                 $diff = (object) (array_diff((array) $after, (array) $before));
        //                 $tmpDiff = (array) $diff;

        //                 if ($tmpDiff) {
        //                     $this->m_log->log_save('coa_mapping', $dataTmp['id'], 'Edit', $diff);

        //                     return 'success';
        //                 } else {
        //                     return 'Tidak Ada Perubahan';
        //                 }
        //             } else {
        //                 return 'service';
        //             }
        //         } else {
        //             return 'metode_penagihan';
        //         }
        //     } else {
        //         return 'cara_pembayaran';
        //     }
        // }
    }
}
