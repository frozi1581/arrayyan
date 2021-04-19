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
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtooltip.js"></script>
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
                <script type="text/javascript">
                    //--------------------------- info pasar List ---------------
                        var addRow = function(event){
                                window.location.href='<?=base_url()?>hr/absensi-pusat/M_absensi/addNewData';
                        };
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
                url: '<?php echo base_url().'hr/absensi-pusat/M_absensi/getGridData/'?>',
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
				sortable: false,
                virtualmode: true,
				altrows:true,
				showfilterrow:true,
				selectionmode: 'singlerow',
				rendergridrows: function () {
                    return dataadapter.records;
                },					
                showtoolbar: true,
                rendertoolbar: function (toolBar) {
                    var toTheme = function (className) {
                        if (theme == "") return className;
                        return className + " " + className + "-" + theme;
                    }
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var buttonTemplate = "<div style='float: left; padding: 3px; margin: 2px;'><img src='<?php echo base_url()."jqwidget/jqwidgets/styles/images/icon-time-white.png";?>'  width='25px' height='25px' /></div>";
                    var addButton = $(buttonTemplate);
                    
                    container.append(addButton);
                    toolBar.append(container);
                    addButton.jqxButton({cursor: "pointer", enableDefault: false,  height: 25, width: 25 });
                    //addButton.find('div:first').addClass(toTheme('jqx-icon-plus'));
                    addButton.jqxTooltip({ position: 'bottom', content: "Sync Data Dari Mesin Facepad"});
                    
                    addButton.click(function (event) {
                        if (!addButton.jqxButton('disabled')) {
                            addRow();
                        }
                    });
                    
                },
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
       <!-- Start body content -->
<div class="body-content animated fadeIn">
</div><!-- /.body-content -->
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

    