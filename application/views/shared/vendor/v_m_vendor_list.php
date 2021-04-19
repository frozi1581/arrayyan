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
            height: 50px !important;vertical-align:middle;
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
      
       
/*     
 #abc span {
  vertical-align:middle;
  display: table-cell;
}
.test {
background-color:ffccff;height:50px;width:50px;
align:center;valign:middle
}*/

</style> 

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display:none;">
      <h1>
        
        <small><?php echo $title; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Daftar Vendor</a></li>
        <li class="active"></li>
      </ol>
    </section>

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
                    <button type="button" id="btnAdd" class="btn btn-primary" onclick="addRow()" style="margin-top:10px;margin-bottom:10px;margin-left:10px;">Tambah Data</button>
                     <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
					<div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
					<script type="text/javascript">
						var addRow = function(event){
							window.location.href='<?=base_url()?>shared/M_vendor/addNewData';
						}
						
						var editRow = function(event){
							var id = event.target.id;
							var recId = id.replace('btnEdit','');
							var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", recId);
							window.location.href='<?=base_url()?>shared/M_vendor/editData?recId='+dataRecord.ID;
						}
						
						var infoRow = function(event){
							var id = event.target.id;
							var recId = id.replace('btnInfo','');
							var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", recId);
							window.location.href='<?=base_url()?>shared/M_vendor/infoData?recId='+dataRecord.ID;
							
						}
						
						var deleteRow = function(event){
							var id = event.target.id;
							var recId = id.replace('btnDel','');
							var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", recId);
							window.location.href='<?=base_url()?>shared/M_vendor/deleteData?recId='+dataRecord.ID;
						}
						
						var approveRow = function(event){
							var id = event.target.id;
							var recId = id.replace('btnApprove','');
							var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", recId);
							window.location.href='<?=base_url()?>shared/M_vendor/approveData?recId='+dataRecord.ID;
						}
					</script>
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>Skbdn/save_spb" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
               <div class="col-md-12">
                
                <div style="margin-top: 1px" id="jqxlistbox"></div>
            </div>    
        </div>    
<script type="text/javascript">
	$(document).ready(function () {
			var source =
            {
                 datatype: "json",
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
			    url: '<?php echo base_url().'shared/M_vendor/getVendor/'?>',
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
						alert(error);
						
					}
				}
			);
			
			
			
			var renderer = function (id) {
				
				var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", id);
				//console.log(dataRecord.FLAG_DATA);
				
				strDivActions = '<div style="width:99%;text-align:left;">';
				
				strEdit = '<button onClick="editRow(event)" id="btnEdit' + id + '" style="margin-right:1px;height:20px;border:0px;background:transparent;" title="Edit"><i class="fa fa-edit fa-lg"></i></button>';
				
				strDelete = '<button onClick="deleteRow(event)" id="btnDel' + id + '" style="margin-right:1px;height:20px;border:0px;background:transparent;" title="Hapus"><i class="fa fa-trash fa-lg"></i></button>';
				
				strInfo = '<button onClick="infoRow(event)" id="btnInfo' + id + '" style="margin-right:1px;height:20px;border:0px;background:transparent;" title="Info"><i class="fa fa-info-circle fa-lg"></i></button>';
				
				strApproval = '<button onClick="approveRow(event)" id="btnApprove' + id + '" style="margin-right:1px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o fa-lg"></i></button>';
				
				
				if(dataRecord.FLAG_DATA=='0'){
					strRet = strDivActions + strInfo + strEdit  + strDelete + strApproval + '</div>';
				}else{
					strRet = strDivActions + strInfo + '</div>';
				}
				return strRet;
				//return '<input type="button" onClick="buttonclick(event)" class="gridButton" id="btn' + id + '" value=""/>'
			}
			
			
			
			var theme = 'darkblue';
			// initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '99%',
				source: dataadapter,
                theme: theme,
				filterable:true,
				showfilterrow: false,
				pageable: true,
				pagesize: 10,
				rowsheight: 30,
				sortable: true,
                virtualmode: true,
				altrows:true,
				rendergridrows: function () {
                    return dataadapter.records;
                },					
			    columns: [
					<?php 
						$i=0;
						foreach($grid["columns"] as $key=>$value){
							$strListColumns="{ align:'center',";
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

    