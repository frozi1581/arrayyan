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
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-redmond.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-start.css" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>
    
    <!-- auto search on select drop down --->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/select2/dist/js/select2.min.js"></script> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/dist/css/select2.min.css" type="text/css" />

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
    .row{margin-top: 10px;margin-left: 2px}
    .input-disabled{
            background-color:#ffffff !important;
    }
</style> 
<script type="text/javascript">
    var aCOA = new Array(20);for(i=0;i<20;i++){aCOA[i]="";}   
    var aCOAKET = new Array(20);for(i=0;i<20;i++){aCOAKET[i]="";}
    var aNPP =  new Array(20);for(i=0;i<20;i++){aNPP[i]="";}
    var aKAS =  new Array(20);for(i=0;i<20;i++){aKAS[i]="";}var aKASKET =  new Array(20);for(i=0;i<20;i++){aKASKET[i]="";}
    var aPAT =  new Array(20);for(i=0;i<20;i++){aPAT[i]="";}var aPATKET =  new Array(20);for(i=0;i<20;i++){aPATKET[i]="";}
    var aGAS =  new Array(20);for(i=0;i<20;i++){aGAS[i]="";}var aGASKET =  new Array(20);for(i=0;i<20;i++){aGASKET[i]="";}
    var aNIP =  new Array(20);for(i=0;i<20;i++){aNIP[i]="";}var aNIPKET =  new Array(20);for(i=0;i<20;i++){aNIPKET[i]="";}
    var aPROD =  new Array(20);for(i=0;i<20;i++){aPROD[i]="";}var aPRODKET =  new Array(20);for(i=0;i<20;i++){aPRODKET[i]="";}
    var aLINI =  new Array(20);for(i=0;i<20;i++){aLINI[i]="";}var aLINIKET =  new Array(20);for(i=0;i<20;i++){aLINIKET[i]="";}
    var aVENDOR =  new Array(20);for(i=0;i<20;i++){aVENDOR[i]="";}var aVENDORKET =  new Array(20);for(i=0;i<20;i++){aVENDORKET[i]="";}
    var aMEMORIAL =  new Array(20);for(i=0;i<20;i++){aMEMORIAL[i]="";}
    var mLoad = false;var mLoad2 = false;var mLoadNPP = false;var mDATAGRIDS=[];
    $(document).ready(function () {
        if($('#f_status').val() ==='NEW') selectedId = "<?php echo $this->session->userdata('s_uID'); ?>";
        if($('#f_status').val() ==='EDIT' || $('#f_status').val() ==='VIEW'  ) selectedId = "<?php echo isset($ID)?$ID:""; ?>";
       // document.getElementById("txtID").value=  selectedId;
       $('#btnRefComp').jqxButton({theme:'ui-start',  height:'10%'});
       $('#btnRefPAT').jqxButton({theme:'ui-start',  height:'10%'});
       $('#btnRefGAS').jqxButton({theme:'ui-start',  height:'10%'});
        var SaveDokButton =  $('#saveDokbutton').jqxButton({theme:'ui-start', width:'100px', height:'35px'});
        var HomeListButton   =  $('#HomeListButton').jqxButton({theme:'ui-start', width:'100px', height:'35px'});
                   
       $('#idID_CORP').val('').trigger("change");$('#idID_CORP').select2();
       $('#idKD_PAT').val('').trigger("change");$('#idKD_PAT').select2();
       $('#idKD_GAS').val('').trigger("change");$('#idKD_GAS').select2();
       $('#idID_CORP_PARENT').val('').trigger("change");$('#idID_CORP_PARENT').select2();
       
       if($('#f_status').val() ==='VIEW'){
            $('#idID_CORP').val("<?php echo isset($idCOMPANY)?$idCOMPANY:""; ?>").trigger("change");$('#idID_CORP').select2();
            $('#idKD_PAT').val("<?php echo isset($idPAT)?$idPAT:""; ?>").trigger("change");$('#idKD_PAT').select2();
            $('#idKD_GAS').val("<?php echo isset($idGAS)?$idGAS:""; ?>").trigger("change");$('#idKD_GAS').select2();
            $('#idID_CORP').prop('disabled', true);$('#idKD_PAT').prop('disabled', true);$('#idKD_GAS').prop('disabled', true);
            document.getElementById("btnRefComp").style.display = "none"; document.getElementById("btnRefPAT").style.display = "none";
            document.getElementById("btnRefGAS").style.display = "none"; document.getElementById("saveDokbutton").style.display = "none"; 
        }
        if($('#f_status').val() ==='EDIT'){
            $('#idID_CORP').val("<?php echo isset($idCOMPANY)?$idCOMPANY:""; ?>").trigger("change");$('#idID_CORP').select2();
            $('#idKD_PAT').val("<?php echo isset($idPAT)?$idPAT:""; ?>").trigger("change");$('#idKD_PAT').select2();
            $('#idKD_GAS').val("<?php echo isset($idGAS)?$idGAS:""; ?>").trigger("change");$('#idKD_GAS').select2();
        }
       HomeListButton.click(function(event){
           window.location.href = "<?php echo base_url().'hr/pat-gas/M_index/';?>";
           return false;
       });
       
        SaveDokButton.click(function (event) {
            var selectedId=[];
            selectedId.push($("#f_status").val());            
            selectedId.push($("#idID_CORP").val());            
            selectedId.push($("#idKD_PAT").val());            
            selectedId.push($("#idKD_GAS").val());   
            selectedId.push($("#txtID").val());   
            $.ajax({
                url: "<?php echo base_url().'hr/pat-gas/M_index/SAVE_NEW'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    window.location.href = "<?php echo base_url().'hr/pat-gas/M_index/';?>";
                  },
                error: function (data) {
                    console.log('error');
                }
            });
                        
            return false;
         }); 
    });
    function goHome(){
    }
    function AddComp(){
         $('#idID_CORP_PARENT').val('').trigger("change");
         $('#show_AddComp').modal('show'); return false;
    }
    function AddPAT(){
         $('#show_AddPAT').modal('show'); return false;
    }
    function AddGAS(){
         $('#show_AddGAS').modal('show'); return false;
    }
    function cekCompany(){
        var selectedId = $('#txtID_CORPref').val();
         $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/CEK_COMPANY'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                console.log(data);$('#txtID_CORPref').val(data[0]['ID_CORP']);
                $('#txtKET_CORPref').val(data[0]['KETERANGAN']);
                if(data[0]['PARENT_ID_CORP']!=='') $('#idID_CORP_PARENT').val(data[0]['PARENT_ID_CORP']).trigger("change");
                
              },
            error: function (data) {
                console.log('error');
            }
        });
    }
    function cekPAT(){
        var selectedId = $('#txtKD_PATref').val();
        console.log(selectedId);
         $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/CEK_PAT'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                $('#txtKET_PATref').val(data[0]['KET']);
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
 function cekGAS(){
        var selectedId = $('#txtKD_GASref').val();
        console.log(selectedId);
         $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/CEK_GAS'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                $('#txtKET_GASref').val(data[0]['KET']);
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
    function submitCompRef(){
        var selectedId=[];
        selectedId.push($('#txtID_CORPref').val());            
        selectedId.push($('#txtKET_CORPref').val());            
        selectedId.push($('#idID_CORP_PARENT').val());            
        $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/ADD_COMPANY'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                window.location.reload();
              },
            error: function (data) {
                console.log('error');
            }
        });
    }
   function submitPATRef(){
        var selectedId=[];
        selectedId.push($('#txtKD_PATref').val());            
        selectedId.push($('#txtKET_PATref').val());            
        $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/ADD_PAT'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                window.location.reload();
              },
            error: function (data) {
                console.log('error');
            }
        });
    } 
     function submitGASRef(){
        var selectedId=[];
        selectedId.push($('#txtKD_GASref').val());            
        selectedId.push($('#txtKET_GASref').val());            
        $.ajax({
            url: "<?php echo base_url().'hr/pat-gas/M_index/ADD_GAS'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
                window.location.reload();
              },
            error: function (data) {
                console.log('error');
            }
        });
    } 
    
    
    
    
