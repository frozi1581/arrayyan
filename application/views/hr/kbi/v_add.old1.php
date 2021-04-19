<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lookupbox.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.lookupbox.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />

<?php

	
if(isset($list_js_plugin)){
    foreach ($list_js_plugin as $list_js) {?>
        <!-- JS plugin -->
        <script src="<?php echo base_url('assets/global/plugins/bower_components/'.$list_js); ?>"></script>
<?php
    }
	
	
}
?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.darkblue.css" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
 <style type="text/css">
        .jqx-grid-header
        {
             height: auto !important;vertical-align:bottom;
             cursor: col-resize;
        }
        .centerTest2{
            margin-top: 10px;margin-left: 5px
        }
        .centerTest{
            font:Verdana, Geneva, sans-serif;
            font-size:18px;
            text-align:left;
            background-color:#0F0;
            height:50px;
            display: table;
            width: 100%;
        }
      .centerTest span {
            vertical-align:middle;
            display: table-cell;
      }
</style> 

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                 <?php   if ($this->session->flashdata('message')) { ?>
                    <div class="alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
                  </div>
                 <?php } ?>
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
        
                <form role="form" id="fheader" class="form-horizontal" action="#" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <label for="txtBL" class="col-sm-1 control-label"   >Periode</label>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <input class="form-control" id="txtBL" name="txtBL" placeholder="mmyyyy"  maxlength="6" value="<?php echo isset($BL)?$BL:""; ?>"  required readonly>
                            </div>
                        </div>  
                        <div class="form-group">
                            <input class="form-control" id="txtST_DATE" name="txtST_DATE" value="<?php echo isset($ST_DATE)?$ST_DATE:""; ?>" readonly type="hidden">
                            <input class="form-control" id="txtEND_DATE" name="txtEND_DATE" value="<?php echo isset($END_DATE)?$END_DATE:""; ?>" readonly type="hidden">
                        </div>
                        <input class="form-control" id="txtJNS" name="txtJNS" type="hidden" readonly>
                        <input class="form-control" id="txtIS_MANAGER" name="txtIS_MANAGER" value="<?php echo $IS_MANAGER;?>" type="hidden" readonly>
                       <!--------------------------------- TES TABULASI ---------------------------------------->
                       <div class="box-body">
                            <ul class="nav nav-pills">
                              <li class="tab active"><a data-toggle="pill" href="#home">Pegawai Dinilai</a></li>
                              <li><a class="tab" data-toggle="pill" href="#menu1">Penilai Atasan</a></li>
                              <li><a class="tab" data-toggle="pill" href="#menu2">Penilai 1 Peer</a></li>
                            <!--  <li><a class="tab" data-toggle="pill" href="#menu3" style="display: none;">Penilai Bawahan</a></li>
                              --> 
                             <?php
                                if($IS_MANAGER==='1'){
                                    echo "<li><a class='tab' data-toggle='pill' href='#menu3' >Penilai Bawahan</a></li>";
                                }else{
                                    echo "<li><a class='tab' data-toggle='pill' href='#menu3' style='display: none;'>Penilai Bawahan</a></li>";
                                }
                              ?>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <div class="box box-primary box-solid">
                                          <div class="box-header">
                                            <h3 class="box-title">Pegawai Dinilai</h3>
                                          </div>
                                          <!-- /.box-header -->
                                          <div class="box-body"> 
                                                <div class="form-group">
                                                    <label for="txtNIP" class="col-sm-1 control-label ">NIP Pegawai</label>
                                                   <div class="col-sm-2">
                                                       <input class="form-control" id="txtNIP" name="txtNIP" value="<?php echo isset($NIP)?$NIP:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA" class="col-sm-1 control-label"   >Nama Pegawai</label>
                                                   <div class="col-sm-3">
                                                       <input class="form-control" id="txtNAMA" name="txtNAMA" value="<?php echo isset($NAMA)?$NAMA:""; ?>"  required readonly>
                                                   </div>
                                                </div> 
                                                <div class="form-group" >
                                                  <div class="col-sm-10 pull-right">
                                                    <a onclick="moveTab('menu1')" class="btn btn-success">Selanjutnya</a>
                                                  </div>
                                                </div>
                                          </div>
                                          <!-- /.box-body -->
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                  <h3></h3>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid">
                                        <div class="box-header">
                                          <h3 class="box-title">Pegawai Penilai(Atasan)</h3>
                                        </div>
                                         <div class="box-body">   
                                            <div class="form-group">
                                                    <label for="txtNIP_A" class="col-sm-1 control-label "   >NIP </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_A" name="txtNIP_A" value="<?php echo isset($NIP_A)?$NIP_A:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_A" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_A" name="txtNAMA_A" value="<?php echo isset($txtNAMA_A)?$txtNAMA_A:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIPA" class="btn btn-primary"   onclick="evtOpenLUA()" ><i class="fa fa-search"></i></button>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-sm-10 pull-right">
                                                  <a onclick="moveTab('home')" class="btn btn-success">Sebelumnya</a>
                                                  <a onclick="moveTab('menu2')" class="btn btn-success">Selanjutnya</a>
                                                </div>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                  </div>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                  <h3></h3>
                                  <!-- start row -->
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid">
                                        <div class="box-header">
                                          <h3 class="box-title">Pegawai Penilai(1 Peer)</h3>
                                        </div>
                                        <div class="box-body">  
                                            <div class="form-group">
                                                    <label for="txtNIP_P1" class="col-sm-1 control-label "   >NIP  </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_P1" name="txtNIP_P1" value="<?php echo isset($NIP_P1)?$NIP_P1:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_P1" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_P1" name="txtNAMA_P1" value="<?php echo isset($txtNAMA_P1)?$txtNAMA_P1:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIPP1" class="btn btn-primary"   onclick="evtOpenLUP1()" ><i class="fa fa-search"></i></button>
                                           </div>
                                           <div class="form-group">
                                                    <label for="txtNIP_P2" class="col-sm-1 control-label "   >NIP  </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_P2" name="txtNIP_P2" value="<?php echo isset($NIP_P2)?$NIP_P2:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_P2" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_P2" name="txtNAMA_P2" value="<?php echo isset($txtNAMA_P2)?$txtNAMA_P2:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIPP2A" class="btn btn-primary"   onclick="evtOpenLUP2()" ><i class="fa fa-search"></i></button>
                                           </div>
                                            <div class="form-group" >
                                              <div class="col-sm-10 pull-right">
                                                <a onclick="moveTab('menu1')" class="btn btn-success">Sebelumnya</a>
                                                <a onclick="moveTab('menu3')" id="nmenu3"   class="btn btn-success">Selanjutnya</a>
                                              </div>
                                            </div>
                                        </div>
   
                                      </div>
                                    </div>
                                  </div>

                                  <!-- end row -->
                                </div>
                                <div id="menu3" class="tab-pane fade" >
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid" >
                                        <div class="box-header">
                                          <h3 class="box-title">Pegawai Penilai(Bawahan)</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                    <label for="txtNIP_B1" class="col-sm-1 control-label "   >NIP  </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_B1" name="txtNIP_B1" value="<?php echo isset($NIP_B1)?$NIP_B1:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_B1" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_B1" name="txtNAMA_B1" value="<?php echo isset($txtNAMA_B1)?$txtNAMA_B1:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIPB1" class="btn btn-primary"   onclick="evtOpenLUB1()" ><i class="fa fa-search"></i></button>
                                           </div>
                                           <div class="form-group">
                                                    <label for="txtNIP_B2" class="col-sm-1 control-label "   >NIP  </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_B2" name="txtNIP_B2" value="<?php echo isset($NIP_B2)?$NIP_B2:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_B2" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_B2" name="txtNAMA_B2" value="<?php echo isset($txtNAMA_B2)?$txtNAMA_B2:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIPB2" class="btn btn-primary"   onclick="evtOpenLUB2()" ><i class="fa fa-search"></i></button>
                                           </div>
                                           <div class="form-group">
                                                    <label for="txtNIP_B3" class="col-sm-1 control-label "   >NIP  </label>
                                                   <div class="col-sm-2" >
                                                       <input class="form-control" id="txtNIP_B3" name="txtNIP_B3" value="<?php echo isset($NIP_B3)?$NIP_B3:""; ?>"  required readonly>
                                                   </div>
                                                   <label for="txtNAMA_B3" class="col-sm-1 control-label">Nama Pegawai</label>
                                                   <div class="col-sm-3" >
                                                       <input class="form-control" id="txtNAMA_B3" name="txtNAMA_B3" value="<?php echo isset($txtNAMA_B3)?$txtNAMA_B3:""; ?>"  required readonly>
                                                   </div>
                                                   <button type="button" id="btnopenLUNIP3" class="btn btn-primary"   onclick="evtOpenLUB3()" ><i class="fa fa-search"></i></button>
                                           </div>

                                         
                                            <div class="form-group" >
                                              <div class="col-sm-10 pull-right">
                                                <a onclick="moveTab('menu2')" class="btn btn-success">Sebelumnya</a>
                                              </div>
                                            </div>
                                        </div>
   
                                      </div>
                                    </div>
                                  </div>

                                </div>
                            </div>
                       </div>
              
                       <!--------------------------------- end TES TABULASI ------------------------------------>
                    </div> 
                    <button type="button" id="btnModalBack" name="btnModalBack" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUBACK()">BACK</button>
                    <button type="button" id="btnSubmitPenilai" name="btnSubmitPenilai" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitPENILAI()">SAVE</button>
                </form>
                
                
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>hr/potongan/save_" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
               <div class="col-md-12">
                <div style="margin-top: 1px" id="jqxlistbox"></div>
            </div>    
        </div>    
