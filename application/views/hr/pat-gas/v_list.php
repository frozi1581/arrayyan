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
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;margin-left: 1%;margin-right: 1%;" > 
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>Skbdn/save_spb" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
                <div class="col-md-12">
                    <div id="popupWindow"></div>
                    <div style="margin-top: 1px" id="jqxlistbox"></div>
                </div>    
        </div>    
        <script type="text/javascript">
         var mDATAGRIDS=[];     
	$(document).ready(function () {
            $('#txtTGL_AWL').attr('readonly', true);$('#txtTGL_AWL').addClass('input-disabled');
            $('#txtTGL_AHR').attr('readonly', true);$('#txtTGL_AHR').addClass('input-disabled');
            
           // document.getElementById("txtKdPAT").value="<?php echo $this->session->userdata('s_uPAT');?>";
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
                url: '<?php echo base_url().'hr/pat-gas/M_index/list_map/'?>',
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
                var dataRecord = dataadapter['_source']['records'][ROW];
                var params = "'"+dataRecord.ID+"'";
                var viewButton = '<button id="viewrowbutton" type="button" role="button" aria-disabled="false" value="" title="View Data" onclick="VIEW_DETAIL('+ROW+')"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 2px;float:left;height:30px;width:60px;"><i class="fas fa-info-circle fa-lg fa-fw">&nbsp;</i>Detil</button>';
                var editButton = '<button id="addrowbutton" type="button" value="" title="Edit Data"  onclick="EDIT_DETAIL('+ROW+')"   class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 2px;float:left;height:30px;width:60px;"><i class="fas fa-pencil fa-lg fa-fw">&nbsp;</i>Edit</button>';
                var delButton = '<button id="delrowbutton" type="button" value="" title="Hapus Data"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 2px;float:left;height:30px;width:80px;"  onclick="HAPUS_DETAIL('+ROW+')"><i class="fas fa-trash fa-lg fa-fw">&nbsp;</i>Hapus</button>';
                var container = '<div style="text-align:center;margin-bottom:2%;margin-top:2%;margin-left:2%;margin-right:2%;display: flex;width:100%;">'+viewButton+editButton+delButton+'</div>';
                html = container;
                return html;
            };
            
	    var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '98%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 15,
                autoheight:true,
                autorowheight: true,
                sortable: true,
                virtualmode: true,
                showtoolbar: true,
                altrows:true,
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 1px;'></div>");
                    var btnAdd = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 2px; margin: 3px;float:left;"><i class="fas fa-plus fa-lg fa-fw">&nbsp;</i>Tambah Data Mapping</button>';
                    var addButton = $(btnAdd);
                    addButton.jqxButton({theme:'ui-start', width:'180px', height:'25px'});
                    container.append(addButton);
                    toolbar.append(container);
                    $("#addrowbutton").on('click', function () {
                         window.location.href='<?=base_url()?>hr/pat-gas/M_index/newData';
                    }); 
                    $("#viewrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        var key= dataadapter['recordids'][selectedrowindex]['ID'];
                        console.log(key);
                      //  window.location.href='<?=base_url()?>fin/bukti_kas/M_index/editData/'+key;
                        return false;
                    });
                    $("#deleterowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        var selectedId=[];
                        selectedId.push(dataadapter['recordids'][selectedrowindex]['NO_DOK']);            
                        $.ajax({
                            url: "<?php echo base_url().'fin/bukti_kas/M_index/DeleteCOA'?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                           // dataType: 'json',
                            dataType: 'json',
                            success: function (data) {
                               console.log(data);
                                 //$("#jqxgrid").jqxGrid('updatebounddata');
                                 // window.location.href='<?=base_url()?>os/bukti_kas/M_index/';
                              },
                            error: function (data) {
                                console.log('error');
                            }
                        });
                        return false;

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
            $("#jqxgrid").jqxGrid('updatebounddata');
	});
        function EDIT_DETAIL(params){
           params=aDATAGRID[params]['ID'];
           params=params.replace(/\//g, '_');
           window.location.href='<?=base_url()?>hr/pat-gas/M_index/editData/'+params;
            return false;
        }   
        function VIEW_DETAIL(params){
           params=aDATAGRID[params]['ID'];
           params=params.replace(/\//g, '_');
           window.location.href='<?=base_url()?>hr/pat-gas/M_index/viewData/'+params;
           return false;
        }   
        
        function HAPUS_DETAIL(params){
            var selectedId=[];
            selectedId.push(aDATAGRID[params]['ID']);console.log(selectedId);
            var pesan = "Yakin Hapus Mapping Company:"+aDATAGRID[params]['ID_CORP'];
            if(aDATAGRID[params]['KET_PAT']!==null) pesan+=" PAT:"+aDATAGRID[params]['KET_PAT'];
            if(aDATAGRID[params]['KET_GAS']!==null) pesan+=" GAS:"+aDATAGRID[params]['KET_GAS'];
            var konfirmasi = confirm(pesan);
            if(konfirmasi){
                $.ajax({
                    url: "<?php echo base_url().'hr/pat-gas/M_index/DeleteMAP'?>",
                    type: 'POST',
                    data: {json: JSON.stringify(selectedId)},
                    dataType: 'json',
                    success: function (data) {
                        window.location.href='<?=base_url()?>hr/pat-gas/M_index/';
                      },
                    error: function (data) {
                        console.log('error');
                    }
                });
            }
            
            
            return false;
        }   
        function submitHeader(){
            document.getElementById("f_addHeader").submit(); 
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

