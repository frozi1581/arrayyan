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
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/custom/inner_html.js"></script>  
 
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
    .input-disabled{
            background-color:#ffffff !important;
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
                    <div id="popupWindow"></div>
                    <div style="margin-top: 1px" id="jqxlistbox"></div>
                </div>    
        </div>    
        <script type="text/javascript">
	$(document).ready(function () {
            $('#txtTGL_AWL').attr('readonly', true);$('#txtTGL_AWL').addClass('input-disabled');
            $('#txtTGL_AHR').attr('readonly', true);$('#txtTGL_AHR').addClass('input-disabled');
            aDATAGRID=[];
            document.getElementById("txtKdPAT").value="<?php echo $this->session->userdata('s_uPAT');?>";
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
                url: '<?php echo base_url().'hr/surat/M_index/list_surat/'?>',
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
                {	console.log(data);	
                    if (data != null)
                    {
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
                    strInfo = '<button onClick="infoRow(event)" id="btnInfo' + id + '" style="margin-top:1px;margin-right:0px;height:10px;border:0px;background:transparent;" title="Info"><i class="fa fa-edit fa-lg"></i></button>';
                    strApproval = '<button onClick="approveRow(event)" id="btnApprove' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o fa-lg"></i></button>';
            //--------------------- render search data -------------------
                    strRet = strDivActions + strInfo + '</div>';
                    return strRet;
                    //return '<input type="button" onClick="buttonclick(event)" class="gridButton" id="btn' + id + '" value=""/>'
            };
            var renderACT = function(ROW){
                aDATAGRID=dataadapter['_source']['records'];
                var dataRecord = dataadapter['_source']['records'][ROW];//$("#jqxgrid").jqxGrid("getrowdata", row_);
                var editButton = '<button id="addrowbutton" type="button" value="" title="View/Edit Data"  onclick="EDIT_DETAIL('+ROW+')"   class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;" disabled><i class="fas fa-pencil fa-lg fa-fw" >&nbsp;</i><br>Edit</button>';
                var delButton = '<button id="delrowbutton" type="button" value="" title="Hapus/Non Aktif Nomor Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="HAPUS_DETAIL('+ROW+')" disabled><i class="fas fa-trash fa-lg fa-fw">&nbsp;</i><br>Delete</button>';
                var uploadButton = '<button id="uploadrowbutton" type="button" value="" title="Upload Lampiran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="uploadLampiran('+ROW+')" disabled><i class="fas fa-upload fa-lg fa-fw">&nbsp;</i><br>Upload</button>';
                var downloadButton = '<button id="downloadrowbutton" type="button" value="" title="Belum ada lampiran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="viewLampiran('+ROW+')" disabled><i class="fas fa-paperclip fa-lg fa-fw">&nbsp;</i><br>View</button>';
                if(dataRecord.lampiran !== null  ){
                    if((dataRecord.lampiran).length>5  )         var downloadButton = '<button id="downloadrowbutton" type="button" value="" title="View Lampiran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="viewLampiran('+ROW+')" ><i class="fas fa-paperclip fa-lg fa-fw">&nbsp;</i><br>View</button>';
                }
                //console.log(dataRecord.kd_gas_pengirim);
                var gas_user="<?php echo  $this->session->userdata('s_uGAS'); ?>";
                console.log(gas_user);
                if(gas_user===dataRecord.kd_gas_pengirim){
                    var editButton = '<button id="addrowbutton" type="button" value="" title="View/Edit Data"  onclick="EDIT_DETAIL('+ROW+')"   class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;" ><i class="fas fa-pencil fa-lg fa-fw" >&nbsp;</i><br>Edit</button>';
                    var delButton = '<button id="delrowbutton" type="button" value="" title="Hapus/Non Aktif Nomor Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="HAPUS_DETAIL('+ROW+')" ><i class="fas fa-trash fa-lg fa-fw">&nbsp;</i><br>Delete</button>';
                    var uploadButton = '<button id="uploadrowbutton" type="button" value="" title="Upload Lampiran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:60px;"  onclick="uploadLampiran('+ROW+')" ><i class="fas fa-upload fa-lg fa-fw">&nbsp;</i><br>Upload</button>';
                }
                var container = '<div style="text-align:center;margin-bottom:2%;margin-top:2%;margin-left:2%;margin-right:2%;display: flex;width:100%;">'+editButton+delButton+downloadButton+uploadButton+'</div>';
                html = container;
                return html;
            };
        
            var renderLampiran = function(APP){
                var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", APP);
                var lengt_lampiran=0;
                if(dataRecord.lampiran===null){lengt_lampiran=0;}else{lengt_lampiran=(dataRecord.lampiran).length;}
                if(lengt_lampiran>0){
                    var row_ = APP%15;
                    html='<i class="fa -top:10%; " onClick="viewLampiran('+row_+')" title="View Lampiran"></i>';
          //         html = '<a href="'+dataRecord.lampiran+'" target="_blank" data-togglfa-file fa-2x" style="margin-left:30%;margine="tooltip" title="Lihat Lampiran" ><i class="fa fa-file fa-lg" style="padding:15px" ></i></a>';
                }else{
                    html = '';
                }
                return html;
            };
            var renderUpload = function(APP){
                var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", APP);
                var row_ = APP%15;
                html='<i class="fa fa-upload fa-2x" style="margin-left:30%;margin-top:10%;" onClick="uploadLampiran('+row_+')" title="Upload Lampiran"></i>';
                return html;
            };
	    var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '100%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 15,
                height:550,
             //   autoheight:true,
                autorowheight: true,
                sortable: true,
                virtualmode: true,
                showtoolbar: true,
                //height:550,
               // autoheight: true,
              //  rowsheight: 28,
                //  altrows:true,
               // selectionmode: 'checkbox',
                
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 2px;'></div>");
                    //----------------------------------------------------------------------------------------------------------------
                    var btnAdd = '<button id="addrowbutton" type="button" value="" title="Tambah Permintaan No. Surat"  style="cursor:pointer;padding: 5px; margin: 3px;float:left;"><i class="fas fa-plus fa-lg fa-fw">&nbsp;</i>Add</button>';
                    var btnDownload = '<button id="downloadrowbutton" type="button" value="" title="Download Daftar No. Surat"  style="cursor:pointer;padding: 5px; margin: 3px;float:left;"><i class="fas fa-download fa-lg fa-fw">&nbsp;</i>Download</button>';
                    var addButton = $(btnAdd);addButton.jqxButton({theme:'ui-start', width:'130px', height:'25px'});
                    var downloadButton = $(btnDownload);downloadButton.jqxButton({theme:'ui-start', width:'130px', height:'25px'});
                    container.append(addButton);container.append(downloadButton);
                    toolbar.append(container);
                    $("#viewrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        selectedId = dataadapter['recordids'][selectedrowindex]['no_surat'];
                        var selectedId = selectedId.replace(/\//g, "_");
                        window.location.href='<?=base_url()?>hr/surat/M_index/View_Data/'+selectedId;
                    });
                    $("#addrowbutton").on('click', function () {
                         window.location.href='<?=base_url()?>hr/surat/M_index/newData';
                    });      
                    $("#deleterowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        selectedId = dataadapter['recordids'][selectedrowindex]['no_surat'];
                        document.getElementById('txtDibuatDel').value=dataadapter['recordids'][selectedrowindex]['dibuat_oleh'];
                        document.getElementById('txtNo_suratDel').value=selectedId;
                        $('#show_Delete').modal('show');
                       // var selectedId = selectedId.replace(/\//g, "_");
                    });
                    $("#downloadrowbutton").on('click', function () {
                        $('#show_Download').modal('show');
                    });
                    $("#btnKodeDokumen").on('click', function () {
                        var selectedId="";
                        $.ajax({
                            url: "<?php echo base_url().'hr/LU_help/LU_KD_SURAT'?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                           // dataType: 'json',
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                var htmlContent = '';
                                htmlContent += data['gridLUDOKUMENSURAT'];
                                // run the scripts inside the dom node
                                var $container = document.querySelector('.containerDokumenSurat');
                                $container.innerHTML = htmlContent;
                                runScripts($container);
                                $('#show_kdDokumen').modal('show');
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });
                        return false;
                    });
                    $("#btnSekunder").on('click', function () {
                        //var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       // $('#show_kdInduk').modal('show');
                        var selectedId=document.getElementById('txtPrimer').value;
                        $.ajax({
                            url: "<?php echo base_url().'hr/surat/M_index/LU_KD_SEKUNDER'?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                           // dataType: 'json',
                            dataType: 'json',
                            success: function (data) {
                                console.log(data); 
                                var htmlContent = '';
                                htmlContent += data['gridLUSEKUNDER'];

                                // run the scripts inside the dom node
                                var $container = document.querySelector('.containerSekunder')
                                $container.innerHTML = htmlContent
                                runScripts($container)
                                $('#show_kdSekunder').modal('show');
                            },
                            error: function (data) {
                               // console.log(data);
                                
                                console.log('error');
                            }
                        });
                        return false;
                    });
                    $("#uplrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        $('#show_upload').modal('show');
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
                                                if(  $key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable' || $key2=='pinned'){
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
    function EDIT_DETAIL(params){
        params=aDATAGRID[params]['no_surat'];
        params=params.replace(/\//g, '_');
        window.location.href='<?=base_url()?>hr/surat/M_index/View_Data/'+params;
         return false;
     }  
     function HAPUS_DETAIL(params){
        selectedId = aDATAGRID[params]['no_surat'];
        document.getElementById('txtDibuatDel').value=aDATAGRID[params]['dibuat_oleh'];
        document.getElementById('txtNo_suratDel').value=selectedId;
        $('#show_Delete').modal('show');
        return false;
    }   
    function SHOW_LAMPIRAN(params){
        selectedId = aDATAGRID[params]['no_surat'];
        document.getElementById('txtDibuatDel').value=aDATAGRID[params]['dibuat_oleh'];
        document.getElementById('txtNo_suratDel').value=selectedId;
        $('#show_Delete').modal('show');
        return false;
    }
        function hapus_surat(){
             //show_Delete,hapus_surat,txtNo_suratDel,txtDibuatDel
            var selectedId=[]; 
            selectedId[0]=document.getElementById('txtNo_suratDel').value ;
            selectedId[1]=document.getElementById('txtKet_Del').value ;
            if( document.getElementById('txtKet_Del').value===''){
                alert('Alasan non aktif Surat harus diisi');
            }else{
                $('#show_Delete').modal('hide');
                $.ajax({
                    url: "<?php echo base_url().'hr/surat/M_index/HapusSurat'?>",
                    type: 'POST',
                    data: {json: JSON.stringify(selectedId)},
                    dataType: 'json',
                    success: function (data) {
                       // console.log(data);
                         $("#jqxgrid").jqxGrid('updatebounddata');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }    
        }
        function viewLampiran(row_){
            var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", row_);
            window.open(dataRecord.lampiran, "_blank", "toolbar=no,scrollbars=yes,location=no,titlebar=no,menubar=no,directories=no,location=no, resizable=yes,top=100,left=200,width=800,height=800");
        }
        function uploadLampiran(row_){
            var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", row_);
            console.log(dataRecord.no_surat);
            $('#show_Upload').modal('show');
            document.getElementById("txtUploadNoSurat").value=dataRecord.no_surat;
        }
        function submitUpload(){
            if(document.getElementById("txtUpload_file").value===''){
                alert('Silahkan pilih File yang akan diupload.');
            }else{ document.getElementById("fUpload").submit(); 
            }
        }
        function submitDownload(){
            $('#show_Download').modal('hide'); 
            document.getElementById("fDownload").submit();
        }
        function evtOpenLU(){
             $('#show_wt').modal('show');
        }
        function submitHeader(){
            document.getElementById("f_addHeader").submit(); 
        }
        function submitLUDOKUMEN(){
            var selectedrowindex = $("#jqxGridDOKUMENSURAT").jqxGrid('getselectedrowindex');
            document.getElementById('txtKode_Dokumen').value = $('#jqxGridDOKUMENSURAT').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
            $('#show_kdDokumen').modal('hide')
        }
        function submitLUNINDUK(){
            var selectedrowindex = $("#jqxGridINDUK").jqxGrid('getselectedrowindex');
            document.getElementById('txtInduk').value = $('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen');
            document.getElementById('txtKet_masalah_induk').value = $('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'ket_masalah_induk');
            document.getElementById('txtNo_surat').value=$('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen');
            document.getElementById('txtPrimer').value ="";document.getElementById('txtSekunder').value = "";
            document.getElementById('txtKet_masalah_primer').value ="";document.getElementById('txtKet_masalah_sekunder').value ="";
            $('#show_kdInduk').modal('hide');$('#show_Header').modal('show');
        }
        function submitLUPRIMER(){
            var selectedrowindex = $("#jqxGridPRIMER").jqxGrid('getselectedrowindex');
            document.getElementById('txtPrimer').value = $('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen');
            document.getElementById('txtKet_masalah_primer').value = $('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'ket_masalah_primer');
            document.getElementById('txtNo_surat').value=$('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen');
            document.getElementById('txtSekunder').value = "";document.getElementById('txtKet_masalah_sekunder').value ="";
            $('#show_kdPrimer').modal('hide');$('#show_Header').modal('show');
        }
        function submitLUSEKUNDER(){
            var selectedrowindex = $("#jqxGridSEKUNDER").jqxGrid('getselectedrowindex');
            document.getElementById('txtSekunder').value = $('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen');
            document.getElementById('txtKet_masalah_sekunder').value = $('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'ket_masalah_sekunder');
            document.getElementById('txtNo_surat').value=$('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'kd_dokumen')+"/WB-"+"<?php echo $this->session->userdata('s_uPAT'); ?>"+".###/"+"<?php echo substr(date("Y"),2,2); ?>";
            $('#show_kdSekunder').modal('hide');$('#show_Header').modal('show');
        }
        $(function() {
            $( "#txtTgl_surat").datepicker({
              changeMonth: false,
              changeYear: false
            });
            $( "#txtTGL_AWL").datepicker({
              changeMonth: false,
              changeYear: false
            });
            $( "#txtTGL_AHR").datepicker({
              changeMonth: false,
              changeYear: false
            });
            
            
        });
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
    <div class="modal-dialog " style="width:1200px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
                <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 2px;margin-top: 15px" data-dismiss="modal"><i class="fa fa-home fa-lg"></i></button>
                <h3 class="box-title"><div id="f_judul"></div></h3>
            
        </div>
        <form role="form" class="form-horizontal" id="f_addHeader" method="post" name="f_addHeader" action="<?php echo base_url().'hr/surat/M_index/f_submit'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <div class="form-group">
                <div class="form-group" style="background-color: #449bca;color: #ffffff">
                    <div class="form-group" > <input type="hidden" id="txtStatus" name="txtStatus" >
                        <input type="hidden" id="txtKdPAT" name="txtKdPAT" > <input type="hidden" id="txtLampiran" name="txtLampiran" >
                    </div> 
                        <div class="form-group" >
                            <label for="txtKet_masalah_induk" class="col-sm-2 control-label">Kode Masalah Induk</label>
                            <div class="col-sm-2">  
                                <input type="text" id="txtInduk" style="width:100%;" name="txtInduk" class="form-control" required readonly>
                            </div>    
                            <div class="col-sm-5">  
                                <input type="text" id="txtKet_masalah_induk" style="width:95%;" name="txtKet_masalah_induk" class="form-control" required readonly>
                            </div>
                            <div class="col-sm-1"><button type="button" id="btnInduk" name="btnInduk"  class="btn btn-default pull-left" style="margin-left: 15px;margin-right: 5px;margin-bottom: 5px;display:none;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                            </div>
                        </div>                  
                        <div class="form-group" >
                            <label for="txtKet_masalah_primer" class="col-sm-2 control-label">Kode Masalah Primer</label>
                            <div class="col-sm-2">  
                                <input type="text" id="txtPrimer" style="width:100%;" name="txtPrimer" class="form-control" required readonly>
                            </div>    
                            <div class="col-sm-4">
                                <textarea id="txtKet_masalah_primer" name="txtKet_masalah_primer"  style="width:450px;height:50px;color:#336600" readonly required></textarea>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" id="btnPrimer" name="btnPrimer" class="btn btn-default pull-left" style="margin-left: 110px;margin-right: 5px;margin-bottom: 5px;display:none;" data-dismiss="modal"><i class="fa fa-search"></i></button>
                           </div>
                        </div>
                        <div class="form-group" > 
                            <label for="txtKet_masalah_sekunder" class="col-sm-2 control-label">Kode Masalah Sekunder</label>
                            <div class="col-sm-2">  
                                <input type="text" id="txtSekunder" style="width:100%;" name="txtSekunder" class="form-control" required readonly>
                            </div>
                            <div class="col-sm-4">
                                <textarea id="txtKet_masalah_sekunder" name="txtKet_masalah_sekunder"  style="width:450px;height:50px;color:#336600" readonly required></textarea>
                            </div>
                            <div class="col-sm-1"><button id="btnSekunder" type="button" class="btn btn-default pull-left" style="margin-left: 110px;margin-right: 5px;margin-bottom: 5px;display:none;" data-dismiss="modal"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                </div>
                <div class="form-group" style="background-color: #449bca;color: #ffffff">
                        <div class="form-group" ></div> 
                        <div class="form-group" >
                                   <label for="txtDibuat" class="col-sm-1 control-label">Pengirim</label>
                                    <div class="col-sm-4">  
                                        <input type="text" id="txtDibuat" style="width:100%;" name="txtDibuat" class="form-control" required readonly>
                                    </div>
                          
                                   <label for="txtBL" class="col-sm-1 control-label"   >No. Surat</label>
                                    <div class="form-group">
                                        <div class="col-sm-2">  
                                            <input class="form-control" id="txtNo_surat" name="txtNo_surat" placeholder="No. Dokumen"  maxlength="35" required readonly>
                                        </div>
                                    </div>
                        </div> 
                        <div class="form-group" >
                            <label for="txtJabatan" class="col-sm-1 control-label">Jabatan</label>
                            <div class="col-sm-4">  
                                <input type="text" id="txtJabatan" style="width:100%;" name="txtJabatan" class="form-control" required readonly>
                            </div>
                            <label for="txtTgl_surat" class="col-sm-1 control-label">Tgl. Surat</label>
                            <div class="col-sm-2">  
                                <input type="text" id="txtTgl_surat" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' name="txtTgl_surat" class="form-control" required readonly>
                            </div>
                            <label for="txtTgl_input" class="col-sm-1 control-label">Tgl. Input Surat</label>
                            <div class="col-sm-2">  
                                <input type="text" id="txtTgl_input" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' name="txtTgl_input" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="txtBiro" class="col-sm-1 control-label">Biro/Bagian</label>
                            <div class="col-sm-4">  
                                <input type="text" id="txtBiro" style="width:100%;" name="txtBiro" class="form-control" required readonly>
                            </div>
                            <label for="txtTujuan_surat" class="col-sm-1 control-label">Ditujukan</label>
                            <div class="col-sm-5">  
                                <input type="text" id="txtTujuan_surat" style="width:100%;"  name="txtTujuan_surat" class="form-control" required >
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="txtBiro" class="col-sm-1 control-label">Unit Kerja</label>
                            <div class="col-sm-4">  
                                <input type="text" id="txtUnit" style="width:100%;" name="txtUnit" class="form-control" required readonly>
                            </div>
                            <label for="txtPerihal" class="col-sm-1 control-label">Perihal</label>
                            <div class="col-sm-5">  
                                <input type="text" id="txtPerihal" style="width:100%;" name="txtPerihal" class="form-control" required >
                            </div>
                        </div>   
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
<!-- modal   upload image-->
<div class="modal fade" id="show_Upload" style="display: none;">
    <div class="modal-dialog " style="width:500px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload Lampiran</h4>
        </div>
          <form role="form" class="form-horizontal" id="fUpload"  method="POST" name="fUpload" action="<?php echo base_url().'hr/surat/M_index/f_upload'?>" enctype="multipart/form-data" >
        <div class="modal-body">    
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                <div class="row">
                    <label for="txtKode_Dokumen" style="font-weight:bold;text-align: left" class="col-sm-2 control-label">Kode Dokumen</label>
                    <div class="col-sm-3">  
                        <input type="text" id="txtUploadNoSurat" style="width:100%;margin-left: 30px; width: 200px" name="txtUploadNoSurat"  class="form-control"  >
                    </div>    
                </div>  
                <div class="row">
                    <div class="col-sm-6">
                        <label for="foto" style="text-align: left;width: 50px;" >File : 
                             <input id="txtUpload_file" type="file" class="form-control"  name="txtUpload_file" style=" width: 300px">
                        </label>
                    </div>
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

<!-- modal   download -->
<div class="modal fade" id="show_Download" style="display: none;">
    <div class="modal-dialog " style="width:500px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Download Daftar Surat</h4>
        </div>
          <form role="form" class="form-horizontal" id="fDownload"  method="POST" name="fDownload" action="<?php echo base_url().'hr/surat/M_index/f_download'?>" enctype="multipart/form-data" >
        <div class="modal-body">    
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                <div class="row">
                        <label for="txtKode_Dokumen" style="font-weight:bold;text-align: left" class="col-sm-2 control-label">Kode Surat</label>
                        <div class="col-sm-2">  
                            <input type="text" id="txtKode_Dokumen" style="width:100%;margin-left: 30px; width: 150%" name="txtKode_Dokumen"  class="form-control"  >
                        </div>    
                        <div class="col-sm-1"><button type="button" id="btnKodeDokumen" name="btnKodeDokumen"  class="btn btn-default pull-left" style="margin-left: 60px;margin-bottom: 5px;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                        </div>
                </div>  
                <div class="row">
                    <label for="txtTGL_AWL" style="font-weight:bold;text-align: left" class="col-sm-2 control-label">Tgl. Surat </label>
                    <div class="form-group">
                        <div class="col-sm-2">  
                            <input type="text" id="txtTGL_AWL" placeholder="dd-mm-yyyy" style="width:110%;margin-left: 30px;width:100px;" data-date-format='dd-mm-yyyy'  name="txtTGL_AWL" class="form-control" required >
                        </div>
                        <label for="txtTGL_AHR" class="col-sm-1 control-label"  style="margin-left: 60px;" >s/d</label>  
                        <div class="col-sm-2">  
                            <input type="text" id="txtTGL_AHR" placeholder="dd-mm-yyyy" style="width:180%;" data-date-format='dd-mm-yyyy'  name="txtTGL_AHR" class="form-control" required >
                        </div>
                    </div> 
                </div>                    
            </div> 
               
            <!-------------------- end form upload ---------------------------------------------------------------------->
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitDownload()">Download</button>
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
<!-- modal   Lookup Kode Dokumen Induk -->
  <div class="modal fade" id="show_kdDokumen" style="display: none;">
    <div class="modal-dialog " style="width:680px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Daftar Kode Dokumen<?php //echo isset($gridLUINDUK)?$gridLUINDUK:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="form-group">
                    <div class="containerDokumenSurat">
                    </div>
                </div>
                <?php //echo isset($gridLUINDUK)?$gridLUINDUK:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUDOKUMEN()">OK</button>
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
 
 <!-- modal   Lookup Kode Dokumen Sekunder -->
  <div class="modal fade" id="show_Delete" style="display: none;">
    <div class="modal-dialog " style="width:680px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Pembatalan No surat<?php //echo isset($gridLUINDUK)?$gridLUINDUK:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="containerSekunder">
                    <div class="form-group" >
                        <label for="txtDibuatDel" class="col-sm-1 control-label">Pengirim</label>
                         <div class="form-group">
                            <div class="col-sm-10">  
                                <input type="text" id="txtDibuatDel" style="width:100%;" name="txtDibuatDel" class="form-control" required readonly>
                            </div>
                         </div>     
                        <label for="txtNo_suratDel" class="col-sm-1 control-label"   >No. Surat</label>
                        <div class="form-group">
                             <div class="col-sm-4">  
                                 <input class="form-control" id="txtNo_suratDel" name="txtNo_suratDel" placeholder="No. Dokumen"  maxlength="35" required readonly>
                             </div>
                        </div>
                        <label for="txtKet_Del" class="col-sm-1 control-label"   >*Alasan</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                    <textarea id="txtKet_Del" name="txtKet_Del"  style="width:450px;height:100px;color:#336600"  required></textarea>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="form-group">  
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="hapus_surat()">Hapus</button>  
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
