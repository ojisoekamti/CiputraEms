<?php

defined('BASEPATH') or exit('No direct script access allowed');

class p_registrasi_tvi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('transaksi_lain/m_registrasi_tvi');
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
        $data = $this->m_registrasi_tvi->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_tvi/view', ['data' => $data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function add()
    {
        $dataUnit = $this->m_registrasi_tvi->getUnit();
        $dataCustomer = $this->m_registrasi_tvi->getCustomer();
        $dataPaket = $this->m_registrasi_tvi->getPaket();
        $kode_reg = "CG/REGISTRASITVI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_tvi->last_id()+1);
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'Add']);
        $this->load->view('proyek/transaksi_lain/registrasi_tvi/add', ['dataUnit' => $dataUnit,  'dataCustomer' => $dataCustomer, 'dataPaket' => 
            $dataPaket, 'kode_reg' => $kode_reg    ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function save()

    {


         echo('<PRE>');

         echo 'nomor_registrasi2';
              
         print_r($this->input->post('nomor_registrasi2'));

         echo('</PRE>');





        $status = $this->m_registrasi_tvi->save([

            'pilih_unit' => $this->input->post('pilih_unit'),
            'unit' => $this->input->post('unit_name'),
            'customer_id' => $this->input->post('customer_id'),
            'customer_name' => $this->input->post('customer_name'),
            'customer_name2' => $this->input->post('customer_name2'),
            'jenis_pemasangan' => $this->input->post('jenis_pemasangan'),
            'nomor_telepon' => $this->input->post('nomor_telepon'),
            'nomor_handphone' => $this->input->post('nomor_handphone'),
            'email' => $this->input->post('email'),
            'nomor_telepon2' => $this->input->post('nomor_telepon2'),
            'nomor_handphone2' => $this->input->post('nomor_handphone2'),
            'email2' => $this->input->post('email2'),
            'tanggal_document' => $this->input->post('tanggal_document'),
            'tanggal_pemasangan_mulai' => $this->input->post('tanggal_pemasangan_mulai'),
            'tanggal_aktifasi' => $this->input->post('tanggal_aktifasi'), 
            'jenis_bayar' => $this->input->post('jenis_bayar'),                 
            'jenis_paket_id' => $this->input->post('jenis_paket'),
            'harga_paket' => $this->input->post('harga_paket'),
            'harga_lain_lain' => $this->input->post('harga_pasang'),
            'harga_registrasi' => $this->input->post('harga_registrasi'),
            'diskon' => $this->input->post('diskon'),
            'total' => $this->input->post('total'),
            'keterangan' => $this->input->post('keterangan_paket'),
            'nomor_registrasi' => $this->input->post('nomor_registrasi'),
            'nomor_registrasi2' => $this->input->post('nomor_registrasi2')
           
           



            

        ]);

        $this->load->model('alert');
        $dataUnit = $this->m_registrasi_tvi->getUnit();
        $dataCustomer = $this->m_registrasi_tvi->getCustomer();
        $dataPaket = $this->m_registrasi_tvi->getPaket();
         $kode_reg = "CG/REGISTRASITVI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_tvi->last_id());
        $this->load->view('core/header');
        $this->alert->css();

        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi ', 'subTitle' => 'Add']);
        $this->load->view('proyek/transaksi_lain/registrasi_tvi/add', ['dataUnit' => $dataUnit, 'dataCustomer' => $dataCustomer,
         'dataPaket' => $dataPaket ,  'kode_reg' => $kode_reg   ]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Tambah', 'type' => 'success']);
        } elseif ($status == 'double') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
        }
    }

    public function edit()
    {
        $status = 0;
        if ($this->input->post('nomor_registrasi')) {
            $this->load->model('alert');

            $status = $this->m_registrasi_tvi->edit([


                'id' => $this->input->get('id'), 
                        
               
                'jenis_pemasangan' => $this->input->post('jenis_pemasangan'), 
                'nomor_registrasi' => $this->input->post('nomor_registrasi'),               
                'tanggal_document' => $this->input->post('tanggal_document'),
                'tanggal_pemasangan_mulai' => $this->input->post('tanggal_pemasangan_mulai'),    
                'tanggal_aktifasi' => $this->input->post('tanggal_aktifasi'), 
                'jenis_bayar' => $this->input->post('jenis_bayar'),  
                'jenis_paket_id' => $this->input->post('pilih_paket'),
                'harga_paket' => $this->input->post('harga_paket'),
                'harga_pasang' => $this->input->post('harga_pasang'),
                'biaya_registrasi' => $this->input->post('harga_registrasi'),
                'diskon' => $this->input->post('diskon'),
                'total' => $this->input->post('total'),
                'keterangan' => $this->input->post('keterangan'),
             
            ]);
            $this->alert->css();
        }

        if ($this->m_registrasi_tvi->cek($this->input->get('id'))) {


           
            $dataRegistrasiTviSelect = $this->m_registrasi_tvi->getSelect($this->input->get('id'));
            $dataPaket = $this->m_registrasi_tvi->getPaket();
            $this->load->model('m_log');
            $data = $this->m_log->get('t_tvi_registrasi', $this->input->get('id'));
            $this->load->view('core/header');
            $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
            $this->load->view('core/top_bar');
            $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'Edit']);
            $this->load->view('proyek/transaksi_lain/registrasi_tvi/edit', [ 'data_select' => 
                $dataRegistrasiTviSelect,'dataPaket' => $dataPaket, 'data' => $data]);
            $this->load->view('core/body_footer');
            $this->load->view('core/footer');
        } else {
            redirect(site_url().'/transaksi_lain/P_registrasi_tvi');
        }

        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Update', 'type' => 'success']);
        } elseif ($status == 'double') {
            $this->load->view('core/alert', ['title' => 'Gagal | Double', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
        } elseif ($status == 'Tidak Ada Perubahan') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data Inputan Tidak Ada Perubahan', 'type' => 'danger']);
    }


}


     public function edit_non_unit()
    {
        $status = 0;
        echo $this->input->post('nomor_registrasi2');
        if ($this->input->post('nomor_registrasi2')) {
            $this->load->model('alert');

            $status = $this->m_registrasi_tvi->edit_non_unit([
                'id' => $this->input->get('id'),
                
               
                'id_tagihan' => $this->input->post('id_tagihan'), 
                'nomor_registrasi2' => $this->input->post('nomor_registrasi2'),
                'jenis_pemasangan' => $this->input->post('jenis_pemasangan'),
                'tanggal_document' => $this->input->post('tanggal_document'),
                'tanggal_pemasangan_mulai' => $this->input->post('tanggal_pemasangan_mulai'), 
                'tanggal_aktifasi' => $this->input->post('tanggal_aktifasi'), 
                'jenis_bayar' => $this->input->post('jenis_bayar'),           
                'jenis_paket_id' => $this->input->post('pilih_paket'),
                'harga_paket' => $this->input->post('harga_paket'),
                'harga_pasang' => $this->input->post('harga_pasang'),
                'biaya_registrasi' => $this->input->post('harga_registrasi'),
                'diskon' => $this->input->post('diskon'),
                'total' => $this->input->post('total'),
                'keterangan' => $this->input->post('keterangan'),
             
            ]);
            $this->alert->css();
        }

        if ($this->m_registrasi_tvi->cek($this->input->get('id'))) {


          
            $dataRegistrasiTviNonUnitSelect = $this->m_registrasi_tvi->getSelectNonUnit($this->input->get('id'));
            $dataPaket = $this->m_registrasi_tvi->getPaket();
            $this->load->model('m_log');
            $data = $this->m_log->get('t_tvi_registrasi', $this->input->get('id'));
            $this->load->view('core/header');
            $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
            $this->load->view('core/top_bar');
            $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet > Registrasi', 'subTitle' => 'Edit']);
            $this->load->view('proyek/transaksi_lain/registrasi_tvi/edit_non_unit', ['data_select' => 
                $dataRegistrasiTviNonUnitSelect, 'dataPaket' => $dataPaket, 'data' => $data]);
            $this->load->view('core/body_footer');
            $this->load->view('core/footer');
        } else {
            redirect(site_url().'/transaksi_lain/P_registrasi_tvi');
        }

        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Update', 'type' => 'success']);
        } elseif ($status == 'double') {
            $this->load->view('core/alert', ['title' => 'Gagal | Double', 'text' => 'Data Inputan sudah Ada', 'type' => 'danger']);
         } elseif ($status == 'Tidak Ada Perubahan') {
            $this->load->view('core/alert', ['title' => 'Gagal', 'text' => 'Data Inputan Tidak Ada Perubahan', 'type' => 'danger']);
    }





    }


    public function delete()
    {
        $this->load->model('alert');

        $status = $this->m_registrasi_tvi->delete([
                'id' => $this->input->get('id'),
        ]);

        $this->alert->css();

        $data = $this->m_registrasi_tvi->getAll();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > TV & Internet', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/registrasi_tvi/view', ['data' => $data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
        if ($status == 'success') {
            $this->load->view('core/alert', ['title' => 'Berhasil', 'text' => 'Data Berhasil di Delete', 'type' => 'success']);
        } 
    }


    public function lihat_unit()
    {
        $pilih_unit = $this->input->post('pilih_unit');

        echo json_encode($this->m_registrasi_tvi->getUnit2($pilih_unit));
    }


    public function lihat_customer()
    {
        $pilih_customer = $this->input->post('pilih_customer');

        echo json_encode($this->m_registrasi_tvi->getCustomer2($pilih_customer));
    }


     public function lihat_paket()
    {
        $pilih_paket = $this->input->post('pilih_paket');

        echo json_encode($this->m_registrasi_tvi->getPaket2($pilih_paket));
    }

     public function jenis_paket()
    {
        $jenis_bayar = $this->input->post('jenis_bayar');

        echo json_encode($this->m_registrasi_tvi->getJenisPaket($jenis_bayar));
    }


      public function lihat_nomorreg_non_unit()
    {
      

        $customer_id = $this->input->post('customer_id');

        echo json_encode($this->m_registrasi_tvi->getNomorRegistrasiNonUnit($customer_id));
    }

      public function lihat_nomorreg_unit()
    {
       
        $unit_id = $this->input->post('unit_id');


        echo json_encode($this->m_registrasi_tvi->getNomorRegistrasiUnit( $unit_id));
    }


    public function lihat_aktifasi_unit()
    {
       
        $unit_id = $this->input->post('unit_id');


        echo json_encode($this->m_registrasi_tvi->getAktifasiUnit( $unit_id));
    }


    public function lihat_aktifasi_non_unit()
    {
       
        $customer_id = $this->input->post('customer_id');


        echo json_encode($this->m_registrasi_tvi->getAktifasiNonUnit( $customer_id));
    }





}
