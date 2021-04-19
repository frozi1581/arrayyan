
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
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdatatable.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtreegrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/scripts/demos.js"></script>
    
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
 <style type="text/css">
	.modal {
	  max-height: calc(100% - 100px);
	  position: fixed;
		top: 50%;
		left: 50%;
	  transform: translate(-50%, -50%);
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
        
		
<script type="text/javascript">
	$(document).ready(function () {
			
			var source1 =
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
                hierarchy:
                {
                    keyDataField: { name: 'KD_GAS' },
                    parentDataField: { name: 'PARENT_KD_GAS' }
                },
			    url: '<?php echo base_url().'hr/biro-bagian/M_Biro_Bagian/getGridData/?ikdpat='.$ikdpat; ?>',
				root: 'Rows',
				id: '<?php echo $grid["source"]["ID"]; ?>',
				cache: false
            };		
		    var dataAdapter = new $.jqx.dataAdapter(source1);
			
			var theme = 'darkblue';
			// initialize jqxGrid
            $("#treegrid").jqxTreeGrid(
            {	theme: theme,
				width:  getWidth("TreeGrid"),
                source: dataAdapter,
                pageable: false,
				filterable: true,
                filterMode: 'simple',
                columnsResize: true,
				height:'550px',
                ready: function()
                {
                    // expand row with 'EmployeeKey = 32'
                    
					 $("#treegrid").jqxTreeGrid('expandRow', '2');
                },
                editable: true,
                showToolbar: true,
                altRows: false,
                ready: function()
                {
                    // called when the DatatreeGrid is loaded.   
					$("#treegrid").jqxTreeGrid('expandAll');					
                },
                pagerButtonsCount: 8,
                toolbarHeight: 35,
                renderToolbar: function(toolBar)
                {
                    var toTheme = function (className) {
                        if (theme == "") return className;
                        return className + " " + className + "-" + theme;
                    }
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var buttonTemplate = "<div style='float: left; padding: 3px; margin: 2px;'><div style='margin: 4px; width: 16px; height: 16px;'></div></div>";
                    var addButton = $(buttonTemplate);
                    var editButton = $(buttonTemplate);
                    var deleteButton = $(buttonTemplate);
                   
                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                   
                    toolBar.append(container);
                    addButton.jqxButton({cursor: "pointer", enableDefault: false, disabled: true, height: 25, width: 25 });
                    addButton.find('div:first').addClass(toTheme('jqx-icon-plus'));
                    addButton.jqxTooltip({ position: 'bottom', content: "Add"});
                    editButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    editButton.find('div:first').addClass(toTheme('jqx-icon-edit'));
                    editButton.jqxTooltip({ position: 'bottom', content: "Edit"});
                    deleteButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    deleteButton.find('div:first').addClass(toTheme('jqx-icon-delete'));
                    deleteButton.jqxTooltip({ position: 'bottom', content: "Delete"});
                    
                    var updateButtons = function (action) {
                        switch (action) {
                            case "Select":
                                addButton.jqxButton({ disabled: false });
                                deleteButton.jqxButton({ disabled: false });
                                editButton.jqxButton({ disabled: false });
                               
                                break;
                            case "Unselect":
                                addButton.jqxButton({ disabled: true });
                                deleteButton.jqxButton({ disabled: true });
                                editButton.jqxButton({ disabled: true });
                                
                                break;
                            case "Edit":
                                addButton.jqxButton({ disabled: true });
                                deleteButton.jqxButton({ disabled: true });
                                editButton.jqxButton({ disabled: true });
                                
                                break;
                            case "End Edit":
                                addButton.jqxButton({ disabled: false });
                                deleteButton.jqxButton({ disabled: false });
                                editButton.jqxButton({ disabled: false });
                                
                                break;
                        }
                    }
                    var rowKey = null;
                    $("#treegrid").on('rowSelect', function (event) {
                        var args = event.args;
                        rowKey = args.key;
                        updateButtons('Select');
                    });
                    $("#treegrid").on('rowUnselect', function (event) {
                        updateButtons('Unselect');
                    });
                    $("#treegrid").on('rowEndEdit', function (event) {
                        updateButtons('End Edit');
                    });
                    $("#treegrid").on('rowBeginEdit', function (event) {
                        updateButtons('Edit');
                    });
                    addButton.click(function (event) {
                        if (!addButton.jqxButton('disabled')) {
                            updateButtons('add');
							
							var parentkdgas = $("#treegrid").jqxTreeGrid('getCellValue', rowKey, 'KD_GAS');
							if (parentkdgas != null)$('#txtparentkdgas').val(parentkdgas);
							
							$('#txtkdgas').val('');
							$('#txtsubidproses').val('INPUTNEW');
							$('#editData').modal('show');
                        }
                    });
                    
                    editButton.click(function () {
                        if (!editButton.jqxButton('disabled')) {
                            //$("#treegrid").jqxTreeGrid('beginRowEdit', rowKey);
                            updateButtons('edit');
							
							var kdgas = $("#treegrid").jqxTreeGrid('getCellValue', rowKey, 'KD_GAS');
							var ket = $("#treegrid").jqxTreeGrid('getCellValue', rowKey, 'KET');
							
							$('#txtkdgas').val(kdgas);
							$('#txtket').val(ket);
							
							var parentkdgas = $("#treegrid").jqxTreeGrid('getCellValue', rowKey, 'PARENT_KD_GAS');
							if (parentkdgas != null)$('#txtparentkdgas').val(parentkdgas);
							$('#txtsubidproses').val('EDIT');
							
							$('#editData').modal('show');
							return false;
                        }
                    });
                    deleteButton.click(function () {
                        if (!deleteButton.jqxButton('disabled')) {
                            var selection = $("#treegrid").jqxTreeGrid('getSelection');
                            if (selection.length > 1) {
                                var keys = new Array();
                                for (var i = 0; i < selection.length; i++) {
                                    keys.push($("#treegrid").jqxTreeGrid('getKey', selection[i]));
                                }
                                $("#treegrid").jqxTreeGrid('deleteRow', keys);
                            }
                            else {
                                $("#treegrid").jqxTreeGrid('deleteRow', rowKey);
                            }
                            updateButtons('delete');
                        }
                    });
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
			
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			  //var target = $(e.target).attr("href") // activated tab
			  var ivalue = $(e.target).attr("value");
			  $('#jqxgrid').html('');
			  window.location.href = '<?php echo base_url().'hr/biro-bagian/M_Biro_Bagian/?ikdpat='?>'+ivalue;
			  
			});
			
			$("#cancelButton").click(function(){
				$('#formInput').fadeOut('slow');
			}); 
			
			$("#savebutton").click(function(){
				console.log($('#txtnospprbdari1').val());
			}); 
			
	});
	
	
</script>
<script type="text/javascript">
			
				var prosesSaveUpdateEvt = function(event){
					var subidproses = $('#txtsubidproses').val();
					if(subidproses=='EDIT'){
						updateButtonEvt(event);
					}else{
						saveButtonEvt(event);
					}
				}
				
				var saveButtonEvt = function(event){
					
					var ket = $('#txtket').val();
					var parentkdgas = $('#txtparentkdgas').val();
					
					var arrdata = {};
					
					arrdata["ket"] = ket;
					arrdata["parent_kd_gas"] = parentkdgas;
					arrdata["ikdpat"] = '<?=$ikdpat;?>';
					
					var jsonData = arrdata;
					
					$.ajax({
						url:  '<?=base_url()?>hr/biro-bagian/M_Biro_Bagian/saveNewData/',
						 type: 'POST',
						 dataType: 'json',
						 data: jsonData,
						 error: function ( data ) {
							console.log(data);
							return;
						 },
						 success: function (data) {
							//console.log(data);	
							if(data["STATUS"]=="BERHASIL")
							{
								$txtkdgas = '';
								$txtparentkdgas = '';
								$txtket = '';
								$("#treegrid").jqxTreeGrid('updateBoundData');
								$('#editData').modal('hide');
								$("#treegrid").jqxTreeGrid('expandAll');
								//window.location.href='<?=base_url()?>os/pengadaan/M_Tagihan_Vendor';
							}
							return;
						 }
						 
					});
					
					
				}
				
				var updateButtonEvt = function(event){
					
					var kdgas = $('#txtkdgas').val();
					var ket = $('#txtket').val();
					var parentkdgas = $('#txtparentkdgas').val();
					
					var arrdata = {};
					
					arrdata["kd_gas"] = kdgas;
					arrdata["ket"] = ket;
					arrdata["parent_kd_gas"] = parentkdgas;
					
					var jsonData = arrdata;
					
					$.ajax({
						url:  '<?=base_url()?>hr/biro-bagian/M_Biro_Bagian/updateData/',
						 type: 'POST',
						 dataType: 'json',
						 data: jsonData,
						 error: function ( data ) {
							console.log(data);
							return;
						 },
						 success: function (data) {
							//console.log(data);	
							if(data["STATUS"]=="BERHASIL")
							{
								$txtkdgas = '';
								$txtparentkdgas = '';
								$txtket = '';
								$("#treegrid").jqxTreeGrid('updateBoundData');
								$('#editData').modal('hide');
								$("#treegrid").jqxTreeGrid('expandAll');
								//window.location.href='<?=base_url()?>os/pengadaan/M_Tagihan_Vendor';
							}
							return;
						 }
						 
					});
					
					
				}
				
			</script>
                <!------------  table ------------------------------->
                <!-- Start body content -->
				 <ul class="nav nav-tabs">
				  <li class="<?php echo ($ikdpat=='0A')?'active':'';?>"><a data-toggle="tab" href="#content1" value="0A">1. Kantor Pusat</a></li>
				  <li class="<?php echo ($ikdpat=='1')?'active':'';?>"><a data-toggle="tab" href="#content1" value="1">2. Wilayah Penjualan</a></li>
				  <li class="<?php echo ($ikdpat=='2')?'active':'';?>"><a data-toggle="tab" href="#content1" value="2">3. Pabrik Beton</a></li>
				  <li class="<?php echo ($ikdpat=='3')?'active':'';?>"><a data-toggle="tab" href="#content1" value="3">4. Quarry</a></li>
				  <li class="<?php echo ($ikdpat=='4')?'active':'';?>"><a data-toggle="tab" href="#content1" value="4">5. Project</a></li>
				</ul>
					
				<div class="tab-content" style="height:600px;">
				  <div id="content1" class="tab-pane fade in active">
					<div  id="treegrid" style="margin-top: 1px;width: 50%; float:left;" > </div>
					<div  id="treegrid2" style="margin-top: 1px;width: 50%; float:right;" > </div>
				  </div>
				</div>
				
				
				<input type="hidden" id="txtkdpat" value="<?php echo $ikdpat; ?>" />
				<input type="hidden" id="txtrowactive" value="" />
			<!-- /.body-content -->
<!--/ End body content -->
                <!------------ end table ---------------------------->
                
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

  <div class="modal fade" id="editData" style="display: none;">
    <div class="modal-dialog " style="width:100%;height:100%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Form Input/Edit Data</h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Sub Dari ?</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<select id="txtparentkdgas" >
                                    <?php 
										foreach($DDListParent as $key=>$value)
										{
											echo "<option value='".$value["Value"]."'>".$value["Display"]."</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Keterangan</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								<input id="txtket" type="text" style="width:100%;" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-4">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Tutup</button>
							<button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="prosesSaveUpdateEvt()">Simpan</button>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<input type="hidden" id="txtkdgas" value="" />
					<input type="hidden" id="txtsubidproses" value="" />
				</div>        
			</div>
			
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

    