</script>
        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-sm-1">
                         <h3 class="box-title"><?php echo $title; ?></h3>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                 <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
                  </div>
                 <?php } 
                 ?>
                <form role="form" id="fItems"  class="form-horizontal" >
                <input type="hidden" id="f_status" style="width:100%" name="f_status" value="<?php echo isset($f_status)?$f_status:""; ?>" class="form-control" required readonly>
                <input type="hidden" id="txtID" style="width:100%" name="txtID" value="<?php echo isset($oldKey)?$oldKey:""; ?>" class="form-control" required readonly >
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
                <div class="form-group">
                    <div class="row">
                        <label for="idID_CORP" style="font-weight:bold;text-align: left;width: 20%"  class="col-sm-2 control-label">ID Perusahaan</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="idID_CORP" id="idID_CORP" style="width:100%">
                            <?php  
                            foreach ($aCOMPANY as $d1) {  
                                $opt = "<option  value='".$d1['ID_CORP']."'> " ;
                                $opt .= $d1['ID_CORP'].' - '.$d1['KETERANGAN'];
                                $opt .=" </option>";
                                echo $opt;
                            }
                                ?>
                            </select>
                        </div>   
                        <div class="col-sm-1">
                            <button type="button" id="btnRefComp" name="btnRefComp" onclick="AddComp()" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start"  style="display:block;" data-dismiss="modal" title="Tambah Data Referensi Kode Company"><i class="fas fa-plus fa-lg fa-fw"></i>Tambah referensi</button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label for="idKD_PAT" style="font-weight:bold;text-align: left;width: 20%"  class="col-sm-2 control-label">PPU</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="idKD_PAT" id="idKD_PAT" style="width:100%">
                            <?php  
                            foreach ($aPPU as $d1) {  
                                $opt = "<option  value='".$d1['KD_PAT']."'> " ;
                                $opt .= $d1['KD_PAT'].' - '.$d1['KET'];
                                $opt .=" </option>";
                                echo $opt;
                            }
                                ?>
                            </select>
                        </div>  
                        <div class="col-sm-1">
                            <button type="button" id="btnRefPAT" name="btnRefPAT" onclick="AddPAT()" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start"   style="display:block;" data-dismiss="modal" title="Tambah Data Referensi Kode PAT"><i class="fas fa-plus fa-lg fa-fw"></i>Tambah referensi</button>
                        </div>
                    </div>                   
                    <div class="row">
                        <label for="idKD_GAS" style="font-weight:bold;text-align: left;width: 20%"  class="col-sm-2 control-label">BIRO/SEKSI</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="idKD_GAS" id="idKD_GAS" style="width:100%">
                            <?php  
                                foreach ($aGAS as $d1) {  
                                     $opt = "<option  value='".$d1['KD_GAS']."'> " ;
                                    $opt .= $d1['KD_GAS'].' - '.$d1['KET'];
                                    $opt .=" </option>";
                                    echo $opt;
                                }
                            ?>
                            </select>
                        </div> 
                        <div class="col-sm-1">
                            <button type="button" id="btnRefGAS" name="btnRefGAS" onclick="AddGAS()" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start"   style="display:block;" data-dismiss="modal" title="Tambah Data Referensi Kode GAS"><i class="fas fa-plus fa-lg fa-fw"></i>Tambah referensi</button>
                        </div>
                    </div>
                </div>
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;margin-left: 1%;margin-right: 1%;" > 
                </div>
                <div class='row'>
                        <div class="col-md-12">
                            <div id="popupWindow"></div>
                            <div style="margin-top: 1px" id="jqxlistbox"></div>
                        </div>    
                </div>    
                <!------------  table ------------------------------->
                <!-- Start body content -->
                    <div class="body-content animated fadeIn">
                    </div><!-- /.body-content -->
                <!--/ End body content -->
                <!------------ end table ---------------------------->
                <div id="nav_form" class="row" style="width: 120%;display: flex;">
                        <div class="col-sm-6">
                            <button id="saveDokbutton" name="saveDokbutton"  style="cursor:pointer;padding: 3px; margin: 2px;float:left;" title="Simpan Data"><i class="fas  fa-save fa-lg fa-fw"></i>Simpan</button>
                            <button id="HomeListButton" name="HomeListButton"  style="cursor:pointer;padding: 3px; margin: 2px;float:left;" title="Home"><i class="fas fa-times-circle fa-lg fa-fw"></i>Kembali</button>
                        </div>
                </div>
                </div>    
          </div>
          <!-- /.box -->
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->

