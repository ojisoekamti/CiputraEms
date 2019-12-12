<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_registrasi_tvi extends CI_Model
{
    public function get()
    {
        $query = $this->db->query('
            SELECT * FROM cara_pembayaran
        ');

        return $query->result_array();
    }


    public function getUnit()
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT project.name as project_name,
                   kawasan.name as kawasan_name,
                   blok.name as blok_name,
                   unit.*

             FROM unit 
            left join blok on unit.blok_id = blok.id
            left join kawasan on blok.kawasan_id = kawasan.id
            left join project on project.id = kawasan.project_id where kawasan.project_id = $project->id


             ");

        return $query->result_array();
    }


    public function getUnit2($id)
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT project.name as project_name,
                   kawasan.name as kawasan_name,
                   blok.name as blok_name,
                   unit.id as unit_id,
                   unit.*,
                   customer.name as customer_name,
                   customer.code as customer_code,
                   customer.homephone as customer_homephone,
                   customer.mobilephone1 as customer_mobilephone,
                   customer.email as customer_email,
                   customer.id as customer_id

            FROM unit 
            left join blok on unit.blok_id = blok.id
            left join kawasan on blok.kawasan_id = kawasan.id
            left join project on project.id = kawasan.project_id 
            left join customer on customer.id = unit.pemilik_customer_id
            where kawasan.project_id = $project->id and unit.id = $id


             ");

        return $query->row();
    }



    public function getCustomer()
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT *
            FROM customer          


             ");

        return $query->result_array();
    }



    public function getCustomer2($id)
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT 
                   customer.name as customer_name,
                   customer.code as customer_code,
                   customer.homephone as customer_homephone,
                   customer.mobilephone1 as customer_mobilephone,
                   customer.email as customer_email,
                   customer.id as customer_id

            FROM customer  
            where  project_id = $project->id and id = $id          


             ");

        return $query->row();
    }


       public function getNomorRegistrasiNonUnit( $customer_id)
    {

        $project = $this->m_core->project();

    


         
                $query = $this->db->query("
           


                 SELECT TOP 1 id, nomor_registrasi
                   
                    
             
                FROM t_tvi_registrasi
                where t_tvi_registrasi.customer_id = $customer_id and t_tvi_registrasi.project_id = $project->id   and t_tvi_registrasi.unit = 'non_unit'  order by id desc 
            


                ");


                $row = $query->row();


                if (isset($row)) {


                 
                    $nomor_registrasi  = $row->nomor_registrasi;
                }

                else


                {


                    $nomor_registrasi = "Auto Generate";

                }




               return $nomor_registrasi;
    


   }


   public function getAktifasiNonUnit($customer_id)
   {

       $project = $this->m_core->project();

    


        
               $query = $this->db->query("
          


                SELECT TOP 1 tanggal
                  
                   
            
               FROM t_tvi_tagihan
               LEFT JOIN t_tvi_registrasi on t_tvi_registrasi.id = t_tvi_tagihan.registrasi_id
               where t_tvi_registrasi.customer_id = $customer_id and t_tvi_tagihan.project_id = $project->id and t_tvi_tagihan.flag_type = 3 and t_tvi_registrasi.unit = 'non_unit'
               order by t_tvi_tagihan.id desc 
           


               ");


               $row = $query->row();


               if (isset($row)) {


                  
                   $tanggal  = $row->tanggal;
               }



               $last_day = date('Y-m-t', strtotime($tanggal));



               $tanggal_aktifasi =  date('d-m-Y', strtotime('+1 day', strtotime($last_day)));


              


               return $tanggal_aktifasi;

    



  }





         public function getNomorRegistrasiUnit($unit_id)
    {

        $project = $this->m_core->project();

     


         
                $query = $this->db->query("
           


                 SELECT TOP 1 id, nomor_registrasi
                   
                    
             
                FROM t_tvi_registrasi
                where t_tvi_registrasi.unit_id = $unit_id and t_tvi_registrasi.project_id = $project->id   
                order by id desc 
            


                ");


                $row = $query->row();


                if (isset($row)) {


                   
                    $nomor_registrasi  = $row->nomor_registrasi;
                }


                else


                {


                  $nomor_registrasi = "Auto Generate";


                }



                return $nomor_registrasi;

     



   }


   
   public function getAktifasiUnit($unit_id)
   {

       $project = $this->m_core->project();

    


        
               $query = $this->db->query("
          


                SELECT TOP 1  tanggal
                  
                   
            
               FROM t_tvi_tagihan
               LEFT JOIN t_tvi_registrasi on t_tvi_registrasi.id = t_tvi_tagihan.registrasi_id
               where t_tvi_registrasi.unit_id = $unit_id and t_tvi_tagihan.project_id = $project->id and t_tvi_tagihan.flag_type = 3  
               order by t_tvi_tagihan.id desc 
           


               ");


               $row = $query->row();


               if (isset($row)) {


                  
                   $tanggal  = $row->tanggal;
               }


               $last_day = date('Y-m-t', strtotime($tanggal));



               $tanggal_aktifasi =  date('d-m-Y', strtotime('+1 day', strtotime($last_day)));


              


               return $tanggal_aktifasi;

    



  }




    



    public function getPaket()
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT *
            FROM paket_tvi         


             ");

        return $query->result_array();
    }


     public function getJenisPaket($jenis_bayar)
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT 

                   paket_tvi.id as id,
                   paket_tvi.harga_jual as harga_jual,
                   paket_tvi.description as description,
                   paket_tvi.biaya_pasang_baru as biaya_pasang_baru,
                   paket_tvi.biaya_registrasi as biaya_registrasi,
                   paket_tvi.bandwidth as bandwidth,
                   paket_tvi.name as name


            FROM paket_tvi 
            LEFT JOIN group_tvi on group_tvi.id = paket_tvi.group_tvi_id  
            where group_tvi.project_id = $project->id and group_tvi.jenis_bayar = '$jenis_bayar'      


             ");

        return $query->result_array();
    }


   



    public function getPaket2($id)
    {

        $project = $this->m_core->project();
        $query = $this->db->query("
            SELECT 
                   paket_tvi.name as paket_name,
                   paket_tvi.harga_setelah_ppn as paket_harga_ppn,
                   paket_tvi.biaya_pasang_baru as paket_biaya_pasang_baru,
                   paket_tvi.biaya_registrasi as biaya_registrasi,
                   paket_tvi.bandwidth as bandwidth,
                   paket_tvi.description as paket_description,
                   paket_tvi.id as paket_id,
                   group_tvi.jumlah_hari as jumlah_hari

            FROM paket_tvi      
            join group_tvi  on paket_tvi.group_tvi_id = group_tvi.id where  group_tvi.project_id = $project->id and paket_tvi.id = $id      

             ");

        return $query->row();
    }


    public function save($dataTmp)
    {


        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();


        if ($dataTmp['pilih_unit']  != 'non_unit') {


            $paket = explode('|', $dataTmp['jenis_paket_id']);


             echo('<PRE>');
              
             print_r($dataTmp['jenis_paket_id']);

            echo('</PRE>');



            $dataUnit =
                [
                    'unit_id' => $dataTmp['pilih_unit'],
                    'unit' => $dataTmp['unit'],
                    'customer_id' => $dataTmp['customer_id'],
                    'customer_name' => $dataTmp['customer_name'],
                    'project_id'    => $project->id,
                    'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                    'nomor_telepon' => $dataTmp['nomor_telepon'],
                    'nomor_handphone' => $dataTmp['nomor_handphone'],
                    'email' => $dataTmp['email'],
                    'tanggal_document' => $dataTmp['tanggal_document'],
                    'tanggal_pemasangan_mulai' => $dataTmp['tanggal_pemasangan_mulai'],
                    'tanggal_aktifasi' => $dataTmp['tanggal_aktifasi'], 
                    'jenis_bayar' => $dataTmp['jenis_bayar'],  
                    'jenis_paket_id' => $paket[0],
                    'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                    'harga_lain_lain' => $this->m_core->currency_to_number($dataTmp['harga_lain_lain']),
                    'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['harga_registrasi']),
                    'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                    'total' => $this->m_core->currency_to_number($dataTmp['total']),
                    'keterangan' => $dataTmp['keterangan'],
                    'nomor_registrasi' => $dataTmp['nomor_registrasi'],
                    'status_bayar' => 0,
                    'active' => 1,
                    'delete' => 0,
                ];





            $this->db->where('unit_id', $dataTmp['pilih_unit']);
            $this->db->from('t_tvi_registrasi');

            // validasi double
            if ($this->db->count_all_results() == 0) {



                $parent_id = 0;
            } else {




                $unit_id = $dataTmp['pilih_unit'];


                  echo('<PRE>');

                  echo ('unit_id');
                  print_r($unit_id);

                  echo('</PRE>');


                $query = $this->db->query("
           


                 SELECT TOP 1 id, nomor_registrasi
                   
                    
             
                FROM t_tvi_registrasi
                where t_tvi_registrasi.unit_id = $unit_id and t_tvi_registrasi.project_id = $project->id   
                order by id desc 
            


                ");


                $row = $query->row();


                if (isset($row)) {


                    $parent_id  = $row->id;
                  //  $nomor_reg  = $row->nomor_registrasi;
                }
            }



            $nomor_registrasi =  $dataTmp['nomor_registrasi'] ;



            if ( $nomor_registrasi == 'Auto Generate')

            {

              $nomor_registrasi = "CG/REGISTRASITVI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_tvi->last_id());
                   
            }


            else  


             {


              $nomor_registrasi =  $dataTmp['nomor_registrasi'];



             } 
             
            $tanggal_document =  $dataTmp['tanggal_document'];

            $tanggal_pemasangan_mulai =  $dataTmp['tanggal_pemasangan_mulai'];

            $tanggal_aktifasi =  $dataTmp['tanggal_aktifasi'];

             var_dump($tanggal_document);

             $oldDate1 = $tanggal_document;
             $arr = explode('-', $oldDate1);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_document2 = $arr[2].'-'.$arr[1].'-'.$arr[0];


             if ($tanggal_pemasangan_mulai != null)
             {

             $oldDate2 = $tanggal_pemasangan_mulai;
             $arr = explode('-', $oldDate2);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_pemasangan_mulai2 = $arr[2].'-'.$arr[1].'-'.$arr[0];

             }

             else

             {
               
                $tanggal_pemasangan_mulai2 = null;


             }



             $oldDate3 = $tanggal_aktifasi;
             $arr = explode('-', $oldDate3);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_aktifasi2 = $arr[2].'-'.$arr[1].'-'.$arr[0];




           


          
            $dataUnit2 =
                [

                    'parent_id' => $parent_id,
                    'unit_id' => $dataTmp['pilih_unit'],
                    'unit' => $dataTmp['unit'],
                    'customer_id' => $dataTmp['customer_id'],
                    'customer_name' => $dataTmp['customer_name'],
                    'project_id'    => $project->id,
                    'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                    'nomor_telepon' => $dataTmp['nomor_telepon'],
                    'nomor_handphone' => $dataTmp['nomor_handphone'],
                    'email' => $dataTmp['email'],
                    'tanggal_document' => $tanggal_document2,
                    'tanggal_pemasangan_mulai' => $tanggal_pemasangan_mulai2,
                    'tanggal_aktifasi' => $tanggal_aktifasi2, 
                    'jenis_bayar' => $dataTmp['jenis_bayar'],  
                    'jenis_paket_id' => $paket[0],
                    'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                    'harga_lain_lain' => $this->m_core->currency_to_number($dataTmp['harga_lain_lain']),
                    'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['harga_registrasi']),
                    'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                    'total' => $this->m_core->currency_to_number($dataTmp['total']),
                    'keterangan' => $dataTmp['keterangan'],
                    'nomor_registrasi' => $nomor_registrasi,
                    'status_bayar' => 0,
                    'active' => 1,
                    'delete' => 0,
                ];




            $this->db->insert('t_tvi_registrasi', $dataUnit2);
            $id = $this->db->insert_id();


            $dataLog = $this->get_log($this->db->insert_id());
            $this->m_log->log_save('t_tvi_registrasi', $this->db->insert_id(), 'Tambah', $dataLog);

           


            $query = $this->db->query("



         SELECT  

            group_tvi.jumlah_hari as jumlah_hari                  
            

            FROM   paket_tvi
            LEFT JOIN group_tvi on group_tvi.id = paket_tvi.group_tvi_id
            Where  group_tvi.project_id =  $project->id and paket_tvi.id = $paket[0]





        ");


                       $row = $query->row();
                          
                         // echo('<PRE>');
              
                         // print_r($row);

                         // echo('</PRE>');

                        if (isset($row) )
                        {
                       
                      

                          $jumlah_hari        = $row->jumlah_hari;
                          
                        }



                        //$jumlah_hari = 30;

                         $jumbulan = floor( $jumlah_hari/30 );


                          $aktifasi_date = $dataTmp['tanggal_aktifasi'];


                         if ($jumbulan == '1')

                         {

                        
                         $d = date_parse_from_format("m-d-Y", $aktifasi_date);


                         $thisday = $d["day"];



                         echo('<PRE>');

                         echo 'thisday';
              
                         print_r($thisday);

                         echo('</PRE>');



                         $thismonth = $d["month"];

                         
                          echo('<PRE>');

                          echo '$thismonth';
              
                         print_r($thismonth);

                         echo('</PRE>');





                         $thisyear = $d["year"];



                          echo('<PRE>');

                          echo '$thisyear';
              
                         print_r($thisyear);

                         echo('</PRE>');


                        // $bln = $thisyear + '-' + $thismonth + '-' + $thisday;

                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$arr[0].'-'.$arr[1];




                      
                        $bln = $aktifasi_date;



                          echo('<PRE>');

                          echo '$bln';
              
                         print_r($bln);

                         echo('</PRE>');


                           $last_day = date('t', strtotime($newDate));
                       

                          echo('<PRE>');

                          echo'lastday';
              
                         print_r($last_day);

                         echo('</PRE>');



                          $harga_paket =  $this->m_core->currency_to_number($dataTmp['harga_paket']);

                          $total_per_bulan = $harga_paket / $jumbulan;


                          $total_proportional = (($last_day -   $thisday) / $last_day ) * $total_per_bulan ;


                           $kode_tagihan =  $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayapasang =  $this->m_core->currency_to_number($dataTmp['harga_lain_lain']);


                           $jenis_pemasangan =  $dataTmp['jenis_pemasangan'] ;


                            if ( ( $total_biayapasang != 0 ) &&   ( $jenis_pemasangan == '1' ))

                            {


                           $dataTagihan =
                           [
                             'kode_bill' => $kode_tagihan,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayapasang,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 1,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }



                             $kode_tagihan2 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayaregistrasi =  $this->m_core->currency_to_number($dataTmp['harga_registrasi']);


                            if ( ( $total_biayaregistrasi != 0 ) &&  ( $jenis_pemasangan == '1' ))
                            {


                           $dataTagihan2 =
                           [
                             'kode_bill' => $kode_tagihan2,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayaregistrasi,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 2,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan2);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }

                           $kode_tagihan3 =  $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);




                           $dataTagihan3 =
                           [
                             'kode_bill' => $kode_tagihan3,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' => $total_proportional,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 3,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan3);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);







                         }


                         else if ($jumbulan != '1')

                         {





                         $d = date_parse_from_format("m-d-Y", $aktifasi_date);


                         $thisday = $d["day"];



                         echo('<PRE>');

                         echo('thisday');
              
                         print_r($thisday);

                         echo('</PRE>');



                         $thismonth = $d["month"];

                         
                          echo('<PRE>');

                           echo('thismonth');
              
                         print_r($thismonth);

                         echo('</PRE>');





                         $thisyear = $d["year"];



                          echo('<PRE>');

                           echo('thisyear');
              
                         print_r($thisyear);

                         echo('</PRE>');


                        // $bln = $thisyear + '-' + $thismonth + '-' + $thisday;


                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$arr[0].'-'.$arr[1];

                         
                          echo('<PRE>');

                           echo('newdate');
              
                         print_r($newDate);

                         echo('</PRE>');



                         $bln = $aktifasi_date;



                         $last_day = date('t', strtotime($newDate));



                          echo('<PRE>');

                           echo('last_day');
              
                         print_r($last_day);

                         echo('</PRE>');



                          $harga_paket =  $this->m_core->currency_to_number($dataTmp['harga_paket']);

                          $total_per_bulan = $harga_paket / $jumbulan;


                          echo('<PRE>');

                           echo('total_per_bulan');
              
                         print_r($total_per_bulan);

                         echo('</PRE>');



                          $total_proportional = (($last_day -   $thisday) / $last_day ) * $total_per_bulan ;

                        

                             $kode_tagihan =  $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayapasang =  $this->m_core->currency_to_number($dataTmp['harga_lain_lain']);


                           $jenis_pemasangan =  $dataTmp['jenis_pemasangan'] ;


                            if ((  $total_biayapasang != 0 ) && ($jenis_pemasangan == '1'))
                            {


                           $dataTagihan =
                           [
                             'kode_bill' => $kode_tagihan,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayapasang,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 1,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }



                             $kode_tagihan2 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayaregistrasi =  $this->m_core->currency_to_number($dataTmp['harga_registrasi']);


                            if ( ( $total_biayaregistrasi != 0 ) &&   ( $jenis_pemasangan == '1') )
                            {


                           $dataTagihan2=
                           [
                             'kode_bill' => $kode_tagihan2,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayaregistrasi,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 2,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan2);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }


                           $kode_tagihan3 =  $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);



                           $dataTagihan3 =
                           [
                             'kode_bill' => $kode_tagihan3,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' => $total_proportional,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 3,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan3);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);



                         // $nextmonth = date('Y-m-d', strtotime('+1 month', strtotime($aktifasi_date)));


                    

                          $date = new DateTime($newDate);
                          $date->modify('first day of +1 month');
                          $nextmonth =  $date->format('m'); // return February


                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$nextmonth.'-'.'01';
                


                          echo('<PRE>');

                          echo'nexmonthhhhh';
              
                         print_r($nextmonth);

                         echo('</PRE>');


                


                        // $tanggal_mulai = $thisyear + '-' + $thismonth + '-' + '01';


                        //  $tanggal_mulai = date('m-01-Y', strtotime($nextmonth));


                          $tanggal_mulai = $arr[2].'-'.$nextmonth.'-'.'01';
                




                          echo('<PRE>');

                          echo'startmonth';
              
                         print_r($tanggal_mulai);

                         echo('</PRE>');








             if (isset($jumbulan))
            {
            for ($i = 0; $i < ($jumbulan - 1); ++$i) {
                

               if ($i ==  0)
                {

                $bln=  $tanggal_mulai;

                 }

                else if ( $i != 0)

                {


                $bln = date('Y-m-d', strtotime("+".$i.' '."months", strtotime($tanggal_mulai)));

                }

               
                  $kode_tagihan4 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                $dataTagihan4 =
                [
                    'kode_bill' => $kode_tagihan4,
                    'tanggal' => $bln,
                    'project_id'    => $project->id,
                    'jenis_paket_id' => $paket[0],
                    'total' => $this->m_core->currency_to_number($total_per_bulan),
                    'registrasi_id' => $id,
                    'status_bayar' => 0,
                    'flag_type' => 3,
                    'active' => 0,
                    'delete' => 0,
                ];

                 $this->db->insert('t_tvi_tagihan', $dataTagihan4);
             
                 $dataLog = $this->get_log($id);
                 $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


            }
            }

        }
        

                      
            return 'success';
        } else if ($dataTmp['pilih_unit']  == 'non_unit') {


              $project = $this->m_core->project();


            $paket = explode('|', $dataTmp['jenis_paket_id']);

            $customer = explode('|', $dataTmp['customer_name2']);


            echo('<PRE>');
              
             print_r($dataTmp['jenis_paket_id']);

            echo('</PRE>');





            $dataNonUnit =
                [




                    'unit' => 'non_unit',
                    'customer_id' => $customer[0],
                    'customer_name' => $customer[1],
                    'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                    'nomor_registrasi' => $dataTmp['nomor_registrasi2'],
                    'project_id'      => $project->id,
                    'nomor_telepon' => $dataTmp['nomor_telepon2'],
                    'nomor_handphone' => $dataTmp['nomor_handphone2'],
                    'email' => $dataTmp['email2'],
                    'tanggal_document' => $dataTmp['tanggal_document'],
                    'tanggal_pemasangan_mulai' => $dataTmp['tanggal_pemasangan_mulai'],
                    'tanggal_aktifasi' => $dataTmp['tanggal_aktifasi'], 
                    'jenis_bayar' => $dataTmp['jenis_bayar'],  
                    'jenis_paket_id' => $paket[0],
                    'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                    'harga_lain_lain' => $this->m_core->currency_to_number($dataTmp['harga_lain_lain']),
                    'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['harga_registrasi']),
                    'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                    'total' => $this->m_core->currency_to_number($dataTmp['total']),
                    'keterangan' => $dataTmp['keterangan'],
                    'status_bayar' => 0,
                    'active' => 1,
                    'delete' => 0,


                ];

           
            $this->db->where('customer_id', $dataNonUnit['customer_id']);
            $this->db->from('t_tvi_registrasi');

            // validasi double
            if ($this->db->count_all_results() == 0) {

             
                $parent_id = 0;
            } else {


                $customer_id = $dataNonUnit['customer_id'];

                $query = $this->db->query("
           


                 SELECT TOP 1 id, nomor_registrasi
                   
                    
             
                FROM t_tvi_registrasi
                where t_tvi_registrasi.customer_id = $customer_id and t_tvi_registrasi.project_id = $project->id   and t_tvi_registrasi.unit = 'non_unit'  order by id desc 
            


                ");


                $row = $query->row();


                if (isset($row)) {


                    $parent_id  = $row->id;
                   // $nomor_reg  = $row->nomor_registrasi;
                }
            }


           $nomor_registrasi =  $dataTmp['nomor_registrasi2'] ;


             echo('<PRE>');

             echo 'nomor_registrasi';
             print_r($nomor_registrasi);

             echo('</PRE>');



            if ( $nomor_registrasi == 'Auto Generate')

            {

              $nomor_registrasi = "CG/REGISTRASITVI/".date("Y")."/".$this->m_core->numberToRomanRepresentation($this->m_core->project()->id)."/".($this->m_registrasi_tvi->last_id());
                   
            }


            else  


             {


              $nomor_registrasi =  $dataTmp['nomor_registrasi2'];



             }   


             $tanggal_document =  $dataTmp['tanggal_document'];

             $tanggal_pemasangan_mulai =  $dataTmp['tanggal_pemasangan_mulai'];
 
             $tanggal_aktifasi =  $dataTmp['tanggal_aktifasi'];
 



             $oldDate1 = $tanggal_document;
             $arr = explode('-', $oldDate1);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_document2 = $arr[2].'-'.$arr[1].'-'.$arr[0];


             if ($tanggal_pemasangan_mulai != null)
             {

             $oldDate2 = $tanggal_pemasangan_mulai;
             $arr = explode('-', $oldDate2);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_pemasangan_mulai2 = $arr[2].'-'.$arr[1].'-'.$arr[0];

             }

             else

             {

              $tanggal_pemasangan_mulai2 = null;


             }





             $oldDate3 = $tanggal_aktifasi;
             $arr = explode('-', $oldDate3);
           //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
             $tanggal_aktifasi2 = $arr[2].'-'.$arr[1].'-'.$arr[0];



           



            $dataNonUnit2=
            [



                'parent_id' => $parent_id,
                'unit' => 'non_unit',
                'customer_id' => $customer[0],
                'customer_name' => $customer[1],
                'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                'nomor_registrasi' => $nomor_registrasi,
                'project_id'      => $project->id,
                'nomor_telepon' => $dataTmp['nomor_telepon2'],
                'nomor_handphone' => $dataTmp['nomor_handphone2'],
                'email' => $dataTmp['email2'],
                'tanggal_document' => $tanggal_document2,
                'tanggal_pemasangan_mulai' => $tanggal_pemasangan_mulai2,
                'tanggal_aktifasi' => $tanggal_aktifasi2, 
                'jenis_bayar' => $dataTmp['jenis_bayar'],  
                'jenis_paket_id' => $paket[0],
                'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                'harga_lain_lain' => $this->m_core->currency_to_number($dataTmp['harga_lain_lain']),
                'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['harga_registrasi']),
                'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                'total' => $this->m_core->currency_to_number($dataTmp['total']),
                'keterangan' => $dataTmp['keterangan'],
                'status_bayar' => 0,
                'active' => 1,
                'delete' => 0,


            ];





            $this->db->insert('t_tvi_registrasi', $dataNonUnit2);
            $id = $this->db->insert_id();

            $dataLog = $this->get_log($this->db->insert_id());
            $this->m_log->log_save('t_tvi_registrasi', $this->db->insert_id(), 'Tambah', $dataLog);

           

              $query = $this->db->query("



         SELECT  

            group_tvi.jumlah_hari as jumlah_hari                  
            

            FROM   paket_tvi
            LEFT JOIN group_tvi on group_tvi.id = paket_tvi.group_tvi_id
            Where  group_tvi.project_id =  $project->id and paket_tvi.id = $paket[0]





        ");


                       $row = $query->row();
                          
                         // echo('<PRE>');
              
                         // print_r($row);

                         // echo('</PRE>');

                        if (isset($row) )
                        {
                       
                      

                          $jumlah_hari        = $row->jumlah_hari;
                          
                        }

                        //$jumlah_hari = 30;

                         $jumbulan = floor( $jumlah_hari/30 );


                         $aktifasi_date = $dataTmp['tanggal_aktifasi'];


                         if ($jumbulan == '1')

                         {

                        
                         $d = date_parse_from_format("m-d-Y", $aktifasi_date);


                         $thisday = $d["day"];



                         echo('<PRE>');

                         echo 'thisday';
              
                         print_r($thisday);

                         echo('</PRE>');



                         $thismonth = $d["month"];

                         
                          echo('<PRE>');

                          echo '$thismonth';
              
                         print_r($thismonth);

                         echo('</PRE>');





                         $thisyear = $d["year"];



                          echo('<PRE>');

                          echo '$thisyear';
              
                         print_r($thisyear);

                         echo('</PRE>');


                        // $bln = $thisyear + '-' + $thismonth + '-' + $thisday;

                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$arr[0].'-'.$arr[1];




                      
                        $bln = $aktifasi_date;



                          echo('<PRE>');

                          echo '$bln';
              
                         print_r($bln);

                         echo('</PRE>');


                        $last_day = date('t', strtotime($newDate));
                       

                          echo('<PRE>');

                          echo'lastday';
              
                         print_r($last_day);

                         echo('</PRE>');



                          $harga_paket =  $this->m_core->currency_to_number($dataTmp['harga_paket']);

                          $total_per_bulan = $harga_paket / $jumbulan;


                          $total_proportional = (($last_day -   $thisday) / $last_day ) * $total_per_bulan ;


                         
                          $kode_tagihan = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);



                          $total_biayapasang =  $this->m_core->currency_to_number($dataTmp['harga_lain_lain']);


                          $jenis_pemasangan =  $dataTmp['jenis_pemasangan'] ;


                            if ( ( $total_biayapasang != 0 ) && ($jenis_pemasangan =='1' ))
                            {


                           $dataTagihan =
                           [
                             'kode_bill' => $kode_tagihan,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayapasang,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 1,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }



                             $kode_tagihan2 =  $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayaregistrasi =  $this->m_core->currency_to_number($dataTmp['harga_registrasi']);


                            if ((  $total_biayaregistrasi != 0 ) && ( $jenis_pemasangan =='1'))
                            {


                           $dataTagihan2 =
                           [
                             'kode_bill' => $kode_tagihan2,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayaregistrasi,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 2,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan2);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }



                           $kode_tagihan3 = $project_code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);



                           $dataTagihan3 =
                           [
                             'kode_bill' => $kode_tagihan3,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' => $total_proportional,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 3,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan3);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);




                         }


                         else if ($jumbulan != '1')

                         {





                         $d = date_parse_from_format("m-d-Y", $aktifasi_date);


                         $thisday = $d["day"];



                         echo('<PRE>');

                         echo('thisday');
              
                         print_r($thisday);

                         echo('</PRE>');



                         $thismonth = $d["month"];

                         
                          echo('<PRE>');

                           echo('thismonth');
              
                         print_r($thismonth);

                         echo('</PRE>');





                         $thisyear = $d["year"];



                          echo('<PRE>');

                           echo('thisyear');
              
                         print_r($thisyear);

                         echo('</PRE>');


                        // $bln = $thisyear + '-' + $thismonth + '-' + $thisday;


                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$arr[0].'-'.$arr[1];

                         
                          echo('<PRE>');

                           echo('newdate');
              
                         print_r($newDate);

                         echo('</PRE>');



                         $bln = $aktifasi_date;



                         $last_day = date('t', strtotime($newDate));



                          echo('<PRE>');

                           echo('last_day');
              
                         print_r($last_day);


                          echo('</PRE>');





                          echo('<PRE>');

                           echo('PROJEECCCT');
              
                         print_r($project);

                         echo('</PRE>');




                          $harga_paket =  $this->m_core->currency_to_number($dataTmp['harga_paket']);

                          $total_per_bulan = $harga_paket / $jumbulan;


                          $total_proportional = (($last_day -   $thisday) / $last_day ) * $total_per_bulan ;


                          
                             $kode_tagihan = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayapasang =  $this->m_core->currency_to_number($dataTmp['harga_lain_lain']);

                           echo('<PRE>');

                           echo('total_biaya_pasaang');
              
                         print_r($total_biayapasang);

                         echo('</PRE>');


                         $jenis_pemasangan =  $dataTmp['jenis_pemasangan'] ;


                         if ( ( $total_biayapasang != 0 ) && ($jenis_pemasangan =='1' ))
                         {


                           $dataTagihan =
                           [
                             'kode_bill' => $kode_tagihan,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayapasang,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 1,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }



                             $kode_tagihan2 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                           $total_biayaregistrasi =  $this->m_core->currency_to_number($dataTmp['harga_registrasi']);


                            if ( ( $total_biayaregistrasi != 0 ) &&  ($jenis_pemasangan =='1' ))
                            {


                           $dataTagihan2 =
                           [
                             'kode_bill' => $kode_tagihan2,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' =>   $total_biayaregistrasi,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 2,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan2);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


                            }




                           $kode_tagihan3 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);



                           $dataTagihan3 =
                           [
                             'kode_bill' => $kode_tagihan3,
                             'tanggal' => $bln,
                             'project_id'    => $project->id,
                             'jenis_paket_id' => $paket[0],
                             'total' => $total_proportional,
                             'registrasi_id' => $id,
                             'status_bayar' => 0,
                             'flag_type' => 3,
                             'active' => 0,
                             'delete' => 0,
                            ];

                            $this->db->insert('t_tvi_tagihan', $dataTagihan3);
             
                            $dataLog = $this->get_log($id);
                             $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);



                         // $nextmonth = date('Y-m-d', strtotime('+1 month', strtotime($aktifasi_date)));


                    

                          $date = new DateTime($newDate);
                          $date->modify('first day of +1 month');
                          $nextmonth =  $date->format('m'); // return February


                          $oldDate = $aktifasi_date;
                          $arr = explode('-', $oldDate);
                        //  $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                          $newDate = $arr[2].'-'.$nextmonth.'-'.'01';
                


                          echo('<PRE>');

                          echo'nexmonthhhhh';
              
                         print_r($nextmonth);

                         echo('</PRE>');


                


                        // $tanggal_mulai = $thisyear + '-' + $thismonth + '-' + '01';


                        //  $tanggal_mulai = date('m-01-Y', strtotime($nextmonth));


                          $tanggal_mulai = $arr[2].'-'.$nextmonth.'-'.'01';
                




                          echo('<PRE>');

                          echo'startmonth';
              
                         print_r($tanggal_mulai);

                         echo('</PRE>');








             if (isset($jumbulan))
            {
            for ($i = 0; $i < ($jumbulan - 1); ++$i) {
                

               if ($i ==  0)
                {

                $bln=  $tanggal_mulai;

                 }

                else if ( $i != 0)

                {


                $bln = date('Y-m-d', strtotime("+".$i.' '."months", strtotime($tanggal_mulai)));

                }

               
                  $kode_tagihan4 = $project->code."/TAGIHANTVI/" . date("Y") . "/" . $this->m_core->numberToRomanRepresentation($this->m_core->project()->id) . "/" . ($this->m_registrasi_tvi->last_id_tagihan() + 1);


                $dataTagihan4 =
                [
                    'kode_bill' => $kode_tagihan4,
                    'tanggal' => $bln,
                    'project_id'    => $project->id,
                    'jenis_paket_id' => $paket[0],
                    'total' => $this->m_core->currency_to_number($total_per_bulan),
                    'registrasi_id' => $id,
                    'status_bayar' => 0,
                    'flag_type' => 3,
                    'active' => 0,
                    'delete' => 0,
                ];

                echo('<PRE>');

                           echo('dataTagihan4');
              
                         print_r($dataTagihan4);

                         echo('</PRE>');


                 $this->db->insert('t_tvi_tagihan', $dataTagihan4);
             
                 $dataLog = $this->get_log($id);
                 $this->m_log->log_save('t_tvi_tagihan', $id, 'Tambah', $dataLog);


            }
            }

        }
        
            
            return 'success';



             }

             else {
            //    return 'double';
            // }
        }
    }


    public function last_id()
    {
        $query = $this->db->query("
            SELECT TOP 1 id FROM t_tvi_registrasi
            ORDER by id desc
        ");
        return $query->row() ? $query->row()->id : 0;
    }


    public function last_id_tagihan()
    {
        $query = $this->db->query("
            SELECT TOP 1 id FROM t_tvi_tagihan
            ORDER by id desc
        ");
        return $query->row() ? $query->row()->id : 0;
    }





    public function getAll()
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();
        $query = $this->db->query("
           SELECT 
                  
                   

                   t_tvi_registrasi.customer_name as customer,
                   t_tvi_registrasi.id as id,
                   case when t_tvi_registrasi.jenis_pemasangan ='1' then 'Pemasangan Baru' else 'Perpanjangan Paket' end as jenis_layanan, 
                   t_tvi_registrasi.tanggal_document as tanggal_document,
                   t_tvi_registrasi.tanggal_pemasangan_mulai as tanggal_pemasangan_mulai,
                   t_tvi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
                   t_tvi_registrasi.jenis_paket_id as jenis_paket_id,
                   t_tvi_registrasi.keterangan as keterangan,
                   t_tvi_registrasi.harga_paket as harga_paket,
                   t_tvi_registrasi.harga_lain_lain  as harga_pasang,
                   t_tvi_registrasi.diskon  as diskon,
                   t_tvi_registrasi.total as total,
                   CASE
                   WHEN t_tvi_registrasi.status_bayar = 1 THEN
                   'Lunas' 
                   WHEN t_tvi_registrasi.status_bayar = 2 THEN
                   'Pemutihan' 
                   WHEN t_tvi_registrasi.status_bayar = 0 THEN
                   'Tagihan'                   
                   END AS status_bayar,

                   t_tvi_registrasi.active as active,
                   t_tvi_registrasi.unit as unit,
                   CASE
                   WHEN t_tvi_biaya_tambahan.status_bayar = 1 THEN
                   'Lunas' 
                   WHEN t_tvi_biaya_tambahan.status_bayar = 2 THEN
                   'Pemutihan' 
                   WHEN t_tvi_biaya_tambahan.status_bayar = 0 THEN
                   'Tagihan'                   
                   END AS status_bayar_biaya,


                    paket_tvi.description as keterangan_paket,
                    paket_tvi.name as jenis_paket
                    
             
            FROM t_tvi_registrasi
            left join paket_tvi on t_tvi_registrasi.jenis_paket_id = paket_tvi.id
            left join t_tvi_biaya_tambahan on t_tvi_biaya_tambahan.registrasi_id = t_tvi_registrasi.id
          
            where  t_tvi_registrasi.[delete] = 0 and
            t_tvi_registrasi.project_id = $project->id 
            order by t_tvi_registrasi.id desc 
            
        ");

        return $query->result_array();
    }





    public function cek($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
           
             SELECT 
                  
                   

                   t_tvi_registrasi.customer_name as customer,
                   t_tvi_registrasi.id as id,
                   t_tvi_registrasi.jenis_pemasangan as jenis_layanan,
                   t_tvi_registrasi.tanggal_document as tanggal_document,
                   t_tvi_registrasi.tanggal_pemasangan_mulai as tanggal_pemasangan_mulai,
                   t_tvi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
                   t_tvi_registrasi.jenis_paket_id as jenis_paket_id,
                   t_tvi_registrasi.keterangan as keterangan,
                   t_tvi_registrasi.harga_paket as harga_paket,
                   t_tvi_registrasi.harga_lain_lain  as harga_pasang,
                   t_tvi_registrasi.diskon  as diskon,
                   t_tvi_registrasi.total as total,
                   t_tvi_registrasi.status_bayar as status_bayar,
                   t_tvi_registrasi.active as active,
                   t_tvi_registrasi.unit as unit,


                    paket_tvi.description as keterangan_paket,
                    paket_tvi.name as jenis_paket
                    
             
            FROM t_tvi_registrasi
            left join paket_tvi on t_tvi_registrasi.jenis_paket_id = paket_tvi.id
          
            where 
            t_tvi_registrasi.project_id = $project->id and t_tvi_registrasi.id = $id
            order by t_tvi_registrasi.id desc 
            


            ");
        $row = $query->row();

        return isset($row) ? 1 : 0;
    }

    public function getSelect($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
        
        SELECT     project.name as project,
                   kawasan.name as kawasan,
                   blok.name as blok,
                   unit.no_unit as unit,
                   unit.id as unit_id,
                   t_tvi_registrasi.customer_name as customer,
                   t_tvi_registrasi.email as email,
                   t_tvi_registrasi.nomor_handphone as no_hp,
                   t_tvi_registrasi.nomor_registrasi as nomor_registrasi,
                   t_tvi_registrasi.nomor_telepon as telepon,
                   t_tvi_registrasi.id_tagihan as id_tagihan,


                   t_tvi_registrasi.jenis_pemasangan as jenis_pemasangan,
                   t_tvi_registrasi.tanggal_document as tanggal_document,
                   t_tvi_registrasi.tanggal_pemasangan_mulai as tanggal_pemasangan_mulai,
                   t_tvi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
                   t_tvi_registrasi.jenis_paket_id as jenis_paket_id,
                   t_tvi_registrasi.keterangan as keterangan,
                   t_tvi_registrasi.harga_paket as harga_paket,
                   t_tvi_registrasi.harga_lain_lain  as harga_pasang,
                   t_tvi_registrasi.biaya_registrasi  as biaya_registrasi,
                   t_tvi_registrasi.diskon  as diskon,
                   t_tvi_registrasi.total as total,

                    paket_tvi.description as keterangan_paket,
                    paket_tvi.name as jenis_paket,

                    customer.id as customer_id,
                    paket_tvi.bandwidth as bandwidth





        FROM t_tvi_registrasi
            left join paket_tvi on t_tvi_registrasi.jenis_paket_id = paket_tvi.id
            left join unit on unit.id = t_tvi_registrasi.unit_id
            left join blok on unit.blok_id = blok.id
            left join kawasan on blok.kawasan_id = kawasan.id
            left join project on project.id = kawasan.project_id
            left join customer on unit.pemilik_customer_id = customer.id 
            where 

            t_tvi_registrasi.id = $id and
            kawasan.project_id = $project->id  
            


        ");
        $row = $query->row();

        return $row;
    }


    public function getSelectNonUnit($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
        
       SELECT 
                  
                   

                   t_tvi_registrasi.customer_name as customer,
                   t_tvi_registrasi.email as email,
                   t_tvi_registrasi.nomor_handphone as no_hp,
                   t_tvi_registrasi.nomor_registrasi as nomor_registrasi,
                   t_tvi_registrasi.nomor_telepon as telepon,
                   t_tvi_registrasi.id_tagihan as id_tagihan,


                   t_tvi_registrasi.id as id,
                   t_tvi_registrasi.jenis_pemasangan as jenis_pemasangan,
                   t_tvi_registrasi.tanggal_document as tanggal_document,
                   t_tvi_registrasi.tanggal_pemasangan_mulai as tanggal_pemasangan_mulai,
                   t_tvi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
                   t_tvi_registrasi.jenis_paket_id as jenis_paket_id,
                   t_tvi_registrasi.keterangan as keterangan,
                   t_tvi_registrasi.harga_paket as harga_paket,
                   t_tvi_registrasi.harga_lain_lain  as harga_pasang,
                   t_tvi_registrasi.biaya_registrasi  as biaya_registrasi,
                   t_tvi_registrasi.diskon  as diskon,
                   t_tvi_registrasi.total as total,
                   t_tvi_registrasi.status_bayar as status_bayar,
                   t_tvi_registrasi.active as active,
                   t_tvi_registrasi.unit as unit,


                    paket_tvi.description as keterangan_paket,
                    paket_tvi.name as jenis_paket,
                    paket_tvi.bandwidth as bandwidth
                    
             
            FROM t_tvi_registrasi
            left join paket_tvi on t_tvi_registrasi.jenis_paket_id = paket_tvi.id
          
            where 
            t_tvi_registrasi.project_id = $project->id  and t_tvi_registrasi.id = $id
            order by t_tvi_registrasi.id asc


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
                   project.name as project,
                   kawasan.name as kawasan,
                   blok.name as blok,
                   unit.no_unit as unit,
                   unit.id as unit_id,
                   customer.name as customer,
                   customer.email as email,
                   customer.mobilephone1 as no_hp,
                   customer.code as nomor_registrasi,
                   customer.homephone as telepon,



                   t_tvi_registrasi.jenis_pemasangan as jenis_pemasangan,
                   t_tvi_registrasi.tanggal_document as tanggal_document,
                   t_tvi_registrasi.tanggal_pemasangan_mulai as tanggal_pemasangan_mulai,
                   t_tvi_registrasi.tanggal_pemasangan_berakhir as tanggal_pemasangan_berakhir,
                   t_tvi_registrasi.jenis_paket_id as jenis_paket_id,
                   t_tvi_registrasi.keterangan as keterangan,
                   t_tvi_registrasi.harga_paket as harga_paket,
                   t_tvi_registrasi.harga_lain_lain  as harga_pasang,
                   t_tvi_registrasi.diskon  as diskon,
                   t_tvi_registrasi.total as total,

                    paket_tvi.description as keterangan_paket,
                    paket_tvi.name as jenis_paket
                    
             
            FROM t_tvi_registrasi
            left join t_tvi_tagihan on t_tvi_tagihan.registrasi_id = t_tvi_registrasi.id
            left join paket_tvi on t_tvi_registrasi.jenis_paket_id = paket_tvi.id
            left join unit on unit.no_unit = t_tvi_registrasi.unit
            left join customer on unit.pemilik_customer_id = customer.id
            left join blok on unit.blok_id = blok.id
            left join kawasan on blok.kawasan_id = kawasan.id
            left join project on project.id = kawasan.project_id 
            where 
            t_tvi_registrasi.id = $id and
            kawasan.project_id = $project->id  
            


        ");
        $row = $query->row();

        return $row;
    }


    public function get_log_tagihan($id)
    {
        $this->load->model('m_core');
        $project = $this->m_core->project();

        $query = $this->db->query("
           


            SELECT *
                   
                    
             
            FROM t_tvi_tagihan
            where t_tvi_tagihan.id = $id and t_tvi_tagihan.project_id = $project->id  
            


        ");
        $row = $query->row();

        return $row;
    }





    public function edit($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();





        $paket = explode('|', $dataTmp['jenis_paket_id']);





        $this->db->where('project_id', $project->id);
        $this->db->from('t_tvi_registrasi');
        // echo("<pre>");
        //     print_r($dataTmp);
        // echo("</pre>");
        
        $dataUnit =
            [


                'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                'nomor_registrasi' => $dataTmp['nomor_registrasi'],
                'tanggal_document' => $dataTmp['tanggal_document'],
                'tanggal_pemasangan_mulai' => $dataTmp['tanggal_pemasangan_mulai'],
                'jenis_paket_id' => $paket[0],
                'harga_paket' =>  $this->m_core->currency_to_number($dataTmp['harga_paket']),
                'harga_lain_lain' =>  $this->m_core->currency_to_number($dataTmp['harga_pasang']),
                'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['biaya_registrasi']),
                'diskon' => $dataTmp['diskon'],
                'total' =>  $this->m_core->currency_to_number($dataTmp['total']),
                'keterangan' => $dataTmp['keterangan'],
                'status_bayar' => 0,
                'active' => 0,
                'delete' => 0,


            ];



        // validasi apakah user dengan project $project boleh edit data ini
        if ($this->db->count_all_results() != 0) {


            $this->db->where('nomor_registrasi', $dataTmp['nomor_registrasi'])->where('id !=', $dataTmp['id']);
            $this->db->from('t_tvi_registrasi');
            // validasi double
            if ($this->db->count_all_results() == 0) {




                $before = $this->get_log($dataTmp['id']);
                $this->db->where('id', $dataTmp['id']);
                $this->db->update('t_tvi_registrasi', $dataUnit);
                $after = $this->get_log($dataTmp['id']);




                $id = $dataTmp['id'];

                // echo '<PRE>';
                // print_r($id);
                // echo '<PRE>';


                $query = $this->db->query("
           


                SELECT TOP 1 id
                  
                   
            
               FROM t_tvi_tagihan
               where t_tvi_tagihan.registrasi_id = $id and t_tvi_tagihan.project_id = $project->id   
               order by id desc 
           


               ");


               $row = $query->row();


               if (isset($row) )
               {

                 
                   $tagihan_id  = $row->id;


               }



                $dataTagihan =
                    [


                        'project_id'    => $project->id,
                        'tanggal' =>  $dataTmp['tanggal_document'],
                        'jenis_paket_id' => $paket[0],
                        'total' => $this->m_core->currency_to_number($dataTmp['total']),
                        'registrasi_id' => $dataTmp['id'],
                        'status_bayar' => 0,
                        'active' => 1,
                        'delete' => 0,
                    ];



                $beforeTagihan = $this->get_log_tagihan($tagihan_id);
                $this->db->where('id', $tagihan_id);
                $this->db->update('t_tvi_tagihan', $dataTagihan);
                $afterTagihan = $this->get_log_tagihan($tagihan_id);

                $diff = (object)(array_diff_assoc((array)$after, (array)$before));
                $tmpDiff = (array)$diff;



                $diff2 = (object)(array_diff_assoc((array)$afterTagihan, (array)$beforeTagihan));
                $tmpDiff2 = (array)$diff2;


                if ($tmpDiff) {
                    $this->m_log->log_save('t_tvi_registrasi', $dataTmp['id'], 'Edit', $diff);



                    return 'success';
                } else if ($tmpDiff2) {


                    $this->m_log->log_save('t_tvi_tagihan', $tagihan_id, 'Edit', $diff2);


                    return 'success';
                } else {
                    return 'Tidak Ada Perubahan';
                }
            } else { }
        }
    }



    public function edit_non_unit($dataTmp)
    {

        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();



        $paket = explode('|', $dataTmp['jenis_paket_id']);






        $dataNonUnit =
            [



                'jenis_pemasangan' => $dataTmp['jenis_pemasangan'],
                'nomor_registrasi' => $dataTmp['nomor_registrasi2'],
                'project_id'      => $project->id,
                'tanggal_document' => $dataTmp['tanggal_document'],
                'jenis_paket_id' => $paket[0],
                'harga_paket' => $this->m_core->currency_to_number($dataTmp['harga_paket']),
                'harga_lain_lain' => $this->m_core->currency_to_number($dataTmp['harga_pasang']),
                'biaya_registrasi' => $this->m_core->currency_to_number($dataTmp['biaya_registrasi']),
                'diskon' => $this->m_core->currency_to_number($dataTmp['diskon']),
                'total' => $this->m_core->currency_to_number($dataTmp['total']),
                'keterangan' => $dataTmp['keterangan'],
                'status_bayar' => 0,
                'active' => 0,
                'delete' => 0,


            ];


        $this->db->where('nomor_registrasi', $dataTmp['nomor_registrasi2'])->where('id', $dataTmp['id']);
        $this->db->from('t_tvi_registrasi');


        // echo '<PRE>';
        // print_r($this->db->count_all_results());
        // echo '</PRE>';

        // validasi double
        if ($this->db->count_all_results() > 0) {




            $before = $this->get_log($dataTmp['id']);
            $this->db->where('id', $dataTmp['id']);
            $this->db->update('t_tvi_registrasi', $dataNonUnit);
            $after = $this->get_log($dataTmp['id']);




            $id = $dataTmp['id'];


            $query = $this->db->query("
           


            SELECT TOP 1 id
              
               
        
           FROM t_tvi_tagihan
           where t_tvi_tagihan.registrasi_id = $id and t_tvi_tagihan.project_id = $project->id   
           order by id desc 
       


           ");


           $row = $query->row();


           if (isset($row) )
           {

             
               $tagihan_id  = $row->id;


           }


           



            $dataTagihan =
                [


                    'project_id'    => $project->id,
                    'tanggal' =>  $dataTmp['tanggal_document'],
                    'jenis_paket_id' => $paket[0],
                    'total' => $this->m_core->currency_to_number($dataTmp['total']),
                    'registrasi_id' => $id,
                    'status_bayar' => 0,
                    'active' => 1,
                    'delete' => 0,
                ];





            $beforeTagihan = $this->get_log_tagihan($tagihan_id);
            $this->db->where('id', $tagihan_id);
            $this->db->update('t_tvi_tagihan', $dataTagihan);
            $afterTagihan = $this->get_log_tagihan($tagihan_id);

            $diff = (object)(array_diff_assoc((array)$after, (array)$before));
            $tmpDiff = (array)$diff;



            $diff2 = (object)(array_diff_assoc((array)$afterTagihan, (array)$beforeTagihan));
            $tmpDiff2 = (array)$diff2;


            if ($tmpDiff) {
                $this->m_log->log_save('t_tvi_registrasi', $dataTmp['id'], 'Edit', $diff);



                return 'success';
            } else if ($tmpDiff2) {


                $this->m_log->log_save('t_tvi_tagihan', $tagihan_id, 'Edit', $diff2);


                return 'success';
            } else {
                return 'Tidak Ada Perubahan';
            }


            echo '<PRE>';
            print_r($tmpDiff);
            echo '</PRE>';


            echo '<PRE>';
            print_r($tmpDiff2);
            echo '</PRE>';
        } else {
            return 'double';
        }
    }




    public function delete($dataTmp)
    {
        $this->load->model('m_core');
        $this->load->model('m_log');
        $project = $this->m_core->project();
        $user_id = $this->m_core->user_id();


        $this->db->where('project_id', $project->id);
        $this->db->from('t_tvi_registrasi');

        // validasi apakah user dengan project $project boleh edit data ini
        if ($this->db->count_all_results() != 0) {
            $before = $this->get_log($dataTmp['id']);
            $this->db->where('id', $dataTmp['id']);
            $this->db->update('t_tvi_registrasi', ['delete' => 1]);
            $after = $this->get_log($dataTmp['id']);

            $diff = (object)(array_diff((array)$after, (array)$before));
            $tmpDiff = (array)$diff;

            if ($tmpDiff) {
                $this->m_log->log_save('t_tvi_registrasi', $dataTmp['id'], 'Edit', $diff);

                return 'success';
            } else {
                return 'Tidak Ada Perubahan';
            }
        }
    }
}
