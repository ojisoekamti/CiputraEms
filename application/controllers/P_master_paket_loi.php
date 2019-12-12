<?php

defined('BASEPATH') or exit('No direct script access allowed');

class P_master_paket_loi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        $this->load->model('m_channel');
        if (!$this->m_login->status_login()) {
            redirect(site_url());
        }
        $this->load->model('m_paket_loi');
        $this->load->model('m_core');
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
    }

    public function index()
    {
        $data = $this->m_paket_loi->get_all();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Service > Paket Liaison Officer', 'subTitle' => 'List']);
        $this->load->view('proyek/master/paket_loi/view',['data'=>$data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function add()
    {
        $dataJenis = $this->m_paket_loi->get_jenis();
        $this->load->model('alert');
		$this->alert->css();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar');
        $this->load->view('core/body_header', ['title' => 'Master > Service > Paket Liaison Officer', 'subTitle' => 'Add']);
        $this->load->view('proyek/master/paket_loi/add',['dataJenis'=>$dataJenis]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function edit()
    {
        $dataSelect = $this->m_paket_loi->getSelect($this->input->get("id"));
        $dataPaketSelect = $this->m_paket_loi->get_paket_detail($this->input->get("id"));
        $dataJenis = $this->m_paket_loi->get_jenis();
        $dataItem = $this->m_paket_loi->get_item();
        $this->load->model('m_log');
        $data = $this->m_log->get('paket_loi', $this->input->get('id'));
        $this->load->view('core/header');
        $this->load->model('alert');
		$this->alert->css();
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Service > Paket Liaison Officer', 'subTitle' => 'Edit']);
        $this->load->view('proyek/master/paket_loi/edit',["data"=>$data, "dataSelect"=>$dataSelect,"dataJenis"=>$dataJenis, "dataPaketSelect"=>$dataPaketSelect, "dataItem"=>$dataItem]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
    }

    public function delete()
    {
        $this->load->model('alert');
        $status = $this->m_paket_tv->delete([
            'id' => $this->input->get('id'),
        ]);
        $this->alert->css();
        $data = $this->m_paket_tv->get_all();
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Master > Service > Paket Liaison Officer', 'subTitle' => 'List']);
        $this->load->view('proyek/master/paket_tv/view', ['data' => $data]);
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

    public function ajax_save(){
        echo(json_encode($this->m_paket_loi->save($this->input->post())));
    }

    public function ajax_get_item(){
        $jenis = $this->input->post('jenis');
        echo json_encode($this->m_paket_loi->get_item($jenis));
    }
}
