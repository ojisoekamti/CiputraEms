<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_registrasi_liaison_officer extends CI_Model
{
    public function get()
    {
        $query = $this->db->query('
            SELECT * FROM cara_pembayaran
        ');

        return $query->result_array();
    }

    public function get_kategori()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("id,kode,nama")
                            ->from("kategori_loi")
                            // ->where("project_id",$project->id)
                            ->where("delete",0)
                            ->where("active",1);
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

    public function get_peruntukan()
    {
        $query = $this->db
                            ->select("peruntukan_loi.*")
                            ->from("peruntukan_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = peruntukan_loi.jenis_loi_id","LEFT")
                            ->where("peruntukan_loi.delete",0);
        return $query->get()->result_array();
    }

    public function get_paket()
    {
        $query = $this->db
                            ->select("paket_loi.*")
                            ->from("paket_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = paket_loi.jenis_loi_id", "LEFT")
                            ->where("paket_loi.delete",0);
        return $query->get()->result_array();
    }

    public function getJenis($kategori)
    {
        $query = $this->db
                            ->select("jenis_loi.*")
                            ->from("jenis_loi")
                            ->join("kategori_loi",
                                    "kategori_loi.id = jenis_loi.kategori_loi_id","LEFT")
                            ->where("jenis_loi.kategori_loi_id",$kategori);
        return $query->get()->result();
    }

    public function getPeruntukan($jenis)
    {
        $query = $this->db
                            ->select("peruntukan_loi.*")
                            ->from("peruntukan_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = peruntukan_loi.jenis_loi_id","LEFT")
                            ->where("peruntukan_loi.jenis_loi_id",$jenis);
        return $query->get()->result();
    }

    public function getPaket($jenis)
    {
        $query = $this->db
                            ->select("paket_loi.*")
                            ->from("paket_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = paket_loi.jenis_loi_id","LEFT")
                            ->where("paket_loi.jenis_loi_id",$jenis);
        return $query->get()->result();
    }

     public function getUnit()
    {

        $project = $this->m_core->project();
        $query = $this->db
                            ->select("project.name as project_name,
                                    kawasan.name as kawasan_name,
                                    blok.name as blok_name,
                                    unit.*")
                            ->from("unit")
                            ->join("blok",
                                    "unit.blok_id = blok.id","LEFT")
                            ->join("kawasan",
                                    "blok.kawasan_id = kawasan.id","LEFT")
                            ->join("project",
                                    "project.id = kawasan.project_id","LEFT")
                            ->where("kawasan.project_id",$project->id);
        return $query->get()->result_array();
    }


    public function getUnit2($id)
    {
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("project.name as project_name,
                                    kawasan.name as kawasan_name,
                                    blok.name as blok_name,
                                    unit.luas_bangunan as luas_bangunan,
                                    unit.luas_tanah as luas_tanah,
                                    unit.unit_type as unit_type,
                                    unit.tgl_st as tanggal_st,
                                    unit.no_unit as no_unit,
                                    customer.name as customer_name,
                                    customer.address as customer_address,
                                    customer.code as customer_code,
                                    customer.homephone as customer_homephone,
                                    customer.mobilephone1 as customer_mobilephone,
                                    customer.email as customer_email")
                            ->from("unit")
                            ->join("blok",
                                    "unit.blok_id = blok.id","LEFT")
                            ->join("kawasan",
                                    "blok.kawasan_id = kawasan.id","LEFT")
                            ->join("project",
                                    "project.id = kawasan.project_id","LEFT")
                            ->join("customer",
                                    "customer.id = unit.pemilik_customer_id", "LEFT")
                            ->where("kawasan.project_id",$project->id)
                            ->where("unit.id",$id);
        return $query->get()->row();
    }

      public function getJenisService()
    {
        $query = $this->db->query('
            SELECT * FROM liaison
        ');

        return $query->result_array();
    }

    public function save($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        if ($dataTmp['pilih_unit']  != 'non_unit') {
            $paketLOI = explode('|', $dataTmp['paket_loi_id']);
            $nomor_registrasi =  $dataTmp['nomor_registrasi'] ;

            if ( $nomor_registrasi == 'Auto Generate'){
                $nomor_registrasi = "CG/REGISTRASILOI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_liaison_officer->last_id());
            }else{
                $nomor_registrasi =  $dataTmp['nomor_registrasi'];
            }
            $tanggal_document =  $dataTmp['tanggal_document'];
            $tanggal_rencana_pemasangan =  $dataTmp['tanggal_rencana_pemasangan'];
            $tanggal_rencana_aktifasi =  $dataTmp['tanggal_rencana_aktifasi'];
            $expired_date = $dataTmp['expired_date'];
            $tanggal_rencana_survei = $dataTmp['tanggal_rencana_survei'];
            $oldDate1 = $tanggal_document;
            $arr = explode('-', $oldDate1);
            //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
            $tanggal_document2 = $arr[2].'-'.$arr[1].'-'.$arr[0];

            if ($tanggal_rencana_pemasangan != null)
            {
                $oldDate2 = $tanggal_rencana_pemasangan;
                $arr = explode('-', $oldDate2);
                $tanggal_rencana_pemasangan2 = $arr[2].'-'.$arr[1].'-'.$arr[0];
            }else{
                $tanggal_rencana_pemasangan2 = null;
            }

            if ($tanggal_rencana_aktifasi != null)
            {
                $oldDate3 = $tanggal_rencana_aktifasi;
                $arr = explode('-', $oldDate3);
                $tanggal_rencana_aktifasi2 = $arr[2].'-'.$arr[1].'-'.$arr[0];
            }else{
                $tanggal_rencana_aktifasi2 = null;
            }

            if ($expired_date != null)
            {
                $oldDate4 = $expired_date;
                $arr = explode('-', $oldDate4);
                $expired_date2 = $arr[2].'-'.$arr[1].'-'.$arr[0];
            }else{
                $expired_date2 = null;
            }

            if ($tanggal_rencana_survei != null)
            {
                $oldDate5 = $tanggal_rencana_survei;
                $arr = explode('-', $oldDate5);
                $tanggal_rencana_survei2 = $arr[2].'-'.$arr[1].'-'.$arr[0];
            }else{
                $tanggal_rencana_survei2 = null;
            }

            $dataLOI =
            [
                // 'parent_id' => $parent_id,
                'unit_id' => $dataTmp['pilih_unit'],
                'unit' => $dataTmp['unit'],
                'customer_id' => $dataTmp['customer_id'],
                'customer_name' => $dataTmp['customer_name'],
                'project_id'    => $project->id,
                'nomor_telepon' => $dataTmp['nomor_telepon'],
                'nomor_handphone' => $dataTmp['nomor_handphone'],
                'email' => $dataTmp['email'],
                'tgl_document' => $tanggal_document2,
                'tanggal_rencana_pemasangan' => $tanggal_rencana_pemasangan2,
                'tanggal_rencana_aktifasi' => $tanggal_rencana_aktifasi2,
                'tanggal_rencana_survei' => $tanggal_rencana_survei2,
                'paket_loi_id' => $paketLOI[0],
                'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                'total' => $this->m_core->currency_to_number($dataTmp['total']),
                'keterangan' => $dataTmp['keterangan'],
                'nomor_registrasi' => $nomor_registrasi,
                // 'dokumen' => $dataTmp['dokumen'],
                'status_dokumen' => $dataTmp['status_dokumen'],
                'kategori_loi_id' => $dataTmp['kategori_loi_id'],
                'jenis_loi_id' => $dataTmp['jenis_loi_id'],
                'peruntukan_loi_id' => $dataTmp['peruntukan_loi_id'],
                'luaslama' => $dataTmp['luaslama'],
                'luasbaru' => $dataTmp['luasbaru'],
                'expired_date' => $expired_date2,
                'status_bayar' => 0,
                'active' => 1,
                'delete' => 0
            ];
        }

        $this->db->insert('t_loi_registrasi', $dataLOI);
        $id = $this->db->insert_id();

        $data_tagihan           = (object)[];
        $dataTagihanLOI         = (object)[];
        $this->db->where('unit_id',$dataLOI['unit_id']);            
        $this->db->where('periode',date("Y-m-01"));
        $this->db->where('proyek_id',$project->id);                
        $tagihan_sudah_ada = $this->db->get('t_tagihan');
        if (!$tagihan_sudah_ada->num_rows()) {
            $data_tagihan->proyek_id                    = $project->id;
            $data_tagihan->unit_id                      = $dataLOI['unit_id'];
            $data_tagihan->periode                      = date("Y-m-01");

            $this->db->insert('t_tagihan',$data_tagihan);
            $dataTagihanLOI->t_tagihan_id = $this->db->insert_id();
        }else{
            $dataTagihanLOI->t_tagihan_id = $tagihan_sudah_ada->row()->id;
        }


        $dataTagihanLOI->project_id     = $dataLOI['project_id'];
        $dataTagihanLOI->unit_id        = $dataLOI['unit_id'];
        $dataTagihanLOI->kode_tagihan   = "";
        $dataTagihanLOI->periode        = date("Y-m-01");
        $dataTagihanLOI->status_tagihan = 0;
        $dataTagihanLOI->t_tagihan_id   = 0;
        $dataTagihanLOI->tipe           = 1;
        $dataTagihanLOI->loi_id         = $id;
        $this->db->insert('t_tagihan_loi',$dataTagihanLOI);

        $dataUnit = [
            'luas_bangunan' => $dataTmp['luasbaru']
        ];
        $this->db->where('id', $dataTmp['pilih_unit']);
        $this->db->update('unit', $dataUnit);

        $dataDeposit = [
            't_loi_registrasi_id' => $id,
            'deposit_masuk' => $this->m_core->currency_to_number($dataTmp['deposit_masuk']),
            'status_deposit' => 0
        ];

        $this->db->insert('t_loi_deposit',$dataDeposit);
        $dataLog = $this->get_log($id);
        $this->m_log->log_save('t_loi_registrasi', $this->db->insert_id(), 'Tambah', $dataLog);
        return 'success';
    }

    public function getAll()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("t_loi_registrasi.*,
                                    paket_loi.nama as nama_paket")
                            ->from("t_loi_registrasi")
                            ->join("paket_loi",
                                    "paket_loi.id = t_loi_registrasi.paket_loi_id","LEFT")
                            ->where("t_loi_registrasi.project_id = $project->id")
                            ->where("t_loi_registrasi.delete",0)
                            ->where("(t_loi_registrasi.status_bayar != 'false' OR t_loi_registrasi.status_dokumen != 0 OR t_loi_registrasi.expired_date >= convert(varchar, getdate(), 23))");
        // echo "<pre>";
        // var_dump($query->get()->result_array());
        // echo "</pre>";
        // die();
        return $query->get()->result_array();
    }

    public function get_all_pt_coa()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
        SELECT 
            coa_mapping.id,
            pt.name as pt_name,
            coa.description as coa_name,
            coa.code as coa_code
        FROM coa_mapping
            JOIN coa ON coa.id = coa_mapping.coa_id
            JOIN pt ON pt.id = coa_mapping.pt_id
        WHERE coa_mapping.project_id = $project->id
        ");

        return $query->result_array();
    }

    public function cek($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
            SELECT * 
            FROM cara_pembayaran 
            JOIN coa_mapping ON coa_mapping.id = cara_pembayaran.coa_mapping_id
            WHERE cara_pembayaran.id = $id 
            AND coa_mapping.project_id = $project->id        
            ");
        $row = $query->row();

        return isset($row) ? 1 : 0;
    }

    public function getPaketLOI()
    {   
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db
                            ->select("paket_loi.id,
                                    paket_loi.nama as nama,
                                    jenis_loi.*,
                                    kategori_loi.*")
                            ->from("paket_loi")
                            ->join("jenis_loi",
                                    "jenis_loi.id = paket_loi.jenis_loi_id","LEFT")
                            ->join("kategori_loi",
                                    "kategori_loi.id = jenis_loi.kategori_loi_id","LEFT")
                            ->where("kategori_loi.project_id",$project->id);
        return $query->get()->result_array();
    }

    public function getSelect($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
        
        SELECT     
            project.name as project,
            kawasan.name as kawasan,
            blok.name as blok,
            unit.no_unit as unit,
            unit.id as unit_id,
            t_loi_registrasi.customer_name as customer,
            t_loi_registrasi.email as email,
            t_loi_registrasi.nomor_handphone as no_hp,
            t_loi_registrasi.nomor_registrasi as nomor_registrasi,
            t_loi_registrasi.nomor_telepon as telepon,
            CONVERT(varchar, t_loi_registrasi.tgl_document, 105) as tanggal_document,
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_pemasangan, 105) as tanggal_rencana_pemasangan,
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_aktifasi, 105) as tanggal_rencana_aktifasi,
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_survei,105) as tanggal_rencana_survei,
            CONVERT(varchar, t_loi_registrasi.expired_date,105) as expired_date,
            t_loi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
            t_loi_registrasi.keterangan as keterangan,
            t_loi_registrasi.harga_paket as harga_paket,
            t_loi_registrasi.diskon  as diskon,
            t_loi_registrasi.luaslama as luaslama,
            t_loi_registrasi.luasbaru as luasbaru,
            t_loi_registrasi.total as total,
            kategori_loi.id as kategori,
            kategori_loi.nama as kategori_nama,
            jenis_loi.id as jenis,
            jenis_loi.nama as jenis_nama,
            peruntukan_loi.id as peruntukan,
            peruntukan_loi.nama as peruntukan_nama,
            paket_loi.id as paket,
            customer.id as customer_id,
            paket_loi.nama as nama_paket,
            paket_loi.kode as kode_paket,
            paket_loi.biaya_registrasi as biaya_registrasi,
            paket_loi.harga_jasa as harga_jasa,
            paket_loi.biaya_prakiraan as biaya_prakiraan,
            paket_loi.keterangan as keterangan,
            SUM(paket_loi.biaya_registrasi+paket_loi.harga_jasa+paket_loi.biaya_prakiraan) as total_paket,
            t_loi_deposit.deposit_masuk as deposit_masuk,
            t_loi_pembayaran.total_bayar as total_bayar
        FROM t_loi_registrasi
        left join kategori_loi on kategori_loi.id = t_loi_registrasi.kategori_loi_id
        left join jenis_loi on jenis_loi.id = t_loi_registrasi.jenis_loi_id
        left join peruntukan_loi on peruntukan_loi.id = t_loi_registrasi.peruntukan_loi_id
        left join paket_loi on paket_loi.id = t_loi_registrasi.paket_loi_id
        left join t_loi_deposit on t_loi_deposit.t_loi_registrasi_id = t_loi_registrasi.id
        left join t_loi_pembayaran on t_loi_pembayaran.t_loi_registrasi_id = t_loi_pembayaran.id
        left join unit on unit.id = t_loi_registrasi.unit_id
        left join blok on unit.blok_id = blok.id
        left join kawasan on blok.kawasan_id = kawasan.id
        left join project on project.id = kawasan.project_id
        left join customer on unit.pemilik_customer_id = customer.id
        where 
        t_loi_registrasi.id = $id and
        kawasan.project_id = $project->id
        GROUP BY 
        project.name,
            kawasan.name,
            blok.name,
            unit.no_unit,
            unit.id,
            t_loi_registrasi.customer_name,
            t_loi_registrasi.email ,
            t_loi_registrasi.nomor_handphone ,
            t_loi_registrasi.nomor_registrasi,
            t_loi_registrasi.nomor_telepon,
            CONVERT(varchar, t_loi_registrasi.tgl_document, 105),
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_pemasangan, 105),
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_aktifasi, 105),
            CONVERT(varchar, t_loi_registrasi.tanggal_rencana_survei,105),
            CONVERT(varchar, t_loi_registrasi.expired_date,105),
            t_loi_registrasi.tanggal_pemasangan_berakhir,
            t_loi_registrasi.keterangan,
            t_loi_registrasi.harga_paket,
            t_loi_registrasi.diskon,
            t_loi_registrasi.luaslama,
            t_loi_registrasi.luasbaru,
            t_loi_registrasi.total,
            kategori_loi.id,
            kategori_loi.nama,
            jenis_loi.id,
            jenis_loi.nama,
            peruntukan_loi.id,
            peruntukan_loi.nama,
            paket_loi.id,
            customer.id,
            paket_loi.nama,
            paket_loi.kode,
            paket_loi.keterangan,
            paket_loi.biaya_registrasi,
            paket_loi.harga_jasa,
            paket_loi.biaya_prakiraan,
            t_loi_deposit.deposit_masuk,
            t_loi_pembayaran.total_bayar
        ");
        $row = $query->row();

        return $row;
    }

    public function get_log($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
            SELECT 
                t_loi_registrasi.* 
            FROM t_loi_registrasi
            WHERE t_loi_registrasi.id = $id
        ");
        $row = $query->row();

        return $row;
    }

    // public function edit($dataTmp)
    // {
    //     $this->load->model('m_core');
    //     $this->load->model('m_log');
    //     $project = $this->m_core->project();
    //     $user_id = $this->m_core->user_id();

    //     $this->db->join('coa_mapping', 'coa_mapping.id = cara_pembayaran.coa_mapping_id');
    //     $this->db->where('coa_mapping.project_id', $project->id);
    //     $this->db->from('cara_pembayaran');

    //     $data =
    //     [
    //         'code' => $dataTmp['code'],
    //         'name' => $dataTmp['jenis_pembayaran'],
    //         'biaya_admin' => $this->m_core->currency_to_number($dataTmp['biaya_admin']),
    //         'coa_mapping_id' => $dataTmp['coa'],
    //         'description' => $dataTmp['keterangan'],
    //         'active' => $dataTmp['active'] ? 1 : 0,
    //     ];
    //     // validasi apakah user dengan project $project boleh edit data ini
    //     if ($this->db->count_all_results() != 0) {
    //         $this->db->where('code', $data['code'])->where('id !=', $dataTmp['id']);
    //         $this->db->from('cara_pembayaran');
    //         // validasi double
    //         if ($this->db->count_all_results() == 0) {
    //             $before = $this->get_log($dataTmp['id']);
    //             $this->db->where('id', $dataTmp['id']);
    //             $this->db->update('cara_pembayaran', $data);
    //             $after = $this->get_log($dataTmp['id']);

    //             $diff = (object) (array_diff_assoc((array) $after, (array) $before));
    //             $tmpDiff = (array) $diff;

    //             if ($tmpDiff) {
    //                 $this->m_log->log_save('cara_pembayaran', $dataTmp['id'], 'Edit', $diff);

    //                 return 'success';
    //             } else {
    //                 return 'Tidak Ada Perubahan';
    //             }
    //         } else {
    //             return 'double';
    //         }
    //     }
    // }

    public function edit($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $expired_date =  $dataTmp['expired_date'];
        $oldDate1 = $expired_date;
        $arr = explode('-', $oldDate1);
        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $expired_date2 = $arr[2].'-'.$arr[1].'-'.$arr[0];

        $dataRegister =
        [
            'nomor_registrasi' => $dataTmp['nomor_registrasi'],
            'expired_date' => $expired_date2
        ];
        
        if ($this->db->count_all_results() != 0) {
            $this->db->where('nomor_registrasi', $dataTmp['nomor_registrasi'])->where('id !=', $dataTmp['id']);
            $this->db->from('t_loi_registrasi');
            // validasi double
            if ($this->db->count_all_results() == 0) {
                $before = $this->get_log($dataTmp['id']);
                $this->db->where('id', $dataTmp['id']);
                $this->db->update('t_loi_registrasi', $dataRegister);
                $after = $this->get_log($dataTmp['id']);
                $diff = (object) (array_diff_assoc((array) $after, (array) $before));
                $tmpDiff = (array) $diff;
                if ($tmpDiff) {
                    $this->m_log->log_save('t_loi_registrasi', $dataTmp['id'], 'Edit', $diff);
                    return 'success';
                } else {
                    return 'Tidak Ada Perubahan';
                }
            }else{
                return 'double';
            }
        }
    }

    public function pembayaran($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');

        $dataRegister =
        [
            'nomor_registrasi' => $dataTmp['nomor_registrasi'],
            'status_dokumen' => 1,
            'status_bayar'  => $dataTmp['status_bayar']
        ];
        $this->db->where('id', $dataTmp['id']);
        $this->db->update('t_loi_registrasi', $dataRegister);

        $dataBayar =
            [  
                't_loi_registrasi_id' => $dataTmp['id'],
                'total_bayar' => $this->m_core->currency_to_number($dataTmp['total_bayar'])
            ];
        $this->db->insert('t_loi_pembayaran', $dataBayar);
        $id = $this->db->insert_id();

        $dataLog = $this->get_log($id);
        $this->m_log->log_save('t_loi_pembayaran', $id, 'Tambah', $dataLog);

        return 'success';
        
    }

    public function delete($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();

        $this->db->join('coa_mapping', 'coa_mapping.id = cara_pembayaran.coa_mapping_id');
        $this->db->where('coa_mapping.project_id', $project->id);
        $this->db->from('cara_pembayaran');

        // validasi apakah user dengan project $project boleh edit data ini
        if ($this->db->count_all_results() != 0) {
            $before = $this->get_log($dataTmp['id']);
            $this->db->where('id', $dataTmp['id']);
            $this->db->update('cara_pembayaran', ['delete' => 1]);
            $after = $this->get_log($dataTmp['id']);

            $diff = (object) (array_diff((array) $after, (array) $before));
            $tmpDiff = (array) $diff;

            if ($tmpDiff) {
                $this->m_log->log_save('cara_pembayaran', $dataTmp['id'], 'Edit', $diff);

                return 'success';
            } else {
                return 'Tidak Ada Perubahan';
            }
        }
    }

    public function last_id()
    {
        $query = $this->db->query("
            SELECT TOP 1 id FROM t_loi_registrasi
            ORDER by id desc
        ");
        return $query->row() ? $query->row()->id : 0;
    }

    
    public function upload($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();

        
        $this->db->select('status_dokumen');
        $this->db->from('t_loi_registrasi');
        $this->db->where('id',$dataTmp['id']);
        $status_dokumen =  $this->db->get()->row()->status_dokumen;
        $status_dokumen = ($status_dokumen!=0) ? $status_dokumen : 1;

        $this->db->where('project_id', $project->id);
        $this->db->from('t_loi_registrasi');
        $data = [
            'status_dokumen' => $status_dokumen,
            'dokumen' => $dataTmp['dokumen']
        ];
        $this->db->where('id', $dataTmp['id']);
        $this->db->update('t_loi_registrasi', $data);
        return 'success';
        // validasi apakah user dengan project $project boleh edit data ini
        // if ($this->db->count_all_results() != 0) {
        //     $before = $this->get_log($dataTmp['id']);
        //     $this->db->where('id', $dataTmp['id']);
        //     $this->db->update('t_tvi_registrasi', $data);
        //     $after = $this->get_log($dataTmp['id']);

        //     $diff = (object)(array_diff((array)$after, (array)$before));
        //     $tmpDiff = (array)$diff;

        //     if ($tmpDiff) {
        //         $this->m_log->log_save('t_tvi_registrasi', $dataTmp['id'], 'Edit', $diff);
        //         return 'success';
        //     } else {
        //         return 'Tidak Ada Perubahan';
        //     }
        // }
    }
}
