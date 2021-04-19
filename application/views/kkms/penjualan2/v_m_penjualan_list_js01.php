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

        
        
        var renderACT = function(ROW){
            aDATAGRID=dataadapter['_source']['records'];
            var dataRecord = dataadapter['_source']['records'][ROW];//$("#jqxgrid").jqxGrid("getrowdata", row_);
            //console.log(dataRecord);
            
            var btnEdit = '<button id="editRowButton" type="button" value="" title="Edit" onclick="EDIT_DETAIL('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-pencil fa-fw">&nbsp;</i></button>';

            var btnDel = '<button id="delRowButton" type="button" value="" title="Hapus" onclick="DELETE_DETAIL('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-trash fa-fw">&nbsp;</i></button>';

            var btnUp = '<button id="upRowButton" type="button" value="" title="Up" onclick="UP_LEVEL('+ROW+')"  style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-level-up fa-fw">&nbsp;</i></button>';

            var btnDown = '<button id="downRowButton" type="button" value="" title="Down" onclick="DOWN_LEVEL('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-level-down fa-fw">&nbsp;</i></button>';

           
            var container = '<div style="text-align:center;width:99%;align:center;display: inline-block">'+btnEdit+btnDel+btnUp+btnDown+'</div>';
            
            html = container;
            return html;
        };
        
        
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
                url: '<?php echo base_url().'kkms/M_penjualan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val(),
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
                        arrSumData = data[0].SumData;
                        arrMaxData = data[0].MaxData;
                    }
                }

            };
        var dataadapter = new $.jqx.dataAdapter(source1,{async:false});

        var toThemeProperty = function (className) {
            return className + " " + className + "-" + theme;
        }
        var groupsrenderer = function (text, group, expanded, data) {
            var number = dataadapter.formatNumber(group, data.groupcolumn.cellsformat);
            var text =  number;
            
            var aggregate = this.getcolumnaggregateddata('lbr_pengajuan', ['sum'], true, data.subItems);
            return '<div class="' + toThemeProperty('jqx-grid-groups-row') + '" style="position: absolute;"><span>' + text + ', </span>' + '<span class="' + toThemeProperty('jqx-grid-groups-row-details') + '">' + "<i>Jumlah Lembar Pengajuan : " + arrSumData[data.group] + ' , Maks. Harga Pengajuan : ' + arrMaxData[data.group] + '</i></span></div>';
            
        }
        
        // initialize jqxGrid
        $("#jqxgrid").jqxGrid(
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
                    var btnAddNew = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-plus fa-lg fa-fw">&nbsp;</i>Add New</button>';
                    var btnProsesJual = '<button id="btnProsesJual" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-cloud-upload fa-lg fa-fw"></i>&nbsp;&nbsp;Submit</button>';

                    var addNew = $(btnAddNew);
                    var prosesJual = $(btnProsesJual);

                    addNew.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    prosesJual.jqxButton({theme:'ui-start', width:'130px', height:'35px'});

                    container.append(addNew);
                    container.append(prosesJual);
                    toolBar.append(container);
                    addNew.click(function(event){
                        window.location.href = "<?php echo base_url().'kkms/M_penjualan/addNewData'; ?>";
                        return false;
                    });
                    prosesJual.click(function (event) {
                        var rows = $('#jqxgrid').jqxGrid('selectedrowindexes');
                        var IDS = '';
                        $.each(rows, function(key,value){
                            var rowData = $('#jqxgrid').jqxGrid('getrowdata', value);
                            if(key>0){
                                IDS = IDS + '|' + rowData['id'];
                            }else{
                                IDS = rowData['id'];
                            }
                            
                            //console.log(rowData['id']);
                        });

                        var paramsSent = { iIDS: IDS };

                        //console.log(paramsSent);

                        $.ajax({
                            url: "<?php echo base_url().'kkms/M_penjualan/setProses' ?>",
                            type: 'POST',
                            data: paramsSent,
                            dataType: 'json',
                            success: function (data) {
                                if(data.Status=="OK"){
                                    window.location="<?php echo base_url().'kkms/M_penjualan/?subpage=1';?>";
                                    
                                }else{
                                    window.alert("ERROR :"+data.ErrorMsg);
                                }
                            },
                            error: function (data) {
                                // console.log(data);
                                console.log('error');
                            }
                        });
                        
                        //$('#loadingDiv').show();
                        //$("#jqxgrid").jqxGrid({disabled:true});
                        //$('#formLoaderGif').modal('show');
                        
                    });
                },
                rowdetails: true,
                showrowdetailscolumn: false,
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow:true,
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
                        text: 'No', align:'center', sortable: false, filterable: false, editable: false,
                        groupable: false, draggable: false, resizable: false, pinned: true,hidden:true,
                        datafield: '', columntype: 'number', width: '3%', cellsalign:'center',
                        cellsrenderer: function (row, column, value) {
                            return "<div style='margin:4px;width:100%;align:center;text-align:center;'> " + (value + 1) +  "</div>";
                        }
                    },
					<?php
					$i=0;
					foreach($grid["columns"] as $key=>$value){
						$strListColumns="{ align:'center',";
						foreach($value as $key2=>$value2){
							if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable' || $key2=='aggregates' || $key2=='aggregatesrenderer'){
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

        $("#jqxgrid").on("bindingcomplete", function (event) {
            //$('#totalLbrWIKA').val(totalLbrWIKA);
            //$('#totalLbrWIKA').number(true,0);
            
        });

        $('#jqxgrid').jqxGrid('expandallgroups');
        
    });

    function UP_LEVEL(params){
        var IDUp=aDATAGRID[params]['id'];
        var paramsSent = { iID: IDUp };
        //console.log(paramsSent);
        
        $.ajax({
            url: "<?php echo base_url().'kkms/M_penjualan/Up_Level' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {

                if(data.Status=="OK"){
                    window.location="<?php echo base_url().'kkms/M_penjualan/?subpage='.$subpage;?>";
                    /*var tmpS = $("#jqxgrid").jqxGrid('source');
                    tmpS._source.url = '<?php echo base_url().'kkms/M_penjualan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val();
                    $("#jqxgrid").jqxGrid('source', tmpS);*/

                }
            },
            error: function (data) {
                // console.log(data);
                console.log('error');
            }
        });
        
        return false;
    }

    function DOWN_LEVEL(params){
        var IDUp=aDATAGRID[params]['id'];

        var paramsSent = { iID: IDUp };
        $.ajax({
            url: "<?php echo base_url().'kkms/M_penjualan/Down_Level' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {

                if(data.Status=="OK"){
                    window.location="<?php echo base_url().'kkms/M_penjualan/?subpage='.$subpage;?>";
                    /*
                    var tmpS = $("#jqxgrid").jqxGrid('source');
                    tmpS._source.url = '<?php echo base_url().'kkms/M_penjualan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val();
                    $("#jqxgrid").jqxGrid('source', tmpS);*/

                }
            },
            error: function (data) {
                // console.log(data);
                console.log('error');
            }
        });

        return false;
    }
    
    function DELETE_DETAIL(params){
        var IDDel=aDATAGRID[params]['id'];
        
        if (confirm("Yakin mau hapus data...?")) {
            var paramsSent = { iID: IDDel };
            $.ajax({
                url: "<?php echo base_url().'kkms/M_penjualan/deleteData' ?>",
                type: 'POST',
                data: paramsSent,
                dataType: 'json',
                success: function (data) {
                    
                    if(data.Status=="OK"){
                        window.location="<?php echo base_url().'kkms/M_penjualan/?subpage='.$subpage;?>";
                        /*var tmpS = $("#jqxgrid").jqxGrid('source');
                        tmpS._source.url = '<?php echo base_url().'kkms/M_penjualan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val();
                        $("#jqxgrid").jqxGrid('source', tmpS);*/

                    }
                },
                error: function (data) {
                    // console.log(data);
                    console.log('error');
                }
            });
        }
        return false;
    }
    
    function EDIT_DETAIL(params){
        var IDEdit = aDATAGRID[params]['id'];
        $('#idrec').val(IDEdit);
        $('#frmedit').submit();
        
    }
    function VIEW_DETAIL(params){
        params=aDATAGRID[params]['ID'];
        params=params.replace(/\//g, '_');
        $('#showAddNew').modal('show');
        return false;
    }
    
    
    
</script>
