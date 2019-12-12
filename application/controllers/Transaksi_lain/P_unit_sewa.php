<?php
defined('BASEPATH') or exit('No direct script access allowed');
class P_unit_sewa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_unit');
        $this->load->model('m_core');
        $this->load->model('m_login');
        $this->load->model('transaksi_lain/m_unit_sewa');
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
        $data = $this->m_unit_sewa->get();
        var_dump($data);
        $this->load->view('core/header');
        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Sewa Properti > Unit Sewa', 'subTitle' => 'List']);
        $this->load->view('proyek/transaksi_lain/unit_sewa/view', ['data' => $data]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
	}
	public function add()
    {
		$this->load->model("m_unit");
		$dataUnit = $this->m_unit->get_unit();
		$this->load->model("m_harga_sewa");
		$dataRangeHargaSewa = $this->m_harga_sewa->get_range_harga_sewa();
		$this->load->model('alert');

		$this->load->view('core/header');
		$this->alert->css();

        $this->load->view('core/side_bar', ['menu' => $GLOBALS['menu']]);
        $this->load->view('core/top_bar', ['jabatan' => $GLOBALS['jabatan'], 'project' => $GLOBALS['project']]);
        $this->load->view('core/body_header', ['title' => 'Transaksi Service Lain > Sewa Properti > Unit Sewa', 'subTitle' => 'Add']);
		$this->load->view('proyek/transaksi_lain/unit_sewa/add', 
			[
				'dataUnit' => $dataUnit,
				'dataRangeHargaSewa' => $dataRangeHargaSewa
			]);
        $this->load->view('core/body_footer');
        $this->load->view('core/footer');
	}
	public function ajax_save(){
		echo(json_encode($this->m_unit_sewa->save($this->input->get())));
	}
}
?>