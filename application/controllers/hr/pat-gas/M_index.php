<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_index extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * April 2018
	 */
	 
	var $oraConn = "HR";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    public function render_view($content = "main", $params = array()){
       $this->load->view('shared/header',$params);
       $this->load->view('shared/sidebar',$params);
       $this->load->view($content,$params);
       $this->load->view('shared/footer',$params);
    }
    public function errorPage($value=''){
        $this->render_view('error');
    }
    public function index(){
	$this->load->helper(array('form','url','download'));
        $this->load->library('session');
        $this->contentManagement();
    }
    public function contentManagement(){
        $params["title"]="Mapping Company-PAT-GAS";
        $params["grid"] = $this->initGrid();
        //--------------------------------Load info user into session -----------------------------------
        $this->load_info_user();
        //------------------------------------------------------------------------------------------------
        $this->render_view('hr/pat-gas/v_list', $params);
    }
    public function load_info_user(){
        $array_val = array('s_uID' => '','s_uNAME' => '', 's_uPAT' => '','s_uJBT' => '',
            's_uGAS' => '','s_uPAT_KET' => '','s_uGAS_KET' => '','s_uJBT_KET' => '',);
        //------------get session OS---------------------
        $this->load->library('Wb_Security');
        $isessid="";
      //  $isessid="33b8dc9015a043dd3ec9dedd316b078a";//"c1ea6c56a103b441875fcfcdce93a84e";//"c5c689ce32b0e4afcef7b0e44b352b21";// "80f027d6f304c9a4cad98ddb062e8b89"; 
        if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
        $this->wb_security->id_session = $isessid;
        $this->session->set_userdata($this->wb_security->cekSession());
        //-----------------------------------------------
        $this->session->unset_userdata($array_val);
        $this->session->set_userdata('s_uID',$this->session->userdata("TMP_NIP"));
        //$this->session->set_userdata('s_uID', 'LS183677');//LS083110  'LS183677'   u/ TES development
        $sql="select a.employee_id,
            trim(first_title||' '||first_name||' '||last_name||last_title)nama_pengirim,
            a.kd_pat,b.ket ket_pat,c.kd_gas,c.ket ket_gas,a.kd_jbt,d.ket ket_jbt from wos.personal a
            left join wos.tb_pat b on a.kd_pat=b.kd_pat
            left join wos.tb_gas c on a.kd_gas=c.kd_gas
            left join wos.tb_jbt d on a.kd_jbt=d.kd_jbt
            where a.employee_id='".$this->session->userdata('s_uID')."' and st='1'";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $this->session->set_userdata('s_uNAME',$row['NAMA_PENGIRIM']);
            $this->session->set_userdata('s_uPAT',$row['KD_PAT']);
            $this->session->set_userdata('s_uJBT',$row['KD_JBT']);
            $this->session->set_userdata('s_uGAS',$row['KD_GAS']);
            $this->session->set_userdata('s_uPAT_KET',$row['KET_PAT']);
            $this->session->set_userdata('s_uGAS_KET',$row['KET_GAS']);
            $this->session->set_userdata('s_uJBT_KET',$row['KET_JBT']);
        }
        return $this->session->userdata;
    }
    public function initGrid(){
            $paramsGrid["source"]["ID"] = "MAPPING";
            $i=0;
           //  ID,ID_CORP,KET_CORP,ID_PARENT,KET_PARENT,
          //  KD_PAT,KET_PAT,KD_GAS,KET_GAS
            
            $aFLD=["ID","ID_CORP","KET_CORP","ID_PARENT","KET_PARENT","KD_PAT","KET_PAT","KD_GAS","KET_GAS","FLAG_DATA"];
            $aMtext=["ACTION","ID PERUSAHAAN","NAMA PERUSAHAAN","ID_PARENT","NAMA PERUSAHAAN INDUK","KD. PAT","NAMA PAT","ID GAS","NAMA GAS","FLAG_DATA"];
            $aCellsAlign=["center","left","left","left","left","left","left","left","left","left"];
            $aCellsHidden=["false","false","false","true","false","false","false","false","false","true"];
            $aCellsRender=["renderACT","","","","","","","","",""];
            $aCellsPinned=["true","false","false","false","false","false","false","false","false","false"];
            $aCellsWidth=["18%","13%","25%","6%","25%","8%","25%","8%","15%","1%"];
            for($x=0;$x<count($aFLD)-1;$x++){
                $i++;  
                $paramsGrid["source"]["datafields"][$i]["dbfieldname"]=$aFLD[$x];
                $paramsGrid["source"]["datafields"][$i]["name"]=$aFLD[$x];
                $paramsGrid["source"]["datafields"][$i]["type"]="string";
                $paramsGrid["columns"][$i]["text"]=$aMtext[$x];
                $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
                $paramsGrid["columns"][$i]["width"]=$aCellsWidth[$x];
                $paramsGrid["columns"][$i]["cellsalign"]=$aCellsAlign[$x];
                $paramsGrid["columns"][$i]["pinned"]=$aCellsPinned[$x];
                $paramsGrid["columns"][$i]["hidden"]=$aCellsHidden[$x];
                if(strlen($aCellsRender[$x])>0) $paramsGrid["columns"][$i]["cellsrenderer"]=$aCellsRender[$x];
            }
            return $paramsGrid;
    }
    public function list_map(){
        $errMsg = "";$recPerPage = 15;$currPage = 1;$where = ""; $filter_user="";// $user_level = 0[Admin]  1[user]
        if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
        if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

        $this->load->library('AdodbConn');
        $conn = $this->adodbconn->getOraConn("OS");
        $this->load->helper('erp_wb_helper');
        if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
        //------------------------------- end cek session ---------------------------------------------------------
        //$this->session->userdata('s_uPAT');
        $query="select * from (select  a.ID_CORP||'.'||c.KD_PAT||'.'||e.KD_GAS ID,a.ID_CORP,a.KETERANGAN KET_CORP,b.ID_CORP ID_PARENT,b.KETERANGAN KET_PARENT,
            c.KD_PAT,d.KET KET_PAT,e.KD_GAS,f.KET KET_GAS from hrms.TB_CORP a
            left join hrms.TB_CORP b on a.PARENT_ID_CORP=b.ID_CORP
            left join hrms.TB_CORP_PAT c on a.ID_CORP=c.ID_CORP
            left join hrms.TB_PAT d on c.KD_PAT=d.KD_PAT
            left join hrms.TB_PAT_GAS e on c.KD_PAT=e.KD_PAT and c.ID_CORP=e.ID_CORP
            left join hrms.TB_GAS f on e.KD_GAS=f.KD_GAS  order by a.ID_CORP desc)src where length(ID)>1 ".$where;
        $arrParamData = array();
        $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
        if($rst){
                $total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
                if($rst->recordCount()>0){
                        for($i=0;$i<$rst->recordCount();$i++){
                                $arrData[] = array(
                                    'ID' => $rst->fields["ID"],
                                    'ID_CORP' =>  $rst->fields["ID_CORP"],
                                    'KET_CORP' =>  $rst->fields["KET_CORP"],
                                    'ID_PARENT' =>  $rst->fields["ID_PARENT"],
                                    'KET_PARENT' =>  $rst->fields["KET_PARENT"],
                                    'KD_PAT' =>  $rst->fields["KD_PAT"],
                                    'KET_PAT' =>  $rst->fields["KET_PAT"],
                                    'KD_GAS' =>  $rst->fields["KD_GAS"],  
                                    'KET_GAS' =>  $rst->fields["KET_GAS"],
                                    'FLAG_DATA' => "0"
                                    );	 
                                $rst->moveNext();
                        }   
                }else{
                        $total_rows = 0;              
                        $arrData[] = array(
                                'ID' => "",
                                'ID_CORP' =>  $rst->fields["ID_CORP"],
                                'KET_CORP' =>  $rst->fields["KET_CORP"],
                                'ID_PARENT' =>  $rst->fields["ID_PARENT"],
                                'KET_PARENT' =>  $rst->fields["KET_PARENT"],
                                'KD_PAT' =>  $rst->fields["KD_PAT"],
                                'KET_PAT' =>  $rst->fields["KET_PAT"],
                                'KD_GAS' =>  $rst->fields["KD_GAS"],  
                                'KET_GAS' =>  $rst->fields["KET_GAS"],
                                'FLAG_DATA' => "0"
                            ); 
                }
        }else{
                $total_rows = 0;
                $arrData[] = array(
                    'ID' => "",
                    'ID_CORP' =>  $rst->fields["ID_CORP"],
                    'KET_CORP' =>  $rst->fields["KET_CORP"],
                    'ID_PARENT' =>  $rst->fields["ID_PARENT"],
                    'KET_PARENT' =>  $rst->fields["KET_PARENT"],
                    'KD_PAT' =>  $rst->fields["KD_PAT"],
                    'KET_PAT' =>  $rst->fields["KET_PAT"],
                    'KD_GAS' =>  $rst->fields["KD_GAS"],  
                    'KET_GAS' =>  $rst->fields["KET_GAS"],
                    'FLAG_DATA' => "0"
                );
        }
		//$errMsg = $query;
		
        $data[] = array(
           'where' => $where,
           'TotalRows' => $total_rows,
           'Rows' => $arrData,
           'ErrorMsg'=>$errMsg
        );
        
        print_r(json_encode($data,JSON_PRETTY_PRINT));        
    }
    public function newData(){
        $params["title"]="Mapping Company-PAT-GAS(CREATE NEW)";
        $params["f_status"]="NEW";
        $params["aCOMPANY"]=[];$params["aGAS"]=[];$params["aPPU"]=[];
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        //--------------- combo box COMPANY ----------------------------
        $sql="select ID_CORP,KETERANGAN from hrms.TB_CORP where length(ID_CORP)>0 ";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'ID_CORP' =>$row->ID_CORP,     
                       'KETERANGAN' =>$row->KETERANGAN
                   );
                   array_push($params["aCOMPANY"],$newdata);
               }
            }  
        }
        $newdata =  array ('ID_CORP' =>"",'KETERANGAN' =>"PILIH");array_push($params["aCOMPANY"],$newdata);
        //--------------- combo box KD_PAT ----------------------------
        $sql="select kd_pat,ket from tb_pat where length(kd_pat)>0 ";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'KD_PAT' =>$row->KD_PAT,     
                       'KET' =>$row->KET
                   );
                   array_push($params["aPPU"],$newdata);
               }
            }  
        }
        $newdata =  array ('KD_PAT' =>"",'KET' =>"PILIH");array_push($params["aPPU"],$newdata);
        //--------------- combo box KD_GAS ----------------------------
        $sql="select kd_gas,ket from hrms.tb_gas where status=1";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'KD_GAS' =>$row->KD_GAS,     
                       'KET' =>$row->KET
                   );
                   array_push($params["aGAS"],$newdata);
               }
            }  
        } $newdata =  array ('KD_GAS' =>"",'KET' =>"PILIH");array_push($params["aGAS"],$newdata);
        $this->render_view('hr/pat-gas/add_data', $params);
    }
    public function ADD_COMPANY() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");
        $sql="select ID_CORP from hrms.TB_CORP where ID_CORP='".$data[0]."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0){
            $sql="update hrms.TB_CORP set KETERANGAN='".$data[1]."',PARENT_ID_CORP='".$data[2]."' where ID_CORP='".$data[0]."'";
        }else{
            $sql="insert into hrms.TB_CORP(ID_CORP,KETERANGAN,PARENT_ID_CORP,CREATED_BY,CREATED_DATE) values("
                   . "'".$data[0]."','".$data[1]."','".$data[2]."','".$this->session->userdata('s_uID')."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'))";
        }
        $result=$this->db->query($sql);  
        $this->session->set_flashdata('message','Berhasil Simpan Kode Company <b>'.$data[1].'</b>  !!!');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function CEK_COMPANY() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $sql="select ID_CORP,KETERANGAN,PARENT_ID_CORP from hrms.TB_CORP where ID_CORP='".$data."'";
        $result=$this->db->query($sql)->result_array();
        print_r(json_encode($result,JSON_PRETTY_PRINT));
    }
    public function CEK_PAT() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $sql="select KD_PAT,KET from hrms.TB_PAT where KD_PAT='".$data."'";
        $result=$this->db->query($sql)->result_array();
        print_r(json_encode( $result,JSON_PRETTY_PRINT));
  
    }
    public function CEK_GAS() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $sql="select KD_GAS,KET from hrms.TB_GAS where KD_GAS='".$data."'";
        $result=$this->db->query($sql)->result_array();
        print_r(json_encode( $result,JSON_PRETTY_PRINT));
  
    }
    public function ADD_PAT() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");
        $sql="select KD_PAT from hrms.TB_PAT where KD_PAT='".$data[0]."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0){
            $sql="update hrms.TB_PAT set KET='".$data[1]."', LAST_UPDATE_BY = '".$this->session->userdata('s_uID')."'  ,LAST_UPDATE_DATE=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss')  where KD_PAT='".$data[0]."'";
        }else{
            $sql="insert into hrms.TB_PAT(KD_PAT,KET, CREATED_BY,CREATED_DATE) values("
                   . "'".$data[0]."','".$data[1]."','".$this->session->userdata('s_uID')."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'))";
        }
        $result=$this->db->query($sql);  
        $this->session->set_flashdata('message','Berhasil Simpan Kode PAT <b>'.$data[0].'['.$data[1].']</b>  !!!');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function ADD_GAS() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");
        $sql="select KD_GAS from hrms.TB_GAS where KD_GAS='".$data[0]."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0){
            $sql="update hrms.TB_GAS set KET='".$data[1]."', LAST_UPDATE_BY = '".$this->session->userdata('s_uID')."'  ,LAST_UPDATE_DATE=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss')  where KD_GAS='".$data[0]."'";
        }else{
            $sql="insert into hrms.TB_GAS(KD_GAS,KET, CREATED_BY,CREATED_DATE) values("
                   . "'".$data[0]."','".$data[1]."','".$this->session->userdata('s_uID')."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'))";
        }
        $result=$this->db->query($sql);  
        $this->session->set_flashdata('message','Berhasil Simpan Kode GAS <b>'.$data[0].'['.$data[1].']</b>  !!!');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function SAVE_NEW() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");$pesan="";
        if($data[0]==='EDIT'){
            $key = explode('.',  $data[4]);
            $sql="delete from hrms.TB_PAT_GAS  where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' and KD_GAS='".$key[2]."'";
            $result=$this->db->query($sql);
            $sql="select ID_CORP from hrms.TB_PAT_GAS  where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' ";
            $sql = $this->db->query($sql);
            if($sql->num_rows()<1){
                $sql="delete from hrms.TB_CORP_PAT where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' ";
                $result=$this->db->query($sql);
            }
        }
        $sql="select ID_CORP from hrms.TB_CORP_PAT where ID_CORP='".$data[1]."' and KD_PAT='".$data[2]."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()<1){
            $sql="insert into hrms.TB_CORP_PAT(ID_CORP,KD_PAT,CREATED_BY,CREATED_DATE) values("
                   . "'".$data[1]."','".$data[2]."','".$this->session->userdata('s_uID')."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'))"; 
            $result=$this->db->query($sql); 
            $pesan="Berhasil Simpan ID Perusahaan : <b>".$data[1]."</b> KD. PAT:<b>".$data[2]."</b>";
        }
        $sql="select ID_CORP from hrms.TB_PAT_GAS where ID_CORP='".$data[1]."' and KD_PAT='".$data[2]."' and KD_GAS='".$data[3]."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()<1){
            $sql="insert into hrms.TB_PAT_GAS(ID_CORP,KD_PAT,KD_GAS,CREATED_BY,CREATED_DATE) values("
                   . "'".$data[1]."','".$data[2]."','".$data[3]."','".$this->session->userdata('s_uID')."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'))"; 
            $result=$this->db->query($sql); 
            $pesan="Berhasil Simpan ID Perusahaan : <b>".$data[1]."</b> KD. PAT:<b>".$data[2]."</b> KD. GAS :<b>".$data[3]."</b>";
        }
        $this->session->set_flashdata('message',$pesan);
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function viewData($filter="get"){
           $params["title"]="Mapping Company-PAT-GAS(VIEW)";
           $params["f_status"]="VIEW";
           $params["aCOMPANY"]=[];$params["aGAS"]=[];$params["aPPU"]=[];
           $this->load->helper('erp_wb_helper');
           $this->load->library('LookupData');
           $key = explode('.',  $filter);
           $params["idCOMPANY"]=$key[0];
           $params["idPAT"]=$key[1];
           $params["idGAS"]=$key[2]; 
           //--------------- combo box COMPANY ----------------------------
           $sql="select ID_CORP,KETERANGAN from hrms.TB_CORP where length(ID_CORP)>0 ";
           $result=$this->db->query($sql);
           if($result->num_rows()>0){
             if($result->num_rows()>0){
                   $result=$result->result();
                   foreach ($result as $row){
                       $newdata =  array (
                          'ID_CORP' =>$row->ID_CORP,     
                          'KETERANGAN' =>$row->KETERANGAN
                      );
                      array_push($params["aCOMPANY"],$newdata);
                  }
               }  
           }
           $newdata =  array ('ID_CORP' =>"",'KETERANGAN' =>"PILIH");array_push($params["aCOMPANY"],$newdata);
           //--------------- combo box KD_PAT ----------------------------
           $sql="select kd_pat,ket from tb_pat where length(kd_pat)>0 ";
           $result=$this->db->query($sql);
           if($result->num_rows()>0){
             if($result->num_rows()>0){
                   $result=$result->result();
                   foreach ($result as $row){
                       $newdata =  array (
                          'KD_PAT' =>$row->KD_PAT,     
                          'KET' =>$row->KET
                      );
                      array_push($params["aPPU"],$newdata);
                  }
               }  
           }
           $newdata =  array ('KD_PAT' =>"",'KET' =>"PILIH");array_push($params["aPPU"],$newdata);
           //--------------- combo box KD_GAS ----------------------------
           $sql="select kd_gas,ket from hrms.tb_gas where status=1";
           $result=$this->db->query($sql);
           if($result->num_rows()>0){
             if($result->num_rows()>0){
                   $result=$result->result();
                   foreach ($result as $row){
                       $newdata =  array (
                          'KD_GAS' =>$row->KD_GAS,     
                          'KET' =>$row->KET
                      );
                      array_push($params["aGAS"],$newdata);
                  }
               }  
           } $newdata =  array ('KD_GAS' =>"",'KET' =>"PILIH");array_push($params["aGAS"],$newdata);
          $this->render_view('hr/pat-gas/add_data', $params);
       }
    public function editData($filter="get"){
        $params["title"]="Mapping Company-PAT-GAS(EDIT)";
        $params["f_status"]="EDIT";
        $params["aCOMPANY"]=[];$params["aGAS"]=[];$params["aPPU"]=[];
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $key = explode('.',  $filter);
        $params["idCOMPANY"]=$key[0];
        $params["idPAT"]=$key[1];
        $params["idGAS"]=$key[2]; 
        $params["oldKey"]=$filter;
        //--------------- combo box COMPANY ----------------------------
        $sql="select ID_CORP,KETERANGAN from hrms.TB_CORP where length(ID_CORP)>0 ";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'ID_CORP' =>$row->ID_CORP,     
                       'KETERANGAN' =>$row->KETERANGAN
                   );
                   array_push($params["aCOMPANY"],$newdata);
               }
            }  
        }
        $newdata =  array ('ID_CORP' =>"",'KETERANGAN' =>"PILIH");array_push($params["aCOMPANY"],$newdata);
        //--------------- combo box KD_PAT ----------------------------
        $sql="select kd_pat,ket from tb_pat where length(kd_pat)>0 ";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'KD_PAT' =>$row->KD_PAT,     
                       'KET' =>$row->KET
                   );
                   array_push($params["aPPU"],$newdata);
               }
            }  
        }
        $newdata =  array ('KD_PAT' =>"",'KET' =>"PILIH");array_push($params["aPPU"],$newdata);
        //--------------- combo box KD_GAS ----------------------------
        $sql="select kd_gas,ket from hrms.tb_gas where status=1";
        $result=$this->db->query($sql);
        if($result->num_rows()>0){
          if($result->num_rows()>0){
                $result=$result->result();
                foreach ($result as $row){
                    $newdata =  array (
                       'KD_GAS' =>$row->KD_GAS,     
                       'KET' =>$row->KET
                   );
                   array_push($params["aGAS"],$newdata);
               }
            }  
        } $newdata =  array ('KD_GAS' =>"",'KET' =>"PILIH");array_push($params["aGAS"],$newdata);
       $this->render_view('hr/pat-gas/add_data', $params);
    }
    public function DeleteMAP() {
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");$pesan="";
        $key = explode('.',  $data[0]);
        $pesan="Berhasil Hapus ";
        $sql="delete from hrms.TB_PAT_GAS  where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' and KD_GAS='".$key[2]."'";
        $result=$this->db->query($sql);
        $pesan=$pesan." KD. GAS:<b>".$key[2]."</b>";
        $sql="select ID_CORP from hrms.TB_PAT_GAS  where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' ";
        $sql = $this->db->query($sql);
        if($sql->num_rows()<1){
            $sql="delete from hrms.TB_CORP_PAT where ID_CORP='".$key[0]."' and KD_PAT='".$key[1]."' ";
            $result=$this->db->query($sql);
            $pesan=$pesan." KD. PAT:<b>".$key[1]."</b>";
        }
        $sql="select ID_CORP from hrms.TB_CORP_PAT  where ID_CORP='".$key[0]."'  ";
        $sql = $this->db->query($sql);
        if($sql->num_rows()<1){
            $sql="delete from hrms.TB_CORP where ID_CORP='".$key[0]."' ";
            $result=$this->db->query($sql);
            $pesan=$pesan." KD. COMPANY:<b>".$key[0]."</b>";
        }
        $this->session->set_flashdata('message',$pesan);
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }



    
    public function DeleteCOA(){
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $sql="select NO_DOK from wfinance.dokkas_h where no_dok='".$data[0]."' AND APP1=0 AND APP2=0 AND APP3=0 AND APP4=0";
        $result=$this->db->query($sql);
        if($result->num_rows()<1){
            $cnt=1;
            $this->session->set_flashdata('message','Dokumen Bukti Kas <b>'.$data[0].'</b> Sudah diApprove, tidak bisa dihapus !!!');
       }else{
            $sql = "delete from wfinance.dokkas_d1 where no_dok='".$data[0]."'";
            $result=$this->db->query($sql);
            $sql = "delete from wfinance.dokkas_h where no_dok='".$data[0]."'";
            $result=$this->db->query($sql);
            $this->session->set_flashdata('message','Dokumen Bukti Kas <b>'.$data[0].'</b> Berhasil Dihapus !!!');
        }
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function DeleteDetail(){
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $sql = "delete from wfinance.dokkas_d1 where no_dok='".$data[0]."' and account='".$data[1]."'";
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Hapus Account <b>'.$data[1].'</b>  !!!');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function SaveDetail(){
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $kd_pat = $this->session->userdata('s_uPAT');
        if($data[18]==='')$data[18]=0;if($data[20]==='')$data[20]=0;if($data[21]==='')$data[21]=0;
        $sql="select count(NO_DOK)cnt from wfinance.dokkas_d1 where NO_DOK='".$data[0]."'";  
        $result=$this->db->query($sql);
        if($result->num_rows()<1){$cnt=1;}else{
            $result=$result->result();
            $cnt = $result[0]->CNT+1 ;
        }
        $cek="";
        if($data[22]==='NEW'){
            $sql="select NO_DOK from wfinance.dokkas_h where NO_DOK='".$data[0]."'";  
            $result=$this->db->query($sql);
            if($result->num_rows()<1){
                $sql="insert into wfinance.dokkas_h( no_dok,kd_pat,jdok,subject,ket,kd_currency) values('".$data[0]."','".$kd_pat."','".$data[24]."',"
                . "'".$data[25]."','".$data[26]."','01') ";
                $result=$this->db->query($sql); 
                $cek.=$sql;
            }
        }
        IF($data[22]==='NEW')
            $sql="insert into wfinance.dokkas_d1(NO_DOK,ACCOUNT,URAIAN,NO_NPP,PELANGGAN_ID,KD_PRODUK,NO_TAGIHAN,VENDOR_ID,NO_SPB,NO_SP3,KD_LINI,HARTA_TETAP,KD_PAT,
                KD_GAS,EMPLOYEE_ID,NO_PAJAK,NO_DOK_KAS,NO_DOK_MEM,VOL,SATUAN,HARSAT,TOTAL,LINENO) values('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."',"
                . "'".$data[4]."','".$data[5]."','".$data[6]."',"."'".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','"
                .$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."',".$data[18].",'"
                .$data[19]."',".$data[20].",".$data[21].",".$cnt.")";
      
        IF($data[22]==='EDIT')
            $sql = "update wfinance.dokkas_d1 set ACCOUNT='".$data[1]."',URAIAN='".$data[2]."',NO_NPP='".$data[3]."',PELANGGAN_ID='".$data[4]."',
                KD_PRODUK='".$data[5]."',NO_TAGIHAN='".$data[6]."',VENDOR_ID='".$data[7]."',NO_SPB='".$data[8]."',NO_SP3='".$data[9]."',
                KD_LINI='".$data[10]."',HARTA_TETAP='".$data[11]."',KD_PAT='".$data[12]."',
                KD_GAS='".$data[13]."',EMPLOYEE_ID='".$data[14]."',NO_PAJAK='".$data[15]."',NO_DOK_KAS='".$data[16]."',
                NO_DOK_MEM='".$data[17]."',VOL=".$data[18].",SATUAN='".$data[19]."',HARSAT=".$data[20].",TOTAL=".$data[21]
              . " where NO_DOK='".$data[0]."' and     LINENO='".$data[23]."'";
        $cek.=$sql;
        $result=$this->db->query($sql);
        print_r(json_encode($cek,JSON_PRETTY_PRINT));
    }
    public function SaveHeader(){
        $json  = utf8_encode($_POST['json']); // Don't forget the encoding
        $data  = json_decode($json);
        $kd_pat = $this->session->userdata('s_uPAT');
        $sql   = "select max(no_dok)no_dok from  wfinance.dokkas_d1 where substr(no_dok,0,4)= EXTRACT(YEAR FROM sysdate) and substr(no_dok,5,2)= '".$kd_pat."'    order by no_dok desc";
        $result=$this->db->query($sql);
        if($result->num_rows()<1){
            $next=date("Y").$kd_pat.'00000001';
        }else{
            $result=$result->result();
            $currDoc = $result[0]->NO_DOK ;
            $curr_seq = substr($currDoc,6,8);
            $next= sprintf("%08d", floatval($curr_seq)+1) ;
            $next=date("Y").$kd_pat.$next;
        }
        if($data[0]==='NEW'){
            $sql="insert into wfinance.dokkas_h( no_dok,kd_pat,jdok,subject,ket,kd_currency) values('".$next."','".$kd_pat."','".$data[2]."',"
                . "'".$data[3]."','".$data[4]."','01') ";
            $result=$this->db->query($sql);        
            $sql="update wfinance.dokkas_d1 set no_dok='".$next."' where no_dok='".$data[1]."'"; 
            $result=$this->db->query($sql);
            $sql="delete from wfinance.dokkas_d1 where  no_dok='".$data[1]."'";$result=$this->db->query($sql);   
            $sql="delete from wfinance.dokkas_h where no_dok='".$data[1]."'";
        
            $this->session->set_flashdata('message','Berhasil Simpan Dokumen Bukti Kas <b>'.$next.'</b> !!!');
        }
        if($data[0]==='EDIT'){
            $sql="update wfinance.dokkas_h set jdok='".$data[2]."',subject='".$data[3]."',ket='".$data[4]."' where no_dok='".$data[1]."'";
            $this->session->set_flashdata('message','Dokumen Bukti Kas <b>'.$data[1].'</b> berhasil  diupdate !!!');
        }
        $result=$this->db->query($sql);        
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function addItems(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $sql=" insert into wfinance.dokkas_d1(no_dok,lineno) values('LS083110',
            (select count(no_dok)+1  from  wfinance.dokkas_d1 where no_dok='LS083110'))";
        $result=$this->db->query($sql);
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
}
