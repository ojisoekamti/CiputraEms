<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_paket_loi extends CI_Model
{

    public function get()
    {
        $query = $this->db->query("
            SELECT * FROM paket_tvi
        ");
        return $query->result_array();
    }

    public function get_all()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT 
            paket_loi.*,
            jenis_loi.nama as nama_jenis
        FROM paket_loi
            JOIN jenis_loi ON jenis_loi.id = paket_loi.jenis_loi_id         
        WHERE paket_loi.[delete] = 0 order by id desc
        ");
        return $query->result_array();
    }

    public function getSelect($id)
    {
        return $this->db
                    ->select("
                    jenis_loi.id as jenis,
                    paket_loi.*")
                    ->from("paket_loi")
                    ->join("jenis_loi",
                            "jenis_loi.id = paket_loi.jenis_loi_id","LEFT")
                    ->where("paket_loi.id",$id)
                    ->get()->row();
    }

    public function get_kategori()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT
            id,
            kode,
            nama
        FROM kategori_loi
            WHERE project_id = $project->id and active = 1
        ");
        return $query->result_array();
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
    
    public function get_paket_detail($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        // $query = $this->db->query("
        //     SELECT  *  FROM range_air_detail
        //     WHERE range_air_id = $id 
        //     order by  id asc
        // ");

        $query = $this->db
                            ->select("paket_loi_item.item_loi_id as item,
                                    paket_loi_item.id,
                                    paket_loi_item.volume,
                                    paket_loi_item.status_item,
                                    paket_loi_item.paket_id,
                                    item_loi.satuan,
                                    item_loi.harga_satuan")
                            ->from("paket_loi_item")
                            ->join("item_loi",
                                    "item_loi.id = paket_loi_item.item_loi_id")
                            ->where("paket_id",$id)
                            ->order_by("id","ASC");
		return $query->get()->result();
		
	}

    public function get_item()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("*")
                            ->from("item_loi")
                            ->order_by("id","desc");
        return $query->get()->result_array();
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
        $project = $this->m_core->project();

        $query = $this->db->query("
            select 
                kategori_loi.kode as [Kode],
                kategori_loi.nama as [Nama],
                case 
                    when kategori_loi.active = 1 then 'Aktif' 
                    else 'Tidak Aktif' 
                end as Aktif, 
                case 
                    when kategori_loi.[delete] = 1 then 'Ya' 
                    else 'Tidak' 
                end as [Delete] 
            from kategori_loi
            WHERE kategori_loi.id = $id
            AND kategori_loi.project_id = $project->id
        ");
        $row = $query->row();
        return $row;
    }
    
    public function save($data){
        $data = (object)$data;
        $this->load->model('m_log');
        //cek data double dari segi username dan nama
        $return = (object)[];
        $return->message = "";
        $return->status = false;
        
        $this->db->where('kode', $data->kode);
        $this->db->from('paket_loi');
        
        // validasi double name
        if ($this->db->count_all_results() > 0) {
            $return->message = "Kode sudah di gunakan";
            return $return;
        }
        $data->biaya_registrasi = $this->m_core->currency_to_number($data->biaya_registrasi);
        $data->harga_jasa = $this->m_core->currency_to_number($data->harga_jasa);
        $data->biaya_prakiraan = $this->m_core->currency_to_number($data->biaya_prakiraan);
        $data->deposit_min = $this->m_core->currency_to_number($data->deposit_min);
        $data->active = 1;
        $data->delete = 0;
        $this->db->insert('paket_loi',$data);
        $id = $this->db->insert_id();

        if (isset($data->nama_item))
        {
            for($i= 0;$i<count($data->nama_item);$i++) {            
                $nama_item[$i]  =  $data->nama_item[$i];  
                $volume[$i] =  $this->m_core->currency_to_number($data->volume[$i]);
                $status_item[$i] = $data->status_item[$i];
                
                $dataItem = [
                    'item_loi_id'  => $nama_item[$i],
                    'volume'       => $volume[$i],
                    'paket_id'     => $id,
                    'status_item'  => $status_item[$i]
                ];
                    
                $this->db->insert('paket_loi_item', $dataItem);
                $dataLog = $this->get_log($this->db->insert_id());
                $this->m_log->log_save('paket_loi_item',$this->db->insert_id(),'Tambah',$dataLog);

            }
        }
        $dataLog = $this->get_log($id);
        $this->m_log->log_save('paket_loi',$id,'Tambah',$dataLog);
        $return->status = true;        
        $return->message = "Data berhasil di tambah";
        return $return;
    }

    public function edit($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $data =
            [
                'group_tvi_id'                   => $dataTmp['group'],
                'code'                           => $dataTmp['kode'],
                'name'                           => $dataTmp['nama_paket'],
                'bandwidth'                      => $this->m_core->currency_to_number($dataTmp['bandwith']),
                // 'harga_hpp'                      => $this->m_core->currency_to_number($dataTmp['hpp']),
                'harga_jual'                     => $this->m_core->currency_to_number($dataTmp['harga_jual']),
                'biaya_pasang_baru'              => $this->m_core->currency_to_number($dataTmp['biaya_pasang']),
                'biaya_registrasi'               => $this->m_core->currency_to_number($dataTmp['biaya_registrasi']),
                'description'                    => $dataTmp['keterangan'],
                'active'                         => $dataTmp['active'] ? 1 : 0,
            ];

        // validasi apakah user dengan project $project boleh edit data ini
        $this->db->join('group_tvi', 'group_tvi.id = paket_tvi.group_tvi_id');
        $this->db->where('group_tvi.project_id', $project->id);
        $this->db->from('paket_tvi');
        if ($this->db->count_all_results() != 0) {
            $this->db->where('code', $data['code'])->where('id !=', $dataTmp['id']);
            $this->db->from('paket_tvi');
            // validasi double
            if ($this->db->count_all_results() == 0) {

                $before = $this->get_log($dataTmp['id']);
                $this->db->where('id', $dataTmp['id']);
                $this->db->update('paket_tvi', $data);
                $after = $this->get_log($dataTmp['id']);

                $diff = (object)(array_diff_assoc((array)$after, (array)$before));
                $tmpDiff = (array)$diff;
                if ($tmpDiff) {
                    $this->m_log->log_save('paket_tvi', $dataTmp['id'], 'Edit', $diff);
                    return 'success';
                } else return 'Tidak Ada Perubahan';
            } else return 'double';
        }
    }

    public function delete($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        // validasi apakah user dengan project $project boleh edit data ini

        // validasi Cara Pembayaran

        $before = $this->get_log($dataTmp['id']);
        $this->db->where('id', $dataTmp['id']);
        $this->db->update('paket_tv', ['delete' => 1]);
        $after = $this->get_log($dataTmp['id']);

        $diff = (object)(array_diff((array)$after, (array)$before));
        $tmpDiff = (array)$diff;

        if ($tmpDiff) {
            $this->m_log->log_save('paket_tv', $dataTmp['id'], 'Edit', $diff);

            return 'success';
        } else {
            return 'Tidak Ada Perubahan';
        }
    }
}

