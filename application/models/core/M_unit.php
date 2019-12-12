<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_unit extends CI_Model
{
    public function getService($unit_id)
    {
        $query = $this->db->query("
                            SELECT 
                                *
                            FROM v_unit_service
                            WHERE unit_id = $unit_id
                        ");
        return $query->result();
    }
    public function getTagihan($unit_id){
        $query = $this->db->query("
                    SELECT 
                        vus.*,
                        CASE 
                            WHEN vta.total_tagihan IS NOT NULL THEN vta.total_tagihan
                            WHEN vtl.total_tagihan IS NOT NULL THEN vtl.total_tagihan
                        END as total_tagihan
                    FROM v_unit_service as vus
                    LEFT JOIN v_tagihan_air as vta
                        on vta.unit_id = vus.unit_id
                        AND vus.service_jenis = 1
                    LEFT JOIN v_tagihan_lingkungan as vtl
                        on vtl.unit_id = vus.unit_id
                        AND vus.service_jenis = 2
                    WHERE vus.unit_id = $unit_id 
                    AND
                        CASE 
                            WHEN vta.total_tagihan IS NOT NULL THEN vta.total_tagihan
                            WHEN vtl.total_tagihan IS NOT NULL THEN vtl.total_tagihan
                        END IS NOT NULL
                ");
        $tagihan = $query->result();
        // echo("<pre>");
        //     print_r($tagihan);
        // echo("</pre>");
        
        // $query = $this->db->query("
        //                             SELECT
        //                                 service ='Air',
        //                                 t_tagihan_air.periode,
        //                                 t_tagihan_air.nilai +
        //                                 t_tagihan_air.denda +
        //                                 t_tagihan_air.penalti
                                        
        //                             FROM unit
        //                             JOIN t_tagihan_air
        //                                 on t_tagihan_air.unit_id = unit.id
        //                             WHERE unit.id = $unit_id    
        // ");
        // $tagihanAir = $query->result();
        return $tagihan;
    }
    public function getUnitBlokKawasan($unit_id){
        $query = $this->db->query("
                                    SELECT 
                                        unit.no_unit as unit,
                                        blok.name as blok,
                                        kawasan.name as kawasan
                                    FROM unit
                                    JOIN blok
                                        on blok.id = unit.blok_id
                                    JOIN kawasan
                                        on kawasan.id = blok.kawasan_id
                                    WHERE unit.id = $unit_id
        ");
        return $query->row();
    }
    public function test(){

        $awal_periode = $this->db->select("*")
                            ->from("v_tagihan_lingkungan")
                            ->where("periode <= '2019-06-01'")
                            ->where("unit_id",202)
                            ->where("status_bayar_flag",0)
                            ->order_by('periode')
                            ->get()->row();
        $awal_periode = $awal_periode?$awal_periode->periode:null;
        if($awal_periode){
            $query = $this->db->select("*")
                                ->from("v_tagihan_lingkungan")
                                ->where("periode <= '2019-06-01'")
                                ->where("periode >= '$awal_periode'")
                                ->where("unit_id",202)
                                ->get()->result();
            // echo("<pre>");
            //     print_r($awal_periode);
            // echo("</pre>");
            // echo("<pre>");
            //     print_r($query);
            // echo("</pre>");
        }                            
                
    }

}
