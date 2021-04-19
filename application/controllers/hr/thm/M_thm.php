<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Thm extends CI_Controller {
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
		$ivalue="11";
		if(isset($_GET["ivalue"]))$ivalue = $_GET["ivalue"];
		$this->ivalue = $ivalue;
		$params["grid"] = $this->initGrid();
		$this->render_view('hr/thm/v_m_thm_list', $params);
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
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KD_PAT";
		$paramsGrid["source"]["datafields"][$i]["name"]="KD_PAT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Kode UK";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.BL";
		$paramsGrid["source"]["datafields"][$i]["name"]="BL";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Periode";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NO_KTP";
		$paramsGrid["source"]["datafields"][$i]["name"]="NO_KTP";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="No KTP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["hidden"]="false";
	
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NAMA_THM";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA_THM";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama THM";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["cellsalign"]="left";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.JHK";
		$paramsGrid["source"]["datafields"][$i]["name"]="JHK";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="J H K";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.UPAH";
		$paramsGrid["source"]["datafields"][$i]["name"]="UPAH";
		$paramsGrid["source"]["datafields"][$i]["type"]="number";
		$paramsGrid["columns"][$i]["text"]="UPAH";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsformat"]="d";
		$paramsGrid["columns"][$i]["cellsalign"]="right";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["name"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="FLAG_DATA";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="1%";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		return $paramsGrid;
	}
	
	
	public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";$ithn=Date("Y");$filterJTrans="0";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
		
		if(isset($_GET["ithn"]))$ithn = $_GET["ithn"];
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
		
        $query="select (a.bl||a.no_ktp) as ID, a.bl, a.kd_pat, a.no_ktp, a.nama_thm, a.tgl_masuk, a.jhk, a.upah, a.no_ktp_mandor from hrms.absensi_thm a where a.kd_pat like :filterkdpat and a.bl like :filterbl ";
		$arrParamData = array("filterkdpat"=>"2%", "filterbl"=>"__".$ithn);
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
						'ID' =>  $rst->fields["ID"],
						'KD_PAT' =>  $rst->fields["KD_PAT"],
						'BL' =>  $rst->fields["BL"],
						'NO_KTP' =>  $rst->fields["NO_KTP"],
						'NAMA_THM' => $rst->fields["NAMA_THM"],
						'TGL_MASUK' => $rst->fields["TGL_MASUK"],
						'JHK' => $rst->fields["JHK"],
						'UPAH' => $rst->fields["UPAH"],
						'NO_KTP_MANDOR' => $rst->fields["NO_KTP_MANDOR"],
						'FLAG_DATA' => "0"
					);	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
					'ID' => "",
					'KD_PAT' => "",
					'BL' => "",
					'NO_KTP' => "",
					'NAMA_THM' => "",
					'TGL_MASUK' => "",
					'JHK' => "",
					'UPAH' => "",
					'NO_KTP_MANDOR' => "",
					'FLAG_DATA'=>'0'
				);
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
				'ID' => "",
				'KD_PAT' => "",
				'BL' => "",
				'NO_KTP' => "",
				'NAMA_THM' => "",
				'TGL_MASUK' => "",
				'JHK' => "",
				'UPAH' => "",
				'NO_KTP_MANDOR' => "",
				'FLAG_DATA'=>'0'
				);
		
				$errMsg = $conn->ErrorMsg();
		}
		/*
		$strExcel="<html><body><table>";
		$strExcel.="<tr style='border-bottom:1px solid black;font-weight:bold;vertical-align:top;align:center;text-align:center;'>";
		$strExcel.="<td>Tahun</td>";
		$strExcel.="<td>Kode PAT</td>";
		$strExcel.="<td>NO KTP</td>";
		$strExcel.="<td>NAMA THM</td>";
		$strExcel.="<td>TGL MASUK</td>";
		$strExcel.="<td>J H K</td>";
		$strExcel.="<td>UPAH</td>";
		$strExcel.="</tr>";
		foreach($arrData as $key=>$value)
		{
			$strExcel.="<tr style='vertical-align:top;align:center;text-align:center;'>";
			$strExcel.="<td>$thn</td>";
			$strExcel.="<td>".$value["KD_SBU"]."</td>";
			$strExcel.="<td>".$value["SBU"]."</td>";
			$strExcel.="<td>".$value["SUB_SBU"]."</td>";
			$strExcel.="<td style='text-align:left;'>".$value["PRODUK"]."</td>";
			$strExcel.="<td>".$value["KD_PAT"]."</td>";
			$strExcel.="<td>".$value["PAT_TO"]."</td>";
			$strExcel.="<td>".$value["NO_NPP"]."</td>";
			$strExcel.="<td style='text-align:left;'>".$value["NO_SPPRB"]."</td>";
			$strExcel.="<td style='text-align:right;'>".$value["PESANAN"]."</td>";
			$strExcel.="<td style='text-align:right;'>".$value["PRODUKSI"]."</td>";
			$strExcel.="<td style='text-align:right;'>".$value["DISTRIBUSI"]."</td>";
			$strExcel.="<td style='text-align:right;'>".$value["STOCK"]."</td>";
			$strExcel.="</tr>";
		}
		$strExcel.="</table></body></html>";
		
		$strFileName = "exp-data-mon-pj-tl-".microtime(false);
		$strFileName = str_replace(" ","-",$strFileName);
		$strFileName = str_replace(".","-",$strFileName);
		$strFileName.=".xls";
		
		$strRootPath = "/wwwroot/php5/erp-ci/";
		//$strRootPath = "c://xampp/htdocs/erp-ci/";
		
		$strFolder = "data_uploads/";
		$strPath = $strRootPath.$strFolder.$strFileName;
		
		$myfile = fopen($strPath, "w") or die("Can't create file");
		fwrite($myfile, $strExcel);
		fclose($myfile);
		*/
		
		
		$data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
		
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }   
	
	
	
	
     
    
    
}
