<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Absensi_Pegawai extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * Februari 2018
	 */
	 
	var $oraConn = "HR";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
	
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
		$params["title"]="Daftar Tagihan";
		$params["grid"] = $this->initGrid();
		$this->render_view('hr/absensi-pegawai/v_absensi_list', $params);
    }
	
	
	public function initGrid(){
		
		$i=0;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="4%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NO_SPB";
		$paramsGrid["source"]["datafields"][$i]["name"]="NO_SPB";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="No SPB";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.NAMA";
		$paramsGrid["source"]["datafields"][$i]["name"]="VENDOR_NAME";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama Vendor";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
	
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.JATUH_TEMPO";
		$paramsGrid["source"]["datafields"][$i]["name"]="JATUH_TEMPO";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Jatuh Tempo";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="c.SISTEM_BAYAR";
		$paramsGrid["source"]["datafields"][$i]["name"]="SISTEM_BAYAR";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Pembayaran";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="d.METODE_BAYAR";
		$paramsGrid["source"]["datafields"][$i]["name"]="METODE_BAYAR";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Metode Bayar";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="e.TOTAL";
		$paramsGrid["source"]["datafields"][$i]["name"]="TOTAL";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="Total";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		
		
		
		return $paramsGrid;
	}
	
	
	
	public function addNewData(){
		$params["title"] = "Tambah Data";
		$this->load->helper('erp_wb_helper');
		
		$this->load->library('LookupData');
		$this->sqlLookup01 = "select no_spb as ID, no_spb, vendor_id, vendor_name from Lookup_Vendor_01 where vendor_id not like 'XX' ";
		$this->oraConn = "OS";
		$this->lookupdata->ID="NO_SPB";
		$this->lookupdata->oraConn = $this->oraConn;
		$this->lookupdata->urlData=base_url()."os/pengadaan/M_Tagihan_Vendor/getLookupSPB/";
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtnospb","targetDataField"=>"NO_SPB");
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtvendorid","targetDataField"=>"VENDOR_ID");
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtnamavendor","targetDataField"=>"VENDOR_NAME");
		$this->lookupdata->extraJS[]=array("extraJS"=>" fncChangeDetailData();");
		$this->lookupdata->sql = $this->sqlLookup01;
		$this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
		$this->lookupdata->customParamsGrid["columns"][1]["text"]="SPB";
		$this->lookupdata->customParamsGrid["columns"][2]["text"]="ID Vendor";
		$this->lookupdata->customParamsGrid["columns"][3]["text"]="Nama Vendor";
		$this->lookupdata->customParamsGrid["columns"][1]["width"]="40%";
		$this->lookupdata->customParamsGrid["columns"][2]["width"]="10%";
		$this->lookupdata->customParamsGrid["columns"][3]["width"]="50%";
		$this->lookupdata->customParamsGrid["columns"][2]["hidden"]="true";
		$this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
		
		$params["gridLUSPB"] = genGrid("jqxGridSPB",$this->lookupdata->initGridLookup(),900);
		
		$this->sqlLookup02 = "select id_sistem_bayar, sistem_bayar from tb_sistem_bayar  where id_sistem_bayar not like 'XX' ";
		$this->oraConn = "FN";
		$this->lookupdata->setClearVars();
		$this->lookupdata->ID="ID_SISTEM_BAYAR";
		$this->lookupdata->oraConn = $this->oraConn;
		$this->lookupdata->urlData=base_url()."os/pengadaan/M_Tagihan_Vendor/getLookupSB/";
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtpembayaran","targetDataField"=>"SISTEM_BAYAR");
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtidsistembayar","targetDataField"=>"ID_SISTEM_BAYAR");
		$this->lookupdata->sql = $this->sqlLookup02;
		$this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
		$this->lookupdata->customParamsGrid["columns"][1]["text"]="Pembayaran";
		$this->lookupdata->customParamsGrid["columns"][0]["width"]="40%";
		$this->lookupdata->customParamsGrid["columns"][1]["width"]="60%";
		$params["gridLUSistemBayar"] = genGrid("jqxGridSistemBayar",$this->lookupdata->initGridLookup(),900);
		
		$this->sqlLookup03 = "select id_metode_bayar, metode_bayar from tb_metode_bayar where id_metode_bayar not like 'XX' ";
		$this->oraConn = "FN";
		$this->lookupdata->setClearVars();
		$this->lookupdata->ID="ID_METODE_BAYAR";
		$this->lookupdata->oraConn = $this->oraConn;
		$this->lookupdata->urlData=base_url()."os/pengadaan/M_Tagihan_Vendor/getLookupMB/";
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtmetodebayar","targetDataField"=>"METODE_BAYAR");
		$this->lookupdata->retVal[]=array("destCtrl"=>"txtidmetodebayar","targetDataField"=>"ID_METODE_BAYAR");
		$this->lookupdata->sql = $this->sqlLookup03;
		$this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
		$this->lookupdata->customParamsGrid["columns"][1]["text"]="Metode Bayar";
		$this->lookupdata->customParamsGrid["columns"][0]["width"]="40%";
		$this->lookupdata->customParamsGrid["columns"][1]["width"]="60%";
		$params["gridLUMetodeBayar"] = genGrid("jqxGridMetodeBayar",$this->lookupdata->initGridLookup(),900);
		
		$this->render_view('os/pengadaan/v_m_tagihan_vendor_add', $params);	
		
	}
	
	public function getLookupSPB()
	{
		$this->load->library('LookupData');
		$this->lookupdata->oraConn = "OS";
		$this->lookupdata->sql = "select no_spb, vendor_id, vendor_name from Lookup_Vendor_01 where vendor_id not like 'XX' ";
		
		echo $this->lookupdata->getGridData();
	}
	
	public function getLookupMB()
	{
		$this->load->library('LookupData');
		$this->lookupdata->oraConn = "FN";
		$this->lookupdata->sql = "select id_metode_bayar, metode_bayar from tb_metode_bayar where id_metode_bayar not like 'XX' ";
		
		echo $this->lookupdata->getGridData();
	}
	
	public function getLookupSB()
	{
		$this->load->library('LookupData');
		$this->lookupdata->oraConn = "FN";
		$this->lookupdata->sql = "select id_sistem_bayar, sistem_bayar from tb_sistem_bayar  where id_sistem_bayar not like 'XX'";
		
		echo $this->lookupdata->getGridData();
	}
	
	public function getGridDataDetail($inospb){
		$nospb = str_replace("~","/", $inospb);
		$strRetVal="";
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
		//exit;
        $query="select (no_bapb||kd_material) as ID, no_bapb, to_char(tgl_terima,'DD/MM/YYYY') as tgl_terima, pat_bapb, kd_material, ket_material, vol, harga from bapb_view where no_spb like :filterSPB and vol > 0 ".$where;
		$arrParamData = array("filterSPB"=>$nospb);
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			$totalJumlah = 0; $i=0;
			if($rst->recordCount()>0){
				$strRetVal="<table style='width:100%;' cellpadding=2 cellspacing=2><tr align='center' style='text-align:center;font-size:16px;font-weight:bold;border-bottom:1px solid grey;'><td align='center'>No</td><td align='center'>No BAPB</td><td align='center'>Tgl BAPB</td><td align='center'>Kode Material</td><td align='center'>Ket Material</td><td align='center'>Volume</td><td align='center'>Harga</td><td align='center'>Jumlah</td></tr>";
				while(!$rst->EOF)
				{
					
					$arrData[] = array(
						'ID' =>  $rst->fields["ID"],
						'NO_BAPB' =>  $rst->fields["NO_BAPB"],
						'KD_MATERIAL' =>  $rst->fields["KD_MATERIAL"],
						'KET_MATERIAL' =>  $rst->fields["KET_MATERIAL"],
						'VOL' =>  $rst->fields["VOL"],
						'HARGA' => $rst->fields["HARGA"]
					);	
					
					$nobapb = $rst->fields["NO_BAPB"];
					$tglbapb = $rst->fields["TGL_TERIMA"];
					$kdmaterial = $rst->fields["KD_MATERIAL"];
					$ketmaterial = $rst->fields["KET_MATERIAL"];
					$vol = $rst->fields["VOL"];
					$harsat = $rst->fields["HARGA"];
					$jumlah = $vol * $harsat;
					
					$totalJumlah += $jumlah;
					
					$strCtlSelect="<input type='checkbox' id='chk_".$i."' value='$jumlah' />";
					$strRetVal.="<tr style='border-bottom:1px solid grey;'><td align='center'>".($i+1)."&nbsp; $strCtlSelect</td><td>$nobapb<input type='hidden' id='txtnobapb_$i' value='$nobapb' /></td><td align='center'>$tglbapb<input type='hidden' id='txttglbapb_$i' value='$tglbapb' /></td><td>$kdmaterial<input type='hidden' id='txtkdmaterial_$i' value='$kdmaterial' /></td><td>$ketmaterial</td><td align='right'>$vol<input type='hidden' id='txtvol_$i' value='$vol' /></td><td align='right'>$harsat<input type='hidden' id='txtharsat_$i' value='$harsat' /></td><td align='right'><input  class='clsJumlah' type='text' align='right' style='border:0px; background:transparent;text-align:right' readonly id='txtJumlah_".$i."' value='$jumlah' /></td></tr>";
					$rst->moveNext();
					$i++;
				}
				$strRetVal.="<tr><td colspan=7 align='right'><b>TOTAL</b></td><td align='right'><input id='txtTotalJumlah' type='text' align='right' style='border:0px; background:transparent;text-align:right;font-size:16px;font-weight:bold;' readonly value='$totalJumlah' /></td></tr>";
				$strRetVal.="</table>";
				#$strRetVal.="<script>";
				#for($x=0;$x<i;$x++){
				#	$strRetVal.=" $('#txtJumlah_'".$x.").number( true, 0 );";	
				#}
				#$strRetVal.="</script>";
			}else{
				$total_rows = 0;
				$arrData[] = array(
				'ID' =>  "",
				'NO_BAPB' =>  "",
				'KD_MATERIAL' =>  "",
				'KET_MATERIAL' =>  "",
				'VOL' =>  "",
				'HARGA' => ""
				);
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
				'ID' =>  "",
				'NO_BAPB' =>  "",
				'KD_MATERIAL' =>  "",
				'KET_MATERIAL' =>  "",
				'VOL' =>  "",
				'HARGA' => ""
				);
		}
		//$errMsg = $query;
		
		$data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'RetVal' => $strRetVal,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));
	}
	
	function saveNewData(){
		$data = $_POST;
		$status = "";
		$listOfEM=array();
		//var_dump($data["detil"]);
		$sql="insert into TAGIHAN_SPB_H(NO_TAGIHAN, TGL_TAGIHAN, VENDOR_ID, NO_SPB, KD_PAT, JATUH_TEMPO, ID_SISTEM_BAYAR, ID_METODE_BAYAR, CREATED_BY, CREATED_DATE) values (";
		$sql.="'".$data["no_tagihan"]."'";
		$sql.=",TO_DATE('".$data["tgl_tagihan"]."','DD/MM/YYYY')";
		$sql.=",'".$data["vendor_id"]."'";
		$sql.=",'".$data["no_spb"]."'";
		$sql.=",'0A'";
		$sql.=",'".$data["jatuh_tempo"]."'";
		$sql.=",'".$data["id_sistem_bayar"]."'";
		$sql.=",'".$data["id_metode_bayar"]."'";
		$sql.=",'WB040034'";
		$sql.=",SYSDATE";
		$sql.=")";
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");	
		$rst=$conn->Execute($sql);
		if(!$rst)
		{
			$status="ERROR";
			$listOfEM[]=array("HEADER" => $conn->ErrorMsg(), "SQL"=>$sql);
		}else{
			foreach($data["detil"] as $key=>$value)
			{
				//var_dump($value);
				$sql="insert into TAGIHAN_SPB_D1(no_tagihan, no_spb, no_bapb, tgl_bapb, kd_material, vol, harsat, harga) values (";
				$sql.="'".$data["no_tagihan"]."'";
				$sql.=",'".$data["no_spb"]."'";
				$sql.=",'".$value["no_bapb"]."'";
				$sql.=",TO_DATE('".$value["tgl_bapb"]."','DD/MM/YYYY')";
				$sql.=",'".$value["kd_material"]."'";
				$sql.=",'".$value["vol"]."'";
				$sql.=",'".$value["harsat"]."'";
				$sql.=",'".$value["jumlah"]."'";
				$sql.=")";
				$rst=$conn->Execute($sql);
				if(!$rst)
				{
					$status="ERROR";
					$listOfEM[]=array("DETIL" => $conn->ErrorMsg());
				}
			}
		}
		
		if(empty($listOfEM))
		{
			$status="BERHASIL";
		}
		$data=array("STATUS"=>$status, "LISTOFEM"=>$listOfEM);
		print_r(json_encode($data,JSON_PRETTY_PRINT));
		
	}
	
    public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;

		//exit;
        $query="select a.no_spb, a.no_tagihan, a.vendor_id, b.nama as vendor_name, a.jatuh_tempo, c.sistem_bayar, d.metode_bayar, sum(e.harga) as total from tagihan_spb_h a inner join vendor b on a.vendor_id=b.vendor_id inner join wfinance.tb_sistem_bayar c on c.id_sistem_bayar=a.id_sistem_bayar inner join wfinance.tb_metode_bayar d on d.id_metode_bayar=a.id_metode_bayar inner join tagihan_spb_d1 e on e.no_tagihan=a.no_tagihan ".$where." group by a.no_spb, a.no_tagihan, a.vendor_id, b.nama, a.jatuh_tempo, c.sistem_bayar, d.metode_bayar";
		$arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
						'ID' =>  $rst->fields["NO_TAGIHAN"],
						'NO_TAGIHAN' =>  $rst->fields["NO_TAGIHAN"],
						'NO_SPB' =>  $rst->fields["NO_SPB"],
						'VENDOR_ID' =>  $rst->fields["VENDOR_ID"],
						'VENDOR_NAME' =>  $rst->fields["VENDOR_NAME"],
						'JATUH_TEMPO' => $rst->fields["JATUH_TEMPO"],
						'SISTEM_BAYAR' => $rst->fields["SISTEM_BAYAR"],
						'METODE_BAYAR' => $rst->fields["METODE_BAYAR"],
						'TOTAL' => $rst->fields["TOTAL"]
					);	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
				'ID' =>  "",
				'NO_TAGIHAN' =>  "",
				'NO_SPB' =>  "",
				'VENDOR_ID' =>  "",
				'VENDOR_NAME' =>  "",
				'JATUH_TEMPO' => "",
				'SISTEM_BAYAR' => "",
				'METODE_BAYAR' => "",
				'TOTAL'=>0
				);
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
				'ID' =>  "",
				'NO_TAGIHAN' =>  "",
				'NO_SPB' =>  "",
				'VENDOR_ID' =>  "",
				'VENDOR_NAME' =>  "",
				'JATUH_TEMPO' => "",
				'SISTEM_BAYAR' => "",
				'METODE_BAYAR' => "",
				'TOTAL'=>0
				);
		}
		//$errMsg = $query;
		
		$data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }    
    
    
}
