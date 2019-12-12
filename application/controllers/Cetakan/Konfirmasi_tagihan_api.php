<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class konfirmasi_tagihan_api extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Setting/m_parameter_project');
        $this->load->model('Cetakan/m_konfirmasi_tagihan');
        $this->load->model('m_core');

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
    
    public function test_get(){
        echo json_encode(1);
    }
    public function send_post($unit_id=null){
        $isi_konfirmasi_tagihan = $this->post("isi");
        $project_id = $this->post("project_id");
        // var_dump($isi_konfirmasi_tagihan);
        // $project = $this->m_core->project();
        // var_dump($project);

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
        $status_saldo_deposit   = $this->m_konfirmasi_tagihan->get_status_saldo_deposit($unit_id);
        $saldo_deposit          = $this->m_konfirmasi_tagihan->get_saldo_deposit($unit_id);


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
        // var_dump($project);

        $ttd                    = $this->m_parameter_project->get($project_id,"ttd_konfirmasi_tagihan");
        $catatan = $unit->catatan;
        $catatan = str_replace("{{va_unit}}",$unit->virtual_account,$catatan);

        $a = $this->pdf->send("proyek/cetakan/konfirmasi_tagihan",[
                                        "unit"              => $unit,
                                        "tagihan"           => $tagihan,
                                        "catatan"           => $catatan,
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
        $isi_konfirmasi_tagihan = str_replace("{{Project}}",$unit->project,$isi_konfirmasi_tagihan);
        $isi_konfirmasi_tagihan = str_replace("{{Kawasan}}",$unit->kawasan,$isi_konfirmasi_tagihan);
        $isi_konfirmasi_tagihan = str_replace("{{Blok}}",$unit->blok,$isi_konfirmasi_tagihan);
        $isi_konfirmasi_tagihan = str_replace("{{No_unit}}",$unit->no_unit,$isi_konfirmasi_tagihan);
        $isi_konfirmasi_tagihan = str_replace("{{Pemilik}}",$unit->pemilik,$isi_konfirmasi_tagihan);

        if ($periode_first == $periode_last) {
            $isi_konfirmasi_tagihan = str_replace("{{Bulan}}",strtoupper($this->bln_indo(substr($tagihan[0]->periode,5,2))),$isi_konfirmasi_tagihan);
        } else {
            $isi_konfirmasi_tagihan = str_replace("{{Bulan}}",strtoupper($this->bln_indo(substr($tagihan[0]->periode,5,2))) . " sampai " . strtoupper($this->bln_indo(date('m'))),$isi_konfirmasi_tagihan);
        }




        $isi_konfirmasi_tagihan = str_replace("{{Tahun}}",date("Y"),$isi_konfirmasi_tagihan);
        // var_dump($isi_konfirmasi_tagihan);


        if(write_file("application/pdf/$nama_file", $a)){
            echo json_encode([
                "isi"=>$isi_konfirmasi_tagihan,
                "name_file"=>$nama_file
            ]);
        }else{
            echo("Gagal ".$nama_file);
            echo json_encode(false);
        }
    }
}
