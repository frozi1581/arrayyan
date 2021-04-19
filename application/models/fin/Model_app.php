<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_app extends CI_Model
{
    function logged_id()
    {
        return $this->session->userdata('USRID');
    }

    public function is_biro()
    {
      return $this->session->userdata('KET_GAS');
    }

    public function login_auth($username, $password)
    {
        $query = $this->db->query("SELECT  A.USRID, A.EMPLOYEE_ID, A.PASSWD,
                                  C.KET KET_JBT,D.KET KET_GAS, D.KD_GAS
                                  FROM USRADM.USERS A,HRMS.PERSONAL B,HRMS.TB_JBT C,HRMS.TB_GAS  D
                                  WHERE A.EMPLOYEE_ID=B.EMPLOYEE_ID  AND B.KD_JBT=C.KD_JBT AND B.KD_GAS=D.KD_GAS
                                  AND A.USRID='".$username."' AND A.PASSWD='".$password."'")->result();
        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function pushNotifBiro($biro)
    {
        $query = $this->db->query("select count(a.ticket_id) as sum from wfinance.rkap_ticket a where a.biro = '".$biro."' ")->result();
        if($query)
            return $query;
        else
            return false;
    }

    public function get_ticket_biro($biro)
    {
        $query = $this->db->query("SELECT a.ticket_id, a.requestor, a.jabatan, a.biro, a.dokumen, a.tanggal, a.pesan, 
                                    case a.keterangan
                                      when '0' THEN '0'
                                      when '1' THEN 'Requested / Waiting Approval'
                                      when '2' THEN 'Rejected'
                                      when '3' THEN 'Approved'
                                    end as status
                                    FROM WFINANCE.RKAP_TICKET a 
                                    WHERE a.biro = '".$biro."'")->result();
        if($query){
          return $query;
        }else{
            return false;
        }
    }

    public function getBiro()
    {
        $query = $this->db->query("SELECT DISTINCT a.BIRO FROM WFINANCE.RKAP_MASTER_KODE a ")->result();

        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function getAccountDS($biro)
    {
        $query = $this->db->query("SELECT DISTINCT a.ID_KODE FROM WFINANCE.RKAP_MASTER_KODE a WHERE a.KET_KD_GAS = '".$biro."'")->result();

        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }

    }

    public function subquery()
    {
      $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_RENCANA")->result();
      if ($query) {
        # code...
        return $query;
      } else {
        return false;
      }
    }
	//fungsi check login
    public function check_login($table, $username, $password)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($username);
        $this->db->where($password);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function check_year($tahun)
    {
        $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_RENCANA a WHERE a.TAHUN LIKE '".$tahun."'")->result();
        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function popupBuilder($t_id)
    {
        $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_RENCANA a WHERE a.T_ID = '".$t_id."'")->result();

        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function popupBuilder_grid($t_id)
    {
        $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_RENCANA_VIEW a WHERE a.T_ID = '".$t_id."' ")->result();

        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function updateTicket($t_id, $status, $date, $komentar)
    {
        $query = $this->db->query("UPDATE
                                          WFINANCE.RKAP_TICKET a
                                      SET
                                          a.KETERANGAN = '".$status."',
                                          a.TANGGAL = '".$date."',
                                          a.PESAN = '".$komentar."'
                                      WHERE
                                          a.TICKET_ID = '".$t_id."'");
        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function updateTicketbyPIC($t_id, $keterangan, $date)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_TICKET a
                                   SET a.KETERANGAN = '".$keterangan."',
                                   a.TANGGAL = '".$date."' 
                                   WHERE
                                    a.TICKET_ID = '".$t_id."'");
        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }

    }

    public function requestProyeksi($biro, $tahun, $keterangan, $ticket_id)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_RENCANA a SET a.STATUS = '".$keterangan."', a.T_ID = '".$ticket_id."'
                                    WHERE a.TAHUN = '".$tahun."'
                                        AND EXISTS (SELECT 1 FROM WFINANCE.RKAP_MASTER_KODE b
                                        WHERE b.ID_KODE = a.KODE_ANGGARAN
                                        AND b.KET_KD_GAS = '".$biro."')");

          if ($query) {
            # code...
            return true;
          } else {
            return false;
          }
    }

    public function updateProyeksiByPIC($t_id, $keterangan)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_RENCANA a
                                      SET a.STATUS = '".$keterangan."'
                                    WHERE a.T_ID = '".$t_id."'");
        if ($query) {
          # code...
          return true;
        } else {
          return false;
        }
    }

    public function get_rencana_biro($tahun, $biro)
    {
        $query = $this->db->query("select b.id, b.belongs_to, a.tahun, a.kode_anggaran, a.jenis_biaya, a.t_id, a.status,
        a.jan, a.feb, a.mar, a.apr, a.mei, a.juni, a.juli, a.ags, a.sep, a.okt, a.nov, a.des, a.total
        from wfinance.rkap_rencana a, wfinance.rkap_master_kode_detail b
        where a.jenis_biaya = b.uraian and a.tahun = '".$tahun."' and b.ket_kd_gas = '".$biro."'
        order by a.id asc")->result();
        
        if ($query) {
            # code...
            return $query;
        } else {
            return false;
        }
    }

    //fungsi cek tahun database
    public function check_year_approval($tahun, $biro)
    {
        $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_RENCANA a
        LEFT JOIN WFINANCE.RKAP_MASTER_KODE b ON b.ID_KODE = a.KODE_ANGGARAN
      WHERE a.TAHUN = '".$tahun."' AND b.KD_GAS = '".$biro."' ORDER BY a.ID ASC")->result();

        if ($query) {
            # code...
            return $query;
        } else {
            return false;
        }
    }

    public function updateProyeksi($biro, $tahun, $keterangan)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_RENCANA R
                                            SET STATUS = ( 
                                        WITH RP AS
                                        (
                                        SELECT
                                              RKAP_RENCANA.ID AS ID,
                                              RKAP_RENCANA.TAHUN AS TAHUN,
                                              RKAP_RENCANA.KODE_ANGGARAN AS KODE_ANGGARAN,
                                              RKAP_RENCANA.JENIS_BIAYA AS JENIS_BIAYA,
                                              RKAP_RENCANA.JAN AS JAN,
                                              RKAP_RENCANA.FEB AS FEB,
                                              RKAP_RENCANA.MAR AS MAR,
                                              RKAP_RENCANA.APR AS APR,
                                              RKAP_RENCANA.MEI AS MEI,
                                              RKAP_RENCANA.JUNI AS JUNI,
                                              RKAP_RENCANA.JULI AS JULI,
                                              RKAP_RENCANA.AGS AS AGS,
                                              RKAP_RENCANA.SEP AS SEP,
                                              RKAP_RENCANA.OKT AS OKT,
                                              RKAP_RENCANA.NOV AS NOV,
                                              RKAP_RENCANA.DES AS DES,
                                              RKAP_RENCANA.SUBTOTAL AS SUBTOTAL,
                                              RKAP_RENCANA.TOTAL AS TOTAL,
                                              RKAP_RENCANA.BELONGS_TO AS BELONGS_TO,
                                              RKAP_RENCANA.NOMOR AS NOMOR,
                                              RKAP_RENCANA.STATUS AS STATUS,
                                              '".$keterangan."' AS ZERO_STATUS
                                          FROM WOS.RKAP_RENCANA
                                          LEFT JOIN WOS.RKAP_MASTER_KODE ON RKAP_MASTER_KODE.ID_KODE = RKAP_RENCANA.KODE_ANGGARAN
                                          LEFT JOIN WOS.RKAP_USER ON RKAP_USER.BIRO = RKAP_MASTER_KODE.BIRO
                                        WHERE TAHUN = '".$tahun."' AND RKAP_MASTER_KODE.BIRO = '".$biro."')
                                        SELECT RP.ZERO_STATUS
                                          FROM RP
                                          WHERE RP.ID = R.ID
                                        )");
        if ($query) {
            # code...
            return true;
        } else {
            return false;
        }
    }

    public function ApproveOrReject($status, $t_id)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_RENCANA a
                                      SET a.STATUS = '".$status."'
                                    WHERE a.T_ID = '".$t_id."'");
        if($query){
          return true;
        }else{
            return false;
        }
    }

    public function createTicket($data)
    {
        // $query = $this->db->query("INSERT INTO RKAP_TICKET(TICKET_ID, REQUESTOR, JABATAN, BIRO, DOKUMEN, KETERANGAN, TANGGAL) VALUES ('".$ticket_id."', '".$requestor."', '".$jabatan."', '".$biro."', '".$dokumen."', '".$keterangan."', SYSDATE);")->result();
        $query = $this->db->insert("WFINANCE.RKAP_TICKET", $data); 

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function allbiro()
    {
        $query = $this->db->query("select a.kd_gas, a.ket_kd_gas from wfinance.rkap_master_kode a
                                  group by a.kd_gas, a.ket_kd_gas")->result();
        if($query)
            return $query;
        else
            return false;
    }

    public function allaccount($kd_gas)
    {
        $query = $this->db->query("select a.kode_anggaran 
                                    from wfinance.rkap_rencana a, wfinance.rkap_master_kode b
                                    where a.kode_anggaran = b.id_kode and b.kd_gas = '".$kd_gas."'
                                    group by a.kode_anggaran")->result();
        if($query)
            return $query;
        else
            return false;
    }



    public function get_all_kendo( $column, $take, $skip, $sort_dir, $sort_field, $filterdata ) {
    
        $this->db->select($column);
        
        // pengecekan apa ada trigger sort oleh user
        if( isset( $sort_dir ) ){
          
          // pengecekan apa ada trigger filter data oleh user
          if( isset($filterdata) ){
            $this->db->order_by($sort_field, $sort_dir);
            $this->db->limit($take,$skip);
    
            // pengecekan filter operator kendo apa terset ?
            if( isset($filterdata['operator']) ) {
              
              // pengecekan filter operator default bawaaan kendo
              if( $filterdata['operator'] == 'eq' ) {
                $this->db->where($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'neq' ) {
                $field = $filterdata['field'] . ' != ';
                $this->db->where($field, $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'startswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'after');
              }
              elseif( $filterdata['operator'] == 'contains' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'both');
              }
              elseif( $filterdata['operator'] == 'doesnotcontain' ) {
                $this->db->not_like($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'endswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'],'before');
              }
            }
    
            $data = $this->db->get("WFINANCE.RKAP_MASTER_KODE");
          }else{
            $this->db->order_by($sort_field, $sort_dir);
            $this->db->limit($take,$skip);
            $data = $this->db->get("WFINANCE.RKAP_MASTER_KODE");
          }
          
        }else{
          
          if( $filterdata != 0 ){
    
            if( isset($filterdata['operator']) ) {
              if( $filterdata['operator'] == 'eq' ) {
                $this->db->where($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'neq' ) {
                $field = $filterdata['field'] . ' != ';
                $this->db->where($field, $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'startswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'after');
              }
              elseif( $filterdata['operator'] == 'contains' ) {
                $this->db->like($filterdata['field'], $filterdata['value'], 'both');
              }
              elseif( $filterdata['operator'] == 'doesnotcontain' ) {
                $this->db->not_like($filterdata['field'], $filterdata['value']);
              }
              elseif( $filterdata['operator'] == 'endswith' ) {
                $this->db->like($filterdata['field'], $filterdata['value'],'before');
              }
            }
            
            $this->db->limit($take,$skip);
            $data = $this->db->get("WFINANCE.RKAP_MASTER_KODE");
          }else{
            $this->db->limit($take,$skip);
            $data = $this->db->get("WFINANCE.RKAP_MASTER_KODE");
          }
    
        }
        //$data=array();

        return $data->result();
    }

    /* Function handle Filter */

    public function count_all() {
      $count = $this->db->count_all("WFINANCE.RKAP_MASTER_KODE");
      $query = $this->db->last_query();
      return $count;
    }
  
    // menghitung total data jika terdapat kondisi tertentu pada kendo seperti filtering
    public function count_all_where($filterdata) {
      if( isset($filterdata['operator']) ) {
        if( $filterdata['operator'] == 'eq' ) {
          $this->db->where($filterdata['field'], $filterdata['value']);
        }
        elseif( $filterdata['operator'] == 'neq' ) {
          $field = $filterdata['field'] . ' !=';
          $this->db->where($field, $filterdata['value']);
        }
        elseif( $filterdata['operator'] == 'startswith' ) {
          $this->db->like($filterdata['field'], $filterdata['value'], 'after');
        }
        elseif( $filterdata['operator'] == 'contains' ) {
          $this->db->like($filterdata['field'], $filterdata['value'], 'both');
        }
        elseif( $filterdata['operator'] == 'doesnotcontain' ) {
          $this->db->not_like($filterdata['field'], $filterdata['value']);
        }
        elseif( $filterdata['operator'] == 'endswith' ) {
          $this->db->like($filterdata['field'], $filterdata['value'],'before');
        }
      }
      $this->db->from("WFINANCE.RKAP_MASTER_KODE");
      $count = $this->db->count_all_results();
      return $count;
    }

    public function get_all_ticket( $column, $take, $skip, $sort_dir, $sort_field, $filterdata ) {
    
      $this->db->select($column);
      
      // pengecekan apa ada trigger sort oleh user
      if( isset( $sort_dir ) ){
        
        // pengecekan apa ada trigger filter data oleh user
        if( isset($filterdata) ){
          $this->db->order_by($sort_field, $sort_dir);
          $this->db->limit($take,$skip);
  
          // pengecekan filter operator kendo apa terset ?
          if( isset($filterdata['operator']) ) {
            
            // pengecekan filter operator default bawaaan kendo
            if( $filterdata['operator'] == 'eq' ) {
              $this->db->where($filterdata['field'], $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'neq' ) {
              $field = $filterdata['field'] . ' != ';
              $this->db->where($field, $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'startswith' ) {
              $this->db->like($filterdata['field'], $filterdata['value'], 'after');
            }
            elseif( $filterdata['operator'] == 'contains' ) {
              $this->db->like($filterdata['field'], $filterdata['value'], 'both');
            }
            elseif( $filterdata['operator'] == 'doesnotcontain' ) {
              $this->db->not_like($filterdata['field'], $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'endswith' ) {
              $this->db->like($filterdata['field'], $filterdata['value'],'before');
            }
          }
  
          $data = $this->db->get("WFINANCE.RKAP_TICKET");
        }else{
          $this->db->order_by($sort_field, $sort_dir);
          $this->db->limit($take,$skip);
          $data = $this->db->get("WFINANCE.RKAP_TICKET");
        }
        
      }else{
        
        if( $filterdata != 0 ){
  
          if( isset($filterdata['operator']) ) {
            if( $filterdata['operator'] == 'eq' ) {
              $this->db->where($filterdata['field'], $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'neq' ) {
              $field = $filterdata['field'] . ' != ';
              $this->db->where($field, $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'startswith' ) {
              $this->db->like($filterdata['field'], $filterdata['value'], 'after');
            }
            elseif( $filterdata['operator'] == 'contains' ) {
              $this->db->like($filterdata['field'], $filterdata['value'], 'both');
            }
            elseif( $filterdata['operator'] == 'doesnotcontain' ) {
              $this->db->not_like($filterdata['field'], $filterdata['value']);
            }
            elseif( $filterdata['operator'] == 'endswith' ) {
              $this->db->like($filterdata['field'], $filterdata['value'],'before');
            }
          }
          
          $this->db->limit($take,$skip);
          $data = $this->db->get("WFINANCE.RKAP_TICKET");
        }else{
          $this->db->limit($take,$skip);
          $data = $this->db->get("WFINANCE.RKAP_TICKET");
        }
  
      }
      //$data=array();

      return $data->result();
  }

  /* Function handle Filter */

  public function count_all_ticket() {
    $count = $this->db->count_all("WFINANCE.RKAP_TICKET");
    $query = $this->db->last_query();
    return $count;
  }

  // menghitung total data jika terdapat kondisi tertentu pada kendo seperti filtering
  public function count_all_where_ticket($filterdata) {
    if( isset($filterdata['operator']) ) {
      if( $filterdata['operator'] == 'eq' ) {
        $this->db->where($filterdata['field'], $filterdata['value']);
      }
      elseif( $filterdata['operator'] == 'neq' ) {
        $field = $filterdata['field'] . ' !=';
        $this->db->where($field, $filterdata['value']);
      }
      elseif( $filterdata['operator'] == 'startswith' ) {
        $this->db->like($filterdata['field'], $filterdata['value'], 'after');
      }
      elseif( $filterdata['operator'] == 'contains' ) {
        $this->db->like($filterdata['field'], $filterdata['value'], 'both');
      }
      elseif( $filterdata['operator'] == 'doesnotcontain' ) {
        $this->db->not_like($filterdata['field'], $filterdata['value']);
      }
      elseif( $filterdata['operator'] == 'endswith' ) {
        $this->db->like($filterdata['field'], $filterdata['value'],'before');
      }
    }
    $this->db->from("WFINANCE.RKAP_TICKET");
    $count = $this->db->count_all_results();
    return $count;
  }

  public function get_ticket()
  {
      $query = $this->db->query("SELECT a.ticket_id, a.requestor, a.jabatan, a.biro, a.dokumen, a.tanggal, a.pesan, 
                                  case a.keterangan
                                    when '0' THEN '0'
                                    when '1' THEN 'Requested / Waiting Approval'
                                    when '2' THEN 'Rejected'
                                    when '3' THEN 'Approved'
                                  end as status
                                  FROM WFINANCE.RKAP_TICKET a ")->result();
      if($query){
        return $query;
      }else{
          return false;
      }
  }

  public function get_own_ticket($username, $jabatan, $biro)
  {
      $query = $this->db->query("SELECT a.ticket_id, a.requestor, a.jabatan, a.biro, a.dokumen, a.tanggal, a.pesan, 
                                  case a.keterangan
                                    when '0' THEN 'Has Been Created'
                                    when '1' THEN 'Requested / Waiting Approval'
                                    when '2' THEN 'Rejected'
                                    when '3' THEN 'Approved'
                                  end as status
                                  FROM WFINANCE.RKAP_TICKET a 
                                  WHERE a.REQUESTOR = '".$username."' 
                                  AND a.JABATAN = '".$jabatan."' 
                                  AND a.BIRO = '".$biro."'")->result();
      if($query){
        return $query;
      }else{
          return false;
      }
  }

    public function save_master_kode($data)
    {
        $query = $this->db->insert("WFINANCE.RKAP_MASTER_KODE", $data);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function update_master_kode($id_kode,$uraian, $biro, $account) {
        $query = $this->db->query("UPDATE
                                        WFINANCE.RKAP_MASTER_KODE a
                                    SET
                                        a.ID_KODE = '".$id_kode."',
                                        a.URAIAN = '".$uraian."',
                                        a.BIRO = '".$biro."',
                                        a.ACCOUNT = '".$account."'
                                    WHERE
                                        a.ID_KODE = '".$id_kode."'");

        if($query)
            return true;
        else
            return false;   
    }

    public function getAccount($biro)
    {
      $query = $this->db->query("SELECT * FROM WFINANCE.RKAP_MASTER_KODE a WHERE a.KET_KD_GAS = '".$biro."'")->result();

      if ($query) {
        return $query;
      } else {
        return false;
      }
      
    }

    public function lineChartRealisasi($year_start)
    {
        $query = $this->db->query("SELECT A.BL,B.ACCOUNT,SUM(TOTAL)TOTAL
                                      FROM DOKKAS_H A,DOKKAS_D1 B 
                                    WHERE A.NO_DOK=B.NO_DOK AND B.ACCOUNT IN ('21157') AND SUBSTR(A.BL,3,4)='".$year_start."' AND A.APP4=1 AND A.JDOK='P'
                                    GROUP BY A.BL,B.ACCOUNT
                                    ORDER BY A.BL,B.ACCOUNT")->result();
        if ($query) {
          return $query;
        } else {
          return false;
        }
    }

    public function tempAccount($biro)
    {
        $query = $this->db->query("SELECT a.ID_KODE FROM WFINANCE.RKAP_MASTER_KODE a WHERE a.KET_KD_GAS = '".$biro."' ")->result_array();

        if ($query) {
          return $query;
        } else {
          return false;
        }
    }

    public function tempAccountRi($biro)
    {
        $query = $this->db->query("SELECT DISTINCT a.ID_KODE FROM WFINANCE.RKAP_MASTER_KODE a WHERE a.KET_KD_GAS = '".$biro."' ")->result_array();

        if ($query) {
          return $query;
        } else {
          return false;
        }
    }

    public function getbarchartrealisasi($account, $year)
    {
      $query = $this->db->query("SELECT A.BL,SUM(TOTAL)TOTAL
                                FROM DOKKAS_H A,DOKKAS_D1 B, RKAP_MASTER_KODE C
                              WHERE A.NO_DOK=B.NO_DOK AND B.ACCOUNT=C.ACCOUNT AND C.ID_KODE = '".$account."' AND SUBSTR(A.BL,3,4)='".$year."' AND A.APP4=1 AND A.JDOK='P'
                              GROUP BY A.BL,B.ACCOUNT
                              ORDER BY A.BL,B.ACCOUNT")->result_array();
          if ($query) {
            return $query;
          } else {
            return false;
          }
    }

    public function getbarchartrencana($account, $year)
    {
      $query = $this->db->query("SELECT 
                                    SUM(a.JAN) AS JAN,
                                    SUM(a.FEB) AS FEB,
                                    SUM(a.MAR) AS MAR,
                                    SUM(a.APR) AS APR,
                                    SUM(a.MEI) AS MEI,
                                    SUM(a.JUNI) AS JUNI,
                                    SUM(a.JULI) AS JULI,
                                    SUM(a.AGS) AS AGS,
                                    SUM(a.SEP) AS SEP,
                                    SUM(a.OKT) AS OKT,
                                    SUM(a.NOV) AS NOV,
                                    SUM(a.DES) AS DES
                                  FROM RKAP_RENCANA a, RKAP_MASTER_KODE b
                                  WHERE a.KODE_ANGGARAN = b.ID_KODE AND a.TAHUN = '".$tahun."' AND a.KODE_ANGGARAN = '".$kode."'")->result_array();

          if ($query) {
            # code...
            return $query;
          } else {
            return false;
          }
    }

    public function insertdata($id, $parent, $tahun, $kode, $jenis, $jan, $feb, $mar, $apr, $mei, $juni, $juli, $ags, $sep, $okt, $nov, $des, $belongs_to)
    {
        $query = $this->db->query("INSERT INTO WFINANCE.RKAP_RENCANA(ID, PARENT, BELONGS_TO, TAHUN, KODE_ANGGARAN, JENIS_BIAYA, T_ID, STATUS, JAN, FEB, MAR, APR, MEI, JUNI, JULI, AGS, SEP, OKT, NOV, DES) 
                                  VALUES 
                                  ('".$id."', '".$parent."', '".$belongs_to."', 
                                  '".$tahun."', '".$kode."', 
                                  '".$jenis."', '0', '0', 
                                  '".$jan."', '".$feb."', 
                                  '".$mar."', '".$apr."', 
                                  '".$mei."', '".$juni."', 
                                  '".$juli."', '".$ags."', 
                                  '".$sep."', '".$okt."', 
                                  '".$nov."', '".$des."')");
    }

    public function updatedata($id, $tahun, $kode, $jenis, $jan, $feb, $mar, $apr, $mei, $juni, $juli, $ags, $sep, $okt, $nov, $des)
    {
        $query = $this->db->query("UPDATE WFINANCE.RKAP_RENCANA SET 
                                                                    KODE_ANGGARAN = '".$kode."',
                                                                    TAHUN = '".$tahun."',
                                                                    JENIS_BIAYA = '".$jenis."',
                                                                    JAN = '".$jan."', FEB = '".$feb."', 
                                                                    MAR = '".$mar."', APR = '".$apr."', 
                                                                    MEI = '".$mei."', JUNI = '".$juni."', 
                                                                    JULI = '".$juli."', AGS = '".$ags."', 
                                                                    SEP = '".$sep."', OKT = '".$okt."', 
                                                                    NOV = '".$nov."', DES = '".$des."' 
                                                                WHERE ID = '".$id."' AND TAHUN = '".$tahun."' AND KODE_ANGGARAN = '".$kode."'");
    }

    public function deletedata($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->delete('WFINANCE.RKAP_RENCANA');
        
        if($query)
            return true;
        else
            return false;
    }

    public function getdropdownkode($biro)
    {
        $query = $this->db->query("select a.id_kode from wfinance.rkap_master_kode a
                                    where a.kd_gas = '".$biro."'")->result();
        if($query)
            return $query;
        else
            return false;
    }

    public function getdropdownjenis($biro)
    {
        $query = $this->db->query("select a.jenis_biaya from wfinance.rkap_rencana a, wfinance.rkap_master_kode b
                                  where a.kode_anggaran = b.id_kode and b.kd_gas = '".$biro."'")->result();
        if($query)
            return $query;
        else
            return false;
    }

    public function pushNotification()
    {
        $query = $this->db->query("select count(a.ticket_id) as sum from wfinance.rkap_ticket a group by ticket_id")->result();

        if($query)
            return $query;
        else
            return false;
    }

    public function pushNotificationBiro()
    {}

    public function gettemporarydata($biro, $tahun_extends)
    {
        $query = $this->db->query("select a.id, a.parent, a.belongs_to, a.tahun, a.kode_anggaran, a.jenis_biaya, a.t_id, a.status,
                                    a.jan, a.feb, a.mar, a.apr, a.mei, a.juni, a.juli, a.ags, a.sep, a.okt, a.nov, a.des
                                    from wfinance.rkap_rencana a, wfinance.rkap_master_kode b 
                                    where a.kode_anggaran = b.id_kode and a.tahun = '".$tahun_extends."' and b.ket_kd_gas = '".$biro."' order by a.id asc")->result();

        if($query)
            return $query;
        else
            return false;
    }

    public function insertbatch($array)
    {
        $query = $this->db->insert_batch("WFINANCE.RKAP_RENCANA", $array);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function getmaxnumber()
    {
        $query = $this->db->query("select max(a.id) as max from wfinance.rkap_rencana a")->result();

        if($query)
            return $query;
        else
            return false;

    }

    public function getgas()
    {
        $query = $this->db->query("select DISTINCT a.kd_gas, a.ket from HRMS.TB_GAS a where a.kd_pat = '0A' order by a.kd_gas asc")->result();

        if($query)
            return $query;
        else
            return false;
    }

    public function searchgas($ket)
    { 
        $query = $this->db->query("select a.ket from hrms.tb_gas a where a.kd_gas = '".$ket."'")->result();

        if($query)
            return $query;
        else
            return false;
    }

    public function getsummarypiechart()
    {
        $data = $this->db->query("select a.ket_kd_gas category, sum(a.total) as value
                                  from wfinance.rkap_rencana_view a
                                  group by a.ket_kd_gas")->result_array();
        $bsi = 0;
        $bku = 0;
        $hc = 0;
        $op = 0;
        $qshe = 0;
        $peng = 0;
        $prod = 0;
        $proc = 0;
        $sales = 0;
        $busdev = 0;
        $sekper = 0;

        foreach ($data as $key => $value) {
            if ($data[$key]['CATEGORY'] == 'Biro Sistem Informasi') {
                $bsi = (float) $value['VALUE']; 
            }
            if ($data[$key]['CATEGORY'] == 'Biro Keuangan Korporasi') {
                $bku = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Human Capital') {
                $hc = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Operasi') {
                $op = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro QSHE & SM') {
                $qshe = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Pengendalian') {
                $peng = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Produksi') {
                $prod = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Pengadaan') {
                $proc = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Penjualan') {
                $sales = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Business Development') {
                $busdev = (float) $value['VALUE'];
            }
            if ($data[$key]['CATEGORY'] == 'Biro Sekretariat Perusahaan') {
                $sekper = (float) $value['VALUE'];
            } 
        }
        $total = $bsi + $bku + $hc + $op + $qshe + $peng + $prod + $proc + $sales + $busdev + $sekper;
        $arr[] = array(
                array
                (
                    "category" => "Biro Sistem Informasi",
                    "value"    => round($bsi/$total, 2),
                    "color"    => "#9de219"
                ),
                array
                (
                    "category" => 'Biro Keuangan Korporasi',
                    "value"    => round($bku/$total, 2),
                    "color"    => "#90cc38"
                ),
                array
                (
                    "category" => "Biro Human Capital",
                    "value"    => round($hc/$total,2),
                    "color"    => "#068c35"
                ),
                array
                (
                    "category" => "Biro Operasi",
                    "value"    => round($op/$total,2),
                    "color"    => "#006634"
                ),
                array
                (
                    "category" => "Biro QSHE & SM",
                    "value"    => round($qshe/$total,2),
                    "color"    => "#004d38"
                ),
                array
                (
                    "category" => "Biro Pengendalian",
                    "value"    => round($peng/$total,2),
                    "color"    => "#033939"
                ),
                array
                (
                    "category" => "Biro Produksi",
                    "value"    => round($prod/$total,2),
                    "color"    => "#4BABE9"
                ),
                array
                (
                    "category" => "Biro Pengadaan",
                    "value"    => round($proc/$total,2),
                    "color"    =>"#72B0E8"
                ),
                array
                (
                    "category" => "Biro Penjualan",
                    "value"    => round($sales/$total,2),
                    "color"    => "#8ABEFF"
                ),
                array(
                    "category" => "Biro Business Development",
                    "value"    => round($busdev/$total,2),
                    "color"    => "#729EE8"
                ),
                array(
                    "category" => "Biro Sekretariat Perusahaan",
                    "value"    => round($sekper/$total,2),
                    "color"    => "#7DA4FF"
                ));   
        foreach ($arr as $i => $val) {
            return $val;
        }
    }

}