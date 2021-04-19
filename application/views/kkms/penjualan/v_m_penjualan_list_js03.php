<script type="text/javascript">
    $(document).ready(function () {
        var theme = 'darkblue';

        $('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top',selectedItem: <?php echo $subpage;?>});

        $('#subtabs').on('selected', function (event) {
            var value = $("#subtabs").jqxTabs('val');
            window.location="<?php echo base_url().'kkms/M_penjualan/?subpage=';?>" + value;
        });

        //$('#subtabs').jqxTabs('select', <?php echo $subpage;?>);

        $("#cancelButton").click(function(){
            $('#formInput').fadeOut('slow');
        });
        
        var source3 =
            {
                datatype: "json",
                datafields: [
					<?php
					$i=0;
					foreach($grid3["source"]["datafields"] as $key=>$value){
						if($i==(count($grid3["source"]["datafields"])-1) ){
							echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
						}else{
							echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
						}
						$i++;
					}
					?>

                ],
                url: '<?php echo base_url().'kkms/M_penjualan/getGridData3/'; ?>?ifldorderby=' + $('#txtfldorderby').val(),
                root: 'Rows',
                id: '<?php echo $grid3["source"]["ID"]; ?>',
                cache: false,
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#jqxgrid3").jqxGrid('updatebounddata', 'filter');
                },
                beforeprocessing: function(data)
                {
                    if (data != null)
                    {
                        source3.totalrecords = data[0].TotalRows;
                    }
                }

            };
        var dataadapter3 = new $.jqx.dataAdapter(source3,{async:false});

        // initialize jqxGrid
        $("#jqxgrid3").jqxGrid(
            {	width: '100%',
                height: '800px',
                columnsheight:'40px',
                showtoolbar:true,
                toolbarHeight: 40,
                editable:false,
                renderToolbar: function(toolBar)
                {

                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");

                    var btnLapHarian = '<button id="btnCancelJual" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-file-pdf-o fa-lg fa-fw" style="padding:5px;"></i>&nbsp;&nbsp;&nbsp;Rekap Penjualan</button>';
                    
                    var lapHarian = $(btnLapHarian);
                    
                    lapHarian.jqxButton({theme:'ui-start', width:'180px', height:'35px'});
                    
                    container.append(lapHarian);
                    toolBar.append(container);
                    
                    lapHarian.click(function (event) {
                        var rowIndex = $('#jqxgrid3').jqxGrid('selectedrowindex');
                        //console.log(rowIndex);
                        
                        if(rowIndex !== ''){
                            var rowData = $('#jqxgrid3').jqxGrid('getrowdata', rowIndex);
                            //console.log(rowData);
                            //console.log(rowData.id_batch);
                            window.open('<?php echo base_url()."kkms/M_penjualan/genLapRekapharian?iidbatch=";?>'+rowData.id_batch,'_blank');
                        }else{
                            alert('Harap pilih salah satu baris, untuk melakukan pencetakan Rekap Penjualan.....');
                        }
                        
                    });
                    
                },
                rowdetails: true,
                showrowdetailscolumn: false,
                source: dataadapter3,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 100,
                pagesizeoptions: ['10', '20', '50','100','1000','10000'],
                sortable: false,
                virtualmode: true,
                altrows:true,
                columnsresize: true,
                selectionmode: 'single',
                rendergridrows: function (obj) {
                    return obj.data;
                },
                showstatusbar: true,
                statusbarheight: 25,
                showaggregates: true,
                columns: [
                    {
                        text: 'No', align:'center', sortable: false, filterable: false, editable: false,
                        groupable: false, draggable: false, resizable: false, pinned: true,
                        datafield: '', columntype: 'number', width: '5%', cellsalign:'center',
                        cellsrenderer: function (row, column, value) {
                            return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
                        }
                    },
					<?php
					$i=0;
					foreach($grid3["columns"] as $key=>$value){
						$strListColumns="{ align:'center',";
						foreach($value as $key3=>$value3){
							if($key3=='hidden' || $key3=='cellsrenderer' || $key3=='buttonclick' || $key3=='filterable' || $key3=='sortable' || $key3=='aggregates' || $key3=='aggregatesrenderer'){
								$strListColumns .= $key3.":".$value3.",";
							}else{
								$strListColumns .= $key3.":'".$value3."',";
							}
						}
						$strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;
						
						if($i==(count($grid3["columns"])-1) ){
							$strListColumns.="}";
						}else{
							$strListColumns.="},";
						}
						echo $strListColumns."\n";
						$i++;
					}
					?>

                ],
                columngroups:
                    [
                        { text: 'Data Peserta', align: 'center', name: 'datapeserta' },
                        { text: 'Pengajuan', align: 'center', name: 'pengajuan' },
                        { text: 'Terjual', align: 'center', name: 'terjual' },
                        { text: 'KKMS', align: 'center', name: 'kkms' }
                    ]
            });

        $("#jqxgrid3").on("bindingcomplete", function (event) {
            //$('#totalLbrWIKA').val(totalLbrWIKA);
            //$('#totalLbrWIKA').number(true,0);

        });

        $("#jqxgrid3").on('cellendedit', function (event) {
            var args = event.args;
            //var lbrterjual = parseInt(args.row.lbr_terjual);
            //var hrgterjual = parseInt(args.row.hrg_terjual);
            
            console.log(args);
            console.log(args.row.lbr_terjual);
            //console.log(args.row.lbr_terjual);
            
        });

        $('[data-toggle=datepicker]').each(function() {
            var target = $(this).data('target-name');
            var t = $('input[name=' + target + ']');
            t.datepicker({
                dateFormat: 'dd/mm/yy',
                theme: 'classic'
            });
            $(this).on("click", function() {
                t.datepicker("show");
            });
        });

        $(".tgl-dok").datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateText) {
                //console.log(dateText);

            }
        });
        
        $('#jqxwindow2').jqxWindow({
            theme: 'energyblue',
            autoOpen:false,
            width:'800px',
            height:'450px'
        });
        
    });





</script>