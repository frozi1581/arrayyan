<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
    function editDataMemorial($isDok, $f_status, $f_upload, $arrSumberDaya, $arrLinino, $arrUraian,$arrAcc, $arrPPU, $arrPPUText, $arrSPB, $arrSP3, $arrVendor, $arrVendorText, $arrNPP, $arrNPPText, $arrPelanggan, $arrProd, $arrProdText,$arrNIP,$arrNIPText,$arrHartap,$arrHartapText,$arrLini,$arrLiniText,$arrPajak,$arrKas,$arrKasText,$arrMem,$arrMemText,$arrTag,$arrTagText,$arrSat,$arrVol,$arrDebit,$arrKredit,$arrUraianTambahan,$arrInvoice)
    {   
        if (isset($f_status) && isset($f_upload)) {
            if ($f_status == 'EDIT' && $f_upload == 'NO' && $isDok == 'MEMORIAL') {
                $strDetail="";
                    for($i=0;$i<100;$i++){
                        $strDetail.="<tr>";
                        $strDetail.="<td style=\"text-align:right;\">".($i+1).".</td>";
                        if (array_key_exists($i, $arrAcc)){
                            $strDetail.="<td><select name='txtAkun[]".$i."' class=\"akun\" style=\"width:500px;\"><option value=\"".$arrAcc[$i]."\">".$arrUraian[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select name='txtAkun[]".$i."' class=\"akun\" style=\"width:500px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrUraianTambahan)){
                            $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"".$arrUraianTambahan[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrPPU)) {
                            $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"".$arrPPU[$i]."\">".$arrPPUText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrNPP)) {
                            $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:200px;\"><option value=\"".$arrNPP[$i]."\">".$arrNPPText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSPB)) {
                            $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"".$arrSPB[$i]."\">".$arrSPB[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSP3)){
                            $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"".$arrSP3[$i]."\" style=\"text-align:left;width:250px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"\" style=\"text-align:left;width:250px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrVendor)){
                            $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:200px;\"><option value=\"".$arrVendorText[$i]."\">".$arrVendor[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrPelanggan)){
                            $strDetail.="<td><select id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"".$arrPelanggan[$i]."\">".$arrPelanggan[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrProd)){
                            $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:200px;\"><option value=\"".$arrProd[$i]."\">".$arrProd[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrNIP)){
                            $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:200px;\"><option value=\"".$arrNIP[$i]."\">".$arrNIPText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrHartap)){
                            $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"".$arrHartap[$i]."\">".$arrHartapText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrSumberDaya)){
                            $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"".$arrSumberDaya[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrLini)){
                            $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:200px;\"><option value=\"".$arrLini[$i]."\">".$arrLiniText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrPajak)){
                            $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"".$arrPajak[$i]."\" style=\"text-align:left;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"\" style=\"text-align:left;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrKas)){
                            $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:200px;\"><option value=\"".$arrKas[$i]."\">".$arrKasText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrMem)){
                            $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:200px;\"><option value=\"".$arrMem[$i]."\">".$arrMemText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrTag)){
                            $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:200px;\"><option value=\"".$arrTag[$i]."\">".$arrTagText[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrInvoice)){
                            $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:200px;\"><option value=\"".$arrInvoice[$i]."\">".$arrInvoice[$i]."</option></select></td>";
                        } else {
                            $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                        }
                        if (array_key_exists($i, $arrLinino)) {
                            $strDetail.="<td><input type='hidden' type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"".$arrLinino[$i]."\" style=\"text-align:right;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='hidden'  type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"\" style=\"text-align:right;\"/></td>";
                        }
                        if (array_key_exists($i, $arrSat)){
                            $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"".$arrSat[$i]."\" style=\"text-align:center;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"\" style=\"text-align:center;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrVol)){
                            $strDetail.="<td><input type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"".$arrVol[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
                        } else {
                            $strDetail.="<td><input type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"\" style=\"text-align:right;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrDebit)){
                            $strDetail.="<td><input type='text' class=\"debet\" name='txt_debet[]".$i."' value=\"".$arrDebit[$i]."\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }else {
                            $strDetail.="<td><input type='text' class=\"debet\" name='txt_debet[]".$i."' value=\"\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }
                        if (array_key_exists($i, $arrKredit)){
                            $strDetail.="<td><input type='text' class=\"kredit\" name='txt_kredit[]".$i."' value=\"".$arrKredit[$i]."\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }else {
                            $strDetail.="<td><input type='text' class=\"kredit\" name='txt_kredit[]".$i."' value=\"\" placeholder='0' style=\"text-align:right;width:140px;\"/></td>";
                        }
                        $strDetail.="</tr>";
                    }
                return $strDetail;
            }
        }
    }

    function editDataKas($isDok, $f_status, $f_upload, $arrLinino, $arrUraian, $arrNPP, $arrNPPText, $arrSPB, $arrSP3, $arrHartap, $arrHartapText, $arrPPU, $arrPPUText, $arrNIP, $arrNIPText, $arrLini, $arrLiniText, $arrProd, $arrProdText, $arrVendor, $arrPajak, $arrKas, $arrKasText, $arrMem, $arrMemText, $arrTag, $arrTagText, $arrVol, $arrSat, $arrAcc, $arrTot, $arrDeb, $arrDebText, $arrPelanggan, $arrUraianTambahan, $arrSumberDaya, $arrInvoice)
    {
        if ($f_status == 'EDIT' && $f_upload == 'NO' && $isDok == 'KAS') {
            $strDetail="";
            for($i=0;$i<100;$i++){
                $strDetail.="<tr>";
                $strDetail.="<td style=\"text-align:right;\">".($i+1).".</td>";
                if (array_key_exists($i, $arrUraian)){
                    $strDetail.="<td><select class=\"akun\" id='txtAkun[]".$i."' name='txtAkun[]".$i."' value=\"\" style=\"text-align:right;width:400px;\"><option value=".$arrAcc[$i].">".$arrUraian[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select class=\"akun\" id='txtAkun[]".$i."' name='txtAkun[]".$i."' value=\"\" style=\"text-align:right;width:400px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrUraianTambahan)){
                    $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"".$arrUraianTambahan[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"uraianTambahan\" id='txt_uraianTambahan[]".$i."' name='txt_uraianTambahan[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                }
                if (array_key_exists($i, $arrPPU)){
                    $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option selected='selected' value=".$arrPPU[$i].">".$arrPPUText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtRCPAT[]".$i."' name='txtRCPAT[]".$i."' class=\"rcpat\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrNPP)) {
                    $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:400px;\"><option value=".$arrNPP[$i].">".$arrNPPText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNPP[]".$i."' name='txtNPP[]".$i."' class=\"npp\" value=\"\" style=\"width:400px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSPB)) {
                    $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"".$arrSPB[$i]."\">".$arrSPB[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtSPB[]".$i."' name='txtSPB[]".$i."' class=\"spb\" value=\"\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSP3)){
                    $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"".$arrSP3[$i]."\" style=\"text-align:left;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"sp3\" id='txt_sp3[]".$i."' name='txt_sp3[]".$i."' value=\"\" style=\"text-align:left;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrVendor)){
                    $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:250px;\"><option value=".$arrVendor[$i].">".$arrVendor[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtVendpr[]".$i."' name='txtVendpr[]".$i."' class=\"vendor\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrPelanggan)){
                    $strDetail.="<td><select disabled='disabled' id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"".$arrPelanggan[$i]."\">".$arrPelanggan[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtPelanggan[]".$i."' name='txtPelanggan[]".$i."' class=\"pelanggan\" style=\"width:200px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrProd)){
                    $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:250px;\"><option value=".$arrProd[$i].">".$arrProdText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtProduk[]".$i."' name='txtProduk[]".$i."' class=\"produk\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrNIP)){
                    $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:250px;\"><option value=".$arrNIP[$i].">".$arrNIPText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNIP[]".$i."' name='txtNIP[]".$i."' class=\"nip\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrHartap)){
                    $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=".$arrHartap[$i].">".$arrHartapText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtHartaTetap[]".$i."' name='txtHartaTetap[]".$i."' class=\"hartatetap\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrSumberDaya)){
                    $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"".$arrSumberDaya[$i]."\" style=\"text-align:left;width:400px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"sumberdaya\" id='txt_sumberdaya[]".$i."' name='txt_sumberdaya[]".$i."' value=\"\" style=\"text-align:left;width:400px;\"/></td>";
                }
                if (array_key_exists($i, $arrLini)){
                    $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:250px;\"><option value=".$arrLini[$i].">".$arrLiniText[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtLini[]".$i."' name='txtLini[]".$i."' class=\"lini\" style=\"width:250px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrPajak)){
                    $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"".$arrPajak[$i]."\" style=\"text-align:left;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"pajak\" id='txt_pajak[]".$i."' name='txt_pajak[]".$i."' value=\"\" style=\"text-align:left;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrKas)){
                    $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:300px;\"><option value=".$arrKas[$i].">".$arrKas[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefKas[]".$i."' name='txtNoRefKas[]".$i."' class=\"refkas\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrMem)){
                    $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:300px;\"><option value=".$arrMem[$i].">".$arrMem[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefMem[]".$i."' name='txtNoRefMem[]".$i."' class=\"refmem\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrTag)){
                    $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:300px;\"><option value=".$arrTag[$i].">".$arrTag[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoRefTagihan[]".$i."' name='txtNoRefTagihan[]".$i."' class=\"reftagihan\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrInvoice)){
                    $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:300px;\"><option value=".$arrInvoice[$i].">".$arrInvoice[$i]."</option></select></td>";
                } else {
                    $strDetail.="<td><select id='txtNoInvoice[]".$i."' name='txtNoInvoice[]".$i."' class=\"invoice\" style=\"width:300px;\"><option value=\"\"></option></select></td>";
                }
                if (array_key_exists($i, $arrLinino)) {
                    $strDetail.="<td><input type='hidden' type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"".$arrLinino[$i]."\" style=\"text-align:right;\"/></td>";
                } else {
                    $strDetail.="<td><input type='hidden'  type='text' class=\"linino\" id='txtLinino[]".$i."' name='txtLinino[]".$i."' value=\"\" style=\"text-align:right;\"/></td>";
                }
                if (array_key_exists($i, $arrSat)){
                    $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"".$arrSat[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
                } else {
                    $strDetail.="<td><input type='text' class=\"satuan\" id='txt_satuan[]".$i."' name='txt_satuan[]".$i."' value=\"\" style=\"text-align:right;width:140px;\"/></td>";
                }
                if (array_key_exists($i, $arrVol)){
                    $strDetail.="<td><input type='text' class=\"volume\" id='txt_volume[]".$i."' name='txt_volume[]".$i."' value=\"".$arrVol[$i]."\" style=\"text-align:right;width:140px;\"/></td>";
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