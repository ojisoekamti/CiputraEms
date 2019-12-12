<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_st_liaison_officer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('transaksi_lain/m_st_liaison_officer');
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
        $data = $this->m_st_liaison_officer->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Serah Terima', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/st_liaison_officer/view',['data'=>$data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function add()
    {
        $dataUnit = $this->m_st_liaison_officer->getUnit();
        $dataKategori = $this->m_st_liaison_officer->get_kategori();
        $dataRegistrasiLoiSelect = $this->m_st_liaison_officer->getSelect($this->input->get('id'));
        $dataJenis = $this->m_st_liaison_officer->get_jenis();
        $dataPeruntukan = $this->m_st_liaison_officer->get_peruntukan();
        $dataPaket = $this->m_st_liaison_officer->get_paket();
        $dataItemCharge = $this->m_st_liaison_officer->get_item_charge($this->input->get('id'));
        $dataItemChargeTambah = $this->m_st_liaison_officer->get_item_charge_tambah($this->input->get('id'));
        $this->load->model('m_log');
        $data = $this->m_log->get('t_loi_registrasi', $this->input->get('id'));
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Serah Terima ', 'subTitle' => 'Add']);
        $this->load->view('proyek/transaksi_lain/st_liaison_officer/add', ['data'=>$data,'dataUnit' => $dataUnit,'dataKategori'=>$dataKategori,'dataJenis'=>$dataJenis,'dataSelect'=>$dataRegistrasiLoiSelect,'dataPeruntukan'=>$dataPeruntukan, 'dataPaket'=>$dataPaket, 'dataItemCharge'=>$dataItemCharge, 'dataItemChargeTambah'=>$dataItemChargeTambah]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }
    
    public function save()
    {
        $status = 0;
        if ($this->input->post('nomor_registrasi')) {
            $this->load->model('alert');
            $hasil_aktifasi = $this->input->post('hasil_aktifasi');
            $status = $this->m_st_liaison_officer->save([
                'id' => $this->input->get('id'),
                'id_item' => $this->input->post('id_item[]'),
                'nomor_registrasi' => $this->input->post('nomor_registrasi'),
                'tanggal_aktifasi' => $this->input->post('tanggal_aktifasi'),
                'hasil_aktifasi' => $this->input->post('hasil_aktifasi'),
                'deposit_pemakaian' => $this->input->post('deposit_pemakaian'),
                'sisa_deposit' => $this->input->post('sisa_deposit'),
                'harga_satuan' => $this->input->post('harga_satuan[]')
            ]);
            $this->alert->css();
        }
        if(!empty($hasil_aktifasi)){
            $data = $this->m_st_liaison_officer->getAll();
        }       
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Liason Officer > Serah Terima', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/st_liaison_officer/view',['data'=>$data]);
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
    
    public function lihat_unit()
    {
        $this->load->model('transaksi_lain/m_registrasi_liaison_officer');
        $pilih_unit = $this->input->post('pilih_unit');
        echo json_encode($this->m_registrasi_liaison_officer->getUnit2($pilih_unit));
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
}
?>