<?php 
class my404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
        { 
            redirect(site_url('dashboard'));
            // $this->output->set_status_header('404'); 
            // $data['content'] = 'error_404'; // View name 
            // $this->load->view('index',$data);//loading in my template 
        } 
    }
