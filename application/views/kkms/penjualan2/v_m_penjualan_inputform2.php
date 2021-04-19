<?php
	if(isset($list_js_plugin)){
		foreach ($list_js_plugin as $list_js) {?>
            <script src="<?php echo base_url('assets/global/plugins/bower_components/'.$list_js); ?>"></script>
			<?php
		}
	}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="max-height: 600px;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        
        <form role="form" class="form-horizontal" id="faddNew" method="post" name="fupload" action="<?php echo base_url().'kkms/M_penjualan/saveData'?>" enctype="multipart/form-data" >
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="box-title"><?php echo $title; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
					<?php if ($this->session->flashdata('message')) { $data=$this->session->flashdata('message'); if (isset($data['f_info'])) {?>
                        <div class="alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Info!</strong> <?php echo $data['f_info']; } ?>
                        </div>
					<?php } ?>
					<?php if ($this->session->flashdata('messageonupdate')) { ?>
                        <div class="alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Info!</strong> <?php print_r($this->session->flashdata('messageonupdate')); ?>
                        </div>
					<?php } ?>
					<?php if ($this->session->flashdata('messageonupdate_error')) { ?>
                        <div class="alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Info!</strong> <?php echo $this->session->flashdata('messageonupdate_error'); ?>
                        </div>
					<?php } ?>
                    <div class="row" style="padding-left: 10px;">
                        <div class="col-md-11">
                            <!-- Hidden no dokumen -->
                            
                            
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblTglDok">Tanggal : </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input id="tgldokId" type="text" value="<?php echo isset($DATA[0]['tgl_batch'])?$DATA[0]['tgl_batch']:Date('d/m/Y'); ?>" class="form-control tgl-dok" name="txtTglDok" />
                                        <span class="input-group-btn">
						        <button type="button" class="btn btn-primary" data-toggle="datepicker" data-target-name="txtTglDok"><span class="glyphicon glyphicon-calendar"></span></button></span>
                                    </div>
                                </div>
                                <div id="error_msg"></div>
                                
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lbrsekuritas">Sekuritas : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtSekuritas" style="width:100%;text-align:left;" name="txtSekuritas"  class="form-control clsSekuritas" value="<?php echo isset($DATA[0]['sekuritas'])?$DATA[0]['sekuritas']:''; ?>" readonly />
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lbrsekuritas">Emiten : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtEmiten" style="width:100%;text-align:left;" name="txtEmiten"  class="form-control clsSekuritas"  value="<?php echo isset($DATA[0]['kode_emiten'])?$DATA[0]['kode_emiten']:''; ?>" readonly/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblTerimDanaDariSekuritas">Terima Dana Dari Sekuritas : </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary"><span>Rp.</span></button></span>
                                        <input type="text" id="txtDanaDariSekuritas" style="width:100%;text-align:right;" name="txtDanaDariSekuritas"  class="form-control clsDanaDariSekuritas" value="<?php echo isset($DATA[0]['terima_dari_sekuritas'])?$DATA[0]['terima_dari_sekuritas']:''; ?>"/>
                                    </div>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="margin-left:2px; padding-bottom: 10px;padding-top: 10px;background-color: #f2f2f2;">
                                <div class="col-md-4" style="text-align:center;">
                                </div>
                                <div class="col-md-3" style="text-align:center;border-bottom: 1px solid black;">
                                    <b>Pengajuan</b>
                                </div>
                                <div class="col-md-3" style="margin-left:10px;text-align:center;border-bottom: 1px solid black;">
                                    <b>Simpanan</b>
                                </div>
                                <div class="col-md-2" style="text-align:center;">
                                </div>
                            </div>
                            <div class="row" style="margin-left:2px; padding-bottom: 10px;padding-top: 10px;background-color: #f2f2f2;">
                                <div class="col-md-2" style="text-align:center;">
                                    <b>Nama Anggota</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>NIP</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Tgl Pengajuan</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Lembar</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Harga</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Total</b>
                                </div>
                                <div class="col-md-1" style="margin-left:10px;text-align:center;">
                                    <b>Wajib</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Pokok</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Sukarela</b>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                    <b>Hutang</b>
                                </div>
                            </div>
                            <?php
                                $i=1;
                                $totalLbr = 0;
                                $totalPengajuan=0;
                                
                                foreach($DATA as $key=>$value){
	                                $bgcolor = "";
                                    if(fmod($i,2)==0){
                                        $bgcolor = "background-color: #f2f2f2;";
                                    }
	                                $totalLbr += isset($value['lbr_terjual'])?$value['lbr_terjual']:$value['lbr_pengajuan'];
                                    $totalPengajuan += isset($value['total_terjual'])?$value['total_terjual']:$value['total_pengajuan'];
                                ?>
                            <div class="row" style="margin-left:2px;padding-bottom: 10px;padding-top: 10px;<?php echo $bgcolor;?>">
                                <div class="col-md-2" style="">
                                    <input type="checkbox" class="form-check-input clsSelectedRow" id="chk1" value="<?php echo $i;?>" checked>&nbsp;<?php echo $value["nama"]; ?>
                                    <input type="hidden" id="idrow_<?php echo $i;?>" class="clsIDRow" value="<?php echo $value['id'];?>"/>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
                                   <?php echo $value["nip"]; ?>
                                </div>
                                <div class="col-md-1" style="text-align:center;">
		                            <?php echo $value["tgl_pengajuan"]; ?>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtLbrPengajuan_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtLbrPengajuan"  class="form-control clsLBRPENGAJUAN" required value="<?php echo isset($value['lbr_terjual'])?$value['lbr_terjual']:$value['lbr_pengajuan'];?>" data-rownum="<?php echo $i;?>"/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtHrgPengajuan_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtHrgPengajuan"  class="form-control clsHRGPENGAJUAN" required value="<?php echo $value['hrg_pengajuan'];?>" readonly />
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtTotalPengajuan_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtTotalPengajuan"  class="form-control clsTOTALPENGAJUAN" required value="<?php echo isset($value['total_terjual'])?$value['total_terjual']:$value['total_pengajuan'];?>" readonly/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpPokok_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtSimpPokok"  class="form-control clsSIMPPOKOK" required value="<?php echo isset($value['simp_pokok'])?$value['simp_pokok']:''; ?>"/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpWajib_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtSimpWajib"  class="form-control clsSIMPWAJIB" required value="<?php echo isset($value['simp_wajib'])?$value['simp_wajib']:''; ?>" />
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpSukarela_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtSimpSukarela"  class="form-control clsSIMPSUKARELA" required value="<?php echo isset($value['simp_sukarela'])?$value['simp_sukarela']:''; ?>" />
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtPotHutang_<?php echo $i;?>" style="width:100%;text-align:right;" name="txtPotHutang"  class="form-control clsPOTHUTANG" required value="<?php echo isset($value['pot_hutang'])?$value['pot_hutang']:''; ?>" />
                                </div>
                            </div>
                            
                            <?php
                                    $i++;
                                }
                            ?>

                            <div class="row" style="margin-left:2px;padding-bottom: 10px;padding-top: 10px;<?php echo $bgcolor;?>">
                                <div class="col-md-4 style="font-weight: bold;text-align:center;">
                                    J U M L A H
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtLbrPengajuanJml" style="width:100%;text-align:right;" name="txtLbrPengajuan"  class="form-control clsLBRPENGAJUAN" required value="<?php echo $totalLbr; ?>" readonly/>
                                </div>
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtTotalPengajuanJml" style="width:100%;text-align:right;" name="txtTotalPengajuan"  class="form-control clsGRANDTOTALPENGAJUAN" required value="<?php echo $totalPengajuan;?>" readonly/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpPokokJml" style="width:100%;text-align:right;" name="txtSimpPokok"  class="form-control clsSIMPPOKOK" required value="" readonly/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpWajibJml" style="width:100%;text-align:right;" name="txtSimpWajib"  class="form-control clsSIMPWAJIB" required value="" readonly/>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" id="txtSimpSukarelaJml" style="width:100%;text-align:right;" name="txtSimpSukarela"  class="form-control clsSIMPSUKARELA" required value="" readonly/>
                                </div>
                                <div class="col-md-1">
                                
                                </div>
                            </div>
                            
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" onclick="cancelForm()">Cancel</button>
                                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Submit</button>
                                    <input type="hidden" id="dmlmode" value="<?php echo isset($dmlmode)?$dmlmode:'INSERT'; ?>" />
                                    <input type="hidden" id="id" value="<?php echo isset($ID)?$ID:''; ?>" />
	                               
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <!--  -->
                    <div class="row">
                        <div class="col-md-12" style="align-content: center;text-align:center;width:100%;">
							
                        </div>
                    </div>
                    <div class="row">
                        <br/>
                    </div>
                    <!------------  table ------------------------------->
                    <!-- Start body content -->
                    <div class="body-content animated fadeIn">
                    </div><!-- /.body-content -->
                    <!--/ End body content -->
                    <!------------ end table ---------------------------->

                </div>

            </div>
            <!-- /.box -->

            <!--/.col (left) -->
        </div>
        <!-- /.row -->
        </form>
		
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() {
        var id = '<?php echo isset($DATA["id"])?$DATA["id"]:"";?>';
        var nama = '<?php echo isset($DATA["nama"])?$DATA["nama"]:"";?>';
        var nama2 = '<?php echo isset($DATA["nama2"])?$DATA["nama2"]:"";?>';
        var tgl = '<?php echo isset($DATA["tgl"])?$DATA["tgl"]:"";?>';
        var sekuritas = '<?php echo isset($DATA["sekuritas"])?$DATA["sekuritas"]:"";?>';
        var emiten = '<?php echo isset($DATA["kode_emiten"])?$DATA["kode_emiten"]:"";?>';
        var lbrdimiliki = '<?php echo isset($DATA["lbr_dimiliki"])?$DATA["lbr_dimiliki"]:"";?>';
        var lbrpengajuan = '<?php echo isset($DATA["lbr_pengajuan"])?$DATA["lbr_pengajuan"]:"";?>';
        var hrgpengajuan = '<?php echo isset($DATA["hrg_pengajuan"])?$DATA["hrg_pengajuan"]:"";?>';
        var totalpengajuan = '<?php echo isset($DATA["total_pengajuan"])?$DATA["total_pengajuan"]:"";?>';
        
        var dblbrpengajuan = new Array();
        var dbhrgpengajuan = new Array();
        var dbtotalpengajuan = new Array();
        <?php
            foreach($DATA as $key=>$value) {
	           ?>
            dblbrpengajuan.push(<?php echo $value["lbr_pengajuan"];?>);
            dbhrgpengajuan.push(<?php echo $value["hrg_pengajuan"];?>);
            dbtotalpengajuan.push(<?php echo $value["total_pengajuan"];?>);
        <?php
            }
        ?>
        
        $('[data-toggle=datepicker]').each(function() {
            var target = $(this).data('target-name');
            var t = $('input[name=' + target + ']');
            t.datepicker({
                dateFormat: 'dd/mm/yy',
                theme: 'classic'
            });
            $(this).on("click", function() {
                t.datepicker("show");
            });
        });
        

        $('input[type="checkbox"]').click(function(){
            var idrow = this.value;
            var currTotal = parseFloat($('#txtTotalPengajuanJml').val());
            var thisRowTotal = parseFloat(dbtotalpengajuan[idrow-1]);

            var currTotalLbr = parseFloat($('#txtLbrPengajuanJml').val());
            var thisRowTotalLbr = parseFloat(dblbrpengajuan[idrow-1]);
            
            if($(this).prop("checked") == true){
                //console.log("Checkbox is checked.");
                currTotal = currTotal + thisRowTotal;
                currTotalLbr = currTotalLbr + thisRowTotalLbr;
                $('#txtLbrPengajuan_'+idrow).val(dblbrpengajuan[idrow-1]);
                $('#txtHrgPengajuan_'+idrow).val(dbhrgpengajuan[idrow-1]);
                $('#txtTotalPengajuan_'+idrow).val(dbtotalpengajuan[idrow-1]);
            }
            else if($(this).prop("checked") == false){
                //console.log("Checkbox is unchecked.");
                currTotal = currTotal - thisRowTotal;
                currTotalLbr = currTotalLbr - thisRowTotalLbr;
                $('#txtLbrPengajuan_'+idrow).val(0);
                $('#txtHrgPengajuan_'+idrow).val(0);
                $('#txtTotalPengajuan_'+idrow).val(0);
            }

            $('#txtTotalPengajuanJml').val(currTotal);
            $('#txtLbrPengajuanJml').val(currTotalLbr);
            
        });
        
        $(".tgl-dok").datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateText) {
            
            }
        });
        
       
        
        $('#txtDanaDariSekuritas').number(true,0);
        
        $('.clsLBRPENGAJUAN').number(true,0);
        $('.clsTOTALPENGAJUAN').number(true,0);
        $('.clsGRANDTOTALPENGAJUAN').number(true,0);
        $('.clsHRGPENGAJUAN').number(true,0);
        $('.clsSIMPPOKOK').number(true,0);
        $('.clsSIMPWAJIB').number(true,0);
        $('.clsSIMPSUKARELA').number(true,0);
        $('.clsPOTHUTANG').number(true,0);
        
        $('.clsLBRPENGAJUAN').keyup(function(){
            //console.log(this.value);
            var arrID = this.id.split("_");
            var rownum = arrID[1];
            var lbrPengajuan = parseFloat($('#txtLbrPengajuan_'+rownum).val().replace(/,/g, ""));
            var hrgPengajuan = parseFloat($('#txtHrgPengajuan_'+rownum).val().replace(/,/g, ""));
            var totalPengajuan = lbrPengajuan * hrgPengajuan;
            var GrandTotalPengajuan = 0;
            
            $('#txtTotalPengajuan_'+rownum).val(totalPengajuan);
            
            $('.clsTOTALPENGAJUAN').each(function(i, obj) {
                var totalRowPengajuan = parseFloat(obj.value.replace(/,/g, ""));
                GrandTotalPengajuan = GrandTotalPengajuan + totalRowPengajuan;
            });

            $('#txtTotalPengajuanJml').val(GrandTotalPengajuan);
            
        });
        
       
        
    } );
    
    function cancelForm(){
        window.location.href = "<?php echo base_url().'kkms/M_penjualan2/'; ?>";
    }
    
    function submitUpload(){
        var dmlmode = $('#dmlmode').val();

        var tanggal = $('#tgldokId').val();
        var sekuritas = $('#txtSekuritas').val();
        var emiten = $('#txtEmiten').val();
        var terimaDana = $('#txtDanaDariSekuritas').val();
        var dataRow = [];
        
        $('.clsSelectedRow').each(function(i, obj) {
            if($(this).prop("checked") == true){
                var IDSRd = $('#idrow_'+obj.value).val();
                var LbrPengajuanRd = $('#txtLbrPengajuan_'+obj.value).val();
                var HrgPengajuanRd = $('#txtHrgPengajuan_'+obj.value).val();
                var TotalPengajuanRd = $('#txtTotalPengajuan_'+obj.value).val();
                var SimpPokokRd = $('#txtSimpPokok_'+obj.value).val();
                var SimpWajibRd = $('#txtSimpWajib_'+obj.value).val();
                var SimpSukarelaRd = $('#txtSimpSukarela_'+obj.value).val();
                dataRow.push({
                    IDDB : IDSRd,
                    LbrPengajuan : LbrPengajuanRd,
                    HrgPengajuan : HrgPengajuanRd,
                    TotalPengajuan : TotalPengajuanRd,
                    SimpPokok : SimpPokokRd,
                    SimpWajib : SimpWajibRd,
                    SimpSukarela : SimpSukarelaRd
                });
            }
        });
        
        if(tanggal===''){
            alert("Tanggal Wajib Di Isi.....");
            $("#tgldokId").focus();
        }
        
        
        var paramsSent = { idmlmode: dmlmode, itanggal : tanggal, isekuritas:sekuritas, iemiten: emiten, iterimadana:terimaDana, idatarow : dataRow };
        
        //console.log(paramsSent);
        
        $.ajax({
            url: "<?php echo base_url().'kkms/M_penjualan2/setTerjual' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {
                if(data.Status=="OK"){
                    window.alert("Data sudah tersimpan....");
                    window.location.href = "<?php echo base_url().'kkms/M_penjualan2';?>";
                }else{
                    window.alert("ERROR :"+data.ErrorMsg);
                }
                
            },
            error: function (data) {
                // console.log(data);
                console.log('error');
            }
        });
        
        
        
    }

</script>