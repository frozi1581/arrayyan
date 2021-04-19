<script type="text/javascript">
	$(document).ready(function () {
			
			var ivalue='<?php echo $ivalue;?>';
			var nestedGrids = new Array();
			
			var initrowdetails = function (index, parentElement, gridElement, datarecord) {
				var id = datarecord.uid.toString();
                var grid = $($(parentElement).children()[0]);
                nestedGrids[index] = grid;
				
				$(parentElement).css("z-index", 1000);
				
				//var grid = $($(parentElement).children()[0]);
				var recid = datarecord['ID'];
				var empid = datarecord['EMPLOYEE_ID'];
				var sourceDetil =
				{
					 datatype: "json",
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
					url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridData2/?ivalue='.$ivalue.'&recid='; ?>'+recid+'&iempid='+empid,
					cache: false,
					filter: function()
					{
						grid.jqxGrid('updatebounddata', 'filter');
					},
					sort: function()
					{
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
				grid.jqxGrid({ source: dataAdapterDetil, theme: theme, width: '95%', pageable:false, height:510, virtualmode:true, altrows:true, rendergridrows: function () {
                    return dataAdapterDetil.records;
                },	
					columngroups: [
						{ text: 'ATASAN LANGSUNG', align: 'center', name: 'ATASAN' },
						{ text: 'PEER 1', align: 'center', name: 'PEER1' },
						{ text: 'PEER 2', align: 'center', name: 'PEER2' },
						{ text: 'BAWAHAN', align: 'center', name: 'BAWAHAN' },
						{ text: 'DIRI SENDIRI', align: 'center', name: 'DIRISENDIRI' },
						{ text: 'KBI INDIVIDU', align: 'center', name: 'KBIINDIVIDU' }
					],
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
			    url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridData/?ivalue='.$ivalue; ?>',
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
				height: '800px',
				columnsheight:'40px',
				showtoolbar:true,
				toolbarHeight: 35,
				rowdetails: true,
                initrowdetails: initrowdetails,
				rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;z-index:999;border:1px solid grey;'></div>", rowdetailsheight: 600, rowdetailshidden: true },
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
                    container.append(reportButton);
                    toolBar.append(container);
                    reportButton.jqxButton({cursor: "pointer", enableDefault: false,  height: 25, width: 25 });
                    reportButton.find('div:first').addClass(toTheme('jqx-icon-report01'));
                    reportButton.jqxTooltip({ position: 'bottom', content: "Tabulasi"});
                    var updateButtons = function (action) {
                        switch (action) {
                            case "Select":
                                reportButton.jqxButton({ disabled: false });
                                
                                
                                break;
                            case "Unselect":
                                reportButton.jqxButton({ disabled: false });
                                
                                break;
                            case "Edit":
                                reportButton.jqxButton({ disabled: true });
                                
                                break;
                            case "End Edit":
                                reportButton.jqxButton({ disabled: false });
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
                    reportButton.click(function (event) {
                        
                    });
                    
                },
				source: dataadapter,
                theme: theme,
				filterable:true,
				showfilterrow: false,
				pageable: true,
				pagesize: 20,
				sortable: false,
                virtualmode: true,
				altrows:true,
				columnsresize: true,
				selectionmode: 'singlerow',
				rendergridrows: function () {
                    return dataadapter.records;
                },				
				columngroups: [
						{ text: 'KBI INDIVIDU', align: 'center', name: 'KBIINDIVIDU' }
					],
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
			
			// $('#jqxgrid').on('rowclick', function (event) 
				// {
				// var args = event.args;
				// var boundIndex = args.rowindex;
				// var visibleIndex = args.visibleindex;
				// var rightclick = args.rightclick; 
				// var ev = args.originalEvent;      
				
				// var data = $('#jqxgrid').jqxGrid('getrowdata', boundIndex);
				
				
				
			// }); 
			
				
			
	});
</script>