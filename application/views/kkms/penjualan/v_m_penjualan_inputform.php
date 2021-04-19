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
                                    <label id="lblTglDok">Nama Anggota : </label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        if($dmlmode=="INSERT"){
                                    ?>
                                            <select  id="txtNAMA" style="width:100%" name="txtNAMA"  class="clsNAMA"></select>
                                    <?php
                                        }else{
                                        ?>
                                            <input type="text" id="txtNAMA2" style="width:100%;text-align:left;" name="txtNAMA2"  class="form-control" readonly/>
                                    <input type="hidden" id="txtNAMA" style="width:100%;text-align:right;" name="txtNAMA"  class="form-control" readonly/>
                                    <?php
                                        }
                                        ?>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblTglDok">Tanggal : </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input id="tgldokId" type="text" value="<?php echo isset($TglDok)?$TglDok:""; if ($this->session->flashdata('message')) { $data=$this->session->flashdata('message'); if (isset($data['TglDok'])) { echo $data['TglDok']; } }?>" class="form-control tgl-dok" name="txtTglDok" />
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
                                    <input type="text" id="txtSekuritas" style="width:100%;text-align:left;" name="txtSekuritas"  class="form-control clsSekuritas" readonly/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lbrsekuritas">Emiten : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtEmiten" style="width:100%;text-align:left;" name="txtEmiten"  class="form-control clsSekuritas" readonly/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblJmlDimiliki">Jumlah Lembar Dimiliki : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtJmlLbrDimiliki" style="width:100%;text-align:right;" name="txtJmlLbrDimiliki"  class="form-control clsLBRMILIKI" readonly/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblLbrPengajuan">Jumlah Lembar : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtLbrPengajuan" style="width:100%;text-align:right;" name="txtLbrPengajuan"  class="form-control clsLBRPENGAJUAN" required/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblHrgPengajuan">Harga Per Lembar : </label>
                                </div>
                                
                                <div class="col-md-2">
                                    <input type="text" id="txtHrgPengajuan" style="width:100%;text-align:right;" name="txtHrgPengajuan"  class="form-control clsHRGPENGAJUAN" required/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row" style="padding-bottom: 10px;padding-top: 10px;">
                                <div class="col-md-2">
                                    <label id="lblTotalPengajuan">Jumlah Harga : </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="txtTotalPengajuan" style="width:100%;text-align:right;" name="txtTotalPengajuan"  class="form-control clsTOTALPENGAJUAN" required readonly/>
                                </div>
                                <div id="error_msg"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">


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

        $(".tgl-dok").datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateText) {
                
                //console.log(dateText);

            }
        });
        
        $(".clsNAMA").select2({
            tags: true,
            ajax: {
                url: '<?php echo base_url();?>index.php/kkms/LU_help/getLookupSelect2/KEPEMILIKAN',
                dataType: 'json'
            }
        });
        
        $('#id').val(id);
        $('#txtNAMA').val(nama);
        $('#txtNAMA2').val(nama2);
        $('#tgldokId').val(tgl);
        $('#txtSekuritas').val(sekuritas);
        $('#txtEmiten').val(emiten);
        $('#txtJmlLbrDimiliki').val(lbrdimiliki);
        $('#txtLbrPengajuan').val(lbrpengajuan);
        $('#txtHrgPengajuan').val(hrgpengajuan);
        $('#txtTotalPengajuan').val(totalpengajuan);
        
        
        $('.clsLBRMILIKI').number(true,0);
        $('.clsLBRPENGAJUAN').number(true);
        $('.clsHRGPENGAJUAN').number(true,0);
        $('.clsTOTALPENGAJUAN').number(true,0);

        $("#txtLbrPengajuan").keyup(function(){
            var lbrmiliki = parseInt($('#txtJmlLbrDimiliki').val());
            var lbrpengajuan = parseInt($('#txtLbrPengajuan').val());
            
            if(lbrpengajuan>lbrmiliki){
                alert('Jumlah lembar yang pengajuan tidak boleh melebihi dari yang dimiliki!!!');
                $('#txtLbrPengajuan').val(lbrmiliki);
                lbrpengajuan = lbrmiliki;
            }
            var hrgpengajuan = parseInt($('#txtHrgPengajuan').val());
            var totalpengajuan = hrgpengajuan * lbrpengajuan;
            $('#txtTotalPengajuan').val(totalpengajuan);
        });
        
        $("#txtHrgPengajuan").keyup(function(){
            var hrgpengajuan = parseInt($('#txtHrgPengajuan').val());
            var lbrpengajuan = parseInt($('#txtLbrPengajuan').val());
            var totalpengajuan = hrgpengajuan * lbrpengajuan;
            $('#txtTotalPengajuan').val(totalpengajuan);
        });
        
        $('.clsNAMA').on('select2:select', function (e) {
            var data = e.params.data;
            //console.log(data);
            
            var arrData = data.id.split("|");
            $('#txtSekuritas').val(arrData[1]);
            $('#txtEmiten').val(arrData[2]);
            $('#txtJmlLbrDimiliki').val(arrData[3]);
            //$('#txtJmlLbrJual').val(arrData[2]);
            $('#txtLbrPengajuan').val(0);
            $('#txtHrgPengajuan').val(0);
            $('#txtTotalPengajuan').val(0);
            
        });
        
    } );
    
    function cancelForm(){
        window.location.href = "<?php echo base_url().'kkms/M_penjualan/'; ?>";
    }
    
    function submitUpload(){
        var dmlmode = $('#dmlmode').val();
        var ID = $('#id').val();
        var arrID  = $('#txtNAMA').val().split('|');
        var nip = arrID[0];
        var sekuritas = $('#txtSekuritas').val();
        var emiten = $('#txtEmiten').val();
        var lbrdimiliki = $('#txtJmlLbrDimiliki').val();
        var tanggal = $('#tgldokId').val();
        var lbrpengajuan = $('#txtLbrPengajuan').val();
        var hrgpengajuan = $('#txtHrgPengajuan').val();
        var totalpengajuan = $('#txtTotalPengajuan').val();
        
        if(tanggal===''){
            alert("Tanggal Wajib Di Isi.....");
            $("#tgldokId").focus();
        }
        var paramsSent = { idmlmode: dmlmode, iID:ID, inip: nip, isekuritas:sekuritas, iemiten: emiten, ilbrdimiliki:lbrdimiliki, itgl:tanggal, ilbrpengajuan:lbrpengajuan, ihrgpengajuan:hrgpengajuan, itotalpengajuan:totalpengajuan };
        
        //console.log(paramsSent);
        
        $.ajax({
            url: "<?php echo base_url().'kkms/M_penjualan/saveData' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {
                if(data.Status=="OK"){
                    window.alert("Data sudah tersimpan....");
                    window.location.href = "<?php echo base_url().'kkms/M_penjualan';?>";
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