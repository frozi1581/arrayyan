<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kepemilikan extends CI_Controller {
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
	
	
	public function __construct(){
        parent::__construct();
		
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->helper(array('form','url','download'));
		
		$userid = ($this->session->userdata('user_id')!==null)?$this->session->userdata('user_id'):"";
		if($userid==""){
			redirect('login/M_login');
		}
        
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
		
		$this->contentManagement();
		
    }
    

    public function contentManagement(){
	    $params["grid"] = $this->initGrid();
		$this->render_view('kkms/kepemilikan/v_m_kepemilikan_list', $params);
    }
    
    public function initGrid(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="2%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
	
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ACT";
	    $paramsGrid["source"]["datafields"][$i]["name"]="ACT";
	    $paramsGrid["source"]["datafields"][$i]["type"]="string";
	    $paramsGrid["columns"][$i]["text"]="...";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="3%";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    $paramsGrid["columns"][$i]["pinned"]="true";
	    $paramsGrid["columns"][$i]["cellsrenderer"]="renderACT";
	    
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nip";
		$paramsGrid["source"]["datafields"][$i]["name"]="nip";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
	 
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nama";
		$paramsGrid["source"]["datafields"][$i]["name"]="nama";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["hidden"]="false";
	 
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["name"]="unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
	    
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_wika";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_wika";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="WIKA";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["aggregates"]="['sum']";
	    $paramsGrid["columns"][$i]["aggregatesrenderer"]="renderAggWIKA";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_wton";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_wton";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="WTON";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["aggregates"]="['sum']";
	    $paramsGrid["columns"][$i]["aggregatesrenderer"]="renderAggWTON";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_wege";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_wege";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="WEGE";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["aggregates"]="['sum']";
	    $paramsGrid["columns"][$i]["aggregatesrenderer"]="renderAggWEGE";
	
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_wr";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_wr";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="WR";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["aggregates"]="['sum']";
	    $paramsGrid["columns"][$i]["aggregatesrenderer"]="renderAggWR";
	
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_wikon";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_wikon";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="WIKON";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["aggregates"]="['sum']";
	    $paramsGrid["columns"][$i]["aggregatesrenderer"]="renderAggWIKON";
	
	    
	    
		return $paramsGrid;
	}
	
    public function getGridData(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";
	    $totaLbrWIKA = 0; $totaLbrWTON = 0; $totaLbrWEGE = 0; $totaLbrWR = 0; $totaLbrWIKON = 0;
	
	    $ifldorderby = "name asc";
	    
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
	    if(isset($_GET["ifldorderby"]))$ifldorderby = $_GET["ifldorderby"];
	    
	    $this->load->library('AdodbConnMySQL');
	    $conn = $this->adodbconnmysql->getMySQLConn("HR");
	    $this->load->helper('erp_wb_helper');
	
	    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		$query="select a.nip as ID, a.nip, a.nama, a.unit_kerja,  COALESCE (b.lbr_wika,0) as lbr_wika, COALESCE (b.lbr_wton,0) as lbr_wton, COALESCE (b.lbr_wege,0) as lbr_wege, COALESCE (b.lbr_wr,0) as lbr_wr, COALESCE (b.lbr_wikon,0) as lbr_wikon
				from m_anggota a
				left join v_kepemilikan b on a.nip=b.nip
				where a.nip <> 'XXX' ".$where."
				order by $ifldorderby";
		$arrParamData=array();
		//$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
	    $rst=$conn->PageExecute($query, $recPerPage,$currPage, $arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconnmysql->gettotalrec($conn,$query, $arrParamData);
			
			$query2="select sum(b.lbr_wika) as totalLbrWIKA, sum(b.lbr_wton) as totalLbrWTON, sum(b.lbr_wege) as totalLbrWEGE, sum(b.lbr_wr) as totalLbrWR, sum(b.lbr_wikon) as totalLbrWIKON
				from m_anggota a
				inner join v_kepemilikan b on a.nip=b.nip
				where a.nip <> 'XXX' ".$where;
			$rst2 = $conn->Execute($query2);
			if($rst2){
				$totaLbrWIKA = $rst2->fields["totalLbrWIKA"];
				$totaLbrWTON = $rst2->fields["totalLbrWTON"];
				$totaLbrWEGE = $rst2->fields["totalLbrWEGE"];
				$totaLbrWR = $rst2->fields["totalLbrWR"];
				$totaLbrWIKON = $rst2->fields["totalLbrWIKON"];
			}
			
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
		    'TotalLbrWIKA' => $totaLbrWIKA,
	        'TotalLbrWTON' => $totaLbrWTON,
	        'TotalLbrWEGE' => $totaLbrWEGE,
	        'TotalLbrWR' => $totaLbrWR,
	        'TotalLbrWIKON' => $totaLbrWIKON,
		    'debug' => $query,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    } 
    
	public function saveData(){
		$errMsg = "";
		$status = "";
		$dmlmode = $_POST['idmlmode'];
		$nip = $_POST['inip'];
		$nama = $_POST['inama'];
		$uk = $_POST['iuk'];
		$emiten = $_POST['iemiten'];
		$sekuritas = $_POST['isekuritas'];
		$lbrsaham = $_POST['ilbrsaham'];
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if($dmlmode=="addnew"){
			$query="Insert into m_anggota (nip, nama, unit_kerja,created_date) values (?,?,?, NOW())";
			$arrParamData=array($nip,$nama,$uk);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				$status = "OK";
				foreach($emiten as $key=>$value){
					if($lbrsaham[$key]!==""){
						$query2="insert into m_kepemilikan(nip, tgl, kode_emiten, sekuritas, lbr_saham, created_by,created_date) values (?,NOW(),?,?,?,?,NOW())";
						$arrParamData2 = array($nip, $value, $sekuritas[$key], $lbrsaham[$key], 'SYSTEM');
						$rst2=$conn->Execute($query2, $arrParamData2);
						if(!$rst2){
							$errMsg = $conn->ErrorMsg();
							$status = "ERROR";
						}else{
							$status = "OK";
						}
					}
				}
			}
		}else{
			$query="Update m_anggota set nama = ? , unit_kerja = ? ,last_update_date=NOW() Where nip=?";
			$arrParamData=array($nama,$uk, $nip);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				$status = "OK";
				foreach($emiten as $key=>$value){
					if($lbrsaham[$key]!==""){
						
						$query2="delete from m_kepemilikan where nip like ?";
						$arrParamData2 = array($nip);
						$rst2=$conn->Execute($query2, $arrParamData2);
						if(!$rst2){
							$errMsg = $conn->ErrorMsg();
							$status = "ERROR";
						}else{
							$status = "OK";
						}
					
						$query2="insert into m_kepemilikan(nip, tgl, kode_emiten, sekuritas, lbr_saham, created_by,created_date) values (?,NOW(),?,?,?,?,NOW()) on duplicate key update lbr_saham=?, last_update_date=NOW()";
						$arrParamData2 = array($nip, $value, $sekuritas[$key], $lbrsaham[$key], 'SYSTEM',$lbrsaham[$key]);
						$rst2=$conn->Execute($query2, $arrParamData2);
						if(!$rst2){
							$errMsg = $conn->ErrorMsg();
							$status = "ERROR";
						}else{
							$status = "OK";
						}
						
						
					}
				}
			}
		}
		
		
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function deleteData(){
		$errMsg = "";
		$status = "";
		$id = $_POST['iID'];
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$query="delete from m_kepemilikan where nip like ?";
		$arrParamData=array($id);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			$status = "OK";
			$query2="delete from m_anggota where nip like ?";
			$arrParamData2=array($id);
			$rst2=$conn->Execute($query2, $arrParamData2);
			if(!$rst2){
				$status="ERROR";
			}
		}
		
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function getDataDetail(){
		$nip="";$nama="";$uk="";$lbrwika=0;$lbrwton=0;$lbrwege=0;$lbrwr=0;
		$errMsg = "";
		$status = "";
		$id = $_POST['iID'];
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$query="select a.nip as ID, a.nip, a.nama, a.unit_kerja,  COALESCE (b.lbr_wika,0) as lbr_wika, COALESCE (b.lbr_wton,0) as lbr_wton, COALESCE (b.lbr_wege,0) as lbr_wege, COALESCE (b.lbr_wr,0) as lbr_wr, COALESCE (b.lbr_wikon,0) as lbr_wikon
				from m_anggota a
				left join v_kepemilikan b on a.nip=b.nip
				where a.nip like ? ";
		$arrParamData=array($id);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				$nip=$id;
				$nama=$rst->fields["nama"];
				$uk = $rst->fields["unit_kerja"];
				$lbrsaham[0]=$rst->fields["lbr_wika"];
				$lbrsaham[1]=$rst->fields["lbr_wton"];
				$lbrsaham[2]=$rst->fields["lbr_wege"];
				$lbrsaham[3]=$rst->fields["lbr_wr"];
				$lbrsaham[4]=$rst->fields["lbr_wikon"];
				$status="OK";
			}
		}
		$data = array(
			'nip'=>$nip,
			'nama'=>$nama,
			'uk'=>$uk,
			'lbrsaham'=>$lbrsaham,
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function validatorFld(){
		$errMsg = "";
		$status = "";
		$iType = $_POST['iType'];
		$nip = $_POST['inip'];
		$messageReturn = "";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		switch($iType){
			case "nip":
				$messageReturn = "NIP NOT available!!!";
				$query="select nip, nama, unit_kerja from m_anggota where nip like ? ";
				$arrParamData=array($nip);
				$rst=$conn->Execute($query, $arrParamData);
				if($rst){
					if($rst->recordCount()>0){
						$messageReturn = "NIP Sudah digunakan oleh ".$rst->fields["nama"]." , pada unit kerja ".$rst->fields["unit_kerja"]."!!!";
						$status = "NOTOK";
					}else{
						$messageReturn = "";
						$status = "OK";
					}
				}
				
				break;
		}
		
		$data = array(
			'Status' => $status,
			'Message' => $messageReturn,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
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
	
	public function genKartuKepemilikan(){
		$inip = isset($_GET["inip"])?$_GET["inip"]:"ES951887";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$pathTCPDF = $this->config->item( 'wb_server_path' )."assets/TCPDF/";
		
		require_once($pathTCPDF.'examples/tcpdf_include.php');
		// create new PDF document
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator('ROZI');
		$pdf->SetAuthor('KKMS');
		$pdf->SetTitle('Kepemilikan UPS/ Saham');
		$pdf->SetSubject('Kepemilikan Saham');
		$pdf->SetKeywords('saham, kepemilikan');
		
		$pdf->setPrintHeader(false);
		
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('times', 'B', 12);
		
		// add a page
		$pdf->AddPage();
		//$pdf->Write(0, 'KKMS', '', 0, 'L', true, 0, false, false, 0);
		$pdf->Image('/wwwroot/php5rozi/kkms/assets/images/Logo-KKMS.jpg', 15, 17, 25, 20, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);
		$pdf->Write(0, 'KEPEMILIKAN UPS / SAHAM', '', 0, 'C', true, 0, false, false, 0);
		$pdf->Write(0, "WIKA GROUP", '', 0, 'C', true, 0, false, false, 0);
		
		$idkkms = "-";
		$nama = "XXXXX";
		$unitkerja = "PT WIJAYA KARYA BETON, TBK";
		
		$query="select nama, unit_kerja, kode_nasabah from m_anggota where nip = ?";
		$arrParamData=array($inip);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$nama = $rst->fields["nama"];
				$unitkerja = $rst->fields["unit_kerja"];
				$idkkms = $rst->fields["kode_nasabah"];
			}
		}
		
		
		$pdf->SetFont('times', '', 8);
		$strTblHdr="<table cellpadding=\"2\" >
						<tr>
							<td style=\"width:100px;text-align:left;\">ID KKMS</td>
							<td style=\"width:10px;\">:</td>
							<td style=\"width:200px;text-align:left;\">$idkkms</td>
						</tr>
						<tr>
							<td style=\"width:100px;text-align:left;\">Nama</td>
							<td style=\"width:10px;\">:</td>
							<td style=\"width:200px;text-align:left;\">$nama</td>
						</tr>
						<tr>
							<td style=\"width:100px;text-align:left;\">NIP</td>
							<td style=\"width:10px;\">:</td>
							<td style=\"width:200px;text-align:left;\">$inip</td>
						</tr>
						<tr>
							<td style=\"width:100px;text-align:left;\">Unit Kerja</td>
							<td style=\"width:10px;\">:</td>
							<td style=\"width:200px;text-align:left;\">$unitkerja</td>
						</tr>
					</table>
		";
		
		$pdf->writeHTML($strTblHdr, true, false, false, false, 'C');
		$hdrStyle=" style=\"border:1px solid black;text-align:center;font-weight:bold;\" ";
		$strTblContent="<table cellpadding=\"4\">
							<thead>
								<tr>
									<th $hdrStyle>UPS / SAHAM</th>
									<th $hdrStyle>Qty</th>
									<th $hdrStyle>Keterangan</th>
								</tr>
							</thead>
							<tbody>
						";
		$query="select a.kode_emiten, a.sekuritas, b.deskripsi_emiten, a.lbr_saham from m_kepemilikan a inner join m_emiten b on b.kode_emiten=a.kode_emiten and a.sekuritas=b.sekuritas where a.nip = ? and a.lbr_saham > 0";
		$arrParamData=array($inip);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$nourut=1;
				while(!$rst->EOF){
					$kodeemiten = $rst->fields["kode_emiten"];
					$deskripsiemiten = $rst->fields["deskripsi_emiten"];
					$qty = $rst->fields["lbr_saham"];
					$sekuritas = $rst->fields["sekuritas"];
					
					$strTblContent.="<tr>";
					$strTblContent.="<td style=\"text-align:left;height:30px;border-left:1px solid black;\">$nourut. $deskripsiemiten</td>";
					
					$strTblContentDetil="";
					$query2="select a.kode_emiten, a.sekuritas, b.deskripsi_emiten, DATE_FORMAT(a.tgl,'%d-%m-%Y') as tgljual, a.lbr_saham from m_kepemilikan a inner join m_emiten b on b.kode_emiten=a.kode_emiten and a.sekuritas=b.sekuritas where a.nip = ? and a.kode_emiten = ? and a.lbr_saham < 0";
					$arrParamData2=array($inip, $kodeemiten);
					$rst2=$conn->Execute($query2, $arrParamData2);
					if($rst2) {
						if ($rst2->recordCount() > 0) {
							$strTblContentDetil.="<table style=\"width:100%;\" border=\"0\">";
							while(!$rst2->EOF){
								$tglJual=$rst2->fields["tgljual"];
								$lbrJual=number_format($rst2->fields["lbr_saham"],0)." lbr";
								$strTblContentDetil.="<tr><td>$tglJual</td><td>:</td><td>$lbrJual</td></tr>";
								$rst2->moveNext();
							}
							$strTblContentDetil.="</table>";
						}
					}
					
					$strTblContent.="<td style=\"text-align:right;height:30px;border-left:1px solid black;border-right:1px solid black;\">".number_format($qty,0)." lbr <br/>$strTblContentDetil</td>";
					$strTblContent.="<td style=\"text-align:left;height:30px;border-right:1px solid black;\">&nbsp;$sekuritas</td>";
					$strTblContent.="</tr>";
					$rst->moveNext();
					$nourut++;
				}
				
			}
		}
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-left:1px solid black;border-bottom:1px solid black;\"></td>";
		$strTblContent.="<td style=\"text-align:right;height:30px;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;\"></td>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-right:1px solid black;border-bottom:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		//area simpanan wajib, simpanan pokok, dan sukarela
		$simpananpokok = 0;
		$simpananwajib = 0;
		$simpanansukarela = 0;
		$jualwtonditahan = 0;
		$totalsimpanan = 0;
		$hutang = 0;
		
		$query="select a.pokok, a.wajib, a.sukarela from m_simpanan a  where a.nip = ?";
		$arrParamData=array($inip);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$nourut=1;
				$simpananpokok = $rst->fields["pokok"];
				$simpananwajib = $rst->fields["wajib"];
				$simpanansukarela = $rst->fields["sukarela"];
				
				$totalsimpanan = $simpananpokok + $simpananwajib + $simpanansukarela;
			}
				
		}
		
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-left:1px solid black;\"></td>";
		$strTblContent.="<td style=\"text-align:right;height:30px;\"><i>Rupiah</i></td>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-left:1px solid black;\">Simpanan Pokok</td>";
		$strTblContent.="<td style=\"text-align:right;height:20px;\">".number_format($simpananpokok,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-left:1px solid black;\">Simpanan Wajib</td>";
		$strTblContent.="<td style=\"text-align:right;height:20px;\">".number_format($simpananwajib,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-left:1px solid black;\">Simpanan Sukarela</td>";
		$strTblContent.="<td style=\"text-align:right;height:20px;\">".number_format($simpanansukarela,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-left:1px solid black;\">Jual WTON Ditahan 5%</td>";
		$strTblContent.="<td style=\"text-align:right;height:20px;\">".number_format($jualwtonditahan,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-left:1px solid black;\">&nbsp;</td>";
		$strTblContent.="<td style=\"text-align:right;height:20px;border-top:1px solid black;\">".number_format($totalsimpanan,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:20px;border-right:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="<tr>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-left:1px solid black;border-bottom:1px solid black;\">Hutang</td>";
		$strTblContent.="<td style=\"text-align:right;height:30px;border-bottom:1px solid black;\">".number_format($hutang,0)."</td>";
		$strTblContent.="<td style=\"text-align:left;height:30px;border-right:1px solid black;border-bottom:1px solid black;\">&nbsp;</td>";
		$strTblContent.="</tr>";
		
		$strTblContent.="</tbody>";
		$strTblContent.="</table>";
		$pdf->writeHTML($strTblContent, true, false, false, false, 'C');
		
		$waktuSaatIni = Date("YmdHis");
		//$serverPath = $this->config->item( 'wb_server_path' );
		$fnoutputname = "lap-rekap-harian-penjualan-".$waktuSaatIni.".pdf";
		
		//Close and output PDF document
		$pdf->Output($fnoutputname, "I");
		
		//$pdf->Output('kuitti'.$ordernumber.'.pdf', 'F');
		//============================================================+
		// END OF FILE
		//============================================================+
	}
}
