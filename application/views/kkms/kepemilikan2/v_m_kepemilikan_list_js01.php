<script type="text/javascript">
	$(document).ready(function () {
        var theme = 'darkblue';
        var totalLbrWIKA = 0;
        var totalLbrWTON = 0;
        var totalLbrWEGE = 0;
        var totalLbrWR = 0;
        var totalLbrWIKON = 0;
        
        $('#subtabs').jqxTabs({ theme:'material', width: '100%', height: '100%', position: 'top'});

        $("#cancelButton").click(function(){
            $('#formInput').fadeOut('slow');
        });
        
        var renderACT = function(ROW){
            aDATAGRID=dataadapter['_source']['records'];
            var dataRecord = dataadapter['_source']['records'][ROW];//$("#jqxgrid").jqxGrid("getrowdata", row_);
            //console.log(dataRecord);
            /*
            var btnEdit = '<button id="editRowButton" type="button" value="" title="Edit" onclick="EDIT_DETAIL('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-pencil fa-fw">&nbsp;</i></button>';

            var btnDel = '<button id="delRowButton" type="button" value="" title="Hapus" onclick="DELETE_DETAIL('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-trash fa-fw">&nbsp;</i></button>';

            var btnPrint = '<button id="printRowButton" type="button" value="" title="Print" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-file-pdf fa-fw">&nbsp;</i></button>';

            var btnCombine = '<button id="combineRowButton" type="button" value="" title="Menggabungkan 2 Data atau lebih yang dianggap duplikat" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-people-arrows fa-fw">&nbsp;</i></button>';
            
            var container = '<div style="text-align:center;width:99%;align:center;display: inline-block">'+btnEdit+btnDel+btnView+btnPrint+btnCombine+'</div>';
            */

            var btnPrint = '<button id="printRowButton" type="button" value="" title="Print" onclick="PRINT_KARTU('+ROW+')" style="cursor: pointer; padding: 3px; margin:1px; float: left; height: 25px; width: 30px;" role="button" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" aria-disabled="false"><i class="fal fa-file-pdf fa-fw">&nbsp;</i></button>';
            
            var container = '<div style="text-align:center;width:99%;align:center;display: flex;justify-content:center;">'+btnPrint+'</div>';
            
            html = container;
            return html;
        };

        var renderAggWIKA = function (aggregates, column, element) {
            var renderstring = "<div id='totalLbrWIKA' class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: right; width: 100%; height: 100%; tex-align:right;margin:1px;font-weight: bold;background: transparent;'>" + $.number(totalLbrWIKA,0) + "</div>";

            return renderstring;
        };
        
        var renderAggWTON = function (aggregates, column, element) {
            var renderstring = "<div id='totalLbrWTON' class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: right; width: 100%; height: 100%; tex-align:right;margin:1px;font-weight: bold;background: transparent;'>" + $.number(totalLbrWTON,0) + "</div>";
            
            return renderstring;
        };

        var renderAggWEGE = function (aggregates, column, element) {
            var renderstring = "<div id='totalLbrWEGE' class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: right; width: 100%; height: 100%; tex-align:right;margin:1px;font-weight: bold;background: transparent;'>" + $.number(totalLbrWEGE,0) + "</div>";
            return renderstring;
        };

        var renderAggWR = function (aggregates, column, element) {
            var renderstring = "<div id='totalLbrWR' class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: right; width: 100%; height: 100%; tex-align:right;margin:1px;font-weight: bold;background: transparent;'>" + $.number(totalLbrWR,0) + "</div>";
            return renderstring;
        };

        var renderAggWIKON = function (aggregates, column, element) {
            var renderstring = "<div id='totalLbrWIKON' class='jqx-widget-content jqx-widget-content-" + theme + "' style='float: right; width: 100%; height: 100%; tex-align:right;margin:1px;font-weight: bold;background: transparent;'>" + $.number(totalLbrWIKON,0) + "</div>";
            return renderstring;
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
                url: '<?php echo base_url().'kkms/M_kepemilikan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val(),
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
                        totalLbrWIKA = data[0].TotalLbrWIKA;
                        totalLbrWTON = data[0].TotalLbrWTON;
                        totalLbrWEGE = data[0].TotalLbrWEGE;
                        totalLbrWR = data[0].TotalLbrWR;
                        totalLbrWIKON = data[0].TotalLbrWIKON;
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
                renderToolbar: function(toolBar)
                {

                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var btnAddNew = '<button id="addrowbutton" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-plus fa-lg fa-fw">&nbsp;</i>Add New</button>';
                    var btnExpPDF = '<button id="btnExpPDF" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-file-pdf fa-lg fa-fw">&nbsp;</i>Export To PDF</button>';

                    var btnExpXLS = '<button id="btnExpXLS" type="button" value="" style="cursor:pointer;padding: 3px; margin: 2px;float:left;"><i class="fal fa-file-excel fa-lg fa-fw">&nbsp;</i>Export To Excel</button>';

                    var addNew = $(btnAddNew);
                    var expPDF = $(btnExpPDF);
                    var expXLS = $(btnExpXLS);

                    //addNew.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    expPDF.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    expXLS.jqxButton({theme:'ui-start', width:'130px', height:'35px'});
                    //container.append(addNew);
                    container.append(expPDF);
                    container.append(expXLS);
                    toolBar.append(container);
                    /*addNew.click(function(event){
                        clearAllField();
                        $('#dmlmode').val('addnew');
                        $('#lblheaderdml').html('Add New Data');
                        $('#txtNIP').prop('readonly',false);
                        $('#showAddNew').modal('show');
                        
                        return false;
                    });*/
                    expPDF.click(function (event) {
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
                showfilterrow: true,
                pageable: true,
                pagesize: 100,
                pagesizeoptions: ['10', '20', '50','100','1000','10000'],
                sortable: false,
                virtualmode: true,
                altrows:true,
                columnsresize: true,
                selectionmode: 'singlerow',
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
            $('#totalLbrWTON').html(totalLbrWTON);
            $('#totalLbrWTON').number(true,0);
            $('#totalLbrWEGE').html(totalLbrWEGE);
            $('#totalLbrWEGE').number(true,0);
            $('#totalLbrWR').html(totalLbrWR);
            $('#totalLbrWR').number(true,0);
            $('#totalLbrWIKON').html(totalLbrWIKON);
            $('#totalLbrWIKON').number(true,0);
        });

        
        //$('#totalLbrWIKA').val(totalLbrWIKA);
        //$('#totalLbrWIKA').number(true,0);
        $('#totalLbrWTON').html(totalLbrWTON);
        $('#totalLbrWTON').number(true,0);
        $('#totalLbrWEGE').html(totalLbrWEGE);
        $('#totalLbrWEGE').number(true,0);
        $('#totalLbrWR').html(totalLbrWR);
        $('#totalLbrWR').number(true,0);
        $('#totalLbrWIKON').html(totalLbrWIKON);
        $('#totalLbrWIKON').number(true,0);

        $('.lbrsaham').number(true,0);
        
        $( "#txtNIP" ).focusout(function() {
            var dmlmode = $('#dmlmode').val();
            var nip = $('#txtNIP').val();
            var paramsSent = { iType : 'nip', inip: nip};
            $('#msgNIP').val('');
            if(dmlmode=='addnew'){
                $.ajax({
                    url: "<?php echo base_url().'kkms/M_kepemilikan/validatorFld' ?>",
                    type: 'POST',
                    data: paramsSent,
                    dataType: 'json',
                    success: function (data) {

                        if(data.Status!=="OK"){
                            $('#msgNIP').html('<i class="fal fa-times fa-lg fa-fw" aria-hidden="true"></i>&nbsp;' + data.Message);
                            $('#btnModalSubmit').prop('disabled', true);
                        }else{
                            $('#msgNIP').html('<i class="fal fa-check-circle fa-lg fa-fw" aria-hidden="true"></i>&nbsp;' + data.Message);
                            $('#btnModalSubmit').prop('disabled', false);
                        }
                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
            }
            
        });

        
        
    });

    function DELETE_DETAIL(params){
        params=aDATAGRID[params]['ID'];
        params=params.replace(/\//g, '_');
        if (confirm("Yakin mau hapus data...?")) {
            var paramsSent = { iID: params };
            $.ajax({
                url: "<?php echo base_url().'kkms/M_kepemilikan/deleteData' ?>",
                type: 'POST',
                data: paramsSent,
                dataType: 'json',
                success: function (data) {
                    
                    if(data.Status=="OK"){
                        clearAllField();
                        $('#showAddNew').modal('hide');
                        $('#txtfldorderby').val('nama asc');
                        var tmpS = $("#jqxgrid").jqxGrid('source');
                        tmpS._source.url = '<?php echo base_url().'kkms/M_kepemilikan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val();
                        $("#jqxgrid").jqxGrid('source', tmpS);

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
    
    function PRINT_KARTU(params){
        params=aDATAGRID[params]['ID'];
        params=params.replace(/\//g, '_');
        var paramsSent = { iID: params };
        console.log(paramsSent);

        window.open('<?php echo base_url()."kkms/M_kepemilikan/genKartuKepemilikan?inip=";?>'+params,'_blank');
        
        return false;
    }
    function VIEW_DETAIL(params){
        params=aDATAGRID[params]['ID'];
        params=params.replace(/\//g, '_');
        $('#showAddNew').modal('show');
        return false;
    }
    
    function clearAllField(){
        $('#txtNIP').val('');
        $('#txtNAMA').val('');
        $('#txtUK').val('');
        $("input[name='txtSEKURITAS[]']").val('');
        $("input[name='txtLBRSAHAM[]']").val('');
    }
    
    function submitUpload(){
        var dmlmode = $('#dmlmode').val();
        var nip = $('#txtNIP').val();
        var nama = $('#txtNAMA').val();
        var uk = $('#txtUK').val();
        var emiten = $("input[name='txtEMITEN[]']").map(function(){return $(this).val();}).get();
        var sekuritas = $("input[name='txtSEKURITAS[]']").map(function(){return $(this).val();}).get();
        var lbrsaham = $("input[name='txtLBRSAHAM[]']").map(function(){return $(this).val();}).get();
        var paramsSent = { idmlmode: dmlmode, inip: nip, inama: nama, iuk:uk, iemiten:emiten, isekuritas:sekuritas, ilbrsaham:lbrsaham };
        
        $.ajax({
            url: "<?php echo base_url().'kkms/M_kepemilikan/saveData' ?>",
            type: 'POST',
            data: paramsSent,
            dataType: 'json',
            success: function (data) {
                if(data.Status=="OK"){
                    clearAllField();
                    $('#showAddNew').modal('hide');
                    $('#txtfldorderby').val('created_date desc');
                    var tmpS = $("#jqxgrid").jqxGrid('source');
                    tmpS._source.url = '<?php echo base_url().'kkms/M_kepemilikan/getGridData/'; ?>?ifldorderby=' + $('#txtfldorderby').val();
                    $("#jqxgrid").jqxGrid('source', tmpS);
                    
                }
            },
            error: function (data) {
                // console.log(data);
                console.log('error');
            }
        });
    }
    
</script>
