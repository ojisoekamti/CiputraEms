<?php

defined("BASEPATH") or exit("No direct script access allowed");

class m_history_pembayaran extends CI_Model
{

//     public function getCaraPembayaran()
//     {
//         $project = $this->m_core->project();
//         $query = $this->db
//                         ->select(
//                             "cara_pembayaran_jenis.*")
//                         ->from("cara_pembayaran_jenis")
//                         ->join("cara_pembayaran",
//                                 "cara_pembayaran.jenis_cara_pembayaran_id = cara_pembayaran_jenis.id
//                                 AND cara_pembayaran.project_id = $project->id",
//                                 "LEFT")
//                         ->where("cara_pembayaran.id is not null")
//                         ->distinct();
//         return $query->get()->result();
//     }
    public function getCaraPembayaran()
    {
        $project = $this->m_core->project();
        $query = $this->db
                        ->select(
                            "cara_pembayaran.id as id,
                            cara_pembayaran.code as code,
                            cara_pembayaran.name as cara,
                            bank.name as bank_name")
                        ->from("cara_pembayaran")
                        ->join("bank",
                                "bank.id = cara_pembayaran.bank_id","LEFT")
                        ->join("project",
                                "project.id = cara_pembayaran.project_id","LEFT")
                        ->where("cara_pembayaran.project_id",$project->id)
                        ->where("cara_pembayaran.id is not null")
                        ->distinct();
        return $query->get()->result();
    }

    public function getService()
    {
        $query = $this->db
                        ->select(
                            "service_jenis.*")
                        ->from("service_jenis")
                        ->where("service_jenis.id is not null")
                        ->distinct();
        return $query->get()->result();
    }

    public function getAll($kawasan,$blok,$periode_awal,$periode_akhir,$cara_bayar,$jns_service)
    {
        //Air
        $project = $this->m_core->project();
        $periode_awal = substr($periode_awal,6,4)."-".substr($periode_awal,3,2)."-".substr($periode_awal,0,2);
        $periode_akhir = substr($periode_akhir,6,4)."-".substr($periode_akhir,3,2)."-".substr($periode_akhir,0,2);
        
        $query = $this->db
                            ->select("
                            kawasan.code,
                            v_tagihan_air.blok,
                            v_tagihan_air.no_unit,
                            ISNULL(kwitansi_referensi.no_kwitansi,'-') as no_kwitansi,
                            v_tagihan_air.periode,
                            t_tagihan_air_info.pemakaian,
                            t_pembayaran.tgl_bayar,
                            v_tagihan_air.nilai_administrasi,
                            v_tagihan_air.nilai_denda,
                            v_tagihan_air.nilai,
                            t_pembayaran_detail.nilai_diskon,
                            v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan) as bayar")
                            ->from("v_tagihan_air")
                            ->join("project",
                                    "project.id = v_tagihan_air.proyek_id")
                            ->join("kawasan",
                                    "kawasan.id = v_tagihan_air.kawasan_id")      
                            ->join("t_tagihan_air",
                                    "t_tagihan_air.proyek_id = project.id")
                            ->join("t_tagihan_air_info",
                                    "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
                            ->join("t_pembayaran_detail",
                                    "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
                            ->join("t_pembayaran",
                                    "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                            ->join("cara_pembayaran",
                                    "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
                            ->join("kwitansi_referensi",
                                    "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
                            ->join("service",
                                    "service.id = t_pembayaran_detail.service_id")
                            ->where("v_tagihan_air.proyek_id",$project->id)
                            ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                            ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");

        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");


        }else{

                $query = $query->where("cara_pembayaran_id", $cara_bayar);
                $query = $query->where("t_pembayaran_detail.bayar > 0");


        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan_id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok_id",$blok);
        }

        $data = (object)[];
        $data->header=["Kode Kawasan","Kode Blok","No Unit", "No. Kwitansi", "Periode", "Pakai (m3)", "Tanggal Bayar", "Nilai Admin", "Denda", 
                        "Pemakaian", "Disc", "Total Bayar"];
        $result = $query->get()->result();
        $data->isi = $result;
        

        if($cara_bayar==0){
                $cara_pembayaran_name = "Service Air - Deposit";
        }else{
            $cara = $this->db
                            ->select("CONCAT(cara_pembayaran.name,' ',bank.name) as gabungan")
                            ->from("cara_pembayaran")
                            ->join("bank",
                                    "bank.id = cara_pembayaran.bank_id", "LEFT")
                            ->where("cara_pembayaran.id",$cara_bayar)->get()->row()->gabungan;
        //     $cara_pembayaran_name = "Service Air - ".$cara;
            $cara_pembayaran_name = "Service Air  ";
        }
        $data->cara_bayar = $cara;
        $data->judul = $cara_pembayaran_name;
        $pembayaran_name = "Rekapitulasi Transaksi Service Air";
        $data->judul_rekap = $pembayaran_name;
        if($jns_service==2){
            $jns_service = $this->db->select("id")->from("service_jenis")->where("id",$jns_service)->get()->row()->id;
        }
        $data->serviceAir = $jns_service;

        // $Air = $this->db
        //                 ->select("
        //                 SUM(t_tagihan_air_info.pemakaian) as pakai,
        //                 SUM(v_tagihan_air.nilai_administrasi) as admin,
        //                 SUM(v_tagihan_air.nilai_denda) as denda,
        //                 SUM(v_tagihan_air.nilai) as pemakaian,
        //                 SUM(t_pembayaran_detail.nilai_diskon) as diskon,
        //                 SUM(v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)) as bayar")
        //                 ->from("v_tagihan_air")
        //                 ->join("project",
        //                         "project.id = v_tagihan_air.proyek_id")      
        //                 ->join("t_tagihan_air",
        //                         "t_tagihan_air.proyek_id = project.id")
        //                 ->join("t_tagihan_air_info",
        //                         "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_air.proyek_id",$project->id)
        //                 ->where("t_pembayaran.cara_pembayaran_id",$cara_bayar)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $admin = $Air->admin;
        // $pakai = $Air->pakai;
        // $denda = $Air->denda;
        // $pemakaian = $Air->pemakaian;
        // $diskon = $Air->diskon;
        // $bayar = $Air->bayar;
        // $data->nilai_admin = $admin;
        // $data->denda = $denda;
        // $data->pakai = $pakai;
        // $data->pemakaian = $pemakaian;
        // $data->diskon = $diskon;
        // $data->bayar = $bayar;

        // $GrandAir = $this->db
        //                 ->select("
        //                 SUM(t_tagihan_air_info.pemakaian) as pakai,
        //                 SUM(v_tagihan_air.nilai_administrasi) as admin,
        //                 SUM(v_tagihan_air.nilai_denda) as denda,
        //                 SUM(v_tagihan_air.nilai) as pemakaian,
        //                 SUM(t_pembayaran_detail.nilai_diskon) as diskon,
        //                 SUM(v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)) as bayar,
        //                 SUM(t_pembayaran_detail.nilai_denda_pemutihan) as denda_pemutihan,
        //                 SUM(t_pembayaran_detail.nilai_tagihan_pemutihan) as tagihan_pemutihan")
        //                 ->from("v_tagihan_air")
        //                 ->join("project",
        //                         "project.id = v_tagihan_air.proyek_id")      
        //                 ->join("t_tagihan_air",
        //                         "t_tagihan_air.proyek_id = project.id")
        //                 ->join("t_tagihan_air_info",
        //                         "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_air.proyek_id",$project->id)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $grandAdmin = $GrandAir->admin;
        // $grandPakai = $GrandAir->pakai;
        // $grandDenda = $GrandAir->denda;
        // $grandPemakaian = $GrandAir->pemakaian;
        // $grandDiskon = $GrandAir->diskon;
        // $grandBayar = $GrandAir->bayar;
        // $dendaPemutihan = $GrandAir->denda_pemutihan;
        // $tagihanPemutihan = $GrandAir->tagihan_pemutihan;
        // $data->grandAdmin = $grandAdmin;
        // $data->grandDenda = $grandDenda;
        // $data->grandPakai = $grandPakai;
        // $data->grandPemakaian = $grandPemakaian;
        // $data->grandDiskon = $grandDiskon;
        // $data->grandBayar = $grandBayar;
        // $data->dendaPemutihan = $dendaPemutihan;
        // $data->tagihanPemutihan = $tagihanPemutihan;

        //Lingkungan
        $project = $this->m_core->project();
        $periode_awal = substr($periode_awal,6,4)."-".substr($periode_awal,3,2)."-".substr($periode_awal,0,2);
        $periode_akhir = substr($periode_akhir,6,4)."-".substr($periode_akhir,3,2)."-".substr($periode_akhir,0,2);

        $query = $this->db
                        ->select("
                        kawasan.code,
                        v_tagihan_lingkungan.blok,
                        v_tagihan_lingkungan.no_unit,
                        ISNULL(kwitansi_referensi.no_kwitansi,' - ') as no_kwitansi,
                        v_tagihan_lingkungan.periode,
                        t_pembayaran.tgl_bayar,
                        t_pembayaran_detail.nilai_denda,
                        v_tagihan_lingkungan.nilai_bangunan,
                        v_tagihan_lingkungan.nilai_kavling,
                        v_tagihan_lingkungan.nilai_keamanan,
                        v_tagihan_lingkungan.nilai_kebersihan,
                        v_tagihan_lingkungan.total_tanpa_ppn,
                        v_tagihan_lingkungan.ppn,
                        t_pembayaran_detail.nilai_diskon,
                        v_tagihan_lingkungan.total_tanpa_ppn+t_pembayaran_detail.nilai_denda+v_tagihan_lingkungan.ppn-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan) as bayar")
                        ->from("v_tagihan_lingkungan")
                        ->distinct()
                        ->join("project",
                                "project.id = v_tagihan_lingkungan.proyek_id")
                        ->join("kawasan",
                                "kawasan.id = v_tagihan_lingkungan.kawasan_id")
                        ->join("t_pembayaran_detail",
                                "t_pembayaran_detail.tagihan_service_id = v_tagihan_lingkungan.tagihan_id")
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("cara_pembayaran",
                                "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id")
                        ->where("v_tagihan_lingkungan.proyek_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");
                        
        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");


        }else{

            $query = $query->where("cara_pembayaran_id", $cara_bayar);
            $query = $query->where("t_pembayaran_detail.bayar > 0");


        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan_id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok_id",$blok);
        }
        $data = (object)[];
        $data->header=["Kode Kawasan","Kode Blok","No Unit", "No. Kwitansi", "Periode", "Tanggal Bayar", "Denda", 
                        "Nilai Bangunan", "Nilai Tanah", "Nilai Keamanan", "Nilai Kebersihan", "Tagihan", "PPN", "Disc",
                        "Total Bayar"];
        // $data->footer=["Sub Total Lingkungan",$data->];
        // $data->colspan=["7"];
        $result = $query->get()->result();
        $data->isi = $result;

        if($cara_bayar==0){
                $cara_pembayaran_name = "Service Lingkungan - Deposit";
        }else{
        $cara = $this->db
                        ->select("CONCAT(cara_pembayaran.name,' ',bank.name) as gabungan")
                        ->from("cara_pembayaran")
                        ->join("bank",
                                "bank.id = cara_pembayaran.bank_id", "LEFT")
                        ->where("cara_pembayaran.id",$cara_bayar)->get()->row()->gabungan;
        // $cara_pembayaran_name = "Service Lingkungan - ".$cara;
        $cara_pembayaran_name = "Service Lingkungan ";
        }
        $data->cara_bayar = $cara;
        $data->judul = $cara_pembayaran_name;
        $pembayaran_name = "Sub Total Transaksi Lingkungan - ".$cara;
        $data->judul_rekap = $pembayaran_name;
        if($jns_service==1){
            $jns_service = $this->db->select("id")->from("service_jenis")->where("id",$jns_service)->get()->row()->id;
        }
        $data->serviceLingkungan = $jns_service;

        // $Lingkungan = $this->db
        //                 ->select("
        //                 ISNULL(SUM(t_pembayaran_detail.nilai_denda),' - ') as denda,
        //                 ISNULL(SUM(v_tagihan_lingkungan.nilai_bangunan),' - ') as bangunan,
        //                 ISNULL(SUM(v_tagihan_lingkungan.nilai_kavling),' - ') as kavling,
        //                 ISNULL(SUM(v_tagihan_lingkungan.nilai_keamanan),' - ') as keamanan,
        //                 ISNULL(SUM(v_tagihan_lingkungan.nilai_kebersihan),' - ') as kebersihan,
        //                 ISNULL(SUM(v_tagihan_lingkungan.total_tanpa_ppn),' - ') as tagihan,
        //                 ISNULL(SUM(v_tagihan_lingkungan.ppn),' - ') as ppn,
        //                 ISNULL(SUM(t_pembayaran_detail.nilai_diskon),' - ') as diskon,
        //                 ISNULL(SUM(v_tagihan_lingkungan.total_tanpa_ppn+t_pembayaran_detail.nilai_denda+v_tagihan_lingkungan.ppn-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)),' - ') as bayar")
        //                 ->from("v_tagihan_lingkungan")
        //                 ->join("project",
        //                         "project.id = v_tagihan_lingkungan.proyek_id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_lingkungan.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_lingkungan.proyek_id",$project->id)
        //                 ->where("t_pembayaran.cara_pembayaran_id",$cara_bayar)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $denda = $Lingkungan->denda;
        // $bangunan = $Lingkungan->bangunan;
        // $kavling = $Lingkungan->kavling;
        // $keamanan = $Lingkungan->keamanan;
        // $kebersihan = $Lingkungan->kebersihan;
        // $tagihan = $Lingkungan->tagihan;
        // $ppn = $Lingkungan->ppn;
        // $diskon = $Lingkungan->diskon;
        // $bayar = $Lingkungan->bayar;
        
        // $data->denda = $denda;
        // $data->bangunan = $bangunan;
        // $data->kavling = $kavling;
        // $data->keamanan = $keamanan;
        // $data->kebersihan = $kebersihan;
        // $data->tagihan = $tagihan;
        // $data->ppn = $ppn;
        // $data->diskon = $diskon;
        // $data->bayar = $bayar;

        // $GrandLingkungan = $this->db
        //                 ->select("
        //                 SUM(t_pembayaran_detail.nilai_denda) as denda,
        //                 SUM(v_tagihan_lingkungan.nilai_bangunan) as bangunan,
        //                 SUM(v_tagihan_lingkungan.nilai_kavling) as kavling,
        //                 SUM(v_tagihan_lingkungan.nilai_keamanan) as keamanan,
        //                 SUM(v_tagihan_lingkungan.nilai_kebersihan) as kebersihan,
        //                 SUM(v_tagihan_lingkungan.total_tanpa_ppn) as tagihan,
        //                 SUM(v_tagihan_lingkungan.ppn) as ppn,
        //                 SUM(t_pembayaran_detail.nilai_diskon) as diskon,
        //                 SUM(v_tagihan_lingkungan.total_tanpa_ppn+t_pembayaran_detail.nilai_denda+v_tagihan_lingkungan.ppn-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)) as bayar,
        //                 SUM(t_pembayaran_detail.nilai_denda_pemutihan) as denda_pemutihan,
        //                 SUM(t_pembayaran_detail.nilai_tagihan_pemutihan) as tagihan_pemutihan")
        //                 ->from("v_tagihan_lingkungan")
        //                 ->join("project",
        //                         "project.id = v_tagihan_lingkungan.proyek_id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_lingkungan.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_lingkungan.proyek_id",$project->id)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $grandDenda = $GrandLingkungan->denda;
        // $grandBangunan = $GrandLingkungan->bangunan;
        // $grandKavling = $GrandLingkungan->kavling;
        // $grandKeamanan = $GrandLingkungan->keamanan;
        // $grandKebersihan = $GrandLingkungan->kebersihan;
        // $grandTagihan = $GrandLingkungan->tagihan;
        // $grandPpn = $GrandLingkungan->ppn;
        // $grandDiskon = $GrandLingkungan->diskon;
        // $grandBayar = $GrandLingkungan->bayar;
        // $dendaPemutihan =  $GrandLingkungan->denda_pemutihan;
        // $tagihanPemutihan = $GrandLingkungan->tagihan_pemutihan; 
        
        // $data->grandDenda = $grandDenda;
        // $data->grandBangunan = $grandBangunan;
        // $data->grandKavling = $grandKavling;
        // $data->grandKeamanan = $grandKeamanan;
        // $data->grandKebersihan = $grandKebersihan;
        // $data->grandTagihan = $grandTagihan;
        // $data->grandPpn = $grandPpn;
        // $data->grandDiskon = $grandDiskon;
        // $data->grandBayar = $grandBayar;
        // $data->dendaPemutihan = $dendaPemutihan;
        // $data->tagihanPemutihan = $tagihanPemutihan;
        return $data;
    }

    public function getAir2($kawasan,$blok,$periode_awal,$periode_akhir,$cara_bayar,$jns_service)
    {
        $project = $this->m_core->project();
        $periode_awal = substr($periode_awal,6,4)."-".substr($periode_awal,3,2)."-".substr($periode_awal,0,2);
        $periode_akhir = substr($periode_akhir,6,4)."-".substr($periode_akhir,3,2)."-".substr($periode_akhir,0,2);
        
        $query = $this->db
                        ->select("
                        kawasan.code,
                        v_tag ihan_air.blok,
                        v_tagihan_air.no_unit,
                        ISNULL(kwitansi_referensi.no_kwitansi,'-') as no_kwitansi,
                        v_tagihan_air.periode,
                        t_tagihan_air_info.pemakaian,
                        t_pembayaran.tgl_bayar,
                        v_tagihan_air.nilai_administrasi,
                        v_tagihan_air.nilai_denda,
                        v_tagihan_air.nilai,
                        t_pembayaran_detail.nilai_diskon,
                        v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan) as bayar")
                        ->from("v_tagihan_air")
                        ->join("project",
                                "project.id = v_tagihan_air.proyek_id")
                        ->join("kawasan",
                                "kawasan.id = v_tagihan_air.kawasan_id")      
                        ->join("t_tagihan_air",
                                "t_tagihan_air.proyek_id = project.id")
                        ->join("t_tagihan_air_info",
                                "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
                        ->join("t_pembayaran_detail",
                                "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("cara_pembayaran",
                                "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id")
                        ->where("v_tagihan_air.proyek_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");

        if($cara_bayar==0){
                $query = $query->where("t_pembayaran_detail.bayar = 0");


        }else{

                $query = $query->where("cara_pembayaran_id", $cara_bayar);
                $query = $query->where("t_pembayaran_detail.bayar > 0");


        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan_id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok_id",$blok);
        }

        $data = (object)[];
        $data->header=["Kode Kawasan","Kode Blok","No Unit", "No. Kwitansi", "Periode", "Pakai (m3)", "Tanggal Bayar", "Nilai Admin", "Denda", 
                        "Pemakaian", "Disc", "Total Bayar"];
        $result = $query->get()->result();
        $data->isi = $result;
        

        if($cara_bayar==0){
                $cara_pembayaran_name = "Service Air - Deposit";
        }else{
            $cara = $this->db
                            ->select("CONCAT(cara_pembayaran.name,' ',bank.name) as gabungan")
                            ->from("cara_pembayaran")
                            ->join("bank",
                                    "bank.id = cara_pembayaran.bank_id", "LEFT")
                            ->where("cara_pembayaran.id",$cara_bayar)->get()->row()->gabungan;
        //     $cara_pembayaran_name = "Service Air - ".$cara;
            $cara_pembayaran_name = "Service Air  ";
        }
        $data->cara_bayar = $cara;
        $data->judul = $cara_pembayaran_name;
        $pembayaran_name = "Rekapitulasi Transaksi Service Air";
        $data->judul_rekap = $pembayaran_name;
        if($jns_service==2){
            $jns_service = $this->db->select("id")->from("service_jenis")->where("id",$jns_service)->get()->row()->id;
        }
        $data->serviceAir = $jns_service;

        // $Air = $this->db
        //                 ->select("
        //                 ISNULL(SUM(t_tagihan_air_info.pemakaian),' - ') as pakai,
        //                 ISNULL(SUM(v_tagihan_air.nilai_administrasi),' - ') as admin,
        //                 ISNULL(SUM(v_tagihan_air.nilai_denda),' - ') as denda,
        //                 ISNULL(SUM(v_tagihan_air.nilai),' - ') as pemakaian,
        //                 ISNULL(SUM(t_pembayaran_detail.nilai_diskon),' - ') as diskon,
        //                 ISNULL(SUM(v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)),' - ') as bayar")
        //                 ->from("v_tagihan_air")
        //                 ->join("project",
        //                         "project.id = v_tagihan_air.proyek_id")      
        //                 ->join("t_tagihan_air",
        //                         "t_tagihan_air.proyek_id = project.id")
        //                 ->join("t_tagihan_air_info",
        //                         "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_air.proyek_id",$project->id)
        //                 ->where("t_pembayaran.cara_pembayaran_id",$cara_bayar)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $admin = $Air->admin;
        // $pakai = $Air->pakai;
        // $denda = $Air->denda;
        // $pemakaian = $Air->pemakaian;
        // $diskon = $Air->diskon;
        // $bayar = $Air->bayar;
        // $data->nilai_admin = $admin;
        // $data->denda = $denda;
        // $data->pakai = $pakai;
        // $data->pemakaian = $pemakaian;
        // $data->diskon = $diskon;
        // $data->bayar = $bayar;

        // $GrandAir = $this->db
        //                 ->select("
        //                 SUM(t_tagihan_air_info.pemakaian) as pakai,
        //                 SUM(v_tagihan_air.nilai_administrasi) as admin,
        //                 SUM(v_tagihan_air.nilai_denda) as denda,
        //                 SUM(v_tagihan_air.nilai) as pemakaian,
        //                 SUM(t_pembayaran_detail.nilai_diskon) as diskon,
        //                 SUM(v_tagihan_air.total_tanpa_ppn+t_pembayaran_detail.nilai_denda-(t_pembayaran_detail.nilai_diskon+t_pembayaran_detail.nilai_denda_pemutihan+t_pembayaran_detail.nilai_tagihan_pemutihan)) as bayar,
        //                 SUM(t_pembayaran_detail.nilai_denda_pemutihan) as denda_pemutihan,
        //                 SUM(t_pembayaran_detail.nilai_tagihan_pemutihan) as tagihan_pemutihan")
        //                 ->from("v_tagihan_air")
        //                 ->join("project",
        //                         "project.id = v_tagihan_air.proyek_id")      
        //                 ->join("t_tagihan_air",
        //                         "t_tagihan_air.proyek_id = project.id")
        //                 ->join("t_tagihan_air_info",
        //                         "t_tagihan_air_info.t_tagihan_air_id = t_tagihan_air.id")
        //                 ->join("t_pembayaran_detail",
        //                         "t_pembayaran_detail.tagihan_service_id = v_tagihan_air.tagihan_id")
        //                 ->join("t_pembayaran",
        //                         "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
        //                 ->join("cara_pembayaran",
        //                         "cara_pembayaran.id = t_pembayaran.cara_pembayaran_id")
        //                 ->join("kwitansi_referensi",
        //                         "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id")
        //                 ->join("service",
        //                         "service.id = t_pembayaran_detail.service_id")
        //                 ->where("v_tagihan_air.proyek_id",$project->id)
        //                 ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
        //                 ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'")->get()->row();
        // $grandAdmin = $GrandAir->admin;
        // $grandPakai = $GrandAir->pakai;
        // $grandDenda = $GrandAir->denda;
        // $grandPemakaian = $GrandAir->pemakaian;
        // $grandDiskon = $GrandAir->diskon;
        // $grandBayar = $GrandAir->bayar;
        // $dendaPemutihan = $GrandAir->denda_pemutihan;
        // $tagihanPemutihan = $GrandAir->tagihan_pemutihan;
        // $data->grandAdmin = $grandAdmin;
        // $data->grandDenda = $grandDenda;
        // $data->grandPakai = $grandPakai;
        // $data->grandPemakaian = $grandPemakaian;
        // $data->grandDiskon = $grandDiskon;
        // $data->grandBayar = $grandBayar;
        // $data->dendaPemutihan = $dendaPemutihan;
        // $data->tagihanPemutihan = $tagihanPemutihan;
        return $data;
    }


    public function getLingkungan($kawasan,$blok,$periode_awal,$periode_akhir,$cara_bayar,$jns_service)
    {
        $project = $this->m_core->project();
        $periode_awal = substr($periode_awal,6,4)."-".substr($periode_awal,3,2)."-".substr($periode_awal,0,2);
        $periode_akhir = substr($periode_akhir,6,4)."-".substr($periode_akhir,3,2)."-".substr($periode_akhir,0,2);
        
        $query = $this->db
                        ->select("
                                kawasan.code as kawasan,
                                blok.code as blok,
                                unit.no_unit,
                                isnull(kwitansi_referensi.no_kwitansi,'-') as no_kwitansi,
                                t_tagihan_lingkungan.periode as periode,
                                CONVERT(date,t_pembayaran.tgl_bayar) as tgl_bayar,
                                t_pembayaran_detail.nilai_denda,
                                
                                t_tagihan_lingkungan_detail.nilai_bangunan,
                                t_tagihan_lingkungan_detail.nilai_kavling,
                                t_tagihan_lingkungan_detail.nilai_keamanan,
                                t_tagihan_lingkungan_detail.nilai_kebersihan,
                                
                                t_pembayaran_detail.nilai_tagihan - ((t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn) / (100+t_pembayaran_detail.nilai_ppn)) as nilai_tagihan,
                                ((t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn) / (100+t_pembayaran_detail.nilai_ppn)) as nilai_ppn,	

                                t_pembayaran_detail.nilai_diskon,
                                t_pembayaran_detail.nilai_tagihan as total_tagihan,

                                isnull(t_pembayaran_detail.bayar,t_pembayaran_detail.bayar_deposit) as nilai_bayar")
                        ->from("t_pembayaran_detail")
                        ->distinct()
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("unit",
                                "unit.id = t_pembayaran.unit_id",
                                "LEFT")
                        ->join("blok",
                                "blok.id = unit.blok_id",
                                "LEFT")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id",
                                "LEFT")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id",
                                "LEFT")
                        ->join("t_tagihan_lingkungan",
                                "t_tagihan_lingkungan.id = t_pembayaran_detail.tagihan_service_id")
                        ->join("t_tagihan_lingkungan_detail",
                                "t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id = t_tagihan_lingkungan.id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id ")
                        ->where("service.service_jenis_id", $jns_service)
                        ->where("unit.project_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");
        
        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");
        }else{
            $query = $query->where("t_pembayaran.cara_pembayaran_id", $cara_bayar);
            $query = $query->where("t_pembayaran_detail.bayar > 0");
        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan.id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok.id",$blok);
        }
        $data = (object)[];
        $data->header=["Kode Kawasan","Kode Blok","No Unit" , "No. Kwitansi", "Periode", "Tanggal Bayar", "Denda", 
                        "Nilai Bangunan", "Nilai Tanah", "Nilai Keamanan", "Nilai Kebersihan", "Tagihan", "PPN", "Disc", "Total Tagihan", "Total Bayar"];
        $result = $query->get()->result();
        $data->isi = $result;  
        // print_r($this->db->last_query())
        if($cara_bayar==0){
            $cara_pembayaran_name = "Deposit";
        }else{
            $cara = $this->db
                            ->select("CONCAT(cara_pembayaran.name,' ',bank.name) as gabungan")
                            ->from("cara_pembayaran")
                            ->join("bank",
                                    "bank.id = cara_pembayaran.bank_id", "LEFT")
                            ->where("cara_pembayaran.id",$cara_bayar)->get()->row()->gabungan;
            $cara_pembayaran_name = $cara;
        }
        $pembayaran_name = "Sub Total Transaksi Lingkungan - ".$cara_pembayaran_name;
        $data->judul_rekap = $pembayaran_name;
        if($jns_service==1){
            $jns_service = $this->db->select("id")->from("service_jenis")->where("id",$jns_service)->get()->row()->id;
        }

        $query = $this->db
                        ->select("
                                sum(t_pembayaran_detail.nilai_denda) as nilai_denda,
            
                                sum(t_tagihan_lingkungan_detail.nilai_bangunan) as nilai_bangunan,
                                sum(t_tagihan_lingkungan_detail.nilai_kavling) as nilai_kavling,
                                sum(t_tagihan_lingkungan_detail.nilai_keamanan) as nilai_keamanan,
                                sum(t_tagihan_lingkungan_detail.nilai_kebersihan) as nilai_kebersihan,
                                
                                sum(t_pembayaran_detail.nilai_tagihan - ( ( t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn ) / ( 100+t_pembayaran_detail.nilai_ppn ) )) AS nilai_tagihan,
                                sum(( ( t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn ) / ( 100+t_pembayaran_detail.nilai_ppn ) )) AS nilai_ppn,

                                sum(t_pembayaran_detail.nilai_diskon) as nilai_diskon,
                                sum(t_pembayaran_detail.nilai_tagihan) as total_tagihan,
                                sum(isnull( t_pembayaran_detail.bayar, t_pembayaran_detail.bayar_deposit )) AS nilai_bayar ")
                        ->from("t_pembayaran_detail")
                        ->distinct()
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("unit",
                                "unit.id = t_pembayaran.unit_id",
                                "LEFT")
                        ->join("blok",
                                "blok.id = unit.blok_id",
                                "LEFT")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id",
                                "LEFT")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id",
                                "LEFT")
                        ->join("t_tagihan_lingkungan",
                                "t_tagihan_lingkungan.id = t_pembayaran_detail.tagihan_service_id")
                        ->join("t_tagihan_lingkungan_detail",
                                "t_tagihan_lingkungan_detail.t_tagihan_lingkungan_id = t_tagihan_lingkungan.id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id ")
                        ->where("service.service_jenis_id", $jns_service)
                        ->where("unit.project_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");
        
        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");
        }else{
            $query = $query->where("t_pembayaran.cara_pembayaran_id", $cara_bayar);
            $query = $query->where("t_pembayaran_detail.bayar > 0");
        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan.id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok.id",$blok);
        }
        $result = $query->get()->row();
        $data->footer[0] = 6;
        $data->footer[1] = $result;
        $data->jns_service = $jns_service;
        $data->cara_bayar = $cara_bayar;
        return $data;
    }
    public function getAir($kawasan,$blok,$periode_awal,$periode_akhir,$cara_bayar,$jns_service)
    {
        $project = $this->m_core->project();
        $periode_awal = substr($periode_awal,6,4)."-".substr($periode_awal,3,2)."-".substr($periode_awal,0,2);
        $periode_akhir = substr($periode_akhir,6,4)."-".substr($periode_akhir,3,2)."-".substr($periode_akhir,0,2);
       
        $query = $this->db
                        ->select("
                                kawasan.code as kawasan,
                                blok.code as blok,
                                unit.no_unit,
                                isnull(kwitansi_referensi.no_kwitansi,'-') as no_kwitansi,
                                t_tagihan_air.periode as periode,
                                CONVERT(date,t_pembayaran.tgl_bayar) as tgl_bayar,
                                t_pembayaran_detail.nilai_denda,
                                
                                (t_pencatatan_meter_air.meter_akhir - t_pencatatan_meter_air.meter_awal) as pemakaian,
                                
                                t_pembayaran_detail.nilai_tagihan - ((t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn) / (100+t_pembayaran_detail.nilai_ppn)) as nilai_tagihan,
                                ((t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn) / (100+t_pembayaran_detail.nilai_ppn)) as nilai_ppn,	
                                t_pembayaran_detail.nilai_diskon,
                                t_pembayaran_detail.nilai_tagihan as total_tagihan,
                                isnull(t_pembayaran_detail.bayar,t_pembayaran_detail.bayar_deposit) as nilai_bayar")
                        ->from("t_pembayaran_detail")
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("unit",
                                "unit.id = t_pembayaran.unit_id",
                                "LEFT")
                        ->join("blok",
                                "blok.id = unit.blok_id",
                                "LEFT")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id",
                                "LEFT")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id",
                                "LEFT")
                        ->join("t_tagihan_air",
                                "t_tagihan_air.id = t_pembayaran_detail.tagihan_service_id")
                        ->join("t_tagihan_air_detail",
                                "t_tagihan_air_detail.t_tagihan_air_id = t_tagihan_air.id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id ")
                        ->join("t_pencatatan_meter_air",
                                "t_pencatatan_meter_air.unit_id = unit.id
                                AND t_pencatatan_meter_air.periode = t_tagihan_air.periode")
                        ->distinct()
                        ->where("service.service_jenis_id", $jns_service)
                        ->where("unit.project_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");
        
        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");
        }else{
            $query = $query->where("t_pembayaran.cara_pembayaran_id", $cara_bayar);
            $query = $query->where("t_pembayaran_detail.bayar > 0");
        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan.id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok.id",$blok);
        }
        $data = (object)[];
        $data->header=["Kode Kawasan","Kode Blok","No Unit" , "No. Kwitansi", "Periode", "Tanggal Bayar", "Denda", 
                        "Pemakaian", "Tagihan", "PPN", "Disc","Total Tagihan","Total Bayar"];
        // $data->header=["Kode Kawasan","Kode Blok","No Unit","No. Bukti", "No. Kwitansi", "Periode", "Pakai (m3)", "Tanggal Bayar", "Nilai Admin", "Denda", 
        //                 "Pemakaian", "Disc", "Total Bayar"];
        $result = $query->get()->result();
        // echo("<pre>");
        //         print_r($result);
        // echo("</pre>");
        // echo("<pre>");
        //         print_r($this->db->last_query());
        // echo("</pre>");
        
        
        $data->isi = $result;

