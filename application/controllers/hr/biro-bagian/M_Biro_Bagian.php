<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Biro_Bagian extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * Februari 2018
	 */
	 
	var $oraConn = "HR";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
	var $ikdpat="";
	var $irowactive="";
	
	public function __construct(){
        parent::__construct();
		
        date_default_timezone_set('Asia/Jakarta');
    }
	
    public function render_view($content = "main", $params = array()){
		$params["PageTitle"] = "Daftar Biro/Bagian/Seksi";
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
		$this->load->library('Wb_Security');
		$isessid="";
		if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		$this->wb_security->id_session = $isessid;
		$this->session->set_userdata($this->wb_security->cekSession());
		$this->session->set_userdata('TMP_NIP','WB040034');
		
		if($this->session->userdata('TMP_NIP')!=""){
			$ikdpat="0A";
			if(isset($_GET["ikdpat"]))$ikdpat = $_GET["ikdpat"];
			$this->ikdpat = $ikdpat;
			$params["ikdpat"] = $ikdpat;
			$params["grid"] = $this->initGrid();
			
			$this->load->library('AdodbConn');
			$conn = $this->adodbconn->getOraConn("HR");		
			if($ikdpat=="0A"){
				$query="select kd_gas, ket from hrms.tb_gas where kd_gas like '0%' and status='1' order by ket ";
			}else{
				$query="select kd_gas, ket from hrms.tb_gas where kd_gas like '".$ikdpat."%'  and status='1' order by ket ";
			}
			$arrParamData = array();
			$rst=$conn->Execute($query,$arrParamData);
			if($rst)
			{
				if($rst->recordCount()>0)
				{
					$i=0;
					while(!$rst->EOF)
					{
						$params["DDListParent"][$i] = array("Display"=>$rst->fields["KET"], "Value"=>$rst->fields["KD_GAS"]);
						$rst->moveNext();
						$i++;
					}
				}
			}
		
			$this->render_view('hr/biro-bagian/v_m_biro_bagian_list', $params);
			
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
		$paramsGrid["columns"][$i]["width"]="15%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KD_GAS";
		$paramsGrid["source"]["datafields"][$i]["name"]="KD_GAS";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KET";
		$paramsGrid["source"]["datafields"][$i]["name"]="KET";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Keterangan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="65%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(select count(x.employee_id) from personal x where x.kd_gas like a.kd_gas)";
		$paramsGrid["source"]["datafields"][$i]["name"]="JML_PEG";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Jumlah Pegawai Aktif";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.PARENT_KD_GAS";
		$paramsGrid["source"]["datafields"][$i]["name"]="PARENT_KD_GAS";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="PARENT_KD_GAS";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		// $i++;
		// $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(Case when a.status='1' THEN 'Aktif' ELSE 'Tdk Aktif' END)";
		// $paramsGrid["source"]["datafields"][$i]["name"]="STATUS";
		// $paramsGrid["source"]["datafields"][$i]["type"]="string";
		// $paramsGrid["columns"][$i]["text"]="Status";
		// $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		// $paramsGrid["columns"][$i]["width"]="10%";
		// $paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["name"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="FLAG_DATA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		return $paramsGrid;
	}
	
	
	public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";$ikdpat="0A";$filterJTrans="0";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ikdpat"]))$ikdpat = $_GET["ikdpat"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		if($ikdpat=="0A"){
			$filterKdGas = "0";
		}else{
			$filterKdGas = "$ikdpat";
		}
        $query="select a.kd_gas  as ID, a.kd_gas, a.ket, a.parent_kd_gas, (Case when a.status='1' THEN 'Aktif' ELSE 'Tdk Aktif' END) as status, (select count(x.employee_id) from personal x where x.kd_gas like a.kd_gas and x.st='1') as jml_pegawai from hrms.tb_gas a where a.kd_gas like '".$filterKdGas."%' and a.status like '1' order by a.kd_gas asc";
		$arrParamData = array();
		#$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		$rst=$conn->Execute($query,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
						'ID' =>  $rst->fields["ID"],
						'KD_GAS' =>  $rst->fields["KD_GAS"],
						'KET' =>  $rst->fields["KET"],
						'PARENT_KD_GAS' =>  $rst->fields["PARENT_KD_GAS"],
						'STATUS' => $rst->fields["STATUS"],
						'JML_PEG' => $rst->fields["JML_PEGAWAI"],
						'FLAG_DATA' => "0"
					);	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
					'ID' =>  "",
					'KD_GAS' =>  "",
					'KET' =>  "",
					'PARENT_KD_GAS' =>  "",
					'STATUS' => "",
					'JML_PEG' => 0,
					'FLAG_DATA' => "0"
				);
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
				'ID' =>  "",
					'KD_GAS' =>  "",
					'KET' =>  "",
					'PARENT_KD_GAS' =>  "",
					'STATUS' => "",
					'JML_PEG' => 0,
					'FLAG_DATA' => "0"
				);
		
				$errMsg = $conn->ErrorMsg();
		}
		
		$data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }   
	
	function saveNewData(){
		$data = $_POST;
		$status = "";
		$listOfEM=array();
		$nextNum = 0;
		$newKdGas = "";
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");	
		
		if($data["ikdpat"]=="0A"){
			$sql="select (to_number(max(kd_gas))+1) as nextNum from tb_gas where kd_gas like '0%' and kd_gas not like '099' and kd_gas not like '0A%'";
			$rst=$conn->Execute($sql);
			if($rst->recordCount()>0){
				$nextNum = $rst->fields["NEXTNUM"];
			}
			$newKdGas = "0".sprintf("%02d",$nextNum);
		}else{
			$sql="select (to_number(max(kd_gas))+1) as nextNum from tb_gas where kd_gas like '".$data["ikdpat"]."%' and wos.is_numeric(kd_gas)=1";
			$rst=$conn->Execute($sql);
			if($rst->recordCount()>0){
				$nextNum = $rst->fields["NEXTNUM"];
			}
			$newKdGas = sprintf("%03d",$nextNum);
		}
		$sql="select ";
		$sql="insert into hrms.tb_gas(KD_GAS, KET, PARENT_KD_GAS, CREATED_BY, CREATED_DATE, STATUS) values (";
		$sql.="'".$newKdGas."'";
		$sql.=",'".$data["ket"]."'";
		$sql.=",'".$data["parent_kd_gas"]."'";
		$sql.=",'".$this->session->userdata('TMP_NIP')."'";
		$sql.=",SYSDATE, '1'";
		$sql.=")";
		
		$rst=$conn->Execute($sql);
		if(!$rst)
		{
			$status="ERROR";
			$listOfEM[]=array("HEADER" => $conn->ErrorMsg(), "SQL"=>$sql);
		}
		
		if(empty($listOfEM))
		{
			$status="BERHASIL";
		}
		$data=array("STATUS"=>$status, "LISTOFEM"=>$listOfEM);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
    function updateData(){
		$data = $_POST;
		$status = "";
		$listOfEM=array();
		//var_dump($data["detil"]);

		$sql="Update hrms.tb_gas set ket='".$data["ket"]."', parent_kd_gas='".$data["parent_kd_gas"]."', last_update_by='".$this->session->userdata('TMP_NIP')."', last_update_date=SYSDATE where kd_gas like '".$data["kd_gas"]."'";
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");	
		$rst=$conn->Execute($sql);
		if(!$rst)
		{
			$status="ERROR";
			$listOfEM[]=array("HEADER" => $conn->ErrorMsg(), "SQL"=>$sql);
		}
		
		if(empty($listOfEM))
		{
			$status="BERHASIL";
		}
		$data=array("STATUS"=>$status, "LISTOFEM"=>$listOfEM);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	} 
    
    
}
