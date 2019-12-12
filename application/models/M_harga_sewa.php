<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_harga_sewa extends CI_Model {

    public function get()
		
    {
		
	    $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT * FROM harga_sewa where 
            project_id = $project->id 
            and [delete] = 0 order by id desc
        ");
        return $query->result_array();
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
    public function getSelect($id){
        $this->load->model('m_core');
        $project = $this->m_core->project();
        
        $query = $this->db->query("
		    SELECT * FROM harga_sewa 
			WHERE id = $id
            AND project_id = $project->id
        ");
        $row = $query->row();
        return $row; 
    }


    public function get_range_detail_bangunan($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT  *  FROM harga_sewa_detail
            WHERE harga_sewa_id = $id  and flag_jenis=0 and [delete]=0
            order by  id asc
        ");
		return $query->result_array();
		
    }


    public function get_range_detail_kavling($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT  *  FROM harga_sewa_detail
            WHERE harga_sewa_id = $id  and flag_jenis=1 and [delete]=0
            order by  id asc
        ");
		return $query->result_array();
		
    }
    

    public function get_log($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
            			
			SELECT  
                    harga_sewa.code					 as code,
                    harga_sewa.name					 as name,                    
                    harga_sewa.description			 as description, 
                    case when harga_sewa.active = 0	 then 'Tidak Aktif' else 'Aktif' end as aktif, 
                    case when harga_sewa.[delete] = 0 then 'Tidak di Hapus' else 'Terhapus' end as [delete],
                    harga_sewa_detail.id				as id_harga_sewa_detail,
                    harga_sewa_detail.range_awal		as range_awal,
					harga_sewa_detail.range_akhir	as range_akhir,
					harga_sewa_detail.harga_hpp		as harga_hpp,
                    harga_sewa_detail.harga	as harga_range,
                    harga_sewa_detail.flag_jenis	as flag_jenis
                    
                   
            FROM harga_sewa
            JOIN harga_sewa_detail		ON harga_sewa.id = harga_sewa_detail.harga_sewa_id
            WHERE				harga_sewa.id             = $id
            AND					harga_sewa.project_id     = $project->id
            ORDER BY			harga_sewa.id		  ASC
			
			
			
			
			
			
			
        ");
        $row = $query->result_array();
        $hasil = [];
        $i = 1;
        foreach ($row as $v) {
            if (!array_key_exists('code', $hasil)) {
                $hasil['code'] = $v['code'];
                $hasil['name'] = $v['name'];
                $hasil['description'] = $v['description'];
                $hasil['aktif'] = $v['aktif'];
                $hasil['delete'] = $v['delete'];
            }
            $hasil[$i.' id_harga_sewa_detail'] = $v['id_harga_sewa_detail'];
            $hasil[$i.' range_awal'] = $v['range_awal'];
            $hasil[$i.' range_akhir'] = $v['range_akhir'];
            $hasil[$i.' harga_hpp'] = $v['harga_hpp'];
            $hasil[$i.' harga'] = $v['harga_range'];
            $hasil[$i.' flag_jenis'] = $v['flag_jenis'];
           
            ++$i;
        }

        return $hasil;
    }
	
	


	
	public function get_log_detail($id){
        $this->load->model('m_core');
        $project = $this->m_core->project();
        
        $query = $this->db->query("
             SELECT * FROM harga_sewa_detail
        ");
        $row = $query->row();
        return $row; 
    }
	
	
	public function cek($id){
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
            SELECT * FROM harga_sewa WHERE id = $id and project_id = $project->id
        ");
        $row = $query->row();
        return isset($row)?1:0;
    }
	
	
    
	public function save($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $data = [
            'code'              => $dataTmp['kode'],
            'project_id'        => $project->id,
            'name'              => $dataTmp['nama'],
            'description'       => $dataTmp['keterangan'],
            'formula_bangunan'  => $dataTmp['formula_bangunan'],
            'formula_kavling'   => $dataTmp['formula_kavling'],
            'flag_bangunan'     => $dataTmp['flag_bangunan'] ? 1:0,
            'flag_kavling'      => $dataTmp['flag_kavling'] ? 1:0,
            'active'            => 1,
            'delete'            => 0
        ];
		
		
		$data_range_bangunan = [
            'range_awal'       =>  $dataTmp['range_awal'], 
            'range_akhir'      =>  $dataTmp['range_akhir'],  
            'harga_hpp'        =>  $dataTmp['harga_hpp'],  
			'harga'            =>  $dataTmp['harga_range'],  
            'flag_jenis'       => 0,
            'active'           => 1,
            'delete'           => 0
        ];
		
		
		
		$data_range_kavling = [
            'range_awal'       => $dataTmp['range_awal2'],   
            'range_akhir'      => $dataTmp['range_akhir2'],  
            'harga_hpp'        => $dataTmp['harga_hpp2'],  
			'harga'            => $dataTmp['harga_range2'],  
            'flag_jenis'       => 1,
            'active'           => 1,
            'delete'           => 0
        ];
		
		
		
		//var_dump($data_range_detail);
	

        $this->db->where('code', $data['code']);
        $this->db->from('harga_sewa');

        // validasi double
        if($this->db->count_all_results()==0){ 

                    $this->db->insert('harga_sewa', $data);
                    $id = $this->db->insert_id();
                   	$dataLog = $this->get_log($id);
                   // $this->m_log->log_save('range_lingkungan',$id,'Tambah',$dataLog);
					
					//echo("<pre>");
					//print_r($dataTmp);
					//echo("</pre>");
					
					
					
					if (isset($dataTmp['range_awal']))
					{
					for($i= 0;$i<=count($dataTmp['range_awal'])-1;$i++) {
						
                        $range_awal[$i]  =  $this->m_core->currency_to_number($dataTmp['range_awal'][$i]);
                        $range_akhir[$i] = $this->m_core->currency_to_number($dataTmp['range_akhir'][$i]); 
                        $harga_hpp[$i]   =  $this->m_core->currency_to_number($dataTmp['harga_hpp'][$i]);  
						$harga_range[$i] =  $this->m_core->currency_to_number($dataTmp['harga_range'][$i]); 
                        
                        
                        $data_range_bangunan = [
                            'harga_sewa_id'      => $id, 
                            'range_awal'               => $range_awal[$i],
                            'range_akhir'              => $range_akhir[$i],
                            'harga_hpp'                => $harga_hpp[$i],
							'harga'                    => $harga_range[$i],
                            'flag_jenis'               => 0,
                            'active'                   => 1,
                            'delete'                   => 0
                            
                        ];
                            
                        $this->db->insert('harga_sewa_detail', $data_range_bangunan);
                        $dataLog = $this->get_log_detail($this->db->insert_id());
                         $this->m_log->log_save('harga_sewa_detail',$this->db->insert_id(),'Tambah',$dataLog);

					}
					}
					
					if (isset($dataTmp['range_awal2']))
					{
					for($i= 0;$i<=count($dataTmp['range_awal2'])-1;$i++) {
						
                        $range_awal2[$i]  =  $this->m_core->currency_to_number($dataTmp['range_awal2'][$i]); 
                        $range_akhir2[$i] =  $this->m_core->currency_to_number($dataTmp['range_akhir2'][$i]);  
                        $harga_hpp2[$i]   =  $this->m_core->currency_to_number($dataTmp['harga_hpp2'][$i]);  
						$harga_range2[$i] =  $this->m_core->currency_to_number($dataTmp['harga_range2'][$i]); 
                        
                        
                        $data_range_kavling = [
                            'harga_sewa_id'      => $id, 
                            'range_awal'               => $range_awal2[$i],
                            'range_akhir'              => $range_akhir2[$i],
                            'harga_hpp'                => $harga_hpp2[$i],
							'harga'                    => $harga_range2[$i],
                            'flag_jenis'               => 1,
                            'active'                   => 1,
                            'delete'                   => 0
                           
                        ];
                            
                        $this->db->insert('harga_sewa_detail', $data_range_kavling);
                        $dataLog = $this->get_log_detail($this->db->insert_id());
                        $this->m_log->log_save('harga_sewa_detail',$this->db->insert_id(),'Tambah',$dataLog);

					}
					}
					
					
					
				
					
            return 'success';
        }else return 'double';
        
        
    }
	
	
	  public function edit($dataTmp)
    {
        // echo '<pre>';
        // print_r($dataTmp);
        // echo '</pre>';

        $before = $this->get_log($dataTmp['id']);

        $this->db->where('harga_sewa_id', $dataTmp['id']);
        $this->db->update('harga_sewa_detail', ['delete' => 1]);

        //$this->save($dateTmp);

        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $this->db->where('project_id', $project->id);
        $this->db->from('harga_sewa');
        $data =
        [
            'code' => $dataTmp['kode_range'],
            'name' => $dataTmp['name'],
            'description' => $dataTmp['keterangan'],
            'formula_bangunan'  => $dataTmp['formula_bangunan'],
            'formula_kavling'   => $dataTmp['formula_kavling'],
            'flag_bangunan' => $dataTmp['flag_bangunan'] ? 1:0,
            'flag_kavling'  => $dataTmp['flag_kavling'] ? 1:0,
            'active' => $dataTmp['active'] ? 1 : 0,
            'delete' => 0
        ];


        

        
       // echo '<pre>';
       // print_r($data);
       // echo '</pre>';

       if ($this->db->count_all_results() != 0) {
        
        //proses edit
        $beforeRange = $this->get_log($dataTmp['id']);

        $this->db->where('id', $dataTmp['id']);
        $this->db->update('harga_sewa', $data);
        $afterRange = $this->get_log($dataTmp['id']);
        $diff = (object) (array_diff_assoc((array) $afterRange, (array) $beforeRange));
        $tmpDiff = (array) $diff;
        if(true){
            $i = 0;
            $j = 0;
            $jumlahRangeBangunanBaru = 0;
            $jumlahRangeKavlingBaru = 0;

             //echo '<pre>';
             //   print_r($dataTmp);
             //   echo '</pre>';
            if (isset($dataTmp['id_range_bangunan'] )) {

            foreach ($dataTmp['id_range_bangunan'] as $v) {
                // echo '<pre>';
                // print_r($v);
                // echo '</pre>';
                // var_dump($dataTmp['id_rekening'][$i]);
                $dataRangeLingkunganDetailBangunanTmp = [];
                $dataRangeLingkunganDetailBangunanTmp =
                [
                    'harga_sewa_id' => $dataTmp['id'],
                    'range_awal' =>  $this->m_core->currency_to_number($dataTmp['range_awal'][$i]),  
                    'range_akhir' =>  $this->m_core->currency_to_number($dataTmp['range_akhir'][$i]),  
                    'harga_hpp' =>  $this->m_core->currency_to_number($dataTmp['harga_hpp'][$i]), 
                    'harga' =>  $this->m_core->currency_to_number($dataTmp['harga_range'][$i]),     
                    'flag_jenis'=> 0,
                    'active'=> 1,                    
                    'delete' => 0

                ];
                if ($v != 0) {
                    $jumlahRangeBangunanBaru++;
                    // $dataRekeningTmp['id'] = $dataTmp['id_rekening'][$i];
                    // edit rekening
                    $this->db->where('id', $dataTmp['id_range_bangunan'][$i]);
                    $this->db->update('harga_sewa_detail', $dataRangeLingkunganDetailBangunanTmp);
                }else{
                    // add rekening
                    $this->db->insert('harga_sewa_detail', $dataRangeLingkunganDetailBangunanTmp);  

                }

                // echo '<pre>';
                // print_r($dataRekeningTmp);
                // echo '</pre>';
                $i++;
            }

        }

        }

        if (isset($dataTmp['id_range_kavling'] )) {


            foreach ($dataTmp['id_range_kavling'] as $m) {
                // echo '<pre>';
                // print_r($v);
                // echo '</pre>';
                
                $dataRangeLingkunganDetailKavlingTmp = [];
                $dataRangeLingkunganDetailKavlingTmp =
                [
                    'harga_sewa_id' => $dataTmp['id'],
                    'range_awal' =>  $this->m_core->currency_to_number($dataTmp['range_awal2'][$j]), 
                    'range_akhir' =>  $this->m_core->currency_to_number($dataTmp['range_akhir2'][$j]),  
                    'harga_hpp' =>  $this->m_core->currency_to_number($dataTmp['harga_hpp2'][$j]),   
                    'harga' =>  $this->m_core->currency_to_number($dataTmp['harga_range2'][$j]),    
                    'flag_jenis'=> 1,
                    'active'=> 1,                    
                    'delete' => 0

                ];
                if ($m != 0) {
                    $jumlahRangeKavlingBaru++;
                   
                    // edit range
                    $this->db->where('id', $dataTmp['id_range_kavling'][$j]);
                    $this->db->update('harga_sewa_detail', $dataRangeLingkunganDetailKavlingTmp);
                }else{
                    // add range
                    $this->db->insert('harga_sewa_detail', $dataRangeLingkunganDetailKavlingTmp);  

                }

               
                $j++;
            }

           
            $after = $this->get_log($dataTmp['id']);
            $diff = (object) (array_diff_assoc((array) $after, (array) $before));
            $tmpDiff = (array) $diff;
            // echo '<pre>';
            //     print_r($before);
            // echo '</pre>';
            // echo '<pre>';
            //     print_r($after);
            // echo '</pre>';
            // echo '<pre>';
            //     print_r($tmpDiff);
            // echo '</pre>';
            if ($tmpDiff) {
                $this->m_log->log_save('harga_sewa', $dataTmp['id'], 'Edit', $diff);

                return 'success';
            }
        }

    }
       
       
    }
	
	
	public function delete($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $this->db->where('project_id', $project->id);
        $this->db->from('harga_sewa');

        // validasi apakah user dengan project $project boleh edit data ini
        if ($this->db->count_all_results() != 0) {
          
                        $before = $this->get_log($dataTmp['id']);
                        $this->db->where('id', $dataTmp['id']);
                        $this->db->update('harga_sewa', ['delete' => 1]);
                        $after = $this->get_log($dataTmp['id']);

                        $diff = (object) (array_diff((array) $after, (array) $before));
                        $tmpDiff = (array) $diff;

                        if ($tmpDiff) {
                            $this->m_log->log_save('harga_sewa', $dataTmp['id'], 'Edit', $diff);

                            return 'success';
                        } else {
                            return 'Tidak Ada Perubahan';
                        }
                 
        }
    }
	
	

}