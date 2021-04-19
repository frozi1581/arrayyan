<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KalenderLiburController extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Jakarta');

        //load model
        $this->load->model('hr/KalenderLiburModel');
    }
    
    public function render_view($content = "main", $params = array()){
        $strBaseUrl=base_url()."hr/kalender-libur/v_kalender_libur";
        //$this->session->set_userdata($this->getPPUData());
        $this->load->view('shared/header',$params);
        $this->load->view('shared/sidebar',$params);
        $this->load->view($content,$params);
        //$this->load->view('shared/footer',$params);
    }
    public function errorPage($value='')
    {
        $this->render_view('error');
    }
    public function index() {
        $this->load->helper(array('form','url','download'));
        $this->contentManagement();
    }   

    public function contentManagement(){
        $params["title"]="Kalender Libur";
        //$params["grid"] = $this->initGrid();
        //$this->render_view('os/produksi/v_m_trans_produksi_list', $params);
        //$this->load->library('Wb_Security');
        //$isessid="";
        //if(isset($_GET["sessid"]))$isessid = $_GET["sessid"];
        //$this->wb_security->id_session = $isessid;
        //$this->session->set_userdata($this->wb_security->cekSession());
        
        //if($this->session->userdata('TMP_NIP')!==""){
        
        
        $this->render_view('hr/kalender-libur/v_kalender_libur', $params);
        
        //}else{
        //	redirect('http://erp.wika-beton.co.id');
        //}
    }

    public function getAllList() {
        $result = $this->KalenderLiburModel->getData();

        echo json_encode($result);
    }
    public function create() {
        $ket        = $this->input->post('KETERANGAN');
        $status     = $this->input->post('STATUS');

        $chkdt      = $this->input->post('TGL');
        $chkdtarr   = explode("GMT",$chkdt);
        $newdt      = strtotime($chkdtarr[0]);
        $date       = date("Y-m-d",$newdt);

        $this->KalenderLiburModel->create($date, $ket, $status);
    }
    public function update() {
        $date         = $this->input->post('TGL');
        $ket          = $this->input->post('KETERANGAN');
        $status       = $this->input->post('STATUS');

        $this->KalenderLiburModel->update($date, $ket, $status);
    }
    public function delete() {
        $date         = $this->input->post('TGL');

        $this->KalenderLiburModel->delete($date);
    }
}