<?php
defined('BASEPATH') or exit('No direct script access allowed');

class P_aging extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('transaksi/m_aging');
		$this->load->model('m_core');
		global $jabatan;
		$jabatan = $this->m_core->jabatan();
		global $project;
		$project = $this->m_core->project();
		global $menu;
		$menu = $this->m_core->menu();
		global $unit_id;
		$unit_id = $this->m_core->unit_id();
    }
    
    public function index()
    {
        $kawasan = $this->m_aging->getKawasan();
		$this->load->view('core/header');
		$this->load->view('core/side_bar',['menu' => $GLOBALS['menu']]);
		$this->load->view('core/top_bar',['jabatan' => $GLOBALS['jabatan'],'project' => $GLOBALS['project']]);
		$this->load->view('core/body_header',['title' => 'Transaksi Service > Aging > Aging Service','subTitle' => 'List']);
		$this->load->view('proyek/transaksi/aging/dashboard',['kawasan'=>$kawasan]);
		$this->load->view('core/body_footer');
		$this->load->view('core/footer');
    }

    public function ajax_get_blok(){
		echo json_encode($this->m_aging->ajax_get_blok($this->input->get('id')));
	}
	public function ajax_get_unit(){
		echo json_encode($this->m_aging->ajax_get_unit($this->input->get('kawasan'),$this->input->get('blok'),$this->input->get('periode')));
	}
}
?>