<!-- modal   Lookup show AddComp -->
  <div class="modal fade" id="show_AddComp" style="display: none;">
    <div class="modal-dialog " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">ADD/UPDATE KODE COMPANY</h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
            <div class="modal-body">
                <div class="row">
                    <label for="txtID_CORPref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">ID Perusahaan</label>
                    <div class="col-sm-5">
                        <input type="text" id="txtID_CORPref" style="width:50%;margin-left: 30%" name="txtID_CORPref" class="form-control" onchange="cekCompany(this)">
                    </div>   
                </div>
                <div class="row">
                    <label for="txtKET_CORPref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">Keterangan Perusahaan</label>
                    <div class="col-sm-5">
                          <input type="text" id="txtKET_CORPref" style="width:180%;margin-left: 30%" name="txtKET_CORPref" class="form-control" >
                    </div>   
                </div>
                <div class="row">
                    <label for="idID_CORP_PARENT" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">ID Perusahaan Induk</label>
                    <div class="col-sm-5" style="margin-left: 12%">
                        <select class="form-control" name="idID_CORP_PARENT" id="idID_CORP_PARENT" style="width:180%;">
                            <?php  
                            foreach ($aCOMPANY as $d1) {  
                                $opt = "<option  value='".$d1['ID_CORP']."'> " ;
                                $opt .= $d1['ID_CORP'].' - '.$d1['KETERANGAN'];
                                $opt .=" </option>";
                                echo $opt;
                            }
                                ?>
                            </select> 
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <div id="nav_form" class="row" style="width: 100%;display: flex;">
                    <button type="button" class="btn btn-default pull-left" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px "  data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px"  class="btn btn-primary" onclick="submitCompRef()">Save</button>
                </div>
            </div>    
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Company -->

