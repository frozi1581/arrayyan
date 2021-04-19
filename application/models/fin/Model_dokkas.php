<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_dokkas extends CI_Model {

    public function logged_id()
    {
        return $this->session->userdata('USRID');
    }

    public function login_auth($username, $password)
    {
        $query = $this->db->query("SELECT  A.USRID, A.EMPLOYEE_ID, A.PASSWD,
                                    C.KET KET_JBT,B.KD_GAS, D.KET KET_GAS, B.KD_PAT
                                    FROM USRADM.USERS A,HRMS.PERSONAL B,HRMS.TB_JBT C,HRMS.TB_GAS D
                                    WHERE A.EMPLOYEE_ID=B.EMPLOYEE_ID  AND B.KD_JBT=C.KD_JBT AND B.KD_GAS=D.KD_GAS
                                    AND A.USRID='".$username."' AND A.PASSWD='".$password."'")->result();
        if ($query) {
          # code...
          return $query;
        } else {
          return false;
        }
    }

    public function auto_login()
    {
        $query = $this->db->query("select a.employee_id,
                                    trim(first_title||' '||first_name||' '||last_name||last_title)nama_pengirim,
                                    a.kd_pat,b.ket ket_pat,c.kd_gas,c.ket ket_gas,a.kd_jbt,d.ket ket_jbt from wos.personal a
                                    left join wos.tb_pat b on a.kd_pat=b.kd_pat
                                    left join wos.tb_gas c on a.kd_gas=c.kd_gas
                                    left join wos.tb_jbt d on a.kd_jbt=d.kd_jbt
                                    where a.employee_id='LS900946' and st='1'")->result();
        if ($query) {return $query;} else {return false;}
    }

    public function getView($kd_pat, $kd_gas)
    {
        $query = $this->db->query("select 
        a.no_dok AS ID, 
        a.no_dok,
        a.jdok,
        case a.jdok
            when 'P' THEN 'BAYAR'
            when 'M' THEN 'BELUM'
        end AS JDOK_KET,
        a.bl,
        a.subject,
        a.verify,
        a.paid,
        case a.verify
            when '0' THEN 'false'
            when '1' THEN 'true'
        end AS VERIFY_KET,
        case a.paid
            when '0' THEN 'false'
            when '1' THEN 'true'
        end AS PAID_KET
                  from wfinance.dokkas_h a,hrms.personal b
          where b.kd_pat='".$kd_pat."' and app1=0 and app2=0 and app3=0 and app4=0
          and a.created_by=b.employee_id and b.kd_gas='".$kd_gas."'
                  order by substr(a.no_dok,0,4)desc")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box NPP ----------------------------
    public function combo_box_npp($input)
    {
        $query = $this->db->query("select no_npp,nama_proyek from wos.npp where to_char(tgl_npp,'YYYY')>2010 and no_npp like '%".$input."%'")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box SPB ----------------------------
    public function combo_box_spb($input)
    {
        $query = $this->db->query("select a.no_spb from wfinance.dokkas_d1 a where NULLIF(a.no_spb, '') IS NOT NULL and a.no_spb like '%".$input."%' group by a.no_spb")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box SP3 ----------------------------
    public function combo_box_sp3($input)
    {
        $query = $this->db->query("select a.no_sp3 from wfinance.dokkas_d1 a where a.no_sp3 is not null and a.no_sp3 like '%".$input."%' group by a.no_sp3")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box Harta Tetap ----------------------------
    public function combo_box_hartatetap($input)
    {
        $query = $this->db->query("select a.harta_tetap from wfinance.dokkas_d1 a where a.harta_tetap is not null and a.harta_tetap like '%".$input."%' group by a.harta_tetap")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box PPU ----------------------------
    public function combo_box_ppu($input)
    {
        $query = $this->db->query("select kd_pat,ket from tb_pat where length(kd_pat)>0 and ket like '%".$input."%'")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box NIP ----------------------------
    public function combo_box_nip($input)
    {
        $query = $this->db->query("select a.employee_id from wfinance.dokkas_d1 a where a.employee_id is not null and a.employee_id like '%".$input."%' group by a.employee_id")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box LINI ----------------------------
    public function combo_box_lini($input)
    {
        $query = $this->db->query("select a.kd_lini from wfinance.dokkas_d1 a where a.kd_lini is not null and a.kd_lini like '%".$input."%' group by a.kd_lini")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box Produk ----------------------------
    public function combo_box_produk($input)
    {
        $query = $this->db->query("select a.kd_produk from wos.tb_produk a where a.kd_produk is not null and a.kd_produk like '%".$input."%' group by a.kd_produk")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }   

    //--------------- combo box Vendor ----------------------------
    public function combo_box_vendor($input)
    {
        $query = $this->db->query("select vendor_id,upper(nama)nama from wos.vendor where length(vendor_id)>0 and vendor_id like '%".$input."%'")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box Ref Kas ----------------------------
    public function combo_box_kas($input)
    {
        $query = $this->db->query("select a.no_dok_kas from wfinance.dokkas_d1 a where a.no_dok_kas is not null and a.no_dok_kas like '%".$input."%' group by a.no_dok_kas")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box Ref Memorial ----------------------------
    public function combo_box_memorial($input)
    {
        $query = $this->db->query("select a.no_dok_mem from wfinance.dokkas_d1 a where a.no_dok_mem is not null and a.no_dok_mem like '%".$input."%' group by a.no_dok_mem")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    //--------------- combo box Ref Tagihan ----------------------------
    public function combo_box_tagihan($input)
    {
        $query = $this->db->query("select a.no_tagihan from wfinance.dokkas_d1 a where a.no_tagihan is not null and a.no_tagihan like '%".$input."%' group by a.no_tagihan")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function combo_box_debet($input)
    {
        $query = $this->db->query("select a.account from wfinance.dokkas_d1 a where a.account is not null and a.account like '%".$input."%' group by a.account")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function combo_box_bank($input)
    {
        $query = $this->db->query("select a.kd_bank, a.ket from wfinance.tb_bank a where a.kd_bank is not null and a.account like '%".$input."%' group by a.kd_bank, a.ket")->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function list_view_detail($f_no_dokkas)
    {
        $this->load->library('AdodbConn');
        $conn = $this->adodbconn->getOraConn("OS");//$conn = $this->adodbconn->getMySqlConn("hcis");
        // $filter = $this->input->post('f_status');
        $query="select (a.account || ' - ' || a.uraian) as uraian, (b.no_npp || ' - ' || b.nama_proyek) as no_npp, a.no_spb, a.no_sp3, (k.no_inventaris || ' - ' || k.uraian) as harta_tetap, 
                        c.ket as PPU, d.employee_id || ' - ' || trim(d.first_name || ' ' || d.last_name) as nip, e.kd_lini || ' - ' || e.ket as lini, (f.kd_produk || ' - ' || f.tipe || ' ' || f.ket || ' [' || std_nonstd || ']') as produk,
                        g.nama nama_vendor, a.no_pajak, (j.no_dok || ' - ' || to_char(j.tgl_dok,'dd-mm-yyyy') || ' - ' || j.subject||' ('||j.ket||')' ) as no_ref_kas,
                        (j.no_dok || ' - ' || to_char(j.tgl_dok,'dd-mm-yyyy')) as no_ref_mem, (l.no_tagihan || ' - ' || l.no_faktur) as tagihan, a.vol, a.satuan,
                        (a.account || ' - ' || a.uraian) as debet_perk, a.total, a.account
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
                        left join wos.alat k on a.harta_tetap=k.no_inventaris
                        left join wfinance.tagihan_h l on a.no_tagihan = l.no_tagihan
                        where a.no_dok='".$f_no_dokkas."'";
        $arrParamData = array();
        $rst=$conn->PageExecute($query,$recPerPage,$currPage,$arrParamData);
        if($rst){
                $total_rows = $this->adodbconn->gettotalrec($conn, $query, $arrParamData);
                if($rst->recordCount()>0){
                        for($i=0;$i<$rst->recordCount();$i++){
                                $arrData[] = array(
                                    'ID'    => $i+1,
                                    'URAIAN' =>  $rst->fields["URAIAN"],
                                    'NO_NPP' => $rst->fields["NO_NPP"],
                                    'NO_SPB' =>  $rst->fields["NO_SPB"],
                                    'NO_SP3' =>  $rst->fields["NO_SP3"],
                                    'HARTA_TETAP' =>  $rst->fields["HARTA_TETAP"],
                                    'PPU' => $rst->fields["PPU"],
                                    'NIP' =>  $rst->fields["NIP"],
                                    'KD_LINI' =>  $rst->fields["LINI"],
                                    'PRODUK' => $rst->fields["PRODUK"],
                                    'NAMA_VENDOR' =>  $rst->fields["NAMA_VENDOR"],
                                    'NO_PAJAK' =>  $rst->fields["NO_PAJAK"],
                                    'NO_REF_KAS' => $rst->fields["NO_REF_KAS"],
                                    'NO_REF_MEM' =>  $rst->fields["NO_REF_MEM"],
                                    'TAGIHAN' =>  $rst->fields["TAGIHAN"],
                                    'VOL' => $rst->fields["VOL"],
                                    'SATUAN' =>  $rst->fields["SATUAN"],
                                    'ACCOUNT' =>  $rst->fields["ACCOUNT"],
                                    'TOTAL' =>  $rst->fields["TOTAL"]
                                    );	 
                                $rst->moveNext();
                        }
                }else{                   
                        $total_rows = 0;
                        $arrData[] = array(
                                'ID' => "", 'NO_DOK' => "",'LINENO' => "",
                                'URAIAN' => "",'KD_GAS' => "",
                                'ACCOUNT' => "",'NO_SP3' => "",
                                'NO_NPP' => "",'NO_SPB' => "",
                                'HARTA_TETAP' => "",'KD_PAT' => "",
                                'EMPLOYEE_ID' => "",'KD_LINI' => "",
                                'KD_PRODUK' => "",'VENDOR_ID' => "",
                                'NO_PAJAK' => "",'NO_DOK_KAS' => "",
                                'NO_DOK_MEM' => "",'NO_TAGIHAN' => "",
                                'VOL' => "",'SATUAN' => "",
                                'HARSAT' =>  "",'TOTAL' =>  "",
                                'NAMA_PROYEK' => "",'KET_PAT' => "",
                                'NAMA' =>  "",'KET_LINI' =>  "",
                                'TIPE_PRODUK' => "",'NAMA_VENDOR' => "",
                                'PELANGGAN_ID' => "",'NAMA_PELANGGAN' => "",'KET_GAS' => "",'KET_REF_KAS' => ""
                            ); 
                }
        }else{
                $total_rows = 0;
                $arrData[] = array(
                    'ID' => "", 'NO_DOK' => "",'LINENO' => "",
                                'URAIAN' => "",'KD_GAS' => "",
                                'ACCOUNT' => "",'NO_SP3' => "",
                                'NO_NPP' => "",'NO_SPB' => "",
                                'HARTA_TETAP' => "",'KD_PAT' => "",
                                'EMPLOYEE_ID' => "",'KD_LINI' => "",
                                'KD_PRODUK' => "",'VENDOR_ID' => "",
                                'NO_PAJAK' => "",'NO_DOK_KAS' => "",
                                'NO_DOK_MEM' => "",'NO_TAGIHAN' => "",
                                'VOL' => "",'SATUAN' => "",
                                'HARSAT' =>  "",'TOTAL' =>  "",
                                'NAMA_PROYEK' => "",'KET_PAT' => "",
                                'NAMA' =>  "",'KET_LINI' =>  "",
                                'TIPE_PRODUK' => "",'NAMA_VENDOR' => "",
                                'PELANGGAN_ID' => "",'NAMA_PELANGGAN' => "",'KET_GAS' => "",'KET_REF_KAS' => ""
                );
        }
        print_r(json_encode($arrData,JSON_PRETTY_PRINT));  
    }

    public function view_detail($f_no_dokkas)
    {
        $query = $this->db->query("select (a.account || ' - ' || a.uraian) as uraian, (b.no_npp || ' - ' || b.nama_proyek) as no_npp, a.no_spb, a.no_sp3, (k.no_inventaris || ' - ' || k.uraian) as harta_tetap, 
                                c.ket as PPU, d.employee_id || ' - ' || trim(d.first_name || ' ' || d.last_name) as nip, e.kd_lini || ' - ' || e.ket as lini, (f.kd_produk || ' - ' || f.tipe || ' ' || f.ket || ' [' || std_nonstd || ']') as produk,
                                g.nama nama_vendor, a.no_pajak, (j.no_dok || ' - ' || to_char(j.tgl_dok,'dd-mm-yyyy') || ' - ' || j.subject||' ('||j.ket||')' ) as no_ref_kas,
                                (j.no_dok || ' - ' || to_char(j.tgl_dok,'dd-mm-yyyy')) as no_ref_mem, (l.no_tagihan || ' - ' || l.no_faktur) as tagihan, a.vol, a.satuan,
                                (a.account || ' - ' || a.uraian) as debet_perk, a.total, a.account
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
                                left join wos.alat k on a.harta_tetap=k.no_inventaris
                                left join wfinance.tagihan_h l on a.no_tagihan = l.no_tagihan
                                where a.no_dok='".$f_no_dokkas."'")->result();
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function simpan_upload($judul,$image)
    {
        $sql = "select max(no_dok)no_dok from  wfinance.dokkas_h where substr(no_dok,0,4)= EXTRACT(YEAR FROM sysdate) and substr(no_dok,5,2)= '".$kd_pat."'order by no_dok desc";
        $result=$this->db->query($sql);
        if($result->num_rows()<1){
            $next=date("Y").$kd_pat.'00000001';
        }else{
            $result=$result->result();
            $currDoc = $result[0]->NO_DOK ;
            $curr_seq = substr($currDoc,6,8);
            $next= sprintf("%08d", floatval($curr_seq)+1) ;
            $next=date("Y").$kd_pat.$next;
        }

        $data = array(
            'ID'     => $next,
            'JUDUL'  => $judul,
            'GAMBAR' => $image
        );  
            $result= $this->db->insert('wfinance.tbl_galeri',$data);
            return $result;
    }
    
}
