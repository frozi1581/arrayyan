<script type="text/javascript">
	$(document).ready(function () {
           		var theme = 'darkblue';
			//$('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top'});
			 $( "#txtTGL_BERLAKU" ).datepicker();
                         $("#txtTGL_AWAL").datepicker();$("#txtTGL_AHIR").datepicker();
			var ivalue='<?php echo $ivalue;?>';
			//var nestedGrids = new Array();
			var chartArrayData = new Array();
			var SQLID = '';
			
            var source =
            {
                 datatype: "json",
                 datafields: [
                    <?php 
                            $i=0;
                            foreach($grid3["source"]["datafields"] as $key=>$value){
                                    if($i==(count($grid["source"]["datafields"])-1) ){
                                            echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
                                    }else{
                                            echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
                                    }
                                    $i++;
                            }
                    ?>
				],
                url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridDataBlmIsi/?ivalue='.$ivalue; ?>',
                root: 'Rows',
                id: '<?php echo $grid3["source"]["ID"]; ?>',
                cache: false,
                filter: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid1C").jqxGrid('updatebounddata', 'filter');
                },
                beforeprocessing: function(data)
                {   if (data != null)
                        {
                                source.totalrecords = data[0].TotalRows;	
                                //SQLID = data[0].SqlId;
                        }
                }
            };
            
            var dataadapter = new $.jqx.dataAdapter(source,{async:false});
            //console.log(dataadapter)
            // initialize jqxGrid
            $("#jqxgrid1C").jqxGrid(
            {	width: '90%',
                height: '725px',
                columnsheight:'40px',
                showtoolbar:true,
                toolbarHeight: 40,
                rowdetails: false,
                showrowdetailscolumn: false,
              //  initrowdetails: initrowdetails,
              //     rowdetailstemplate: { rowdetails: "<div style='margin: 10px;'><ul style='margin-left: 30px;'><li class='title'></li><li>Grafik</li></ul><div class='information'></div><div class='notes'></div></div>", rowdetailsheight: 600 },
                renderToolbar: function(toolBar)
                {
					
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var btnPdf = '<button id="pdfbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-file-pdf fa-lg fa-fw">&nbsp;</i>Cetak PDF</button>';
                    var btnSentNotif = '<button id="send_notifbutton" type="button" value="" title="Kirim Notifikasi ke WTONMobile" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fa fa-mobile fa-lg fa-fw">&nbsp;</i>Kirim Notifikasi</button>';
                    var btnFileExcel = '<button id="file_excel" type="button" value="" title="Download File Xls" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fa fa-file-excel-o  fa-lg fa-fw">&nbsp;</i>Download File</button>';
                    var loadingDiv = "<div style='margin: 2px;float:left;' id='loadingDiv' ><img src='<?php echo base_url(); ?>assets/images/lg.rotating-squares-preloader-gif.gif' width='35px' height='35px;' /></div>";
                    var pdfButton = $(btnPdf);
                    var SendNotifButton = $(btnSentNotif);var FileExcelButton = $(btnFileExcel);
                    var loadingDivGif = $(loadingDiv);
                    pdfButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    SendNotifButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    FileExcelButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    container.append(pdfButton);container.append(SendNotifButton);container.append(FileExcelButton);
                    toolBar.append(container);
                    $('#formLoaderGif').hide();
                    
                    SendNotifButton.click(function(event){
                        $('#loadingDiv').show();
                        $('#formLoaderGif').modal('show');
                       var selectedId="<?php echo $ivalue; ?>";
                        $.ajax({
                            url: "<?php echo base_url().'hr/kbi-rev/M_KBI/SEND_NOTIF';?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                            dataType: 'json',
                            success: function (data) {
                                $('#formLoaderGif').modal('hide');
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });
                        return false; 
                    });
                    FileExcelButton.click(function(event){
                        $('#loadingDiv').show();
                        $('#formLoaderGif').modal('show');
                       var selectedId="<?php echo $ivalue; ?>";
                        $.ajax({
                            url: "<?php echo base_url().'hr/kbi-rev/M_KBI/DOWNLOAD_FILE';?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                window.location.href = "<?php echo base_url();?>"+data;
                                $('#formLoaderGif').modal('hide');
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });
                        return false; 
                    });
                    pdfButton.click(function (event) {
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
			/*	columngroups: [
						{ text: 'KBI INDIVIDU', align: 'center', name: 'KBIINDIVIDU' }
					],*/
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
						foreach($grid3["columns"] as $key=>$value){
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

			
			var source1D =
            {
                 datatype: "json",
                 datafields: [
                    <?php 
                            $i=0;
                            foreach($grid4["source"]["datafields"] as $key=>$value){
                                    if($i==(count($grid["source"]["datafields"])-1) ){
                                            echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
                                    }else{
                                            echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
                                    }
                                    $i++;
                            }
                    ?>
				],
                url: '<?php echo base_url().'hr/kbi-rev/M_KBI/getGridDataSdhIsi/?ivalue='.$ivalue; ?>',
                root: 'Rows',
                id: '<?php echo $grid4["source"]["ID"]; ?>',
                cache: false,
                filter: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid1D").jqxGrid('updatebounddata', 'filter');
                },
                beforeprocessing: function(data)
                {   if (data != null)
                        {
                                source1D.totalrecords = data[0].TotalRows;	
                                //SQLID = data[0].SqlId;
                        }
                }
            };
            
            var dataadapter1D = new $.jqx.dataAdapter(source1D,{async:false});
            //console.log(dataadapter)
            // initialize jqxGrid
            $("#jqxgrid1D").jqxGrid(
            {	width: '90%',
                height: '725px',
                columnsheight:'40px',
                showtoolbar:true,
                toolbarHeight: 40,
                rowdetails: false,
                showrowdetailscolumn: false,
                renderToolbar: function(toolBar)
                {
					
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var btnPdf = '<button id="pdfbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fas fa-file-pdf fa-lg fa-fw">&nbsp;</i>Cetak PDF</button>';
                    var btnSentNotif = '<button id="send_notifbutton" type="button" value="" title="Kirim Notifikasi ke WTONMobile" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fa fa-mobile fa-lg fa-fw">&nbsp;</i>Kirim Notifikasi</button>';
                    var btnFileExcel = '<button id="file_excel" type="button" value="" title="Download File Xls" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fa fa-file-excel-o  fa-lg fa-fw">&nbsp;</i>Download File</button>';
                    var loadingDiv = "<div style='margin: 2px;float:left;' id='loadingDiv' ><img src='<?php echo base_url(); ?>assets/images/lg.rotating-squares-preloader-gif.gif' width='35px' height='35px;' /></div>";
                    var pdfButton = $(btnPdf);
                    var SendNotifButton = $(btnSentNotif);var FileExcelButton = $(btnFileExcel);
                    var loadingDivGif = $(loadingDiv);
                    pdfButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    SendNotifButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    FileExcelButton.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    container.append(pdfButton);container.append(SendNotifButton);container.append(FileExcelButton);
                    toolBar.append(container);
                    $('#formLoaderGif').hide();
                    
                    SendNotifButton.click(function(event){
                        $('#loadingDiv').show();
                        $('#formLoaderGif').modal('show');
                       var selectedId="<?php echo $ivalue; ?>";
                        $.ajax({
                            url: "<?php echo base_url().'hr/kbi-rev/M_KBI/SEND_NOTIF';?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                            dataType: 'json',
                            success: function (data) {
                                $('#formLoaderGif').modal('hide');
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });
                        return false; 
                    });
                    FileExcelButton.click(function(event){
                        $('#loadingDiv').show();
                        $('#formLoaderGif').modal('show');
                       var selectedId="<?php echo $ivalue; ?>";
                        $.ajax({
                            url: "<?php echo base_url().'hr/kbi-rev/M_KBI/DOWNLOAD_FILE';?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                window.location.href = "<?php echo base_url();?>"+data;
                                $('#formLoaderGif').modal('hide');
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });
                        return false; 
                    });
                    pdfButton.click(function (event) {
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
                
                source: dataadapter1D,
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
						foreach($grid4["columns"] as $key=>$value){
							$strListColumns="{ align:'center',";
							foreach($value as $key2=>$value2){
								if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable'){
									$strListColumns .= $key2.":".$value2.",";
								}else{
									$strListColumns .= $key2.":'".$value2."',";
								}
							}
							$strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;
								
							if($i==(count($grid4["columns"])-1) ){
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
                   // console.log(data);
                }
            });
         }
</script>
