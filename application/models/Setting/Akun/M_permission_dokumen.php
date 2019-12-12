<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_permission_dokumen extends CI_Model
{
    public function get_wewenang($project_id,$dokumen_jenis_kode,$nilai){
        $result = $this->db->select("jabatan_id,
                                    jarak_approve")
                            ->from("permission_dokumen")
                            ->join("dokumen_jenis",
                                    "dokumen_jenis.id = permission_dokumen.dokumen_jenis_id")
                            ->where("dokumen_jenis.code",$dokumen_jenis_kode)
                            ->where("tipe",1)
                            ->where("project_id",$project_id)
                            ->where("nilai_awal <= $nilai")
                            ->order_by("permission_dokumen.id,permission_dokumen.nilai_awal")
                            ->get()->result();
        if(!$result){
            $result = $this->db->select("jabatan_id,
                                        jarak_approve")
                            ->from("permission_dokumen")
                            ->join("dokumen_jenis",
                                    "dokumen_jenis.id = permission_dokumen.dokumen_jenis_id")
                            ->where("dokumen_jenis.code",$dokumen_jenis_kode)
                            ->where("tipe",1)
                            ->where("project_id is null")
                            ->where("nilai_awal <= $nilai")
                            ->order_by("permission_dokumen.id,permission_dokumen.nilai_awal")
                            ->get()->result();
        }
        $data1 = [];
        $data2 = [];
        
        foreach ($result as $k=>$v) {
            $data1[$k] = $v->jabatan_id;
            $data2[$k] = $v->jarak_approve;
        }
        return $result;
    }
    public function get_mengetahui($project_id,$dokumen_jenis_kode){
        $result = $this->db->select("jabatan_id,
                                    jarak_approve")
                            ->from("permission_dokumen")
                            ->join("dokumen_jenis",
                                    "dokumen_jenis.id = permission_dokumen.dokumen_jenis_id")
                            ->where("dokumen_jenis.code",$dokumen_jenis_kode)
                            ->where("tipe",0)
                            ->where("project_id",$project_id)
                            ->order_by("permission_dokumen.id")
                            ->get()->result();
        if(!$result){
        $result = $this->db->select("jabatan_id,
                                    jarak_approve")
                            ->from("permission_dokumen")
                            ->join("dokumen_jenis",
                                    "dokumen_jenis.id = permission_dokumen.dokumen_jenis_id")
                            ->where("dokumen_jenis.code",$dokumen_jenis_kode)
                            ->where("tipe",0)
                            ->where("project_id is null")
                            ->order_by("permission_dokumen.id")
                            ->get()->result();
        }
        $data1 = [];
        $data2 = [];
        
        foreach ($result as $k=>$v) {
            $data1[$k] = $v->jabatan_id;
            $data2[$k] = $v->jarak_approve;
        }
        return (object)[
            "jabatan" => $data1,
            "jarak_approve" => $data2
            
        ];
    }
    public function get($dokumen_jenis_kode,$nilai){
        $project = $this->m_core->project();
        $mengetahui = $this->get_mengetahui($project->id,$dokumen_jenis_kode);
        $wewenang = $this->get_wewenang($project->id,$dokumen_jenis_kode,$nilai);

        
        return (object)[
            "mengetahui"    => $mengetahui->data1,
            "mengetahui_jarak_approve"    => $mengetahui->data2,
            "wewenang"      => $wewenang->data1,
            "wewenang_jarak_approve"      => $wewenang->data2
        ];
    }
    public function get_jabatan()
    {
        $project = $this->m_core->project();

        return $this->db
                        ->select("
                                id,
                                name
                        ")
                        ->from("jabatan")
                        ->get()->result();
    }
    public function get_view()
    {
        return $this->db
                        ->select("
                                id,
                                name,
                                code,
                                description
                                ")
                        ->from("dokumen_jenis")
                        ->get()->result();
    }
    public function get_by_id($id)
    {
        return $this->db
                        ->select("
                                id,
                                name,
                                code,
                                description
                                ")
                        ->from("dokumen_jenis")
                        ->where("id",$id)
                        ->get()->row();
    }
    public function get_range($id,$project_id,$tipe){
        $tmp =  $this->db
                        ->from("permission_dokumen")
                        ->where("dokumen_jenis_id",$id)
                        ->where("project_id",$project_id)
                        ->where("tipe",$tipe)
                        ->get()->result();
        // echo("<pre>");
        //     print_r($tmp);
        // echo("</pre>");
        // var_dump(explode(",",$tmp[0]->jabatan_id));
        return $tmp;
    }

    public function save($data,$project_id){
        
        $data = (object)$data;
        $tmp = (object)[];
        
        // echo("<pre>");
        //     print_r($data);
        // echo("</pre>");
        

        $return = (object)[];
        $return->message = "";
        $return->status = false;
        
        $tmp->dokumen_jenis_id = $data->id_dokumen;
        $tmp->project_id = $project_id;
        $tmp->tipe = 1;
        
        
        
        $this->db->where("dokumen_jenis_id",$data->id_dokumen);
        $this->db->where("project_id",$project_id);
        $this->db->delete("permission_dokumen");
        foreach ($data->jabatan_user as $k=>$v) {
            $tmp->nilai_awal = str_replace(",","",$data->range_awal[$k]);
            $tmp->nilai_akhir = $k==(count($data->jabatan_user)-1)?'-1':str_replace(",","",$data->range_akhir[$k]);
            $tmp->jarak_approve = $data->jarak_approve[$k];
            $tmp->jabatan_id = $v;
            // var_dump($v);
            $this->db->insert("permission_dokumen",$tmp);

           


            // foreach ($tmp2 as $k2 => $v2) {
            //     $tmp->jabatan_id = str_replace(",","",$v2);                
            //     $this->db->insert("permission_dokumen",$tmp);
            // }
        }
        $tmp2 = (object)[];
        $tmp2->dokumen_jenis_id = $data->id_dokumen;
        $tmp2->project_id = $project_id;
        $tmp2->tipe = 0;
        $tmp2->nilai_awal = 0;
        $tmp2->nilai_akhir = 0;

        foreach ($data->jabatan_user_mengetahui as $k=>$v) {
            $tmp2->jarak_approve = $data->jarak_approve_mengetahui[$k];
            $tmp2->jabatan_id = $v;
            // var_dump($v);

            $this->db->insert("permission_dokumen",$tmp2);
        }

        $return->status = true;        
        $return->message = "Data permission dokumen berhasil di tambah";        
        return $return;
    }
   
}
