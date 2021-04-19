<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_login extends CI_Controller {
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
        
    }
	
    public function render_view($content = "main", $params = array()){
		$this->load->view($content,$params);
    }
    public function errorPage($value='')
    {
        $this->render_view('error');
    }

    public function index()
	{
		$this->load->library('session');
		$this->load->helper(array('form','url','download'));
		$username = isset($_POST["username"])?$_POST["username"]:"";
		$passwd = isset($_POST["pass"])?$_POST["pass"]:"";
		
		if($username!=="" && $passwd!=""){
			$this->load->library('AdodbConnMySQL');
			$conn = $this->adodbconnmysql->getMySQLConn("HR");
			$this->load->helper('erp_wb_helper');
			
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			$sql="select user_id, passwd from m_users where user_id like ?";
			$arrBindParam = array($username);
			$rst = $conn->Execute($sql,$arrBindParam);
			if($rst){
				if($rst->recordCount()>0){
					if($rst->fields["passwd"]==$passwd){
						$this->session->set_userdata('user_id', $username);
						redirect('kkms/M_kepemilikan2');
					}
				}
			}
		}
        $this->contentManagement();
    }
    

    public function contentManagement(){
		$params="";
		$this->render_view('login/v_login', $params);
    }
    
}
