<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_penjualan extends CI_Controller {
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
		$subpage = isset($_GET['subpage'])?$_GET['subpage']:0;
		switch($subpage){
			case 0:
				$params["grid"] = $this->initGrid();
				break;
			case 1:
				$params["grid2"] = $this->initGrid2();
				break;
			case 2:
				$params["grid3"] = $this->initGrid3();
				break;
			default:
				break;
		}
		
	    $params["subpage"] = $subpage;
		$this->render_view('kkms/penjualan/v_m_penjualan_list', $params);
    }
    
    public function initGrid(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="id";
		$paramsGrid["source"]["datafields"][$i]["name"]="id";
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
	    $paramsGrid["columns"][$i]["text"]="ACTIONS";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="10%";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    $paramsGrid["columns"][$i]["pinned"]="true";
	    $paramsGrid["columns"][$i]["cellsrenderer"]="renderACT";
	
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.no_urut";
	    $paramsGrid["source"]["datafields"][$i]["name"]="no_urut";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="No Urut";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="5%";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nip";
		$paramsGrid["source"]["datafields"][$i]["name"]="nip";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nama";
		$paramsGrid["source"]["datafields"][$i]["name"]="nama";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["name"]="unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.tgl";
	    $paramsGrid["source"]["datafields"][$i]["name"]="tgl";
	    $paramsGrid["source"]["datafields"][$i]["type"]="date";
	    $paramsGrid["columns"][$i]["text"]="Tanggal";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="8%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["cellsformat"]="d";
	    $paramsGrid["columns"][$i]["filtertype"]="date";
	    $paramsGrid["columns"][$i]["cellsformat"]= "dd-MM-yyyy";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="sekuritasemiten";
	    $paramsGrid["source"]["datafields"][$i]["name"]="sekuritasemiten";
	    $paramsGrid["source"]["datafields"][$i]["type"]="string";
	    $paramsGrid["columns"][$i]["text"]="sekuritasemiten";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="1%";
	    $paramsGrid["columns"][$i]["hidden"]="true";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.sekuritas";
	    $paramsGrid["source"]["datafields"][$i]["name"]="sekuritas";
	    $paramsGrid["source"]["datafields"][$i]["type"]="string";
	    $paramsGrid["columns"][$i]["text"]="Sekuritas";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="10%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.kode_emiten";
	    $paramsGrid["source"]["datafields"][$i]["name"]="kode_emiten";
	    $paramsGrid["source"]["datafields"][$i]["type"]="string";
	    $paramsGrid["columns"][$i]["text"]="Emiten";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="10%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="center";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_pengajuan";
	    $paramsGrid["source"]["datafields"][$i]["name"]="lbr_pengajuan";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="Lembar Pengajuan";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="10%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
	    $i++;
	    $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.hrg_pengajuan";
	    $paramsGrid["source"]["datafields"][$i]["name"]="hrg_pengajuan";
	    $paramsGrid["source"]["datafields"][$i]["type"]="number";
	    $paramsGrid["columns"][$i]["text"]="Harga Pengajuan";
	    $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
	    $paramsGrid["columns"][$i]["width"]="10%";
	    $paramsGrid["columns"][$i]["hidden"]="false";
	    $paramsGrid["columns"][$i]["cellsalign"]="right";
	    $paramsGrid["columns"][$i]["cellsformat"]="D";
	    $paramsGrid["columns"][$i]["filtertype"]="number";
	    $paramsGrid["columns"][$i]["filterable"]="false";
	    
		return $paramsGrid;
	}
	
    public function getGridData(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";
	    $jmlGroup = 0;
	    $arrSumData = array();
	    $arrMaxData = array();
	    
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
		$query="select count(distinct concat(a.sekuritas,' - ',a.kode_emiten)) as jml_group
				from m_penjualan a
				inner join m_anggota b on a.nip=b.nip
				where a.status='PENGAJUAN' ".$where."
				order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
	    $rst=$conn->Execute($query);
	    if($rst)
	    {
	    	$jmlGroup = $rst->fields["jml_group"];
	    }
	    
	    $query="select concat(a.sekuritas,' - ',a.kode_emiten) as id, COALESCE(sum(a.lbr_pengajuan),0) as jml_pengajuan, COALESCE(max(a.hrg_pengajuan),0) as hrg_pengajuan
				from m_penjualan a
				inner join m_anggota b on a.nip=b.nip
				where a.status='PENGAJUAN' ".$where."
				group by concat(a.sekuritas,' - ',a.kode_emiten)
				order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
	    $rst=$conn->Execute($query);
	    if($rst)
	    {
		    while(!$rst->EOF){
			    $arrSumData[$rst->fields["id"]] = number_format(round($rst->fields["jml_pengajuan"],0),0);
			    $arrMaxData[$rst->fields["id"]] = number_format(round($rst->fields["hrg_pengajuan"],0),0);
		    	$rst->moveNext();
		    }
	    }
	    
		$query="select a.id, a.no_urut, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, concat(a.sekuritas,' - ',a.kode_emiten) as sekuritasemiten, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, 'PENGAJUAN' as status from m_penjualan a inner join m_anggota b on a.nip=b.nip where a.status='PENGAJUAN' ".$where." order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
		$arrParamData=array();
	    $rst=$conn->PageExecute($query, $recPerPage,$currPage, $arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconnmysql->gettotalrec($conn,$query, $arrParamData);
			$total_rows += $jmlGroup;
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
		    'SumData' =>$arrSumData,
	        'MaxData' =>$arrMaxData,
		    'debug' => $query,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }
	
	public function saveData(){
		$errMsg = "";
		$dmlmode = $_POST['idmlmode'];
		$ID = isset($_POST['iID']) ? $_POST['iID'] : "";
		$nip = isset($_POST['inip']) ? $_POST['inip'] : "";
		$tgl = isset($_POST['itgl']) ? $_POST['itgl']:"";
		
		if($tgl<>""){
			$arrTgl =  explode("/",$tgl);
			$tgl = $arrTgl[2]."-".$arrTgl[1]."-".$arrTgl[0];
		}
		
		$sekuritas = isset($_POST['isekuritas'])?$_POST['isekuritas']:"";
		$kode_emiten = isset($_POST['iemiten'])?$_POST['iemiten']:"";
		$lbr_dimiliki = isset($_POST['ilbrdimiliki'])?$_POST['ilbrdimiliki']:"";
		$lbr_pengajuan = isset($_POST['ilbrpengajuan'])?$_POST['ilbrpengajuan']:"";
		$hrg_pengajuan = isset($_POST['ihrgpengajuan'])?$_POST['ihrgpengajuan']:"";
		$total_pengajuan = isset($_POST['itotalpengajuan'])?$_POST['itotalpengajuan']:"";
		$status="PENGAJUAN";
		$nourut=1;
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if($dmlmode=="INSERT"){
			$query="select max(no_urut) as lastno from m_penjualan where sekuritas = ? and kode_emiten = ? and DATE_FORMAT(tgl,'%Y-%m-%d') like ? and status='PENGAJUAN'";
			$arrParamData=array($sekuritas, $kode_emiten,$tgl);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				$nourut = $rst->fields["lastno"] + 1;
			}else{
				$nourut = 1;
				$status = "ERROR";
				$errMsg = $conn->ErrorMsg();
			}
			
			$query="Insert into m_penjualan (nip, tgl, sekuritas, kode_emiten, no_urut, lbr_dimiliki, lbr_pengajuan, hrg_pengajuan, total_pengajuan, status, created_by, created_date) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
			$arrParamData=array($nip,$tgl,$sekuritas, $kode_emiten, $nourut, $lbr_dimiliki, $lbr_pengajuan, $hrg_pengajuan, $total_pengajuan,$status,'SYSTEM');
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				$status = "OK";
			}else{
				$status = "ERROR";
				$errMsg = $conn->ErrorMsg();
			}
		}else{
			$query="Update m_penjualan set tgl = ? , sekuritas = ? , kode_emiten = ? , lbr_dimiliki = ?, lbr_pengajuan = ? , hrg_pengajuan = ?, total_pengajuan = ?, status = ?, last_update_by=?, last_update_date=NOW() Where id=?";
			$arrParamData=array($tgl,$sekuritas, $kode_emiten, $lbr_dimiliki, $lbr_pengajuan, $hrg_pengajuan, $total_pengajuan,$status,'SYSTEM',$ID);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				$status = "OK";
			}else{
				$status = "ERROR";
				$errMsg = $conn->ErrorMsg();
			}
		}
		
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function initGrid2(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="id";
		$paramsGrid["source"]["datafields"][$i]["name"]="id";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="2%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.no_urut";
		$paramsGrid["source"]["datafields"][$i]["name"]="no_urut";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="No Urut";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nip";
		$paramsGrid["source"]["datafields"][$i]["name"]="nip";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nama";
		$paramsGrid["source"]["datafields"][$i]["name"]="nama";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="25%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["name"]="unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.tgl";
		$paramsGrid["source"]["datafields"][$i]["name"]="tgl";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tanggal";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="8%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["filtertype"]="date";
		$paramsGrid["columns"][$i]["cellsformat"]= "dd-MM-yyyy";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.sekuritas";
		$paramsGrid["source"]["datafields"][$i]["name"]="sekuritas";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Sekuritas";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.kode_emiten";
		$paramsGrid["source"]["datafields"][$i]["name"]="kode_emiten";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Emiten";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="sekuritasemiten";
		$paramsGrid["source"]["datafields"][$i]["name"]="sekuritasemiten";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="sekuritasemiten";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["hidden"]="true";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["name"]="lbr_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Lembar Pengajuan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.hrg_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["name"]="hrg_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Harga Pengajuan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["filterable"]="false";
		
		return $paramsGrid;
	}
	
	public function getGridData2(){
		$errMsg = "";$recPerPage = 20;$currPage = 1;$where = "";
		$totaLbrWIKA = 0; $totaLbrWTON = 0; $totaLbrWEGE = 0; $totaLbrWR = 0; $totaLbrWIKON = 0;
		$jmlGroup = 0;
		$arrSumData = array();
		$arrMaxData = array();
		
		$ifldorderby = "name asc";
		
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		if(isset($_GET["ifldorderby"]))$ifldorderby = $_GET["ifldorderby"];
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		$query="select distinct count(distinct concat(a.sekuritas,' - ',a.kode_emiten)) as jml_group
				from m_penjualan a
				inner join m_anggota b on a.nip=b.nip
				where a.status='PROSES' ".$where."
				order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
		$rst=$conn->Execute($query);
		if($rst)
		{
			$jmlGroup = $rst->fields["jml_group"];
		}
		
		$query="select distinct concat(a.sekuritas,' - ',a.kode_emiten) as id, COALESCE(sum(a.lbr_pengajuan),0) as lbr_pengajuan, COALESCE(max(a.hrg_pengajuan),0) as hrg_pengajuan
				from m_penjualan a
				inner join m_anggota b on a.nip=b.nip
				where a.status='PROSES' ".$where."
				group by concat(a.sekuritas,' - ',a.kode_emiten)
				order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
		$rst=$conn->Execute($query);
		if($rst)
		{
			while(!$rst->EOF){
				$arrSumData[$rst->fields["id"]] = number_format(round($rst->fields["lbr_pengajuan"],0),0);
				$arrMaxData[$rst->fields["id"]] = number_format(round($rst->fields["hrg_pengajuan"],0),0);
				$rst->moveNext();
			}
		}
		
		$query="select distinct a.id, a.nip, a.no_urut, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, concat(a.sekuritas,' - ',a.kode_emiten) as sekuritasemiten, a.lbr_pengajuan,a.hrg_pengajuan, 'PROSES' as status from m_penjualan a inner join m_anggota b on a.nip=b.nip  where a.status='PROSES' ".$where." order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
		$arrParamData=array();
		$rst=$conn->PageExecute($query, $recPerPage,$currPage, $arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconnmysql->gettotalrec($conn,$query, $arrParamData);
			$total_rows += $jmlGroup;
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
			'SumData' =>$arrSumData,
			'MaxData' =>$arrMaxData,
			'debug' => $query,
			'ErrorMsg'=>$errMsg
		);
		
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function initGrid3(){
		$paramsGrid["source"]["ID"] = "ID";
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="id";
		$paramsGrid["source"]["datafields"][$i]["name"]="id";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="2%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="id_batch";
		$paramsGrid["source"]["datafields"][$i]["name"]="id_batch";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID BATCH";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="2%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nip";
		$paramsGrid["source"]["datafields"][$i]["name"]="nip";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NIP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="datapeserta";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.nama";
		$paramsGrid["source"]["datafields"][$i]["name"]="nama";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NAMA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="15%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="datapeserta";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["name"]="unit_kerja";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Unit Kerja";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["columngroup"]="datapeserta";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.tgl";
		$paramsGrid["source"]["datafields"][$i]["name"]="tgl";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tanggal";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="8%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["filtertype"]="date";
		$paramsGrid["columns"][$i]["cellsformat"]= "dd-MM-yyyy";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.sekuritas";
		$paramsGrid["source"]["datafields"][$i]["name"]="sekuritas";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Sekuritas";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.kode_emiten";
		$paramsGrid["source"]["datafields"][$i]["name"]="kode_emiten";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Emiten";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["name"]="lbr_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Lembar";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.hrg_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["name"]="hrg_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Harga";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.total_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["name"]="total_pengajuan";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Total";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="pengajuan";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.lbr_terjual";
		$paramsGrid["source"]["datafields"][$i]["name"]="lbr_terjual";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Lembar";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="terjual";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.hrg_terjual";
		$paramsGrid["source"]["datafields"][$i]["name"]="hrg_terjual";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Harga";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="terjual";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.total_terjual";
		$paramsGrid["source"]["datafields"][$i]["name"]="total_terjual";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Total";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="terjual";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.fee_sekuritas";
		$paramsGrid["source"]["datafields"][$i]["name"]="fee_sekuritas";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Fee Sekuritas";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="terjual";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.net_terjual";
		$paramsGrid["source"]["datafields"][$i]["name"]="net_terjual";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Net";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="terjual";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.fee_transaksi";
		$paramsGrid["source"]["datafields"][$i]["name"]="fee_transaksi";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Fee Penjualan";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.fee_jaminan_pph";
		$paramsGrid["source"]["datafields"][$i]["name"]="fee_jaminan_pph";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Fee Jaminan PPh";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.fee_kelola";
		$paramsGrid["source"]["datafields"][$i]["name"]="fee_kelola";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Fee Kelola";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.pot_hutang";
		$paramsGrid["source"]["datafields"][$i]["name"]="pot_hutang";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Pot. Hutang";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="7%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.net_pemohon";
		$paramsGrid["source"]["datafields"][$i]["name"]="net_pemohon";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Diterima Pemohon";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="D";
		$paramsGrid["columns"][$i]["filtertype"]="number";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="token";
		$paramsGrid["source"]["datafields"][$i]["name"]="token";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Token";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="true";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["columngroup"]="kkms";
		
		return $paramsGrid;
	}
	
	public function getGridData3(){
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
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.net_pemohon, a.id_batch from m_penjualan a inner join m_anggota b on a.nip=b.nip  where a.status LIKE 'TERJUAL%' ".$where."order by a.tgl desc";
		$arrParamData=array();
		$rst=$conn->PageExecute($query, $recPerPage,$currPage, $arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconnmysql->gettotalrec($conn,$query, $arrParamData);
			
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					$tokenidbatch=base64_encode("iidbatch=".$rst->fields["id_batch"]);
					foreach($rst->fields as $key=>$value){
						$arrData[$i][$key]=$value;
					}
					$arrData[$i]["token"]=$tokenidbatch;
					
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
			'debug' => $query,
			'ErrorMsg'=>$errMsg
		);
		
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function setProses(){
		$errMsg = "";
		$listIDS = isset($_POST['iIDS']) ? $_POST['iIDS'] : "";
		$arrID = explode("|",$listIDS);
		$lastID = 1;
		
		$status="PROSES";
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		/*$sql="select COALESCE(max(id_batch_jual),0 ) as last_id from m_req_jual where tgl_batch_jual like CURDATE() ";
		$rst=$conn->Execute($sql);
		if($rst){
			if($rst->recordCount()>0){
				if($rst->fields["last_id"]=="0"){
					$lastID = Date("Ymd").sprintf("%03d",1);
				}else{
					$lastID = $rst->fields["last_id"]+1;
					$lastID = Date("Ymd").sprintf("%03d",$lastID);
				}
				
			}else{
				$lastID = Date("Ymd").sprintf("%03d",1);
			}
		}else{
			$lastID = Date("Ymd").sprintf("%03d",1);
		}
		*/
		foreach($arrID as $key=>$value){
			$query="Update m_penjualan set status = ?, st_proses='1', tgl_proses=NOW() Where id = ?";
			$arrParamData=array($status,$value);
			$rst=$conn->Execute($query, $arrParamData);
			
		}
		$status="OK";
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function setCancelProses(){
		$errMsg = "";
		$listIDS = isset($_POST['iIDS']) ? $_POST['iIDS'] : "";
		$arrID = explode("|",$listIDS);
		$lastID = 1;
		
		$status="PROSES";
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		foreach($arrID as $key=>$value){
			$query="Update m_penjualan set status = 'PENGAJUAN' Where id = ?";
			$arrParamData=array($value);
			$rst=$conn->Execute($query, $arrParamData);
		}
		$status="OK";
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function setTerjual(){
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$errMsg = "";
		$emiten = isset($_POST['iemiten']) ? $_POST['iemiten'] : "";
		$sekuritas = isset($_POST['isekuritas']) ? $_POST['isekuritas'] : "";
		$jmllbr = isset($_POST['iJmlLbr']) ? $_POST['iJmlLbr'] : "";
		//$hrgjual = isset($_POST['iHrgJual']) ? $_POST['iHrgJual'] : "";
		$terimadana = isset($_POST['iTerimaDana']) ? $_POST['iTerimaDana'] : "";
		$listIDS = isset($_POST['iIDS']) ? $_POST['iIDS'] : "";
		$arrID = explode("|",$listIDS);
		
		$IdIn = str_replace("|","','",$listIDS);
		$IdIn = "'".$IdIn."'";
		$noberkas = "";
		
		$lbrterjual =0;$lbrpengajuan=0;$sisalbr=0;$statusjual="";
		
		$total_lbr1             = 0;
		$total_lbr2             = 0;
		$total_aju              = 0;
		$total_jual             = 0;
		$total_fee_sekuritas    = 0;
		$total_net              = 0;
		$total_fee_jual         = 0;
		$total_jaminan          = 0;
		$total_kelola           = 0;
		$total_hutang           = 0;
		$total_pemohon          = 0;
		$total_jaminan_kelola   = 0;
		$total_pdpt_lain = 0;
		
		$lbrbelumterjual = 0;
		$statusRet = "";
		$idbatch = "";
		
		/*$query="select a.id,a.no_urut, a.kode_emiten, a.lbr_pengajuan, a.hrg_pengajuan
		from m_penjualan a
		inner join m_anggota b on a.nip=b.nip
		inner join m_emiten c on c.sekuritas=a.sekuritas and c.kode_emiten=a.kode_emiten
		where a.status='PROSES' and a.kode_emiten = ? and a.sekuritas=?
		and a.id in (".$IdIn.") and a.hrg_pengajuan <= ?
		order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";*/
		
		$query="select a.id,a.no_urut, a.kode_emiten, a.lbr_pengajuan, a.hrg_pengajuan
		from m_penjualan a
		inner join m_anggota b on a.nip=b.nip
		inner join m_emiten c on c.sekuritas=a.sekuritas and c.kode_emiten=a.kode_emiten
		where a.status='PROSES' and a.kode_emiten = ? and a.sekuritas = ?
		and a.id in (".$IdIn.")
		order by a.sekuritas, a.kode_emiten, a.tgl, a.no_urut asc";
		
		$arrParamData=array($emiten, $sekuritas);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$sisalbr=$jmllbr;
				
				$sqlbatch = "select coalesce(max(id_batch),0)+1 as lastno from m_penjualan_terima";
				$rstbatch = $conn->Execute($sqlbatch);
				if($rstbatch){
					if($rstbatch->recordCount()>0){
						$idbatch = $rstbatch->fields["lastno"];
					}else{
						$idbatch = Date("Y").sprintf("%04d",1);
					}
				}else{
					$idbatch = Date("Y").sprintf("%04d",1);
				}
				//var_dump($idbatch);
				
				while(!$rst->EOF){
					$idrec = $rst->fields["id"];
					$lbrpengajuan = $rst->fields["lbr_pengajuan"];
					if($sisalbr>0) {
						if ($sisalbr < $lbrpengajuan) {
							$lbrterjual = $sisalbr;
							$lbrbelumterjual = $lbrpengajuan - $lbrterjual;
							$sisalbr = 0;
							$status = "TERJUAL SEBAGIAN";
						} else {
							$lbrterjual = $lbrpengajuan;
							$sisalbr = $sisalbr - $lbrpengajuan;
							$status = "TERJUAL";
						}
						
						$sql2 = "Update m_penjualan set lbr_terjual=?, tgl_terjual = NOW(), id_batch=?, status=? where id = ?";
						$arrParamData2 = array($lbrterjual, $idbatch, $status, $idrec);
						$rst2 = $conn->Execute($sql2, $arrParamData2);
						if ($rst2) {
							$statusRet = "OK";
							
							
							if($lbrbelumterjual>0){
								$sql4="insert into m_penjualan (nip, tgl, tgl_expired, sekuritas, kode_emiten, lbr_dimiliki, lbr_pengajuan, hrg_pengajuan, total_pengajuan, status, no_urut, st_proses, tgl_proses) select nip, tgl, tgl_expired, sekuritas, kode_emiten, lbr_dimiliki, ?, hrg_pengajuan, (? * hrg_pengajuan), 'PROSES', no_urut,'1',NOW() from m_penjualan where id = ?";
								$arrParamData4=array($lbrbelumterjual, $lbrbelumterjual, $idrec);
								$rst4=$conn->Execute($sql4, $arrParamData4);
								if (!$rst4) {
									echo $conn->ErrorMsg() . "<br>";
								}
							}
							
							
						}
					}
					$rst->moveNext();
					
				}
				
				$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where a.id_batch like ? order by a.tgl desc";
				$arrParamData=array($idbatch);
				$rst=$conn->Execute($query, $arrParamData);
				if($rst) {
					if ($rst->recordCount() > 0) {
						$i = 0;
						$nama_sekuritas = $rst->fields["sekuritas"];
						while (!$rst->EOF) {
							$total_lbr1 += $rst->fields["lbr_pengajuan"];
							$total_lbr2 += $rst->fields["lbr_terjual"];
							$total_aju += $rst->fields["total_pengajuan"];
							$total_jual += $rst->fields["total_terjual"];
							$total_fee_sekuritas += $rst->fields["fee_sekuritas"];
							$total_net += $rst->fields["net_terjual"];
							$total_fee_jual += $rst->fields["fee_transaksi"];
							$total_jaminan += $rst->fields["fee_jaminan_pph"];
							$total_kelola += $rst->fields["fee_kelola"];
							$total_hutang += $rst->fields["pot_hutang"];
							$total_pemohon += $rst->fields["net_pemohon"];
							
							$total_jaminan_kelola = $total_jaminan + $total_kelola;
							$rst->moveNext();
						}
					}
				}
				
				$total_pdpt_lain = $total_pemohon - $total_fee_jual - $total_jaminan_kelola - $total_hutang;
				
				$sqlbatch = "insert into m_penjualan_terima (id_batch, tgl_batch,  lbr_jual_batch, total_jual_batch, total_fee_sekuritas, terima_bersih, total_diterima_pemohon, total_fee_penjualan, total_jaminan_pph, total_fee_kelola, total_hutang, total_pdpt_lain, terima_dari_sekuritas) values (?, NOW(),  ?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$arrBindParamBatch = array($idbatch,  $jmllbr, $total_jual, $total_fee_sekuritas, $total_net, $total_pemohon, $total_fee_jual, $total_jaminan, $total_kelola, $total_hutang, $total_pdpt_lain, $terimadana);
				$rstbatch = $conn->Execute($sqlbatch, $arrBindParamBatch);
				if(!$rstbatch){
					$statusRet="ERROR";
					$errMsg = $conn->ErrorMsg();
				}
				
				$sqlGetNoBerkas = "select COALESCE(max(no_berkas),0)+1 as lastno from dokkas_h where year(tgl_dok)=year(now())";
				$rstGetNoBerkas = $conn->Execute($sqlGetNoBerkas);
				if($rstGetNoBerkas){
					if($rstGetNoBerkas->recordCount()>0){
						$noberkas = $rstGetNoBerkas->fields["lastno"];
						if($noberkas=="1"){
							$noberkas = Date("Y").sprintf("%06d",$noberkas);
						}
					}
				}
				
				$sqlInsKB = "insert into dokkas_h(no_berkas, tgl_dok, jdok, debet_no_perk, subject) values () ";
			}
		}
		
		$data = array(
			'Status' => $statusRet,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function setCancelTerjual(){
		$errMsg = "";
		$listIDS = isset($_POST['iIDS']) ? $_POST['iIDS'] : "";
		$arrID = explode("|",$listIDS);
		$lastID = 1;
		
		$status="PROSES";
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		foreach($arrID as $key=>$value){
			$query="Update m_req_jual set  status = 'PROSES' Where id = ?";
			$arrParamData=array($value);
			$rst=$conn->Execute($query, $arrParamData);
		}
		$status="OK";
		#var_dump($lbrsaham);
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function Up_Level(){
		$errMsg = "";
		$status = "";
		$id = $_POST['iID'];
		$emiten = "";
		$tgl = "";
		$currNoUrut = 0;
		$prevNourut = 0;
		$prevID = "";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$query="select kode_emiten, DATE_FORMAT(tgl,'%Y-%m-%d') as tgl, no_urut from m_req_jual where id like ?";
		$arrParamData=array($id);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				$emiten = $rst->fields["kode_emiten"];
				$tgl = $rst->fields["tgl"];
				$currNoUrut = $rst->fields["no_urut"];
				$prevNourut = $currNoUrut - 1;
			}
		}
		
		if($emiten!=="" && $tgl!=="" && $currNoUrut>1){
			$query="select id from m_req_jual where kode_emiten like ? and DATE_FORMAT(tgl,'%Y-%m-%d') like ? and no_urut = ?";
			$arrParamData=array($emiten,$tgl, $prevNourut);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				if($rst->recordCount()>0){
					$prevID = $rst->fields["id"];
					$query2="Update m_req_jual set no_urut=? where id like ?";
					$arrParamData2=array($prevNourut, $id);
					$rst2=$conn->Execute($query2,$arrParamData2);
					if($rst){
						$status="OK";
					}
					
					$query2="Update m_req_jual set no_urut=? where id like ?";
					$arrParamData2=array($currNoUrut, $prevID);
					$rst2=$conn->Execute($query2,$arrParamData2);
					if($rst){
						$status="OK";
					}
					
				}
			}
		}
		
		
		$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
	public function Down_Level(){
		$errMsg = "";
		$status = "";
		$id = $_POST['iID'];
		$emiten = "";
		$tgl = "";
		$currNoUrut = 0;
		$prevNourut = 0;
		$prevID = "";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$query="select kode_emiten, DATE_FORMAT(tgl,'%Y-%m-%d') as tgl, no_urut from m_req_jual where id like ?";
		$arrParamData=array($id);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				$emiten = $rst->fields["kode_emiten"];
				$tgl = $rst->fields["tgl"];
				$currNoUrut = $rst->fields["no_urut"];
				$prevNourut = $currNoUrut + 1;
			}
		}
		
		if($emiten!=="" && $tgl!=="" ){
			$query="select id from m_req_jual where kode_emiten like ? and DATE_FORMAT(tgl,'%Y-%m-%d') like ? and no_urut = ?";
			$arrParamData=array($emiten,$tgl, $prevNourut);
			$rst=$conn->Execute($query, $arrParamData);
			if($rst){
				if($rst->recordCount()>0){
					$prevID = $rst->fields["id"];
					$query2="Update m_req_jual set no_urut=? where id like ?";
					$arrParamData2=array($prevNourut, $id);
					$rst2=$conn->Execute($query2,$arrParamData2);
					if($rst){
						$status="OK";
					}
					
					$query2="Update m_req_jual set no_urut=? where id like ?";
					$arrParamData2=array($currNoUrut, $prevID);
					$rst2=$conn->Execute($query2,$arrParamData2);
					if($rst){
						$status="OK";
					}
					
				}
			}
		}
		
		
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
		$query="delete from m_penjualan where id like ?";
		$arrParamData=array($id);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			$status = "OK";
		}else{
			$errMsg = $conn->ErrorMsg();
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
	
	public function addNewData(){
		$params["title"] = "Tambah Data Penjualan Saham (Pengajuan)";
		$params["dmlmode"] = "INSERT";
		//$params["TglDok"] = Date("d/m/Y");
		$DATA["tgl"] = Date("d/m/Y");
		$params["DATA"]=$DATA;
		$this->render_view('kkms/penjualan/v_m_penjualan_inputform', $params);
	}
	
	public function editData(){
		
		$params["title"] = "Edit Data Penjualan Saham (Pengajuan)";
		$params["dmlmode"] = "UPDATE";
		$params["TglDok"] = Date("d/m/Y");
		$idrec = isset($_POST['idrec']) ? $_POST['idrec'] : "";
		
		if($idrec!=""){
			$params["ID"] = $idrec;
			$this->load->library('AdodbConnMySQL');
			$conn = $this->adodbconnmysql->getMySQLConn("HR");
			$this->load->helper('erp_wb_helper');
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			$sql="select a.id, a.nip, concat(a.nip,'|',a.kode_emiten,'|',round(a.lbr_dimiliki,0) ) as nama, concat(b.nama,' - ', b.unit_kerja,' - [ ',a.kode_emiten,' : ', CONVERT(FORMAT(round(a.lbr_dimiliki,0),0) using utf8),' lembar ]') as nama2,DATE_FORMAT(a.tgl,'%d/%m/%Y') as tgl, a.tgl_expired, a.sekuritas, a.kode_emiten, a.lbr_dimiliki, a.lbr_pengajuan, a.hrg_pengajuan, a.total_pengajuan from m_penjualan a inner join m_anggota b on a.nip=b.nip where a.id like ? ";
			$arrParamData=array($idrec);
			$rst=$conn->Execute($sql, $arrParamData);
			if($rst){
				
				if($rst->recordCount()>0){
					foreach($rst->fields as $key=>$value){
						$params["DATA"][$key]=$value;
					}
					$this->render_view('kkms/penjualan/v_m_penjualan_inputform', $params);
				}
			}else{
				$status = "ERROR";
				$errMsg = $conn->ErrorMsg();
				echo $errMsg;
			}
			
		}
		
	}
	
	public function genLapRekapharian(){
		$emiten = isset($_GET["iemiten"])?$_GET["iemiten"]:"WTON";
		$idbatch = isset($_GET["iidbatch"])?$_GET["iidbatch"]:"202006001";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$kodeemiten = "";
		$i=0;
		$styleContent1="";
		
		$query="select kode_emiten from m_penjualan where id_batch like ?";
		$arrParamData=array($idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$emiten = $rst->fields["kode_emiten"];
			}
		}
		
		
		$nama_sekuritas="";
		$tgl_batch="";$tgl_batch2="";
		$hrg_jual_batch = 0;$lbr_jual_batch=0;$nilai_jual_batch=0;
		$terima_dari_sekuritas = 0;
		
		
		
		$namaemiten = "PT WIJAYA KARYA BETON, TBK";
		$pathTCPDF = $this->config->item( 'wb_server_path' )."assets/TCPDF/";
		
		$query="select nama_emiten from m_emiten where kode_emiten = ?";
		$arrParamData=array($emiten);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$namaemiten = $rst->fields["nama_emiten"];
			}
		}
		
		$query="select DATE_FORMAT(tgl_batch,'%Y-%m-%d') as tgl_batch, DATE_FORMAT(tgl_batch,'%d/%m/%Y') as tgl_batch2 from m_penjualan_terima a where id_batch = ?";
		$arrParamData=array($idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$tgl_batch = $rst->fields["tgl_batch"];
				$tgl_batch2 = $rst->fields["tgl_batch2"];
			}
		}
		
		$query="select sum(lbr_jual_batch) as lbr_jual_batch, sum(total_jual_batch) as total_jual_batch, max(terima_dari_sekuritas) as terima_dari_sekuritas from m_penjualan_terima where tgl_batch like ? and id like ?";
		$arrParamData=array($tgl_batch, $idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				//$nilai_jual_batch = $rst->fields["nilai_jual_batch"];
				$lbr_jual_batch = $rst->fields["lbr_jual_batch"];
				$hrg_jual_batch = $rst->fields["total_jual_batch"];
				$terima_dari_sekuritas = $rst->fields["terima_dari_sekuritas"];
			}
		}
		
		require_once($pathTCPDF.'examples/tcpdf_include.php');
		// create new PDF document
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator('ROZI');
		$pdf->SetAuthor('KKMS');
		$pdf->SetTitle('Laporan Rekap Harian');
		$pdf->SetSubject('Rekap Harian');
		$pdf->SetKeywords('Rekap, PDF, harian, kkms');
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
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
		$pdf->SetFont('calibri', 'B', 12);
		//$fontname = TCPDF_FONTS::addTTFfont('/wwwroot/php5rozi/kkms/assets/TCPDF/fonts/Calibri.ttf', 'TrueTypeUnicode', '', 96);
		//$pdf->SetFont($fontname, '', 12);
		
		$pdf->SetMargins(10, 20, 10, true);
		
		// add a page
		$pdf->AddPage();
		$pdf->Image('/wwwroot/php5rozi/kkms/assets/images/Logo-KKMS.jpg', 10, 17, 20, 15, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);
		$pdf->Write(0, 'REKAPITULASI INSTRUKSI PENJUALAN/PEMINDAHAN', '', 0, 'C', true, 0, false, false, 0);
		$pdf->Write(0, "PROGRAM SAHAM $emiten - $namaemiten", '', 0, 'C', true, 0, false, false, 0);
		$pdf->SetFont('calibri', '', 8);
		
		
		// -----------------------------------------------------------------------------
				/*$attrHdr1="background-color:#cfcfc4;border:1px solid #adadad;";
				$attrHdr2="background-color:#e5e5e5;border:1px solid #adadad;";
				$attrHdr3="background-color:#cfcfc4;border:1px solid #adadad;";*/
		$attrHdr1="background-color:#cfcfc4;border:1px solid #000000;";
		$attrHdr2="background-color:#e5e5e5;border:1px solid #000000;";
		$attrHdr3="background-color:#cfcfc4;border:1px solid #000000;";
		
		$tbl = "<br/><br/>
		<table cellspacing=\"0\" cellpadding=\"2\">
			<thead>
				<tr style=\"text-align:center;font-weight:bold;\">
					<th colspan=\"4\" style=\"width:35%;$attrHdr1\">DATA PESERTA</th>
					<th colspan=\"3\" style=\"width:20%;$attrHdr1\">PENGAJUAN</th>
					<th colspan=\"2\" style=\"width:14%;$attrHdr1\">TERJUAL</th>
					<th colspan=\"5\" style=\"width:31%;$attrHdr1\">KKMS</th>
				</tr>
				<tr style=\"text-align:center;font-weight:bold;vertical-align: middle;\">
					<th style=\"width:3%;$attrHdr2\">NO</th>
					<th style=\"width:6%;$attrHdr2\">NIP</th>
					<th style=\"width:16%;$attrHdr2\">NAMA</th>
					<th style=\"width:10%;$attrHdr2\">UNIT KERJA</th>
					<th style=\"width:6%;$attrHdr2\">LEMBAR</th>
					<th style=\"width:6%;$attrHdr2\">HARGA</th>
					<th style=\"width:8%;$attrHdr2\">TOTAL</th>
					<th style=\"width:6%;$attrHdr2\">LEMBAR</th>
					<th style=\"width:8%;$attrHdr2\">TOTAL</th>
					<th style=\"width:8%;$attrHdr2\">FEE PENJUALAN</th>
					
					";
				if($emiten=="WTON"){
					$tbl.="
						<th style=\"width:8%;$attrHdr2\">JAMINAN<br>PPh SP 5%</th>";
				}
				if($emiten=="WEGE"){
					$tbl.="
						<th style=\"width:8%;$attrHdr2\">FEE KELOLA</th>";
				}
				
					$tbl.= "
					<th style=\"width:7%;$attrHdr2\">POT HUTANG</th>
					<th style=\"width:8%;$attrHdr2\">DITERIMA PEMOHON</th>
				</tr>
				<tr style=\"text-align:center;font-size:8px;\">
					<th style=\"width:3%;$attrHdr3\">1</th>
					<th style=\"width:6%;$attrHdr3\">2</th>
					<th style=\"width:16%;$attrHdr3\">3</th>
					<th style=\"width:10%;$attrHdr3\">4</th>
					<th style=\"width:6%;$attrHdr3\">5</th>
					<th style=\"width:6%;$attrHdr3\">6</th>
					<th style=\"width:8%;$attrHdr3\">7</th>
					<th style=\"width:6%;$attrHdr3\">8</th>
					<th style=\"width:8%;$attrHdr3\">9</th>
					<th style=\"width:8%;$attrHdr3\">10</th>
					<th style=\"width:8%;$attrHdr3\">11</th>
					<th style=\"width:7%;$attrHdr3\">12</th>
					<th style=\"width:8%;$attrHdr3\">13</th>
				</tr>
			</thead>
			<tbody>";
		
		
		$total_lbr1=0;$total_lbr2=0;
		$total_aju=0;$total_jual=0;
		$total_fee_sekuritas=0;
		$total_net = 0;
		$total_fee_jual = 0;
		$total_jaminan = 0;
		$total_kelola = 0;
		$total_hutang = 0;
		$total_pemohon = 0;
		$total_jaminan_kelola = 0;
		$unit_kerja = "";
		
		$attrRow1="background-color:#ffffff;border:1px solid #000000;";
		$attrRow2="background-color:#f6fdfa;border:1px solid #000000;";
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where DATE_FORMAT(a.tgl_terjual,'%Y-%m-%d') like ? and a.id_batch like ? order by a.tgl desc";
		
		$arrParamData=array($tgl_batch, $idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst)
		{
			if($rst->recordCount()>0){
				$i=0;
				$nama_sekuritas = $rst->fields["sekuritas"];
				while(!$rst->EOF)
				{
					$total_lbr1+=$rst->fields["lbr_pengajuan"];
					$total_lbr2+=$rst->fields["lbr_terjual"];
					$total_aju+=$rst->fields["total_pengajuan"];
					$total_jual+=$rst->fields["total_terjual"];
					$total_fee_sekuritas+=$rst->fields["fee_sekuritas"];
					$total_net += $rst->fields["net_terjual"];
					$total_fee_jual += $rst->fields["fee_transaksi"];
					$total_jaminan += $rst->fields["fee_jaminan_pph"];
					$total_kelola +=$rst->fields["fee_kelola"];
					$total_hutang += $rst->fields["pot_hutang"];
					$total_pemohon += $rst->fields["net_pemohon"];
					
					$unit_kerja = $rst->fields["unit_kerja"];
					$total_jaminan_kelola = $total_jaminan + $total_kelola;
					
					$tbl.= "
					<tr style=\"\">
						<td style=\"width:3%;text-align:center;$attrRow1\">".($i+1)."</td>
						<td style=\"width:6%;text-align:center;$attrRow1\">".$rst->fields["nip"]."</td>
						<td style=\"width:16%;$attrRow1\">".$rst->fields["nama"]."</td>
						<td style=\"width:10%;text-align:center;$attrRow1\">".$rst->fields["unit_kerja"]."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["lbr_pengajuan"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["hrg_pengajuan"],0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["total_pengajuan"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["lbr_terjual"],0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["total_terjual"],0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["fee_transaksi"],0)."</td>";
					switch($emiten){
						case "WTON":
							$tbl.="<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["fee_jaminan_pph"],0)."</td>";
							break;
						case "WEGE":
							$tbl.="<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["fee_kelola"],0)."</td>";
							break;
					}
					$tbl.="
						<td style=\"width:7%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["pot_hutang"],0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["net_pemohon"],0)."</td>
					</tr>";
					
					$rst->moveNext();
					$i++;
				}
				
				$strHeight="height:".(30*(10-$i))."px;";
				$tbl .= "
					<tr style='$strHeight'>
						<td style=\"$strHeight width:3%;text-align:center;$attrRow1\">&nbsp;</td>
						<td style=\"$strHeight width:6%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:16%;$attrRow1\"></td>
						<td style=\"$strHeight width:10%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>";
				switch($emiten){
					case "WTON":
						$tbl.="<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>";
						break;
					case "WEGE":
						$tbl.="<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>";
						break;
				}
				$tbl.="
						<td style=\"$strHeight width:7%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>
					</tr>";
				
				
				$attrFoot1="background-color:#cfcfc4;border:1px solid #000000;";
				$tbl .= "
					<tr style='height:45px;'>
						<td  style=\"width:35%;text-align:center;vertical-align:top;$attrFoot1\" colspan='4'><b>T O T A L</b></td>
						<td  style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_lbr1,0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrFoot1\">&nbsp;</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_aju,0)."</td>
						<td  style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_lbr2,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_jual,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_fee_jual,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_jaminan,0)."</td>
						<td style=\"width:7%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_hutang,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_pemohon,0)."</td>
					</tr>
						";
				
			}
		}
		
		//$terima_dari_sekuritas = $hrg_jual_batch - $total_fee_sekuritas;
		$pendapatan_lain_lain = $terima_dari_sekuritas - $total_pemohon - $total_fee_jual - $total_jaminan_kelola - $total_hutang;
		$tbl.="</tbody></table>";
		$tbl.="<br/>";
		$tbl.="<table border=\"0\" style=\"width:100%;\">
					<tr>
						<td colspan=\"3\" style=\"height:40px;width:100%;\">&nbsp;</td>
					</tr>
					<tr>
						<td style=\"width:40%;text-align:left;\">&nbsp;</td>
						<td style=\"width:20%;\">&nbsp;</td>
						<td style=\"width:40%;text-align:right\"></td>
					</tr>
					<tr>
						<td style=\"width:30%;\">
							<table border=\"1\" style=\"width:100%;\">
								<tr>
									<td style=\"width:33%;text-align:center;\">Ketua</td>
									<td style=\"width:33%;text-align:center;\">Sekertaris</td>
									<td style=\"width:33%;text-align:center;\">Bendahara</td>
								</tr>
								<tr>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
								</tr>
								<tr>
									<td style=\"width:33%;text-align:center;\">Drs. Suparyadi</td>
									<td style=\"width:33%;text-align:center;\">Adi Susetyo</td>
									<td style=\"width:33%;text-align:center;\">Yushadi</td>
								</tr>
							</table>
						</td>
						<td style=\"width:10%;text-align:right;align-content: right;\"></td>
						<td style=\"width:30%;text-align:right;align-content: right;\">&nbsp;
							<table border=\"0\" style=\"width:100%;border:1px solid gray;\">
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;border-top:0.5px solid grey;\">Diterima bersih dari $nama_sekuritas</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;border-top:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;border-top:0.5px solid grey;\">".number_format($terima_dari_sekuritas,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Diterima Pemohon</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_pemohon,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Fee Penjualan</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_fee_jual,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Jaminan PPh SP</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_jaminan,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Potongan Hutang Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_hutang,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Pendapatan Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($pendapatan_lain_lain,0)."</td>
								</tr>
							</table>
						</td>
						<td style=\"width:30%;text-align:right;\">
							<table border=\"0\" style=\"width:100 %;\">
								<tr>
									<td style=\"width:33%;text-align:center;\">&nbsp;</td>
									<td style=\"width:33%;text-align:center;\">&nbsp;</td>
									<td style=\"width:33%;text-align:center;\">Jakarta, $tgl_batch2</td>
								</tr>
								<tr>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
									<td style=\"height:60px;width:33%;\">&nbsp;</td>
								</tr>
								<tr>
									<td style=\"width:33%;text-align:center;\">&nbsp;</td>
									<td style=\"width:33%;text-align:center;\">&nbsp;</td>
									<td style=\"width:33%;text-align:center;\">-------------------------</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>";
		//echo $tbl;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		
		//Area Bukti Kas Penerimaan
		$pdf->AddPage('P','A4');
		$pdf->SetFont('calibri', '', 8);
		$pdf->Image('/wwwroot/php5rozi/kkms/assets/images/Logo-KKMS.jpg', 10, 17, 20, 15, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);
		
		$tblHdrPage2 = "<table border=\"0\">
							<tr>
								<td style=\"text-align:left;width:70px;\"></td>
								<td style=\"width:150px;\">&nbsp;</td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:110px;\" colspan=\"2\">BUKTI PENERIMAAN</td>";
		
		$tblHdrPage2.="
								<td style=\"width:110px;\">[&nbsp;&nbsp;&nbsp;] KAS</td>";
		$tblHdrPage2.="
								<td style=\"width:110px;\">[&nbsp;&nbsp;&nbsp;] BANK</td>";
		
		$tblHdrPage2.="
								<td rowspan=\"5\" style=\"width:70px;\"><table border=\"1\"><tr><td style=\"text-align: center;vertical-align: bottom;\">VERIFIKATOR</td></tr><tr><td style=\"height:50px;\"></td></tr></table></td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;\">&nbsp;</td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:40px;text-align:left;\">___ ___</td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:180px;\">___ ___ ___ ___ / ___ ___ / ___ / ___ ___</td>
								<td style=\"width:90px;\"></td>
							</tr>";
		$tblHdrPage2.="
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Debet No. Perkiraan</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:110px;text-align:left;\">___ ___ ___ ___ ___</td>
								<td style=\"width:110px;\">&nbsp;</td>
								<td style=\"width:110px;\">&nbsp;</td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;height:10px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Diterima dari</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:330px;text-align:left;\" colspan=\"3\">$nama_sekuritas</td>
								<td style=\"width:100px;\"></td>
								
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Diterima</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>Tunai</td></tr></table></td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>Cek/Giro</td></tr></table></td>
								<td style=\"width:110px;\">NOMOR : </td>
								<td style=\"width:100px;\"></td>
							</tr>
						</table>";
		
		$pdf->WriteHTML($tblHdrPage2, true,false, false, false, 'C');
		$styleHdr1=" border:1px solid black;text-align:center;font-weight:bold;background-color:#808080;color:#ffffff; ";
		$strTblContentPage2="<table cellpadding=\"3\">
									<thead>
										<tr>
											<th style=\"width:5%;$styleHdr1\">No.</th>
											<th style=\"width:30%;$styleHdr1\">URAIAN</th>
											<th style=\"width:10%;$styleHdr1\">SPK</th>
											<th style=\"width:10%;$styleHdr1\">KODE Nasabah</th>
											<th style=\"width:10%;$styleHdr1\">KODE SDY</th>
											<th style=\"width:10%;$styleHdr1\">VOL</th>
											<th style=\"width:10%;$styleHdr1\">KREDIT No. PERK</th>
											<th style=\"width:15%;$styleHdr1\">RUPIAH</th>
										</tr>
									</thead>
									<tbody>
									
		";
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where DATE_FORMAT(a.tgl_terjual,'%Y-%m-%d') like ? and a.id_batch like ? order by a.tgl desc";
		$arrParamData=array($tgl_batch, $idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$i = 0;
				$styleContent1=" border:1px solid black;";
				while (!$rst->EOF) {
					$nama = $rst->fields["nama"];
					$kodeemiten = $rst->fields["kode_emiten"];
					$vol = $rst->fields["lbr_terjual"];
					$rupiah = $rst->fields["net_pemohon"];
					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">$kodeemiten - $nama</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\">".number_format($vol,0)."</th>
											<th style=\"width:10%;text-align:center;$styleContent1\">2 1 1 2 6</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($rupiah,0)."</th>
										</tr>";
					$rst->moveNext();
					$i++;
				}
				//fee penjualan
				$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">FEE PENJUALAN</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"width:10%;text-align:center;$styleContent1\">5 1 3 2 5</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($total_fee_jual,0)."</th>
										</tr>";
				$i++;
				if($kodeemiten=='WEGE'){
					//adm kelola saham wege penjualan
					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">ADM KELOLA SAHAM</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"width:10%;text-align:center;$styleContent1\">5 1 3 2 5</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($total_kelola,0)."</th>
										</tr>";
				}
				if($kodeemiten=='WTON'){
					//jaminan kelola saham wege penjualan
					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">JAMINAN PPH</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"width:10%;text-align:center;$styleContent1\">2 1 1 5 9</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($total_jaminan,0)."</th>
										</tr>";
				}
				
				//selisih adm penjualan
				$selisihpenjualan = $terima_dari_sekuritas - $total_pemohon - $total_fee_jual - $total_jaminan;
				if($selisihpenjualan>0){
					$i++;
					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">SELISIH PENJUALAN</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"width:10%;text-align:center;$styleContent1\">5 1 4 1 5</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($selisihpenjualan,0)."</th>
										</tr>";
				}
				
			}
			//blank area for adjust height
			$strHeight="height:".(30*(15-$i))."px;";
			$strTblContentPage2.="<tr>
											<th style=\"$strHeight width:5%; text-align:center;$styleContent1\"></th>
											<th style=\"$strHeight width:30%;text-align:left;$styleContent1\"></th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"$strHeight width:10%;text-align:center;$styleContent1\"></th>
											<th style=\"$strHeight width:15%;text-align:right;$styleContent1\"></th>
										</tr>";
			//area total
			$total_bkas = $total_pemohon + $total_fee_jual + $total_jaminan + $total_kelola;
			$total_terbilang = strtoupper($this->Terbilang($total_bkas));
			$strTblContentPage2.="<tr>
											<th style=\"width:85%; text-align:left;$styleContent1\" colspan=\"7\">Terbilang : #$total_terbilang RUPIAH#</th>
											<th style=\"width:15%;text-align:right;$styleContent1\"><b>".number_format($total_bkas, 0)."</b></th>
										</tr>";
		}
		
		$strTblContentPage2.="<p style=\"text-align:right; width:100%;\">Jakarta, $tgl_batch2</p>
								<table border=\"1\" style=\"width:100%;\">
								<tr>
									<td style=\"width:20%;text-align:center;\">Ketua</td>
									<td style=\"width:20%;text-align:center;\">Sekertaris</td>
									<td style=\"width:20%;text-align:center;\">Bendahara</td>
									<td style=\"width:20%;text-align:center;\">Administrasi</td>
									<td style=\"width:20%;text-align:center;\">Penerima</td>
								</tr>
								<tr>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
								</tr>
								<tr>
									<td style=\"width:20%;text-align:center;\">Drs. Suparyadi</td>
									<td style=\"width:20%;text-align:center;\">Adi Susetyo</td>
									<td style=\"width:20%;text-align:center;\">Yushadi</td>
									<td style=\"width:20%;text-align:center;\">&nbsp;</td>
									<td style=\"width:20%;text-align:center;\">&nbsp;</td>
								</tr>
							</table>
		";
		$strTblContentPage2.="
									</tbody>
								</table>";
		$pdf->WriteHTML($strTblContentPage2, true,false, false, false, 'C');
		
		//Area Bukti Kas Pengeluaran
		$pdf->AddPage('P','A4');
		$pdf->Image('/wwwroot/php5rozi/kkms/assets/images/Logo-KKMS.jpg', 10, 17, 20, 15, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);
		
		$tblHdrPage2 = "<table border=\"0\">
							<tr>
								<td style=\"text-align:left;width:70px;\"></td>
								<td style=\"width:150px;\">&nbsp;</td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:110px;\" colspan=\"2\">BUKTI PENGELUARAN</td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>KAS</td></tr></table></td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>BANK</td></tr></table></td>
								<td rowspan=\"5\" style=\"width:70px;\"><table border=\"1\"><tr><td style=\"text-align: center;vertical-align: bottom;\">VERIFIKATOR</td></tr><tr><td style=\"height:50px;\"></td></tr></table></td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;\">&nbsp;</td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:40px;\"><table border=\"1\"><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></td>
								<td style=\"width:20px;\">&nbsp;</td>
								<td style=\"width:160px;\"><table border=\"1\"><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>/</td><td>&nbsp;</td><td>&nbsp;</td><td>/</td><td>&nbsp;</td><td>/</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td>
								<td style=\"width:110px;\"></td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;KREDIT No. Perkiraan</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:110px;\"><table border=\"1\"><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table></td>
								<td style=\"width:110px;\">&nbsp;</td>
								<td style=\"width:110px;\">&nbsp;</td>
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;height:10px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Dibayar Kepada</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:330px;text-align:left;\" colspan=\"3\">$unit_kerja</td>
								<td style=\"width:100px;\"></td>
								
							</tr>
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Diterima</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>Tunai</td></tr></table></td>
								<td style=\"width:110px;\"><table><tr><td style=\"border:1px solid black;width:10px;\"></td><td>Cek/Giro</td></tr></table></td>
								<td style=\"width:110px;\">NOMOR : </td>
								<td style=\"width:100px;\"></td>
							</tr>
						</table>";
		
		$pdf->WriteHTML($tblHdrPage2, true,false, false, false, 'C');
		$styleHdr1=" border:1px solid black;text-align:center;font-weight:bold; ";
		$strTblContentPage2="<table cellpadding=\"3\">
									<thead>
										<tr>
											<th style=\"width:5%;$styleHdr1\">No.</th>
											<th style=\"width:30%;$styleHdr1\">URAIAN</th>
											<th style=\"width:10%;$styleHdr1\">SPK</th>
											<th style=\"width:10%;$styleHdr1\">KODE Nasabah</th>
											<th style=\"width:10%;$styleHdr1\">KODE SDY</th>
											<th style=\"width:10%;$styleHdr1\">VOL</th>
											<th style=\"width:10%;$styleHdr1\">DEBET No. PERK</th>
											<th style=\"width:15%;$styleHdr1\">RUPIAH</th>
										</tr>
									</thead>
									<tbody>
									
		";
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where DATE_FORMAT(a.tgl_terjual,'%Y-%m-%d') like ? order by a.tgl desc";
		$arrParamData=array($tgl_batch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$i = 0;
				$styleContent1=" border:1px solid black;";
				while (!$rst->EOF) {
					$nama = $rst->fields["nama"];
					$kodeemiten = $rst->fields["kode_emiten"];
					$vol = $rst->fields["lbr_terjual"];
					$rupiah = $rst->fields["net_pemohon"];
					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">$kodeemiten - $nama</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\">".number_format($vol,0)."</th>
											<th style=\"width:10%;text-align:center;$styleContent1\">2 1 1 2 6</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format($rupiah,0)."</th>
										</tr>";
					$rst->moveNext();
					$i++;
				}
				
				
			}
			//blank area for adjust height
			$strHeight="height:".(30*(10-$i))."px;";
			$strTblContentPage2.="<tr>
											<th style=\"$strHeight width:5%; text-align:center;$styleContent1\"></th>
											<th style=\"$strHeight width:30%;text-align:left;$styleContent1\"></th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"$strHeight width:10%;text-align:right;$styleContent1\"></th>
											<th style=\"$strHeight width:10%;text-align:center;$styleContent1\"></th>
											<th style=\"$strHeight width:15%;text-align:right;$styleContent1\"></th>
										</tr>";
			//area total
			$total_bkas = $total_pemohon ;
			$total_terbilang = strtoupper($this->Terbilang($total_bkas));
			$strTblContentPage2.="<tr>
											<th style=\"width:85%; text-align:left;$styleContent1\" colspan=\"7\">Terbilang : #$total_terbilang Rupiah#</th>
											<th style=\"width:15%;text-align:right;$styleContent1\"><b>".number_format($total_bkas, 0)."</b></th>
										</tr>";
		}
		
		$strTblContentPage2.="<p style=\"text-align:right; width:100%;\">Jakarta, $tgl_batch2</p>
								<table border=\"1\" style=\"width:100%;\">
								<tr>
									<td style=\"width:20%;text-align:center;\">Ketua</td>
									<td style=\"width:20%;text-align:center;\">Sekertaris</td>
									<td style=\"width:20%;text-align:center;\">Bendahara</td>
									<td style=\"width:20%;text-align:center;\">Administrasi</td>
									<td style=\"width:20%;text-align:center;\">Penerima</td>
								</tr>
								<tr>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
									<td style=\"height:40px;width:20%;\">&nbsp;</td>
								</tr>
								<tr>
									<td style=\"width:20%;text-align:center;\">Drs. Suparyadi</td>
									<td style=\"width:20%;text-align:center;\">Adi Susetyo</td>
									<td style=\"width:20%;text-align:center;\">Yushadi</td>
									<td style=\"width:20%;text-align:center;\">&nbsp;</td>
									<td style=\"width:20%;text-align:center;\">&nbsp;</td>
								</tr>
							</table>
		";
		$strTblContentPage2.="
									</tbody>
								</table>";
		$pdf->WriteHTML($strTblContentPage2, true,false, false, false, 'C');
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
	
	
	public function Terbilang($Nominal="0"){
		$strTbl="";
		if(is_numeric($Nominal)){
			$arrNum=array(
				"0" => "Nol",
				"1" => "Satu",
				"2" => "Dua",
				"3" => "Tiga",
				"4" => "Empat",
				"5" => "Lima",
				"6" => "Enam",
				"7" => "Tujuh",
				"8" => "Delapan",
				"9" => "Sembilan");
			$arrRibuan=array(
				"0" => "",
				"1" => "Ribu",
				"2" => "Juta",
				"3" => "Milyar",
				"4" => "Triliun",
				"5" => "Ribu Triliun",
				"6" => "Juta Triliun",
				"7" => "Milyar Triliun");
			$strNum=trim(strval($Nominal));
			for($i=0;$i<strlen($strNum);$i++){
				if($strNum{$i}!="0") break;
			}
			$strNum=substr($strNum,$i);
			$strTbl="";
			for($pos=0;$pos<strlen($strNum);$pos++){
				$suku=(strlen($strNum)-$pos)%3;
				$posRev=strlen($strNum)-$pos;
				if($suku==0 && $posRev>0) $suku=3;
				for($digit=0;$digit<$suku;$digit++,$pos++){
					if($strTbl!="") $strTbl.=" ";
					$SDg=$strNum{$pos};
					if($SDg==0){
						if($pos==(strlen($strNum)-1) && $strTbl==""){
							$strTbl="Nol";
						}
					}elseif($SDg==1){
						if($pos==(strlen($strNum)-1) && $strTbl==""){
							$strTbl.=$arrNum["$SDg"];
						}elseif(($suku-$digit)==3){
							$strTbl.="Seratus";
						}elseif(($suku-$digit)==2){
							if($strNum{$pos+1}=="0"){
								$strTbl.="Sepuluh";
							}elseif($strNum{$pos+1}=="1"){
								$strTbl.="Sebelas";
							}else{
								$strTbl.=$arrNum[$strNum{$pos+1}]." Belas";
							}
							$digit++;$pos++;
						}else{
							if((strlen($strNum)-$pos)==4){
								if($suku==1){
									$strTbl.="Se";
								}elseif($suku==3){
									if(($strNum{$pos-1}=="0") && ($strNum{$pos-2}=="0")){
										$strTbl.="Se";
									}else{
										$strTbl.=$arrNum["$SDg"];
									}
								}else{
									$strTbl.=$arrNum["$SDg"];
								}
							}else{
								$strTbl.=$arrNum["$SDg"];
							}
						}
					}else{
						$strTbl.=$arrNum["$SDg"];
						if(($suku-$digit)==3){
							$strTbl.=" Ratus";
						}elseif(($suku-$digit)==2){
							$strTbl.=" Puluh";
						}
					}
				}
				$Rb=intval($posRev/3)-1;
				if($Rb>0 && ($posRev%3)==0){
					$N=(strlen($strNum)-$posRev);
					if(($strNum{$N}=="0") && ($strNum{$N+1}=="0") && ($strNum{$N+2}=="0")){
						$strTbl.="";
					}elseif(($strNum{$N}=="0") && ($strNum{$N+1}=="0") && ($strNum{$N+2}=="1")){
						if($Rb=="1"){
							$strTbl.="ribu";
						}else{
							$strTbl.=" ".$arrRibuan["$Rb"];
						}
					}else{
						$strTbl.=" ".$arrRibuan["$Rb"];
					}
				}elseif($Rb>0){
					$Rb++;
					$strTbl.=" ".$arrRibuan["$Rb"];
				}else{
					if(trim($strTbl)==""){
						$strTbl="Nol";
					}else{
						if($posRev>3){
							if(($posRev%3)==1){
								$N=(strlen($strNum)-$posRev);
								if($strNum{strlen($strNum)-$posRev}=="1"){
									$strTbl.="ribu";
								}else{
									$Rb++;
									$strTbl.=" ".$arrRibuan["$Rb"];
								}
							}elseif(($posRev%3)==2){
								$Rb++;
								$strTbl.=" ".$arrRibuan["$Rb"];
							}
						}
					}
				}
				$pos-=1;
			}
		}
		
		if(trim($strTbl)=="") $strTbl="Nol";
		return($strTbl);
	}
}
