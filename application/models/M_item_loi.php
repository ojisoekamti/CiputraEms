<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_item_loi extends CI_Model
{

    public function get_all()
    {
        $this->load->model('m_core');
        $query = $this->db
                            ->select("item_loi.*,
                                    jenis_loi.nama as nama_jenis")
                            ->from("item_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = item_loi.jenis_loi_id")
                            ->where("item_loi.delete",0);
        return $query->get()->result_array();
    }

    public function get_jenis()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("jenis_loi.*")
                            ->from("jenis_loi")
                            ->join("kategori_loi",
                                    "kategori_loi.id = jenis_loi.kategori_loi_id","LEFT")
                            ->where("kategori_loi.project_id",$project->id);
        return $query->get()->result_array();
    }

    public function getSelect($id)
    {
        return $this->db
                    ->select("
                    jenis_loi.id as jenis,
                    item_loi.*")
                    ->from("item_loi")
                    ->join("jenis_loi",
                            "jenis_loi.id = item_loi.jenis_loi_id","LEFT")
                    ->where("item_loi.id",$id)
                    ->get()->row();
    }

    public function cek($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
            SELECT * FROM paket_tvi WHERE id = $id 
        ");
        $row = $query->row();
        return isset($row) ? 1 : 0;
    }

    public function get_log($id)
    {
        $this->load->model('m_core');
        $query= $this->db
                        ->select("*")
                        ->from("item_loi")
                        ->where("id",$id)
                        ->get()->row();
        return $query;
    }
    
    public function save($data){
        $project = $this->m_core->project();
        $this->load->model('m_core');
        $this->load->model('m_log');
        $data = (object)$data;
        //cek data double dari segi username dan nama
        $return = (object)[];
        $return->message = "";
        $return->status = false;
        
        $this->db->where('nama', $data->nama);
        $this->db->from('item_loi');
        
        // validasi double name
        if ($this->db->count_all_results() > 0) {
            $return->message = "Nama sudah di gunakan";
        }
        $data->harga_satuan = $this->m_core->currency_to_number($data->harga_satuan);
        // $data->is_channel = implode(",",$data->is_channel);
        $data->delete = 0;
        $this->db->insert('item_loi',$data);
        $dataLog = $this->get_log($this->db->insert_id());
        $this->m_log->log_save('item_loi', $this->db->insert_id(), 'Tambah', $dataLog);
        $return->status = true;        
        $return->message = "Data item berhasil di tambah";        
        return $return;
    }

    public function edit($data){
        $data = (object)$data;
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $this->load->model('m_log');
        //cek data double dari segi username dan nama
        $return = (object)[];
        $return->message = "Data gagal di ubah";
        $return->status = false;
        
        $this->db->where('nama', $data->nama);
        $this->db->from('item_loi');
        // validasi double kode
        if ($this->db->count_all_results() > 0) {            
            $before = $this->get_log($data->id);
            $this->db->set('jenis_loi_id',$data->jenis_loi_id);
            $this->db->set('nama',$data->nama);
            $this->db->set('satuan',$data->satuan);
            $this->db->set('harga_satuan',$data->harga_satuan);
            $this->db->set('status_item',$data->status_item);
            $this->db->set('keterangan',$data->keterangan);
            $this->db->where('id',$data->id);
            $this->db->update('item_loi');
            $after = $this->get_log($data->id);
            $return->message = "Nama sudah di gunakan";        
        }
        $diff = (object) (array_diff_assoc((array) $after, (array) $before));
        $tmpDiff = (array) $diff;
        if ($tmpDiff) {
            $this->m_log->log_save('item_loi', $data->id, 'Edit', $diff);
        }
        $return->status = true;  
        $return->message = "Data berhasil di ubah";   
        return $return;
    }

    public function delete($dataTmp)
    {
        $this->load->model('m_log');
        
        $before = $this->get_log($dataTmp['id']);
        $this->db->where('id', $dataTmp['id']);
        $this->db->update('item_loi', ['delete' => 1]);
        $after = $this->get_log($dataTmp['id']);

        $diff = (object)(array_diff((array)$after, (array)$before));
        $tmpDiff = (array)$diff;

        if ($tmpDiff) {
            $this->m_log->log_save('item_loi', $dataTmp['id'], 'Edit', $diff);
        } 
        return 'success';
    }
}

