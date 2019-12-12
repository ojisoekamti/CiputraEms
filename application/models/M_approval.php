<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_approval extends CI_Model
{
    public function get_view()
    {
        $approval_id = []; 
        
        $jabatan_id = $this->db->select("jabatan_id")
                                    ->from("group_user")
                                    ->where("id", $this->session->userdata["group"])
                                    ->get()->row()->jabatan_id;
        $project = $this->m_core->project();
        $dataCreate = $this->db->select("id")
                                ->from("approval")
                                ->where("approval.create_jabatan_id",$jabatan_id)
                                ->get()->result();
        foreach ($dataCreate as $v) {
            array_push($approval_id,$v->id);
        }
        $dataWewenang = $this->db->select("id")
                                ->from("approval")
                                ->where("approval.create_jabatan_id",$jabatan_id)
                                ->get()->result();

        $dataWewenang = $this->db->select("
                                approval.id,
                                approval_detail.approval_jabatan_id as jabatan_id
                                ")
                        ->from("approval")
                        ->join("dokumen_jenis",
                                "dokumen_jenis.id = approval.dokumen_jenis_id")
                        ->join("user",
                                "user.id = approval.create_user_id")
                        ->join("approval_status",
                                "approval_status.id = approval.status_dokumen")
                        ->join("approval_detail",
                                "approval_detail.approval_id = approval.id")
                        ->where("approval.project_id",$project->id)
                        ->where("approval.status_request",1)
                        ->get()->result();
        $data = [];
        $tmp = 0; // untuk pemisahan jabatan
        $tmp2 = 0; // untuk tidak double, berisi id
        foreach ($dataWewenang as $k => $v) {
            $tmp = explode(",",$v->jabatan_id);
            foreach ($tmp as $k2 => $v2) {
                if($v2 == $jabatan_id && $tmp2 != $v->id ){
                    array_push($approval_id,$v->id);
                    $tmp2                   = $v->id;
                }
            }
        }
        if($approval_id){
        $data = $this->db->select("
                            approval.id,
                            approval.dokumen_code,
                            dokumen_jenis.name as dokumen_jenis,
                            approval.tgl_tambah,
                            approval_status.status_dokumen,
                            user.name as user_request
                            ")
                    ->from("approval")
                    ->join("dokumen_jenis",
                            "dokumen_jenis.id = approval.dokumen_jenis_id")
                    ->join("user",
                            "user.id = approval.create_user_id")
                    ->join("approval_status",
                            "approval_status.id = approval.status_dokumen")
                    ->where("approval.project_id",$project->id)
                    ->where_in("approval.id",$approval_id)
                    // ->where("approval.status_request",1)
                    ->get()->result();
        }

        return $data;
    }
    public function cek_permission_edit($id){
        $data = $this->get_view();
        foreach ($data as $v) {
            if($v->id == $id){
                return true;
            }
        }
        return false;
    }
    public function get_edit($id){
        $project = $this->m_core->project();

        $dokumen = $this->db->select("
                                dokumen_jenis.name as dokumen,
                                approval.dokumen_code,
                                user.name as request,
                                approval.dokumen_nilai,
                                approval.tgl_tambah,
                                approval.jarak_request_closed,
                                approval.tgl_closed,
                                approval.tgl_approve,
                                approval.status_dokumen,
                                status_dokumen.status_dokumen,
                                status_request.status_request,
                                status_request.id as status_request_id,
                                approval.create_user_id,
                                approval.create_jabatan_id")
                            ->from("approval")
                            ->join("dokumen_jenis",
                                    "dokumen_jenis.id = approval.dokumen_jenis_id")
                            ->join("user",
                                    "user.id = approval.create_user_id")
                            ->join("approval_status as status_dokumen",
                                    "status_dokumen.id = approval.status_dokumen")
                            ->join("approval_status as status_request",
                                    "status_request.id = approval.status_request")
                            ->where("approval.id",$id)
                            ->get()->row();
        // if($dokumen)
        $jabatan_id = $this->db->select("jabatan_id")
                                ->from("group_user")
                                ->where("id", $this->session->userdata["group"])
                                ->get()->row()->jabatan_id;    
        // var_dump($jabatan_id);
        $daftar_jabatan_tmp = $this->db->select("
                                    approval_detail.approval_jabatan_id as jabatan_id,
                                    approval_detail.status_approve,
                                    description,
                                    approval_detail.jarak_approve
                                ")
                                // approval_detail.mengetahui_wewenang,
                                ->from("approval_detail")
                                ->where("approval_detail.approval_id",$id)
                                ->order_by("approval_detail.id")
                                ->get()->result();
        $daftar_jabatan    = [];
        $jumlah_wewenang =(object)[
            "wewenang" => 0,
            "wewenang_approve" => 0
        ];
        // if($dokumen->status_approval==0)
        //     $tmp = "Create";
        // else if($dokumen->status_approval==1)
        //     $tmp = "Open";
        // else
        //     $tmp = "Cancel";
        $create = (object)[
            "hak_approve"       => $dokumen->status_request_id==0?2:0,
            "jabatan_name"      => $this->db->select("name")->from("jabatan")->where("id",$dokumen->create_jabatan_id)->get()->row()->name,
            "jabatan_id"      => $this->db->select("id")->from("jabatan")->where("id",$dokumen->create_jabatan_id)->get()->row()->id,
            "status"            => $dokumen->status_request,
            "status_id"         => $dokumen->status_request_id,
            "batas_waktu"       => $dokumen->jarak_request_closed,
            "deskripsi"         => 0,
        ];
        foreach ($daftar_jabatan_tmp as $k => $v) {            
            $daftar_jabatan[$k] = (object)[];
            $tmp = explode(",",$v->jabatan_id);
            $nama_jabatan_tmp = "";
            $id_jabatan_tmp = "";
            $daftar_jabatan[$k]->hak_approve = 0;
            foreach($tmp as $k2 => $v2){
                $cek_jabatan = $this->db->select("name")->from("jabatan")->where("id",$v2)->get()->row();
                if($cek_jabatan){
                    $nama_jabatan_tmp = $nama_jabatan_tmp.$cek_jabatan->name." / ";
                    $id_jabatan_tmp = $id_jabatan_tmp.$v2.",";
                    if($v2 == $jabatan_id && $v->status_approve == 0){
                        $daftar_jabatan[$k]->hak_approve = 1;                
                    }
                }

            }
            $daftar_jabatan[$k]->jabatan_id     = substr($id_jabatan_tmp,0,-1);
            $daftar_jabatan[$k]->jabatan_name   = substr($nama_jabatan_tmp,0,-3);
            if($v->status_approve == 0)
                $daftar_jabatan[$k]->status = "Belum di Approve";
            if($v->status_approve == 1)
                $daftar_jabatan[$k]->status = "Sudah di Approve";
            if($v->status_approve == 2)
                $daftar_jabatan[$k]->status = "Di Tolak";
            if($v->status_approve == 3)
                $daftar_jabatan[$k]->status = "Telat";
            $daftar_jabatan[$k]->status_id              = $v->status_approve;
            // $daftar_jabatan[$k]->mengetahui_wewenang    = $v->mengetahui_wewenang;
            $daftar_jabatan[$k]->batas_waktu            = $v->jarak_approve;
            $daftar_jabatan[$k]->deskripsi              = $v->description;
            
            // if($daftar_jabatan[$k]->mengetahui_wewenang == 0){
                // $jumlah_wewenang->mengetahui++;
                // if($v->status_approve == 1){
                //     $jumlah_wewenang->mengetahui_approve++;
                // }
            // }
            // if($daftar_jabatan[$k]->mengetahui_wewenang == 1){
            $jumlah_wewenang->wewenang++;
            if($v->status_approve == 1){
                $jumlah_wewenang->wewenang_approve++;
            }
            // }
        }
        $data = (object)[];
        $data->mengajukan       = $create;
        $data->wewenang         = $daftar_jabatan;
        $data->jumlah_wewenang  = $jumlah_wewenang;
        $data->dokumen          = $dokumen;
        $data->jabatan_id       = $jabatan_id;
        return $data;
        
    }
    public function mengajukan($id,$tipe){
        $jabatan_id = $this->db->select("user_id,jabatan_id")
                                    ->from("group_user")
                                    ->where("id", $this->session->userdata["group"])
                                    ->get()->row(); 
        $user_id    = $jabatan_id->user_id;
        $jabatan_id = $jabatan_id->jabatan_id;
        $project = $this->m_core->project();
        $date = date('Y-m-d H:i:s.000');

        if($tipe == 1){

            $query1 = $this->db->select("count(*) as c")
                        ->from("approval")
                        ->where("status_request",0)
                        ->where("status_dokumen",0)
                        ->where("id",$id)
                        ->where("tgl_closed <= ","$date")
                        ->get()->row()->c;
            $query2 = $this->db->select("count(*) as c")
                        ->from("approval")
                        ->where("status_request",0)
                        ->where("status_dokumen",0)
                        ->where("id",$id)->where("create_jabatan_id",$jabatan_id)->get()->row()->c;
            if($query1 > 0){
                return 0;
            }else if($query2 > 0){
                $this->db->set('status_request', 1);
                $this->db->set('status_dokumen', 1);
                $this->db->set('approve_user_id', $user_id);
                $this->db->set('approve_jabatan_id', $jabatan_id);
                $this->db->set('tgl_approve', $date);
                $this->db->where('id', $id);
                $this->db->update('approval');

                $jabatan_id = $this->db->select("approval_jabatan_id")
                                    ->from("approval_detail")
                                    ->where("approval_id",$id)
                                    ->order_by("id")
                                    ->get()->row()->approval_jabatan_id;
                $jabatan_id = explode(",",$jabatan_id);
                $email = $this->db->select("email, user.name")
                    ->from("group_user")
                    ->join("user",
                            "user.id = group_user.user_id")
                    ->where_in("jabatan_id",$jabatan_id)
                    ->where("group_user.project_id",$project->id)
                    ->where("email is not null")
                    ->distinct()->get()->result(); 
                 $this->load->model('Setting/m_parameter_project');
                $config = [
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'protocol'  => 'smtp',
                    'smtp_host' => $this->m_parameter_project->get($project->id,"smtp_host"),
                    'smtp_user' => $this->m_parameter_project->get($project->id,"smtp_user"),
                    'smtp_pass' => $this->m_parameter_project->get($project->id,"smtp_pass"),
                    'smtp_port' => $this->m_parameter_project->get($project->id,"smtp_port"),
                    'crlf'      => "\r\n",
                    'newline'   => "\r\n"
                ];
                $this->load->library('email',$config);
                $this->email->from($this->m_parameter_project->get($project->id,"smtp_user"), 'EMS Ciputra');
                $komponen = $this->db->select("
                                                dokumen_jenis.name as dokumen,
                                                approval.dokumen_code,
                                                user_create.name as user_create,
                                                approval.dokumen_nilai,
                                                approval.tgl_tambah")
                                        ->from("approval")
                                        ->join("dokumen_jenis",
                                                "dokumen_jenis.id = approval.dokumen_jenis_id")
                                        ->join("user as user_create",
                                                "user_create.id = approval.create_user_id")
                                        ->where("approval.id",$id)
                                        ->get()->row();
                $tmp = $this->m_parameter_project->get($project->id,"isi_email_approval");
                $tmp = str_replace("{{Dokumen}}",$komponen->dokumen,$tmp);
                $tmp = str_replace("{{Kode}}",$komponen->dokumen_code,$tmp);
                $tmp = str_replace("{{User_create}}",$komponen->user_create,$tmp);
                $tmp = str_replace("{{Nilai}}",number_format($komponen->dokumen_nilai),$tmp);
                $tmp = str_replace("{{Date_create}}",substr($komponen->tgl_tambah,0,10),$tmp);
                
                $tmp = str_replace("{{Button_V}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#169F85;border-radius:5px;color:white'> Login </a>",$tmp);
                $tmp = str_replace("{{Button_A}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#286090;border-radius:5px;color:white'> Approve </a>",$tmp);
                $tmp = str_replace("{{Button_R}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#286090;border-radius:5px;color:white'> Approve </a>",$tmp);
                $tmp = str_replace("{{Button_L}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#169F85;border-radius:5px;color:white'> Login </a>",$tmp);
                foreach ($email as $v) {
                    $tmp2 = str_replace("{{User}}",ucwords($v->name),$tmp);
                    $this->email->clear(TRUE);
                    $this->email->from($this->m_parameter_project->get($project->id,"smtp_user"), 'EMS Ciputra');
                    $this->email->subject($this->m_parameter_project->get($project->id,"subjeck_email_approval"));
                    $this->email->message($tmp2);
                    $this->email->to($v->email);
                    if($this->email->send()){
                    }else{
                    }                   
                }
                $approval_detail = $this->db->select("*")
                                            ->from("approval_detail")
                                            ->where("approval_id",$id)
                                            ->get()->result();
                if($approval_detail){
                    $newDate = "";
                    $jarak_sebelumnya = 0;
                    foreach ($approval_detail as $k => $v) {
                        $data = (object)[];
                        if($k==0){
                            $newDate = date('Y-09-01');
                            $data->status_kirim_email = 1;
                        }else{
                            $newDate = date('Y-m-d',strtotime($newDate . "+".(1+$jarak_sebelumnya)." days"));
                            $data->status_kirim_email = 0;
                        }
                        $jarak_sebelumnya = $v->jarak_approve;

                        $data->tgl_kirim_email = $newDate;
                        $this->db->set('tgl_kirim_email', $data->tgl_kirim_email);
                        $this->db->set('status_kirim_email', $data->status_kirim_email);
                        $this->db->where('id', $v->id);
                        $this->db->update('approval_detail');

                    }
                    $newDate = date('Y-m-d',strtotime($newDate . "+".(1+$jarak_sebelumnya)." days"));
                    $this->db->set('tgl_closed', $newDate);
                    $this->db->where('id', $v->id);
                    $this->db->update('approval');
                }
                return 1;
            }
        }else{

        }
    }
    public function approve($id,$description,$tipe){
        $jabatan_id = $this->db->select("user_id,jabatan_id")
                                    ->from("group_user")
                                    ->where("id", $this->session->userdata["group"])
                                    ->get()->row(); 

        $user_id    = $jabatan_id->user_id;
        $jabatan_id = $jabatan_id->jabatan_id;


        $project = $this->m_core->project();
        $date = date('Y-m-d H:i:s.000');

        $id_approval_detail_tmp = $this->db->select("
                                                id,
                                                approval_jabatan_id,
                                                jarak_approve
                                                ")
                                            ->from("approval_detail")
                                            ->where("approval_id",$id)
                                            ->where("status_approve",0)
                                            ->get()->result();
        $id_approval_detail = 0;
        $jarak_tgl_closed = 0;
        $jarak_tgl_closed2 = 0;

        $email_jabatan_id = [0];
        $get_email_jabatan_id = 0;
        foreach ($id_approval_detail_tmp as $v) {
            if($get_email_jabatan_id == 1){
                $tmp = explode(",",$v->approval_jabatan_id);
                foreach ($tmp as $v2) {
                    array_push($email_jabatan_id,$v2);
                }   
                $get_email_jabatan_id = 0;
            }
            if($id_approval_detail == 0){
                $tmp = explode(",",$v->approval_jabatan_id);
                foreach ($tmp as $v2) {
                    if($v2 == $jabatan_id){
                        $id_approval_detail = $v->id;
                        $get_email_jabatan_id = 1;
                    }
                }
            }else{
                $jarak_tgl_closed2 = $jarak_tgl_closed2 + ((int)$v->jarak_approve)+1;
            }
            $jarak_tgl_closed = $jarak_tgl_closed + ((int)$v->jarak_approve)+1;

        }
        if($tipe == 1){

            

            $this->db->set('approve_user_id', $user_id);
            $this->db->set('approve_jabatan_id', $jabatan_id);
            $this->db->set('tgl_approve', $date);
            $this->db->set('status_approve', 1);
            $this->db->set('status_kirim_email', 1);
            $this->db->set('description', $description);
            $this->db->where('id', $id_approval_detail);
            // var_dump("approve_user_id ".$user_id."<br>");
            // var_dump("approve_jabatan_id ".$jabatan_id."<br>");
            // var_dump("tgl_approve ".$date."<br>");
            // var_dump("status_approve 1<br>");
            // var_dump("status_kirim_email 1<br>");
            $this->db->update('approval_detail');


            
            $approve_semua = $this->db->select("
                                                        case
                                                            WHEN count(status_approve)=sum(convert(int,status_approve)) THEN 1
                                                            ELSE 0
                                                        END as c")
                                        ->from("approval_detail")
                                        ->where("approval_detail.approval_id ",$id)
                                        ->get()->row()->c;
            if($approve_semua == 1){
                $tabel_dokumen = $this->db->select("
                                                approval.source_id,
                                                dokumen_jenis.source_table")
                                        ->from("approval")
                                        ->join("dokumen_jenis",
                                                "dokumen_jenis.id = approval.dokumen_jenis_id")
                                        ->where("approval.id",$id)
                                        ->get()->row();
                $source_id = $tabel_dokumen->source_id;
                $tabel_dokumen = $tabel_dokumen->source_table;
                $this->db->set("status",1);
                $this->db->where("id",$source_id);
                $this->db->update($tabel_dokumen);
                
                $this->db->set("status_dokumen",3);
                $this->db->set('tgl_closed', date("Y-m-d"));
                $this->db->where("id",$id);
                $this->db->update("approval");
                
                return 1;
            }else{
                // untuk kirim email
                $email = $this->db->select("email, user.name")
                    ->from("group_user")
                    ->join("user",
                            "user.id = group_user.user_id")
                    ->where_in("jabatan_id",$email_jabatan_id)
                    ->where("group_user.project_id",$project->id)
                    ->where("email is not null")
                    ->distinct()->get()->result(); 
                $this->load->model('Setting/m_parameter_project');
                
                $config = [
                    'mailtype'  => 'html',
                    'charset'   => 'utf-8',
                    'protocol'  => 'smtp',
                    'smtp_host' => $this->m_parameter_project->get($project->id,"smtp_host"),
                    'smtp_user' => $this->m_parameter_project->get($project->id,"smtp_user"),
                    'smtp_pass' => $this->m_parameter_project->get($project->id,"smtp_pass"),
                    'smtp_port' => $this->m_parameter_project->get($project->id,"smtp_port"),
                    'crlf'      => "\r\n",
                    'newline'   => "\r\n"
                ];
                $this->load->library('email',$config);
                $this->email->from($this->m_parameter_project->get($project->id,"smtp_user"), 'EMS Ciputra');
                $komponen = $this->db->select("
                                                dokumen_jenis.name as dokumen,
                                                approval.dokumen_code,
                                                user_create.name as user_create,
                                                approval.dokumen_nilai,
                                                approval.tgl_tambah")
                                        ->from("approval")
                                        ->join("dokumen_jenis",
                                                "dokumen_jenis.id = approval.dokumen_jenis_id")
                                        ->join("user as user_create",
                                                "user_create.id = approval.create_user_id")
                                        ->where("approval.id",$id)
                                        ->get()->row();
                $tmp = $this->m_parameter_project->get($project->id,"isi_email_approval");
                $tmp = str_replace("{{Dokumen}}",$komponen->dokumen,$tmp);
                $tmp = str_replace("{{Kode}}",$komponen->dokumen_code,$tmp);
                $tmp = str_replace("{{User_create}}",$komponen->user_create,$tmp);
                $tmp = str_replace("{{Nilai}}",number_format($komponen->dokumen_nilai),$tmp);
                $tmp = str_replace("{{Date_create}}",substr($komponen->tgl_tambah,0,10),$tmp);
                
                $tmp = str_replace("{{Button_V}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#169F85;border-radius:5px;color:white'> Login </a>",$tmp);
                $tmp = str_replace("{{Button_A}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#286090;border-radius:5px;color:white'> Approve </a>",$tmp);
                $tmp = str_replace("{{Button_R}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#286090;border-radius:5px;color:white'> Approve </a>",$tmp);
                $tmp = str_replace("{{Button_L}}","<a href='http://ces.ciputragroup.com' style='text-decoration: none;line-height:6;padding:6px 12px;margin:5px;width:100px;background-color:#169F85;border-radius:5px;color:white'> Login </a>",$tmp);
                foreach ($email as $v) {
                    $tmp2 = str_replace("{{User}}",ucwords($v->name),$tmp);
                    $this->email->clear(TRUE);
                    $this->email->from($this->m_parameter_project->get($project->id,"smtp_user"), 'EMS Ciputra');
                    $this->email->subject($this->m_parameter_project->get($project->id,"subjeck_email_approval"));
                    $this->email->message($tmp2);
                    $this->email->to($v->email);
                    if($this->email->send()){
                    }else{
                    }                   
                }
                // end kirim email

                // update tgl closed
                
                $jarak_tgl_closed = $jarak_tgl_closed + ((int)$this->db->select("jarak_request_closed")
                                                            ->from("approval")
                                                            ->where("id",$id)
                                                            ->get()->row()->jarak_request_closed
                                                        )+1;
                $create_date = substr($this->db->select("tgl_tambah")
                                ->from("approval")
                                ->where("id",$id)
                                ->get()->row()->tgl_tambah,0,10);
                
                $crete_closed = date('Y-m-d',strtotime($create_date . "+".(1+$jarak_tgl_closed)." days"));

                $last_approve_date = (int)$this->db->select("tgl_closed")
                                        ->from("approval")
                                        ->where("id",$id)
                                        ->get()->row()->tgl_closed;
                $last_approve_closed = date('Y-m-d',strtotime($last_approve_date . "+".(1+$jarak_tgl_closed2)." days"));

                if(strtotime($crete_closed) < strtotime($last_approve_closed)){
                    $this->db->set('tgl_closed', $crete_closed);
                    // var_dump("crete_closed ".$crete_closed."<br>");

                }else{
                    $this->db->set('tgl_closed', $last_approve_closed);
                    // var_dump("last_approve_closed ".$last_approve_closed."<br>");

                }            
                $this->db->where('id', $id);

                $this->db->update('approval');
                return 1;
            }
        }else{
            // echo("ini");
            $this->db->set('approve_user_id', $user_id);
            $this->db->set('approve_jabatan_id', $jabatan_id);
            $this->db->set('tgl_approve', $date);
            $this->db->set('status_approve', 2);
            $this->db->set('description', $description);
            $this->db->where('id', $id_approval_detail);
            $this->db->update('approval_detail');
        }

    }
}
