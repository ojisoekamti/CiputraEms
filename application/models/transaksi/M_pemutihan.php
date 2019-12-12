<?php
defined("BASEPATH") or exit("No direct script access allowed");

class m_pemutihan extends CI_Model
{

    
    public function get_kawasan(){
        $project = $this->m_core->project();

        return $this->db
                ->select("
                        id,
                        code,
                        name")
                ->from("kawasan")
                ->where("project_id",$project->id)
                ->get()->result();
    }
    public function get_blok($kawasan_id){
        if($kawasan != "all"){
            return $this->db
                        ->select("
                                id,
                                code,
                                name")
                        ->from("blok")
                        ->where("id",$kawasan_id)
                        ->get()->result();
        }
        return $this->db
                    ->select("
                            id,
                            code,
                            name")
                    ->from("blok")
                    ->where("id",$kawasan_id)
                    ->get()->result();
    }
    public function get_service(){
        return $this->db
                    ->select("id,jenis_service as name")
                    ->from("service_jenis")
                    ->get()->result();
    }
    public function get_unit($blok_id,$kawasan_id,$periode_awal,$periode_akhir,$metode_tagihan)
    {
        $periode_awal = substr($periode_awal,3,4)."-".substr($periode_awal,0,2)."-01";
        $periode_akhir = substr($periode_akhir,3,4)."-".substr($periode_akhir,0,2)."-01";
        $project = $this->m_core->project();
        $query = $this->db
                ->select("
                        unit_id,
                        kawasan.name as kawasan,
                        blok.name as blok,
                        unit.no_unit,
                        pemilik.name as pemilik")
                ->from("v_sales_force_bill")
                ->join("unit",
                        "unit.id = v_sales_force_bill.unit_id")
                ->join("blok",
                        "blok.id = unit.blok_id")
                ->join("kawasan",
                        "kawasan.id = blok.kawasan_id")
                ->join("customer as pemilik",
                        "pemilik.id = unit.pemilik_customer_id")
                ->where("v_sales_force_bill.periode >= '$periode_awal'")
                ->where("v_sales_force_bill.periode <= '$periode_akhir'")
                ->where("unit.project_id",$project->id)
                ->group_by("
                        unit_id,
                        kawasan.name,
                        blok.name,
                        unit.no_unit,
                        pemilik.name");
        $service_air        = false;
        $service_lingkungan = false;
        foreach ($metode_tagihan as $v) {
            if($v == 2){
                $service_air = true;
            }elseif($v==1){
                $service_lingkungan = true;
            }
        }
        if($service_air && $service_lingkungan){
            $query = $query
                    ->select("
                        sum(tagihan_air_tanpa_ppn
                        +tagihan_lingkungan_tanpa_ppn) as nilai_pokok,
                        sum(denda_lingkungan+denda_air) as denda,
                        sum(tagihan_air_tanpa_ppn
                        +tagihan_lingkungan_tanpa_ppn
                        +denda_lingkungan
                        +denda_air) as total, 
                    ");
        }elseif($service_air){
            $query = $query
                    ->select("
                        sum(tagihan_air_tanpa_ppn) as nilai_pokok,
                        sum(denda_air) as denda,
                        sum(tagihan_air_tanpa_ppn
                        +denda_air) as total
                    ");
        }elseif($service_lingkungan){
            $query = $query
                    ->select("
                        sum(tagihan_lingkungan_tanpa_ppn) as nilai_pokok,
                        sum(denda_lingkungan) as denda,
                        sum(tagihan_lingkungan_tanpa_ppn
                        +denda_lingkungan) as total
                    ");
        }else{
            $query = $query
                    ->select("
                        0 as nilai_pokok,
                        0 as denda,
                        0 as total
                    ");
        }
        if($blok_id != 'all'){
            $query = $query->where("blok.id",$blok_id);
        }
        if($kawasan_id != 'all'){
            $query = $query->where("kawasan.id",$kawasan_id);
        }
        return $query->get()->result();
                                        
    }
    public function save($data,$nama_file){

        $this->db->trans_start();
        $project = $this->m_core->project();
        $data = (object)$data;
        $data->nama_file = $nama_file;
        $date = date("Y-m-d");
        $create_user_id = $this->db->select("id")
                                    ->from("user")
                                    ->where("username", $this->session->userdata["username"])
                                    ->get()->row()->id;
        $create_jabatan_id = $this->db->select("jabatan_id")
                                    ->from("group_user")
                                    ->where("id", $this->session->userdata["group"])
                                    ->get()->row()->jabatan_id;

        // $approval = (object)[];
        // status 
        // $approval->status_approval = 0;
        // $approval->approval_jenis_id = 1;
        // $approval->create_user_id = $create_user_id;
        // // $approval->approval_user_id = ;
        // $approval->tgl_tambah = $date;
        
        
        // $approval->tgl_approve = ;
        // $approval->create_jabatan_id = ;
        // $approval->approval_jabatan_id = ;
        
        $pemutihan = (object)[];
        $pemutihan->project_id      = $project->id;
        $pemutihan->periode_awal    = substr($data->periode_awal,3,4)."-".substr($data->periode_awal,0,2)."-"."01";
        $pemutihan->periode_akhir   = substr($data->periode_akhir,3,4)."-".substr($data->periode_akhir,0,2)."-"."01";
        $pemutihan->masa_awal       = substr($data->masa_awal,6,4)."-".substr($data->masa_awal,3,2)."-".substr($data->masa_awal,0,2);
        $pemutihan->masa_akhir      = substr($data->masa_akhir,6,4)."-".substr($data->masa_akhir,3,2)."-".substr($data->masa_akhir,0,2);
        $pemutihan->description     = $data->description;
        $pemutihan->tgl_tambah      = $date;
        $pemutihan->tambah_user_id  = $create_user_id;
        $pemutihan->approval_id     = 0;
        $pemutihan->status          = 0;
        $pemutihan->file            = $data->nama_file;
        $pemutihan->code            = $data->kode;
        $this->db->insert("pemutihan",$pemutihan);
        $id_pemutihan = $this->db->insert_id();

        $pemutihan_nilai                        = (object)[];
        $pemutihan_nilai->pemutihan_id          = $id_pemutihan;
        $pemutihan_nilai->nilai_tagihan_type    = $data->nilai_tagihan_type;
        $pemutihan_nilai->nilai_tagihan         = str_replace(",","",$data->nilai_tagihan);
        $pemutihan_nilai->nilai_denda_type      = $data->nilai_denda_type;
        $pemutihan_nilai->nilai_denda           = str_replace(",","",$data->nilai_denda);
        $pemutihan_nilai->perkiraan_pemutihan_nilai_tagihan     = str_replace(",","",$data->perkiraan_pemutihan_nilai_tagihan);
        $pemutihan_nilai->perkiraan_pemutihan_nilai_denda       = str_replace(",","",$data->perkiraan_pemutihan_nilai_denda);
        $pemutihan_nilai->perkiraan_pemutihan_total             = str_replace(",","",$data->perkiraan_pemutihan_total);
        $this->db->insert("pemutihan_nilai",$pemutihan_nilai);

        $this->load->model('Setting/Akun/m_permission_dokumen');
        $permission = $this->m_permission_dokumen->get_wewenang($project->id,"pemutihan",$pemutihan_nilai->perkiraan_pemutihan_total);

        echo("<pre>");
            print_r($permission);
        echo("</pre>");
        
        $approval           = (object)[];
        $approval_detail    = (object)[];
        
        $approval->status_dokumen       = 0;
        $approval->status_request       = 0;
        
        $approval->create_user_id       = $create_user_id;
        $approval->tgl_tambah           = date("Y-m-d H:i:s.000");
        $approval->dokumen_jenis_id     = $this->db->select("id")->from("dokumen_jenis")->where("code","pemutihan")->get()->row()->id;
        $approval->source_id            = $id_pemutihan;
        $approval->create_jabatan_id    = $create_jabatan_id;
        $approval->project_id           = $project->id;
        $approval->dokumen_code         = $data->kode;
        $approval->dokumen_nilai        = str_replace(",","",$data->perkiraan_pemutihan_total);
        $tmp = $this->db->select("jarak_approve")
                ->from("permission_dokumen")->where("jabatan_id","$create_jabatan_id")->where("tipe",0)->where("project_id",$project->id)->get()->row();
        if($tmp){
            $approval->jarak_request_closed    =  (int)$tmp->jarak_approve;
            $approval->tgl_closed           =  date('Y-m-d',strtotime(date("Y/m/d") . "+".($approval->jarak_request_closed+1)." days"));
            $approval->status_approval = 0;
            $this->db->insert("approval",$approval);


            
            $approval_detail->approval_id   = $this->db->insert_id();
            // $approval_detail->mengajukan_wewenang  = 0;
            $approval_detail->status_approve  = 0;
            

            $jabatan_approval = [];
            // foreach ($permission->mengetahui as $k => $v) {
            //     $approval_detail->approval_jabatan_id  = $v;
            //     $approval_detail->lama_approve  = $permission->mengetahui_jarak_approve[$k];
                
            //     $tmp = explode(",",$v);
            //     foreach ($tmp as $k2=> $v2) {
            //         array_push($jabatan_approval,$v2);
            //     }
            //     $this->db->insert("approval_detail",$approval_detail);
            // }
            // $approval_detail->mengajukan_wewenang  = 1;

            foreach ($permission as $k => $v) {
                $approval_detail->jarak_approve  = $v->jarak_approve;

                $tmp = explode(",",$v->jabatan_id);
                $tmp2 = [];
                foreach ($tmp as $v2) {
                    if($v2!=$create_jabatan_id)
                        array_push($tmp2,$v2);
                }
                $approval_detail->approval_jabatan_id  = implode(",",$tmp2);
                $this->db->insert("approval_detail",$approval_detail);
            }

            echo("jabatan_approval<pre>");
                print_r($jabatan_approval);
            echo("</pre>");
            
            $email_approval = $this->db->select("email, user.name")
                        ->from("group_user")
                        ->join("user",
                                "user.id = group_user.user_id")
                        ->where_in("jabatan_id",$create_jabatan_id)
                        ->where("group_user.project_id",$project->id)
                        ->where("email is not null")
                        ->distinct()->get()->result();
            echo("<pre>");
                print_r($email_approval);
            echo("</pre>");
            $pemutihan_service                      = (object)[];
            $pemutihan_service->pemutihan_id        = $id_pemutihan;
            foreach($data->service_jenis as $v){
                $pemutihan_service->service_id          = $this->db->select("id")
                                                            ->from("service")
                                                            ->where("project_id",$project->id)
                                                            ->where("service_jenis_id",$v)
                                                            ->get()->row();
                if($pemutihan_service->service_id){
                    $pemutihan_service->service_id          = $pemutihan_service->service_id->id;
                    $pemutihan_service->service_jenis_id    = $v;
                    $this->db->insert("pemutihan_service",$pemutihan_service);
                }
            }
            $pemutihan_unit                      = (object)[];
            $pemutihan_unit->pemutihan_id        = $id_pemutihan;
            foreach($data->unit_id as $v){
                $pemutihan_unit->unit_id          = $v;
                $this->db->insert("pemutihan_unit",$pemutihan_unit);
            }
            
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
            // print_r($config);
            // $this->db->selec
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
                                    ->where("approval.id",$approval_detail->approval_id)
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
            
            // $tmp = str_replace("{{Button_A}}",$unit->project,$tmp);
            // $parameter_delay = explode(";",$this->m_parameter_project->get($project->id,"delay_email"));
            // var_dump($parameter_delay);

            foreach ($email_approval as $k => $v) {
                // if($k!=0 && ($k+1)%$parameter_delay[0]==0){
                //     sleep($parameter_delay[1]);
                // }
                echo("Email $v->email");
                $tmp2 = str_replace("{{User}}",ucwords($v->name),$tmp);
                $this->email->clear(TRUE);
                $this->email->from($this->m_parameter_project->get($project->id,"smtp_user"), 'EMS Ciputra');
                $this->email->subject($this->m_parameter_project->get($project->id,"subjeck_email_approval"));
                $this->email->message($tmp2);
                // echo($v);
                $this->email->to($v->email);
                // echo("email<pre>");
                //     print_r($this->email);
                // echo("</pre>");
                // $this->email->attach("application/pdf/$result->name_file");

                if($this->email->send()){
                    echo("Success Kirim Email");
                    // $email_success++;
                }else{
                    echo("Gagal Kirim Email");
                }
            }    




            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
        return "Tidak Memiliki Izin";
    }

}
