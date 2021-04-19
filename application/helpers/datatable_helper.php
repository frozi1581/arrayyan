<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
    function createDatatable($isDok)
    {   
        if ($isDok=='KAS') {
            $strtable="";
            $strtable.="<thead>";
            $strtable.="    <tr>";
            $strtable.="        <th>No</th>";
            $strtable.="        <th class=\"tbaccLutfi\">KREDIT PERK.</th>";
            $strtable.="        <th  >URAIAN</th>";
            $strtable.="        <th  >RK PPU</th>";
            $strtable.="        <th  >NO NPP</th>";
            $strtable.="        <th  >SPB</th>";
            $strtable.="        <th  >SP3</th>";
            $strtable.="        <th  >VENDOR ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementVendor\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Vendor</a></label></th>";
            $strtable.="        <th  >PELANGGAN ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementPelanggan\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Pelanggan</a></label></th>";
            $strtable.="        <th  >PRODUK</th>";
            $strtable.="        <th  >NIP</th>";
            $strtable.="        <th  >HARTA TETAP</th>";
            $strtable.="        <th  >KODE SUMBER DAYA</th>";
            $strtable.="        <th  >KODE LINI</th>";
            $strtable.="        <th  >PAJAK</th>";
            $strtable.="        <th  >NO REF KAS</th>";
            $strtable.="        <th  >NO REF MEMORIAL</th>";
            $strtable.="        <th  >NO REF TAGIHAN</th>";
            $strtable.="        <th  >NO INVOICE</th>";
            $strtable.="        <th></th>";
            $strtable.="        <th  >SATUAN</th>";
            $strtable.="        <th  >VOLUME</th>";
            $strtable.="        <th >TOTAL</th>";
            $strtable.="    </tr>";
            $strtable.="</thead>";
            return $strtable;
        } else if ($isDok == 'MEMORIAL'){
            $strtable="";
            $strtable.="<thead>";
            $strtable.="    <tr>";
            $strtable.="        <th>No</th>";
            $strtable.="        <th >AKUN</th>";
            $strtable.="        <th  >URAIAN</th>";
            $strtable.="        <th  >RK PPU</th>";
            $strtable.="        <th  >NO NPP</th>";
            $strtable.="        <th  >SPB</th>";
            $strtable.="        <th  >SP3</th>";
            $strtable.="        <th  >VENDOR ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementVendor\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Vendor</a></label></th>";
            $strtable.="        <th  >PELANGGAN ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementPelanggan\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Pelanggan</a></label></th>";
            $strtable.="        <th  >PRODUK</th>";
            $strtable.="        <th  >NIP</th>";
            $strtable.="        <th  >HARTA TETAP</th>";
            $strtable.="        <th  >KODE SUMBER DAYA</th>";
            $strtable.="        <th  >KODE LINI</th>";
            $strtable.="        <th  >PAJAK</th>";
            $strtable.="        <th  >NO REF KAS</th>";
            $strtable.="        <th  >NO REF MEMORIAL</th>";
            $strtable.="        <th  >NO REF TAGIHAN</th>";
            $strtable.="        <th  >NO INVOICE</th>";
            $strtable.="        <th></th>";
            $strtable.="        <th  >SATUAN</th>";
            $strtable.="        <th  >VOLUME</th>";
            $strtable.="        <th >Debet</th>";
            $strtable.="        <th >Kredit</th>";
            $strtable.="    </tr>";
            $strtable.="</thead>";
            return $strtable;
        } else if ($isDok == 'ERR'){
            $strtable="";
            $strtable.="<thead>";
            $strtable.="    <tr>";
            $strtable.="        <th>No</th>";
            $strtable.="        <th >AKUN</th>";
            $strtable.="        <th  >URAIAN</th>";
            $strtable.="        <th  >RK PPU</th>";
            $strtable.="        <th  >NO NPP</th>";
            $strtable.="        <th  >SPB</th>";
            $strtable.="        <th  >SP3</th>";
            $strtable.="        <th  >VENDOR ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementVendor\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Vendor</a></label></th>";
            $strtable.="        <th  >PELANGGAN ||<label style=\"margin-left: 10px;margin-top: 8px;\"><a style=\"color: white !important\" href=\"contentManagementPelanggan\" target=\"_blank\"><i class=\"fa fa-file-excel\" style=\"margin-right:5px\"></i>Lihat Daftar Pelanggan</a></label></th>";
            $strtable.="        <th  >PRODUK</th>";
            $strtable.="        <th  >NIP</th>";
            $strtable.="        <th  >HARTA TETAP</th>";
            $strtable.="        <th  >KODE SUMBER DAYA</th>";
            $strtable.="        <th  >KODE LINI</th>";
            $strtable.="        <th  >PAJAK</th>";
            $strtable.="        <th  >NO REF KAS</th>";
            $strtable.="        <th  >NO REF MEMORIAL</th>";
            $strtable.="        <th  >NO REF TAGIHAN</th>";
            $strtable.="        <th  >NO INVOICE</th>";
            $strtable.="        <th></th>";
            $strtable.="        <th  >SATUAN</th>";
            $strtable.="        <th  >VOLUME</th>";
            $strtable.="        <th >Debet</th>";
            $strtable.="        <th >Kredit</th>";
            $strtable.="    </tr>";
            $strtable.="</thead>";
            return $strtable;
        }
        
    }
?>