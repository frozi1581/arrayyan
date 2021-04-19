<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_index extends CI_Controller {
	/**
	 * Copyright
	 * Auth:WaSe
	 * Agst 2018
	 */
	 
	var $oraConn = "HR";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
	
	public function __construct(){
        parent::__construct();
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    	
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
    public function initGrid(){
            $paramsGrid["source"]["ID"] = "ID";
            $i=0;
            //Actions Columns
            //Actions
            //SET ID TO HIDE
            //MUST BE ON FIRST COLUMN , SET ID TO PRIMARY KEY
            //$i=0;
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="BL";
            $paramsGrid["source"]["datafields"][$i]["name"]="BL";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="BL";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="8%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ST_DATE";
            $paramsGrid["source"]["datafields"][$i]["name"]="ST_DATE";
            $paramsGrid["source"]["datafields"][$i]["type"]="date";
            $paramsGrid["columns"][$i]["text"]="TGL. MULAI PENILAIAN";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="20%";
            $paramsGrid["columns"][$i]["cellsformat"]="dd/MM/yyyy";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="END_DATE";
            $paramsGrid["source"]["datafields"][$i]["name"]="END_DATE";
            $paramsGrid["source"]["datafields"][$i]["type"]="date";
            $paramsGrid["columns"][$i]["text"]="TGL. SELESAI PENILAIAN";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="20%";
            $paramsGrid["columns"][$i]["cellsformat"]="dd/MM/yyyy";
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
    public function getGridData(){
		$errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
	     	if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;
                $query="select bl,to_char(st_date,'dd/mm/yyyy')st_date,to_char(end_date,'dd/mm/yyyy')end_date
                        from kbi_h where bl is not null ".$where;
                $arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{	$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
                                            'BL' =>  $rst->fields["BL"],
                                            'ST_DATE' =>  $rst->fields["ST_DATE"],
                                            'END_DATE' =>  $rst->fields["END_DATE"],
                                            'FLAG_DATA' => "0"
                                            );	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
                                        'BL' => '',
                                        'ST_DATE' =>  '',
                                        'END_DATE' =>  '',
                                        'FLAG_DATA' => "0"
                                    );
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
                                    'BL' => '',
                                    'ST_DATE' =>  '',
                                    'END_DATE' =>  '',
                                    'FLAG_DATA' => "0"
                                    );
		}
		//$errMsg = $query;
		
		$data[] = array(
                   'where' => $where,
		   'TotalRows' => $total_rows,
                   'arrData'=>$arrData,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }
    public function cekPeriode(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        //$conn = $this->adodbconn->getOraConn("HR");		
	$sql = "select BL from hrms.kbi_h 
                where bl='".trim($data)."'";
        if($this->db->query($sql)->num_rows()>0){
            $cek="1";
        }else{$cek="0";}
        $params=array('cek'=>$cek); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));
  
    }
    public function f_addHeader(){
        $BL = $_POST['txtBL'];
        $ST_DATE = $_POST['txtST_DATE'];
        $END_DATE = $_POST['txtEND_DATE'];
        $create_by='WASE';                     //----------- ambil dari login
        $tgl_create=date("Y-m-d H:i:s");
    		
        //to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss')
        $sql="insert into hrms.kbi_h(bl,st_date,end_date,created_by) values('".$BL."',to_date('".$ST_DATE."','dd/mm/yyyy'),
               to_date('".$END_DATE."','dd/mm/yyyy'),'".$create_by."')";
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Tambah Header  ['.$BL."] ");    
        $params=array('pesan'=>'sukses'); 
        $this->contentManagement();  
    }
    public function contentManagement(){
		$params["title"]="KBI (Key Behaviour Indicator)";
		$params["grid"] = $this->initGrid();
                $params["DDListIsMan"][0] = array("id"=>'0', "status"=>'Non Manager');$params["DDListIsMan"][1] = array("id"=>'1', "status"=>'Manager');
                $this->render_view('hr/kbi/v_list', $params);
    }
    public  function initGridL(){
        $paramsGrid["source"]["ID"] = "ID";
        $i=0;
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="EMPLOYEE_ID";
        $paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="NIP";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="7%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="EMPLOYEE_NAME";
        $paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_NAME";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="NAMA PEGAWAI";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="22%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ESELON";
        $paramsGrid["source"]["datafields"][$i]["name"]="ESELON";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="ESELON";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="6%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="UNIT_KERJA";
        $paramsGrid["source"]["datafields"][$i]["name"]="UNIT_KERJA";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="UNIT KERJA";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="25%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="BAGIAN";
        $paramsGrid["source"]["datafields"][$i]["name"]="BAGIAN";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="UNIT BAGIAN";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="25%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="IS_MANAGER";
        $paramsGrid["source"]["datafields"][$i]["name"]="IS_MANAGER";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="STATUS";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="8%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="true";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="STATUS_RESPON";
        $paramsGrid["source"]["datafields"][$i]["name"]="STATUS_RESPON";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="RESPON";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="6%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["cellsrenderer"]="renderVAL";
	$paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="APP";
        $paramsGrid["source"]["datafields"][$i]["name"]="APP";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="APPROVE";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="8%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["cellsrenderer"]="renderAPP";
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
    public function getGridDataEdit($params="get"){
                $errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
               //   $json      = $_POST['json']; 
             //   $json      = utf8_encode($_POST['json']); // Don't forget the encoding
             //   $params      = json_decode($json);
               $a_params= explode('_', $params);
                
                $periode='';
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
                $this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		$query2='';
	     	if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridL()) ;
          
               $query="select EMPLOYEE_ID,EMPLOYEE_NAME,ESELON,UNIT_KERJA,BAGIAN,IS_MANAGER,STATUS_RESPON,APP from(
                        SELECT a.bl,a.st_date,a.end_date,a.employee_id,
                        trim (first_title||' '||first_name||' '||last_name||' '||last_title)employee_name,
                        b.eselon,c.ket unit_kerja,d.ket bagian,is_manager,0 status_respon,app1 APP
                         FROM hrms.KBI_D a
                        inner join hrms.personal b on a.employee_id = b.employee_id
                        inner join hrms.tb_pat c on b.kd_pat=c.kd_pat
                        inner join hrms.tb_gas d on b.kd_gas=d.kd_gas
                        left join hrms.tb_jbt e on b.kd_jbt=e.kd_jbt
                        )src where BL='".$a_params[0]."' and to_char(st_date,'dd-mm-yyyy')='".$a_params[1]."' and  to_char(end_date,'dd-mm-yyyy')='".$a_params[2]."'   ".$where;
             
                $arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
                if($rst)
		{	$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
                                            'EMPLOYEE_ID' =>  $rst->fields["EMPLOYEE_ID"],
                                            'EMPLOYEE_NAME' =>   $rst->fields["EMPLOYEE_NAME"],
                                            'ESELON' =>  $rst->fields["ESELON"],
                                            'UNIT_KERJA' =>  $rst->fields["UNIT_KERJA"],
                                            'BAGIAN' =>  $rst->fields["BAGIAN"],
                                            'IS_MANAGER' =>  $rst->fields["IS_MANAGER"],
                                            'STATUS_RESPON' =>  $rst->fields["STATUS_RESPON"],
                                            'APP' =>  $rst->fields["APP"],
                                            'FLAG_DATA' => "0"
                                            );	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
                                        'EMPLOYEE_ID' =>  '',
                                        'EMPLOYEE_NAME' =>  '',
                                        'ESELON' => '',
                                        'UNIT_KERJA' => '',
                                        'BAGIAN' => '',
                                        'IS_MANAGER' => '',
                                        'STATUS_RESPON' => '',
                                        'APP' => '',
                                        'FLAG_DATA' => "0"
                                    );
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
                                    'EMPLOYEE_ID' =>  '',
                                    'EMPLOYEE_NAME' =>  '',
                                    'ESELON' => '',
                                    'UNIT_KERJA' => '',
                                    'BAGIAN' => '',
                                    'IS_MANAGER' => '',
                                    'STATUS_RESPON' => '',
                                    'APP' => '',
                                    'FLAG_DATA' => "0"
                                    );
		}
		//$errMsg = $query;
		
		$data[] = array(
                   'where' => $where,
                   'query' => $query,
                   // 'params' => $params,
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }
    public function editData(){
        $key = $_GET["recId"];
        $DATA = explode("*", $key);
        $params["title"]="Edit Data Penilaian";
        $params["grid"] = $this->initGridL();
        $params["BL"]=$DATA[0];
        $params["ST_DATE"]=$DATA[1];
        $params["END_DATE"]=$DATA[2];
       // IF($DATA[5]==='1'){$params["APP"]='Approved';}else{$params["APP"]='Not Approve';}
        //-------------------------------------- lookup NIP ---------------------------------------------------
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup02 = "select employee_id ID, employee_id, 
            trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama,eselon,b.ket unit_kerja,c.ket bagian,d.ket jabatan,
            a.kd_pat,a.kd_gas,a.kd_jbt
            from hrms.personal a
            inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
            inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
            left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
            where a.st=1 and instr(employee_id,'TX')<1  and instr(employee_id,'TH')<1 
            and (a.kd_pat='0A' or substr(a.kd_pat,0,1)=1 or substr(a.kd_pat,0,1)=2)
            and eselon=6
            order by a.kd_pat,a.kd_gas,a.eselon
            ";
        $this->oraConn = "HR";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."hr/kbi/M_index/getLookupNIP/";//.$params["KD_PAT"];
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtknip","targetDataField"=>"EMPLOYEE_ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama","targetDataField"=>"NAMA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txteselon","targetDataField"=>"ESELON");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtunit_kerja","targetDataField"=>"UNIT_KERJA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtbagian","targetDataField"=>"BAGIAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtjabatan","targetDataField"=>"JABATAN");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    
        $this->lookupdata->sql = $this->sqlLookup02;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NAMA PEGAWAI";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="ESELON";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="UNIT KERJA";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="BAGIAN";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="JABATAN";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="23%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="8%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="12%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="25%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        $params["gridLUNIP"] = 'Daftar Pegawai';
        $params["gridLUNIP"]  = genGrid("jqxGridNIP",$this->lookupdata->initGridLookup(),false,1150);
        //-------------------------------------------------------------------------------------------------------
        $params["DDListIsMan"][0] = array("id"=>'0', "status"=>'Non Manager');$params["DDListIsMan"][1] = array("id"=>'1', "status"=>'Manager');
      $this->render_view('hr/kbi/v_edit', $params);
    }
    public function V_SOAL(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        
        $sql="select max( bl)bl ,kp_id,ik_id,max( to_char( st_date,'dd/mm/yyyy'))st_date,max( to_char( end_date,'dd/mm/yyyy')   )end_date,max(employee_id)employee_id,
                max(nama_dinilai)nama_dinilai,       max(jenis_kriteria_penilaian)jenis_kriteria_penilaian,
                max(kriteria_penilaian)kriteria_penilaian,
                max(ik_text)ik_text
                from(
                select a.bl,a.st_date,a.end_date,a.employee_id,a.kp_id,  trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama_dinilai ,c.kriteria_penilaian,   c.jenis_kriteria_penilaian,d.ik_id ,d.no_urut_ik,d.ik_text 
                from hrms.kbi_kp_ik a inner join hrms.personal b on a.employee_id=b.employee_id 
                inner join hrms.kbi_kp_h c on c.kp_id=a.kp_id 
                inner join hrms.kbi_kp_d d on d.tgl_berlaku=c.tgl_berlaku and d.is_manager=c.is_manager and c.no_urut=d.no_urut 
                where a.employee_id='".$data[3]."' and a.bl='".$data[0]."' and 
                ( to_date('".$data[1]."','dd-mm-yyyy') = st_date AND to_date('".$data[2]."','dd-mm-yyyy') = end_date) order by a.employee_id,c.no_urut,d.no_urut_ik
                )s group by kp_id,ik_id order by kp_id";
        $arrParamData=array();
        $getData = $this->db->query($sql)->result_array();
        $params["isi"] =$this->db->query($sql)->num_rows();
        if($this->db->query($sql)->num_rows()>0){
            $kp_id='';
            foreach ($getData as $row){
                $params["isi"] = $getData;
                $BL=$row["BL"];
                $ST_DATE=$row["ST_DATE"];
                $END_DATE=$row["END_DATE"];
                $NAMA_DINILAI=$row["NAMA_DINILAI"];
                $EMPLOYEE_ID_DINILAI=$row["EMPLOYEE_ID"];
                
                if($kp_id<>$row["KP_ID"]){
                   if(isset($arrSoal)){
                         $arrMasterFromDB['GET_SOAL'][]=array("status"=>true,
                                "BL"=>$row["BL"],
                                "ST_DATE"=>$row["ST_DATE"], "END_DATE"=>$row["END_DATE"],
                                "NAMA_DINILAI"=>$row["NAMA_DINILAI"],"EMPLOYEE_ID_DINILAI"=>$row["EMPLOYEE_ID"],
                                "KP_ID"=>$kp_id,
                                "JNS_KRITERIA_NILAI"=>$jenis_kriteria_penilaian,
                                "KRITERIA_NILAI"=>$kriteria_penilaian,
                               "SOAL"=>$arrSoal
                                );
                    }
                    $kp_id=$row["KP_ID"];
                    $jenis_kriteria_penilaian=$row["JENIS_KRITERIA_PENILAIAN"];
                    $kriteria_penilaian=$row["KRITERIA_PENILAIAN"];
                    $arrSoal = array();
                }
                array_push($arrSoal,$row["IK_TEXT"]);
              //  $arrSoal[]=$row["IK_ID"].'^'.$row["IK_TEXT"];
            }
            $arrMasterFromDB['GET_SOAL'][]=array("status"=>true,
                                "BL"=>$row["BL"],
                                "ST_DATE"=>$row["ST_DATE"], "END_DATE"=>$row["END_DATE"],
                                "NAMA_DINILAI"=>$row["NAMA_DINILAI"],"EMPLOYEE_ID_DINILAI"=>$row["EMPLOYEE_ID"],
                                "KP_ID"=>$kp_id,
                                "JNS_KRITERIA_NILAI"=>$jenis_kriteria_penilaian,
                                "KRITERIA_NILAI"=>$kriteria_penilaian,
                               "SOAL"=>$arrSoal
                                );
            
        }
      
               print_r(json_encode($arrMasterFromDB,JSON_PRETTY_PRINT));

     //   print_r(json_encode($arrMasterFromDB,JSON_PRETTY_PRINT));

    }
    public function  DELETE_PESERTA(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $sql="delete from hrms.kbi_d where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
            . "end_date=to_date('".$data[2]."','dd/mm/yyyy') and employee_id='".$data[3]."'";
        $result = $this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Hapus Peserta  NIP:'.$data[3]);  
        $params=array('pesan'=>'Berhasil'); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));

    }
    public function  APPROVE(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $user='WASE';                     //----------- ambil dari login
        $curr_date = date("Y-m-d H:i:s"); 
        $sql_m1="";$sql_m2="";
       $mysql_db=$this->load->database('hcis',true);//connected with mysql
    
        $sqlx="update hrms.kbi_d set last_update_by='".$user."' ,last_update_date=to_date('".$curr_date."','yyyy/mm/dd hh24:mi:ss'),"
                . "app1='1',app1_by='".$user."',app1_date=to_date('".$curr_date."','yyyy/mm/dd hh24:mi:ss')  where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
            . "end_date=to_date('".$data[2]."','dd/mm/yyyy') and employee_id='".$data[3]."'";
        $result = $this->db->query($sqlx);
        //------------------------------------------------------- update kbi_h -----------------------------------------------------------
        $sql="select bl,to_char(st_date,'dd/mm/yyyy')st_date,to_char(end_date,'dd/mm/yyyy')end_date,created_by,to_char(created_date,'dd/mm/yyyy hh24:mi:ss')created_date,last_update_by,to_char(last_update_date,'dd/mm/yyyy hh24:mi:ss')last_update_date from  hrms.kbi_h where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
          . "end_date=to_date('".$data[2]."','dd/mm/yyyy') ";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
           $sql_m1="select bl from kbi_h where bl=  '".$row['BL']."' and st_date=str_to_date('".$row['ST_DATE']."','%d/%m/%Y') and 
                    end_date=str_to_date('".$row['END_DATE']."','%d/%m/%Y')"; 
            if($mysql_db->query($sql_m1)->num_rows()<1){
                $sql_m1="insert into kbi_h(bl,st_date,end_date,created_by,created_date) values('"
                    . $row['BL']."',str_to_date('".$row['ST_DATE']."','%d/%m/%Y'),str_to_date('".$row['END_DATE']."','%d/%m/%Y'),'".$row['CREATED_BY']."',"
                    . "str_to_date('".$row['CREATED_DATE']."','%d/%m/%Y %H%i%s'))";
                $mysql_db->query($sql_m1);
            }
        }
        //------------------------------------------------------- update kbi_d -----------------------------------------------------------
        $sql="select bl,to_char(st_date,'dd/mm/yyyy')st_date, to_char(end_date,'dd/mm/yyyy')end_date,employee_id,eselon,employee_id_atasan,
                employee_id_peer1,employee_id_peer2,employee_id_sub1,employee_id_sub2,employee_id_sub3,is_manager,
                created_by,to_char(created_date,'dd/mm/yyyy hh24:mi:ss')created_date,last_update_by,to_char(last_update_date,'dd/mm/yyyy hh24:mi:ss')last_update_date,
                app1,to_char(app1_date,'dd/mm/yyyy hh24:mi:ss')app1_date,app1_by
                from  hrms.kbi_d where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
                . "end_date=to_date('".$data[2]."','dd/mm/yyyy') and employee_id='".$data[3]."'";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $sql_m2="select bl from kbi_d where bl='".$row['BL']."' and st_date=str_to_date('".$row['ST_DATE']."','%d/%m/%Y') and end_date=str_to_date('".$row['END_DATE']."','%d/%m/%Y')
                    and employee_id='".$row['EMPLOYEE_ID']."'";
            if($mysql_db->query($sql_m2)->num_rows()<1){
                  $sql_m2="insert into kbi_d(bl,st_date,end_date,employee_id,eselon,employee_id_atasan,employee_id_peer1,employee_id_peer2,"
               . "employee_id_sub1,employee_id_sub2,employee_id_sub3,is_manager,created_by,created_date,last_update_by,"
               . "last_update_date,app1,app1_date,app1_by) values('"
               . $row['BL']."',str_to_date('".$row['ST_DATE']."','%d/%m/%Y'),str_to_date('".$row['END_DATE']."','%d/%m/%Y'),'".$row['EMPLOYEE_ID']."','".$row['ESELON']."','"
               . $row['EMPLOYEE_ID_ATASAN']."','".$row['EMPLOYEE_ID_PEER1']."','".$row['EMPLOYEE_ID_PEER2']."','".$row['EMPLOYEE_ID_SUB1']."','"
               . $row['EMPLOYEE_ID_SUB2']."','".$row['EMPLOYEE_ID_SUB3']."','".$row['IS_MANAGER']."','".$row['CREATED_BY']."',"
                . "str_to_date('".$row['CREATED_DATE']."','%d/%m/%Y %H:%i:%s'),"
                . "'".$row['LAST_UPDATE_BY']."',str_to_date('".$row['LAST_UPDATE_DATE']."','%d/%m/%Y %H:%i:%s'),'"
                 .$row['APP1']."',str_to_date('".$row['APP1_DATE']."','%d/%m/%Y %H:%i:%s'),'".$row['APP1_BY']."')";
               $mysql_db->query($sql_m2);
            }        
       }
        //----------------------------------------------------- update kbi_kp_h -----------------------------------------------------------------------------
        $sql="select to_char(a.tgl_berlaku,'dd/mm/yyyy')tgl_berlaku,a.is_manager,no_urut,jenis_kriteria_penilaian,kriteria_penilaian,
            created_by,to_char(created_date,'dd/mm/yyyy hh24:mm:ss')created_date,last_update_by,
            to_char(last_update_Date,'dd/mm/yyyy hh24:mm:ss')last_update_date,
            kp_id from hrms.kbi_kp_h a
            inner join (select distinct tgl_berlaku,is_manager from hrms.kbi_kp_h where tgl_berlaku<=to_date('".$data[1]."','dd/mm/yyyy') and is_manager='".$data[4]."' order by tgl_berlaku)
            b on a.tgl_berlaku=b.tgl_berlaku and a.is_manager=b.is_manager";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $sql_m2="select kp_id from kbi_kp_h where tgl_berlaku<=str_to_date('".$data[1]."','%d-%m-%Y') and is_manager='".$data[4]."' 
                    and kp_id='".$row['KP_ID']."'";
            if($mysql_db->query($sql_m2)->num_rows()<1){
                $sql_m1="insert into kbi_kp_h(tgl_berlaku,is_manager,no_urut,jenis_kriteria_penilaian,kriteria_penilaian,
                        created_by,created_date,last_update_by,last_update_Date,kp_id
                        ) values(str_to_date('".$row['TGL_BERLAKU']."','%d/%m/%Y'),'".$row['IS_MANAGER']."','"
                       .$row['NO_URUT']."','".$row['JENIS_KRITERIA_PENILAIAN']."','".$row['KRITERIA_PENILAIAN']."','"
                       .$row['CREATED_BY']."',str_to_date('".$row['CREATED_DATE']."','%d/%m/%Y %H:%i:%s'),'"
                       .$row['LAST_UPDATE_BY']."',str_to_date('".$row['LAST_UPDATE_DATE']."','%d/%m/%Y %H:%i:%s'),'".$row['KP_ID']."')" ;   
                $mysql_db->query($sql_m1); 
            }
        }
        //-----------------------------------------------------update kbi_kp_d-----------------------------------------------------------------------------------
       
        $sql="select to_char(a.tgl_berlaku,'dd/mm/yyyy')tgl_berlaku,a.is_manager,no_urut,jenis_kriteria_penilaian,no_urut_ik,ik_text,ik_skor,created_by,to_char(created_date,'dd/mm/yyyy hh24:mm:ss')created_date,
            last_update_by,to_char(last_update_Date,'dd/mm/yyyy hh24:mm:ss')last_update,ik_id from hrms.kbi_kp_d a
            inner join (select distinct tgl_berlaku,is_manager from hrms.kbi_kp_h where tgl_berlaku<=to_date('".$data[1]."','dd/mm/yyyy') and is_manager='".$data[4]."' order by tgl_berlaku)
            b on a.tgl_berlaku=b.tgl_berlaku and a.is_manager=b.is_manager";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $sql_m2="select tgl_berlaku from  kbi_kp_d where tgl_berlaku<=str_to_date('".$data[1]."','%d-%m-%Y')  and  is_manager='".$row['IS_MANAGER']."' "
                  . "and no_urut= '".$row['NO_URUT']."' and no_urut_ik='".$row['NO_URUT_IK']."'  and  ik_id= '".$row['IK_ID']."'   ";
            
            if($mysql_db->query($sql_m2)->num_rows()<1){
                $sql_m2="insert into kbi_kp_d(tgl_berlaku,is_manager,no_urut,jenis_kriteria_penilaian,no_urut_ik,
                   ik_text,ik_skor,created_by,created_date,last_update_by,last_update_date,ik_id) values(str_to_date('".$row['TGL_BERLAKU']."','%d/%m/%Y'),'"
                  .$row['IS_MANAGER']."','".$row['NO_URUT']."','".$row['JENIS_KRITERIA_PENILAIAN']."','".$row['NO_URUT_IK']."','"
                  .$row['IK_TEXT']. "','".$row['IK_SKOR']."','".$row['CREATED_BY']."',str_to_date('".$row['CREATED_DATE']."','%d/%m/%Y %H:%i:%s'),'"
                  .$row['LAST_UPDATE_BY']."',str_to_date('".$row['LAST_UPDATE']."','%d/%m/%Y %H:%i:%s'),'".$row['IK_ID']."')";
                $mysql_db->query($sql_m2);
            }
            
         }
        //------------------------------------------------------end update kbi_kp_d -----------------------------------------------------------------
       //------------------------------------------------------- update kbi_kp_ik --------------------------------------------------------
        $sql="select bl,to_char(st_date,'dd/mm/yyyy')st_date,to_char(end_date,'dd/mm/yyyy')end_date,employee_id,kp_id,ik_id,created_by,
                to_char(created_date,'dd/mm/yyyy hh24:mm:ss')created_date,last_update_by,to_char(last_update_Date,'dd/mm/yyyy hh24:mm:ss')last_update_date,    employee_id2 from hrms.kbi_kp_ik 
                where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and end_date=to_date('".$data[2]."','dd/mm/yyyy') 
                and employee_id='".$data[3]."'";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $sql_m2="select bl from kbi_kp_ik where bl='". $row['BL']."' and st_date= str_to_date('".$row['ST_DATE']."','%d-%m-%Y')
                    and end_date= str_to_date('".$row['END_DATE']."','%d-%m-%Y') and employee_id='".$row['EMPLOYEE_ID']."' and kp_id='".$row['KP_ID']."'";
           if($mysql_db->query($sql_m2)->num_rows()<1){
                $sql_m2="insert into kbi_kp_ik(bl,st_date,end_date,employee_id,kp_id,ik_id,created_by,created_date,last_update_by,last_update_date,employee_id2) values('"
                    .$row['BL']."',str_to_date('".$row['ST_DATE']."','%d/%m/%Y'),str_to_date('".$row['END_DATE']."','%d/%m/%Y'),'".$row['EMPLOYEE_ID']."',"
                    . "'".$row['KP_ID']."','".$row['IK_ID']."','".$row['CREATED_BY']."',"
                    . "str_to_date('".$row['CREATED_DATE']."','%d/%m/%Y %H:%i:%s'),"
                    . "'".$row['LAST_UPDATE_BY']."',str_to_date('".$row['LAST_UPDATE_DATE']."','%d/%m/%Y %H:%i:%s'),'".$row['EMPLOYEE_ID2']."')";
                $mysql_db->query($sql_m2);
            }
        }
        
       $mysql_db->close();
       $this->session->set_flashdata('message','Berhasil Approve Peserta  NIP:'.$data[3]);  
       $params=array('pesan'=>$sqlx); 
       print_r(json_encode($params,JSON_PRETTY_PRINT));

    }
    public function  addPenilai($recId="get"){
        $a_params= explode('_', $recId);
        $params["title"]="Edit Data Penilai";
        $params["grid"] = $this->initGridL();
        $params["BL"]=$a_params[0];
        $params["ST_DATE"]=$a_params[1];
        $params["END_DATE"]=$a_params[2];
        $params["NIP"]=$a_params[3];
        $params["ESELON"]=$a_params[4];
        $params["IS_MANAGER"]=$a_params[5];
        
        $kd_pat="";$kd_gas="" ;
        $f_peer="";$f_atasan="";$f_bawahan="";        
        if($params["ESELON"]==='5'){ $f_peer=" and (x.eselon=4  or x.eselon=5 ) ";}        
        if($params["ESELON"]==='4'){ $f_peer=" and (x.eselon=3  or  x.eselon=4) ";}        
        if($params["ESELON"]==='3'){ $f_peer=" and (x.eselon=2  or x.eselon=3) ";}        
        if($params["ESELON"]==='2'){ $f_peer=" and x.eselon=2  ";}        
        if($params["ESELON"]==='1'){ $f_peer=" and x.eselon=1  ";}        
        //---------------------- atasan -------------------
        $sql="select kd_pat,kd_gas,trim (first_title||' '||first_name||' '||last_name||' '||last_title) nama from hrms.personal where employee_id='".$params["NIP"]."'";
        if($this->db->query($sql)->num_rows()>0){
           $getData = $this->db->query($sql)->result_array();
           $kd_pat=$getData[0]['KD_PAT'];
           $kd_gas=$getData[0]['KD_GAS'];
           $params["NAMA"]=$getData[0]['NAMA'];
        }
       // $f_atasan="  and (a.kd_pat='".$kd_pat."' and a.kd_gas='".$kd_gas."' and a.eselon<".$params["ESELON"]." )   ";
        $f_atasan=" and x.employee_id=(select pimp_empid from hrms.personal where employee_id='".$params["NIP"]."') ";
        $f_bawahan="  and (x.kd_pat='".$kd_pat."' and x.kd_gas='".$kd_gas."' and x.eselon>".$params["ESELON"]."    )   ";
        $order_=" order by a.kd_pat,a.eselon ";
        $sql_="select * from (
            select employee_id ID, employee_id, 
            trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama,eselon,b.ket unit_kerja,c.ket bagian,d.ket jabatan,
            a.kd_pat,a.kd_gas,a.kd_jbt,a.st
            from hrms.personal a
            inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
            inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
            left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
            order by a.kd_pat,a.eselon
            )x where x.st=1 and instr(x.employee_id,'TX')<1  and instr(x.employee_id,'TH')<1 
            and (x.kd_pat='0A' or substr(x.kd_pat,0,1)=1 or substr(x.kd_pat,0,1)=2)  ";
        $sql_atasan=$sql_.$f_atasan;  //.$order_;
        $sql_peer=$sql_.$f_peer; //.$order_;
        $sql_bawahan=$sql_.$f_bawahan;//.$order_;
        
        //-------------------------- cek penilai -------------------------------------------------------------------
        $sql=" select employee_id_atasan,b.nama nama_atasan,employee_id_peer1,c.nama nama_peer1,employee_id_peer2,d.nama nama_peer2,employee_id_sub1,e.nama nama_sub1,
            employee_id_sub2,f.nama nama_sub2,employee_id_sub3,g.nama nama_sub3
            from   hrms.kbi_d a
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )b on b.employee_id = a.employee_id_atasan
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )c on c.employee_id = a.employee_id_peer1
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )d on d.employee_id = a.employee_id_peer2
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )e on e.employee_id = a.employee_id_sub1
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )f on f.employee_id = a.employee_id_sub2
            left join (select employee_id,trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama from HRMS.personal )g on g.employee_id = a.employee_id_sub3
            where bl='".$params["BL"]."' and st_date=to_date('".$params["ST_DATE"]."','dd-mm-yyyy') and end_date=to_date('".$params["END_DATE"]."','dd-mm-yyyy') and "
                . "a.employee_id='".$params["NIP"]."'";
        $getData = $this->db->query($sql)->result_array();
        $params["NIP_A"]=$getData[0]['EMPLOYEE_ID_ATASAN'];$params["txtNAMA_A"]=$getData[0]['NAMA_ATASAN'];
        $params["NIP_P1"]=$getData[0]['EMPLOYEE_ID_PEER1'];$params["txtNAMA_P1"]=$getData[0]['NAMA_PEER1'];
        $params["NIP_P2"]=$getData[0]['EMPLOYEE_ID_PEER2'];$params["txtNAMA_P2"]=$getData[0]['NAMA_PEER2'];
        $params["NIP_B1"]=$getData[0]['EMPLOYEE_ID_SUB1'];$params["txtNAMA_B1"]=$getData[0]['NAMA_SUB1'];
        $params["NIP_B2"]=$getData[0]['EMPLOYEE_ID_SUB2'];$params["txtNAMA_B2"]=$getData[0]['NAMA_SUB2'];
        $params["NIP_B3"]=$getData[0]['EMPLOYEE_ID_SUB3'];$params["txtNAMA_B3"]=$getData[0]['NAMA_SUB3'];
       
        //----------------------------------------------------------------------------------------------------------
        
        $this->load->helper('erp_wb_helper');
        //-------------------------------------- lookup NIP ATASAN---------------------------------------------------
        $this->session->set_userdata('sql_NIPA',$sql_atasan);
        $this->load->library('LookupData');
        $this->sqlLookup02 = $sql_atasan;
        $this->oraConn = "HR";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."hr/kbi/M_index/getLookupNIPA";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtknip","targetDataField"=>"EMPLOYEE_ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama","targetDataField"=>"NAMA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txteselon","targetDataField"=>"ESELON");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtunit_kerja","targetDataField"=>"UNIT_KERJA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtbagian","targetDataField"=>"BAGIAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtjabatan","targetDataField"=>"JABATAN");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    
        $this->lookupdata->sql = $this->sqlLookup02;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NAMA PEGAWAI";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="ESELON";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="UNIT KERJA";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="BAGIAN";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="JABATAN";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="23%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="8%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="12%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="25%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        $params["gridLUNIPA_H"] = 'Daftar Pegawai (Atasan)';
        if($this->db->query($sql_atasan)->num_rows()>0){
                    $params["gridLUNIPA"]  = genGrid("jqxGridNIPA",$this->lookupdata->initGridLookUp(),false,1150);
        }
        //-------------------------------------------------------------------------------------------------------
      //-------------------------------------- lookup NIP PEER---------------------------------------------------
        $this->session->set_userdata('sql_NIPP',$sql_peer);
        $this->load->library('LookupData');
        $this->sqlLookup02 = $sql_peer;
        $this->oraConn = "HR";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."hr/kbi/M_index/getLookupNIPP";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtknip","targetDataField"=>"EMPLOYEE_ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama","targetDataField"=>"NAMA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txteselon","targetDataField"=>"ESELON");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtunit_kerja","targetDataField"=>"UNIT_KERJA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtbagian","targetDataField"=>"BAGIAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtjabatan","targetDataField"=>"JABATAN");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    
        $this->lookupdata->sql = $this->sqlLookup02;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NAMA PEGAWAI";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="ESELON";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="UNIT KERJA";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="BAGIAN";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="JABATAN";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="23%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="8%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="12%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="25%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        $params["gridLUNIPP_H"] = 'Daftar Pegawai (1 Peer)';
        if($this->db->query($sql_peer)->num_rows()>0){
                    $params["gridLUNIPP"]  = genGrid("jqxGridNIPP",$this->lookupdata->initGridLookup(),false,1150);
        }
        //-------------------------------------------------------------------------------------------------------
      //-------------------------------------- lookup NIP BAWAHAN---------------------------------------------------
        $this->session->set_userdata('sql_NIPB',$sql_bawahan);
        $this->load->library('LookupData');
        $this->sqlLookup02 = $sql_bawahan;
        $this->oraConn = "HR";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."hr/kbi/M_index/getLookupNIPB";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtknip","targetDataField"=>"EMPLOYEE_ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama","targetDataField"=>"NAMA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txteselon","targetDataField"=>"ESELON");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtunit_kerja","targetDataField"=>"UNIT_KERJA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtbagian","targetDataField"=>"BAGIAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtjabatan","targetDataField"=>"JABATAN");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    
        $this->lookupdata->sql = $this->sqlLookup02;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NAMA PEGAWAI";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="ESELON";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="UNIT KERJA";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="BAGIAN";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="JABATAN";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="23%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="8%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="12%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="25%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        $params["gridLUNIPB_H"] = 'Daftar Pegawai (Bawahan)';
        $params["gridLUNIPB"]  = genGrid("jqxGridNIPB",$this->lookupdata->initGridLookup(),false,1150);
        //-------------------------------------------------------------------------------------------------------
        if($this->db->query($sql_bawahan)->num_rows()>0){
            $this->render_view('hr/kbi/v_add', $params);
        }
    }
    public function getGridDataAdd($eselon="get",$kd_pat="get"){
                $errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
		if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
		if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
                $this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		$query2='';$where2="";

                if($eselon==='5'){$where2 = " and (eselon=4  or eselon=5 )";}
                if($eselon==='4'){$where2 = " and (eselon=3  or  eselon=4)";}
                if($eselon==='3'){$where2 = " and (eselon=2  or eselon=3)";}
                if($eselon==='2'){$where2 = " and eselon=2";}
                if($eselon==='1'){$where2 = " and eselon=1";}
                else{$where2 = " and (eselon=5 and kd_pat='".$kd_pat."')";}

                $periode='082018';
	     	if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridLO()) ;
                
                $query2="SELECT EMPLOYEE_ID,NAMA,KETERANGAN,KD_PAT,ESELON from (
                        select employee_id, 
                        trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama, ('[eselon:'||eselon||']['||b.ket||']['||c.ket||']['||d.ket||']' )keterangan,a.kd_pat,a.eselon
                        from hrms.personal a
                        inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
                        inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
                        left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt order by kd_pat,eselon)src
                        where  (kd_pat='0A' or substr(kd_pat,0,1)=1 or substr(kd_pat,0,1)=2) ".$where2.' '.$where;
               $query="SELECT EMPLOYEE_ID,NAMA,KETERANGAN
                       FROM (
                    select a.periode,a.employee_id,b.nama,b.keterangan,
                    a.employee_id_penilai,c.nama_penilai,c.keterangan2,a.status_respon,a.tgl_respon,a.status_layer 
                    from ws_survey_d a
                    inner join(
                    select employee_id, 
                    trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama, ('[eselon:'||eselon||']['||b.ket||']['||c.ket||']['||d.ket||']' )keterangan
                    from hrms.personal a
                    inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
                    inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
                    left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
                    where a.st=1 and instr(employee_id,'TX')<1 
                    and (a.kd_pat='0A' or substr(a.kd_pat,0,1)=1 or substr(a.kd_pat,0,1)=2)
                    order by a.kd_pat,a.kd_gas,a.eselon
                    )b on a.employee_id=b.employee_id
                    inner join(
                    select employee_id, 
                    trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama_penilai, ('[eselon:'||eselon||']['||b.ket||']['||c.ket||']['||d.ket||']' )keterangan2
                    from hrms.personal a
                    inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
                    inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
                    left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
                    where a.st=1 and instr(employee_id,'TX')<1 
                    and (a.kd_pat='0A' or substr(a.kd_pat,0,1)=1 or substr(a.kd_pat,0,1)=2)
                    order by a.kd_pat,a.kd_gas,a.eselon
                    )c on a.employee_id_penilai=c.employee_id
                    )SRC where periode='".$periode."' ".$where;
             
                $arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
                if($rst)
		{	$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
                                            'EMPLOYEE_ID' =>  $rst->fields["EMPLOYEE_ID"],
                                            'NAMA' =>  $rst->fields["NAMA"],
                                            'KETERANGAN' =>  $rst->fields["KETERANGAN"],
                                            'FLAG_DATA' => "0"
                                            );	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
				$arrData[] = array(
                                        'EMPLOYEE_ID' =>  '',
                                        'NAMA' => '',
                                        'KETERANGAN' => '',
                                        'FLAG_DATA' => "0"
                                    );
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
                                    'EMPLOYEE_ID' =>  '',
                                    'NAMA' => '',
                                    'KETERANGAN' => '',
                                    'FLAG_DATA' => "0"
                                    );
		}
		//$errMsg = $query;
		
		$data[] = array(
                   'where' => $total_rows,
                   'query' => $query2,
                    
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }
    public  function initGridLO(){
        $paramsGrid["source"]["ID"] = "ID";
        $i=0;
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="EMPLOYEE_ID";
        $paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="NIP";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="6%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="NAMA";
        $paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="NAMA PEGAWAI";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="25%";
        $paramsGrid["columns"][$i]["cellsalign"]="left";
        $paramsGrid["columns"][$i]["hidden"]="false";
        $i++;
        $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="KETERANGAN";
        $paramsGrid["source"]["datafields"][$i]["name"]="KETERANGAN";
        $paramsGrid["source"]["datafields"][$i]["type"]="string";
        $paramsGrid["columns"][$i]["text"]="KETERANGAN";
        $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
        $paramsGrid["columns"][$i]["width"]="69%";
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
    public function addData(){
        $recId = $_GET["recId"];
        $a_params= explode('_', $recId);
        
        $params["title"]="Add Peserta Survey";
        $params["grid"] = $this->initGridLO();
        $params["BL"]=$a_params[0];
        $params["ST_DATE"]=$a_params[1];
        $params["END_DATE"]=$a_params[2];
        
       // IF($DATA[5]==='1'){$params["APP"]='Approved';}else{$params["APP"]='Not Approve';}
        //-------------------------------------- lookup Pegawai ---------------------------------------------------
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup02 = "select ID,employee_id,nama,eselon,unit_kerja,bagian,jabatan from (select a.employee_id ID, a.employee_id, 
            trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama,a.eselon,b.ket unit_kerja,c.ket bagian,d.ket jabatan
            from hrms.personal a
            inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
            inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
            left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
            where a.st=1 and instr(employee_id,'TX')<1  and instr(employee_id,'TH')<1 
            and (a.kd_pat='0A' or substr(a.kd_pat,0,1)=1 or substr(a.kd_pat,0,1)=2) order by a.kd_pat,a.kd_gas,a.eselon)src where employee_id is not null ";
            //order by a.kd_pat,a.kd_gas,a.eselon ";
         
                
        $this->oraConn = "HR";
        //$this->lookupdata->ID="kd_produk";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."hr/survey/M_index/getLookupNIP/";//.$params["KD_PAT"];
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtknip","targetDataField"=>"EMPLOYEE_ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama","targetDataField"=>"NAMA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txteselon","targetDataField"=>"ESELON");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtunit_kerja","targetDataField"=>"UNIT_KERJA");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtbagian","targetDataField"=>"BAGIAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtjabatan","targetDataField"=>"JABATAN");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    
        $this->lookupdata->sql = $this->sqlLookup02;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NAMA PEGAWAI";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="ESELON";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="UNIT KERJA";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="BAGIAN";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="JABATAN";
        
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="8%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="6%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="12%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="25%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
     //   $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
      //  $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
       // $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        $params["gridLUNIP"] = 'Daftar Pegawai';
        $params["gridLUNIP"]  = genGrid("jqxGridNIP",$this->lookupdata->initGridLookup(),false,1100);
        //-------------------------------------------------------------------------------------------------------
      $this->render_view('hr/survey/v_add', $params);
    }
    public function getLookupNIPA(){    //($kd_pat="get"){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "HR";
        $this->lookupdata->sql =  $this->session->userdata('sql_NIPA');
        echo $this->lookupdata->getGridData();
    }
    public function getLookupNIPP(){    //($kd_pat="get"){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "HR";
        $this->lookupdata->sql =  $this->session->userdata('sql_NIPP');

        echo $this->lookupdata->getGridData();
    }
    public function getLookupNIPB(){    //($kd_pat="get"){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "HR";
        $this->lookupdata->sql =  $this->session->userdata('sql_NIPB');

        echo $this->lookupdata->getGridData();
    }
    public function getLookupNIP(){    //($kd_pat="get"){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "HR";
        $this->lookupdata->sql = "select ID,employee_id,nama,eselon,unit_kerja,bagian,jabatan from (
            select a.employee_id ID, a.employee_id, 
            trim (first_title||' '||first_name||' '||last_name||' '||last_title)nama,a.eselon,b.ket unit_kerja,c.ket bagian,d.ket jabatan
            from hrms.personal a
            inner join hrms.tb_pat b on a.kd_pat=b.kd_pat
            inner join hrms.tb_gas c on a.kd_gas=c.kd_gas
            left join hrms.tb_jbt d on a.kd_jbt=d.kd_jbt
            where a.st=1 and instr(employee_id,'TX')<1  and instr(employee_id,'TH')<1 
            and (a.kd_pat='0A' or substr(a.kd_pat,0,1)=1 or substr(a.kd_pat,0,1)=2) order by a.kd_pat,a.kd_gas,a.eselon)src where employee_id is not null ";
         //   order by a.kd_pat,a.kd_gas,a.eselon ";
        //            a.kd_pat,a.kd_gas,a.kd_jbt

        echo $this->lookupdata->getGridData();
    }
    public function getGridDataNull(){
        $total_rows=0;
        $errMsg='';
        $arrData[] = array(
                        'ID' =>  '',
                        'KD_PRODUK' => '',
                        'KET_SBU'=>'',
                        'VOL' =>  '',
                        'HARSAT' => '',
                        'TOTAL' => '',
                        'FLAG_DATA' => "0"
                );	
        $data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $arrData,
		   'ErrorMsg'=>$errMsg
		);
        print_r(json_encode($data,JSON_PRETTY_PRINT));

    }   
    public function newData(){
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        
	/*------------------------- end LookUP VENDOR ANGKUTAN----------------*/
        //-------------------- LU NO. SPM ----------------------------------
        $this->sqlLookup01 ="select a.no_spm ID,a.no_spm,b.no_spprb,b.nama_proyek,
                        c.nama nama_angkutan,a.no_pol,b.tujuan,a.no_sppb,  a.tgl_spm,b.no_npp
                         from spm_h a 
                         inner join 
                         (select a.no_sppb,a.tgl_sppb,a.no_spprb,c.nama_proyek,c.nama_pelanggan,a.app,a.tujuan,c.no_npp  from sppb_h a 
                         inner join spprb_h b on a.no_spprb=b.no_spprb
                         inner join npp c on b.no_npp=c.no_npp
                         where c.nama_pelanggan is not null
                         )b on a.no_sppb=b.no_sppb
                         inner join vendor c on a.vendor_id=c.vendor_id where a.app1 =1";
        
        $this->oraConn = "OS";
        $this->lookupdata->oraConn = $this->oraConn;
        $this->lookupdata->urlData=base_url()."os/sptb/M_index/getLookupSPM";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtno_spm","targetDataField"=>"NO_SPM");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtno_spprb","targetDataField"=>"NO_SPPRB");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama_proyek","targetDataField"=>"NAMA_PROYEK");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnama_angkutan","targetDataField"=>"NAMA_ANGKUTAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtnopol","targetDataField"=>"NO_POL");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txttujuan","targetDataField"=>"TUJUAN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtno_sppb","targetDataField"=>"NO_SPPB");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txttgl_spm","targetDataField"=>"TGL_SPM");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtno_npp","targetDataField"=>"NO_NPP");
        
        
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="NO. SPM";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="NO. SPPRB";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="NAMA PROYEK";
        $this->lookupdata->customParamsGrid["columns"][4]["text"]="NAMA ANGKUTAN";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="PLAT NO.";
        $this->lookupdata->customParamsGrid["columns"][6]["text"]="TUJUAN";
        
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="22%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="25%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="25%";
        $this->lookupdata->customParamsGrid["columns"][4]["width"]="20%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][6]["width"]="30%";
        
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][7]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][8]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][9]["hidden"]="true";
        
        $params["gridLUSPM"] = genGrid("jqxGridSPM",$this->lookupdata->initGridLookup(),false,1100);
        
        /*-------------------- list jns_sptb -------------------*/
        $this->load->library('AdodbConn');
        $conn = $this->adodbconn->getOraConn("OS");
                
        $sql="select id,keterangan from tb_jns_sptb";
        $arrParamData=array();
        $rst=$conn->Execute($sql,$arrParamData);
        if($rst)
        {
            if($rst->recordCount()>0)
            {
                $i=0;
                while(!$rst->EOF)
                { $params["DDListJnsSptb"][$i] = array("Value"=>$rst->fields["ID"],
                                                            "Display"=>$rst->fields["KETERANGAN"]
                                                    );
                        $rst->moveNext();
                        $i++;
                }
            }else{
                    $params["DDListJnsSptb"][$i] = array("Value"=>'',
                            "Display"=>""
                    );
            }
        }
        /*-------------------------- end LookUpPAT--------------*/
          $params["DDListProduk"][] = array("KD_PRODUK"=>'',
                                            "TIPE"=>'',
                                            "VOL"=>'',
                                            "KET"=>'');
                        
             //----------------get Data existing--------------------------------------------------------
               $params["title"] = "New Data";
                $params["NO_SPTB"] = '';
                $params["NO_SPM"] = '';
                $params["NAMA_ANGKUTAN"] = '';
                $params["TGL_BERANGKAT"] = '';$params["JAM_BERANGKAT"] = '';
                $params["NO_POL"] = '';$params["PROD_BY"] = '';
                $params["TGL_SAMPAI"] = '';
                $params["JAM_SAMPAI"] = '';
                $params["TUJUAN"] = '';
                $params["PROD_BY"] = '';
                $params["statEdit"] = false;
                
                //-----------------------------------------------------------------------------------------
            $this->render_view('os/sptb/v_new', $params);
    }
    public function addPeserta() {
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $user='WASE';                     //----------- ambil dari login
        $curr_date = date("Y-m-d H:i:s"); 
    	//created_by,created_date,last_update_by,last_update_date
        //txtBL,txtST_DATE,txtEND_DATE,txtEMPLOYEE_ID,txtEselon,txtIsMan
        //select bl,st_date,end_date,employee_id,eselon,is_manager,created_by,created_date from hrms.kbi_d;
        $sql = "select bl from  hrms.kbi_d where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
                . "end_date=to_date('".$data[2]."','dd/mm/yyyy') and employee_id='".$data[3]."'";
      
        if($this->db->query($sql)->num_rows()>0){
            $sql="update hrms.kbi_d set last_update_by='".$user."' ,last_update_date=to_date('".$curr_date."','yyyy/mm/dd hh24:mi:ss'),"
                    . "is_manager='".$data[5]."'  where bl='".$data[0]."' and st_date=to_date('".$data[1]."','dd/mm/yyyy') and   "
                . "end_date=to_date('".$data[2]."','dd/mm/yyyy') and employee_id='".$data[3]."'";
            $this->session->set_flashdata('message','Berhasil Update Peserta  NIP:'.$data[3]);    
        }else{
            $sql="insert into hrms.kbi_d(bl,st_date,end_date,employee_id,eselon,is_manager,created_by,created_date) values ("
                    . "'".$data[0]."',to_date('".$data[1]."','dd/mm/yyyy'),to_date('".$data[2]."','dd/mm/yyyy'),"
                    . "'".$data[3]."','".$data[4]."','".$data[5]."','".$user."',to_date('".$curr_date."','yyyy/mm/dd hh24:mi:ss'))";
            $this->session->set_flashdata('message','Berhasil Tambah Peserta  NIP:'.$data[3]);    
        }
        $result=$this->db->query($sql);
        $params=array('pesan'=>'sukses'); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));
  }
    public function savePenilai(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $user='WASE';                     //----------- ambil dari login
        $curr_date = date("Y-m-d H:i:s"); 
        $sql= "update hrms.kbi_d set employee_id_atasan='".$data[4]."',employee_id_peer1='".$data[5]."',employee_id_peer2='".$data[6]."',"
                . "employee_id_sub1='".$data[7]."',employee_id_sub2='".$data[8]."',employee_id_sub3='".$data[9]."',"
                . "last_update_by='".$user."',last_update_date=to_date('".$curr_date."','yyyy/mm/dd hh24:mi:ss') "
                . " where  bl='".trim($data[0])."' and to_char(st_date,'dd-mm-yyyy')='".trim($data[1])."' "
                . "  and to_char(end_date,'dd-mm-yyyy')='".trim($data[2])."' and trim(employee_id)='".trim($data[3])."'";
                   
        $result = $this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Update Penilai untuk NIP:'.$data[3]);    
        $params=array('pesan'=>'sukses');
        print_r(json_encode($params,JSON_PRETTY_PRINT));
  
    }
    public function delPotong(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        //array(5) { [0]=> string(2) "0A" [1]=> string(11) "I0A02062018" [2]=> string(4) "2150" [3]=> string(8) "TK180088" [4]=> string(5) "20000" }  
        $sql="delete from hrms.p02_d where kd_pat='".$data[0]."' and no_trans='".$data[1]."' and employee_id='".$data[3]."' and wt='".$data[2]."'";
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Hapus Potongan  NIP:'.$data[3]);    
        $params=array('pesan'=>'sukses'); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));
  
    }
    public function f_upload_peserta(){
        $BL = $_POST['txtBL_M'];
        $ST_DATE = $_POST['txtST_DATE_M'];
        $END_DATE = $_POST['txtEND_DATE_M'];           
            
        $user='WASE';                       //---------------- Ambil dari Server -----------------------------------------
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
                    $no_urut=$row-1;$ESELON='';
                    $sql="select eselon from hrms.personal where employee_id='".$rowData[0][0]."'";
                    if($this->db->query($sql)->num_rows()>0){
                        $getData = $this->db->query($sql)->result_array();
                        foreach ($getData as $row){
                            $ESELON = $row['ESELON'];
                        }      
                    }
                    //  $BL  $ST_DATE  $END_DATE
                    $sql="select bl,app1 from hrms.kbi_d where bl='".$BL."' and st_date=to_date('".$ST_DATE."','dd/mm/yyyy')
                        and end_date=to_date('".$END_DATE."','dd/mm/yyyy') and employee_id='".$rowData[0][0]."'";
                    $rows=$this->db->query($sql)->num_rows();
                    if($rows>0){
                        $getData = $this->db->query($sql)->result_array();
                        foreach ($getData as $row){
                            $APP1 = $row['APP1'];
                        }
                        /*
                         select bl,st_date,end_date,employee_id,eselon,employee_id_atasan,employee_id_peer1,employee_id_peer2,employee_id_sub1,
                        employee_id_sub2,employee_id_sub3,is_manager,created_by,created_date,app1,app1_date from kbi_d;
                         */
                        if($APP1==='0'){
                            $sql="update hrms.kbi_d set employee_id_atasan='".$rowData[0][1]."', employee_id_peer1='".$rowData[0][2]."',"
                                . "employee_id_peer2='".$rowData[0][3]."',employee_id_sub1='".$rowData[0][4]."',employee_id_sub2='".$rowData[0][5]."',"
                                . "employee_id_sub3='".$rowData[0][6]."',is_manager='".$rowData[0][7]."',app1='".$rowData[0][7]."',app1_date=to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss') "
                                . "where bl='".$BL."' and st_date=to_date('".$ST_DATE."','dd/mm/yyyy')
                                    and end_date=to_date('".$END_DATE."','dd/mm/yyyy') and employee_id='".$rowData[0][0]."'";
                        }
                    }else{
                        $sql="insert into hrms.kbi_d(bl,st_date,end_date,employee_id,eselon,employee_id_atasan,employee_id_peer1,employee_id_peer2,employee_id_sub1,
                        employee_id_sub2,employee_id_sub3,is_manager,created_by,created_date,app1,app1_date) values(
                        '".$BL."',to_date('".$ST_DATE."','dd/mm/yyyy'),to_date('".$END_DATE."','dd/mm/yyyy'),trim('". $rowData[0][0]."'),trim('"
                       . $ESELON."'),trim('".$rowData[0][1]."'),trim('".$rowData[0][2]."'),trim('".$rowData[0][3]."'),trim('".$rowData[0][4]."'),trim('".$rowData[0][5]."'),trim('"
                       .$rowData[0][6]."'),trim('".$rowData[0][7]."'),'UPLOAD',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'),'".$rowData[0][8]."',to_date('".$tgl_create."','yyyy/mm/dd hh24:mi:ss'))";
                    }
                    $result=$this->db->query($sql);
                }
             
            }
        delete_files($media['file_path']);
        $this->session->set_flashdata('message','Berhasil Upload Daftar Pegawai Periode  '.$ST_DATE.' s/d '.$END_DATE);    
        $params=array('pesan'=>'sukses'); 
        $this->contentManagement();  
    
        //------------------------------------------------------
        
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
        $user='WASE';                       //---------------- Ambil dari Server -----------------------------------------
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
        $this->contentManagement();  
    
        //------------------------------------------------------
        
    }
    function tofloat($num) {
        return (str_replace(',','',$num));
    }
    public function appData(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $sql="update hrms.p02_h set app='1' where no_trans='".$data[0]."' and wt='".$data[1]."' and kd_pat='".$data[4]."'";
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Approve '.$data[0].' Periode:'.$data[0].' u/ KD. PAT:'.$data[4]);    
        $params=array('pesan'=>'sukses'); 
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
    //-------------------------------------
    
    
}
