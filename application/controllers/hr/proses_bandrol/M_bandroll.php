<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_bandroll extends CI_Controller {
	/**
	 * Copyright
	 * 
	 * April 2018
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
		$params["title"]="Proses Bandroll";
		$params["grid"] = $this->initGrid();
		$this->render_view('hr/bandroll/v_bandroll', $params);
    }
    public function initGrid(){
            $paramsGrid["source"]["ID"] = "TIMERECORD";
            $i=0;
            //Actions Columns
            //Actions
            //$i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="";
            $paramsGrid["source"]["datafields"][$i]["name"]="";
            $paramsGrid["source"]["datafields"][$i]["type"]="";
            $paramsGrid["columns"][$i]["text"]="";
            $paramsGrid["columns"][$i]["datafield"]="id";
            $paramsGrid["columns"][$i]["width"]="100";
            $paramsGrid["columns"][$i]["filterable"]="false";
            $paramsGrid["columns"][$i]["sortable"]="false";
            $paramsGrid["columns"][$i]["cellsrenderer"]="renderer";
            //SET ID TO HIDE
            //MUST BE ON FIRST COLUMN , SET ID TO PRIMARY KEY
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="BL";
            $paramsGrid["source"]["datafields"][$i]["name"]="BL";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="PERIODE";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="5%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="TANGGAL";
            $paramsGrid["source"]["datafields"][$i]["name"]="TANGGAL";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="PERIODE";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="20%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="TOT";
            $paramsGrid["source"]["datafields"][$i]["name"]="TOT";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="STATUS";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="10%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
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
    //-------------------------------------
    public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;

		//exit;
       $query="select BL,TOT,TANGGAL from (
                select a.BL,  concat( (a.p1+a.p2+a.p3+a.p4+a.p5)/5*100,' %') TOT,concat( concat(b.tgl_mulai,' s/d '),b.tgl_akhir)TANGGAL
                ,b.TGL_MULAI from hrms.p_gaji_h a 
                inner join hrms.master_bandroll b on a.BL=b.BL
                ) data
                where TGL_MULAI is not null ".$where." order by substr(BL,3)desc,substr(BL,0,2) desc ";                
        
                $arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
                                               'ID' =>  $rst->fields["BL"],
                                                'BL' =>  $rst->fields["BL"],
                                                'TOT' =>  $rst->fields["TOT"],
                                                'TANGGAL' =>  $rst->fields["TANGGAL"],
                                                'FLAG_DATA' => "0"
                                            );	
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
                                $arrData[] = array(
                                        'ID' =>  $rst->fields["BL"],
                                        'BL' =>  $rst->fields["BL"],
                                        'TOT' =>  $rst->fields["TOT"],
                                        'TANGGAL' =>  $rst->fields["TANGGAL"],
                                        'FLAG_DATA' => "0"
                                    );
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
                                        'ID' =>  '',
                                        'BL' =>  '',
                                        'TOT' => '',
                                        'TANGGAL' =>  '',
                                        'FLAG_DATA' =>  '0'
                                    );
		}
		//$errMsg = $query;
		
		$data[] = array(
                   'where' => $where,
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }    
    //--------------------------------------
     public function getProses(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        
        
        $this->session->set_flashdata('message','Berhasil Proses Bandrol Periode : '.$data);
        $params=array('pesan'=>'sukses'); 
    }
 public function getCabut(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        
        
        $this->session->set_flashdata('message','Berhasil Proses Cabut Bandrol Periode : '.$data);
        $params=array('pesan'=>'sukses'); 
    }
   
    
    
    
}
