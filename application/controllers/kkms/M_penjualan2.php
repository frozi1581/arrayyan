<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_penjualan2 extends CI_Controller {
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
	    $this->load->view('shared/header2',$params);
	    $this->load->view('shared/sidebar2',$params);
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
	    $params["subpage"] = $subpage;
		switch($subpage){
			case 0:
				//$params["grid"] = $this->initGrid();
				$this->render_view('kkms/penjualan2/v_m_penjualan_list0', $params);
				break;
			case 1:
				$params["grid2"] = $this->initGrid2();
				$this->render_view('kkms/penjualan2/v_m_penjualan_list1', $params);
				break;
			case 2:
				$params["grid3"] = $this->initGrid3();
				$this->render_view('kkms/penjualan2/v_m_penjualan_list2', $params);
				break;
			default:
				$this->render_view('kkms/penjualan2/v_m_penjualan_list', $params);
				break;
		}
		
	   
		
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
	    $totaLbrWIKA = 0; $totaLbrWTON = 0; $totaLbrWEGE = 0; $totaLbrWR = 0; $totaLbrWIKON = 0;
	    
	    $jmlGroup = 0;
	    $arrSumData = array();
	    $arrMaxData = array();
	    
	    $this->load->library('AdodbConnMySQL');
	    $conn = $this->adodbconnmysql->getMySQLConn("HR");
	    $this->load->helper('erp_wb_helper');
	
	    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
	
	
	    $query="select a.id_batch, a.id, a.no_urut, if(a.status='TERJUAL', concat('Tanggal Terjual : ',DATE_FORMAT(a.tgl_terjual,'%d-%m-%Y'),', Emiten : ', a.kode_emiten, ', Sekuritas : ', a.sekuritas, ', Terima Dana : Rp. ', convert(FORMAT(c.terima_dari_sekuritas,0) using utf8)  ),
 concat('Pengajuan ', a.kode_emiten, ', Sekuritas : ', a.sekuritas  )
		 )as groupid, a.nip, b.nama, b.unit_kerja, DATE_FORMAT(a.tgl,'%d/%m/%Y') as tgl_pengajuan, a.sekuritas, a.kode_emiten, a.lbr_pengajuan, a.hrg_pengajuan, a.lbr_terjual, a.total_terjual, a.status, DATE_FORMAT(a.tgl_proses,'%d/%m/%Y') as tgl_proses, DATE_FORMAT(a.tgl_terjual,'%d/%m/%Y') as tgl_terjual, c.terima_dari_sekuritas from m_penjualan a inner join m_anggota b on a.nip=b.nip left join m_penjualan_terima c on c.id_batch=a.id_batch where a.status<>'EXPIRED'
		order by case a.status
		when 'PENGAJUAN' then 1
		else 9
		end
		, a.tgl";
	 
		$arrParamData=array();
	    $rst=$conn->Execute($query, $arrParamData);
		if($rst)
		{
			if($rst->recordCount()>0){
				$i=0;
				while(!$rst->EOF)
				{
					$idbatch = $rst->fields["id_batch"];
					$id = $rst->fields["id"];
					$nip = $rst->fields["nip"];
					$nama = $rst->fields["nama"];
					$unitkerja = $rst->fields["unit_kerja"];
					$kodeemiten = $rst->fields["kode_emiten"];
					$sekuritas = $rst->fields["sekuritas"];
					$status = $rst->fields["status"];
					if($status=="PENGAJUAN"){
						$lbrpengajuan = number_format($rst->fields["lbr_pengajuan"],0);
						$hrgpengajuan = number_format($rst->fields["hrg_pengajuan"],0);
						$jmlterjual = number_format($rst->fields["lbr_pengajuan"] * $rst->fields["hrg_pengajuan"],0);
					}else{
						$lbrpengajuan = number_format($rst->fields["lbr_terjual"],0);
						$hrgpengajuan = number_format($rst->fields["hrg_pengajuan"],0);
						$jmlterjual = number_format($rst->fields["lbr_terjual"] * $rst->fields["hrg_pengajuan"],0);
					}
					
					$tglpengajuan = $rst->fields["tgl_pengajuan"];
					$tglproses = $rst->fields["tgl_proses"];
					$tglterjual = $rst->fields["tgl_terjual"];
					$terimadanasekuritas = number_format($rst->fields["terima_dari_sekuritas"],0);
					$groupid = $rst->fields["groupid"];
					
					$totaLbrWIKA    += ($rst->fields["kode_emiten"]=="WIKA")?$rst->fields["lbr_terjual"]:0;
					$totaLbrWTON    += ($rst->fields["kode_emiten"]=="WTON")?$rst->fields["lbr_terjual"]:0;
					$totaLbrWEGE    += ($rst->fields["kode_emiten"]=="WEGE")?$rst->fields["lbr_terjual"]:0;
					$totaLbrWR      += ($rst->fields["kode_emiten"]=="WR")?$rst->fields["lbr_terjual"]:0;
					$totaLbrWIKON   += ($rst->fields["kode_emiten"]=="WIKON")?$rst->fields["lbr_terjual"]:0;
					
					$arrData[] = array($idbatch,$id,  $groupid, $nip,$nama,$unitkerja, $kodeemiten, $sekuritas,$tglpengajuan, $lbrpengajuan, $hrgpengajuan, $jmlterjual, $status,  $tglproses, $tglterjual, $terimadanasekuritas);
					
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
		
		
    $data = array(
		    'data' => $arrData,
	        'total' => array(number_format($totaLbrWIKA,0), number_format($totaLbrWTON,0), number_format($totaLbrWEGE,0), number_format($totaLbrWR,0), number_format($totaLbrWIKON,0))
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
		$noberkas = "";
		
		$idbatch = isset($_GET['idbatch'])?$_GET['idbatch']:'';
		
		$tanggal = isset($_POST['itanggal']) ? $_POST['itanggal'] : "";
		$emiten = isset($_POST['iemiten']) ? $_POST['iemiten'] : "";
		$sekuritas = isset($_POST['isekuritas']) ? $_POST['isekuritas'] : "";
		$terimadana = isset($_POST['iterimadana']) ? $_POST['iterimadana'] : "";
		$arrRowData = isset($_POST['idatarow']) ? $_POST['idatarow'] : "";
		$arrTanggal = explode("/",$tanggal);
		$tanggal = $arrTanggal[2]."-".$arrTanggal[1]."-".$arrTanggal[0];
		
		if($idbatch==""){
			//ambil idbatch terakhir dulu
			$sqlbatch = "select coalesce(max(id_batch),0)+1 as lastno from m_penjualan_terima where id_batch like '".Date("Y")."%'";
			$rstbatch = $conn->Execute($sqlbatch);
			if($rstbatch){
				$idbatch = $rstbatch->fields["lastno"];
				if($idbatch=="1"){
					$idbatch = Date("Y").sprintf("%04d",$idbatch);
				}
			}else{
				$idbatch = Date("Y").sprintf("%04d",1);
			}
			
			$sqlberkas = "select coalesce(max(no_berkas),0)+1 as lastno from m_dokkbm_h where no_berkas like '".Date("Y")."%'";
			$rstberkas = $conn->Execute($sqlberkas);
			if($rstberkas){
				$noberkas = $rstberkas->fields["lastno"];
				if($noberkas=="1"){
					$noberkas = Date("Y").sprintf("%06d",$noberkas);
				}
			}else{
				$noberkas = Date("Y").sprintf("%06d",1);
			}
			
			//header nya m_penjualan_terima
			//insert ke header nya dulu, baru ke detil nya di table m_penjualan
			$sqlIns1 = "insert into kkms.m_penjualan_terima (id_batch, tgl_batch, kode_emiten, sekuritas, terima_dari_sekuritas) values (?,?,?,?,?)";
			$arrBindDataIns1 = array($idbatch,$tanggal, $emiten, $sekuritas, $terimadana);
			
			$sqlberkas = "insert into kkms.m_dokkbm_h(no_berkas, tgl_dok, jdok, subject,  idbatch) values (?,?,?,?,?)";
			$arrBindDataBerkas = array($noberkas, $tanggal, 'M', $sekuritas,  $idbatch);
			$conn->Execute($sqlberkas, $arrBindDataBerkas);
			
		}else{
			$sqlIns1 = "update kkms.m_penjualan_terima set tgl_batch = ?, kode_emiten = ?, sekuritas = ?, terima_dari_sekuritas = ? where id_batch like ?";
			$arrBindDataIns1 = array($tanggal, $emiten, $sekuritas, $terimadana, $idbatch);
		}
		
		$rstIns1 = $conn->Execute($sqlIns1, $arrBindDataIns1);
		if($rstIns1) {
			
			
			
			foreach($arrRowData as $key=>$value){
				$sqlIns2="Update kkms.m_penjualan set id_batch = ?, tgl_terjual = ?, lbr_terjual = ?, hrg_terjual = ?, total_terjual = ?, status='TERJUAL', simp_pokok = ?, simp_wajib = ?, simp_sukarela = ? where id like ?";
				$arrBindDataIns2 = array($idbatch, $tanggal, $value["LbrPengajuan"], $value["HrgPengajuan"], $value["TotalPengajuan"], $value["SimpPokok"], $value["SimpWajib"], $value["SimpSukarela"], $value["IDDB"]);
				$rstIns2 = $conn->Execute($sqlIns2, $arrBindDataIns2);
				if(!$rstIns2){
					$errMsg.="Error Pada ID : ".$value["IDDB"]." , ".$conn->ErrorMsg()." !!!!";
				}
				
			}
		}else{
			$errMsg.="Error Insert !!! \n".$conn->ErrorMsg();
		}
		
		if($errMsg==""){
			$statusRet = "OK";
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
		$id = $_GET['iID'];
		
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
		$params="";
		
		$this->contentManagement();
		
		//$this->render_view('kkms/penjualan2/v_m_penjualan_list', $params);
		
		/*$data = array(
			'Status' => $status,
			'ErrorMsg'=>$errMsg
		);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		*/
		
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
		$params["title"] = "Tambah Data Pengajuan Penjualan Saham ";
		$params["dmlmode"] = "INSERT";
		//$params["TglDok"] = Date("d/m/Y");
		$DATA["tgl"] = Date("d/m/Y");
		$params["DATA"]=$DATA;
		$this->render_view('kkms/penjualan2/v_m_penjualan_inputform', $params);
	}
	
	public function setTerjualForm(){
		$params["title"] = "Tambah Data Penjualan Saham (Terjual)";
		$params["dmlmode"] = "INSERT";
		$arrData = array();
		$kodeemiten = isset($_GET['kodeemiten'])?$_GET['kodeemiten']:'';
		$sekuritas = isset($_GET['sekuritas'])?$_GET['sekuritas']:'';
		$idbatch = isset($_GET['idbatch'])?$_GET['idbatch']:'';
		if($idbatch!==""){
			$params["dmlmode"] = "EDIT";
		}
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		if($idbatch==""){
			$query="select a.id, a.no_urut, a.nip, b.nama, b.unit_kerja, DATE_FORMAT(a.tgl,'%d/%m/%Y') as tgl_pengajuan, a.sekuritas, a.kode_emiten, round(a.lbr_pengajuan,0) as lbr_pengajuan, round(a.hrg_pengajuan,0) as hrg_pengajuan, round(a.total_pengajuan,0) as total_pengajuan from m_penjualan a inner join m_anggota b on a.nip=b.nip left join m_penjualan_terima c on c.id_batch=a.id_batch where a.kode_emiten like '$kodeemiten' and a.sekuritas like '$sekuritas' and a.status='PENGAJUAN'
		order by a.tgl asc";
		}else{
			$query="select a.id, a.no_urut, a.nip, b.nama, b.unit_kerja, DATE_FORMAT(a.tgl,'%d/%m/%Y') as tgl_pengajuan, a.sekuritas, a.kode_emiten, round(a.lbr_pengajuan,0) as lbr_pengajuan, round(a.hrg_pengajuan,0) as hrg_pengajuan, round(a.total_pengajuan,0) as total_pengajuan, round(a.lbr_terjual,0) as lbr_terjual, round(a.hrg_terjual,0) as hrg_terjual, round(a.total_terjual,0) as total_terjual, DATE_FORMAT(c.tgl_batch,'%d/%m/%Y') as tgl_batch, c.terima_dari_sekuritas, a.pot_hutang, a.simp_pokok, a.simp_wajib, a.simp_sukarela from m_penjualan a inner join m_anggota b on a.nip=b.nip left join m_penjualan_terima c on c.id_batch=a.id_batch where a.kode_emiten like '$kodeemiten' and a.sekuritas like '$sekuritas' and a.id_batch like '$idbatch'
		order by a.tgl asc";
		}
		
		
		$arrParamData=array();
		$rst=$conn->Execute($query, $arrParamData);
		if($rst){
			$i=0;
			while(!$rst->EOF){
				
				foreach($rst->fields as $key=>$value){
					$arrData[$i][$key]=$value;
				}
				
				$rst->moveNext();
				$i++;
			}
		}
		
		$params["DATA"]=$arrData;
		
		//var_dump($params);
		
		$this->render_view('kkms/penjualan2/v_m_penjualan_inputform2', $params);
	}
	
	public function setTerjualFormDel(){
		$params["title"] = "Hapus Data Penjualan Saham (Terjual)";
		$arrData = array();
		$kodeemiten = isset($_GET['kodeemiten'])?$_GET['kodeemiten']:'';
		$sekuritas = isset($_GET['sekuritas'])?$_GET['sekuritas']:'';
		$idbatch = isset($_GET['idbatch'])?$_GET['idbatch']:'';
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$this->load->helper('erp_wb_helper');
		
		
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		if($idbatch!=""){
			$query = "Update m_penjualan set status='PENGAJUAN', lbr_terjual=null, hrg_terjual=null, total_terjual=null, fee_sekuritas=null, fee_sekuritas_persen=null, net_terjual=null, fee_transaksi=null, fee_jaminan_pph=null, fee_kelola=null, simp_pokok=null, simp_wajib=null, simp_sukarela=null, pot_hutang=null, net_pemohon=null, net_pemohon_af_simp=null, simp_total=null where id_batch like '$idbatch'";
			$rst=$conn->Execute($query);
			$query = "delete from m_penjualan_terima where id_batch like '$idbatch'";
			$rst=$conn->Execute($query);
			$query = "delete from m_kepemilikan where id_batch like '$idbatch'";
			$rst=$conn->Execute($query);
			
		}
		
		$this->contentManagement();
	}
	
	public function editData(){
		
		$params["title"] = "Edit Data Penjualan Saham (Pengajuan)";
		$params["dmlmode"] = "UPDATE";
		$params["TglDok"] = Date("d/m/Y");
		$idrec = isset($_GET['idrec']) ? $_GET['idrec'] : "";
		
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
					$this->render_view('kkms/penjualan2/v_m_penjualan_inputform', $params);
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
		
		$query="select terima_dari_sekuritas from m_penjualan_terima where id_batch like ?";
		$arrParamData=array($idbatch);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				
				$terima_dari_sekuritas = $rst->fields["terima_dari_sekuritas"];
			}
		}
		
		require_once($pathTCPDF.'examples/tcpdf_include.php');
		// create new PDF document
		$pdf = new TCPDF('L', 'mm', 'A3', true, 'UTF-8', false);
		
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
					<th colspan=\"4\" style=\"width:23%;$attrHdr1\">DATA PESERTA</th>
					<th colspan=\"3\" style=\"width:14%;$attrHdr1\">PENGAJUAN</th>
					<th colspan=\"3\" style=\"width:18%;$attrHdr1\">TERJUAL</th>
					<th colspan=\"8\" style=\"width:45%;$attrHdr1\">KKMS</th>
				</tr>
				<tr style=\"text-align:center;font-weight:bold;vertical-align: middle;\">
					<th style=\"width:3%;$attrHdr2\">NO</th>
					<th style=\"width:4%;$attrHdr2\">NIP</th>
					<th style=\"width:11%;$attrHdr2\">NAMA</th>
					<th style=\"width:5%;$attrHdr2\">UNIT KERJA</th>
					<th style=\"width:4%;$attrHdr2\">LEMBAR</th>
					<th style=\"width:4%;$attrHdr2\">HARGA</th>
					<th style=\"width:6%;$attrHdr2\">TOTAL</th>
					<th style=\"width:6%;$attrHdr2\">LEMBAR</th>
					<th style=\"width:6%;$attrHdr2\">TOTAL</th>
					<th style=\"width:6%;$attrHdr2\">FEE SEKURITAS</th>
					<th style=\"width:6%;$attrHdr2\">FEE PENJUALAN</th>
					
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
					<th style=\"width:5%;$attrHdr2\">SIMP. POKOK</th>
					<th style=\"width:5%;$attrHdr2\">SIMP. WAJIB</th>
					<th style=\"width:6%;$attrHdr2\">SIMP. SUKARELA</th>
					<th style=\"width:8%;$attrHdr2\">DITERIMA PEMOHON</th>
				</tr>
				<tr style=\"text-align:center;font-size:8px;\">
					<th style=\"width:3%;$attrHdr3\">1</th>
					<th style=\"width:4%;$attrHdr3\">2</th>
					<th style=\"width:11%;$attrHdr3\">3</th>
					<th style=\"width:5%;$attrHdr3\">4</th>
					<th style=\"width:4%;$attrHdr3\">5</th>
					<th style=\"width:4%;$attrHdr3\">6</th>
					<th style=\"width:6%;$attrHdr3\">7</th>
					<th style=\"width:6%;$attrHdr3\">8</th>
					<th style=\"width:6%;$attrHdr3\">9</th>
					<th style=\"width:6%;$attrHdr3\">10</th>
					<th style=\"width:6%;$attrHdr3\">11</th>
					<th style=\"width:8%;$attrHdr3\">12</th>
					<th style=\"width:7%;$attrHdr3\">13</th>
					<th style=\"width:5%;$attrHdr3\">14</th>
					<th style=\"width:5%;$attrHdr3\">15</th>
					<th style=\"width:6%;$attrHdr3\">16</th>
					<th style=\"width:8%;$attrHdr3\">17</th>
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
		$total_simp_pokok = 0;
		$total_simp_wajib = 0;
		$total_simp_sukarela = 0;
		$total_jaminan_kelola = 0;
		$total_simp = 0;
		
		$unit_kerja = "";
		
		$attrRow1="background-color:#ffffff;border:1px solid #000000;";
		$attrRow2="background-color:#f6fdfa;border:1px solid #000000;";
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.simp_pokok, a.simp_wajib, a.simp_sukarela, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where DATE_FORMAT(a.tgl_terjual,'%Y-%m-%d') like ? and a.id_batch like ? order by a.tgl desc";
		
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
					$total_simp_pokok += $rst->fields["simp_pokok"];
					$total_simp_wajib += $rst->fields["simp_wajib"];
					$total_simp_sukarela += $rst->fields["simp_sukarela"];
					$total_simp += $rst->fields["simp_pokok"] + $rst->fields["simp_wajib"] +  $rst->fields["simp_sukarela"];
					$unit_kerja = $rst->fields["unit_kerja"];
					$total_jaminan_kelola = $total_jaminan + $total_kelola;
					
					$tbl.= "
					<tr style=\"\">
						<td style=\"width:3%;text-align:center;$attrRow1\">".($i+1)."</td>
						<td style=\"width:4%;text-align:center;$attrRow1\">".$rst->fields["nip"]."</td>
						<td style=\"width:11%;$attrRow1\">".$rst->fields["nama"]."</td>
						<td style=\"width:5%;text-align:center;$attrRow1\">".$rst->fields["unit_kerja"]."</td>
						<td style=\"width:4%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["lbr_pengajuan"],0)."</td>
						<td style=\"width:4%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["hrg_pengajuan"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["total_pengajuan"],0)."</td>
						
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["lbr_terjual"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["total_terjual"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_sekuritas"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_transaksi"],0)."</td>";
					switch($emiten){
						case "WTON":
							$tbl.="<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_jaminan_pph"],0)."</td>";
							break;
						case "WEGE":
							$tbl.="<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_kelola"],0)."</td>";
							break;
					}
					$tbl.="
						<td style=\"width:7%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["pot_hutang"],0)."</td>
						<td style=\"width:5%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["simp_pokok"],0)."</td>
						<td style=\"width:5%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["simp_wajib"],0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["simp_sukarela"],0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["net_pemohon"],0)."</td>
					</tr>";
					
					$rst->moveNext();
					$i++;
				}
				
				$strHeight="height:".(30*(10-$i))."px;";
				$tbl .= "
					<tr style='$strHeight'>
						<td style=\"$strHeight width:3%;text-align:center;$attrRow1\">&nbsp;</td>
						<td style=\"$strHeight width:4%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:11%;$attrRow1\"></td>
						<td style=\"$strHeight width:5%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:4%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:4%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>";
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
						<td style=\"$strHeight width:5%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:5%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:6%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:8%;text-align:right;padding:2px;$attrRow1\"></td>
					</tr>";
				
				
				$attrFoot1="background-color:#cfcfc4;border:1px solid #000000;";
				$tbl .= "
					<tr style='height:45px;'>
						<td  style=\"width:23%;text-align:center;vertical-align:top;$attrFoot1\" colspan='4'><b>T O T A L</b></td>
						<td  style=\"width:4%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_lbr1,0)."</td>
						<td style=\"width:4%;text-align:right;padding:2px;$attrFoot1\">&nbsp;</td>
						<td style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_aju,0)."</td>
						<td  style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_lbr2,0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_jual,0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_fee_sekuritas,0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_fee_jual,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_jaminan_kelola,0)."</td>
						<td style=\"width:7%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_hutang,0)."</td>
						
						<td style=\"width:5%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_simp_pokok,0)."</td>
						<td style=\"width:5%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_simp_wajib,0)."</td>
						<td style=\"width:6%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_simp_sukarela,0)."</td>
						<td style=\"width:8%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_pemohon,0)."</td>
					</tr>
						";
				
			}
		}
		
		//$terima_dari_sekuritas = $hrg_jual_batch - $total_fee_sekuritas;
		$pendapatan_lain_lain = $terima_dari_sekuritas - $total_pemohon + $total_fee_jual + $total_jaminan_kelola + $total_hutang;
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
									<td style=\"width:33%;text-align:center;\">Drs. Saparyadi</td>
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
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\"><b>".number_format($total_pemohon,0)."</b></td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Fee Penjualan</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_fee_jual,0)."</td>
								</tr>
								";
		if($emiten=="WTON"){
			$tbl.="
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Jaminan PPh SP</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_jaminan_kelola,0)."</td>
								</tr>";
		}
		if($emiten=="WEGE"){
			$tbl.="
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">By. Adm. Pengelolaan</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_jaminan_kelola,0)."</td>
								</tr>";
		}
		$tbl.="
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Potongan Hutang Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_hutang,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Pendapatan Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($pendapatan_lain_lain,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Simp. Pokok, Wajib, Sukarela</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_simp,0)."</td>
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
							</tr>";
		$tblHdrPage2.="
							<tr>
								<td colspan=\"6\" style=\"width:500px;height:10px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Diterima dari</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:330px;text-align:left;\" colspan=\"3\">$nama_sekuritas</td>
								<td style=\"width:100px;\"></td>
							</tr>";
		$tblHdrPage2.="
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
				$kodeakun1="";
				while (!$rst->EOF) {
					$nama = $rst->fields["nama"];
					$kodeemiten = $rst->fields["kode_emiten"];
					$vol = $rst->fields["lbr_terjual"];
					$rupiah = $rst->fields["net_pemohon"];
					switch($kodeemiten){
                        case "WTON":
                            $kodeakun1="2 1 1 2 3";
                        break;
                        case "WEGE":
                            $kodeakun1="2 1 1 2 6";
                            break;
                    }


					$strTblContentPage2.="<tr>
											<th style=\"width:5%; text-align:center;$styleContent1\">".($i+1)."</th>
											<th style=\"width:30%;text-align:left;$styleContent1\">$kodeemiten - $nama</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;$styleContent1\">&nbsp;</th>
											<th style=\"width:10%;text-align:right;$styleContent1\">".number_format($vol,0)."</th>
											<th style=\"width:10%;text-align:center;$styleContent1\">$kodeakun1</th>
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
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format(abs($total_fee_jual),0)."</th>
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
											<th style=\"width:10%;text-align:center;$styleContent1\">5 1 3 1 5</th>
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format(abs($total_kelola),0)."</th>
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
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format(abs($total_jaminan),0)."</th>
										</tr>";
				}


				//selisih adm penjualan
				$selisihpenjualan = $terima_dari_sekuritas - $total_pemohon + $total_fee_jual + $total_jaminan_kelola + $total_hutang;
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
											<th style=\"width:15%;text-align:right;$styleContent1\">".number_format(abs($selisihpenjualan),0)."</th>
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
			$total_bkas = abs($total_pemohon) + abs($total_fee_jual) + abs($total_jaminan) + abs($total_kelola) + abs($selisihpenjualan);
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
									<td style=\"width:20%;text-align:center;\">Drs. Saparyadi</td>
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
								<td style=\"width:110px;\" colspan=\"2\">BUKTI PENGELUARAN</td>";
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
								<td style=\"width:150px;text-align:left;\">KREDIT No. Perkiraan</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:110px;text-align:left;\">___ ___ ___ ___ ___</td>
								<td style=\"width:110px;\">&nbsp;</td>
								<td style=\"width:110px;\">&nbsp;</td>
							</tr>";
		$tblHdrPage2.="
							<tr>
								<td colspan=\"6\" style=\"width:500px;height:10px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Dibayar Kepada</td>
								<td style=\"width:20px;\">:</td>
								<td style=\"width:330px;text-align:left;\" colspan=\"3\">$unit_kerja</td>
								<td style=\"width:100px;\"></td>
							</tr>";
		$tblHdrPage2.="
							<tr>
								<td colspan=\"6\" style=\"width:500px;\"></td>
							</tr>
							<tr>
								<td style=\"width:150px;text-align:left;\">&nbsp;Dibayar</td>
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
									<td style=\"width:20%;text-align:center;\">Drs. Saparyadi</td>
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
	
	
	public function genLapRekapbulanan(){
		$blnfilter = isset($_GET["iblnfilter"])?$_GET["iblnfilter"]:"";
		$thnfilter = isset($_GET["ithnfilter"])?$_GET["ithnfilter"]:"";
		
		$this->load->library('AdodbConnMySQL');
		$conn = $this->adodbconnmysql->getMySQLConn("HR");
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		
		$kodeemiten = "";
		$i=0;
		$styleContent1="";
		
		$emiten = "WTON";
		$arrBulan = array("01"=>"Januari", "02"=>"Pebruari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"Nopember", "12"=>"Desember");
		
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
		
		$query="select sum(terima_dari_sekuritas) as terima_dari_sekuritas from m_penjualan_terima where kode_emiten like ? and tgl_batch like '".$thnfilter."-".$blnfilter."%'";
		$arrParamData=array($emiten);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst) {
			if ($rst->recordCount() > 0) {
				$terima_dari_sekuritas = $rst->fields["terima_dari_sekuritas"];
			}
		}
		
		require_once($pathTCPDF.'examples/tcpdf_include.php');
		// create new PDF document
		$pdf = new TCPDF('L', 'mm', 'A3', true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator('ROZI');
		$pdf->SetAuthor('KKMS');
		$pdf->SetTitle('Laporan Rekap Bulanan');
		$pdf->SetSubject('Rekap Bulanan');
		$pdf->SetKeywords('Rekap, PDF, bulan, kkms');
		
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
		$pdf->Write(0, "Periode Bulan ".$arrBulan[$blnfilter]." $thnfilter", '', 0, 'C', true, 0, false, false, 0);
		$pdf->SetFont('calibri', '', 8);
		
		
		// -----------------------------------------------------------------------------
		/*$attrHdr1="background-color:#cfcfc4;border:1px solid #adadad;";
		$attrHdr2="background-color:#e5e5e5;border:1px solid #adadad;";
		$attrHdr3="background-color:#cfcfc4;border:1px solid #adadad;";*/
		$attrHdr1="background-color:#cfcfc4;border:1px solid #000000;";
		$attrHdr2="background-color:#e5e5e5;border:1px solid #000000;";
		$attrHdr3="background-color:#cfcfc4;border:1px solid #000000;";
		
		$arrColMargin[0] = "";
		$arrColMargin[1] = "3";
		$arrColMargin[2] = "4";
		$arrColMargin[3] = "11";
		$arrColMargin[4] = "5";
		$arrColMargin[5] = "6";
		$arrColMargin[6] = "6";
		$arrColMargin[7] = "8";
		$arrColMargin[8] = "6";
		$arrColMargin[9] = "6";
		$arrColMargin[10] = "6";
		$arrColMargin[11] = "6";
		$arrColMargin[12] = "7";
		$arrColMargin[13] = "8";
		$arrColMargin[14] = "5";
		$arrColMargin[15] = "5";
		$arrColMargin[16] = "6";
		
		$arrGroupColMargin[0]="";
		$arrGroupColMargin[1]=$arrColMargin[1]+$arrColMargin[2]+$arrColMargin[3]+$arrColMargin[4];
		$arrGroupColMargin[2]=$arrColMargin[5]+$arrColMargin[6]+$arrColMargin[7];
		$arrGroupColMargin[3]=$arrColMargin[8]+$arrColMargin[9];
		$arrGroupColMargin[4]=$arrColMargin[10]+$arrColMargin[11]+$arrColMargin[12]+$arrColMargin[13]+$arrColMargin[14]+$arrColMargin[15]+$arrColMargin[16];
		
		$tbl = "<br/><br/>
		<table cellspacing=\"0\" cellpadding=\"2\">
			<thead>
				<tr style=\"text-align:center;font-weight:bold;\">
					<th colspan=\"4\" style=\"width:".$arrGroupColMargin[1]."%;$attrHdr1\">DATA PESERTA</th>
					<th colspan=\"3\" style=\"width:".$arrGroupColMargin[2]."%;$attrHdr1\">TERJUAL</th>
					<th colspan=\"2\" style=\"width:".$arrGroupColMargin[3]."%;$attrHdr1\">SEKURITAS</th>
					<th colspan=\"8\" style=\"width:".$arrGroupColMargin[4]."%;$attrHdr1\">KKMS</th>
				</tr>
				<tr style=\"text-align:center;font-weight:bold;vertical-align: middle;\">
					<th style=\"width:".$arrColMargin[1]."%;$attrHdr2\">NO</th>
					<th style=\"width:".$arrColMargin[2]."%;$attrHdr2\">NIP</th>
					<th style=\"width:".$arrColMargin[3]."%;$attrHdr2\">NAMA</th>
					<th style=\"width:".$arrColMargin[4]."%;$attrHdr2\">UNIT KERJA</th>
					<th style=\"width:".$arrColMargin[5]."%;$attrHdr2\">TGL</th>
					<th style=\"width:".$arrColMargin[6]."%;$attrHdr2\">LEMBAR</th>
					<th style=\"width:".$arrColMargin[7]."%;$attrHdr2\">TOTAL</th>
					<th style=\"width:".$arrColMargin[8]."%;$attrHdr2\">By Tiap Transaksi</th>
					<th style=\"width:".$arrColMargin[9]."%;$attrHdr2\">Terima Bersih</th>
					<th style=\"width:".$arrColMargin[10]."%;$attrHdr2\">FEE PENJUALAN</th>
					
					";
		if($emiten=="WTON"){
			$tbl.="
						<th style=\"width:".$arrColMargin[11]."%;$attrHdr2\">JAMINAN<br>PPh SP 5%</th>";
		}
		if($emiten=="WEGE"){
			$tbl.="
						<th style=\"width:".$arrColMargin[11]."%;$attrHdr2\">FEE KELOLA</th>";
		}
		
		$tbl.= "
					<th style=\"width:".$arrColMargin[12]."%;$attrHdr2\">POT HUTANG</th>
					<th style=\"width:".$arrColMargin[13]."%;$attrHdr2\">DITERIMA PEMOHON</th>
					<th style=\"width:".$arrColMargin[14]."%;$attrHdr2\">SIMP. POKOK</th>
					<th style=\"width:".$arrColMargin[15]."%;$attrHdr2\">SIMP. WAJIB</th>
					<th style=\"width:".$arrColMargin[16]."%;$attrHdr2\">SIMP. SUKARELA</th>
				</tr>
				<tr style=\"text-align:center;font-size:8px;\">
					<th style=\"width:".$arrColMargin[1]."%;$attrHdr3\">1</th>
					<th style=\"width:".$arrColMargin[2]."%;$attrHdr3\">2</th>
					<th style=\"width:".$arrColMargin[3]."%;$attrHdr3\">3</th>
					<th style=\"width:".$arrColMargin[4]."%;$attrHdr3\">4</th>
					<th style=\"width:".$arrColMargin[5]."%;$attrHdr3\">5</th>
					<th style=\"width:".$arrColMargin[6]."%;$attrHdr3\">6</th>
					<th style=\"width:".$arrColMargin[7]."%;$attrHdr3\">7</th>
					<th style=\"width:".$arrColMargin[8]."%;$attrHdr3\">8</th>
					<th style=\"width:".$arrColMargin[9]."%;$attrHdr3\">9</th>
					<th style=\"width:".$arrColMargin[10]."%;$attrHdr3\">10</th>
					<th style=\"width:".$arrColMargin[11]."%;$attrHdr3\">11</th>
					<th style=\"width:".$arrColMargin[12]."%;$attrHdr3\">12</th>
					<th style=\"width:".$arrColMargin[13]."%;$attrHdr3\">13</th>
					<th style=\"width:".$arrColMargin[14]."%;$attrHdr3\">14</th>
					<th style=\"width:".$arrColMargin[15]."%;$attrHdr3\">15</th>
					<th style=\"width:".$arrColMargin[16]."%;$attrHdr3\">16</th>
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
		$total_simp_pokok = 0;
		$total_simp_wajib = 0;
		$total_simp_sukarela = 0;
		$total_jaminan_kelola = 0;
		$total_simp = 0;
		
		$unit_kerja = "";
		
		$attrRow1="background-color:#ffffff;border:1px solid #000000;";
		$attrRow2="background-color:#f6fdfa;border:1px solid #000000;";
		
		$query="select distinct a.id, a.nip, b.nama, b.unit_kerja, a.tgl, DATE_FORMAT(a.tgl_terjual,'%d/%m/%Y') as  tgl_terjual, a.sekuritas, a.kode_emiten, a.lbr_pengajuan,a.hrg_pengajuan, a.total_pengajuan, a.lbr_terjual, a.hrg_terjual, a.total_terjual, a.fee_sekuritas, a.net_terjual, a.fee_transaksi, a.fee_jaminan_pph, a.fee_kelola, a.pot_hutang, a.simp_pokok, a.simp_wajib, a.simp_sukarela, a.net_pemohon from m_penjualan a inner join m_anggota b on a.nip=b.nip where a.kode_emiten like ? and DATE_FORMAT(a.tgl_terjual,'%Y-%m') like '".$thnfilter."-".$blnfilter."'  order by a.tgl asc";
		
		$arrParamData=array($emiten);
		$rst=$conn->Execute($query, $arrParamData);
		if($rst)
		{
			if($rst->recordCount()>0){
				$i=0;
				$nama_sekuritas = $rst->fields["sekuritas"];
				while(!$rst->EOF)
				{
					$tglterjual = $rst->fields["tgl_terjual"];
					$feesekuritas = $rst->fields["fee_sekuritas"];
					$terimadarisekuritasperbaris = $rst->fields["net_terjual"];
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
					$total_simp_pokok += $rst->fields["simp_pokok"];
					$total_simp_wajib += $rst->fields["simp_wajib"];
					$total_simp_sukarela += $rst->fields["simp_sukarela"];
					$total_simp += $rst->fields["simp_pokok"] + $rst->fields["simp_wajib"] +  $rst->fields["simp_sukarela"];
					$unit_kerja = $rst->fields["unit_kerja"];
					$total_jaminan_kelola = $total_jaminan + $total_kelola;
					
					$tbl.= "
					<tr style=\"\">
						<td style=\"width:".$arrColMargin[1]."%;text-align:center;$attrRow1\">".($i+1)."</td>
						<td style=\"width:".$arrColMargin[2]."%;text-align:center;$attrRow1\">".$rst->fields["nip"]."</td>
						<td style=\"width:".$arrColMargin[3]."%;$attrRow1\">".$rst->fields["nama"]."</td>
						<td style=\"width:".$arrColMargin[4]."%;text-align:center;$attrRow1\">".$rst->fields["unit_kerja"]."</td>
						<td style=\"width:".$arrColMargin[5]."%;text-align:center;padding:2px;$attrRow1\">".$tglterjual."</td>
						<td style=\"width:".$arrColMargin[6]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["lbr_terjual"],0)."</td>
						<td style=\"width:".$arrColMargin[7]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["total_terjual"],0)."</td>
						<td style=\"width:".$arrColMargin[8]."%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($feesekuritas,0)."</td>
						<td style=\"width:".$arrColMargin[9]."%;text-align:right;padding:2px;$attrRow1\">".number_format($terimadarisekuritasperbaris,0)."</td>
						<td style=\"width:".$arrColMargin[10]."%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_transaksi"],0)."</td>";
					switch($emiten){
						case "WTON":
							$tbl.="<td style=\"width:".$arrColMargin[11]."%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_jaminan_pph"],0)."</td>";
							break;
						case "WEGE":
							$tbl.="<td style=\"width:".$arrColMargin[11]."%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["fee_kelola"],0)."</td>";
							break;
					}
					$tbl.="
						<td style=\"width:".$arrColMargin[12]."%;text-align:right;padding:2px;$attrRow1\">".$this->fnChgToBracket($rst->fields["pot_hutang"],0)."</td>
						<td style=\"width:".$arrColMargin[13]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["net_pemohon"],0)."</td>
						<td style=\"width:".$arrColMargin[14]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["simp_pokok"],0)."</td>
						<td style=\"width:".$arrColMargin[15]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["simp_wajib"],0)."</td>
						<td style=\"width:".$arrColMargin[16]."%;text-align:right;padding:2px;$attrRow1\">".number_format($rst->fields["simp_sukarela"],0)."</td>
						
					</tr>";
					
					$rst->moveNext();
					$i++;
				}
				
				$strHeight="height:".(30*(10-$i))."px;";
				$tbl .= "
					<tr style='$strHeight'>
						<td style=\"$strHeight width:".$arrColMargin[1]."%;text-align:center;$attrRow1\">&nbsp;</td>
						<td style=\"$strHeight width:".$arrColMargin[2]."%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[3]."%;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[4]."%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[5]."%;text-align:center;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[6]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[7]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[8]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[9]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[10]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[11]."%;text-align:right;padding:2px;$attrRow1\"></td>";
				
				$tbl.="
						<td style=\"$strHeight width:".$arrColMargin[12]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[13]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[14]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[15]."%;text-align:right;padding:2px;$attrRow1\"></td>
						<td style=\"$strHeight width:".$arrColMargin[16]."%;text-align:right;padding:2px;$attrRow1\"></td>
						
					</tr>";
				
				
				$attrFoot1="background-color:#cfcfc4;border:1px solid #000000;";
				$tbl .= "
					<tr style='height:45px;'>
						<td  style=\"width:".$arrGroupColMargin[1]."%;text-align:center;vertical-align:top;$attrFoot1\" colspan='4'><b>T O T A L</b></td>
						<td  style=\"width:".$arrColMargin[5]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">&nbsp;</td>
						<td  style=\"width:".$arrColMargin[6]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_lbr2,0)."</td>
						<td style=\"width:".$arrColMargin[7]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_jual,0)."</td>
						<td style=\"width:".$arrColMargin[8]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_fee_sekuritas,0)."</td>
						<td style=\"width:".$arrColMargin[9]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_net,0)."</td>
						<td style=\"width:".$arrColMargin[10]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_fee_jual,0)."</td>
						<td style=\"width:".$arrColMargin[11]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_jaminan,0)."</td>
						<td style=\"width:".$arrColMargin[12]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".$this->fnChgToBracket($total_hutang,0)."</td>
						<td style=\"width:".$arrColMargin[13]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_pemohon,0)."</td>
						<td style=\"width:".$arrColMargin[14]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_simp_pokok,0)."</td>
						<td style=\"width:".$arrColMargin[15]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_simp_wajib,0)."</td>
						<td style=\"width:".$arrColMargin[16]."%;text-align:right;padding:2px;font-weight:bold;$attrFoot1\">".number_format($total_simp_sukarela,0)."</td>
						
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
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_fee_jual,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Jaminan PPh SP</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_jaminan,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Potongan Hutang Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($total_hutang,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Pendapatan Lain-lain</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".$this->fnChgToBracket($pendapatan_lain_lain,0)."</td>
								</tr>
								<tr>
									<td style=\"width:60%;text-align:left;border-bottom:0.5px solid grey;\">Simp. Pokok, Wajib, Sukarela</td>
									<td style=\"width:5%;text-align:center;border-bottom:0.5px solid grey;\">:</td>
									<td style=\"width:35%;text-align:right;border-bottom:0.5px solid grey;\">".number_format($total_simp,0)."</td>
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
		
		
		
		$waktuSaatIni = Date("YmdHis");
		//$serverPath = $this->config->item( 'wb_server_path' );
		$fnoutputname = "lap-rekap-bulanan-penjualan-".$waktuSaatIni.".pdf";
		
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
	
	public function fnChgToBracket($inum,$numDigitaftercomma=0){
		$retval = "";
		if($inum<0){
			$retval="(".number_format(abs($inum),$numDigitaftercomma).")";
		}else{
			$retval = number_format($inum,$numDigitaftercomma);
		}
		
		return $retval;
	}
}
