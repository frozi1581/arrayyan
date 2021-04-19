<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_index extends CI_Controller {
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
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    public function render_view($content = "main", $params = array()){
       $this->load->view('shared/header',$params);
       $this->load->view('shared/sidebar',$params);
       $this->load->view($content,$params);
       $this->load->view('shared/footer',$params);
    }
    public function errorPage($value=''){
        $this->render_view('error');
    }
    public function index(){
	$this->load->helper(array('form','url','download'));
        $this->load->library('session');
        $this->contentManagement();
    }
    public function contentManagement(){
		$params["title"]="Daftar Surat";
		$params["grid"] = $this->initGrid();
                //--------------------------------Load info user into session -----------------------------------
                $this->load_info_user();
                //------------------------------------------------------------------------------------------------
                
      	$this->render_view('hr/surat/v_list', $params);
    }
    public function load_info_user(){
        $array_val = array('s_uID' => '','s_uNAME' => '', 's_uPAT' => '','s_uJBT' => '',
            's_uGAS' => '','s_uPAT_KET' => '','s_uGAS_KET' => '','s_uJBT_KET' => '',);
        
        //------------get session OS---------------------
        $this->load->library('Wb_Security');
        $isessid="";
      //  $isessid="33b8dc9015a043dd3ec9dedd316b078a";//"c1ea6c56a103b441875fcfcdce93a84e";//"c5c689ce32b0e4afcef7b0e44b352b21";// "80f027d6f304c9a4cad98ddb062e8b89"; 
        if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
        $this->wb_security->id_session = $isessid;
        $this->session->set_userdata($this->wb_security->cekSession());
        //-----------------------------------------------
        $this->session->unset_userdata($array_val);
        $this->session->set_userdata('s_uID',$this->session->userdata("TMP_NIP"));
        //$this->session->set_userdata('s_uID', 'LS183677');//LS083110  'LS183677'
        $sql="select a.employee_id,
            trim(first_title||' '||first_name||' '||last_name||last_title)nama_pengirim,
            a.kd_pat,b.ket ket_pat,c.kd_gas,c.ket ket_gas,a.kd_jbt,d.ket ket_jbt from wos.personal a
            left join wos.tb_pat b on a.kd_pat=b.kd_pat
            left join wos.tb_gas c on a.kd_gas=c.kd_gas
            left join wos.tb_jbt d on a.kd_jbt=d.kd_jbt
            where a.employee_id='".$this->session->userdata('s_uID')."' and st='1'";
        $getData = $this->db->query($sql)->result_array();
        foreach ($getData as $row){
            $this->session->set_userdata('s_uNAME',$row['NAMA_PENGIRIM']);
            $this->session->set_userdata('s_uPAT',$row['KD_PAT']);
            $this->session->set_userdata('s_uJBT',$row['KD_JBT']);
            $this->session->set_userdata('s_uGAS',$row['KD_GAS']);
            $this->session->set_userdata('s_uPAT_KET',$row['KET_PAT']);
            $this->session->set_userdata('s_uGAS_KET',$row['KET_GAS']);
            $this->session->set_userdata('s_uJBT_KET',$row['KET_JBT']);
        }
        return $this->session->userdata;
    }
    public function initGridx(){
        $paramsGrid["source"]["ID"] = "ARSIP";
        $i=0;
        //Actions Columns
        //Actions
        //ID,NO_DOK,EMPLOYEE_ID,NAMA,KET_JBT,KD_JBT_PPD
        $aFLD=["ID","NO_SURAT","TUJUAN_SURAT","PERIHAL","TGL_SURAT","CREATED_DATE","UNIT_KERJA","BIRO","DIBUAT_OLEH","EMPLOYEE_PENGIRIM",
            "NAMA_PENGIRIM","JABATAN_PENGIRIM","KET_JABATAN","KD_PAT_PENGIRIM","KD_GAS_PENGIRIM","KET_MASALAH_INDUK","KET_MASALAH_PRIMER",
            "KET_MASALAH_SEKUNDER","LAMPIRAN","UPLOAD","FLAG_DATA"];
        $aMtext=["ACTION","NO. SURAT","TUJUAN_SURAT","PERIHAL","TGL_SURAT","CREATED_DATE","UNIT_KERJA","BIRO","DIBUAT OLEH","EMPLOYEE_PENGIRIM",
            "NAMA_PENGIRIM","JABATAN_PENGIRIM","KET_JABATAN","KD_PAT_PENGIRIM","KD_GAS_PENGIRIM","KET_MASALAH_INDUK","KET_MASALAH_PRIMER",
            "KET_MASALAH_SEKUNDER","LAMPIRAN","UPLOAD","FLAG_DATA"];
        $aCellsAlign=["center","left","left","left","left","left","left","left","left","left",
            "left","left","left","left","left","left","left",
            "left","left","left","left"];
        $aCellsHidden=["false","false","true","false","false","true","true","true","false","true",
            "true","true","true","true","true","true","true",
            "true","true","true","true"];
        $aCellsPinned=["true","false","false","false","false","false","false","false","false","false",
            "false","false","false","false","false","false","false",
            "false","false","false","false"];
        $aCellsRender=["renderACT","false","false","false","false","false","false","false","false","false",
            "false","false","false","false","false","false","false",
            "false","false","false","false"];
        $aCellsWidth=["15%","10%","1%","14%","10%","1%","1%","1%","24%","1%",
            "1%","1%","1%","1%","1%","1%","1%",
            "1%","1%","1%","1%"];
        for($x=0;$x<count($aFLD)-1;$x++){
            $i++;  
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]=$aFLD[$x];
            $paramsGrid["source"]["datafields"][$i]["name"]=$aFLD[$x];
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]=$aMtext[$x];
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]=$aCellsWidth[$x];
            $paramsGrid["columns"][$i]["pinned"]=$aCellsPinned[$x];
            $paramsGrid["columns"][$i]["cellsalign"]=$aCellsAlign[$x];
            $paramsGrid["columns"][$i]["hidden"]=$aCellsHidden[$x];
            if(strlen($aCellsRender[$x])>0) $paramsGrid["columns"][$i]["cellsrenderer"]=$aCellsRender[$x];
        }
        return $paramsGrid;
}
     public function initGrid(){
            $paramsGrid["source"]["ID"] = "ARSIP";
            $i=0;
            //Actions Columns
            //Actions
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
            $paramsGrid["source"]["datafields"][$i]["name"]="ID";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="ACTION";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="21%";
            $paramsGrid["columns"][$i]["cellsrenderer"]="renderACT";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["pinned"]="true";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="no_surat";
            $paramsGrid["source"]["datafields"][$i]["name"]="no_surat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="NO. SURAT";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="18%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
             $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="tujuan_surat";
            $paramsGrid["source"]["datafields"][$i]["name"]="tujuan_surat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Tujuan Surat Eksternal";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="22%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
             $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="perihal";
            $paramsGrid["source"]["datafields"][$i]["name"]="perihal";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="PERIHAL";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="29%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="tgl_surat";
            $paramsGrid["source"]["datafields"][$i]["name"]="tgl_surat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="TGL. SURAT";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="8%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="created_date";
            $paramsGrid["source"]["datafields"][$i]["name"]="created_date";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Tgl. Input";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="8%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="unit_kerja";
            $paramsGrid["source"]["datafields"][$i]["name"]="unit_kerja";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Unit Kerja Pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="biro";
            $paramsGrid["source"]["datafields"][$i]["name"]="biro";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Biro/Seksi Pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="dibuat_oleh";
            $paramsGrid["source"]["datafields"][$i]["name"]="dibuat_oleh";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="DIBUAT OLEH";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="32%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            //$paramsGrid["columns"][$i]["cellsrenderer"]="renderDetails";
	    $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="employee_pengirim";
            $paramsGrid["source"]["datafields"][$i]["name"]="employee_pengirim";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="employee_pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="10%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="nama_pengirim";
            $paramsGrid["source"]["datafields"][$i]["name"]="nama_pengirim";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Nama Pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="jabatan_pengirim";
            $paramsGrid["source"]["datafields"][$i]["name"]="jabatan_pengirim";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="jabatan_pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_jabatan";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_jabatan";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="Jabatan";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;   
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="kd_pat_pengirim";
            $paramsGrid["source"]["datafields"][$i]["name"]="kd_pat_pengirim";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="kd_pat_pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="kd_gas_pengirim";
            $paramsGrid["source"]["datafields"][$i]["name"]="kd_gas_pengirim";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="kd_gas_pengirim";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="true";
               $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_masalah_induk";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_masalah_induk";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="ket_masalah_induk";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="1%";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_masalah_primer";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_masalah_primer";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="ket_masalah_primer";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="1%";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;     
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_masalah_sekunder";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_masalah_sekunder";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="ket_masalah_sekunder";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="1%";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="lampiran";
            $paramsGrid["source"]["datafields"][$i]["name"]="lampiran";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="LAMPIRAN";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="7%";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["cellsrenderer"]="renderLampiran";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="upload";
            $paramsGrid["source"]["datafields"][$i]["name"]="upload";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="UPLOAD";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="6%";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["cellsrenderer"]="renderUpload";
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
    public function list_surat(){
        $errMsg = "";$recPerPage = 15;$currPage = 1;$where = ""; $filter_user="";// $user_level = 0[Admin]  1[user]
        if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
        if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);

        $this->load->library('AdodbConn');
        $conn = $this->adodbconn->getOraConn("OS");
        $this->load->helper('erp_wb_helper');
        
        //-------------------------------- cek user session -------------------------------------------------------
        if(!is_null($this->session->userdata('user_level'))){$user_level=$this->session->userdata('user_level');}else{$user_level='1';}    
      //  $user_level     = isset($this->session->userdata('user_level'))?$this->session->userdata('user_level'):"1";
        if(!is_null($this->session->userdata('user_id'))){$user_id= $this->session->userdata('user_id');}else{$user_id="LS083110";}
      //$user_id     = isset($this->session->userdata('user_id'))?$this->session->userdata('user_id'):"LS083110";
        if($user_level==="1")$filter_user=" and a.kd_pat_pengirim=(select kd_pat from personal where employee_id='".$user_id."') ";
        //------------------------------- end cek session ---------------------------------------------------------
        //---------------- cek Akses ------------------------------------------------------------------------------
        $sql_mnj="select a.kd_pat
                from wos.personal a
                left join wos.tb_pat b on a.kd_pat=b.kd_pat
                left join wos.tb_gas c on a.kd_gas=c.kd_gas
                left join wos.tb_jbt d on a.kd_jbt=d.kd_jbt
                where   instr ('123',a.eselon)>0 and st=1  and a.employee_id='".$this->session->userdata('s_uID')."'";
                //---- cek akses per seksi/gas
        $sql_nonmnj="select a.kd_pat,a.kd_gas
                from wos.personal a
                left join wos.tb_pat b on a.kd_pat=b.kd_pat
                left join wos.tb_gas c on a.kd_gas=c.kd_gas
                left join wos.tb_jbt d on a.kd_jbt=d.kd_jbt
                where st=1  and a.employee_id='".$this->session->userdata('s_uID')."'";
        $getData = $this->db->query($sql_mnj)->result_array();
        if (count($getData)>0){
            $filter_user="  and a.kd_pat_pengirim='".$getData[0]['KD_PAT']."' ";
        }else{
            $getData = $this->db->query($sql_nonmnj)->result_array();
            $filter_user="  and a.kd_pat_pengirim='".$getData[0]['KD_PAT']."' and a.kd_gas_pengirim='".$getData[0]['KD_GAS']."'";
        }
        if($this->session->userdata('s_uGAS')==='006' || $this->session->userdata('s_uGAS')==='007') $filter_user=""; 
        //---------------- end cek Akses --------------------------------------------------------------------------        
        if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGrid()) ;

        $query="select a.no_surat ID,a.no_surat,to_char(a.tgl_surat,'dd-mm-yyyy')tgl_surat,to_char(a.created_date,'dd-mm-yyyy')created_date ,a.employee_pengirim,
                trim(first_title||' '||first_name||' '||last_name||last_title)nama_pengirim,            
                a.jabatan_pengirim,e.ket ket_jabatan,a.kd_pat_pengirim,d.ket lokasi_kerja,
                a.kd_gas_pengirim,c.ket biro, a.tujuan_surat,a.perihal,a.lampiran, 
                d.ket||' ( '||c.ket||' )' dibuat_oleh,
                upper(f.ket_masalah_induk)ket_masalah_induk,upper(f.ket_masalah_primer)ket_masalah_primer,upper(f.ket_masalah_sekunder)ket_masalah_sekunder
                from (select * from tb_surat order by tgl_surat,no_surat desc) a
                inner join personal b on a.employee_pengirim=b.employee_id
                inner join tb_gas c on a.kd_gas_pengirim=c.kd_gas
                inner join tb_pat d on a.kd_pat_pengirim=d.kd_pat
                inner join tb_jbt e on a.jabatan_pengirim=e.kd_jbt
                inner join ms_kode_masalah f on substr(a.no_surat,1,8)=f.kd_dokumen
                where (flag_hapus is null or flag_hapus<>'Y') and   length(a.no_surat)>1  ".$filter_user." ".$where;      //." order by a.tgl_surat,a.no_surat desc";
        $arrParamData = array();
        $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
        if($rst){
                $total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
                if($rst->recordCount()>0){
                        for($i=0;$i<$rst->recordCount();$i++){
                                $arrData[] = array(
                                    'ID' => $rst->fields["ID"],
                                    'no_surat' =>  $rst->fields["NO_SURAT"],
                                    'tgl_surat' =>  $rst->fields["TGL_SURAT"],
                                    'created_date' =>  $rst->fields["CREATED_DATE"],
                                    'employee_pengirim' =>  $rst->fields["EMPLOYEE_PENGIRIM"],
                                    'nama_pengirim' =>  $rst->fields["NAMA_PENGIRIM"],
                                    'jabatan_pengirim' =>  $rst->fields["JABATAN_PENGIRIM"],    
                                    'ket_jabatan' =>  $rst->fields["KET_JABATAN"],
                                    'kd_pat_pengirim' =>  $rst->fields["KD_PAT_PENGIRIM"],
                                    'unit_kerja' =>  $rst->fields["LOKASI_KERJA"],
                                    'kd_gas_pengirim' =>  $rst->fields["KD_GAS_PENGIRIM"],
                                    'biro' =>  $rst->fields["BIRO"],
                                    'tujuan_surat' =>  $rst->fields["TUJUAN_SURAT"],
                                    'dibuat_oleh' =>  $rst->fields["DIBUAT_OLEH"],
                                    'lampiran' =>  $rst->fields["LAMPIRAN"],
                                    'perihal' =>  $rst->fields["PERIHAL"],
                                    'ket_masalah_induk' =>  $rst->fields["KET_MASALAH_INDUK"],
                                    'ket_masalah_primer' =>  $rst->fields["KET_MASALAH_PRIMER"],
                                    'ket_masalah_sekunder' =>  $rst->fields["KET_MASALAH_SEKUNDER"],
                                    'upload' =>  $rst->fields["NO_SURAT"],
                                    'FLAG_DATA' => "0"
                                    );	 
                                $rst->moveNext();
                        }
                }else{
                        $total_rows = 0;              
                        $arrData[] = array(
                                 'ID' => "",
                                'no_surat' =>  "",
                                'tgl_surat' =>  "",
                                'created_date' =>  "",
                                'employee_pengirim' => "",
                                'nama_pengirim' => "",
                                'jabatan_pengirim' => "",    
                                'ket ket_jabatan' =>  "",
                                'kd_pat_pengirim' =>  "",
                                'lokasi_kerja' =>  "",
                                'kd_gas_pengirim' =>  "",
                                'dibuat_oleh' =>  "",
                                'biro' => "",
                                'tujuan_surat' => "",
                                'perihal' => "",
                                'lampiran' => "",
                                'ket_masalah_induk' => "",
                                'ket_masalah_primer' =>  "",
                                'ket_masalah_sekunder' =>  "",
                                'upload' =>  "",
                                'FLAG_DATA' => "0"
                            ); 
                }
        }else{
                $total_rows = 0;
                $arrData[] = array(
                    'ID' => "",
                    'no_surat' =>  "",
                    'tgl_surat' =>  "",
                    'created_date' =>  "",
                    'employee_pengirim' => "",
                    'nama_pengirim' => "",
                    'jabatan_pengirim' => "",    
                    'ket ket_jabatan' =>  "",
                    'kd_pat_pengirim' =>  "",
                    'lokasi_kerja' =>  "",
                    'kd_gas_pengirim' =>  "",
                    'dibuat_oleh' =>  "",
                    'biro' => "",
                    'tujuan_surat' => "",
                    'perihal' => "",
                    'lampiran' => "",
                    'ket_masalah_induk' => "",
                    'ket_masalah_primer' =>  "",
                    'ket_masalah_sekunder' =>  "",
                    'upload' =>  "",
                    'FLAG_DATA' => "0"
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
    public function f_upload(){
        $fpath_old=""; $fpath_new="";
        $tgl_create=date("Y-m-d H:i:s");
        $data=$this->input->post();
        $dataUpdate = array();
        foreach ($data as $key => $value) {
           $dataUpdate[$key] = $value;
        }  
        $ppu = substr($dataUpdate['txtUploadNoSurat'],9,5);
        $fpath_old="";$fpath_new="";
        $sql="select lampiran from wos.tb_surat where no_surat='".$dataUpdate['txtUploadNoSurat']."'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0){
            $getData=$sql->result_array();
            foreach ($getData as $row){
                $fpath_old=$row['LAMPIRAN'];
            }
            //------------------------------------------------------------------------ attach ---------------------
            $config['upload_path']          = './upload/surat';
            $config['allowed_types']        = 'gif|jpg|png|jpg|pdf|docx|doc|xls|xlsx|ppt|pptx';
            $config['max_size']             = 10000000;
            $filename_upload=$_FILES['txtUpload_file']['name'];
          //    $filename_upload = $dataUpdate['txtUpload_file'];
            
            
            if (is_uploaded_file($_FILES['txtUpload_file']['tmp_name'])) {
                $ext = explode('.', $filename_upload);
                $ext = $ext[1];
                $newFileName = $config['file_name'] = $ppu."_".date('Ymdhis')."_".$filename_upload;//.".".$ext;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('txtUpload_file'))
                    {
                        $this->session->set_flashdata('message','Uploading error !!!');
                        echo $this->upload->display_errors();
                        die();
                    }
                    else
                    {   $newFileName=$ppu."_".date('Ymdhis')."_".preg_replace("/\s+/", "_", $_FILES['txtUpload_file']['name']);
                        $fpath_new=base_url().'upload/surat/'.$newFileName; 
                        $xfile= substr($fpath_old,strrpos($fpath_old, '/', -1)+1)   ; //cari nama file
                        if(file_exists('./upload/surat/'.$xfile)  and strrpos($fpath_old, '/', -1)>0 ) {
                                unlink('./upload/surat/'.$xfile);
                        }
                      //  $dataUpdate['file_path'] = base_url().'upload/surat/'.trim($newFileName);
                    }
            }
            if(strlen(trim($fpath_new))>0){
                $sql="update wos.tb_surat set lampiran='".$fpath_new."' where no_surat='".$dataUpdate['txtUploadNoSurat']."'";
                $result=$this->db->query($sql);
                $this->session->set_flashdata('message','Berhasil Update Lampiran No. Dokumen <b>'.$dataUpdate['txtUploadNoSurat'].'</b> !!!');
        
            }
            //------------------------------------------------------------------------end attach ------------------
        }        
       $this->contentManagement();
    }
    public function f_submit(){
        $fpath_old=""; $fpath_new="";
        $tgl_create=date("Y-m-d H:i:s");
        $data=$this->input->post();
        $dataUpdate = array();
        foreach ($data as $key => $value) {
           $dataUpdate[$key] = $value;
        }
        //----------------------------set nomor dokumen -------------------------------------
        // or $dataUpdate['f_status']==='EDIT'
        if($dataUpdate['f_status']==='NEW'){
            $kodefikasi=$dataUpdate['txtSekunder'].'/WB-'.$dataUpdate['txtKdPAT'];
          //  $sql="select seq from wos.ms_no_dokumen where tahun='".date("Y")."' and no_dokumen='".$dataUpdate['txtSekunder']."'";
            $sql="select seq from wos.ms_no_dokumen where tahun='".date("Y")."' and no_dokumen='".$kodefikasi."'";
            $sql = $this->db->query($sql);
            if($sql->num_rows()<1){
                $noseq='0001';
            }else{
                $getData=$sql->result_array();
                foreach ($getData as $row){
                    $noseq= sprintf("%04d",(float)$row['SEQ']+1);
                }
            }
            $no_dokumen=$dataUpdate['txtSekunder'].'/WB-'.$dataUpdate['txtKdPAT'].".".$noseq.'/'.date("Y")  ;        
            if($noseq==='0001'){
                /*
                $sql="insert into wos.ms_no_dokumen(tahun,no_dokumen,seq,created_date,created_by) values("
                   . "'".date("Y")."','".$dataUpdate['txtSekunder']."','".$noseq."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
                 */
                 $sql="insert into wos.ms_no_dokumen(tahun,no_dokumen,seq,created_date,created_by) values("
                   . "'".date("Y")."','".$kodefikasi."','".$noseq."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
               
            }else{
              //  $sql="update wos.ms_no_dokumen set seq='".$noseq."',updated_date=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),updated_by='".$this->session->userdata('s_uID')."' where tahun='".date("Y")."' and no_dokumen='".$dataUpdate['txtSekunder']."'";
                  $sql="update wos.ms_no_dokumen set seq='".$noseq."',updated_date=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),updated_by='".$this->session->userdata('s_uID')."' where tahun='".date("Y")."' and no_dokumen='".$kodefikasi."'";
            }
        }
        //-----------------------------------------------------------------------------------
        $config['upload_path']          = './upload/surat';
        $config['allowed_types']        = 'gif|jpg|png|jpg|pdf';
        $config['max_size']             = 10000000;
        $filename_upload=$_FILES['txtUpload_file']['name'];
        if (is_uploaded_file($_FILES['txtUpload_file']['tmp_name'])) {
            $ext = explode('.', $filename_upload);
            $ext = $ext[1];
            $newFileName = $config['file_name'] =    $dataUpdate['txtKdPAT']."_".date('Ymdhis')."_".$filename_upload;//.".".$ext;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('txtUpload_file'))
                {
                    $this->session->set_flashdata('message','Uploading error !!!');
                    echo $this->upload->display_errors();
                    die();
                }
                else
                {   $newFileName=$dataUpdate['txtKdPAT']."_".date('Ymdhis')."_".preg_replace("/\s+/", "_", $_FILES['txtUpload_file']['name']);
                    if(isset($dataUpdate['txtLampiran'])){$fpath_old=$dataUpdate['txtLampiran'];}else{$fpath_old='';}
                    $fpath_new=base_url().'upload/surat/'.$newFileName; 
                    $xfile= substr($fpath_old,strrpos($fpath_old, '/', -1)+1)   ; //cari nama file
                    if(file_exists('./upload/surat/'.$xfile)  and strrpos($fpath_old, '/', -1)>0 ) {
                            unlink('./upload/surat/'.$xfile);
                    }
                    $dataUpdate['file_path'] = base_url().'upload/surat/'.trim($newFileName);
                }
        }
        if($dataUpdate['f_status']==='EDIT'){
            if($fpath_new<>''){ // tgl_surat,tujuan_surat,perihal,lampiran 
                $sql="update wos.tb_surat set tgl_surat=to_date('".$dataUpdate['txtTgl_surat']."','dd-mm-yyyy') ,   perihal='".$dataUpdate['txtPerihal']."',   lampiran='".$fpath_new."', "
                . " updated_date=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'), "
                . " updated_by='".$this->session->userdata('s_uID')."' where no_surat='".$dataUpdate['txtNo_surat']."' ";
            }else{
                $sql="update wos.tb_surat set tgl_surat=to_date('".$dataUpdate['txtTgl_surat']."','dd-mm-yyyy') ,    "
                . " updated_date=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'), perihal='".$dataUpdate['txtPerihal']."', "
                . " updated_by='".$this->session->userdata('s_uID')."' where no_surat='".$dataUpdate['txtNo_surat']."'";
            }
            $result=$this->db->query($sql);
            $sql="delete from  wos.tb_tujuan_surat where no_surat='".$dataUpdate['txtNo_surat']."' and tipe='2'";
            $result=$this->db->query($sql);
            for($i=0;$i<count( $dataUpdate['txtTujuanEx']);$i++){
                $seq=rand(1,1000);
                $sql="insert into wos.tb_tujuan_surat(no_surat,seq,eksternal,tipe,created_date,created_by) values('"
                    .$dataUpdate['txtNo_surat']."',".$seq.",'".$dataUpdate['txtTujuanEx'][$i]."','2',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
                  $result=$this->db->query($sql);
            }
            $this->session->set_flashdata('message','Dokumen surat nomor <b>'.$dataUpdate['txtNo_surat'].'</b> berhasil diupdate diupdate !!!');
        }
        if($dataUpdate['f_status']==='NEW'){
            $this->session->set_flashdata('message','Berhasil Simpan Dokumen dengan Nomor <b>'.$no_dokumen.'</b> ');
            $result = $this->db->query($sql);
            $sql="insert into wos.tb_surat(no_surat,tgl_surat,employee_pengirim,jabatan_pengirim,kd_pat_pengirim,kd_gas_pengirim,perihal,lampiran,created_date,created_by ) values("
                . "'".$no_dokumen."',to_date('".$dataUpdate['txtTgl_surat']."','dd-mm-yyyy'),'".$this->session->userdata('s_uID')."',"
                . "'".$this->session->userdata('s_uJBT')."','".$this->session->userdata('s_uPAT')."','".$this->session->userdata('s_uGAS')."',"
                . "'".$dataUpdate['txtPerihal']."','".$fpath_new."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
            //echo $sql;
			$result=$this->db->query($sql);
            $sql="update wos.tb_tujuan_surat set no_surat='".$no_dokumen."'  where no_surat='".$this->session->userdata('s_uID')."'";
            $result=$this->db->query($sql);
            for($i=0;$i<count( $dataUpdate['txtTujuanEx']);$i++){
                $seq=rand(1,1000);
                if(strlen($dataUpdate['txtTujuanEx'][$i])>0){
                    $sql="insert into wos.tb_tujuan_surat(no_surat,seq,eksternal,tipe,created_date,created_by) values('"
                        .$no_dokumen."',".$seq.",'".$dataUpdate['txtTujuanEx'][$i]."','2',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
                    $result=$this->db->query($sql);
                }
            }
        }
      $this->contentManagement();
    }
    public function f_download(){
        $data=$this->input->post();
        $dataUpdate = array();
        foreach ($data as $key => $value) {
           $dataUpdate[$key] = $value;
        }
        $filter="";
        if($dataUpdate['txtKode_Dokumen']<>'')$filter.=" AND A.NO_SURAT LIKE '".$dataUpdate['txtKode_Dokumen']."%' ";
        if($dataUpdate['txtTGL_AWL']<>'')$filter.=" AND A.TGL_SURAT >= to_date('".$dataUpdate['txtTGL_AWL']."','dd-mm-yyyy') ";
        if($dataUpdate['txtTGL_AHR']<>'')$filter.=" AND A.TGL_SURAT >= to_date('".$dataUpdate['txtTGL_AWL']."','dd-mm-yyyy') ";
        
        //array(3) { ["txtKode_Dokumen"]=> string(8) "IN.03.00" ["txtTGL_AWL"]=> string(10) "16-10-2018" ["txtTGL_AHR"]=> string(10) "08-10-2018" }
        $sql="select A.NO_SURAT,to_char(A.TGL_SURAT,'dd-mm-yyyy')TGL_SURAT,A.PERIHAL,
                TRIM(B.FIRST_TITLE||' '||B.FIRST_NAME||' '||B.LAST_NAME||' '||B.LAST_TITLE )NAMA_PENGIRIM,
                C.KET JBT_PENGIRIM,D.KET PAT_PENGIRIM,E.KET GAS_PENGIRIM,
                F.PAT PAT_KIRIM,F.GAS GAS_KIRIM,F.NAMA_INTERNAL,F.JABATAN,F.EKSTERNAL,F.TIPE,F.SEQ
                from wos.tb_surat A
                left join wos.personal B on A.EMPLOYEE_PENGIRIM=B.EMPLOYEE_ID
                left join wos.TB_JBT C on A.JABATAN_PENGIRIM=C.KD_JBT
                left join wos.TB_PAT D ON A.KD_PAT_PENGIRIM = D.KD_PAT
                left join wos.TB_GAS E ON A.KD_GAS_PENGIRIM = E.KD_GAS
                left join (select A.NO_SURAT,A.TIPE,A.SEQ,  B.KET PAT,C.KET GAS,TRIM(D.FIRST_TITLE||' '||D.FIRST_NAME||' '||D.LAST_NAME||' '||D.LAST_TITLE )NAMA_INTERNAL,
                E.KET JABATAN,A.EKSTERNAL
                from wos.tb_tujuan_surat A  left join TB_PAT B on A.KD_PAT=B.KD_PAT
                left join wos.TB_GAS C on A.KD_GAS=C.KD_GAS
                left join wos.PERSONAL D on A.EMPLOYEE_ID=D.EMPLOYEE_ID 
                left join wos.TB_JBT E on A.KD_JBT=E.KD_JBT  order by A.TIPE
                )F on A.NO_SURAT = F.NO_SURAT
                WHERE  length(A.NO_SURAT)>0 ".$filter."  order by A.NO_SURAT,F.TIPE,A.TGL_SURAT desc";
        
        $sql = $this->db->query($sql);
        if($sql->num_rows()<1){
            $this->session->set_flashdata('message','Dokumen tidak ditemukan !!!');
        }else{
            $fileName='download/Daftar Surat.xlsx';
       
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle("Daftar Nomor Surat");
            $col=0;$row=1;
            $header= array('NO. SURAT','TGL. SURAT','PERIHAL','NAMA PENGIRIM','JABATAN PENGIRIM','UNIT KERJA PENGIRIM','BIRO/SEKSI PENGIRIM',
                'UNIT KERJA TUJUAN','BIRO/SEKSI TUJUAN','NAMA PEGAWAI DITUJU','JABATAN PEGAWAI DITUJU','TUJUAN EKSTERNAL');
           foreach ($header as $opt) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $opt);$col++;
            }
            $row=2;$last_rowExt=0;
            $getData=$sql->result_array();
            $cur_doc='';$row_awal_ext=0;$last_a=0;$last_b=0;
            foreach ($getData as $rowdata){
                foreach ($header as $opt)
                {  $col = 0;
                //  F.PAT PAT_KIRIM,F.GAS GAS_KIRIM,F.NAMA_INTERNAL,F.JABATAN,F.EKSTERNAL,F.TIPE,F.SEQ
                    if($cur_doc<>$rowdata['NO_SURAT']){
                        $cur_doc=$rowdata['NO_SURAT'];
                        if($rowdata['TIPE']==='1'){
                           // if($row>2)$row=$row-$row_awal_ext+1;
                            $row_awal_ext = $row;
                        }else{$row_awal_ext=0;}
                        $cur_doc=$rowdata['NO_SURAT'];
                        if($row>2){ 
                           // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row,'[awal]'. $last_a.' [ahir]'.$last_b.'['.$rowdata['NO_SURAT'].'['.$last_rowExt);
                           //if($last_srt<$row)$row=$last_rowExt+1;
                           if($last_a===$last_b)$row=$last_a+1;
                           if($last_a>$last_b)$row=$last_a+1; 
                           if($last_b>$last_a)$row=$last_b+1;  
                            $row_awal_ext = $row;
                           // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row,'[awal]'. $last_a.' [ahir]'.$last_b.'['.$rowdata['NO_SURAT'].'['.$last_rowExt);
                        }
                    }else{  /*$col= 7;*/   }
                   if($rowdata['TIPE']==='1'){
                        $last_a=$row;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['NO_SURAT']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['TGL_SURAT']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['PERIHAL']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['NAMA_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['JBT_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['PAT_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['GAS_PENGIRIM']);$col++;
                  
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['PAT_KIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['GAS_KIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['NAMA_INTERNAL']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rowdata['JABATAN']);$col++;
               
               //         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $row);
                 //       $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $row_awal_ext);
                  //      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $last_rowExt);
               
                    }else{
                        $last_b=$row_awal_ext;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['NO_SURAT']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['TGL_SURAT']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['PERIHAL']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['NAMA_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['JBT_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['PAT_PENGIRIM']);$col++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_awal_ext, $rowdata['GAS_PENGIRIM']);$col++;
                      //if($row===$row_awal_ext)
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row_awal_ext, $rowdata['EKSTERNAL']);
                    }
                    
                }
                if($rowdata['TIPE']==='2'){$row=$row_awal_ext;$row_awal_ext++;$last_rowExt=$row_awal_ext;}
                //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $row.' [TES]'.$rowdata['NO_SURAT']);
                  
                if($row_awal_ext>0)$row++;
                //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $row.' [TES]'.$rowdata['NO_SURAT']);
                
            }
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($fileName);
            // download file
            header("Content-Type: application/vnd.ms-excel");
            redirect($fileName);
            
        }
    }
    public function initGridInvite(){
            $paramsGrid["source"]["ID"] = "INVITE";
            $i=0;
            //Actions Columns
            //Actions
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ID";
            $paramsGrid["source"]["datafields"][$i]["name"]="ID";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="ID";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="2%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="seq";
            $paramsGrid["source"]["datafields"][$i]["name"]="seq";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="SEQ";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="no_surat";
            $paramsGrid["source"]["datafields"][$i]["name"]="no_surat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="No. Surat";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="kd_pat";
            $paramsGrid["source"]["datafields"][$i]["name"]="kd_pat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="kd_pat";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_pat";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_pat";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="UNIT KERJA";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="21%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="kd_gas";
            $paramsGrid["source"]["datafields"][$i]["name"]="kd_gas";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="kd_gas";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="15%";
            $paramsGrid["columns"][$i]["cellsalign"]="center";
            $paramsGrid["columns"][$i]["hidden"]="true";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_gas";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_gas";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="BIRO/SEKSI";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="25%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="employee_id";
            $paramsGrid["source"]["datafields"][$i]["name"]="employee_id";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="NIP";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="7%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="nama_diundang";
            $paramsGrid["source"]["datafields"][$i]["name"]="nama_diundang";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="NAMA PEGAWAI";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="20%";
            $paramsGrid["columns"][$i]["cellsalign"]="left";
            $paramsGrid["columns"][$i]["hidden"]="false";
            $i++;
            $paramsGrid["source"]["datafields"][$i]["dbfieldname"]="ket_jbt";
            $paramsGrid["source"]["datafields"][$i]["name"]="ket_jbt";
            $paramsGrid["source"]["datafields"][$i]["type"]="string";
            $paramsGrid["columns"][$i]["text"]="JABATAN";
            $paramsGrid["columns"][$i]["datafield"]=$paramsGrid["source"]["datafields"][$i]["name"];
            $paramsGrid["columns"][$i]["width"]="27%";
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
    public function list_Invite($filter="get"){
        $filter= str_replace('_','/', $filter);
        $errMsg = "";$recPerPage = 15;$currPage = 1;$where = ""; $filter_user="";// $user_level = 0[Admin]  1[user]
        if(isset($_GET["pagenum"]))$currPage = intval($_GET["pagenum"])+1;
        if(isset($_GET["pagesize"]))$recPerPage = intval($_GET["pagesize"]);
        $this->load->library('AdodbConn');
        $conn = $this->adodbconn->getOraConn("OS");//$conn = $this->adodbconn->getMySqlConn("hcis");
        $this->load->helper('erp_wb_helper');
        if(isset($_GET["filterscount"]))$where = genJQWFilterSQL($this->initGridInvite()) ;
        $query="select a.no_surat id,a.seq,a.no_surat,a.kd_pat,b.ket ket_pat,a.kd_gas,c.ket ket_gas,a.employee_id, 
                trim(d.first_title||' '||d.first_name||' '||d.last_name||d.last_title)nama_diundang,e.ket ket_jbt from tb_tujuan_surat a 
                left join tb_pat b on a.kd_pat=b.kd_pat
                left join tb_gas c on a.kd_gas=c.kd_gas
                left join personal d on a.employee_id=d.employee_id
                left join tb_jbt e on a.kd_jbt=e.kd_jbt
                where a.no_surat='".$filter."' and tipe='1' ".$where;      //." order by a.tgl_surat,a.no_surat desc";
        $arrParamData = array();
        $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
        if($rst){
                $total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
                if($rst->recordCount()>0){
                        for($i=0;$i<$rst->recordCount();$i++){
                                $arrData[] = array(
                                    'ID' => $rst->fields["ID"],
                                    'seq' => $rst->fields["SEQ"],
                                    'no_surat' =>  $rst->fields["NO_SURAT"],
                                    'kd_pat' =>  $rst->fields["KD_PAT"],
                                    'ket_pat' =>  $rst->fields["KET_PAT"],
                                    'kd_gas' =>  $rst->fields["KD_GAS"],
                                    'ket_gas' =>  $rst->fields["KET_GAS"],
                                    'employee_id' =>  $rst->fields["EMPLOYEE_ID"],
                                    'nama_diundang' =>  $rst->fields["NAMA_DIUNDANG"],
                                    'ket_jbt' =>  $rst->fields["KET_JBT"],
                                    'FLAG_DATA' => "0"
                                    );	 
                                $rst->moveNext();
                        }
                }else{
                        $total_rows = 0;
                        $arrData[] = array(
                                'ID' => "",
                                'seq' => "",
                                'no_surat' =>  "",
                                'kd_pat' =>  "",
                                'ket_pat' =>  "",
                                'kd_gas' =>  "",
                                'ket_gas' =>  "",
                                'employee_id' =>  "",
                                'nama_diundang' =>  "",
                                'ket_jbt' =>  "",
                                'FLAG_DATA' => "0"
                            ); 
                }
        }else{
                $total_rows = 0;
                $arrData[] = array(
                    'ID' => "",'seq' => "",
                    'no_surat' =>  "",
                    'kd_pat' => "",
                    'ket_pat' => "",
                    'kd_gas' => "",
                    'ket_gas' =>  "",
                    'employee_id' =>  "",
                    'nama_diundang' =>  "",
                    'FLAG_DATA' => "0"
                );
        }
		//$errMsg = $query;
	$data[] = array(
           'where' => $query,
           'TotalRows' => $total_rows,
           'Rows' => $arrData,
           'ErrorMsg'=>$errMsg
        );
        print_r(json_encode($data,JSON_PRETTY_PRINT));   
    }
    public function View_Data($param="get") {
        $param= str_replace('_','/', $param);
        $params=[];
        $params["title"]="Form Permintaan Nomor Surat";
        
        $params["grid"] = $this->initGridInvite();
        $sql="select no_surat,to_char(tgl_surat,'dd-mm-yyyy')tgl_surat ,to_char(a.created_date,'dd-mm-yyyy')created_date,   employee_pengirim,
            trim(e.first_title||' '||e.first_name||' '||e.last_name||' '||e.last_title)nama_pengirim,
            f.ket jabatan_pengirim,
            kd_pat_pengirim,g.ket ket_pat_pengirim,
            kd_gas_pengirim,h.ket ket_gas_pengirim,
            tujuan_surat,perihal,lampiran,
            b.kd_dokumen kd_induk,b.ket_masalah_induk,c.kd_dokumen kd_primer,c.ket_masalah_primer,d.kd_dokumen kd_sekunder, d.ket_masalah_sekunder
             from wos.tb_surat a
             inner join wos.ms_kode_masalah b on substr(a.no_surat,1,2) = trim(b.kd_dokumen) 
             inner join wos.ms_kode_masalah c on substr(a.no_surat,1,5) = trim(c.kd_dokumen) 
             inner join wos.ms_kode_masalah d on substr(a.no_surat,1,8) = trim(d.kd_dokumen) 
             inner join wos.personal e on a.employee_pengirim=e.employee_id
             left join wos.tb_jbt f on a.jabatan_pengirim=f.kd_jbt
             left join wos.tb_pat g on a.kd_pat_pengirim=g.kd_pat
             left join wos.tb_gas h on a.kd_gas_pengirim=h.kd_gas
            where no_surat=trim('".$param."')";
        $getData = $this->db->query($sql)->result_array();
        if(count($getData)>0){
            foreach ($getData as $row){
                $params['no_surat'] = $row['NO_SURAT'];
                $params['tgl_surat']=$row['TGL_SURAT'];
                $params['created_date']=$row['CREATED_DATE'];
                $params['employee_pengirim']=$row['EMPLOYEE_PENGIRIM'];
                $params['nama_pengirim']=$row['NAMA_PENGIRIM'];
                $params['jabatan_pengirim']=$row['JABATAN_PENGIRIM'];
                $params['kd_pat_pengirim']=$row['KD_PAT_PENGIRIM']; 
                $params['ket_pat_pengirim']=$row['KET_PAT_PENGIRIM'];
                $params['kd_gas_pengirim']=$row['KD_GAS_PENGIRIM']; 
                $params['ket_gas_pengirim']=$row['KET_GAS_PENGIRIM'];
                $params['tujuan_surat']=$row['TUJUAN_SURAT'];
                $params['perihal']=$row['PERIHAL'];
                $params['lampiran']=$row['LAMPIRAN'];
                $params['kd_induk']=$row['KD_INDUK'];
                $params['ket_masalah_induk']=$row['KET_MASALAH_INDUK'];
                $params['kd_primer']=$row['KD_PRIMER'];
                $params['ket_masalah_primer']=$row['KET_MASALAH_PRIMER'];
                $params['kd_sekunder']=$row['KD_SEKUNDER'];
                $params['ket_masalah_sekunder']=$row['KET_MASALAH_SEKUNDER'];
                
            }
            $sql="select no_surat,seq,eksternal,tipe from wos.tb_tujuan_surat where no_surat=trim('".$param."') and tipe='2'";
            $tujuan_external=[];
            $getData = $this->db->query($sql)->result_array();
            if(count($getData)>0){
                foreach ($getData as $row){
                    array_push($tujuan_external,$row['EKSTERNAL']);
                }
            }
            $params['aTujuanExt']=$tujuan_external;
            if($params['employee_pengirim']!==$this->session->userdata('s_uID')){
            $params["f_status"]="VIEW";    
            }else{$params["f_status"]="EDIT";}
             $this->render_view('hr/surat/edit_data', $params);
        }
    }
    public function newData(){
        $params["title"]="Form Permintaan Nomor Surat";
        $params["f_status"]="NEW";
        $params["grid"] = $this->initGridInvite();
	$this->render_view('hr/surat/edit_data', $params);
    }
    public function HapusSurat(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $tgl_create=date("Y-m-d H:i:s");
        $sql= "update wos.tb_surat set  flag_hapus='Y',updated_by='".$this->session->userdata('s_uID')."',"
                . "alasan_hapus='".$data[1]."', updated_date=to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss')  where no_surat='".$data[0]."' ";  
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Hapus No. surat <b>'.$data[0].'</b> ');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function del_diundang(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $filter = "";$info="";
        if(strlen(trim($data[1]))>0)$info.= trim($data[1]);
        if(strlen(trim($data[2]))>0){$info.=">"; $info.= trim($data[2]);}
        if(strlen(trim($data[3]))>0){$info.=">"; $info.= trim($data[3]);}
      
       
        $sql= "delete from wos.tb_tujuan_surat where no_surat='".$data[0]."'  and seq=".$data[4];  
        $result=$this->db->query($sql);
        $this->session->set_flashdata('message','Berhasil Hapus  <b>'.$info.'</b> ');
        print_r(json_encode($sql,JSON_PRETTY_PRINT));
    }
    public function save_diundang(){
        $tgl_create=date("Y-m-d H:i:s");
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $sql="insert into wos.tb_tujuan_surat(seq,tipe,no_surat,employee_id,kd_pat,kd_gas,kd_jbt,created_date,created_by)"
           . "values(".$data[6].",'".$data[7]."','".$data[5]."','".$data[4]."','".$data[1]."',"
           . "'".$data[2]."','".$data[3]."',to_date('".$tgl_create."','yyyy-mm-dd hh24:mi:ss'),'".$this->session->userdata('s_uID')."')";
        $result=$this->db->query($sql);
        print_r(json_encode($result,JSON_PRETTY_PRINT));
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
       $query="select TGL,KD_PAT,EMPLOYEE_ID,TIMERECORD,IN_STATUS,UPLOAD_BY,UPLOAD_DATE from hrms.ABSENSI_FGR_PRINT2 where KD_PAT='0A' and TO_CHAR(tgl, 'YYYY') = to_char(sysdate,'YYYY') and 
                ((TO_CHAR(tgl,'mm')=to_char(sysdate,'mm')-1 and 
                 TO_CHAR(tgl,'dd')>'20') or (TO_CHAR(tgl,'mm')=to_char(sysdate,'mm') and TO_CHAR(tgl,'dd')<='19')) and REGEXP_LIKE(substr(EMPLOYEE_ID,3), '^-?[0-9]+(\.[0-9]+)?$') "
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
                                                'KD_PAT' =>  $rst->fields["KD_PAT"],
                                                'EMPLOYEE_ID' =>  $rst->fields["EMPLOYEE_ID"],
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
    
}