<script type="text/javascript">
        $(document).ready(function () {
            if(document.getElementById("txtIS_MANAGER").value==='0'){
                $("#nmenu3").hide();
            }
           // $( "#TGL_MULAI" ).datepicker();
           // $( "#TGL_SELESAI" ).datepicker();
       });
        function moveTab(tab){
            $('.nav-pills a[href="#' + tab + '"]').tab('show');
        }

        function evtOpenLUA(){
            document.getElementById("txtJNS").value='LUA'; 
             $('#show_nipa').modal('show');
        }
        function evtOpenLUP1(){
            document.getElementById("txtJNS").value='LUP1'; 
            $('#show_nipp').modal('show');
        }
        function evtOpenLUP2(){
            document.getElementById("txtJNS").value='LUP2'; 
            $('#show_nipp').modal('show');
        }
        function evtOpenLUB1(){
            document.getElementById("txtJNS").value='LUB1'; 
            $('#show_nipb').modal('show');
        }
        function evtOpenLUB2(){
            document.getElementById("txtJNS").value='LUB2'; 
            $('#show_nipb').modal('show');
        }
        function evtOpenLUB3(){
            document.getElementById("txtJNS").value='LUB3'; 
            $('#show_nipb').modal('show');
        }
        function submitPENILAI(){
            var selectedId=[];
            // txtBL,txtST_DATE,txtEND_DATE,txtNIP,txtNIP_A,txtNIP_P1,txtNIP_P2,txtNIP_B1,txtNIP_B2,txtNIP_B3
            selectedId[0]= document.getElementById("txtBL").value;
            selectedId[1]= document.getElementById("txtST_DATE").value;
            selectedId[2]= document.getElementById("txtEND_DATE").value;
            selectedId[3]= document.getElementById("txtNIP").value;
            selectedId[4]= document.getElementById("txtNIP_A").value;
            selectedId[5]= document.getElementById("txtNIP_P1").value;
            selectedId[6]= document.getElementById("txtNIP_P2").value;
            selectedId[7]= document.getElementById("txtNIP_B1").value;
            selectedId[8]= document.getElementById("txtNIP_B2").value;
            selectedId[9]= document.getElementById("txtNIP_B3").value;
            $.ajax({
                url: "<?php echo base_url().'hr/kbi/M_index/savePenilai'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               dataType: 'json',
                success: function (data) {
                 // location.reload();
                 window.history.back();
            
                },
                error: function (data) {
                    console.log('error');
                }
            });
        }
        function submitLUNIP(){
            if(document.getElementById("txtJNS").value==='LUA'){
                var selectedrowindex = $("#jqxGridNIPA").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPA').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPA').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_A").value=Value_; 
                document.getElementById("txtNAMA_A").value=Value_1; 
                $('#show_nipa').modal('hide');
            }
            if(document.getElementById("txtJNS").value==='LUP1'){
                var selectedrowindex = $("#jqxGridNIPP").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPP').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPP').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_P1").value=Value_; 
                document.getElementById("txtNAMA_P1").value=Value_1; 
                $('#show_nipp').modal('hide');
            }
            if(document.getElementById("txtJNS").value==='LUP2'){
                var selectedrowindex = $("#jqxGridNIPP").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPP').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPP').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_P2").value=Value_; 
                document.getElementById("txtNAMA_P2").value=Value_1; 
                $('#show_nipp').modal('hide');
            }
            if(document.getElementById("txtJNS").value==='LUB1'){
                var selectedrowindex = $("#jqxGridNIPB").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_B1").value=Value_; 
                document.getElementById("txtNAMA_B1").value=Value_1; 
                $('#show_nipb').modal('hide');
            }
            if(document.getElementById("txtJNS").value==='LUB2'){
                var selectedrowindex = $("#jqxGridNIPB").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_B2").value=Value_; 
                document.getElementById("txtNAMA_B2").value=Value_1; 
                $('#show_nipb').modal('hide');
            }
            if(document.getElementById("txtJNS").value==='LUB3'){
                var selectedrowindex = $("#jqxGridNIPB").jqxGrid('getselectedrowindex');
                var Value_  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                var Value_1  = $('#jqxGridNIPB').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
                document.getElementById("txtNIP_B3").value=Value_; 
                document.getElementById("txtNAMA_B3").value=Value_1; 
                $('#show_nipb').modal('hide');
            }
        //window.location.reload(true);
        }
        function f_dec2(val_){
            var nilai =(val_.toString()).replace(/,/g, '');
            nilai = nilai.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            return nilai;
        }; 
        function f_dec(obj){
            var nilai = $(obj).val().replace(/,/g, '');
            $(obj).val(nilai.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $(obj).on("input", function() {
                var v= $(this).val().replace(/,/g, '');
                $(this).val(v.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            });
        };
        function submitLUBACK(){
             window.history.back();
            // window.location.href = "<?php echo base_url().'hr/kbi/editData/';?>";
          //  window.location.reload(true);
                                
        }
        
         
        
        
</script>

                <!------------  table ------------------------------->
                <!------------ end table ---------------------------->
                
                </div>    
            </form>
          </div>
          <!-- /.box -->
       
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<!-- modal   Lookup NIP Atasan -->
  <div class="modal fade" id="show_nipa" style="display: none;">
    <div class="modal-dialog " style="width:1200px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo isset($gridLUNIPA_H)?$gridLUNIPA_H:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <?php echo isset($gridLUNIPA)?$gridLUNIPA:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Cetakan -->
<!-- modal   Lookup NIP Peer -->
  <div class="modal fade" id="show_nipp" style="display: none;">
    <div class="modal-dialog " style="width:1100px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo isset($gridLUNIPP_H)?$gridLUNIPP_H:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <?php echo isset($gridLUNIPP)?$gridLUNIPP:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal NIP Peer -->
<!-- modal   Lookup NIP Peer -->
  <div class="modal fade" id="show_nipb" style="display: none;">
    <div class="modal-dialog " style="width:1100px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo isset($gridLUNIPB_H)?$gridLUNIPB_H:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <?php echo isset($gridLUNIPB)?$gridLUNIPB:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end sho LU NIP Bawahan -->



    