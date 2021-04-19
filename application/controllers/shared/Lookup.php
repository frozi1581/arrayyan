<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lookup extends CI_Controller {
	/**
	 * Copyright
	 * Kumpulan function Lookup
         * content:getUser,getKampus,getJurusan,getJenjang
         * created by wahyu on Jan 18
	 */
    public function __construct(){
        parent::__construct();
       // $this->auth();
        date_default_timezone_set('Asia/Jakarta');
    }
    public function auth(){
         	if (!isset($this->session->userdata['authApp'])) {
			$url='auth/login';
			redirect($url, 'refresh');
		}
    }
     public function getPat($char="get"){
        if(trim($char)<>'-' ){
            $query = "select KD_PAT,KET from wos.tb_pat
                where  KD_PAT like '%".trim($char)."%' or
                       KET like '%".trim($char)."%' 
                        order by  KD_PAT ";
        }else{
            $query = "select KD_PAT,KET from wos.tb_pat";
        } 
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
        foreach ($get_data as $data){
            array_push($item_data, array('KD_PAT'=>$data['KD_PAT'],
                        'KET'=>$data['KET']));
        }
       // print_r(json_encode($item_data,JSON_PRETTY_PRINT));
        echo json_encode($item_data);
       
    }
   
    public function getTagihan($char="get"){
        if(trim($char)<>'-' ){
            $query = "select a.NO_TAGIHAN,a.TGL_TAGIHAN,b.NAMA,a.NO_DOK_MEM 
                from WOS.TAGIHAN_SPB_H a
                inner join WOS.VENDOR b on a.VENDOR_ID=b.VENDOR_ID 
                where  a.NO_TAGIHAN like '%".trim($char)."%' or
                       a.NO_DOK_MEM like '%".trim($char)."%' or
                       a.NAMA like '%".trim($char)."%' or
                       a.TGL_TAGIHAN like '%".trim($char)."%'
                        order by  a.TGL_TAGIHAN desc,a.NO_TAGIHAN desc  
                    ";
        }else{
            $query = "select a.NO_TAGIHAN,a.TGL_TAGIHAN,b.NAMA,a.NO_DOK_MEM 
                from WOS.TAGIHAN_SPB_H a
                inner join WOS.VENDOR b on a.VENDOR_ID=b.VENDOR_ID ";
        } 
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
        foreach ($get_data as $data){
            array_push($item_data, array('NO_TAGIHAN'=>$data['NO_TAGIHAN'],
                        'TGL_TAGIHAN'=>$data['TGL_TAGIHAN'],
                        'NAMA'=>$data['NAMA'],'NO_DOK_MEM'=>$data['NO_DOK_MEM']
                      ));
        }
       // print_r(json_encode($item_data,JSON_PRETTY_PRINT));
        echo json_encode($item_data);
       
    }
    
    
    public function tes($char="get"){
       echo  base64_decode($char);
    }
    
    public function getBAPB(){
        $char=$_POST['data'];
        $query="select a.NO_BAPB,b.KD_MATERIAL,c.URAIAN,b.VOL,b.TGL_RENCANA_PENDATANGAN from WOS.BAPB_H a
                inner join WOS.BAPB_D b on a.NO_BAPB=b.NO_BAPB
                inner join WOS.TR_MATERIAL c on b.KD_MATERIAL=c.KD_MATERIAL 
                where a.NO_SPB='".$char."'";
                
        $result=$this->db->query($query)->result_array();
        $no_bapb_a=[];$kd_material_a=[];$uraian_a=[];$vol_a=[];$tgl_rencana_pendatangan_a=[];
        foreach($result as $data){
            array_push($no_bapb_a,$data['NO_BAPB']);
            array_push($kd_material_a,$data['KD_MATERIAL']);
            array_push($uraian_a,$data['URAIAN']);
            array_push($vol_a,$data['VOL']);
            array_push($tgl_rencana_pendatangan_a,$data['TGL_RENCANA_PENDATANGAN']);
        }
        $params=array(
            'no_bapb_a'=>$no_bapb_a,
            'kd_material_a'=>$kd_material_a,
            'uraian_a'=>$uraian_a,
            'vol_a'=>$vol_a,
            'tgl_rencana_pendatangan_a'=>$tgl_rencana_pendatangan_a
        );
      
        print_r(json_encode($params,JSON_PRETTY_PRINT));

    }
    public function getMetodeBayar($char="get"){
         if(trim($char)<>'-' ){
            $query="select ID_METODE_BAYAR,METODE_BAYAR from WFINANCE.TB_METODE_BAYAR"
                 . " where ID_METODE_BAYAR LIKE '%".trim($char)."%' or "
                 . " METODE_BAYAR LIKE '%".trim($char)."%' order by ID_METODE_BAYAR";
        }else{
            $query="select ID_METODE_BAYAR,METODE_BAYAR from WFINANCE.TB_METODE_BAYAR order by ID_METODE_BAYAR";
        }
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
      //      array_push($item_data, array('query'=>$char));
        foreach ($get_data as $data){
            array_push($item_data, array('id_metode_bayar'=>$data['ID_METODE_BAYAR'],
                        'metode_bayar'=>$data['METODE_BAYAR']
                      ));
        }   
        echo json_encode($item_data);
    }
    public function getSisBayar($char="get"){
        if(trim($char)<>'-' ){
            $query="select ID_SISTEM_BAYAR,SISTEM_BAYAR from WFINANCE.TB_SISTEM_BAYAR"
                 . " where ID_SISTEM_BAYAR LIKE '%".trim($char)."%' or "
                 . " SISTEM_BAYAR LIKE '%".trim($char)."%' order by ID_SISTEM_BAYAR";
        }else{
            $query="select  ID_SISTEM_BAYAR,SISTEM_BAYAR from WFINANCE.TB_SISTEM_BAYAR order by ID_SISTEM_BAYAR";
        }
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
      //      array_push($item_data, array('query'=>$char));
        foreach ($get_data as $data){
            array_push($item_data, array('id_sistem_bayar'=>$data['ID_SISTEM_BAYAR'],
                        'sistem_bayar'=>$data['SISTEM_BAYAR']
                      ));
        }   
        echo json_encode($item_data);
    }
    public function getSPB($char="get"){
        $curyear=date("Y"); 
        $lastyear=$curyear-1;
        if(trim($char)<>'-' ){
            $query = "select  a.NO_SPB,a.PAT_TO KD_PAT,c.KET PAT_TO,b.VENDOR_ID,b.NAMA VENDOR_NAMA  from WOS.SPB_H a
                inner join VENDOR b on a.VENDOR_ID=b.VENDOR_ID
                inner join tb_pat c on a.PAT_TO=c.KD_PAT  
                    WHERE a.PAT_SPB='0A' and a.NO_SPB LIKE '%".trim($char)."%'   order by a.tgl_surat desc";     
        }else{
            $query = "select  a.NO_SPB,a.PAT_TO KD_PAT,c.KET PAT_TO,b.VENDOR_ID,b.NAMA VENDOR_NAMA  from WOS.SPB_H a
                inner join VENDOR b on a.VENDOR_ID=b.VENDOR_ID
                inner join tb_pat c on a.PAT_TO=c.KD_PAT  where a.PAT_SPB='0A' and ( a.NO_SPB LIKE '%".trim($curyear)."%'
                or a.NO_SPB LIKE '%".trim($lastyear)."%')    
                order by a.tgl_surat desc ";
        } 
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
      //      array_push($item_data, array('query'=>$char));
        foreach ($get_data as $data){
            array_push($item_data, array('no_spb'=>$data['NO_SPB'],
                        'pat_to'=>$data['PAT_TO'],
                        'kd_pat'=>$data['KD_PAT'],
                        'vendor_id'=>$data['VENDOR_ID'],
                        'vendor_nama'=>$data['VENDOR_NAMA']
                      ));
        }   
        echo json_encode($item_data);
    }
    
    public function getBank($char="get"){
        if(trim($char)<>'-' ){
            $query = "select a.kd_store,a.kd_bank,b.ket,a.no_rek,a.saldo_akhir,a.saldo_awal 
                    from tb_store a
                    inner join tb_bank b on a.kd_bank=b.kd_bank
                    WHERE a.account like '21%' and (  a.kd_bank LIKE '%".trim($char)."%' or
                          b.ket LIKE '%".trim($char)."%' or
                          a.kd_store LIKE '%".trim($char)."%' or    
                          a.no_rek LIKE '%".trim($char)."%') ORDER by a.kd_bank,a.kd_store,a.no_rek";     
        }else{
            $query = "select a.kd_store,a.kd_bank,b.ket,a.no_rek,a.saldo_akhir,a.saldo_awal 
                    from tb_store a 
                    inner join tb_bank b on a.kd_bank=b.kd_bank  where a.kd_pat like '0A' ";
        } 
        
        $get_data = $this->db->query($query)->result_array();
        $item_data=[];
          //  array_push($item_data, array('query'=>$query));
       
        foreach ($get_data as $data){
            array_push($item_data, array('kd_bank'=>$data['KD_BANK'],
                        'kd_store'=>$data['KD_STORE'],
                        'ket'=>$data['KET'],'no_rek'=>$data['NO_REK'],
                        'saldo_awal'=>$data['SALDO_AWAL'],    
                        'saldo_akhir'=>$data['SALDO_AKHIR']
                      ));
        }
        echo json_encode($item_data);
        }
}
