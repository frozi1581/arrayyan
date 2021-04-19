

<script type="text/javascript">
    $(document).ready(function () {
        var theme = 'darkblue';
        var arrSumData = [];
        var arrMaxData = [];
        
        $('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top',selectedItem: <?php echo $subpage;?>});

        $('#subtabs').on('selected', function (event) {
            var value = $("#subtabs").jqxTabs('val');
            window.location="<?php echo base_url().'kkms/M_penjualan/?subpage=';?>" + value;
        });

        //$('#subtabs').jqxTabs('select', <?php echo $subpage;?>);

        $("#cancelButton").click(function(){
            $('#formInput').fadeOut('slow');
        });
        
        var source2 =
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
                url: '<?php echo base_url().'kkms/M_penjualan/getGridData2/?nopenerbitan='; ?>?ifldorderby=' + $('#txtfldorderby').val(),
                root: 'Rows',
                id: '<?php echo $grid2["source"]["ID"]; ?>',
                cache: false,
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#jqxgrid2").jqxGrid('updatebounddata', 'filter');
                },
                beforeprocessing: function(data)
                {
                    if (data != null)
                    {
                        source2.totalrecords = data[0].TotalRows;
                        arrSumData = data[0].SumData;
                        arrMaxData = data[0].MaxData;
                    }
                }

            };
        var dataadapter2 = new $.jqx.dataAdapter(source2,{async:false});

        var toThemeProperty = function (className) {
            return className + " " + className + "-" + theme;
        }
        var groupsrenderer = function (text, group, expanded, data) {
            var number = dataadapter2.formatNumber(group, data.groupcolumn.cellsformat);
            var text =  number;
            
            var aggregate = this.getcolumnaggregateddata('lbr_pengajuan', ['sum'], true, data.subItems);
            return '<div class="' + toThemeProperty('jqx-grid-groups-row') + '" style="position: absolute;"><span>' + text + ', </span>' + '<span class="' + toThemeProperty('jqx-grid-groups-row-details') + '">' + "<i>Jumlah Lembar Pengajuan : " + arrSumData[data.group] + ' , Maks. Harga Pengajuan : ' + arrMaxData[data.group] + '</i></span></div>';

        }
        
        // initialize jqxGrid
        $("#jqxgrid2").jqxGrid(
            {	width: '100%',
                height: '800px',
                columnsheight:'40px',
                showtoolbar:true,
                toolbarHeight: 40,
                groupable:true,
                groups: ['sekuritasemiten'],
                groupsrenderer:groupsrenderer,
                showgroupsheader: false,
                renderToolbar: function(toolBar)
                {

                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                   
                    var btnTerjual = '<button id="btnTerjual" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-money fa-lg fa-fw" style="padding:5px;"></i>&nbsp;&nbsp;&nbsp;Laku Terjual</button>';

                    var btnCancelJual = '<button id="btnCancelJual" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-reply fa-lg fa-fw" style="padding:5px;"></i>&nbsp;&nbsp;&nbsp;Batal Proses</button>';
                    
                    var terjual = $(btnTerjual);
                    var cancelJual = $(btnCancelJual);
                    
                    terjual.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    cancelJual.jqxButton({theme:'ui-start', width:'130px', height:'35px'});

                    container.append(cancelJual);
                    container.append(terjual);
                    toolBar.append(container);

                    terjual.click(function (event) {
                        var rows = $('#jqxgrid2').jqxGrid('selectedrowindexes');
                        var IDS = '';
                        var Sekuritas = '';
                        var Emiten = '';
                        var JmlLbr = 0;
                        var HrgMax = 0;
                        
                        $.each(rows, function(key,value){
                            var rowData = $('#jqxgrid2').jqxGrid('getrowdata', value);
                            if(key>0){
                                IDS = IDS + '|' + rowData['id'];
                            }else{
                                IDS = rowData['id'];
                            }
                            Sekuritas = rowData['sekuritas'];
                            Emiten = rowData['kode_emiten'];
                            JmlLbr = JmlLbr + parseInt(rowData['lbr_pengajuan']);
                            if(parseInt(rowData['hrg_pengajuan']) > HrgMax){
                                HrgMax = parseInt(rowData['hrg_pengajuan']);
                            }
                            
                            $("#txtSekuritas").val(Sekuritas);
                            $("#txtEmiten").val(Emiten);
                            $("#txtJmlLbrPengajuan").val(JmlLbr);
                            $("#txtMaxHrgPengajuan").val(HrgMax);
                            $("#txtJmlLbr").val(JmlLbr);
                            $("#txtHrgPerLbr").val(HrgMax);
                        });

                        var paramsSent = { iIDS: IDS };
                        $("#jqxwindow").jqxWindow('open');
                        $("#txtSekuritas").val(Sekuritas);
                        
                       

                    });

                    cancelJual.click(function (event) {
                        var rows = $('#jqxgrid2').jqxGrid('selectedrowindexes');
                        var IDS = '';
                        $.each(rows, function(key,value){
                            var rowData = $('#jqxgrid2').jqxGrid('getrowdata', value);
                            if(key>0){
                                IDS = IDS + '|' + rowData['id'];
                            }else{
                                IDS = rowData['id'];
                            }

                            //console.log(rowData['id']);
                        });

                        var paramsSent = { iIDS: IDS };

                        console.log(paramsSent);

                        $.ajax({
                            url: "<?php echo base_url().'kkms/M_penjualan/setCancelProses' ?>",
                            type: 'POST',
                            data: paramsSent,
                            dataType: 'json',
                            success: function (data) {
                                if(data.Status=="OK"){
                                    window.location="<?php echo base_url().'kkms/M_penjualan/?subpage=0';?>";
                                   
                                }else{
                                    window.alert("ERROR :"+data.ErrorMsg);
                                }
                            },
                            error: function (data) {
                                // console.log(data);
                                console.log('error');
                            }
                        });



                    });
                },
                rowdetails: true,
                showrowdetailscolumn: false,
                source: dataadapter2,
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
                selectionmode: 'checkbox',
                rendergridrows: function (obj) {
                    return obj.data;
                },
                showstatusbar: true,
                statusbarheight: 25,
                showaggregates: true,
                columns: [
                    {
                        text: 'No', align:'center', sortable: false, filterable: false, editable: false, hidden:true,
                        groupable: false, draggable: false, resizable: false, pinned: true,
                        datafield: '', columntype: 'number', width: '5%', cellsalign:'center',
                        cellsrenderer: function (row, column, value) {
                            return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
                        }
                    },
					<?php
					$i=0;
					foreach($grid2["columns"] as $key=>$value){
						$strListColumns="{ align:'center',";
						foreach($value as $key2=>$value2){
							if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable' || $key2=='aggregates' || $key2=='aggregatesrenderer'){
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

        $("#jqxgrid2").on("bindingcomplete", function (event) {
            //$('#totalLbrWIKA').val(totalLbrWIKA);
            //$('#totalLbrWIKA').number(true,0);

        });

        $('#jqxgrid2').jqxGrid('expandallgroups');

        $('#jqxwindow').jqxWindow({
            theme: 'energyblue',
            autoOpen:false,
            width:'800px',
            height:'450px'
        });

        $('#txtJmlLbrPengajuan').number(true,0);
        $('#txtMaxHrgPengajuan').number(true,0);
        
        $('#txtJmlLbr').number(true,0);
        $('#txtTerimaDana').number(true,0);

        
    });

    function submitUpload(){
        var rows = $('#jqxgrid2').jqxGrid('selectedrowindexes');
        var IDS = '';
        var JmlLbrAju = '';
        
        
        var sekuritas = $('#txtSekuritas').val();
        var emiten = $('#txtEmiten').val();
        var JmlLbr = $('#txtJmlLbr').val();
        var TerimaDana = $('#txtTerimaDana').val();
        
        $.each(rows, function(key,value){
            var rowData = $('#jqxgrid2').jqxGrid('getrowdata', value);
            if(key>0){
                IDS = IDS + '|' + rowData['id'];
                JmlLbrAju = JmlLbrAju + '|' + rowData['lbr_dijual'];
            }else{
                IDS = rowData['id'];
                JmlLbrAju = rowData['lbr_dijual'];
            }
            
        });

        var paramsSent = { iemiten:emiten, isekuritas:sekuritas, iIDS: IDS, iJmlLbrAju: JmlLbrAju, iJmlLbr : JmlLbr, iTerimaDana : TerimaDana };
        
        //console.log(paramsSent);
        
        $.ajax({
            url: "<?php echo base_url().'kkms/M_penjualan/setTerjual' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {
                if(data.Status=="OK"){
                    window.location="<?php echo base_url().'kkms/M_penjualan/?subpage=2';?>";
                }else{
                    window.alert("ERROR :"+data.ErrorMsg);
                }
            },
            error: function (data) {
                // console.log(data);
                console.log('error');
            }
        });
        
    }

    

</script>

