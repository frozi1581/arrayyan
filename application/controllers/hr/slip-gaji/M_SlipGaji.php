<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_SlipGaji extends CI_Controller {
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
		//$this->load->library('Wb_Security');
		$isessid="";
		//if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		//$this->wb_security->id_session = $isessid;
		//$this->session->set_userdata($this->wb_security->cekSession());
		
		$this->session->set_userdata('TMP_NIP','WB040034');
		$this->session->set_userdata('TMP_KDWIL','0A');
		
		
		if($this->session->userdata('TMP_NIP')!==""){
			$ivalue="2019";
			if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
			$this->ivalue = $ivalue;
			$params["ivalue"] = $ivalue;
			$params["grid"] = $this->initGrid();
			$params["grid2"] = $this->initGrid2();
			$this->render_view('hr/slip-gaji/v_m_slip_gaji_list', $params);
			
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
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.bl";
		$paramsGrid["source"]["datafields"][$i]["name"]="BL";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Periode";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.tgl_mulai";
		$paramsGrid["source"]["datafields"][$i]["name"]="TGL_MULAI";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tanggal Mulai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="40%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="dd-MM-yyyy";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.tgl_akhir";
		$paramsGrid["source"]["datafields"][$i]["name"]="TGL_AKHIR";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tanggal Akhir";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="40%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="dd-MM-yyyy";
		$paramsGrid["columns"][$i]["hidden"]="false";


		return $paramsGrid;
	}
	
	
	public function getGridData(){
		$errMsg = "";$recPerPage = 500;$currPage = 1;$where = "";$ivalue="2019";$rowdet="0";$parenttrxid="";$iexport="0";$iSQLID="";
		//if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		//if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		if(isset($_GET["rowdet"]))$rowdet = $_GET["rowdet"];
		if(isset($_GET["parenttrxid"]))$parenttrxid = $_GET["parenttrxid"];

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
	
		$filterPAT = $this->session->userdata('TMP_KDWIL');

		$query="select * from (select a.bl, a.tgl_mulai, a.tgl_akhir
					from hrms.master_bandroll a
					where a.post='1'
					order by to_date(a.bl,'MMYYYY') desc) where rownum < 13";
		$arrParamData = array("filterTahun"=>"__".$ivalue);	
		
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


	public function initGrid2(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.employee_id";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="15%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.ket";
		$paramsGrid["source"]["datafields"][$i]["name"]="BIRO_BAGIAN";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Bagian/Seksi";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="trim(a.first_title || ' ' || a.first_name || ' ' || a.last_name || ' ' || a.last_title)";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama Pegawai";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.email";
		$paramsGrid["source"]["datafields"][$i]["name"]="EMAIL";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Email";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["width"]="25%";

		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="";
		$paramsGrid["source"]["datafields"][$i]["name"]="STATUS";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Status";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["width"]="10%";
		
		
		return $paramsGrid;
	}
	
	public function getGridData2(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";$ivalue="2019";$filterJTrans="0";$rowdet="0";$recid="";$ibl="";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ibl"]))$ibl = $_GET["ibl"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid2()) ;
		
		$filterPAT = $this->session->userdata('TMP_KDWIL');
		
		$query="select (a.bl||a.employee_id) as ID, a.bl, a.employee_id, trim(a.first_title || ' ' || a.first_name || ' ' || a.last_name || ' ' || a.last_title) as nama, c.ket as biro_bagian, b.email
        from hrms.penggajian_personal_data a
        inner join hrms.personal b on a.employee_id=b.employee_id
		inner join hrms.tb_gas c on c.kd_gas=b.kd_gas 
        where a.bl like :filterBL and a.kd_pat like :filterPAT ".$where."
        group by a.bl, a.employee_id, trim(a.first_title || ' ' || a.first_name || ' ' || a.last_name || ' ' || a.last_title), c.ket, b.email
        order by a.bl desc, nama";
				
		$arrParamData = array("filterBL"=>$ibl, "filterPAT"=>$filterPAT);
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
		   'ParamData'=>$arrParamData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }  
	
	public function sendEmail()
	{
		$msg="";
		$status="";
		//$pathdir="C://xampp/htdocs/erp-ci/application/download/";
		$pathdir="/wwwroot/php5/tmpweb/";
		
		if(isset($_GET["ibl"]))$ibl = $_GET["ibl"];
		if(isset($_GET["inip"]))$inip = $_GET["inip"];
		if(isset($_GET["iemail"]))$iemail = $_GET["iemail"];
		
		if($ibl!="" && $inip!="" && $iemail!="")
		{
			$fname = $inip."-".$ibl.".pdf";
			$fnameprotected = $inip."-".$ibl."-protected.pdf";
			if($inip!="WB040034"){
				$rptName="\hrms\Slip_gaji_per_pegawai.rpt";
			}else{
				$rptName="\hrms\Slip_gaji_per_pegawai_req.rpt";
			}
			$strParamName= "&promptex-iBL=".$ibl;
			$strParamName.= "&promptex-NIP=".substr($inip,0,2);
			$strParamName.= "&promptex-iempid=".$inip;
			$strParamName.= "&promptex-nm1=".urlencode("Soegeng Prajitno");
			$strParamName.= "&promptex-jbt1=".urlencode("Manager Pengharkatan");
			$exportType="PDF";
			
			$serverLink = "http://10.3.1.95:12000/ReCrystallizeServer/ViewReport.aspx?report=".$rptName;
			$fullLink=$serverLink.$strParamName."&exportfmt=$exportType";
			
			$fdata = file_get_contents($fullLink);
		
			$fSaveAs=fopen($pathdir."$fname","w");

			fwrite($fSaveAs, $fdata);
			fclose($fSaveAs);
			
			$strCmd = "/usr/bin/pdftk ".$pathdir.$fname." multibackground /wwwroot/php5/erp-ci/assets/images/bg_slip_4PDF.pdf output ".$pathdir.$fnameprotected." user_pw $inip allow printing";
			system($strCmd);
				
			$status="01";
		}
		

		 $attach_file=$pathdir.$fnameprotected;
		
		$fileatt = $attach_file; // Path to the file
		$fileatt_type = "application/pdf"; // File Type
		$fileatt_name = "Pendapatan Bulan $ibl.pdf"; // Filename that will be used for the file as the attachment

		$email_from = "hc@wika-beton.co.id"; // Who the email is from
		$email_subject = "Pendapatan Bulan $ibl"; // The Subject of the email
		$email_message = "Dengan Hormat,<br>Terlampir kami kirimkan struk/slip Pendapatan Bulan $ibl";
		$email_message .= "<br>File Pendapatan dapat dibuka dengan : Password NIP Saudara";
		$email_message .= "<br>Harap tidak mereply e-mail ini, karena dikirimkan melalui aplikasi."; 
		$email_message .= "<br>Atas perhatian yang diberikan kami ucapkan terima kasih.";
		$email_message .= "<br><br>Hormat kami,";
		$email_message .= "<br><br>";
		$email_message .= "<br>ttd";
		$email_message .= "<br><br>Administrasi SDM";
		

		$email_to = $iemail; // Who the email is to

		$headers = "From: ".$email_from;

		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);

		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

		$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";

		$email_message .= "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		$email_message .= "\n\n";

		$data = chunk_split(base64_encode($data));

		$email_message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatt_type};\n" .
		" name=\"{$fileatt_name}\"\n" .
		//"Content-Disposition: attachment;\n" .
		//" filename=\"{$fileatt_name}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data .= "\n\n" .
		"--{$mime_boundary}--\n";
		
		if($email_to!=""){
			$ok = @mail($email_to, $email_subject, $email_message, $headers);
		}else{
			$ok = false;
		} 
		
		//$ok=true;
		
		if($ok) {
			$msg = "<font face=verdana size=2><center>Email sudah terkirim....</center></font>";
			$status = "OK";
		} else {
			$msg = "ERROR";
			$status = "ERROR";
			die("Sorry but the email could not be sent. Please go back and try again!");
		}
		
	
		$dataStatus[] = array(
		   'Status'=>$status,
		   'Msg'=>$msg
		);
		print_r(json_encode($dataStatus,JSON_PRETTY_PRINT));
	}
}
