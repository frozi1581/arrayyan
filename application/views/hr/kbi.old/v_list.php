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
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
 
 
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
                 <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
                  </div>
                 <?php } ?>
                <!--    <button type="button" id="btnBatal" class="btn btn-primary" onclick="addRow()" style="margin-top:10px;margin-bottom:10px;margin-left:10px;">Tambah Data</button>
                -->   
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>Skbdn/save_spb" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
               <div class="col-md-12">
                
                <div style="margin-top: 1px" id="jqxlistbox"></div>
            </div>    
        </div>    
        <script type="text/javascript">
	$(document).ready(function () {
            $( "#txtST_DATE" ).datepicker();
            $( "#txtEND_DATE" ).datepicker();
            $( "#txtTGL_BERLAKU" ).datepicker();
            var source =
            {   datatype: "json",
                datafields: [
                    <?php
                        $i=0;
                        foreach($grid["source"]["datafields"] as $key=>$value){
                                if($i==(count($grid["source"]["datafields"])-1) ){
                                        echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
                                }else{
                                        echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
                                }
                                $i++;
                        }
                    ?>
		],
                url: '<?php echo base_url().'hr/kbi/M_index/getGridData/'?>',
                root: 'Rows',
                id: '<?php echo $grid["source"]["ID"]; ?>',
                filter: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid").jqxGrid('updatebounddata', 'sort');
                },
                beforeprocessing: function(data)
                {		
                    if (data != null)
                    {
                        console.log(data);
                        source.totalrecords = data[0].TotalRows;	

                        if(data[0].ErrorMsg!=""){
                                alert(data[0].ErrorMsg);
                        }
                    }
                }
            };
            var dataadapter = new $.jqx.dataAdapter(source, {
                loadError: function(xhr, status, error)
                {
                   // alert(status);
                }
                }
            );
            var renderer = function (id) {
                  var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", id);
                    //console.log(dataRecord.FLAG_DATA);
                    strDivActions = '<div style="width:99%;text-align:left;">';
                    strEdit = '<button onClick="editRow(event)" id="btnEdit' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Edit"><i class="fa fa-edit fa-lg"></i></button>';
                    strDelete = '<button onClick="deleteRow(event)" id="btnDel' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Hapus"><i class="fa fa-trash fa-lg"></i></button>';
                    strInfo = '<button onClick="infoRow(event)" id="btnInfo' + id + '" style="margin-top:1px;margin-right:0px;height:10px;border:0px;background:transparent;" title="Info"><i class="fa fa-info-circle fa-lg"></i></button>';
                    strApproval = '<button onClick="approveRow(event)" id="btnApprove' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o fa-lg"></i></button>';
                    //--------------------- render search data -------------------
                    strRet = strDivActions + strInfo + '</div>';
                    return strRet;
                    //return '<input type="button" onClick="buttonclick(event)" class="gridButton" id="btn' + id + '" value=""/>'
            };
            var renderApp = function(APP){
                var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", APP);
                html='<span style="background-color: #4dffff;position: relative;top: 5px;left: 5px;">Not Approve</span>';
                if(dataRecord.APP==='1'){
                    html='<span style="background-color:#55ff00;position: relative;top: 5px;left: 5px;">Approved</span>';
                }
                return html;
            };
	    var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '99%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 15,
                autoheight:false,
                height:550,
                rowsheight: 28,
                sortable: true,
                virtualmode: true,
                altrows:true,
               // selectionmode: 'checkbox',
                showtoolbar: true,
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 2px;'></div>");
                    toolbar.append(container);
                    strNew = '<button id="addrowbutton" name="addrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Tambah Periode KBI"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-plus jqx-icon-plus-darkblue"></div></button>';
                    strEdit = '<button id="editrowbutton" name="editrowbutton" style="margin-right:0px;height:25px;border:0px;background:transparent;" title="Pilih Pegawai Yg Akan Dinilai"><img src="<?php echo base_url()."assets/images/person.png"; ?>" width="25px" height="25px" style="margin-top:-15px;"/></button>';
                    strDel = '<button id="deleterowbutton" name="deleterowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Delete"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-delete jqx-icon-delete-darkblue"></div></button>';
                    strApp = '<button id="approwbutton" name="approwbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o" style="font-size:24px;"></i></button>';
                    strUpload = '<button id="uplrowbutton" name="uplrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Upload Materi KBI"><i class="fa fa-upload" style="font-size:24px;"></i></button>';
               
        /*    strDelAll = '<button id="clearrowbutton" name="clearrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Delete All Item"><i class="fa fa-trash-o fa-lg" style="font-size:20px;color:white;"></i></button>';
		  */  //container.append(strNew);container.append(strDel); container.append(strApp);
                    container.append(strNew);container.append(strEdit);container.append(strUpload);   //container.append(strDelAll);
                    $("#addrowbutton").on('click', function () {
                        $('#show_Header').modal('show');
                        return false;
                    });
                    $("#uplrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        $('#show_upload').modal('show');
                        return false;
                    });
                    $("#editrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var Value_0= dataadapter['recordids'][selectedrowindex]['BL'];
                        var Value_1= dataadapter['recordids'][selectedrowindex]['ST_DATE'];
                        var Value_2= dataadapter['recordids'][selectedrowindex]['END_DATE'];
                        
                        var key = Value_0+'*'+Value_1+'*'+Value_2;
                        window.location.href='<?=base_url()?>hr/kbi/M_index/editData?recId='+key;
                        return false;
                    });
                  
                    
                },
                rendergridrows: function () {
                return dataadapter.records;
                },					
               columns: [
                        <?php 
                                $i=0;
                                foreach($grid["columns"] as $key=>$value){
                                        $strListColumns="{ align:'left',";
                                        foreach($value as $key2=>$value2){
                                                if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable'){
                                                        $strListColumns .= $key2.":".$value2.",";
                                                }else{
                                                        $strListColumns .= $key2.":'".$value2."',";
                                                }
                                        }
                                        $strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;

                                        if($i==(count($grid["columns"])-1) ){
                                                $strListColumns.="}";
                                        }else{
                                                $strListColumns.="},";
                                        }
                                        echo $strListColumns."\n";
                                        $i++;
                                }
                        ?>
					
                    ]
            });
	});
        function get_periode(obj){
            selectedId=obj.value;
            $.ajax({
                url: "<?php echo base_url().'hr/kbi/M_index/cekPeriode'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
                dataType: 'json',
                success: function (data) {
                    console.log(data['cek']);
                    if(data['cek']==='1'){
                        alert('Data Sudah ada');
                        document.getElementById("txtBL").value='';
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
         }
        function evtOpenLU(){
             $('#show_wt').modal('show');
        }
        function submitUpload(){
            if(document.getElementById("txtTGL_BERLAKU").value===''){
                alert('Tgl. Berlaku Harus Diisi');
            }
            if(document.getElementById("kbifile").value===''){
                alert('Silahkan pilih File yang akan diupload.');
            }else{document.getElementById("fupload").submit(); 
            }
        }
        function submitHeader(){
            document.getElementById("f_addHeader").submit(); 
        }
        function submitLUWT(){
            var selectedrowindex = $("#jqxGridWT").jqxGrid('getselectedrowindex');
            var Value_ = $('#jqxGridWT').jqxGrid('getcellvalue', selectedrowindex, 'WT');
            var Value2 = $('#jqxGridWT').jqxGrid('getcellvalue', selectedrowindex, 'KET');
            document.getElementById("txtket_wt").value=Value2; 
            document.getElementById("txtwt").value=Value_; 
            $('#show_wt').modal('hide');
            
        }

</script>

                <!------------  table ------------------------------->
                <!-- Start body content -->
<div class="body-content animated fadeIn">


</div><!-- /.body-content -->
<!--/ End body content -->
                <!------------ end table ---------------------------->
                
                </div>    
              
            </form>
          </div>
          <!-- /.box -->
       
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
      
    </section
    >
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- modal   Add SURVEY_H -->
  <div class="modal fade" id="show_Header" style="display: none;">
    <div class="modal-dialog " style="width:610px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">CREATE HEADER KBI</h4>
        </div>
          <form role="form" class="form-horizontal" id="f_addHeader" method="post" name="f_addHeader" action="<?php echo base_url().'hr/kbi/M_index/f_addHeader'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <div class="form-group">
                        <label for="txtBL" class="col-sm-3 control-label"   >Periode</label>
                        <div class="form-group">
                            <div class="col-sm-2"> 
                                <input class="form-control" id="txtPeriode" name="txtBL" placeholder="mmyyyy"   onchange="javascript:get_periode(this)" maxlength="6" required>
                            </div>
                        </div>
                        <label for="txtST_DATE" class="col-sm-3 control-label">Tgl. Mulai Penilaian</label>
                        <div class="col-sm-3">  
                            <input type="text" id="txtST_DATE" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($ST_DATE)?$ST_DATE:""; ?>" name="txtST_DATE" class="form-control" required >
                        </div>
                        <div class="col-sm-3">
                            <label for="txtEND_DATE" class="col-sm3 control-label">Tgl. Selesai Penilaian</label>
                        </DIV>    
                        <div class="col-sm-3">
                            <input type="text" id="txtEND_DATE" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($END_DATE)?$END_DATE:"";  ?>" name="txtEND_DATE" class="form-control" required>
                        </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitHeader()">Create</button>
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
<!-- modal   Upload -->
<div class="modal fade" id="show_upload" style="display: none;">
    <div class="modal-dialog " style="width:610px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload Materi KBI</h4>
        </div>
          <form role="form" class="form-horizontal" id="fupload" method="post" name="fupload" action="<?php echo base_url().'hr/kbi/M_index/f_upload'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                <!--    <label for="txtBL" class="col-sm-3 control-label"   >Periode</label>
                    <div class="form-group">
                        <div class="col-sm-2"> 
                            <input class="form-control" id="txtBL_" name="txtBL_" placeholder="mmyyyy"   onchange="javascript:get_periode(this)" maxlength="6" required>
                        </div>
                    </div>
                    <label for="txtST_DATE_" class="col-sm-3 control-label">Tgl. Mulai Penilaian</label>
                    <div class="col-sm-3">  
                        <input type="text" id="txtST_DATE_" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' name="txtST_DATE_" class="form-control" required >
                    </div>
                    <div class="col-sm-3">
                        <label for="txtEND_DATE_" class="col-sm3 control-label">Tgl. Selesai Penilaian</label>
                    </DIV>    
                    <div class="col-sm-3">
                        <input type="text" id="txtEND_DATE_" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy'  name="txtEND_DATE_" class="form-control" required>
                    </div> -->
                    <label for="txtTGL_BERLAKU" class="col-sm-3 control-label">Tgl. Berlaku</label>
                    <div class="form-group">
                        <div class="col-sm-3">  
                            <input type="text" id="txtTGL_BERLAKU" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($TGL_BERLAKU)?$TGL_BERLAKU:""; ?>" name="txtTGL_BERLAKU" class="form-control" required >
                        </div>
                    </div> 
                    
                    <label for="txtIsMan" class="col-sm-3 control-label">Level</label>
                    <div class="form-group">
                            <div class="col-sm-5">
                                <select class="form-control" name="txtIsMan" id="txtIsMan" >
                                <?php $isMan=""; foreach ($DDListIsMan as $d1) { ?>
                                    <option  value="<?php echo $d1['id']; ?>" <?php
                                      if($isMan===$d1['id']){
                                          echo "selected";
                                      }
                                      ?> ><?php echo $d1['status'] ?></option>
                                <?php } ?>
                                </select>
                            </div>    
                    </div>
                    <label for="kbifile" class="col-sm-3 control-label">Attachment</label>
                    <div class="form-group">
                        <input type="file" name="kbifile" id="kbifile">
                        <p class="help-block"></p>
                    </div>
  
           </div> 
               
            <!-------------------- end form upload ---------------------------------------------------------------------->
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Upload</button>
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
 
  
  