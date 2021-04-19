<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_KBI extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * Februari 2018
	 */
	 
	var $oraConn = "OS";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
	var $ivalue="";
	var $irowactive="";
	var $ijtrans="";
	var $ikdpat="";
	var $SQLID="";
	
	public function __construct(){
        parent::__construct();
		
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
     //   require_once(APPPATH.'libraries\firebase\firebase.php');
      //  require_once(APPPATH.'libraries\firebase\push.php');
        
    }
	
    public function render_view($content = "main", $params = array()){
        $this->load->view('shared/header',$params);
		$this->load->view('shared/sidebar',$params);
		$this->load->view($content,$params);
		$this->load->view('shared/footer',$params);
    }
    public function errorPage($value='')
    {
        $this->render_view('error');
    }

    public function index()
	{
		$this->load->helper(array('form','url','download'));
        $this->contentManagement();
    }
    
    public function getListBL(){
		$errMsg = "";
		$arrData=array();
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$query="select distinct bl, to_date(bl,'MMYYYY') as bldate from hrms.kbi_h order by bldate desc";
		$rst=$conn->Execute($query);
		
		if($rst)
		{
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					
					foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					
					
					$rst->moveNext();
					$i++;
				}
				
			}else{
				$arrData[] = array();
			}
		}else{
			$arrData[] = array();
			$errMsg = $conn->ErrorMsg();
		}
		
		//print_r($arrData);
		return $arrData;

    }

    public function contentManagement(){
		//$params["title"]="Daftar Produksi ";
		//$params["grid"] = $this->initGrid();
		//$this->render_view('os/produksi/v_m_trans_produksi_list', $params);
		//$this->load->library('Wb_Security');
		$isessid="";
		//if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		//$this->wb_security->id_session = $isessid;
		//$this->session->set_userdata($this->wb_security->cekSession());
		
         $this->load_info_user();
		//$this->session->set_userdata('TMP_NIP','WB040034');
		//$this->session->set_userdata('TMP_KDWIL','0A');
		
        $params["DDListIsMan"][0] = array("id"=>'0', "status"=>'Non Manager');$params["DDListIsMan"][1] = array("id"=>'1', "status"=>'Manager');
               if($this->session->userdata('TMP_NIP')!==""){
			$ivalue="022019";
			if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
			$this->ivalue = $ivalue;
			$params["ivalue"] = $ivalue;
			$params["grid"] = $this->initGrid();
			$params["grid2"] = $this->initGrid2();
			$params["grid3"] = $this->initGridDataBlmIsi();
			$params["grid4"] = $this->initGridDataSdhIsi();
			$params["listbl"] = $this->getListBL();
			$this->render_view('hr/kbi-rev/v_m_kbi_list', $params);
			
		}else{
			redirect('http://erp.wika-beton.co.id');
		}
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
        //$this->session->set_userdata('s_uID', 'LS183677');//LS083110  'LS183677'
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
            $this->session->set_userdata('TMP_KDWIL',$row['KD_PAT']);
            $this->session->set_userdata('TMP_NIP',$this->session->userdata('s_uID'));
        }
        return $this->session->userdata;
    }
    public function initGrid(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.ESELON";
		$paramsGrid["source"]["datafields"][$i]["name"]="ESELON";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ESELON";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="70";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(b.first_name || ' ' || b.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.KET";
		$paramsGrid["source"]["datafields"][$i]["name"]="UK";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="d.KET";
		$paramsGrid["source"]["datafields"][$i]["name"]="BIRO_BAGIAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Biro/Bagian";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="e.KET";
		$paramsGrid["source"]["datafields"][$i]["name"]="JABATAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="JABATAN";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="round((select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id and ik_id <> 0)/
			(select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id)*100,2)";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_PERSEN";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="(%) Dinilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="120";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="round((select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id and ik_id <> 0)/
			(select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id)*100,2)";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_PERSEN2";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="(%) Menilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="NILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="STD KBI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["name"]="KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="KBI FIT (%)";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ST_KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="STATUS";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_ATASAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_ATASAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Atasan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_PEER1";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_PEER1";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Peer1";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_PEER2";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_PEER2";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Peer2";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_SUB";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_SUB";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai SUB";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Emp ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		return $paramsGrid;
	}
    public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";$ivalue="11";$filterJTrans="0";$rowdet="0";$parenttrxid="";$iexport="0";$iSQLID="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["parenttrxid"]))$parenttrxid = $_GET["parenttrxid"];
		if(isset($_GET["iexport"]))$ivalue = $_GET["iexport"];
		if(isset($_GET["iSQLID"]))$ivalue = $_GET["iSQLID"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid3()) ;
		
		
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		if($iexport=="0"){
//			$query="select (a.bl|| to_char(a.st_date,'YYYYMMDD') || to_char(a.end_date,'YYYYMMDD') || a.employee_id) as ID, a.bl, a.st_date, a.end_date, b.eselon, a.employee_id, trim(b.first_name || ' ' || b.last_name) as nama, a.nilai_kbi,
//				c.ket as uk, d.ket as biro_bagian, e.ket as jabatan,
//				 a.std_kbi, a.kbi_fit, a.st_kbi_fit, a.nilai_atasan, a.nilai_peer1, a.nilai_peer2, a.nilai_sub, a.nilai_empid,
//				   case
//                    (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id)
//                    when 0  then  0
//                else
//                     round((select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id and ik_id <> 0)/
//                     (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id)*100,2)
//                    end st_persen,
//                 case
//                     (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id)
//                     when 0 then 0
//                 else
//                  round(
//                (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id and ik_id <> 0)/
//                (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id)*100,2
//                ) end   st_persen2
//				from kbi_individu_fit_view02D a
//				inner join personal b on b.employee_id=a.employee_id
//				inner join tb_pat c on c.kd_pat=b.kd_pat
//				inner join tb_gas d on d.kd_gas=b.kd_gas
//				inner join tb_jbt e on e.kd_jbt=b.kd_jbt
//				where a.bl <> 'XX' and a.bl='".$ivalue."'  ".$where."
//				order by eselon, b.kd_pat,  nama";
			$query="select * from(select  (a.bl|| to_char(a.st_date,'YYYYMMDD') || to_char(a.end_date,'YYYYMMDD') || a.employee_id) as ID, a.bl, a.st_date, a.end_date, b.eselon, a.employee_id, trim(b.first_name || ' ' || b.last_name) as nama, a.nilai_kbi,
                c.ket as uk, d.ket as biro_bagian, e.ket as jabatan,
                 a.std_kbi, a.kbi_fit, a.st_kbi_fit, a.nilai_atasan, a.nilai_peer1, a.nilai_peer2, a.nilai_sub, a.nilai_empid,
                   case
                    (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id)
                    when 0  then  0
                else
                     round((select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id and ik_id <> 0)/
                     (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id=a.employee_id)*100,2)
                    end st_persen,
                 case
                     (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id)
                     when 0 then 0
                 else
                  round(
                (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id and ik_id <> 0)/
                (select count(ik_id) from kbi_kp_ik x where x.bl=a.bl and x.st_date=a.st_date and x.end_date=a.end_date and x.employee_id2=a.employee_id)*100,2
                ) end   st_persen2
                from kbi_individu_fit_view02D a
                inner join personal b on b.employee_id=a.employee_id
                inner join tb_pat c on c.kd_pat=b.kd_pat
                inner join tb_gas d on d.kd_gas=b.kd_gas
                inner join tb_jbt e on e.kd_jbt=b.kd_jbt
                where  a.bl='$ivalue'  and a.employee_id in (select employee_id from kbi_d where a.bl='$ivalue')
                order by eselon, b.kd_pat,  nama
                )src where length(ID)>0 ".$where." and rownum < 1000";
			$arrParamData = array("filterPAT"=>$filterPAT);	
		}else{
			$query=$this->session->user_data('HR-KBI-SQL-01-QUERY-'.$iSQLID);
			$arrParamData = array("filterPAT"=>$this->session->user_data('HR-KBI-SQL-01-FILTERPAT-'.$iSQLID));
		}
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		if($iexport=="0"){
			$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		}else{
			$rst=$conn->Execute($query, $arrParamData);
		}
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					
					foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					
					
					$rst->moveNext();
					$i++;
				}
				$sqlId=session_id();
				
				if($iexport=="0"){
					$this->session->set_userdata('HR-KBI-SQL-01-SESSID',$sqlId);
					$this->session->set_userdata('HR-KBI-SQL-01-QUERY-'.$sqlId,$query);
					$this->session->set_userdata('HR-KBI-SQL-01-FILTERPAT-'.$sqlId,$filterPAT);
				}
			}else{
				$total_rows = 0;
				$arrData[] = array();
			}
		}else{
			$total_rows = 0;
			$arrData[] = array();
		
			$errMsg = $conn->ErrorMsg();
		}
		
		
    $data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    } 
    
	public function initGridDataBlmIsi(){
		$paramsGrid["source"]["ID"] = "ID";
		//ID,nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.kd_pat";
		$paramsGrid["source"]["datafields"][$i]["name"]="KD_PAT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode Pat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="d.ket";
		$paramsGrid["source"]["datafields"][$i]["name"]="PPU";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode Pat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id2";
		$paramsGrid["source"]["datafields"][$i]["name"]="NIP_PENILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP PENILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_PENILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA PENILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id";
		$paramsGrid["source"]["datafields"][$i]["name"]="NIP_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP DINILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
                $paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(b.first_title || ' ' || b.first_name || ' ' || b.last_name || ' ' || b.last_title)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA DINILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id2_type";
		$paramsGrid["source"]["datafields"][$i]["name"]="MENILAI_SEBAGAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="MENILAI SEBAGAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
                $paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		return $paramsGrid;
	}

    public function getGridDataBlmIsi(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";$ivalue="11";$filterJTrans="0";$rowdet="0";$parenttrxid="";
                $iexport="0";$iSQLID="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		$recPerPage=20;
                /*
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["parenttrxid"]))$parenttrxid = $_GET["parenttrxid"];
		if(isset($_GET["iexport"]))$ivalue = $_GET["iexport"];
		if(isset($_GET["iSQLID"]))$ivalue = $_GET["iSQLID"];
		*/
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridDataBlmIsi()) ;
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		    /*$query=" select ID,nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai from (
                            select distinct (a.employee_id2||a.employee_id) as   ID,a.employee_id2 as nip_penilai, trim(c.first_name || ' ' || c.last_name) as nama_penilai,
                                a.employee_id as nip_dinilai, trim(b.first_name || ' ' || b.last_name) as nama_dinilai, (case when a.employee_Id2_type LIKE 'ATASAN%' then 'BAWAHAN' when a.employee_id2_type like 'BAWAHAN%' then 'ATASAN' when a.employee_id2_type like 'PEER%' then 'PEER' 
								when a.employee_id2_type like 'DIRI%' then 'DIRI SENDIRI' else '' END) as menilai_sebagai
                                from hrms.kbi_kp_ik a
                                inner join hrms.personal b on a.employee_id=b.employee_id
                                inner join hrms.personal c on a.employee_id2=c.employee_id
                                inner join hrms.kbi_d d1 on d1.employee_id_peer1=a.employee_id 
                                where a.ik_id=0 and a.BL='".$ivalue."')src where nip_penilai<>'XX'  ".$where."
                                order by nama_penilai, nama_dinilai";*/
			$query="select (a.bl || a.employee_id || a.employee_id2) as ID, c.kd_pat, d.ket as ppu,  a.employee_id2 as nip_penilai, trim(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title) as nama_penilai, a.employee_id as nip_dinilai, trim(b.first_title || ' ' || b.first_name || ' ' || b.last_name || ' ' || b.last_title) as nama_dinilai,
			a.employee_id2_type as menilai_sebagai
			from hrms.kbi_kp_ik a
			inner join hrms.personal b on b.employee_id=a.employee_id
			inner join hrms.personal c on c.employee_id=a.employee_id2
			inner join hrms.tb_pat d on d.kd_pat=c.kd_pat
			where bl like '".$ivalue."' $where and a.ik_id ='0'
			group by a.bl, c.kd_pat, d.ket, a.employee_id, a.employee_id2, b.first_title, b.first_name, b.last_name, b.last_title,
			c.first_title, c.first_name, c.last_name, c.last_title, a.employee_id2_type
			order by c.kd_pat, nama_penilai, nama_dinilai";

                 $arrParamData = array();
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
                if($iexport=="0"){
			$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		}else{
			$rst=$conn->Execute($query, $arrParamData);
		}
                $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{	foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					$rst->moveNext();
					$i++;
				}
			}else{
				$total_rows = 0;
				$arrData[] = array();
			}
		}else{
			$total_rows = 0;
			$arrData[] = array();
		
			$errMsg = $conn->ErrorMsg();
		}
		
		
    $data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }   
    
	public function initGridDataSdhIsi(){
		$paramsGrid["source"]["ID"] = "ID";
		//ID,nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.kd_pat";
		$paramsGrid["source"]["datafields"][$i]["name"]="KD_PAT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode Pat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="d.ket";
		$paramsGrid["source"]["datafields"][$i]["name"]="PPU";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode Pat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id2";
		$paramsGrid["source"]["datafields"][$i]["name"]="NIP_PENILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP PENILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_PENILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA PENILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id";
		$paramsGrid["source"]["datafields"][$i]["name"]="NIP_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP DINILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
                $paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(b.first_title || ' ' || b.first_name || ' ' || b.last_name || ' ' || b.last_title)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA DINILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id2_type";
		$paramsGrid["source"]["datafields"][$i]["name"]="MENILAI_SEBAGAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="MENILAI SEBAGAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="max(a.last_update_date)";
		$paramsGrid["source"]["datafields"][$i]["name"]="LASTUPDATEDATE";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Waktu Menilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
        $paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		return $paramsGrid;
	}

    public function getGridDataSdhIsi(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";$ivalue="11";$filterJTrans="0";$rowdet="0";$parenttrxid="";
                $iexport="0";$iSQLID="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		$recPerPage=20;
                /*
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["parenttrxid"]))$parenttrxid = $_GET["parenttrxid"];
		if(isset($_GET["iexport"]))$ivalue = $_GET["iexport"];
		if(isset($_GET["iSQLID"]))$ivalue = $_GET["iSQLID"];
		*/
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridDataBlmIsi()) ;
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
	
			$query="select (a.bl || a.employee_id || a.employee_id2) as ID, c.kd_pat, d.ket as ppu,  a.employee_id2 as nip_penilai, trim(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title) as nama_penilai, a.employee_id as nip_dinilai, trim(b.first_title || ' ' || b.first_name || ' ' || b.last_name || ' ' || b.last_title) as nama_dinilai,
			a.employee_id2_type as menilai_sebagai, max(a.last_update_date) as lastupdatedate
			from hrms.kbi_kp_ik a
			inner join hrms.personal b on b.employee_id=a.employee_id
			inner join hrms.personal c on c.employee_id=a.employee_id2
			inner join hrms.tb_pat d on d.kd_pat=c.kd_pat
			where bl like '".$ivalue."' $where and a.ik_id > 0
			group by a.bl, c.kd_pat, d.ket, a.employee_id, a.employee_id2, b.first_title, b.first_name, b.last_name, b.last_title,
			c.first_title, c.first_name, c.last_name, c.last_title, a.employee_id2_type
			order by c.kd_pat, nama_penilai, nama_dinilai";

                 $arrParamData = array();
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
                if($iexport=="0"){
			$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		}else{
			$rst=$conn->Execute($query, $arrParamData);
		}
                $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{	foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					$rst->moveNext();
					$i++;
				}
			}else{
				$total_rows = 0;
				$arrData[] = array();
			}
		}else{
			$total_rows = 0;
			$arrData[] = array();
		
			$errMsg = $conn->ErrorMsg();
		}
		
		
    $data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    } 

    public function tes(){
        $conn_mysql=$this->load->database('hcis',true);//connected with mysql
        $dataSQL = array();
        
        var_dump($dataSQL);echo '<br>';
        $query=" select ID,nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai from (
                select distinct (a.employee_id2||a.employee_id) as   ID,a.employee_id2 as nip_penilai, trim(c.first_name || ' ' || c.last_name) as nama_penilai,
                a.employee_id as nip_dinilai, trim(b.first_name || ' ' || b.last_name) as nama_dinilai, a.employee_id2_type as menilai_sebagai
                from hrms.kbi_kp_ik a
                inner join hrms.personal b on a.employee_id=b.employee_id
                inner join hrms.personal c on a.employee_id2=c.employee_id
                inner join hrms.kbi_d d1 on d1.employee_id_peer1=a.employee_id 
                where a.ik_id=0 and a.BL='012019')src where nip_penilai<>'XX' 
                order by nama_penilai, nama_dinilai";
        $resultORA=$this->db->query($query)->result();
        foreach ($resultORA as $dataOra) {
            $query = "select user_id,user_name,email,device_id from hcis.m_users where user_id='".$dataOra->NIP_PENILAI."'";
            $resultMysql=$conn_mysql->query($query)->result();
            if(count($resultMysql)){
                echo $dataOra->NIP_PENILAI .'-'. $resultMysql[0]->device_id.'<br>';
                
            } 
        }
    }
	//---------------------------------------------
	public function DOWNLOAD_FILE_NILAI()
	{
		$msg="";
		$status="";
		$rptName="";
		//$pathdir="C://xampp/htdocs/erp-ci/download/";
		$pathdir="/wwwroot/php5/erp-ci/download/";
		
		$ibl="";
		$ieselon="ALL";
		
		if(isset($_GET["ibl"]))$ibl = $_GET["ibl"];
		
		if($ibl!="" )
		{
			$randfname = Date("Y_m_d");
			
			$fname = $ibl."_nilai".$randfname.".xlsx";
			$rptName="\hrms\kbi\Rpt_KBI_Nilai.rpt";
			$strParamName= "&promptex-iBL=".$ibl;
			$exportType="EXCELWORKBOOK";
			
			$serverLink = "http://10.3.1.95:12000/ReCrystallizeServer/ViewReport.aspx?report=".$rptName;
			$fullLink=$serverLink.$strParamName."&exportfmt=$exportType";
			$fdata = file_get_contents($fullLink);
		
			$fSaveAs=fopen($pathdir."$fname","w");

			fwrite($fSaveAs, $fdata);
			fclose($fSaveAs);
			
			//$strCmd = "/usr/bin/pdftk ".$pathdir.$fname." multibackground /wwwroot/php5/erp-ci/assets/images/bg_slip_4PDF.pdf output ".$pathdir.$fnameprotected." user_pw $inip allow printing";
			//system($strCmd);
				
			$status="OK";
		}
		
	
		$dataStatus[] = array(
		   'Status'=>$status,
		   'url'=>base_url(),
		   'fname'=>$fname,
		   'Msg'=>$msg
		);
		print_r(json_encode($dataStatus,JSON_PRETTY_PRINT));
	}		
	//---------------------------------------------
	 public function DOWNLOAD_FILE_NILAIx() {
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $periode      = json_decode($json);
        set_time_limit(0);
        //------------------------------------------------------------------------
        
       $queryOra=" select  a.bl, a.st_date, a.end_date,a.employee_id as employee_id,a.nama_dinilai,
                UPPER(b.jenis_kriteria_penilaian) as jenis_kriteria_penilaian, a.atasan_empid, trim(c.first_name || ' ' || c.last_name) as nama_atasan,
                a.atasan_skor, a.atasan_bval, a.peer1_empid, trim(d.first_name || ' ' || d.last_name) as nama_peer1, a.peer1_skor, a.peer1_bval, a.peer2_empid, trim(e.first_name || ' ' || e.last_name) as nama_peer2, a.peer2_skor, a.peer2_bval, a.sub1_empid, trim(f.first_name || ' ' || f.last_name) as nama_sub1, a.sub1_skor, a.sub2_empid, trim(g.first_name || ' ' || g.last_name) as nama_sub2, a.sub2_skor, a.sub3_empid, trim(h.first_name || ' ' || h.last_name) as nama_sub3, a.sub3_skor, round(a.sub_skor,2) as sub_skor, round(a.sub_bval,2) as sub_bval, 
                a.empid_skor, a.empid_bval, round(a.nilai_kbi,2) as nilai_kbi, a.std_kbi, to_char(round(a.kbi_fit,2)||'%') as kbi_fit
                from 
                ( select a.*,b.first_name||' '||b.last_name nama_dinilai from hrms.kbi_tabulasi a inner join hrms.personal b on a.employee_id=b.employee_id 
               )  
                a
                inner join hrms.kbi_kp_h b on a.kp_id=b.kp_id
                inner join hrms.personal c on c.employee_id=a.atasan_empid
                inner join hrms.personal d on d.employee_id=a.peer1_empid
                inner join hrms.personal e on e.employee_id=a.peer2_empid
                left outer join hrms.personal f on f.employee_id=a.sub1_empid
                left outer join hrms.personal g on g.employee_id=a.sub2_empid
                left outer join hrms.personal h on h.employee_id=a.sub3_empid
                where a.bl like'".$periode."'  
                order by a.employee_id, a.kp_id";
         $resultORA=$this->db->query($queryOra)->result();
        ///--------- SETTING FILE EXCELL --------
        $fileName='/wwwroot/php5/erp-ci/download/RekapNilaiKBI_'.$periode.'.xlsx';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Rekap Nilai KBI");
        $col=0;$row=1;
        $header= array('BL','ST_DATE','END_DATE','EMPLOYEE_ID','NAMA_DINILAI','JENIS_KRITERIA_PENILAIAN','ATASAN_EMPID','NAMA_ATASAN','ATASAN_SKOR','ATASAN_BVAL','PEER1_EMPID',
			       'NAMA_PEER1','PEER1_SKOR','PEER1_BVAL','PEER2_EMPID','NAMA_PEER2','PEER2_SKOR','PEER2_BVAL',
                   'SUB1_EMPID','NAMA_SUB1','SUB1_SKOR','SUB2_EMPID','NAMA_SUB2','SUB2_SKOR','SUB3_EMPID','NAMA_SUB3','SUB3_SKOR',
                   'SUB_SKOR','SUB_BVAL','EMPID_SKOR','EMPID_BVAL','NILAI_KBI','STD_KBI','KBI_FIT');
		
        foreach ($header as $opt) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $opt);$col++;
        }
        $row=2;$last_rowExt=0;
        $cur_doc='';$row_awal_ext=0;$last_a=0;$last_b=0;
      foreach ($resultORA as $dataOra) {
           $col = 0;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->BL);$col++;
			
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->ST_DATE);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->END_DATE);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->EMPLOYEE_ID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_DINILAI);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->JENIS_KRITERIA_PENILAIAN);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->ATASAN_EMPID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_ATASAN);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->ATASAN_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->ATASAN_BVAL);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER1_EMPID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_PEER1);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER1_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER1_BVAL);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER2_EMPID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_PEER2);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER2_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PEER2_BVAL);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB1_EMPID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_SUB1);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB1_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB2_EMPID);$col++;				   
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_SUB2);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB2_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB3_EMPID);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_SUB3);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB3_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->SUB_BVAL);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->EMPID_SKOR);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->EMPID_BVAL);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NILAI_KBI);$col++;
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->STD_KBI);$col++;	
				   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->KBI_FIT);$col++;
           $row++;
       }
       
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
       /* redirect($fileName);
        */
		$fileName='download/RekapNilaiKBI_'.$periode.'.xlsx';
        print_r(json_encode($fileName,JSON_PRETTY_PRINT));
    }
	
	
    public function DOWNLOAD_FILE_SDH_ISI() {
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $periode      = json_decode($json);
     
        //------------------------------------------------------------------------
        
        $queryOra=" select ID,kd_pat, uk, nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai from (
                select distinct (a.employee_id2||a.employee_id) as   ID, c.kd_pat, f.ket as uk, a.employee_id2 as nip_penilai,  trim(c.first_title||' '||c.first_name || ' ' || c.last_name||' '| |c.last_title) as nama_penilai,
                a.employee_id as nip_dinilai, trim(b.first_title||' '||b.first_name || ' ' || b.last_name||' '| |b.last_title) as nama_dinilai, 
                case when  a.employee_id2_type like 'BAWAHAN%' then 'ATASAN' when a.employee_id2_type like 'ATASAN%' then 'BAWAHAN' else a.employee_id2_type  end as menilai_sebagai
                from hrms.kbi_kp_ik a
                inner join hrms.personal b on a.employee_id=b.employee_id
                inner join hrms.personal c on a.employee_id2=c.employee_id
				inner join hrms.tb_pat f on f.kd_pat=c.kd_pat
                inner join hrms.kbi_d d1 on d1.employee_id_peer1=a.employee_id 
                where a.ik_id<>0 and a.BL='".$periode."')src where nip_penilai <>'X'
                order by nama_penilai, nama_dinilai";
        //  in ('WB040034','LS183677','TK180088',  'LS900946','TK180092','WB030025','WB060036')
        $resultORA=$this->db->query($queryOra)->result();
        ///--------- SETTING FILE EXCELL --------
        $fileName='/wwwroot/php5/erp-ci/download/SudahIsiKBI_'.$periode.'.xlsx';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Daftar Sudah Isi KBI");
        $col=0;$row=1;
        $header= array('KODE PAT', 'UNIT KERJA', 'NIP. PENILAI','NAMA PENILAI','NIP DINILAI','NAMA DINILAI','MENILAI SEBAGAI');
        foreach ($header as $opt) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $opt);$col++;
        }
        $row=2;$last_rowExt=0;
        $cur_doc='';$row_awal_ext=0;$last_a=0;$last_b=0;
      foreach ($resultORA as $dataOra) {
           $col = 0;
		   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->KD_PAT);$col++;
		   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->UK);$col++;
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NIP_PENILAI);$col++;
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_PENILAI);$col++;
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NIP_DINILAI);$col++;
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_DINILAI);$col++;
           $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->MENILAI_SEBAGAI);$col++;
           $row++;
       }
       
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
       /* redirect($fileName);
        */
		$fileName='download/SudahIsiKBI_'.$periode.'.xlsx';
        print_r(json_encode($fileName,JSON_PRETTY_PRINT));
    }
	public function DOWNLOAD_FILE_BLM_ISI() {
		$json      = utf8_encode($_POST['json']); // Don't forget the encoding
		$periode      = json_decode($json);
		//update baru
		//------------------------------------------------------------------------
		
		$queryOra=" select  (a.bl || a.employee_id || a.employee_id2) as ID, c.kd_pat, d.ket as ppu, a.employee_id2 as nip_penilai,
trim(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title) as nama_penilai, a.employee_id as nip_dinilai,
 trim(b.first_title || ' ' || b.first_name || ' ' || b.last_name || ' ' || b.last_title) as nama_dinilai,
 a.employee_id2_type as menilai_sebagai from hrms.kbi_kp_ik a inner join hrms.personal b on b.employee_id=a.employee_id
 inner join hrms.personal c on c.employee_id=a.employee_id2 inner join hrms.tb_pat d on d.kd_pat=c.kd_pat
 where bl like '$periode' and a.ik_id ='0' group by a.bl, c.kd_pat, d.ket, a.employee_id, a.employee_id2, b.first_title,
  b.first_name, b.last_name, b.last_title, c.first_title, c.first_name, c.last_name, c.last_title, a.employee_id2_type
  order by c.kd_pat, nama_penilai, nama_dinilai";
		
		//var_dump($queryOra);
		//  in ('WB040034','LS183677','TK180088',  'LS900946','TK180092','WB030025','WB060036')
		$resultORA=$this->db->query($queryOra)->result();
		///--------- SETTING FILE EXCELL --------
			$fileName='/wwwroot/php5/erp-ci/download/BelumIsiKBI_'.$periode.'.xlsx';
		//$fileName='/wwwroot/php5yazi/download/BelumIsiKBI_'.$periode.'.xlsx';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle("Daftar Sudah Isi KBI");
		$col=0;$row=1;
		$header= array('KODE PAT', 'UNIT KERJA', 'NIP. PENILAI','NAMA PENILAI','NIP DINILAI','NAMA DINILAI','MENILAI SEBAGAI');
		foreach ($header as $opt) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $opt);$col++;
		}
		$row=2;$last_rowExt=0;
		$cur_doc='';$row_awal_ext=0;$last_a=0;$last_b=0;
		foreach ($resultORA as $dataOra) {
			$col = 0;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->KD_PAT);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->PPU);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NIP_PENILAI);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_PENILAI);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NIP_DINILAI);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->NAMA_DINILAI);$col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dataOra->MENILAI_SEBAGAI);$col++;
			$row++;
		}
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($fileName);
		// download file
		header("Content-Type: application/vnd.ms-excel");
		/* redirect($fileName);
		 */
		$fileName='download/BelumIsiKBI_'.$periode.'.xlsx';
		print_r(json_encode($fileName,JSON_PRETTY_PRINT));
	}
    public function SEND_NOTIF() {
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $periode      = json_decode($json);
        //------------------------------------------------------------------------
        $conn_mysql=$this->load->database('hcis',true);//connected with mysql
        $queryOra=" select ID,nip_penilai,nama_penilai,nip_dinilai,nama_dinilai,menilai_sebagai from (
                select distinct (a.employee_id2||a.employee_id) as   ID,a.employee_id2 as nip_penilai,  trim(c.first_title||' '||c.first_name || ' ' || c.last_name||' '| |c.last_title) as nama_penilai,
                a.employee_id as nip_dinilai, trim(b.first_title||' '||b.first_name || ' ' || b.last_name||' '| |b.last_title) as nama_dinilai, 
                case when  a.employee_id2_type like 'BAWAHAN%' then 'ATASAN' when a.employee_id2_type like 'ATASAN%' then 'BAWAHAN' else a.employee_id2_type  end as menilai_sebagai
                from hrms.kbi_kp_ik a
                inner join hrms.personal b on a.employee_id=b.employee_id
                inner join hrms.personal c on a.employee_id2=c.employee_id
                inner join hrms.kbi_d d1 on d1.employee_id_peer1=a.employee_id 
                where a.ik_id=0 and a.BL='".$periode."')src where nip_penilai <>'X'
                order by nama_penilai, nama_dinilai";
        //  in ('WB040034','LS183677','TK180088',  'LS900946','TK180092','WB030025','WB060036')
        $resultORA=$this->db->query($queryOra)->result();
        
        $cek_=array();$curr_email="";$kirim_email=array();$cnt=0;$abodymail=array();
        foreach ($resultORA as $dataOra) {
            $query = "select a.employee_id,a.eselon,b.device_id,a.email from personal a 
                    inner join m_users b on a.employee_id=b.user_id
                    where user_id='".$dataOra->NIP_PENILAI."'";
            //$query = "select user_id,user_name,email,device_id from hcis.m_users where user_id='".$dataOra->NIP_PENILAI."'";
            $resultMysql=$conn_mysql->query($query)->result();
            if(count($resultMysql)){
                //echo $dataOra->NIP_PENILAI .'-'. $resultMysql[0]->device_id.'<br>';
                $reg_Id=$resultMysql[0]->device_id;		
                $judul = "Info";
                $isi_pesan = "Pastikan KBI a/n ".$dataOra->NAMA_DINILAI." sudah anda input";
                $idNotif = "";
                $jnsNotif = "01";
                $url="https://api.wika-beton.co.id/web-service/wton-mobile/firebase/send_notif.php?reg_Id=".$reg_Id."&title=".$judul."&message=".$isi_pesan."&idNotif=".$idNotif."&jenisnotif=".$jnsNotif;
                $response = file_get_contents($url);
                $response = json_decode($response);
                if($resultMysql[0]->email<>$curr_email){
                    if($curr_email<>'' ){
                        $bodymail = $bodymail."</table>";  array_push($abodymail,array("email"=>$curr_email,"bodymail" => $bodymail));
                    }
                    $curr_email=$resultMysql[0]->email;$dinilai=array();
                    $bodymail = "<table cellpadding=2 cellspacing=2 style='width:100%;'><tr><th>NIP DINILAI</th><th align='left'>NAMA DINILAI</th><th>DINILAI SEBAGAI</th></tr>";
                    $bodymail = $bodymail."<tr><td>".$dataOra->NIP_DINILAI."</td><td>".$dataOra->NAMA_DINILAI."</td><td>".$dataOra->MENILAI_SEBAGAI."</td></tr>";
                }else{
                    $bodymail = $bodymail."<tr><td>".$dataOra->NIP_DINILAI."</td><td>".$dataOra->NAMA_DINILAI."</td><td>".$dataOra->MENILAI_SEBAGAI."</td></tr>";
                }
            }
           
        }
        $end_date='';
        if($curr_email<>'' ){
            $bodymail = $bodymail."</table>";  array_push($abodymail,array("email"=>$curr_email,"bodymail" => $bodymail));
            $query="select to_char(end_date,'dd/mm/yyyy')end_date from hrms.kbi_h where bl='".$periode."'";
            $resultORA=$this->db->query($query)->result();
            $end_date=$resultORA[0]->END_DATE;
        }
        //-------------------Kirim email-----------------------------------------------------
        foreach ($abodymail as $key => $value) {
            $config = Array(
               'protocol' => 'smtp'
               ,'smtp_host' => 'ssl://wbmail.wika-beton.co.id'
               ,'smtp_port' => 465
               ,'smtp_user' => 'hc@wika-beton.co.id'
               ,'smtp_pass' => 'w1k4b3t0n'
               ,'mailtype'  => 'html' 
               ,'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            //$this->email->attach($path);
            $this->email->from('hc@wika-beton.co.id', 'HC Admin');
            $this->email->to($value['email']);
            $this->email->subject('Info Pengisian Penilaian KBI Periode '.$periode);
            $bodymail='Dengan Hormat,<br>Berikut ini adalah daftar penilaian <b>KBI (Key Behavior Index)</b> periode <b>'.$periode.'</b> anda, yang belum diselesaikan :  <br>'.$value['bodymail'];
            $bodymail .='<br>Mohon untuk dapat diselesaikan sebelum <b>'.$end_date.'</b>';
            $bodymail .= '<br><br>Hormat kami,<br><br><br>ttd<br><br>Administrasi HC';
            $this->email->message($bodymail);
            $this->email->send();
            $this->email->clear(TRUE);
        }
        print_r(json_encode($end_date,JSON_PRETTY_PRINT));
    }
    public function f_upload(){
        $IsMan = $_POST['txtIsMan'];
      /*  $Periode = $_POST['txtBL_'];
        $ST_DATE = $_POST['txtST_DATE_'];
        $END_DATE = $_POST['txtEND_DATE_'];*/
        $TGL_BERLAKU = $_POST['txtTGL_BERLAKU'];
        if($IsMan==='1'){
            $ket_level='Manajer';
        }else{
            $ket_level='Non Manajer';
        }
        $user=$this->session->userdata('s_uID');                       //---------------- Ambil dari Server -----------------------------------------
        $tgl_create=date("Y-m-d H:i:s");
        $fileName = time().$_FILES["kbifile"]['name'];
        $config['upload_path'] = './upload/kbi/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
     
        $this->load->library('upload');
        $this->upload->initialize($config);
        if(! $this->upload->do_upload('kbifile') )
        $this->upload->display_errors();
        $media = $this->upload->data();
        $inputFileName = './upload/kbi/'.$media['file_name'];
        //------------------------------------------------------
      	try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $dtmp= array();
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                //Sesuaikan sama nama kolom tabel di database                                
                if($rowData[0][0]==''){
                    $row = $highestRow;
                }else{
                    $no_urut=$row-1;
                    $sql="select tgl_berlaku from hrms.kbi_kp_h where tgl_berlaku= to_date('".$TGL_BERLAKU."','dd/mm/yyyy') and "
                       . "is_manager='".$IsMan."' and no_urut=".$no_urut." and jenis_kriteria_penilaian='".$rowData[0][0]."'";
                    $rows=$this->db->query($sql)->num_rows();
                    if($rows>0){
                        $sql="update hrms.kbi_kp_h set kriteria_penilaian='".$rowData[0][1]."',"
                                . "last_update_by='".$user."',last_update_date= to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss')    where tgl_berlaku= to_date('".$TGL_BERLAKU."','dd/mm/yyyy') and "
                       . "is_manager='".$IsMan."' and no_urut=".$no_urut." and jenis_kriteria_penilaian='".$rowData[0][0]."'";
                    }else{
                        $sql="insert into hrms.kbi_kp_h(tgl_berlaku,is_manager,no_urut,jenis_kriteria_penilaian,kriteria_penilaian,created_by,created_date) values("
                        . "to_date('".$TGL_BERLAKU."','dd/mm/yyyy'),'".$IsMan."',".$no_urut.",'".$rowData[0][0]."','".$rowData[0][1]."',"
                        . "'".$user."',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'))";
                    }
                    $result=$this->db->query($sql);
                    for($i=1;$i<=4;$i++){
                        $sql="select tgl_berlaku from hrms.kbi_kp_d where tgl_berlaku= to_date('".$TGL_BERLAKU."','dd/mm/yyyy') and "
                        . "is_manager='".$IsMan."' and no_urut=".$no_urut."  and no_urut_ik=".$i." and jenis_kriteria_penilaian='".$rowData[0][0]."'";
                        $rows=$this->db->query($sql)->num_rows();
                         if($rows>0){
                            $sql="update hrms.kbi_kp_d set ik_text='".$rowData[0][2*$i]."',ik_skor='".$rowData[0][2*$i+1]."' "
                            . "where tgl_berlaku= to_date('".$TGL_BERLAKU."','dd/mm/yyyy') and "
                            . "is_manager='".$IsMan."' and no_urut=".$no_urut." and jenis_kriteria_penilaian='".$rowData[0][0]."' and "
                            . "no_urut_ik=".$i;
                         }else{
                            $sql="insert into hrms.kbi_kp_d(tgl_berlaku,is_manager,no_urut,jenis_kriteria_penilaian,no_urut_ik,ik_text,ik_skor,created_by,created_date) values("
                           . "to_date('".$TGL_BERLAKU."','dd/mm/yyyy'),'".$IsMan."',".$no_urut.",'".$rowData[0][0]."',".$i.",'".$rowData[0][2*$i]."','".$rowData[0][2*$i+1]."',"
                            . "'".$user."',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'))";
                         }
                        $result=$this->db->query($sql);
                    }
                }
               delete_files($media['file_path']);
            }
        $this->session->set_flashdata('message','Berhasil Upload KBI  u/ Level:'.$ket_level.' Berlaku mulai '.$TGL_BERLAKU);    
        $params=array('pesan'=>'sukses'); 
        $this->index();  
    
        //------------------------------------------------------
        
    }
    public function f_upload_peserta(){
        $BL = $_POST['txtBL'];
        $ST_DATE = $_POST['txtTGL_AWAL'];
        $END_DATE = $_POST['txtTGL_AHIR'];
        $user=$this->session->userdata('s_uID');             
        echo  "<div  id='status'> </div>";
        $tgl_create=date("Y-m-d H:i:s");
        $sql = "select BL from hrms.kbi_h 
                where bl='".trim($BL)."'";
        if($this->db->query($sql)->num_rows()<1){
            $sql="insert into hrms.kbi_h(bl,st_date,end_date,created_by) values('".$BL."',to_date('".$ST_DATE."','dd/mm/yyyy'),
             to_date('".$END_DATE."','dd/mm/yyyy'),'".$user."')";
            $result=$this->db->query($sql);
        } 
        $fileName = time().$_FILES["kbifilePeserta"]['name'];
        $config['upload_path'] = './upload/kbi/'; //buat folder di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
     
        $this->load->library('upload');
        $this->upload->initialize($config);
        if(! $this->upload->do_upload('kbifilePeserta') )
        $this->upload->display_errors();
        $media = $this->upload->data();
        $inputFileName = './upload/kbi/'.$media['file_name'];
        //------------------------------------------------------
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $dtmp= array();
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $status='Proses Upload Data Peserta KBI :'.($row-1);
                echo "<script>document.getElementById('status').innerHTML ='".$status."'  </script>";
                //Sesuaikan sama nama kolom tabel di database
                if($rowData[0][0]==''){
                    $row = $highestRow;
                }else{
                    $no_urut=$row-1;$ESELON='';
                    $sql="select eselon from hrms.personal where employee_id='".$rowData[0][0]."'";
                    if($this->db->query($sql)->num_rows()>0){
                        $getData = $this->db->query($sql)->result_array();
                        foreach ($getData as $rowx){
                            $ESELON = $rowx['ESELON'];
                        }      
                    }
                    $sql="select bl,app1 from hrms.kbi_d where bl='".$BL."' and st_date=to_date('".$ST_DATE."','dd/mm/yyyy')
                        and end_date=to_date('".$END_DATE."','dd/mm/yyyy') and employee_id='".$rowData[0][0]."'";
                    $rows=$this->db->query($sql)->num_rows();
                    if(strlen(trim($rowData[0][1]))<5) { $rowData1="";}else{$rowData1=$rowData[0][1];}
                    if(strlen(trim($rowData[0][2]))<5) { $rowData2="";}else{$rowData2=$rowData[0][2];}
                    if(strlen(trim($rowData[0][3]))<5) { $rowData3="";}else{$rowData3=$rowData[0][3];}
                    if(strlen(trim($rowData[0][4]))<5) { $rowData4="";}else{$rowData4=$rowData[0][4];}
                    if(strlen(trim($rowData[0][5]))<5) { $rowData5="";}else{$rowData5=$rowData[0][5];}
                    if(strlen(trim($rowData[0][6]))<5) { $rowData6="";}else{$rowData6=$rowData[0][6];}
                    if($rows>0){
                        $getData = $this->db->query($sql)->result_array();
                        foreach ($getData as $rowx){
                            $APP1 = $rowx['APP1'];
                        }
                        if($APP1==='0'){
                            $sql="update hrms.kbi_d set employee_id_atasan='".$rowData1."', employee_id_peer1='".$rowData2."',"
                                . "employee_id_peer2='".$rowData3."',employee_id_sub1='".$rowData4."',employee_id_sub2='".$rowData5."',"
                                . "employee_id_sub3='".$rowData6."',is_manager='".$rowData[0][7]."',app1='".$rowData[0][7]."',app1_date=to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss') "
                                . "where bl='".$BL."' and st_date=to_date('".$ST_DATE."','dd/mm/yyyy')
                                    and end_date=to_date('".$END_DATE."','dd/mm/yyyy') and employee_id='".$rowData[0][0]."'";
                        }
                    }else{
                        $sql="insert into hrms.kbi_d(bl,st_date,end_date,employee_id,eselon,employee_id_atasan,employee_id_peer1,employee_id_peer2,employee_id_sub1,
                        employee_id_sub2,employee_id_sub3,is_manager,created_by,created_date,app1,app1_date) values(
                        '".$BL."',to_date('".$ST_DATE."','dd/mm/yyyy'),to_date('".$END_DATE."','dd/mm/yyyy'),trim('". $rowData[0][0]."'),trim('"
                       . $ESELON."'),trim('".$rowData1."'),trim('".$rowData2."'),trim('".$rowData3."'),trim('".$rowData4."'),trim('".$rowData5."'),trim('"
                       .$rowData6."'),trim('".$rowData[0][7]."'),'UPLOAD',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'),'".$rowData[0][8]."',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'))";
                    }
                    $result=$this->db->query($sql);
                }
            }
        echo "<script>document.getElementById('status').innerHTML =''  </script>";    
        delete_files($media['file_path']);
        $this->session->set_flashdata('message','Berhasil Upload Daftar Pegawai Periode  '.$ST_DATE.' s/d '.$END_DATE);    
        $params=array('pesan'=>'sukses'); 
        $this->contentManagement();  
    }
    public function cekPeriode(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        //$conn = $this->adodbconn->getOraConn("HR");		
	$sql = "select BL,to_char(st_date,'dd-mm-yyyy')st_date,to_char(end_date,'dd-mm-yyyy')end_date from hrms.kbi_h 
                where bl='".trim($data)."'";
        $result=array();
        if($this->db->query($sql)->num_rows()>0){
            $cek="1";
            $result=$this->db->query($sql)->result();
        }else{$cek="0";}
        $params=array('cek'=>$cek,'data'=>$result); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));
  
    }
	public function initGrid2(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.JENIS_KRITERIA_PENILAIAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="JENIS_KRITERIA_PENILAIAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="KRITERIA PENILAIAN";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="250";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["pinned"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ATASAN_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ATASAN_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="ATASAN";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(c.first_name || ' ' || c.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_ATASAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="ATASAN";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ATASAN_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="ATASAN_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="ATASAN";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ATASAN_BVAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="ATASAN_BVAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="ATASAN";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER1_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER1_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER1";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(d.first_name || ' ' || d.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_PEER1";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="PEER1";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER1_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER1_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER1";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER1_BVAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER1_BVAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER1";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER2_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER2_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER2";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(e.first_name || ' ' || e.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_PEER2";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="PEER2";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER2_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER2_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER2";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PEER2_BVAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="PEER2_BVAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="PEER2";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB1_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB1_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN1";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(f.first_name || ' ' || f.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_SUB1";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN1";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB1_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB1_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN1";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB2_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB2_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN2";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(g.first_name || ' ' || g.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_SUB2";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN2";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB2_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB2_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN2";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB3_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB3_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN3";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(h.first_name || ' ' || h.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_SUB3";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN3";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB3_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB3_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN3";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.SUB_BVAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="SUB_BVAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="BAWAHAN";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.EMPID_SKOR";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPID_SKOR";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="SKOR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="DIRISENDIRI";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.EMPID_BVAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPID_BVAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="DIRISENDIRI";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="NILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="STANDAR";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["name"]="KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="KBI FIT (%)";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		return $paramsGrid;
	}
	public function initGrid3(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ESELON";
		$paramsGrid["source"]["datafields"][$i]["name"]="ESELON";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ESELON";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="70";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NAMA";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="UK";
		$paramsGrid["source"]["datafields"][$i]["name"]="UK";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="BIRO_BAGIAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="BIRO_BAGIAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Biro/Bagian";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="JABATAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="JABATAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="JABATAN";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="200";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ST_PERSEN";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_PERSEN";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="(%) Dinilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="120";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ST_PERSEN2";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_PERSEN2";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="(%) Menilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="NILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["name"]="STD_KBI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="STD KBI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["name"]="KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="KBI FIT (%)";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ST_KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_KBI_FIT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="STATUS";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_ATASAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_ATASAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Atasan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_PEER1";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_PEER1";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Peer1";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_PEER2";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_PEER2";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Peer2";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_SUB";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_SUB";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai SUB";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NILAI_EMPID";
		$paramsGrid["source"]["datafields"][$i]["name"]="NILAI_EMPID";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Nilai Emp ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="KBIINDIVIDU";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		return $paramsGrid;
	}
	
	public function getGridData2(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";$ivalue="";$filterJTrans="0";$rowdet="0";$recid="";$iempid="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["recid"]))$recid = $_GET["recid"];
		if(isset($_GET["iempid"]))$iempid = $_GET["iempid"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		
		
		$query="select (a.bl || to_char(a.st_date,'YYYYMMDD') || to_char(a.end_date,'YYYYMMDD') || a.employee_id) as ID, a.bl, a.st_date, a.end_date, UPPER(b.jenis_kriteria_penilaian) as jenis_kriteria_penilaian, a.atasan_empid, trim(c.first_name || ' ' || c.last_name) as nama_atasan,
				a.atasan_skor, a.atasan_bval, a.peer1_empid, trim(d.first_name || ' ' || d.last_name) as nama_peer1, a.peer1_skor, a.peer1_bval, a.peer2_empid, trim(e.first_name || ' ' || e.last_name) as nama_peer2, a.peer2_skor, a.peer2_bval, a.sub1_empid, trim(f.first_name || ' ' || f.last_name) as nama_sub1, a.sub1_skor, a.sub2_empid, trim(g.first_name || ' ' || g.last_name) as nama_sub2, a.sub2_skor, a.sub3_empid, trim(h.first_name || ' ' || h.last_name) as nama_sub3, a.sub3_skor, round(a.sub_skor,2) as sub_skor, round(a.sub_bval,2) as sub_bval, 
				a.empid_skor, a.empid_bval, round(a.nilai_kbi,2) as nilai_kbi, a.std_kbi, to_char(round(a.kbi_fit,2)||'%') as kbi_fit
				from kbi_tabulasi a
				inner join kbi_kp_h b on a.kp_id=b.kp_id
				inner join personal c on c.employee_id=a.atasan_empid
				inner join personal d on d.employee_id=a.peer1_empid
				inner join personal e on e.employee_id=a.peer2_empid
				left outer join personal f on f.employee_id=a.sub1_empid
				left outer join personal g on g.employee_id=a.sub2_empid
				left outer join personal h on h.employee_id=a.sub3_empid
				where a.employee_id like '".$iempid."' 
				and a.bl like '".$ivalue."'
				order by a.employee_id, a.kp_id";
				
		$arrParamData = array("filterPAT"=>$filterPAT);
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rst=$conn->Execute($query,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					
					foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					
					
					$rst->moveNext();
					$i++;
				}
			}else{
				$total_rows = 0;
				$arrData[] = array();
			}
		}else{
			$total_rows = 0;
			$arrData[] = array();
		
			$errMsg = $conn->ErrorMsg();
		}
		
		$data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }  

	public function getGridData3(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";$ivalue="12018";$filterJTrans="0";$rowdet="0";$recid="";$iempid="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["recid"]))$recid = $_GET["recid"];
		if(isset($_GET["iempid"]))$iempid = $_GET["iempid"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		
		$arrAbc = array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"E",6=>"F",7=>"G",8=>"H",9=>"I",10=>"J",11=>"K",12=>"L",13=>"M",14=>"N",15=>"O",16=>"P",17=>"Q",18=>"R",19=>"S",20=>"T",21=>"U", 22=>"V",23=>"W",24=>"X",25=>"Y",26=>"Z",);
		$query="select UPPER(b.jenis_kriteria_penilaian) as JENIS, a.STD_KBI, round(a.nilai_kbi,2) as NILAI_KBI
				from kbi_tabulasi a
				inner join kbi_kp_h b on a.kp_id=b.kp_id
				where a.employee_id like '".$iempid."' and a.bl like '022019' and a.kp_id > 41
				order by a.employee_id, a.kp_id";
		
		
		$arrParamData = array("filterPAT"=>$filterPAT);
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rst=$conn->Execute($query,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					$arrData[$i]["ABC"]=$arrAbc[$i+1];
					foreach($rst->fields as $key=>$value){
						//$arrData[$i][$key]=$value;
						$arrData[$i][$key]=$value;
					}
					
					$rst->moveNext();
					$i++;
				}
			}else{
				$total_rows = 0;
				$arrData[] = array();
			}
		}else{
			$total_rows = 0;
			$arrData[] = array();
		
			$errMsg = $conn->ErrorMsg();
		}
		
		
		
        print_r(json_encode($arrData));

    }

	public function genReport01()
	{
		$msg="";
		$status="";
		$rptName="";
		//$pathdir="C://xampp/htdocs/erp-ci/download/";
		$pathdir="/wwwroot/php5/erp-ci/download/";
		
		$ibl="";
		$ieselon="ALL";
		
		if(isset($_GET["ibl"]))$ibl = $_GET["ibl"];
		if(isset($_GET["ieselon"]))$inip = $_GET["ieselon"];
		
		if($ibl!="" && $ieselon!="")
		{
			$randfname = Date("Y_m_d");
			
			$fname = $ibl."_".$randfname.".pdf";
			$rptName="\hrms\kbi\Rpt_KBI_01.rpt";
			$strParamName= "&promptex-bl=".$ibl;
			$strParamName.= "&promptex-eselon=".$ieselon;
			$exportType="PDF";
			
			$serverLink = "http://10.3.1.95:12000/ReCrystallizeServer/ViewReport.aspx?report=".$rptName;
			$fullLink=$serverLink.$strParamName."&exportfmt=$exportType";
			
			$fdata = file_get_contents($fullLink);
		
			$fSaveAs=fopen($pathdir."$fname","w");

			fwrite($fSaveAs, $fdata);
			fclose($fSaveAs);
			
			//$strCmd = "/usr/bin/pdftk ".$pathdir.$fname." multibackground /wwwroot/php5/erp-ci/assets/images/bg_slip_4PDF.pdf output ".$pathdir.$fnameprotected." user_pw $inip allow printing";
			//system($strCmd);
				
			$status="OK";
		}
		
	
		$dataStatus[] = array(
		   'Status'=>$status,
		   'url'=>base_url(),
		   'fname'=>$fname,
		   'Msg'=>$msg
		);
		print_r(json_encode($dataStatus,JSON_PRETTY_PRINT));
	}	
}
