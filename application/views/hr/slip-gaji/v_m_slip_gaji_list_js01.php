<script type="text/javascript">
	$(document).ready(function () {
			
			var theme = 'darkblue';
			
			var ivalue='<?php echo $ivalue;?>';
			//var nestedGrids = new Array();
			var chartArrayData = new Array();
			
			var SQLID = '';
			var nestedGrids = new Array();
			
			var initrowdetails = function (index, parentElement, gridElement, datarecord) {
				$(parentElement).css("z-index", 3000);
				
				var grid = $('#gridDetail1');
				
				var ibl = datarecord["BL"];
				
                nestedGrids[index] = grid;
				
				var localEmpData =  new Array();
				
				var source1 =
				$.ajax({
					type: "GET",
					url: '<?php echo base_url().'hr/slip-gaji/M_SlipGaji/getGridData2/?ivalue='.$ivalue.'&ibl='; ?>'+ibl,
					async: false,
					success: function(data) {
						 var idata = $.parseJSON(data);
						 
						 //console.log(idata[0].Rows[0].ID);
						 $.each(idata[0].Rows, function(key,value){
							 localEmpData.push(value);
						 });
						 
						 return; 
					}
				});
				
			
				var sourceGrid =
				{
					datatype: "json",
					url: '<?php echo base_url().'hr/slip-gaji/M_SlipGaji/getGridData2/?ivalue='.$ivalue.'&ibl='; ?>'+ibl,
					datafields: [
						<?php 
							$i=0;
							foreach($grid2["source"]["datafields"] as $key=>$value){
								if($i==(count($grid2["source"]["datafields"])-1) ){
									echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
								}else{
									echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
								}
								$i++;
							}
						?>
						
					],
					id: 'ID',
					cache: false,
					root: 'Rows',
					filter: function()
					{
						// update the grid and send a request to the server.
						grid.jqxGrid('updatebounddata', 'filter');
					},
					beforeprocessing: function(data)
					{		
						if (data != null)
						{
							sourceGrid.totalrecords = data[0].TotalRows;	
						}
					}
				};
				var dataAdapterGrid = new $.jqx.dataAdapter(sourceGrid);
				
				grid.jqxGrid({ source: dataAdapterGrid, theme: 'ui-start', width: '98%', 
				pageable:false, height:550, virtualmode:false, altrows:true, 
				showtoolbar:true,
				toolbarHeight: 40,
				filterable:true,showfilterrow:true,
				renderToolbar: function(toolBar)
				{
					
					var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
					var btnSentEmail = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-envelope fa-lg fa-fw">&nbsp;</i>Kirim Email</button>';
					var btnProgressBar = "<div style='margin: 2px;float:left;' id='jqxProgressBar'></div>";
					
					var sentEmailButton = $(btnSentEmail);
					var progressBarButton = $(btnProgressBar);
					
					sentEmailButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
					progressBarButton.jqxProgressBar({theme:'ui-redmond', width: 100, height: 30, showText:true, value: 0});
					
					container.append(sentEmailButton);
					container.append(progressBarButton);
					
					toolBar.append(container);
					
					$('#jqxProgressBar').hide();
					
					sentEmailButton.click(function (event) {
						var rowIndexes = grid.jqxGrid('getselectedrowindexes');
						var iLength = rowIndexes.length-1;
						var iProgress = 0;
						var iProgressPersen = 0;
						$('#jqxProgressBar').show();
						var arrNip = [];
						var startRec = 0;
						var nextSent = true;
						
						$.each(rowIndexes, function( index, value ) {
							var rowData = grid.jqxGrid('getrowdata',value);
							var rowId = rowData.ID;
							var inip = rowData.EMPLOYEE_ID;
							var iemail = rowData.EMAIL;
							arrNip.push({'rowid':rowId, 'nip':inip, 'email':iemail});
							grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Antrian...");
						});
						
						var timerId = window.setInterval(sentEmailByTimer, 2000);
						
						function sentEmailByTimer(){
							if(nextSent){
								if(startRec < arrNip.length){
									//console.log(arrNip[startRec]['nip']);
									grid.jqxGrid('setcellvaluebyid',arrNip[startRec]['rowid'], "STATUS", "Sending...");
									console.log(arrNip[startRec]['nip']);
									
									if(arrNip[startRec]['email']!=''){
										nextSent = false;
										
										$.ajax({
											type: "GET",
											url: '<?php echo base_url()."hr/slip-gaji/M_SlipGaji/sendEmail/?inip=";?>'+arrNip[startRec]['nip']+'&ibl='+ibl+'&iemail='+arrNip[startRec]['email'],
											async: true,
											success: function(data) {
												if(data!==null){
													 var jsonData = $.parseJSON(data);
													 if(jsonData[0].Status=='OK'){
														grid.jqxGrid('setcellvaluebyid',arrNip[startRec]['rowid'], "STATUS", "Done");
																							
														iProgressPersen = iProgress/iLength * 100;
														iProgressPersen = Math.round(iProgressPersen);
														progressBarButton.jqxProgressBar({value: iProgressPersen});
														iProgress = iProgress + 1;	
														//console.log(iProgressPersen);
													 }else{
														grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Error"); 
																		
														iProgressPersen = iProgress/iLength * 100;
														iProgressPersen = Math.round(iProgressPersen);
														progressBarButton.jqxProgressBar({value: iProgressPersen});
														iProgress = iProgress + 1;	
														//console.log(iProgressPersen);
													 }
													 nextSent = true;
													startRec++;
												}
												
												return; 
											}
										})
									}
								}else{
									clearInterval(timerId);
									startRec = 0;
								}//end of startRec < length
							}//end of nextSent
						}
						

						
						/* $.each(rowIndexes, function( index, value ) {
							var rowData = grid.jqxGrid('getrowdata',value);
							var rowId = rowData.ID;
							var inip = rowData.EMPLOYEE_ID;
							var iemail = rowData.EMAIL;
							
							grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Sending...");
						
							if(iemail!=''){
								
								
								$.ajax({
									type: "GET",
									url: '<?php echo base_url()."hr/slip-gaji/M_SlipGaji/sendEmail/?inip=";?>'+inip+'&ibl='+ibl+'&iemail='+iemail,
									async: true,
									success: function(data) {
										if(data!==null){
											 var jsonData = $.parseJSON(data);
											 if(jsonData[0].Status=='OK'){
												grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Done");
																					
												iProgressPersen = iProgress/iLength * 100;
												iProgressPersen = Math.round(iProgressPersen);
												progressBarButton.jqxProgressBar({value: iProgressPersen});
												iProgress = iProgress + 1;	
												console.log(iProgressPersen);
											 }else{
												grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Error"); 
																
												iProgressPersen = iProgress/iLength * 100;
												iProgressPersen = Math.round(iProgressPersen);
												progressBarButton.jqxProgressBar({value: iProgressPersen});
												iProgress = iProgress + 1;	
												console.log(iProgressPersen);
											 }
											
											
										}
										
										return; 
									}
								})
								
							}else{
								grid.jqxGrid('setcellvaluebyid',rowId, "STATUS", "Not Sent....");
							}
							
							
							
						}); */
					});
					
				},
				selectionmode: 'checkbox', 
				rendergridrows: function (obj) {
					return obj.data;
				},
					groupable:true,
					groups: ['BIRO_BAGIAN'],
					columns: [
					  {
					  text: 'No', align:'center', sortable: false, filterable: false, editable: false,
					  groupable: false, draggable: false, resizable: false, pinned: true,
					  datafield: '', columntype: 'number', width: 50, cellsalign:'center',
					  cellsrenderer: function (row, column, value) {
						  return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
					  },
					  
				  },
					<?php 
						$i=0;
						foreach($grid2["columns"] as $key=>$value){
							$strListColumns="{ align:'center',";
							foreach($value as $key2=>$value2){
								if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable'){
									$strListColumns .= $key2.":".$value2.",";
								}else{
									$strListColumns .= $key2.":'".$value2."',";
								}
							}
							$strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;
								
							if($i==(count($grid2["columns"])-1) ){
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
				
			}// end of initrowdetails 
			
			
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
			    url: '<?php echo base_url().'hr/slip-gaji/M_SlipGaji/getGridData/?ivalue='.$ivalue; ?>',
				root: 'Rows',
				id: '<?php echo $grid["source"]["ID"]; ?>',
				cache: false,
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
				},
				beforeprocessing: function(data)
				{		
					if (data != null)
					{
						source1.totalrecords = data[0].TotalRows;	
						SQLID = data[0].SqlId;
					}
				}
				
            };		
		    var dataadapter = new $.jqx.dataAdapter(source1,{async:false});
			
			// initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '100%',
				height: '750px',
				columnsheight:'40px',
				rowdetails: true,
				showrowdetailscolumn: true,
                initrowdetails: initrowdetails,
				rowdetailstemplate: { rowdetails: "<div><div id='gridDetail1'></div></div>", rowdetailsheight: 600 },
				showtoolbar:true,
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
                    var reportButton = $(buttonTemplate);
					
                },
				source: dataadapter,
                theme: theme,
				filterable:true,
				showfilterrow: false,
				pageable: false,
				sortable: false,
                virtualmode: true,
				altrows:true,
				columnsresize: true,
				rowsheight: 50,
				selectionmode: 'singlerow',
				
				rendergridrows: function (obj) {
                    return obj.data;
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