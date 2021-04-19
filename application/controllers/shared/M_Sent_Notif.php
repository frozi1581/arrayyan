<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Sent_Notif extends CI_Controller {
	/**
	 * Copyright
	 * Auth:Wase
	 * Oct 2018
	 */
	 
	var $oraConn = "WFINANCE";
	var $sqlLookup01="";
	var $sqlLookup02="";
	var $sqlLookup03="";
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        
    }
	public function render_view($content = "main", $params = array()){
	
	}
	public function errorPage($value=''){
	    $this->render_view('error');
	}
	public function index(){
		$this->load->helper(array('form','url','download'));
		$this->load->library('session');
		
    }
	
    public function sentWA(){
	    $this->load->helper('wa_helper');
	    $phone  = "6281280295218";
	    $body = "*System HCIS PT WIKA BETON, TBK :* \n\nAnda mendapatkan tambahan Hak Cuti Tahun 2019 dengan rincian sebagai berikut :\n";
	    $body .= "Hak Cuti Tahun 2018         : _10_ hari\n";
	    $body .= "Hak Cuti Tahun 2019         : _12_ hari\n";
	    $body .= "Hak Extra Cuti Tahun 2019\s\s\s: _5_ hari\n";
	    $body .= "Total Hak Cuti Anda Menjadi : _27_ hari\n";
	    
	    $hasilSentWA = sendWAMessage($phone,$body);
	    print_r($hasilSentWA);
	    
    }
	
	
}
