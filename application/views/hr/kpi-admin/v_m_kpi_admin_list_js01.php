<script type="text/javascript">
	$(document).ready(function () {
			var theme = 'darkblue';

			$('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top'});

			var ivalue='<?php echo $ivalue;?>';
			//var nestedGrids = new Array();
			var chartArrayData = new Array();
			
			var SQLID = '';
			
			var imagerenderer = function (row, datafield, value) {
				var data = $('#jqxGridL1').jqxGrid('getrowdata', row);
				console.log(data["ID"]);
                return '<img style="margin-left: 5px;" height="60" width="98%" src="<?php echo base_url();?>upload/' + data["ID"] + '.png"/>';
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
			    url: '<?php echo base_url().'hr/kpi-admin/M_KPI_ADMIN/getGridData/?ivalue='.$ivalue; ?>',
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
					console.log(data);
					if (data != null)
					{
						source1.totalrecords = data[0].TotalRows;	
					}
				}
				
            };		
		    var dataadapter = new $.jqx.dataAdapter(source1,{async:false});
			
			// initialize jqxGrid
            $("#jqxGridL1").jqxGrid(
            {	width: '100%',
				height: '100%',
				columnsheight:'40px',
				showtoolbar:true,
				toolbarHeight: 40,
				rowsheight:70,
				selectionmode: 'checkbox',
				rowdetails: false,
				showrowdetailscolumn: false,
                renderToolbar: function(toolBar)
                {
					
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
					var btnAddRow = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-plus fa-lg fa-fw">&nbsp;</i>Tambah Data</button>';
					var btnEditRow = '<button id="editrowbutton" type="button" value="" title="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-pencil fa-lg fa-fw">&nbsp;</i>Edit Data</button>';
					
					var loadingDiv = "<div style='margin: 2px;float:left;' id='loadingDiv'><img src='<?php echo base_url(); ?>assets/images/lg.rotating-squares-preloader-gif.gif' width='35px' height='35px;' /></div>";
					
					var addRowButton = $(btnAddRow);
                    var editRowButton = $(btnEditRow);
					
                    var loadingDivGif = $(loadingDiv);
					addRowButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
					editRowButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    
					container.append(addRowButton);
					container.append(editRowButton);
					container.append(loadingDivGif);

					toolBar.append(container);
					$('#loadingDiv').hide();
					$('#formLoaderGif').hide();
                                       
					addRowButton.click(function (event) {
						var params='';
						window.location.href='<?=base_url()?>hr/kpi-admin/M_KPI_ADMIN?idproses=addnewdata&params='+params;
					});

					addRowButton.click(function (event) {
						var params='';
						window.location.href='<?=base_url()?>hr/kpi-admin/M_KPI_ADMIN?idproses=editdata&params='+params;
					});
                },
				source: dataadapter,
                theme: theme,
				filterable:true,
				showfilterrow: true,
				pageable: true,
				pagesize: 20,
				sortable: false,
                virtualmode: true,
				altrows:true,
				columnsresize: true,
				selectionmode: 'singlerow',
				rendergridrows: function (obj) {
                    return obj.data;
                },				
				columngroups: [
						{ text: 'INDIKATOR KINERJA KUNCI', align: 'center', name: 'IKK' },
						{ text: 'CORPORAT', align: 'center', name: 'CORPORAT' }
					],
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
