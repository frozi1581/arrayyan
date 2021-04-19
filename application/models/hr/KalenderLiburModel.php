<?php

class KalenderLiburModel extends CI_model {
    //Retrieve data from Kalender libur table
    public function getData() {
        $query = $this->db->query("SELECT * FROM HRMS.KALENDER_LIBUR")->result();
                          
        if($query)
            return $query;
        else
            return FALSE;
    }
    public function create($date, $ket, $status) {
        $query = $this->db->query("INSERT INTO HRMS.KALENDER_LIBUR(TGL, KETERANGAN, STATUS) VALUES(TO_DATE('".$date."','YYYY-MM-DD'), '".$ket."', '".$status."')");
        
        if($query) 
            return true;
        else
            return false;
    }
    public function update($date, $ket, $status) {
        $query = $this->db->query("UPDATE
                                        HRMS.KALENDER_LIBUR a
                                    SET
                                        a.KETERANGAN = '".$ket."',
                                        a.STATUS = '".$status."'
                                    WHERE
                                        a.TGL = to_date('".$date."', 'dd-mon-yy')");
        
        if($query) 
            return true;
        else
            return false;
    }
    
    public function delete($date) {
        $query = $this->db->query("DELETE FROM HRMS.KALENDER_LIBUR
                                    WHERE TGL = '".$date."'");
        
        if($query)
            return true;
        else
            return false;
    }
}