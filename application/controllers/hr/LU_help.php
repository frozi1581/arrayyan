<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LU_help extends CI_Controller {
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
	
	public function getLookupSelect2($lookupTable){    //($kd_pat="get"){
		$filterQuery  = "%";
		$filterQuery .= isset($_GET['q']) ?  $_GET['q'] : '';
		$filterQuery .= "%";
		$strsql="";
		$limitRows = 20;
		
		$this->load->library('LookupData');
		$this->lookupdata->oraConn = "HR";
		switch($lookupTable){
			case "ppu":
				$strsql="select kd_pat as ID, ket as text from tb_pat where kd_pat LIKE '1%' ";
				$strsql.=" and (upper(kd_pat) like upper('$filterQuery') or upper(ket) like upper('$filterQuery') ) and rownum < $limitRows";
				$strsql.=" order by 2 ";
				break;
			case "pat":
				$strsql="select kd_pat as ID, ket as text from tb_pat where kd_pat <> 'X' ";
				$strsql.=" and (upper(kd_pat) like upper('$filterQuery') or upper(ket) like upper('$filterQuery') ) and rownum < $limitRows";
				$strsql.=" order by 2 ";
				break;
			case "nip":
				$strsql="select employee_id as ID, employee_id || ' - ' || trim(first_name || ' ' || last_name) as text from personal where st like '1' ";
				$strsql.=" and (upper(employee_id) like upper('$filterQuery') or upper(trim(first_name || ' ' || last_name)) like upper('$filterQuery') ) and rownum < $limitRows";
				$strsql.=" order by 2 ";
				break;
			default:
				break;
		}
		$this->lookupdata->sql =$strsql;
		
		echo $this->lookupdata->getSelect2Data();
	}
	
    public function getLookupDokumenSurat(){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "OS";//$this->lookupdata->mySqlConn = "hcis"; 
        $this->lookupdata->sql = "select distinct substr(kd_dokumen,1,8)ID,substr(kd_dokumen,1,8)kd_dokumen,ket_masalah_sekunder from ms_kode_masalah where length(kd_dokumen)=8 ";
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();
    }
      public  function LU_KD_SURAT(){
        $params=[];
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $filter    = json_decode($json);
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup01 ="select distinct substr(kd_dokumen,1,8)ID,substr(kd_dokumen,1,8)kd_dokumen,ket_masalah_sekunder from ms_kode_masalah where length(kd_dokumen)=8 ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupDokumenSurat/".$filter;
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKD_DOKUMEN","targetDataField"=>"KD_DOKUMEN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_MASALAH_SEKUNDER","targetDataField"=>"KET_MASALAH_SEKUNDER");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Kode Dokumen";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="Keterangan Kode Dokumen";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="18%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="75%";
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        //$params["gridLUSEKUNDER"]=genGrid("jqxGridSEKUNDER",$this->lookupdata->initGridLookupMysql(),false,650);
        $params["gridLUDOKUMENSURAT"]=genGrid("jqxGridDOKUMENSURAT",$this->lookupdata->initGridLookup(),false,650);
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
  
    public function getLookupInduk(){    //($kd_pat="get"){
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "OS";//$this->lookupdata->mySqlConn = "hcis"; 
        $this->lookupdata->sql = "select distinct substr(kd_dokumen,1,2)ID,substr(kd_dokumen,1,2)kd_dokumen,ket_masalah_induk from ms_kode_masalah where length(kd_dokumen)>0 ";
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();
    }
    public function getLookupPrimer($filter="get"){   
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "OS";// $this->lookupdata->mySqlConn = "hcis"; 
        $this->lookupdata->sql = "select distinct substr(kd_dokumen,1,5)ID,substr(kd_dokumen,1,5)kd_dokumen,ket_masalah_primer from ms_kode_masalah where substr(kd_dokumen,1,2)='".$filter."' and length(trim(kd_dokumen))>2 ";
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();  
    }
    public function getLookupSekunder($filter="get"){   
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "OS"; //$this->lookupdata->mySqlConn = "hcis";  
        $this->lookupdata->sql = "select distinct substr(kd_dokumen,1,8)ID,substr(kd_dokumen,1,8)kd_dokumen,ket_masalah_sekunder from ms_kode_masalah where substr(kd_dokumen,1,5)='".$filter."' and length(trim(kd_dokumen))>5 ";
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();  
    }
    
    public function getLookupPAT(){   
        $this->load->library('LookupData');
         $this->lookupdata->oraConn = "OS";//$this->lookupdata->mySqlConn = "hcis";  
        $this->lookupdata->sql = "select * from (select kd_pat ID,ket from tb_pat)src where length(ID)>0 ";
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();  //
    }
	public function getLookupPAT2(){
		$filterQuery = isset($_GET['q']) ?  $_GET['q'] : '';
		$filterQuery .= "%";
		$this->load->library('LookupData');
		$this->lookupdata->oraConn = "HR";//$this->lookupdata->mySqlConn = "hcis";
		$this->lookupdata->sql = "select kd_pat as ID,ket as text from tb_pat  ";
		echo $this->lookupdata->getSelect2Data();//echo $this->lookupdata->getGridDataMySql();  //
	}
    public function getLookupGAS(){   
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "HR";//$this->lookupdata->mySqlConn = "hcis";  
       // $this->lookupdata->sql = "select * from (select kd_gas ID,ket from tb_gas)src where length(ID)>0 ";
        $this->lookupdata->sql ="select distinct a.kd_gas,b.ket  
            from personal a
            left join tb_gas b on a.kd_gas=b.kd_gas 
            where  a.st=1 and substr(a.employee_id,1,2)<>'TX'";
            
        echo $this->lookupdata->getGridData();//echo $this->lookupdata->getGridDataMySql();  
    }
    public function getLookupPegawai($filterPAT="get",$filterGAS="get"){   
        $filter="";
        if(strlen(trim($filterPAT))>1 and $filterPAT<>'get')$filter.=" and a.kd_pat='".$filterPAT."' ";
        if(strlen(trim($filterGAS))>1 and $filterGAS<>'get')$filter.=" and a.kd_gas='".$filterGAS."' ";
       
        $this->load->library('LookupData');
        $this->lookupdata->oraConn = "OS";// $this->lookupdata->mySqlConn = "hcis";  
        $this->lookupdata->sql = "select * from (select employee_id ID,
            trim(first_title||' '||first_name||' '||last_name||last_title)employee_name,
                a.kd_pat,b.ket ket_pat,a.kd_gas,c.ket ket_gas,a.kd_jbt,
                trim(c.ket||' ('|| d.ket||')')ket_jbt
                from personal a
                inner join tb_pat b on a.kd_pat=b.kd_pat
                inner join tb_gas c on a.kd_gas=c.kd_gas 
                left join tb_jbt d on a.kd_jbt=d.kd_jbt
                where st='1'  )src where   substr(ID,1,2)<>'TX'";
       echo $this->lookupdata->getGridData();// echo $this->lookupdata->getGridDataMySql();  
    }
    public  function LU_GAS(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        //if(strlen($data[0])>0){
            $this->sqlLookup01 ="select distinct a.kd_gas,b.ket  
            from personal a
            left join tb_gas b on a.kd_gas=b.kd_gas 
            where a.kd_pat='".$data[0]."' and a.st=1 and substr(a.employee_id,1,2)<>'TX'";
            
      /*  }else{
            $this->sqlLookup01 ="select * from (select kd_gas ID,ket from tb_gas where status=1)src where length(ID)>0 ";
        }*/
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupGAS/".$data[0];
        $this->lookupdata->retVal[]=array("destCtrl"=>"txt_ID","targetDataField"=>"KD_GAS");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtGAS","targetDataField"=>"KET");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="Kode GAS";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Nama Biro/Seksi";
        
        $this->lookupdata->customParamsGrid["columns"][0]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="92%";
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        
        //$params["gridLUGAS"]=genGrid("jqxGridGAS",$this->lookupdata->initGridLookupMysql(),false,600);
        $params["gridLUGAS"]=genGrid("jqxGridGAS",$this->lookupdata->initGridLookUp(),false,700);
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
    public  function LU_PAT(){
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup01 ="select * from (select kd_pat ID,ket from tb_pat)src where length(ID)>0 ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupPAT/";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txt_ID","targetDataField"=>"ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtPAT","targetDataField"=>"KET");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="PAT";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Nama PAT/PPU";
        
        $this->lookupdata->customParamsGrid["columns"][0]["width"]="10%";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="80%";
       // $params["gridLUPAT"]=genGrid("jqxGridPAT",$this->lookupdata->initGridLookupMysql(),false,550);
         $params["gridLUPAT"]=genGrid("jqxGridPAT",$this->lookupdata->initGridLookup(),false,550);
        
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
    public  function LU_Pegawai(){
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $data      = json_decode($json);
        
       // $data[0]="";$data[1]="";
        
        
        $filter_pat_gas='';
        if(strlen(trim($data[0]))>1) $filter_pat_gas.=" and a.kd_pat='".$data[0]."'  ";
        if(strlen(trim($data[1]))>1) $filter_pat_gas.=" and a.kd_gas='".$data[1]."'  ";
        
        
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup01 ="select * from (select employee_id ID,
                trim(first_title||' '||first_name||' '||last_name||last_title)employee_name,a.kd_pat,b.ket ket_pat,a.kd_gas,c.ket ket_gas,a.kd_jbt,
                trim(c.ket||' ('|| d.ket||')') ket_jbt   
                from personal a
                inner join tb_pat b on a.kd_pat=b.kd_pat
                inner join tb_gas c on a.kd_gas=c.kd_gas 
                left join tb_jbt d on a.kd_jbt=d.kd_jbt
                where st='1' ".$filter_pat_gas." )src where   substr(ID,1,2)<>'TX' ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupPegawai/".$data[0]."/".$data[1];
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtEMPLOYEE_ID","targetDataField"=>"ID");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtEMPLOYEE_NAMA","targetDataField"=>"EMPLOYEE_NAME");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_PAT","targetDataField"=>"KET_PAT");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_GAS","targetDataField"=>"KET_GAS");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="NIP";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Nama Pegawai";
        $this->lookupdata->customParamsGrid["columns"][3]["text"]="Unit Kerja";
        $this->lookupdata->customParamsGrid["columns"][5]["text"]="Biro/Seksi";
        $this->lookupdata->customParamsGrid["columns"][7]["text"]="Biro/Seksi(Jabatan)";
        
        $this->lookupdata->customParamsGrid["columns"][0]["width"]="9%";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="30%";
        $this->lookupdata->customParamsGrid["columns"][3]["width"]="50%";
        $this->lookupdata->customParamsGrid["columns"][5]["width"]="25%";
        $this->lookupdata->customParamsGrid["columns"][7]["width"]="55%";
        
        $this->lookupdata->customParamsGrid["columns"][5]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][6]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][3]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][2]["hidden"]="true";
        $this->lookupdata->customParamsGrid["columns"][4]["hidden"]="true";
        $params["SQL"]=$this->sqlLookup01 ;
        $params["gridLUNIP"]=genGrid("jqxGridNIP",$this->lookupdata->initGridLookup(),false,1000);
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    } 
    public  function LU_KD_SEKUNDER(){
        $params=[];
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $filter    = json_decode($json);
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup01 ="select distinct   substr(kd_dokumen,1,8)ID,substr(kd_dokumen,1,8)kd_dokumen,ket_masalah_sekunder from ms_kode_masalah where substr(kd_dokumen,1,5)='".$filter."' and length(trim(kd_dokumen))>5 ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupSekunder/".$filter;
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKD_DOKUMEN","targetDataField"=>"KD_DOKUMEN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_MASALAH_SEKUNDER","targetDataField"=>"KET_MASALAH_SEKUNDER");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Kode Dokumen";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="Keterangan Masalah Sekunder";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="18%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="75%";
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        //$params["gridLUSEKUNDER"]=genGrid("jqxGridSEKUNDER",$this->lookupdata->initGridLookupMysql(),false,650);
        $params["gridLUSEKUNDER"]=genGrid("jqxGridSEKUNDER",$this->lookupdata->initGridLookup(),false,850);
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
    public function LU_KD_PRIMER(){
        $params=[];
        $json      = utf8_encode($_POST['json']); // Don't forget the encoding
        $filter    = json_decode($json);
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        $this->sqlLookup01 ="select distinct substr(kd_dokumen,1,5)ID,substr(kd_dokumen,1,5)kd_dokumen,ket_masalah_primer from ms_kode_masalah where substr(kd_dokumen,1,2)='".$filter."' and length(trim(kd_dokumen))>2 ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupPrimer/".$filter;
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKD_DOKUMEN","targetDataField"=>"KD_DOKUMEN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_MASALAH_PRIMER","targetDataField"=>"KET_MASALAH_PRIMER");
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Kode Dokumen";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="Keterangan Masalah Primer";
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="18%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="70%";
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        //$params["gridLUPRIMER"]=genGrid("jqxGridPRIMER",$this->lookupdata->initGridLookupMysql(),false,650);
        $params["gridLUPRIMER"]=genGrid("jqxGridPRIMER",$this->lookupdata->initGridLookup(),false,640);
        print_r(json_encode($params,JSON_PRETTY_PRINT));
    }
    public function LU_KD_INDUK(){
        $this->load->helper('erp_wb_helper');
        $this->load->library('LookupData');
        /*------------------------- end LookUP Kodefikasi Induk----------------*/
        $this->sqlLookup01 ="select distinct substr(kd_dokumen,1,2)ID,substr(kd_dokumen,1,2)kd_dokumen,ket_masalah_induk from ms_kode_masalah where length(kd_dokumen)>0 ";
        $this->oraConn = "OS";//$this->mySqlConn="hcis";
        $this->lookupdata->oraConn = $this->oraConn;//$this->lookupdata->mySqlConn = "hcis";
        $this->lookupdata->urlData=base_url()."hr/LU_help/getLookupInduk";
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKD_DOKUMEN","targetDataField"=>"KD_DOKUMEN");
        $this->lookupdata->retVal[]=array("destCtrl"=>"txtKET_MASALAH_INDUK","targetDataField"=>"KET_MASALAH_INDUK");
        
        $this->lookupdata->extraJS[]=array("extraJS"=>"");    //array("extraJS"=>" fncChangeDetailData();");
        $this->lookupdata->sql = $this->sqlLookup01;
        
        $this->lookupdata->customParamsGrid["columns"][0]["text"]="ID";
        $this->lookupdata->customParamsGrid["columns"][1]["text"]="Kode Dokumen";
        $this->lookupdata->customParamsGrid["columns"][2]["text"]="Keterangan Masalah Induk";
        
        $this->lookupdata->customParamsGrid["columns"][1]["width"]="18%";
        $this->lookupdata->customParamsGrid["columns"][2]["width"]="72%";
        $this->lookupdata->customParamsGrid["columns"][0]["hidden"]="true";
        
        //$params["gridLUINDUK"] = genGrid("jqxGridINDUK",$this->lookupdata->initGridLookupMysql(),false,650);
        $params["gridLUINDUK"] = genGrid("jqxGridINDUK",$this->lookupdata->initGridLookUp(),false,650);
       print_r(json_encode($params,JSON_PRETTY_PRINT));

    }
    
}
