<script type="text/javascript">
	$(document).ready(function () {
			var theme = 'darkblue';

			$('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top'});

			 $( "#txtTGL_BERLAKU" ).datepicker();
                         $("#txtTGL_AWAL").datepicker();$("#txtTGL_AHIR").datepicker();
			
			
			var ivalue='<?php echo $ivalue;?>';
			//var nestedGrids = new Array();
			var chartArrayData = new Array();
			
			var SQLID = '';
			
			var initrowdetails = function (index, parentElement, gridElement, datarecord) {
				$(parentElement).css("z-index", 3000);
				var empid = datarecord['EMPLOYEE_ID'];
				
				var tabsdiv = null;
                var information = null;
                var notes = null;
                tabsdiv = $($(parentElement).children()[0]);
                if (tabsdiv != null) {
                    information = tabsdiv.find('.information');
                    notes = tabsdiv.find('.notes');
                    var title = tabsdiv.find('.title');
                    title.text('Tabulasi');
                    var container = $('<div style="margin: 5px;"></div>')
                    container.appendTo($(information));
					
					var grid = $('<div style="float: left; width: 98%;"></div>');
					container.append(grid);
					
					var chartcontainer = $('<div style="float:left; width: 900px; height:500px;border:0px;"></div>');
					$(notes).append(chartcontainer);
					
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
						url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridData2/?ivalue='.$ivalue.'&iempid='; ?>'+empid,
						cache: false,
						root: 'Rows',
						beforeprocessing: function(data)
						{		
							
							if (data != null)
							{
								sourceDetil.totalrecords = data[0].TotalRows;	
							}
						}
					};
					
					var dataAdapterDetil = new $.jqx.dataAdapter(sourceDetil);
					grid.jqxGrid({ source: dataAdapterDetil, theme: theme, width: '100%', pageable:false, height:500, virtualmode:false, altrows:true, rendergridrows: function (obj) {
						return obj.data;
					},	
						columngroups: [
							{ text: 'ATASAN LANGSUNG', align: 'center', name: 'ATASAN' },
							{ text: 'PEER 1', align: 'center', name: 'PEER1' },
							{ text: 'PEER 2', align: 'center', name: 'PEER2' },
							{ text: 'BAWAHAN 1', align: 'center', name: 'BAWAHAN1' },
							{ text: 'BAWAHAN 2', align: 'center', name: 'BAWAHAN2' },
							{ text: 'BAWAHAN 3', align: 'center', name: 'BAWAHAN3' },
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
					
				var sourceChart = { 
					datafields: [{ name: 'ABC', type:'string' }, { name: 'JENIS', type:'string' },{ name: 'STD_KBI', type:'number' },{ name: 'NILAI_KBI', type:'number' }],
					datatype: "json",
					url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridData3/?ivalue='.$ivalue.'&iempid='; ?>'+empid
				}

				var dataAdapterChart = new $.jqx.dataAdapter(sourceChart, {autoBind: true, async:false, downloadComplete: function () { }, loadComplete: function () { },loadError: function () { }});
				//var dataAdapterChart = new $.jqx.dataAdapter({localdata:data, datafields: [{name: "ABC", type: "string"},{name: "NILAI_KBI", type: "number"}, {name: "STD_KBI", type: "number"}]});
				// prepare jqxChart settings
				var settings = {
					title: "KBI INDIVIDU BADU",
					description: "",
					source: dataAdapterChart,
					borderLineWidth: 0,
					padding: { left: 5, top: 5, right: 5, bottom: 5 },
					titlePadding: { left: 0, top: 0, right: 0, bottom: 5 },
					colorScheme: 'scheme05',
					xAxis:
					{
						dataField: 'JENIS',
						displayText: 'KRITERIA',
						valuesOnTicks: true,
						labels: { autoRotate: false, angle:350 }
					},
					valueAxis:
					{
						unitInterval: 0.5,
						minValue:0,
						maxValue:4,
						labels: {
							formatSettings: { decimalPlaces: 2 },
							formatFunction: function (value, itemIndex, serieIndex, groupIndex) {
								return value;
							}
						}
					},
					seriesGroups:
						[
							{
								spider: true,
								startAngle: 0,
								endAngle: 360,
								radius: 180,
								type: 'spline',
								series: [
										{ dataField: 'NILAI_KBI', displayText: 'Nilai KBI', lineColor:'#0365C0', opacity: 0.7, radius: 2, lineWidth: 2, symbolType: 'circle' },
										{ dataField: 'STD_KBI', displayText: 'Standar KBI', lineColor:'#C82506', opacity: 0.7, radius: 2, lineWidth: 2, symbolType: 'square' }
									]
							}
						]
				};
				// create the chart
				chartcontainer.jqxChart(settings);
				
				$(tabsdiv).jqxTabs({ theme:theme, width: '95%', height: 550});}
				
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
				height: '800px',
				columnsheight:'40px',
				showtoolbar:true,
				toolbarHeight: 40,
				rowdetails: true,
				showrowdetailscolumn: true,
                initrowdetails: initrowdetails,
				rowdetailstemplate: { rowdetails: "<div style='margin: 10px;'><ul style='margin-left: 30px;'><li class='title'></li><li>Grafik</li></ul><div class='information'></div><div class='notes'></div></div>", rowdetailsheight: 600 },
                renderToolbar: function(toolBar)
                {
					
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
					var btnSentEmail = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-file-pdf fa-lg fa-fw">&nbsp;</i>Cetak PDF</button>';
					var btnUploadMateri = '<button id="upmateri_rowbutton" type="button" value="" title="Upload Materi KBI Manajer/Non Manajer" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-upload fa-lg fa-fw">&nbsp;</i>Upload Materi</button>';
					var btnUploadPegawai = '<button id="upPegawai_rowbutton" type="button" value="" title="Upload Pegawai Peserta KBI" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-upload fa-lg fa-fw">&nbsp;</i>Upload Pegawai</button>';
					var loadingDiv = "<div style='margin: 2px;float:left;' id='loadingDiv'><img src='<?php echo base_url(); ?>assets/images/lg.rotating-squares-preloader-gif.gif' width='35px' height='35px;' /></div>";
					var sentEmailButton = $(btnSentEmail);
                                        var UploadMateriButton = $(btnUploadMateri);var UploadPegawaiButton = $(btnUploadPegawai);
                                        var loadingDivGif = $(loadingDiv);
					sentEmailButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
					UploadMateriButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                                        UploadPegawaiButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
					container.append(sentEmailButton);container.append(UploadMateriButton);container.append(UploadPegawaiButton);
					container.append(loadingDivGif);
					toolBar.append(container);
					$('#loadingDiv').hide();
					$('#formLoaderGif').hide();
                                        UploadMateriButton.click(function(event){
                                            $('#show_upload').modal('show');
                                            return false; 
                                        });
                                        UploadPegawaiButton.click(function(event){
                                            $('#show_upload_peserta').modal('show');
                                            return false; 
                                        });
					sentEmailButton.click(function (event) {
						$('#loadingDiv').show();
						$("#jqxgrid").jqxGrid({disabled:true});
						$('#formLoaderGif').modal('show');
						$.ajax({
							type: "GET",
							url: '<?php echo base_url()."hr/kbi-rev/M_KBI/genReport01/?ibl=".$ivalue."&ieselon=ALL";?>',
							async: true,
							success: function(data) {
								if(data!==null){
									var jsonData = $.parseJSON(data);
									var urlRpt = '<?php echo base_url();?>download/'+jsonData[0].fname;
									window.open(urlRpt);
									$('#loadingDiv').hide();
									$('#formLoaderGif').modal('hide');
									$("#jqxgrid").jqxGrid({disabled:false});
								}
								return; 
							}
						});
						
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
	});
    function submitUpload(){
        if(document.getElementById("txtTGL_BERLAKU").value===''){
            alert('Tgl. Berlaku Harus Diisi');
        }
        if(!$("#kbifile").val()){
            alert('Silahkan pilih File yang akan diupload.');
        }else{document.getElementById("fupload").submit(); 
        }
    }
    
    function submitUploadPeserta(){
        if($("#txtBL").val()==='')alert("Periode tidak boleh kosong.");
        if($("#txtTGL_AWAL").val()==='')alert("Tanggal Awal berlaku tidak boleh kosong.");
        if($("#txtTGL_AHIR").val()==='')alert("Tanggal Ahir berlaku tidak boleh kosong.");
        if(!$("#kbifilePeserta").val())  alert('Silahkan pilih File yang akan diupload.');
        if($("#txtBL").val()!=='' && $("#txtTGL_AWAL").val()!=='' && $("#txtTGL_AHIR").val()!==''  && $("#kbifilePeserta").val()   )  $("#fupload_peserta").submit();
       
    }
    function get_periode(obj){
            selectedId=obj.value;
            $.ajax({
                url: "<?php echo base_url().'hr/kbi-rev/M_KBI/cekPeriode'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
                dataType: 'json',
                success: function (data) {
                    if(data['cek']==='1'){
                        var result = confirm('Data sudah ada,Upload ulang ?');
                        if(result==false)  document.getElementById("txtBL").value='';
                        if(result==true){
                            $("#kbifilePeserta").focus();
                            $("#txtTGL_AWAL").val(data['data'][0]['ST_DATE']);
                            $("#txtTGL_AHIR").val(data['data'][0]['END_DATE']);
                            
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
         }
</script>
