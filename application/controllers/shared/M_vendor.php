<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_vendor extends CI_Controller {
	/**
	 * Copyright
	 * WASE
	 * Februari 2018
	 */
	public function __construct(){
        parent::__construct();
       // $this->auth();
        $this->load->helper('download');
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

    public function index(){
        $this->contentManagement();
    }
   
    public function contentManagement(){
		$params["title"]="Daftar Vendor";
		$params["grid"] = $this->initGrid();
		$this->render_view('shared/vendor/v_m_vendor_list', $params);
    }
	
	public function formEdit(){
		
	}

	public function initGrid(){
		$paramsGrid["source"]["ID"] = "VENDOR_ID";
		
		//SET ID TO HIDE
		//MUST BE ON FIRST COLUMN , SET ID TO PRIMARY KEY
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
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.VENDOR_ID";
		$paramsGrid["source"]["datafields"][$i]["name"]="VENDOR_ID";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="ID";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="4%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NAMA";
		$paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Nama Vendor";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
	
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.NPWP";
		$paramsGrid["source"]["datafields"][$i]["name"]="NPWP";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="NPWP";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="decode(a.berelasi,'0','Tidak','1','Ya')";
		$paramsGrid["source"]["datafields"][$i]["name"]="BERELASI";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Berelasi";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="5%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.ALAMAT";
		$paramsGrid["source"]["datafields"][$i]["name"]="ALAMAT";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Alamat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.CONTACT_PERSON";
		$paramsGrid["source"]["datafields"][$i]["name"]="CONTACT_PERSON";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="PIC";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="20%";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.CREATED_DATE";
		$paramsGrid["source"]["datafields"][$i]["name"]="CREATED_DATE";
		$paramsGrid["source"]["datafields"][$i]["type"]="date";
		$paramsGrid["columns"][$i]["text"]="Tgl Buat";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="10%";
		$paramsGrid["columns"][$i]["cellsformat"]="dd-MM-yyyy";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="false";
		
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["name"]="FLAG_DATA";
		$paramsGrid["source"]["datafields"][$i]["type"]="string";
		$paramsGrid["columns"][$i]["text"]="Flag Data";
		$paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
		$paramsGrid["columns"][$i]["width"]="3%";
		$paramsGrid["columns"][$i]["cellsalign"]="center";
		$paramsGrid["columns"][$i]["hidden"]="true";
		
		//Actions Columns
		//Actions
		$i++;
		$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="";
		$paramsGrid["source"]["datafields"][$i]["name"]="";
		$paramsGrid["source"]["datafields"][$i]["type"]="";
		$paramsGrid["columns"][$i]["text"]="Actions";
		$paramsGrid["columns"][$i]["datafield"]="id";
		$paramsGrid["columns"][$i]["width"]="8%";
		$paramsGrid["columns"][$i]["filterable"]="false";
		$paramsGrid["columns"][$i]["sortable"]="false";
		$paramsGrid["columns"][$i]["cellsrenderer"]="renderer";
		
		
		return $paramsGrid;
	}
	
	public function addNewData(){
		$params["title"]="Tambah Vendor";
		
		$i=0;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="NAMA_VENDOR";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="Nama Vendor";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="ALAMAT";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="Alamat";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="TELP";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="No Telp";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="FAX";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="No Fax";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="KOTA";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="Kota";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="CONTACT_PERSON";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="PIC/ Contact Person";
		$params["FORMS"][$i]["INPUT"]["TYPE"]="text";
		
		$i++;
		$params["FORMS"][$i]["INPUT"]["DBFIELD"]="BERELASI";
		$params["FORMS"][$i]["INPUT"]["LABEL"]="Berelasi";
		
		$this->render_view('shared/vendor/v_m_vendor_add', $params);	
	}
	
	public function getVendorLookup(){
		
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getoraconn();
		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"])){
			$where = genJQWFilterSQL($this->initGrid()) ;
		}
	
		$searchQuery = "{$_GET['query']}%";
		//exit;
        $query="select vendor_id, trim(nama) as nama from vendor where UPPER(trim(nama)) like UPPER(:NAMA) order by nama asc";
		$arrParamData=array("NAMA"=>$searchQuery);
		$rst=$conn->PageExecute($query,100,1, $arrParamData);
		if($rst)
		{
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
						'VENDOR_ID' =>  $rst->fields["VENDOR_ID"],
						'NAMA' =>  $rst->fields["NAMA"]
					);	
					
					$rst->moveNext();
				}
			}else{
				$arrData = array(
						'VENDOR_ID' =>  "",
						'NAMA' => ""
					);		
			}
		}else{
			$arrData = array(
						'VENDOR_ID' =>  "",
						'NAMA' =>  ""
					);	
		}

		
		echo json_encode($arrData);

    }
	
    public function getVendor(){
		$errMsg = "";
		$recPerPage = 10;
		$currPage = 1;
		$where = "";
		
		if(isset($_GET["pagenum"]))
		{
			$currPage = intval($_GET["pagenum"])+1;
		}
		
		if(isset($_GET["pagesize"]))
		{
			$recPerPage = intval($_GET["pagesize"]);
		}
		
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getoraconn();
		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"])){
			$where = genJQWFilterSQL($this->initGrid()) ;
		}
		
		//var_dump($where);
		
		//exit;
        $query="select a.vendor_id as ID, a.vendor_id, trim(a.nama) as nama, a.npwp, decode(a.berelasi,'0','Tidak','1','Ya') as berelasi, a.alamat, a.contact_person, a.created_date, round(dbms_random.value(0,1),0) as flag_data from vendor a where a.nama like :nama ".$where;
		$arrParamData = array("nama"=>"%");
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
						'ID' =>  $rst->fields["VENDOR_ID"],
						'VENDOR_ID' =>  $rst->fields["VENDOR_ID"],
						'NAMA' =>  $rst->fields["NAMA"],
						'NPWP' => $rst->fields["NPWP"],
						'BERELASI' => $rst->fields["BERELASI"],
						'ALAMAT' => $rst->fields["ALAMAT"],
						'CONTACT_PERSON' => $rst->fields["CONTACT_PERSON"],
						'CREATED_DATE' => $rst->fields["CREATED_DATE"],
						'FLAG_DATA' => $rst->fields["FLAG_DATA"]
					);	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
					'ID' => '',
					'VENDOR_ID' =>  "",
					'NAMA' =>  "",
					'NPWP' => "",
					'BERELASI' => "",
					'ALAMAT' => "",
					'CONTACT_PERSON' => "",
					'CREATED_DATE' => "",
					'FLAG_DATA' => ""
				);	
			}
		}else{
			$arrData[] = array(
				'ID' => '',
				'VENDOR_ID' =>  "",
				'NAMA' =>  "",
				'NPWP' => "",
				'BERELASI' => "",
				'ALAMAT' => "",
				'CONTACT_PERSON' => "",
				'CREATED_DATE' => "",
				'FLAG_DATA' => ""
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
