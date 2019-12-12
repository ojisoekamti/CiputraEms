<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_unit_sewa extends CI_Model {

    public function get()
		
    {
        $project = $this->m_core->project();
        return $this->db->select("
                            kawasan.name as kawasan,
                            blok.name as blok,
                            unit.no_unit,
                            harga_sewa.name as harga_sewa,
                            unit_sewa.tgl_mulai
                        ")
                        ->from("unit_sewa")
                        ->join("unit",
                                "unit.id = unit_sewa.unit_id")
                        ->join("blok",
                                "blok.id = unit.blok_id")
                        ->join("kawasan",
                                "kawasan.id = blok.kawasan_id")
                        ->join("harga_sewa",
                                "harga_sewa.id = unit_sewa.harga_sewa_id")
                        ->where("unit_sewa.project_id",$project->id)
                        ->get()->result();
    }

    public function get_range_harga_sewa(){
	    $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT * FROM harga_sewa where 
            project_id = $project->id 
            and [delete] = 0 order by id desc
        ");
        return $query->result();
    }
	public function save($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $data = [
            'project_id'    => $project->id,
            'unit_id'       => $dataTmp['unit'],
            'harga_sewa_id' => $dataTmp['range_harga'],
            'tgl_mulai'     => isset($dataTmp['tgl'])?substr($dataTmp['tgl'],6,4)."-".substr($dataTmp['tgl'],3,2)."-".substr($dataTmp['tgl'],0,2):null

        ];

        $this->db->where('project_id', $data['project_id']);
        $this->db->where('unit_id', $data['unit_id']);
        $this->db->from('unit_sewa');

        // validasi double
        if($this->db->count_all_results()==0){ 
            $this->db->insert('unit_sewa', $data);
            return 1;
        }else return 0;
        
        
    }	
}