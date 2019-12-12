<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_registrasi_liaison_officer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('transaksi_lain/m_registrasi_liaison_officer');
        $this->load->model('m_core');
        $this->load->model('m_login');
        if (!$this->m_login->status_login()) {
            redirect(site_url());
        }
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
    }

    public function index()
    {
        $data = $this->m_registrasi_liaison_officer->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/view',['data'=>$data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }
    
    public function add()
    {
        // $dataJenisService = $this->m_registrasi_liaison_officer->getJenisService()
        $dataUnit = $this->m_registrasi_liaison_officer->getUnit();
        $dataKategori = $this->m_registrasi_liaison_officer->get_kategori();
        $dataJenis = $this->m_registrasi_liaison_officer->get_jenis();
        $kode_reg = "CG/REGISTRASILOI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_liaison_officer->last_id()+1);
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi', 'subTitle' => 'Add']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/add_new', ['dataUnit' => $dataUnit,'dataKategori'=>$dataKategori,'dataJenis'=>$dataJenis,'kode_reg'=>$kode_reg]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function save()
    {
        $validasi = $this->db   ->select("*")
                    ->from("t_loi_registrasi")
                    ->where("kategori_loi_id",$this->input->post("kategori_loi_id"))
                    ->where("jenis_loi_id",$this->input->post("jenis_loi_id"))
                    ->where("peruntukan_loi_id",$this->input->post("peruntukan_loi_id"))
                    ->where("unit_id",$this->input->post("pilih_unit"))
                    // ->where("expired_date >= ".$this->input->post("expired_date"))
                    ->where("expired_date >= '".date("Y-m-d")."'")
                    ->count_all_results();
        if($validasi == 0){
            $status = $this->m_registrasi_liaison_officer->save([
                'pilih_unit' => $this->input->post('pilih_unit'),
                'unit' => $this->input->post('unit_name'),
                'customer_id' => $this->input->post('customer_id'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_name2' => $this->input->post('customer_name2'),
                'nomor_telepon' => $this->input->post('nomor_telepon'),
                'nomor_handphone' => $this->input->post('nomor_handphone'),
                'email' => $this->input->post('email'),
                'nomor_telepon2' => $this->input->post('nomor_telepon2'),
                'nomor_handphone2' => $this->input->post('nomor_handphone2'),
                'email2' => $this->input->post('email2'),
                'tanggal_document' => $this->input->post('tanggal_document'),
                'tanggal_rencana_pemasangan' => $this->input->post('tanggal_rencana_pemasangan'),
                'tanggal_rencana_survei' => $this->input->post('tanggal_rencana_survei'),
                'tanggal_rencana_aktifasi' => $this->input->post('tanggal_rencana_aktifasi'),           
                'paket_loi_id' => $this->input->post('jenis_paket'),
                'luasbaru' => $this->input->post('luasbaru'),
                'luaslama' => $this->input->post('luaslama'),
                'harga_paket' => $this->input->post('harga_paket'),
                'diskon' => $this->input->post('diskon'),
                'total' => $this->input->post('total_bayar'),
                'keterangan' => $this->input->post('keterangan'),
                'nomor_registrasi' => $this->input->post('nomor_registrasi'),
                'nomor_registrasi2' => $this->input->post('nomor_registrasi2'),
                'status_dokumen' => 0,
                'kategori_loi_id' => $this->input->post('kategori_loi_id'),
                'jenis_loi_id' => $this->input->post('jenis_loi_id'),
                'peruntukan_loi_id' => $this->input->post('peruntukan_loi_id'),
                'expired_date' => $this->input->post('expired_date'),
                'deposit_masuk' => $this->input->post('deposit_masuk')
                // 'dokumen' => $data_image
            ]);

            $this->load->model('alert');
            $data = $this->m_registrasi_liaison_officer->getAll();
            $this->load->view('core/header');
            $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
            $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
            $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi', 'subTitle' => 'List']);
            $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/view',['data'=>$data]);
            $this->load->view('core/body_footer');
            $this->load->view('core/footer');
            if ($status == 'success') {
                $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Tambah', 'type' => 'success']);
            } elseif ($status == 'double') {
                $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
            }
        }else{
            redirect(site_url().'/transaksi_lain/p_registrasi_liaison_officer');
        }
    }

    public function edit()
    {
        $dataUnit = $this->m_registrasi_liaison_officer->getUnit();
        $dataKategori = $this->m_registrasi_liaison_officer->get_kategori();
        $dataRegistrasiLoiSelect = $this->m_registrasi_liaison_officer->getSelect($this->input->get('id'));
        $dataJenis = $this->m_registrasi_liaison_officer->get_jenis();
        $dataPeruntukan = $this->m_registrasi_liaison_officer->get_peruntukan();
        $dataPaket = $this->m_registrasi_liaison_officer->get_paket();
        $this->load->model('m_log');
        $data = $this->m_log->get('t_loi_registrasi', $this->input->get('id'));
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi ', 'subTitle' => 'Edit']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/edit', ['data'=>$data,'dataUnit' => $dataUnit,'dataKategori'=>$dataKategori,'dataJenis'=>$dataJenis,'dataSelect'=>$dataRegistrasiLoiSelect,'dataPeruntukan'=>$dataPeruntukan, 'dataPaket'=>$dataPaket]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function aksi_edit()
    {
        $status = 0;
        if ($this->input->post('nomor_registrasi')) {
            $this->load->model('alert');

            $status = $this->m_registrasi_liaison_officer->edit([
                'id' => $this->input->get('id'),
                'nomor_registrasi' => $this->input->post('nomor_registrasi'),
                'expired_date' => $this->input->post('expired_date')
            ]);
            $this->alert->css();
            
        }
        $data = $this->m_registrasi_liaison_officer->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/view',['data'=>$data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        // if ($this->m_registrasi_liaison_officer->cek($this->input->get('id'))) {
            
        // } else {
        //     redirect(site_url().'/P_master_cara_pembayaran');
        // }
        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Update', 'type' => 'success']);
        } elseif ($status == 'double') {
            $this->load->view('core/alert', ['title' => 'Gagal | Double', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
        }
    }

    public function pembayaran()
    {
        $dataUnit = $this->m_registrasi_liaison_officer->getUnit();
        $dataKategori = $this->m_registrasi_liaison_officer->get_kategori();
        $dataRegistrasiLoiSelect = $this->m_registrasi_liaison_officer->getSelect($this->input->get('id'));
        $dataJenis = $this->m_registrasi_liaison_officer->get_jenis();
        $dataPeruntukan = $this->m_registrasi_liaison_officer->get_peruntukan();
        $dataPaket = $this->m_registrasi_liaison_officer->get_paket();
        $this->load->model('m_log');
        $data = $this->m_log->get('t_loi_registrasi', $this->input->get('id'));
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Pembayaran ', 'subTitle' => 'Pembayaran']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/payment', ['data'=>$data,'dataUnit' => $dataUnit,'dataKategori'=>$dataKategori,'dataJenis'=>$dataJenis,'dataSelect'=>$dataRegistrasiLoiSelect,'dataPeruntukan'=>$dataPeruntukan, 'dataPaket'=>$dataPaket]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }
    
    public function aksi_pembayaran()
    {
        $status = 0;
        if ($this->input->post('nomor_registrasi')) {
            $this->load->model('alert');

            $status = $this->m_registrasi_liaison_officer->pembayaran([
                'id' => $this->input->get('id'),
                'nomor_registrasi' => $this->input->post('nomor_registrasi'),
                'total_bayar' => $this->input->post('total_bayar'),
                'status_bayar' => $this->input->post('status_bayar'),
            ]);
            $this->alert->css();
            
        }
        $data = $this->m_registrasi_liaison_officer->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Registrasi', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/view',['data'=>$data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        // if ($this->m_registrasi_liaison_officer->cek($this->input->get('id'))) {
            
        // } else {
        //     redirect(site_url().'/P_master_cara_pembayaran');
        // }

        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Simpan', 'type' => 'success']);
        } elseif ($status == 'double') {
            $this->load->view('core/alert', ['title' => 'Gagal | Double', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
        }
    }

    public function cetak()
    {
        $this->load->library('pdf');
        $this->pdf->set_option('defaultMediaType', 'all');
        $this->pdf->set_option('isFontSubsettingEnabled', true);
        $this->pdf->set_option('isHtml5ParserEnabled', true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "dokumentvi.pdf";
        $dataRegistrasiLOISelect = $this->m_registrasi_liaison_officer->getSelect($this->input->get('id'));
        $tanggal = (date("d")." ".$this->bln_indo(date("m"))." ".date("Y"));
        $terbilang = $this->terbilang(str_replace(",","",$dataRegistrasiLOISelect->total));
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liaison Officer > Edit', 'subTitle' => 'Edit']);
        $this->pdf->load_view('proyek/cetakan/dokumenLOI', ['data_select'=>$dataRegistrasiLOISelect,'tanggal'=>$tanggal,'terbilang'=>$terbilang]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function cetakform()
    {
        $this->load->library('pdf');
        $this->pdf->set_option('defaultMediaType', 'all');
        $this->pdf->set_option('isFontSubsettingEnabled', true);
        $this->pdf->set_option('isHtml5ParserEnabled', true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "dokumentvi.pdf";
        // $dataRegistrasiLOISelect = $this->m_registrasi_liaison_officer->getSelect($this->input->get('id'));
        $tanggal = (date("d")." ".$this->bln_indo(date("m"))." ".date("Y"));
        $terbilang = $this->terbilang(str_replace(",","",$dataRegistrasiLOISelect->total));
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liaison Officer > Edit', 'subTitle' => 'Edit']);
        $this->pdf->load_view('proyek/cetakan/emptyLOI', ['data_select'=>$dataRegistrasiLOISelect,'tanggal'=>$tanggal,'terbilang'=>$terbilang]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    

    public function delete()
    {
        $this->load->model('alert');

        $status = $this->m_cara_pembayaran->delete([
                'id' => $this->input->get('id'),
        ]);

        $this->alert->css();

        $data = $this->m_cara_pembayaran->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Cara Pembayaran', 'subTitle' => 'List']);
        $this->load->view('proyek/master/cara_pembayaran/view', ['data' => $data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Delete', 'type' => 'success']);
        } elseif ($status == 'cara_pembayaran') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data COA digunakan di Cara Pembayaran', 'type' => 'danger']);
        } elseif ($status == 'metode_penagihan') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data COA digunakan di Metode Penagihan', 'type' => 'danger']);
        } elseif ($status == 'service') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data COA digunakan di Service', 'type' => 'danger']);
        }
    }

    public function lihat_unit()
    {
        $this->load->model('transaksi_lain/m_registrasi_liaison_officer');
        $pilih_unit = $this->input->post('pilih_unit');
        echo json_encode($this->m_registrasi_liaison_officer->getUnit2($pilih_unit));
    }

    public function ajax_get_jenis()
    {
        $kategori = $this->input->post('kategori');
        echo json_encode($this->m_registrasi_liaison_officer->getJenis($kategori));
    }

    public function ajax_get_peruntukan(){
        $jenis = $this->input->post('jenis');
        echo json_encode($this->m_registrasi_liaison_officer->getPeruntukan($jenis));
    }

    public function ajax_get_paket()
    {
        $jenis = $this->input->post('jenis');
        echo json_encode($this->m_registrasi_liaison_officer->getPaket($jenis));
    }

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
    }
    
    function terbilang($nilai) {
		if($nilai<0)    $hasil = "minus ". trim($this->penyebut($nilai));
        else            $hasil = trim($this->penyebut($nilai));
		return $hasil." Rupiah";
    }
    
    function bln_indo($tmp){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        return $bulan[(int)$tmp];
    }

    public function upload()
    {
        $status = 0;
        $this->load->model('alert');
        $config['upload_path']          = './assets/dokumen/';
        $config['allowed_types']        = 'jpeg|gif|jpg|png|docx|pdf|xls';
        $config['remove_spaces']        =TRUE;
		$config['overwrite']            =TRUE;
        $config['max_size']             = 9999; // 1MB
        $config['max_width']            = 9999;
        $config['max_height']           = 9999;

        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload('dokumen');
        $data_image=$this->upload->data('file_name');
        
        $status = $this->m_registrasi_liaison_officer->upload([
            'id' => $this->input->get('id'),
            'dokumen' => $data_image
        ]);

        $this->alert->css();

        $data = $this->m_registrasi_liaison_officer->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_liaison_officer/view', ['data' => $data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Dokumen Berhasil di Upload', 'type' => 'success']);
        } 
    }

}
?>