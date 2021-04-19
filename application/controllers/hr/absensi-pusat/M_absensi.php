<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_absensi extends CI_Controller {
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
		$this->load->library('Wb_Security');
		$isessid="";
		if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
		$this->wb_security->id_session = $isessid;
		$this->session->set_userdata($this->wb_security->cekSession());
		
		if($this->session->userdata('TMP_NIP')===NULL){
			redirect('http://erp.wika-beton.co.id');
		}else{
			$params["title"]="Daftar Absensi Dari Mesin Facepad";
			$params["grid"] = $this->initGrid();
			$this->render_view('hr/absensi-pegawai/v_absensi_list', $params);
		}
    }
	
    public function initGrid(){
            $paramsGrid["source"]["ID"] = "TIMERECORD";
            $i=0;
            
            //SET ID TO HIDE
            //MUST BE ON FIRST COLUMN , SET ID TO PRIMARY KEY
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.KD_PAT";
            $paramsGrid["source"]["datafields"][$i]["name"]="ID";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="KODE PAT";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="5%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="false";
            
			$i++;
			$paramsGrid["source"]["datafields"][$i]["dbfieldname"]="b.KET";
            $paramsGrid["source"]["datafields"][$i]["name"]="KET";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="UNIT KERJA";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="10%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
			
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="a.EMPLOYEE_ID";
            $paramsGrid["source"]["datafields"][$i]["name"]="EMPLOYEE_ID";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="NIP";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="7%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="false";
			
			$i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="(c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title)";
            $paramsGrid["source"]["datafields"][$i]["name"]="NAMA";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="NAMA";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="20%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
			
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="TGL";
            $paramsGrid["source"]["datafields"][$i]["name"]="TGL";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="TGL";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="8%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="false";
			
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="TIMERECORD";
            $paramsGrid["source"]["datafields"][$i]["name"]="TIMERECORD";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="JAM";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="7%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
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
		$conn = $this->adodbconn->getOraConn("HR");		
		$this->load->helper('erp_wb_helper');
		
		if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;

		//exit;
       $query="select a.TGL, a.KD_PAT, b.ket, a.EMPLOYEE_ID, (c.first_title || ' ' || c.first_name || ' ' || c.last_name || ' ' || c.last_title) as NAMA, a.TIMERECORD, a.IN_STATUS, a.UPLOAD_BY, a.UPLOAD_DATE from hrms.ABSENSI_FGR_PRINT2 a inner join hrms.tb_pat b on b.kd_pat=a.kd_pat inner join hrms.personal c on c.employee_id=a.employee_id where a.KD_PAT='0A' and TO_CHAR(a.tgl, 'YYYY') = to_char(sysdate,'YYYY') and ((TO_CHAR(a.tgl,'mm')=to_char(sysdate,'mm')-1 and TO_CHAR(a.tgl,'dd')>'20') or (TO_CHAR(a.tgl,'mm')=to_char(sysdate,'mm') and TO_CHAR(tgl,'dd')<='19')) and REGEXP_LIKE(substr(a.EMPLOYEE_ID,3), '^-?[0-9]+(\.[0-9]+)?$') "
                 .$where."   order by tgl";                
        
                $arrParamData = array();
		$rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
		if($rst)
		{
			$total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
			if($rst->recordCount()>0){
				while(!$rst->EOF)
				{
					$arrData[] = array(
                                              //  'ID' =>  $rst->fields["TIMERECORD"],
                                                'TIMERECORD' =>  $rst->fields["TIMERECORD"],
                                                'ID' =>  $rst->fields["KD_PAT"],
												'KET' =>  $rst->fields["KET"],
                                                'EMPLOYEE_ID' =>  $rst->fields["EMPLOYEE_ID"],
												'NAMA' =>  $rst->fields["NAMA"],
                                                'TGL' =>  $rst->fields["TGL"],
                                                'TIMERECORD' =>  $rst->fields["TIMERECORD"],
                                                'FLAG_DATA' => "0"
                                            );	
					
					$rst->moveNext();
				}
			}else{
				$total_rows = 0;
                                $arrData[] = array(
                                        'ID' =>  $rst->fields["TIMERECORD"],
                                        'TIMERECORD' =>  $rst->fields["TIMERECORD"],
                                        'KD_PAT' =>  $rst->fields["KD_PAT"],
                                        'EMPLOYEE_ID' =>  $rst->fields["EMPLOYEE_ID"],
                                        'TGL' =>  $rst->fields["TGL"],
                                        'TIMERECORD' =>  $rst->fields["TIMERECORD"],
                                        'FLAG_DATA' => "0"
                                    );
			}
		}else{
			$total_rows = 0;
			$arrData[] = array(
                                        'TIMERECORD' => '',
                                        'KD_PAT' => '' ,
                                        'EMPLOYEE_ID' =>  '',
                                        'TGL' =>  '',
                                        'TIMERECORD' =>  '',
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
    public function addNewData(){
		ini_set('max_execution_time', 300);
        echo  "<div  id='status'> </div>";
       
        $errMsg = "";$recPerPage = 10;$currPage = 1;$where = "";
	$mysql_db=$this->load->database('absensi',true);//connected with mysql
        $sql = "select name,substr(created_time,1,10)tgl,substr(created_time,11,9)jam,created_time
                from sys_hit_record
                where year(curdate())=year(created_time) and ( ( month(created_time)=month(curdate())-1 
                and day(created_time)>=20)  or  ( month(created_time)=month(curdate()) 
                and day(created_time)<=19) ) and substr(name,3) REGEXP '^[0-9]+$'
                 order by created_time desc  ";
        $absen =$mysql_db->query($sql); // $this->db->query($sql); 
        
	$total=$absen->num_rows();
	$bl_ = date('m').date('Y'); 
        if($absen->num_rows()>0){
            $i=1;
            foreach ($absen->result() as $row)
            {
                $status='Record ke:'.$i.' Periode :'.$bl_.' Employee ID='.$row->name.'  Tanggal = '.$row->tgl.' Waktu = '.$row->jam.'<br>';$i=$i+1;
                 echo "<script>document.getElementById('status').innerHTML ='".$status." Total Record:".$total."'       </script>";
                   $insert_ora = "merge into hrms.absensi_fgr_print2 s1 using (select '".$row->name."'employee_id,'".$this->session->userdata('TMP_KDWIL')."' kd_pat, 
                       to_date('".$row->tgl."','YYYY/MM/DD')tgl,'".trim($row->jam)."' timerecord,'1' in_status,'".$this->session->userdata('TMP_NIP')."' upload_by,sysdate upload_date 
                       from dual
                        )s2 on (s1.employee_id=s2.employee_id and s1.tgl=s2.tgl and s1.timerecord=s2.timerecord )
                        when matched then update set s1.in_status =s2.in_status
                        when not matched then insert (tgl,kd_pat,employee_id,timerecord,in_status,upload_by,upload_date) 
                        values(s2.tgl,s2.kd_pat,s2.employee_id,s2.timerecord,s2.in_status,s2.upload_by,s2.upload_date)";
                    $result=$this->db->query($insert_ora);
                //sleep(2);    
            }
        }
        $mysql_db->close();
        $sql = "CALL HRMS.prc_update_absensi('".$bl_."','".$this->session->userdata('TMP_KDWIL')."')";
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Upload Absen '.$total.' Records');    
        echo "<script>document.getElementById('status').innerHTML =''; </script>";
        $this->index(); 
        
    }
    
}
