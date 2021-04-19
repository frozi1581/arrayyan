<script type="text/javascript">
	$(document).ready(function () {
			
			var nestedGrids = new Array();
			
			var initrowdetails = function (index, parentElement, gridElement, datarecord) {
				var id = datarecord.uid.toString();
				console.log(id);
                var grid = $($(parentElement).children()[0]);
                nestedGrids[index] = grid;
				
				//var grid = $($(parentElement).children()[0]);
				var trxid = datarecord['TRXID'];
				var sourceDetil =
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
					url: '<?php echo base_url().'os/produksi-ppb/M_Trans_Produksi/getGridData/?rowdet=1&ivalue='.$ivalue.'&parenttrxid='; ?>'+trxid,
					cache: false,
					filter: function()
					{
						// update the grid and send a request to the server.
						grid.jqxGrid('updatebounddata', 'filter');
					},
					sort: function()
					{
						// update the grid and send a request to the server.
						grid.jqxGrid('updatebounddata', 'sort');
					},
					root: 'Rows',
					beforeprocessing: function(data)
					{		
						
						if (data != null)
						{
							sourceDetil.totalrecords = data[0].TotalRows;	
							if(data[0].ErrorMsg!=""){
								alert(data[0].ErrorMsg);
							}
						}
					}
				};
				
				var dataAdapterDetil = new $.jqx.dataAdapter(sourceDetil);
				if (grid != null) {
					grid.jqxGrid({ source: dataAdapterDetil, theme: theme, width: '90%', filterable:true, pageable:true, pagesize:10, height:250, virtualmode:true, altrows:true, rendergridrows: function () {
						return dataAdapterDetil.records;
					},	
						columns: [
						  {
						  text: 'No', align:'center', sortable: false, filterable: false, editable: false,
						  groupable: false, draggable: false, resizable: false, pinned: true,
						  datafield: '', columntype: 'number', width: 50, cellsalign:'center',
						  cellsrenderer: function (row, column, value) {
							  return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
						  }
					  },
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
				}
				
			}
			
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
			    url: '<?php echo base_url().'os/produksi-ppb/M_Trans_Produksi/getGridData/?ivalue='.$ivalue; ?>',
				root: 'Rows',
				id: '<?php echo $grid["source"]["ID"]; ?>',
				cache: false,
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
						source1.totalrecords = data[0].TotalRows;	
					}
				}
				
            };		
		    var dataadapter = new $.jqx.dataAdapter(source1);
			
			var theme = 'darkblue';
			
			// initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '100%',
				columnsheight:'40px',
				showtoolbar:true,
				toolbarHeight: 35,
				rowdetails: true,
                initrowdetails: initrowdetails,
				rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;z-index:999'></div>", rowdetailsheight: 220, rowdetailshidden: true },
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
                    var cancelButton = $(buttonTemplate);
                    var updateButton = $(buttonTemplate);
                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                    container.append(cancelButton);
                    container.append(updateButton);
                    toolBar.append(container);
                    addButton.jqxButton({cursor: "pointer", enableDefault: false,  height: 25, width: 25 });
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
                                addButton.jqxButton({ disabled: false });
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
                    var rowIndex = null;
                    $("#jqxgrid").on('rowselect', function (event) {
                        var args = event.args;
                        rowIndex = args.rowindex;
						
                        updateButtons('Select');
                    });
                    $("#table").on('rowUnselect', function (event) {
                        updateButtons('Unselect');
                    });
                    $("#table").on('rowEndEdit', function (event) {
                        updateButtons('End Edit');
                    });
                    $("#table").on('rowBeginEdit', function (event) {
                        updateButtons('Edit');
                    });
                    addButton.click(function (event) {
                        if (!addButton.jqxButton('disabled')) {
                            //$("#formInput").fadeIn('slow');
							$('#txtnospprb').val('');
							$('#txtkdproduk').val('');
							$('#txtproduk').val('');
							$('#txtvolbaik').val('');
							$('#txttrxid').val('');
							for(i=0;i<8;i++)
							{
								$('#txtnospprbdari'+i).val('');
								$('#txtkdprodukdari'+i).val('');
								$('#txtprodukdari'+i).val('');
								$('#txtvolbaikdari'+i).val('');
								$('#txttrxiddari'+i).val('');
							}
							
							$('#formInputEdit').modal('show');
                        }
                    });
                    editButton.click(function () {
                        if (!editButton.jqxButton('disabled')) {
                           // $("#table").jqxDataTable('beginRowEdit', rowIndex);
						   
						   var data = $('#jqxgrid').jqxGrid('getrowdata', rowIndex);
						   //$('#formInputEdit').modal('show');
						   //console.log(data["ID"]);
						   var arrdata = {};
						   arrdata["trxid"] = data["ID"];
						   
						   var jsonData = arrdata;
		
							$.ajax({
								url:  '<?=base_url()?>os/produksi-ppb/M_Trans_Produksi/getEditData/',
								 type: 'GET',
								 dataType: 'json',
								 data: jsonData,
								 error: function ( data ) {
									console.log(data);
									return;
								 },
								 success: function (data) {
									var ivalue = '<?php echo $ivalue; ?>';
									console.log(data);	
									var iDari = 1;
									if(ivalue=='61'){
										$.each(data, function(i, item) {
											if(i==0){
												$('#txtnospprb').val(data[i]["NO_SPPRB1"]);
												$('#txtkdproduk').val(data[i]["KD_PRODUK"]);
												$('#txtproduk').val(data[i]["KETPRODUK"]);
												$('#txtvolbaik').val(data[i]["VOL_BAIK"]);
												$('#txttrxid').val(item["TRXID"]);
												
												$('#txtnospprbdari0').val(item["NO_SPPRB2"]);
												$('#txtkdprodukdari0').val(item["KD_PRODUK2"]);
												$('#txtprodukdari0').val(item["KETPRODUK"]);
												$('#txtvolbaikdari0').val(item["VOL_BAIK2"]);
												$('#txttrxiddari0').val(item["TRXID"]);
											}else{
												//console.log(item);
												$('#txtnospprbdari'+iDari).val(item["NO_SPPRB2"]);
												$('#txtkdprodukdari'+iDari).val(item["KD_PRODUK2"]);
												$('#txtprodukdari'+iDari).val(item["KETPRODUK"]);
												$('#txtvolbaikdari'+iDari).val(item["VOL_BAIK2"]);
												$('#txttrxiddari'+iDari).val(item["TRXID"]);
												iDari++;
											}
											
											
										});
										
										
									}
									
									return;
								 }
								 
							});
                            //updateButtons('edit');
							$('#formInputEdit').modal('show');
                        }
                    });
                    deleteButton.click(function () {
                        if (!deleteButton.jqxButton('disabled')) {
                           
						   var data = $('#jqxgrid').jqxGrid('getrowdata', rowIndex);
						   
						   var arrdata = {};
						   arrdata["trxid"] = data["ID"];
						   
						   var jsonData = arrdata;
		
							$.ajax({
								url:  '<?=base_url()?>os/produksi-ppb/M_Trans_Produksi/getDeleteData/',
								 type: 'GET',
								 dataType: 'json',
								 data: jsonData,
								 error: function ( data ) {
									console.log(data);
									return;
								 },
								 success: function (data) {
									window.location.href = '<?php echo base_url().'os/produksi-ppb/M_Trans_Produksi/?ivalue='?>'+ivalue;
								 }
								 
							});
                        }
                    });
                },
				source: dataadapter,
                theme: theme,
				filterable:true,
				pageable: true,
				pagesize: 10,
				sortable: false,
				altrows:true,
				showfilterrow:true,
				columnsresize: true,
				selectionmode: 'singlerow',
				rendergridrows: function () {
                    return dataadapter.records;
                },				
				
			    columns: [
					{
                      text: 'No', align:'center', sortable: false, filterable: false, editable: false,
                      groupable: false, draggable: false, resizable: false, pinned: true,
                      datafield: '', columntype: 'number', width: 50, cellsalign:'center',
                      cellsrenderer: function (row, column, value) {
                          return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
                      }
                  },
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
			
			$('#jqxgrid').on('rowclick', function (event) 
				{
				var args = event.args;
				// row's bound index.
				var boundIndex = args.rowindex;
				// row's visible index.
				var visibleIndex = args.visibleindex;
				// right click.
				var rightclick = args.rightclick; 
				// original event.
				var ev = args.originalEvent;      
				
				var data = $('#jqxgrid').jqxGrid('getrowdata', boundIndex);
				
				
				
			}); 
			
			
	});
	
</script>