        if($cara_bayar==0){
            $cara_pembayaran_name = "Deposit";
        }else{
            $cara = $this->db
                            ->select("CONCAT(cara_pembayaran.name,' ',bank.name) as gabungan")
                            ->from("cara_pembayaran")
                            ->join("bank",
                                    "bank.id = cara_pembayaran.bank_id", "LEFT")
                            ->where("cara_pembayaran.id",$cara_bayar)->get()->row()->gabungan;
            $cara_pembayaran_name = $cara;
        }
        $pembayaran_name = "Sub Total Transaksi Air - ".$cara_pembayaran_name;
        $data->judul_rekap = $pembayaran_name;
        if($jns_service==1){
            $jns_service = $this->db->select("id")->from("service_jenis")->where("id",$jns_service)->get()->row()->id;
        }

        $query = $this->db
                        ->select("
                                sum(t_pembayaran_detail.nilai_denda) as nilai_denda,
            
                                sum(t_pencatatan_meter_air.meter_akhir - t_pencatatan_meter_air.meter_awal) as pemakaian,

                                
                                sum(t_pembayaran_detail.nilai_tagihan - ( ( t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn ) / ( 100+t_pembayaran_detail.nilai_ppn ) )) AS nilai_tagihan,
                                sum(( ( t_pembayaran_detail.nilai_tagihan * t_pembayaran_detail.nilai_ppn ) / ( 100+t_pembayaran_detail.nilai_ppn ) )) AS nilai_ppn,
                                sum(t_pembayaran_detail.nilai_diskon) as nilai_diskon,
                                sum(t_pembayaran_detail.nilai_tagihan) as total_tagihan,
                                sum(isnull( t_pembayaran_detail.bayar, t_pembayaran_detail.bayar_deposit )) AS nilai_bayar ")
                        ->from("t_pembayaran_detail")
                        ->join("t_pembayaran",
                                "t_pembayaran.id = t_pembayaran_detail.t_pembayaran_id")
                        ->join("unit",
                                "unit.id = t_pembayaran.unit_id",
                                "LEFT")
                        ->join("blok",
                                "blok.id = unit.blok_id",
                                "LEFT")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id",
                                "LEFT")
                        ->join("kwitansi_referensi",
                                "kwitansi_referensi.id = t_pembayaran_detail.kwitansi_referensi_id",
                                "LEFT")
                        ->join("t_tagihan_air",
                                "t_tagihan_air.id = t_pembayaran_detail.tagihan_service_id")
                        ->join("t_tagihan_air_detail",
                                "t_tagihan_air_detail.t_tagihan_air_id = t_tagihan_air.id")
                        ->join("service",
                                "service.id = t_pembayaran_detail.service_id ")
                        ->join("t_pencatatan_meter_air",
                                "t_pencatatan_meter_air.unit_id = unit.id
                                AND t_pencatatan_meter_air.periode = t_tagihan_air.periode")
                        ->distinct()
                        ->where("service.service_jenis_id", $jns_service)
                        ->where("unit.project_id",$project->id)
                        ->where("t_pembayaran.tgl_bayar >= '$periode_awal 00:00:00.000'")
                        ->where("t_pembayaran.tgl_bayar <= '$periode_akhir 23:59:59.000'");
        
        if($cara_bayar==0){
            $query = $query->where("t_pembayaran_detail.bayar = 0");
        }else{
            $query = $query->where("t_pembayaran.cara_pembayaran_id", $cara_bayar);
            $query = $query->where("t_pembayaran_detail.bayar > 0");
        }
        if($kawasan != 'all'){
            $query = $query->where("kawasan.id",$kawasan);
        }if($blok != 'all'){
            $query = $query->where("blok.id",$blok);
        }
        $result = $query->get()->row();
        $data->footer[0] = 6;
        $data->footer[1] = $result;
        $data->jns_service = $jns_service;
        $data->cara_bayar = $cara_bayar;
        
        return $data;
    }
    
}