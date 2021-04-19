<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_Data_WP extends CI_Controller {
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
	
	public function getOK($kdpat="1%"){
		$retVal = 0;
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");
		$this->load->helper('erp_wb_helper');
		$query="select round(sum(ri_perolehan)/1000000000,1) as JML_OK from rpt_ok_by_date where kd_pat like :filterKdPat and tgl like sysdate";
		$arrParamData=array( "filterKdPat"=>$kdpat);
		$rst=$conn->Execute($query,$arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				$retVal = $rst->fields["JML_OK"];
			}
		}
		
		print_r(json_encode($retVal,JSON_PRETTY_PRINT));
	}
	
	public function getOP($kdpat="1%"){
		$retVal = 0;
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");
		$this->load->helper('erp_wb_helper');
		$query="select round(sum(ri_perolehan)/1000000000,1) as JML_OP from rpt_op_by_date where kd_pat like :filterKdPat and tgl like sysdate";
		$arrParamData=array( "filterKdPat"=>$kdpat);
		$rst=$conn->PageExecute($query,200,1, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				$retVal = $rst->fields["JML_OP"];
			}
		}
		
		print_r(json_encode($retVal,JSON_PRETTY_PRINT));
	}
		
    public function getOKRaByWP(){
		$retVal = array();
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");
		$this->load->helper('erp_wb_helper');
		$query="select kd_pat, round(sum(rkap)/1000000000,1) as RKAP_BY_WP from rpt_ok_by_date where tgl like sysdate and kd_pat !='WB' group by kd_pat order by kd_pat";
		$arrParamData=array();
		$rst=$conn->PageExecute($query,200,1, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				while(!$rst->EOF){
					$retVal[] = $rst->fields["RKAP_BY_WP"];
					$rst->moveNext();
				}
			}
		}
		
		print_r(json_encode($retVal,JSON_PRETTY_PRINT));
	}
	
	public function getOKRiByWP(){
		$retVal = array();
		$this->load->library('AdodbConn');
		$conn = $this->adodbconn->getOraConn("OS");
		$this->load->helper('erp_wb_helper');
		$query="select round(sum(ri_perolehan)/1000000000,1) as OK_BY_WP from rpt_ok_by_date where tgl like sysdate and kd_pat !='WB' group by kd_pat order by kd_pat";
		$arrParamData=array();
		$rst=$conn->PageExecute($query,200,1, $arrParamData);
		if($rst){
			if($rst->recordCount()>0){
				while(!$rst->EOF){
					$retVal[] = $rst->fields["OK_BY_WP"];
					$rst->moveNext();
				}
			}
		}
		
		print_r(json_encode($retVal,JSON_PRETTY_PRINT));
	}
	
}