<!-- modal   Lookup  show_AddPAT  -->
  <div class="modal fade" id="show_AddPAT" style="display: none;">
    <div class="modal-dialog " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">ADD/UPDATE TABEL REFERENSI PAT</h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
            <div class="modal-body">
                <div class="row">
                    <label for="txtKD_PATref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">Kode PAT</label>
                    <div class="col-sm-5">
                        <input type="text" id="txtKD_PATref" style="width:50%;margin-left: 30%" name="txtKD_PATref" class="form-control" onchange="cekPAT(this)">
                    </div>   
                </div>
                <div class="row">
                    <label for="txtKET_PATref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">Keterangan PAT</label>
                    <div class="col-sm-5">
                          <input type="text" id="txtKET_PATref" style="width:180%;margin-left: 30%" name="txtKET_PATref" class="form-control" >
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <div id="nav_form" class="row" style="width: 100%;display: flex;">
                    <button type="button" class="btn btn-default pull-left" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px "  data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px"  class="btn btn-primary" onclick="submitPATRef()">Save</button>
                </div>
            </div>    
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal PAT -->
<!-- modal   Lookup  show_AddGAS  -->
  <div class="modal fade" id="show_AddGAS" style="display: none;">
    <div class="modal-dialog " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">ADD/UPDATE TABEL REFERENSI GAS</h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
            <div class="modal-body">
                <div class="row">
                    <label for="txtKD_GASref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">Kode GAS</label>
                    <div class="col-sm-5">
                        <input type="text" id="txtKD_GASref" style="width:50%;margin-left: 30%" name="txtKD_GASref" class="form-control" onchange="cekGAS(this)">
                    </div>   
                </div>
                <div class="row">
                    <label for="txtKET_GASref" style="font-weight:bold;text-align: left;"  class="col-sm-2 control-label">Keterangan GAS</label>
                    <div class="col-sm-5">
                          <input type="text" id="txtKET_GASref" style="width:180%;margin-left: 30%" name="txtKET_GASref" class="form-control" >
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <div id="nav_form" class="row" style="width: 100%;display: flex;">
                    <button type="button" class="btn btn-default pull-left" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px "  data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="cursor:pointer;padding: 3px; margin: 2px;float:left;width:50px"  class="btn btn-primary" onclick="submitGASRef()">Save</button>
                </div>
            </div>    
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal GAS -->
