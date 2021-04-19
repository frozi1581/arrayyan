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
		$filterQuery= "%";
		$filterQuery .= isset($_GET['q']) ?  $_GET['q'] : '';
		$filterQuery .= "%";
		$strsql="";
		$limitRows = 20;
		$filtersekuritas = isset($_GET['sekuritas']) ? urldecode($_GET['sekuritas']) : '';
		$filteremiten = isset($_GET['emiten']) ? urldecode($_GET['emiten']) : '';
		
		$specialFilter = isset($_GET['special_filter'])?$_GET['special_filter']:'';
		
		$this->load->library('LookupData');

		switch($lookupTable){
			case "UK":
				$strsql="select distinct unit_kerja as ID, unit_kerja as TEXT from m_anggota ";
				$strsql.=" where upper(unit_kerja) like upper('".$filterQuery."') ";
				$strsql.=" order by 1 desc limit 30";
				break;
			case "NAMA":
				$strsql="select a.nip as ID, concat(a.nama,' - ', a.unit_kerja,' - [ ',b.kode_emiten,' : ',FORMAT(round(b.lbr_saham,0),0),' lembar ]') as TEXT from m_anggota  a inner join m_kepemilikan b on b.nip=a.nip ";
				$strsql.=" where upper(a.nama) like upper('".$filterQuery."') or upper(a.nip) like upper('".$filterQuery."')";
				$strsql.=" order by 2 asc limit 30";
				break;
			case "KEPEMILIKAN":
				$strsql="select concat(a.nip,'|',b.sekuritas,'|',b.kode_emiten,'|',round(sum(b.lbr_saham),0) ) as ID,
 concat(a.nip, ' - ', a.nama,' - ', a.unit_kerja,' - [ ',b.kode_emiten,' : ', CONVERT(FORMAT(round(sum(b.lbr_saham),0),0) using utf8),' lembar ]') as TEXT from m_anggota  a inner join m_kepemilikan b on b.nip=a.nip ";
				$strsql.=" where upper(a.nama) like upper('".$filterQuery."') or upper(a.nip) like upper('".$filterQuery."')";
				$strsql.=" group by a.nip, b.kode_emiten ";
				$strsql.=" order by 2 asc limit 30";
				break;
			case "SEKURITAS":
				$strsql="select distinct sekuritas as ID, sekuritas as TEXT from m_emiten where upper(sekuritas) like upper('$filterQuery') order by 1 ";
				break;
			case "EMITEN":
				$strsql="select distinct kode_emiten as ID, kode_emiten as TEXT from m_emiten where upper(kode_emiten) like upper('$filterQuery') order by 1 ";
				break;
			case "EMITENBYSEKURITAS":
				$strsql="select distinct kode_emiten as ID, kode_emiten as TEXT from m_emiten where upper(sekuritas) like upper('$filtersekuritas')  order by 1 ";
				//var_dump($strsql);
				break;
			case "KEPEMILIKANBYEMITENSEKURITAS":
				$strsql="select concat(a.nip,'|',b.sekuritas,'|',b.kode_emiten,'|',round(sum(b.lbr_saham),0) ) as ID,
 concat(a.nip, ' - ', a.nama,' - ', a.unit_kerja,' - [ ',b.kode_emiten,' : ', CONVERT(FORMAT(round(sum(b.lbr_saham),0),0) using utf8),' lembar ]') as TEXT from m_anggota  a inner join m_kepemilikan b on b.nip=a.nip ";
				$strsql.=" where upper(b.sekuritas) like upper('$filtersekuritas') and upper(b.kode_emiten) like upper('$filteremiten') and  ( (upper(a.nama) like upper('".$filterQuery."') or upper(a.nip) like upper('".$filterQuery."')) )";
				$strsql.=" group by a.nip, b.kode_emiten ";
				$strsql.=" order by 2 asc limit 30";
				break;
			default:
				break;
		}
		$this->lookupdata->sql =$strsql;
		
		echo $this->lookupdata->getSelect2Data();
	}
	
	public function getlookupDetail($no_dok){
		$filterQuery= "%";
		$filterQuery .= isset($_GET['q']) ?  $_GET['q'] : '';
		$filterQuery .= "%";
		$strsql="";
		$limitRows = 20;
		
		$query = $this->db->query("select a.no_dok ID,a.no_dok,a.lineno,a.uraian,a.kd_gas,a.account,a.no_sp3,a.no_npp,a.no_spb,a.harta_tetap,a.kd_pat,a.employee_id,a.kd_lini,
                    a.kd_produk,a.vendor_id,a.no_pajak,a.no_dok_kas,a.no_dok_mem,a.no_tagihan,
                    a.vol,a.satuan,a.harsat,a.total,b.nama_proyek,c.ket ket_pat,trim(d.first_title||' '||d.first_name||' '||d.last_name||d.last_title)nama,
                    e.ket ket_lini,f.tipe tipe_produk,g.nama nama_vendor,
                    a.PELANGGAN_ID,h.NAMA NAMA_PELANGGAN,i.ket ket_gas,
                    j.subject||' ('||j.ket||')' ket_ref_kas 
                    from wfinance.dokkas_d1  a
                    left join wos.npp b on a.no_npp=b.no_npp
                    left join wos.tb_pat c on a.kd_pat=c.kd_pat
                    left join wos.personal d on a.employee_id=d.employee_id
                    left join wos.tb_lini e on a.kd_lini=e.kd_lini
                    left join wos.tb_produk f on a.kd_produk=f.kd_produk
                    left join wos.vendor g on a.vendor_id=g.vendor_id
                    left join wos.pelanggan h on a.PELANGGAN_ID=h.PELANGGAN_ID
                    left join wos.tb_gas i on a.kd_gas=i.kd_gas 
                    left join wfinance.dokkas_h j on a.no_dok=j.no_dok
                    where a.no_dok='".$no_dok."'")->result();
		$data['results'] = $query;
		print_r(json_encode($data,JSON_PRETTY_PRINT));
	}
	
}
