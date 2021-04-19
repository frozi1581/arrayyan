<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
    function viewDataMemorial($isDok, $f_status, $f_upload, $arrSumberDaya, $arrLinino, $arrAcc, $arrPPU, $arrSPB, $arrSP3, $arrVendor, $arrNPP, $arrPelanggan, $arrProd, $arrNIP, $arrHartap, $arrLini, $arrPajak, $arrKas, $arrMem, $arrTag, $arrSat, $arrVol, $arrDebit, $arrKredit, $arrUraian, $arrUraianTambahan, $arrInvoice)
    {   
        if (isset($f_status) && isset($f_upload)) {
            if ($f_status == 'VIEW' && $f_upload == 'NO' && $isDok == 'MEMORIAL') {
                $strDetail="";
                    for($i=0;$i<100;$i++){
                        $strDetail.="<tr>";
                        $strDetail.="<td style=\"text-align:right;\">".($i+1).".</td>";
                        if (array_key_exists($i, $arrAcc)){
                            $strDetail.="<td><select disabled='disabled' name='txtAkun[]".$i."' class=\"akun\" style=\"width:500px;\"><option value=\"".$arrAcc[$i]."\">".$arrUraian[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select name='txtAkun[]".$i."' class=\"akun\" style=\"width:500px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrUraianTambahan)){
                            $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"".$arrUraianTambahan[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrPPU)) {
                            $strDetail.="<td><select disabled='disabled' id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"".$arrPPU[$i]."\">".$arrPPU[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrNPP)) {
                            $strDetail.="<td><select disabled='disabled' id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:200px;\"><option value=\"".$arrNPP[$i]."\">".$arrNPP[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSPB)) {
                            $strDetail.="<td><select disabled='disabled' id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"".$arrSPB[$i]."\">".$arrSPB[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSP3)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"".$arrSP3[$i]."\" style=\"text-align:left;width:250px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"\" style=\"text-align:left;width:250px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrVendor)){
                            $strDetail.="<td><select disabled='disabled' id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:200px;\"><option value=\"".$arrVendor[$i]."\">".$arrVendor[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrPelanggan)){
                            $strDetail.="<td><select disabled='disabled' id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"".$arrPelanggan[$i]."\">".$arrPelanggan[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrProd)){
                            $strDetail.="<td><select disabled='disabled' id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:200px;\"><option value=\"".$arrProd[$i]."\">".$arrProd[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrNIP)){
                            $strDetail.="<td><select disabled='disabled' id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:200px;\"><option value=\"".$arrNIP[$i]."\">".$arrNIP[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrHartap)){
                            $strDetail.="<td><select disabled='disabled' id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"".$arrHartap[$i]."\">".$arrHartap[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSumberDaya)){
                            $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"".$arrSumberDaya[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrLini)){
                            $strDetail.="<td><select disabled='disabled' id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:200px;\"><option value=\"".$arrLini[$i]."\">".$arrLini[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrPajak)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"".$arrPajak[$i]."\" style=\"text-align:left;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"\" style=\"text-align:left;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrKas)){
                            $strDetail.="<td><select disabled='disabled' id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:200px;\"><option value=\"".$arrKas[$i]."\">".$arrKas[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrMem)){
                            $strDetail.="<td><select disabled='disabled' id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:200px;\"><option value=\"".$arrMem[$i]."\">".$arrMem[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrTag)){
                            $strDetail.="<td><select disabled='disabled' id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:200px;\"><option value=\"".$arrTag[$i]."\">".$arrTag[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrInvoice)){
                            $strDetail.="<td><select disabled='disabled' id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:200px;\"><option value=\"".$arrInvoice[$i]."\">".$arrInvoice[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrLinino)) {
                            $strDetail.="<td><input type='hidden' type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"".$arrLinino[$i]."\" style=\"text-align:right;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='hidden'  type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"\" style=\"text-align:right;\"/></td>";
                        }
                        if (array_key_exists($i, $arrSat)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"".$arrSat[$i]."\" style=\"text-align:center;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"\" style=\"text-align:center;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrVol)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"".$arrVol[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"\" style=\"text-align:right;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrDebit)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"debet\" name='txt_debet[]".$i."' value=\"".$arrDebit[$i]."\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }else {
                            $strDetail.="<td><input type='text' class=\"debet\" name='txt_debet[]".$i."' value=\"\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrKredit)){
                            $strDetail.="<td><input disabled='disabled' type='text' class=\"kredit\" name='txt_kredit[]".$i."' value=\"".$arrKredit[$i]."\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }else {
                            $strDetail.="<td><input type='text' class=\"kredit\" name='txt_kredit[]".$i."' value=\"\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }
                        $strDetail.="</tr>";
                    }
                return $strDetail;

            }
        }
    } 

    function viewDataKas($isDok, $f_status, $f_upload, $arrLinino, $arrUraian, $arrNPP, $arrSPB, $arrSP3, $arrHartap,$arrPPU,$arrNIP,$arrLini,$arrProd,$arrVendor,$arrPajak,$arrKas,$arrMem,$arrTag,$arrVol,$arrSat,$arrAcc,$arrTot,$arrPelanggan,$arrUraianTambahan,$arrSumberDaya,$arrInvoice)
    {
        if ($f_status == 'VIEW' && $f_upload == 'NO' && $isDok == 'KAS') {
            $strDetail="";
            for($i=0;$i<100;$i++){
                $strDetail.="<tr>";
                $strDetail.="<td style=\"text-align:right;\">".($i+1).".</td>";
                if (array_key_exists($i, $arrUraian)){
                    $strDetail.="<td><select disabled='disabled' class=\"akun\" id='txtAkun[]".$i."' name='txtAkun[]".$i."' value=\"\" style=\"text-align:right;width:400px;\"><option value=\"debetVal\">".$arrUraian[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select class=\"akun\" id='txtAkun[]".$i."' name='txtAkun[]".$i."' value=\"\" style=\"text-align:right;width:400px;\"><option value=\"debetVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrUraianTambahan)){
                    $strDetail.="<td><input type='text' disabled='disabled' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"".$arrUraianTambahan[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' disabled='disabled' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                }
                if (array_key_exists($i, $arrPPU)){
                    $strDetail.="<td><select disabled='disabled' id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"rcpatVal\">".$arrPPU[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"rcpatVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrNPP)) {
                    $strDetail.="<td><select disabled='disabled' id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:400px;\"><option value=\"nppVal\">".$arrNPP[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:400px;\"><option value=\"nppVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSPB)) {
                    $strDetail.="<td><select disabled='disabled' id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"".$arrSPB[$i]."\">".$arrSPB[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSP3)){
                    $strDetail.="<td><input disabled='disabled' type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"".$arrSP3[$i]."\" style=\"text-align:left;width:250px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"\" style=\"text-align:left;width:250px;\"/></td>";
                }
                if (array_key_exists($i, $arrVendor)){
                    $strDetail.="<td><select disabled='disabled' id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:240px;\"><option value=\"vendorVal\">".$arrVendor[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:240px;\"><option value=\"vendorVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrPelanggan)){
                    $strDetail.="<td><select disabled='disabled' id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"".$arrPelanggan[$i]."\">".$arrPelanggan[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrProd)){
                    $strDetail.="<td><select disabled='disabled' id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:240px;\"><option value=\"produkVal\">".$arrProd[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:240px;\"><option value=\"produkVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrNIP)){
                    $strDetail.="<td><select disabled='disabled' id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:250px;\"><option value=\"nipVal\">".$arrNIP[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:250px;\"><option value=\"nipVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrHartap)){
                    $strDetail.="<td><select disabled='disabled' id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"hartatetapVal\">".$arrHartap[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"hartatetapVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSumberDaya)){
                    $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"".$arrSumberDaya[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                }
                if (array_key_exists($i, $arrLini)){
                    $strDetail.="<td><select disabled='disabled' id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:300px;\"><option value=\"liniVal\">".$arrLini[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:300px;\"><option value=\"liniVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrPajak)){
                    $strDetail.="<td><input disabled='disabled' type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"".$arrPajak[$i]."\" style=\"text-align:left;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"\" style=\"text-align:left;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrKas)){
                    $strDetail.="<td><select disabled='disabled' id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:300px;\"><option value=\"refkasVal\">".$arrKas[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:300px;\"><option value=\"refkasVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrMem)){
                    $strDetail.="<td><select disabled='disabled' id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:300px;\"><option value=\"refmemVal\">".$arrMem[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:300px;\"><option value=\"refmemVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrTag)){
                    $strDetail.="<td><select disabled='disabled' id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:300px;\"><option value=\"reftagihanVal\">".$arrTag[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:300px;\"><option value=\"reftagihanVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrInvoice)){
                    $strDetail.="<td><select disabled='disabled' id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:300px;\"><option value=\"reftagihanVal\">".$arrInvoice[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:300px;\"><option value=\"reftagihanVal\"></option></select></td>";
                }
                if (array_key_exists($i, $arrLinino)) {
                    $strDetail.="<td><input type='hidden' type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"".$arrLinino[$i]."\" style=\"text-align:right;\"/></td>";
                } else {
                    $strDetail.="<td><input type='hidden' type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"\" style=\"text-align:right;\"/></td>";
                }
                if (array_key_exists($i, $arrSat)){
                    $strDetail.="<td><input disabled='disabled' type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"".$arrSat[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"\" style=\"text-align:right;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrVol)){
                    $strDetail.="<td><input disabled='disabled' type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"".$arrVol[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"\" style=\"text-align:right;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrTot)){
                    $strDetail.="<td><input type='text' class=\"kredit\" id='txt_kredit[]".$i."' name='txt_kredit[]".$i."' value=".$arrTot[$i]." placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                }else {
                    $strDetail.="<td><input type='text' class=\"kredit\" id='txt_kredit[]".$i."' name='txt_kredit[]".$i."' value=\"\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                }
                $strDetail.="</tr>";
            }
            return $strDetail;
        }
    }
?>