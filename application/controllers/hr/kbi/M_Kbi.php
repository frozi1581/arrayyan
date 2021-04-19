<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Kbi extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * Februari 2018
	 */
	 
	var $oraConn = "HR";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
	var $ivalue="";
	var $irowactive="";
	var $ijtrans="";
	var $ikdpat="";
	
	public function __construct(){
        parent::__construct();
		
        date_default_timezone_set('Asia/Jakarta');
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
   
    public function contentManagement(){
		//$params["title"]="Daftar Produksi ";
		//$params["grid"] = $this->initGrid();
		//$this->render_view('os/produksi/v_m_trans_produksi_list', $params);
		$this->load->library('Wb_Security');
		$isessid="";
		if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		$this->wb_security->id_session = $isessid;
		$this->session->set_userdata($this->wb_security->cekSession());
		
		//$this->session->set_userdata('TMP_NIP','WB040034');
		//$this->session->set_userdata('TMP_KDWIL','0A');
		
		
		if($this->session->userdata('TMP_NIP')!==""){
			$ivalue="11";
			if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
			$this->ivalue = $ivalue;
			$params["ivalue"] = $ivalue;
			$params["grid"] = $this->initGrid();
			$params["grid2"] = $this->initGrid();
			$params["gridLU"] = $this->initGrid();
			$this->render_view('hr/kbi/v_m_kbi_list', $params);
			
		}else{
			redirect('http://erp.wika-beton.co.id');
		}
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
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.BL";
		$paramsGrid["source"]["datafields"][$i]["name"]="BL";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="BL";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ST_DATE";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_DATE";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tgl Mulai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="dd-MM-yyyy";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.END_DATE";
		$paramsGrid["source"]["datafields"][$i]["name"]="END_DATE";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tgl Selesai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="dd-MM-yyyy";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP Yg Di Nilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(b.first_name || ' ' || b.last_name)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama Yg Di Nilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="250";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.ket";
		$paramsGrid["source"]["datafields"][$i]["name"]="JBT_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Jabatan Yg Di Nilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="300";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(case when a.employee_id2=f.employee_id_atasan then 'BAWAHAN' when a.employee_id2=f.employee_id_peer1 then 'PEER' when a.employee_id2=f.employee_id_peer2 then 'PEER' when a.employee_id2=a.employee_id then 'DIRI SENDIRI' ELSE 'ATASAN' END)";
		$paramsGrid["source"]["datafields"][$i]["name"]="ST_YG_DINILAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Yang Di Nilai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="150";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(case when count(ik_id)>0 then 1 else 0 end)";
		$paramsGrid["source"]["datafields"][$i]["name"]="PARTISIPASI";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Status";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="100";
		$paramsGrid["columns"][$i]["columntype"]="checkbox";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id2";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID2";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP PENILAI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		
		return $paramsGrid;
	}
	
	public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";$ivalue="11";$filterJTrans="0";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		$query="select (a.bl||a.st_date||a.end_date||a.employee_id||a.employee_id2) as ID, a.bl, a.st_date, a.end_date, a.employee_id, Replace((b.first_name || ' ' || b.last_name),',','') as nama_dinilai, c.ket as jbt_dinilai, a.employee_id2, d.first_name || '' || d.last_name as nama_Penilai, e.ket as jbt_penilai, (case when a.employee_id2=f.employee_id_atasan then 'Bawahan' when a.employee_id2=f.employee_id_peer1 then 'Peer' when a.employee_id2=f.employee_id_peer2 then 'Peer' when a.employee_id2=a.employee_id then 'Diri Sendiri' ELSE 'Atasan' END) as st_yg_dinilai,
            (case when count(ik_id)>0 then 1 else 0 end) as partisipasi
            from kbi_kp_ik a
            inner join personal b on a.employee_id=b.employee_id
            inner join tb_jbt c on c.kd_jbt=b.kd_jbt
            inner join personal d on d.employee_Id=a.employee_id2
            inner join tb_jbt e on e.kd_jbt=d.kd_jbt
            inner join kbi_d f on f.bl=a.bl and f.st_date=a.st_date and f.end_date=a.end_date and f.employee_Id=a.employee_Id and f.app1='1'
            Where a.employee_id2 like '".$this->session->userdata('TMP_NIP')."' ".$where."
            group by a.bl, a.st_date, a.end_date, a.employee_id, (b.first_name || ' ' || b.last_name) , c.ket, a.employee_id2, 
            d.first_name || '' || d.last_name, e.ket, f.employee_id_atasan, f.employee_id_peer1, f.employee_id_peer2
			order by partisipasi, st_yg_dinilai";
			
		$arrParamData = array();
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
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
	
	
	public function getSurveyData(){
		$data = $_GET;
		$status = "";
		$errMsg = "";
		$listOfEM=array();
		$arrData=array();
		$arrData2=array();
		$totalRec = 0;
		$jmlRespon = 0;
		
		//var_dump($data["detil"]);
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$this->load->helper('erp_wb_helper');
		
		$strAddFields="";$strFieldsValues="";
		
		$query="select count(a.IK_ID) as jml from kbi_kp_ik a where a.bl like :bl and a.st_date like to_date(:st_date,'DD-MM-YYYY') and a.end_date like to_date(:end_date,'DD-MM-YYYY') and a.employee_id like :employee_id and a.employee_id2 like :employee_id2";
		$arrParamData = array("bl"=>"012018", "st_date"=>$data["ST_DATE"], "end_date"=>$data["END_DATE"], "employee_id"=>$data["EMPLOYEE_ID"], "employee_id2"=>$data["EMPLOYEE_ID2"]);
		$rst=$conn->Execute($query,$arrParamData);
		if($rst)
		{
			$jmlRespon = $rst->fields["JML"];
		}
		
		if($jmlRespon<1)
		{
			$arrData[0]["STATUS"]="0";
			$query="select b.no_urut, a.kp_id, B.JENIS_KRITERIA_PENILAIAN, B.KRITERIA_PENILAIAN, b.tgl_berlaku, b.is_manager from kbi_kp_ik a inner join kbi_kp_h b on b.kp_id=a.kp_id where a.bl like :bl and a.st_date like to_date(:st_date,'DD-MM-YYYY') and a.end_date like to_date(:end_date,'DD-MM-YYYY') and a.employee_id like :employee_id and a.employee_id2 like :employee_id2 order by B.NO_URUT ";
				
			$arrParamData = array("bl"=>$data["BL"], "st_date"=>$data["ST_DATE"], "end_date"=>$data["END_DATE"], "employee_id"=>$data["EMPLOYEE_ID"], "employee_id2"=>$data["EMPLOYEE_ID2"]);
			$rst=$conn->Execute($query,$arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0){
					$i=0;$kpid="";
					while(!$rst->EOF)
					{
						$kpid=$rst->fields["KP_ID"];	
						foreach($rst->fields as $key=>$value)
						{
							$arrData[$i][$key]=$value;
						}
						$query2="select a.ik_id, a.ik_text from kbi_kp_d a where a.KP_ID like :kpid ";
						$arrParamData2=array("KPID"=>$kpid);
						$rst2=$conn->Execute($query2,$arrParamData2);
						if($rst2->recordCount()>0){
							$arrJawaban=array();
							while(!$rst2->EOF){
								$arrJawaban[$rst2->fields["IK_ID"]]=$rst2->fields["IK_TEXT"];
								
								$rst2->moveNext();
							}
							//$arrData2[$kpid]=$arrJawaban;
							//$arrData2[$kpid]=shuffle($arrJawaban);
						}
						$arrData[$i]["JAWABAN"]=$arrJawaban;
						$rst->moveNext();
						$i++;
					}
				}
			}
		}else{
			$arrData[0]["STATUS"]="1";
		}
        print_r(json_encode($arrData,JSON_PRETTY_PRINT));

    }   
	
	function saveData(){
		$data = $_GET;
		$status = "";
		$lastNo = 1;
		$strLastNo = "";$strLastNoParent="";
		$listOfEM=array();
		//var_dump($data["detil"]);
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");	
		$strAddFields="";$strFieldsValues="";
		
		foreach($data["JAWABAN"] as $key=>$value)
		{
			if($value!=""){	
				$query="Update hrms.kbi_kp_ik set ik_id= :ik_id where bl like :bl and st_date like to_date(:st_date,'DD-MM-YYYY') and end_date like to_date(:end_date,'DD-MM-YYYY') and employee_id like :employee_id and employee_id2 like :employee_id2 and kp_id like :kp_id";
				$arrParamData = array("ik_id"=>$value, "bl"=>$data["BL"], "st_date"=>$data["ST_DATE"], "end_date"=>$data["END_DATE"], "employee_id"=>$data["EMPLOYEE_ID"], "employee_id2"=>$data["EMPLOYEE_ID2"], "kp_id"=>$key);
				$rst=$conn->Execute($query,$arrParamData);
				if(!$rst)
				{
					$listOfEM["ERROR"]=$conn->ErrorMsg();
				}
				
			}
		}
		
		if(empty($listOfEM))
		{
			$status="BERHASIL";
		}else{
			$status="GAGAL";
		}
		$data=array("STATUS"=>$status, "LISTOFEM"=>$listOfEM);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
     
    public function getLokasi(){
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");	
        $query="select kd_lokasi, ket from tb_lokasi order by kd_lokasi ";
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
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
		
        return $arrData;
    }   
    
}
