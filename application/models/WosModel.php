<?php

class WosModel extends CI_model {
    //Retrieve data from GCG_QUESTION table
    public function getData($value, $year, $kd_sbu) {
        $query = $this->db->query("SELECT (a.THN||''||a.KD_PAT||''||a.BLN||''||a.KD_SBU)id, a.*
                                    FROM WOS.UTIL_PROD_H a
                                    WHERE a.KD_PAT = '".$value."' AND a.THN = '".$year."' AND a.KD_SBU LIKE '".$kd_sbu."'
                                    ORDER BY a.KD_SBU ASC, a.BLN")->result_array();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }
    public function getSpecificRa($kdpat, $year, $kdsbu, $bln) {
        $query = $this->db->query("SELECT A.RA_PER_BLN_M3
                                    FROM WOS.UTIL_PROD_H a
                                    WHERE a.KD_PAT = '".$kdpat."' AND a.THN = '".$year."' AND a.KD_SBU = '".$kdsbu."' AND A.BLN = '".$bln."' ")->result_array();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }
    public function getSpecificKumRa($kdpat, $year, $kdsbu, $bln) {
        $query = $this->db->query("SELECT A.KUM_RA_M3
                                    FROM WOS.UTIL_PROD_H a
                                    WHERE a.KD_PAT = '".$kdpat."' AND a.THN = '".$year."' AND a.KD_SBU = '".$kdsbu."' AND A.BLN = '".$bln."' ")->result_array();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }
    public function getSpecificKumRi($kdpat, $year, $kdsbu, $bln) {
        $query = $this->db->query("SELECT A.KUM_RI_M3
                                    FROM WOS.UTIL_PROD_H a
                                    WHERE a.KD_PAT = '".$kdpat."' AND a.THN = '".$year."' AND a.KD_SBU = '".$kdsbu."' AND A.BLN = '".$bln."' ")->result_array();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }
    public function checkData($year, $code) {
        $query = $this->db->query("SELECT *
                                    FROM WOS.UTIL_PROD_H a
                                    WHERE a.THN = '".$year."' AND a.KD_PAT = '".$code."' AND ROWNUM = 1")->result();
                                        
        if($query)
            return TRUE;
        else
            return FALSE;
    }
    

    public function getKdPatList() {
        $query = $this->db->query("SELECT a.KD_PAT, a.KET FROM HRMS.TB_PAT a
                                    WHERE a.KD_PAT LIKE '2%' and a.kd_pat not in ('2I','2K','2L','2M','2N','2O','2Q','2R')
                                    ORDER BY a.KD_PAT ASC")->result();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }

    public function insertRealisasi($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("INSERT INTO WOS.UTIL_PROD_H a (a.THN,
                                                                a.KD_PAT,
                                                                a.KD_SBU,
                                                                a.BLN,
                                                                a.RI_PER_BLN_M3)
                                                        VALUES ('".$year."', '".$kdpat."', '".$kdsbu."', '".$month."', '".$riValue."')");

        if($query) 
            return true;
        else
            return false;
    }

    public function updateRa($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.RA_PER_BLN_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }
    public function updateKumRa($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.KUM_RA_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }
    public function updateRi($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.RI_PER_BLN_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }
    public function updateRiVsRa($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.RI_VS_RA_PERSEN_BLN_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }
    public function updateKumRi($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.KUM_RI_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }
    public function updateKumVsKumRa($year, $kdpat, $kdsbu, $month, $riValue) {
        $query = $this->db->query("UPDATE
                                        WOS.UTIL_PROD_H a
                                    SET
                                        a.KUM_VS_KUMRA_PERSEN_M3 = '".$riValue."'
                                    WHERE
                                        a.THN = '".$year."' AND a.KD_PAT = '".$kdpat."' AND a.KD_SBU = '".$kdsbu."' AND a.BLN = '".$month."' ");

        if($query) 
            return true;
        else
            return false;
    }

}