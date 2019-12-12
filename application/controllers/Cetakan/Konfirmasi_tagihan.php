<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class konfirmasi_tagihan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('m_login');
        if (!$this->m_login->status_login()) {
            redirect(site_url());
        }
        $this->load->model('Setting/m_parameter_project');
        $this->load->model('Cetakan/m_konfirmasi_tagihan');
        $this->load->model('m_core');
        global $jabatan;
        $jabatan = $this->m_core->jabatan();
        global $project;
        $project = $this->m_core->project();
        global $menu;
        $menu = $this->m_core->menu();
        ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');

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
    public function test(){
        return 1;
    }
    public function index(){
        $this->load->library('pdf');
        $this->pdf->set_option('defaultMediaType', 'all');
        $this->pdf->set_option('isFontSubsettingEnabled', true);
        $this->pdf->set_option('isHtml5ParserEnabled', true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-petanikode.pdf";
        
        $this->pdf->load_view('konfirmasi_tagihan', $data);
    
    
    }
    public function unit($unit_id=null){
        $project = $this->m_core->project();
        
        $this->load->library('pdf');
        $this->pdf->set_option('defaultMediaType', 'all');
        $this->pdf->set_option('isFontSubsettingEnabled', true);
        $this->pdf->set_option('isHtml5ParserEnabled', true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "konfirmasi_tagihan.pdf";
        
        $unit= $this->m_konfirmasi_tagihan->get_unit($unit_id);

        
        $tagihan= $this->m_konfirmasi_tagihan->get_tagihan($unit_id);
        $total_air              = 0;
        $total_lingkungan       = 0;
        $total_lain             = 0;
        $total_pakai            = 0;
        $total_ppn              = 0;
        $total_denda            = 0;
        $total                  = 0;
        $periode_last           = $this->bln_indo(substr($tagihan[0]->periode,5,2))." ".substr($tagihan[0]->periode,0,4);
        $periode_first          = $this->bln_indo(date('m'))." ".date("Y");
        $status_saldo_deposit   = $this->m_konfirmasi_tagihan->get_status_saldo_deposit($unit_id);
        $saldo_deposit          = $this->m_konfirmasi_tagihan->get_saldo_deposit($unit_id);
        $ttd                    = $this->m_parameter_project->get($project->id,"ttd_konfirmasi_tagihan");

        foreach ($tagihan as $k=>$v) {

            $tagihan[$k]->periode = substr($this->bln_indo(substr($tagihan[$k]->periode,5,2)),0,3)." ".substr($tagihan[$k]->periode,0,4);
            $total_air          += str_replace(',','',$v->tagihan_air);
            $total_lingkungan   += str_replace(',','',$v->tagihan_lingkungan);
            $total_lain         += str_replace(',','',$v->tagihan_lain);
            $total_pakai        += str_replace(',','',$v->meter_pakai?$v->meter_pakai:0);
            $total_ppn          += str_replace(',','',$v->ppn_lingkungan);
            $total_denda        += str_replace(',','',$v->total_denda);
            $total              += str_replace(',','',$v->total);
            
        }
        
        // $this->load->view('proyek/cetakan/konfirmasi_tagihan');
        // var_dump($unit);
        // var_dump($tagihan);
        // var_dump(number_format($total_air));
        // var_dump(number_format($total_lingkungan));
        // var_dump(number_format($total_lain));
        // var_dump(number_format($total_pakai));
        // var_dump(number_format($total_ppn));
        // var_dump(number_format($total_denda));
        // var_dump(number_format($total));
        // var_dump($periode_first);
        // var_dump($periode_last);
        // var_dump($saldo_deposit);
        // var_dump($status_saldo_deposit);
        // var_dump($k);
        $catatan = $unit->catatan;
        // echo($catatan);
        $catatan = str_replace("{{va_unit}}",$unit->virtual_account,$catatan);
        // echo($catatan);

        $this->pdf->load_view("proyek/cetakan/konfirmasi_tagihan",[
                                        "unit"              => $unit,
                                        "catatan"           => $catatan,
                                        "tagihan"           => $tagihan,
                                        "total_air"         => number_format($total_air),
                                        "total_lingkungan"  => number_format($total_lingkungan),
                                        "total_lain"        => number_format($total_lain),
                                        "total_pakai"       => number_format($total_pakai),
                                        "total_ppn"         => number_format($total_ppn),
                                        "total_denda"       => number_format($total_denda),
                                        "total"             => number_format($total),
                                        "periode_first"     => $periode_first,
                                        "periode_last"      => $periode_last,
                                        "saldo_deposit"     => $saldo_deposit,
                                        "status_saldo_deposit"     => $status_saldo_deposit,
                                        "line"              => $k,
                                        "ttd"               => $ttd
                                        ]);
    }
    public function send($unit_id=null){
        $this->load->helper('file');

        $unit_id = str_replace(".pdf","",$unit_id);
        $this->load->library('pdf');
        $this->pdf->set_option('defaultMediaType', 'all');
        $this->pdf->set_option('isFontSubsettingEnabled', true);
        $this->pdf->set_option('isHtml5ParserEnabled', true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "konfirmasi_tagihan.pdf";
        
        $unit= $this->m_konfirmasi_tagihan->get_unit($unit_id);
        $tagihan= $this->m_konfirmasi_tagihan->get_tagihan($unit_id);
        $total_air          = 0;
        $total_lingkungan   = 0;
        $total_lain         = 0;
        $total_pakai        = 0;
        $total_ppn          = 0;
        $total_denda        = 0;
        $total              = 0;
        $periode_last  = $this->bln_indo(substr($tagihan[0]->periode,5,2))." ".substr($tagihan[0]->periode,0,4);
        $periode_first = $this->bln_indo(date('m'))." ".date("Y");
        


        foreach ($tagihan as $k=>$v) {

            $tagihan[$k]->periode = substr($this->bln_indo(substr($tagihan[$k]->periode,5,2)),0,3)." ".substr($tagihan[$k]->periode,0,4);
            $total_air          += str_replace(',','',$v->tagihan_air);
            $total_lingkungan   += str_replace(',','',$v->tagihan_lingkungan);
            $total_lain         += str_replace(',','',$v->tagihan_lain);
            $total_pakai        += str_replace(',','',$v->meter_pakai?$v->meter_pakai:0);
            $total_ppn          += str_replace(',','',$v->ppn_lingkungan);
            $total_denda        += str_replace(',','',$v->total_denda);
            $total              += str_replace(',','',$v->total);
            
        }
        
        // $this->load->view('konfirmasi_tagihan', $data);

        $nama_file = $unit_id.date("_Y-m-d_H-i-s").".pdf";

        $a = $this->pdf->send("proyek/cetakan/konfirmasi_tagihan",[
                                        "unit"              => $unit,
                                        "tagihan"           => $tagihan,
                                        "total_air"         => number_format($total_air),
                                        "total_lingkungan"  => number_format($total_lingkungan),
                                        "total_lain"        => number_format($total_lain),
                                        "total_pakai"       => number_format($total_pakai),
                                        "total_ppn"         => number_format($total_ppn),
                                        "total_denda"       => number_format($total_denda),
                                        "total"             => number_format($total),
                                        "periode_first"     => $periode_first,
                                        "periode_last"      => $periode_last,
                                        "line"              => $k
                                        ]);
        if(write_file("pdf/$nama_file", $a)){
            echo json_encode($nama_file);
        }else{
            echo("Gagal ".$nama_file);
            echo json_encode(false);
        }
    }
}
