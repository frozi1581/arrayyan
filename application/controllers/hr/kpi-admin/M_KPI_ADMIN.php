<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_KPI_ADMIN extends CI_Controller {
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
	var $pathView="hr/kpi-admin/";
	var $idsession = "";
	var $idproses = "";

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
    public function errorPage($value='')
    {
        $this->render_view('error');
    }

    public function index()
	{
		if(!$this->checkAuth()){
			header("Location: http://erp.wika-beton.co.id");
		}else{
			$this->load->helper(array('form','url','download'));
			$this->contentManagement();
		}

    }
    
	private function checkAuth(){
		$this->load->library('Wb_Security');
		$isessid="f75726cab15573bc7ad61d9c80c88e22";
		//$isessid="";
		if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		$this->idsession=$isessid;
		$this->wb_security->id_session = $isessid;
		$this->session->set_userdata($this->wb_security->cekSession());
		//$this->session->set_userdata('TMP_NIP','WB040034');
		//$this->session->set_userdata('TMP_KDWIL','0A');
		if($isessid!=""){
			if($this->session->userdata("TMP_NIP")!=""){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

    private function contentManagement(){
		
		$idproses = isset($_GET["idproses"])?$_GET["idproses"]:"";
		$this->idproses = $idproses;

		switch($this->idproses){
			case "getdatakinerja":
				$retData = $this->getDataKinerja();
				echo json_encode($retData);
			break;
			case "addnewdata":
				$params["title"]="KPI Level 1";
				$params["isessid"] = $this->idsession;
				$this->render_view($this->pathView.'v_m_kpi_admin_add', $params);
			break;
			default:
				$params["listbl"][] = array("BL"=>"012019");
				$params["ivalue"] = "012019";
				$params["isessid"] = $this->idsession;
				$params["grid"] = $this->initGrid();
				$this->render_view($this->pathView.'v_m_kpi_admin_list', $params);
			break;
		}

		
    }
    
	public function getDataLU(){
		//if(!$this->checkAuth()){
		//	header("Location: http://erp.wika-beton.co.id");
		//	exit;
		//}

		//declare variable
		$idLU = isset($_GET["idlu"])?$_GET["idlu"]:"";
		$filter1 = isset($_GET["filter1"])?$_GET["filter1"]:"";
		$arrData = array();
		//=====================

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if($idLU!==""){
			switch($idLU){
				case "datakinerja":
					$query="select ID_KINERJA as ID, KINERJA as textdisplay from hrms.TB_KPI_KINERJA order by 2";
				break;
				case "dataindikinkunci":
					$query="select ID_INDI_KIN_KUNCI as ID, INDI_KIN_KUNCI as textdisplay from hrms.TB_KPI_INDI_KIN_KUNCI where id_kinerja like '$filter1' order by 2";
				break;
			}
			
			$arrParamData = array();	
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			$rst=$conn->Execute($query, $arrParamData);
			
			if($rst)
			{
				
				if($rst->recordCount()>0){
					$i=0;
					while(!$rst->EOF)
					{
						$arrData[$i]["id"]=$rst->fields["ID"];
						$arrData[$i]["text"]=$rst->fields["TEXTDISPLAY"];
						
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
			
			$data=array("results"=>$arrData);
			print_r(json_encode($data,JSON_PRETTY_PRINT));
		}
    }

    private function initGrid(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID_KPI_L1";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NO";
		$paramsGrid["source"]["datafields"][$i]["name"]="NO";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NO";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="3%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.KINERJA";
		$paramsGrid["source"]["datafields"][$i]["name"]="KINERJA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="KINERJA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="15%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NO_INDI_KIN_KUNCI";
		$paramsGrid["source"]["datafields"][$i]["name"]="NO_INDI_KIN_KUNCI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NO";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="IKK";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.INDI_KIN_KUNCI";
		$paramsGrid["source"]["datafields"][$i]["name"]="INDI_KIN_KUNCI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="INDIKATOR KINERJA KUNCI";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="15%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="IKK";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="FORMULA";
		$paramsGrid["source"]["datafields"][$i]["name"]="FORMULA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="FORMULA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="35%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsrenderer"]="imagerenderer";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="SATUAN";
		$paramsGrid["source"]["datafields"][$i]["name"]="SATUAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="SAT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="BOBOT";
		$paramsGrid["source"]["datafields"][$i]["name"]="BOBOT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="BOBOT";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="CORPORAT";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="TARGET";
		$paramsGrid["source"]["datafields"][$i]["name"]="TARGET";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="TARGET";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="CORPORAT";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		
		return $paramsGrid;
	}


    public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";$ivalue="11";$filterJTrans="0";$rowdet="0";$parenttrxid="";$iexport="0";$iSQLID="";
		$arrParamData=array();
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		$filterPAT="%";
		if($this->session->userdata('TMP_KDWIL')!="0A"){
			$filterPAT = $this->session->userdata('TMP_KDWIL');
		}
		$query="select a.ID_KPI_L1 as ID, a.THN, a.ID_KINERJA_L1, b.kinerja, a.NO_INDI_KIN_KUNCI, a.ID_INDI_KIN_KUNCI, c.INDI_KIN_KUNCI, a.FORMULA, a.SATUAN, a.BOBOT, a.TARGET, a.CREATED_BY, a.CREATED_DATE, a.LAST_UPDATE_BY, a.LAST_UPDATE_DATE 
		from hrms.kpi_l1 a 
		inner join hrms.tb_kpi_kinerja b on a.id_kinerja_l1=b.id_kinerja 
		inner join hrms.tb_kpi_indi_kin_kunci c on c.id_indi_kin_kunci=a.id_indi_kin_kunci 
		$where ";
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query,$arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					
					$arrData[$i]["NO"]=$i+1;
					foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					$formula = $rst->fields["FORMULA"];
					chdir("/wwwroot/php5/erp-ci/upload/");
					$url = "https://drive.wika-beton.co.id/remote.php/webdav$formula";
					$cmdshell = "curl -O -u webapp:wikabetonkeren -X GET '$url' ";
					//var_dump($cmdshell);
					//$cmdshell = "c://curlwin/bin/curl.exe -k -T '".$_FILES['fileUpload']['tmp_name']."' -u webapp:wikabetonkeren -X PUT '$url' ";
					$returnvar = shell_exec($cmdshell);

					$rst->moveNext();
					$i++;
				}
				//$returnvar = shell_exec("pwd");
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
		   'ErrorMsg'=>$errMsg,
		    'Return'=>$returnvar
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    } 
    
	public function saveDataL1(){
		//if(!$this->checkAuth()){
		//	header("Location: http://erp.wika-beton.co.id");
		//	exit;
		//}

		//declare variable
		$idkpil1=""; $thn=""; $idkinerja=""; $noindikinkunci=""; $idindikinkunci=""; $formula=""; $satuan=""; $bobot=""; $target="";
		$return_var="";
		$thn = isset($_REQUEST["txtThn"])?$_REQUEST["txtThn"]:"";
		$idkinerja = isset($_REQUEST["id_kinerja"])?$_REQUEST["id_kinerja"]:"";
		$noindikinkunci = isset($_REQUEST["no_idindikinkunci"])?$_REQUEST["no_idindikinkunci"]:"";
		$idindikinkunci = isset($_REQUEST["id_indikinkunci"])?$_REQUEST["id_indikinkunci"]:"";
		//$formula = isset($_REQUEST["no_idindikinkunci"])?$_REQUEST["no_idindikinkunci"]:"";
		$satuan = isset($_REQUEST["txtSatuan"])?$_REQUEST["txtSatuan"]:"";
		$bobot = isset($_REQUEST["txtBobot"])?$_REQUEST["txtBobot"]:"";
		$target = isset($_REQUEST["txtTarget"])?$_REQUEST["txtTarget"]:"";
		$arrData = array();
		//=====================

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		$queryID="select nvl(max(to_number(substr(id_kpi_l1,-6))),0)+1 as NEXTNUM from hrms.kpi_l1";
		$rst=$conn->Execute($queryID);
		if($rst->recordCount()>0){
			$idkpil1=Date("Y").sprintf("%06d",$rst->fields["NEXTNUM"]);
		}else{
			$idkpil1=Date("Y").sprintf("%06d",1);
		}

		$ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
		$filename = $idkpil1.".".$ext; 
		$formula="/hr/kpi-admin/".Date("Y")."/".$filename;

		$query="insert into hrms.kpi_l1 (ID_KPI_L1, THN, ID_KINERJA_L1, NO_INDI_KIN_KUNCI, ID_INDI_KIN_KUNCI, FORMULA, SATUAN, BOBOT, TARGET, CREATED_BY, CREATED_DATE) values ('$idkpil1','$thn', '$idkinerja', '$noindikinkunci', '$idindikinkunci', '$formula', '$satuan', '$bobot', '$target','".$_SESSION["TMP_NIP"]."',SYSDATE)";	
		
		$arrParamData = array();	
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rst=$conn->Execute($query);
		if(!$rst)
		{
			$errMsg = $conn->ErrorMsg();
			$this->session->set_flashdata('error','Error Simpan Data!!!');
		}else{
			$this->session->set_flashdata('message','Berhasil Simpan Data!!!');

			$url = "https://drive.wika-beton.co.id/remote.php/webdav/hr/kpi-admin/".Date("Y")."/$filename";
			
			$cmdshell = "curl -k -T '".$_FILES['fileUpload']['tmp_name']."' -u webapp:wikabetonkeren -X PUT '$url' ";
			//$cmdshell = "c://curlwin/bin/curl.exe -k -T '".$_FILES['fileUpload']['tmp_name']."' -u webapp:wikabetonkeren -X PUT '$url' ";
			$returnvar = shell_exec($cmdshell);

			//var_dump($cmdshell);
			//var_dump($returnvar);

			
		}
		$this->idproses="addnewdata";
		$this->contentManagement();	
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
