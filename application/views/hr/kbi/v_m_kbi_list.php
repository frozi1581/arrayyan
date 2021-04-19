<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lookupbox.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.lookupbox.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />

<?php

	
if(isset($list_js_plugin)){
    foreach ($list_js_plugin as $list_js) {?>
        <!-- JS plugin -->
        <script src="<?php echo base_url('assets/global/plugins/bower_components/'.$list_js); ?>"></script>
<?php
    }
	
	
}
?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.darkblue.css" type="text/css" />
	
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.grouping.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcombobox.js"></script> 
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtabs.js"></script> 
	
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
 <style type="text/css">
	.modal {
	  max-height: calc(100% - 100px);
	  position: fixed;
		top: 50%;
		left: 50%;
	  transform: translate(-50%, -50%);
	}
</style> 

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
        
		
<script type="text/javascript">
	var iQuestions = [];
	var iCurrRec = 0;
	
	var iUserAnswers = [];
	
	$(document).ready(function () {
			
			var ivalue='<?php echo $ivalue;?>';
			
			
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
			    url: '<?php echo base_url().'hr/kbi/M_Kbi/getGridData/?ivalue='.$ivalue; ?>',
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
						console.log(data[0].Rows[0].ID);
						//changeDetailGrid(data[0].Rows[0].ID);
					}
				}
				
            };		
		    var dataadapter = new $.jqx.dataAdapter(source1);
			
			var theme = 'darkblue';
			
			// initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '100%',
				height: '100%',
				columnsheight:'40px',
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
                    var doKBIButton = $(buttonTemplate);
                    var editButton = $(buttonTemplate);
                    var deleteButton = $(buttonTemplate);
                    var cancelButton = $(buttonTemplate);
                    var updateButton = $(buttonTemplate);
                    container.append(doKBIButton);
                    toolBar.append(container);
                    doKBIButton.jqxButton({cursor: "pointer", enableDefault: false,  height: 25, width: 25 });
                    doKBIButton.find('div:first').addClass(toTheme('jqx-icon-survey'));
                    doKBIButton.jqxTooltip({ position: 'bottom', content: "KBI"});
                    var updateButtons = function (action) {
                        switch (action) {
                            case "Select":
                                doKBIButton.jqxButton({ disabled: false });
                                
                                break;
                            case "Unselect":
                                doKBIButton.jqxButton({ disabled: false });
                                
                                break;
                            case "Edit":
                                doKBIButton.jqxButton({ disabled: true });
                                
                                break;
                            case "End Edit":
                                doKBIButton.jqxButton({ disabled: false });
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
                    doKBIButton.click(function (event) {
                        if (!doKBIButton.jqxButton('disabled')) {
							
							var data = $('#jqxgrid').jqxGrid('getrowdata', rowIndex);
							var nama = data["NAMA_DINILAI"];
							var stdinilai = data["ST_YG_DINILAI"];
                            $('#lblNamaYgDinilai').html(nama);
							$('#lblStYgDiNilai').html(stdinilai);
							
							var textSTDate = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "ST_DATE");
							var textENDDate = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "END_DATE");
							var stpartisipasi = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "PARTISIPASI");
							
							if(stpartisipasi=="0")
							{
								
								var arrdata = {};
								arrdata["BL"] = data["BL"];
								arrdata["ST_DATE"] = textSTDate;
								arrdata["END_DATE"] = textENDDate;
								arrdata["EMPLOYEE_ID"] = data["EMPLOYEE_ID"];
								arrdata["EMPLOYEE_ID2"] = data["EMPLOYEE_ID2"];
								
								//console.log(arrdata);
								
								var jsonData = arrdata;
								
								$.ajax({
									url:  '<?=base_url()?>hr/kbi/M_Kbi/getSurveyData/',
									 type: 'GET',
									 dataType: 'json',
									 data: jsonData,
									 error: function ( data ) {
										console.log(data);
										
										return;
									 },
									 success: function (data) {
										 console.log(data);
										 if(data[0]["STATUS"]=="0"){
											iQuestions=data;
											//console.log(iQuestions);
											iCurrRec = 0;
											$('#formInputEdit').modal('show');
											displayQuestion();
										}else{
											alert('Penilaian tersebut sudah lakukan....');
										}
										return;
									 }
									 
								});
							}else{
								alert('Anda sudah selesai melakukan penilaian terhadap Pegawai ini, Terima Kasih....');
							}
                        }
                    });
                    
                    
                },
				source: dataadapter,
                theme: theme,
				filterable:true,
				showfilterrow: false,
				pageable: true,
				pagesize: 10,
				sortable: false,
                virtualmode: true,
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
				
				//console.log(data["ID"]);
				//changeDetailGrid(data["ID"]);
				
			}); 
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			  //var target = $(e.target).attr("href") // activated tab
			  var ivalue = $(e.target).attr("value");
			  $('#jqxgrid').html('');
			  window.location.href = '<?php echo base_url().'hr/kbi/M_Kbi/'?>';
			  
			});
			
			$("#cancelButton").click(function(){
				$('#formInput').fadeOut('slow');
			}); 
			
			$("#savebutton").click(function(){
				console.log($('#txtnospprbdari1').val());
			}); 
				
			
	});
	
	var displayQuestion = function (){
		if(iCurrRec>0){
			
			var kpid=iQuestions[iCurrRec-1]["KP_ID"];
			var ikid= $('input[name=rbtAnswers]:checked').val(); 
			
		}
		
		if(ikid == null && iCurrRec>0)
		{
			alert('Penilaian harus diisi terlebih dahulu!!!!');
			return false;
		}else{
			if(iCurrRec>0){
				//set answers to var first 
				iUserAnswers[kpid]=ikid;
				
				if(iCurrRec>=iQuestions.length){
					//console.log('Saat nya save....');
					var rowIndex = $('#jqxgrid').jqxGrid('getselectedrowindexes');
					if (rowIndex.length > 0)
					{
						// returns the selected row's data.
						var data = $('#jqxgrid').jqxGrid('getrowdata', rowIndex[0]);
						var nama = data["NAMA_DINILAI"];
						var textSTDate = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "ST_DATE");
						var textENDDate = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "END_DATE");
						var stpartisipasi = $('#jqxgrid').jqxGrid('getcelltext', rowIndex, "PARTISIPASI");
						var arrdata = {};
						arrdata["BL"] = data["BL"];
						arrdata["ST_DATE"] = textSTDate;
						arrdata["END_DATE"] = textENDDate;
						arrdata["EMPLOYEE_ID"] = data["EMPLOYEE_ID"];
						arrdata["EMPLOYEE_ID2"] = data["EMPLOYEE_ID2"];
						arrdata["JAWABAN"]=iUserAnswers;
						
						$.ajax({
						url:  '<?=base_url()?>hr/kbi/M_Kbi/saveData/',
						 type: 'GET',
						 dataType: 'json',
						 data: arrdata,
						 error: function ( data ) {
							console.log(data);
							return;
						 },
						 success: function (data) {
							//console.log(data);	
							if(data["STATUS"]=="BERHASIL")
							{
								window.location.href='<?=base_url()?>hr/kbi/M_Kbi/';
							}else{
								alert('Error Save Data!!!');
								console.log(data);
							}
							return;
						 }
						 
					});
					}
					
					
					
				}
			}
			
			if(iCurrRec>=0 && iCurrRec<=(iQuestions.length-1)){
				//display next questions
				$('#lblNoQuestions').html(iQuestions[iCurrRec]["NO_URUT"]+".");
				$('#dvQuestions').html('<b>'+iQuestions[iCurrRec]["JENIS_KRITERIA_PENILAIAN"]+' : </b><br/>' +iQuestions[iCurrRec]["KRITERIA_PENILAIAN"]);
				$("#dvAnswers").html('');
				var strTblAnswers="<div class='row'>";
				$.each(iQuestions[iCurrRec]["JAWABAN"], function(i, item) {
					//console.log(i);
					strTblAnswers=strTblAnswers+"<div class='col-md-1'><input type='radio' name='rbtAnswers' value='"+i+"'/></div>";
					strTblAnswers=strTblAnswers+"<div class='col-md-11' style='white-space:normal;word-wrap:break-word;'>"+item+"</div>";
				});	
				strTblAnswers=strTblAnswers+"</div>";
				$('#dvAnswers').append(strTblAnswers);
				iCurrRec++;
			}
			return true;
		}
	}
	
	
	
	
</script>

                <!------------  table ------------------------------->
                <!-- Start body content -->
				 <ul class="nav nav-tabs">
				  <li class="<?php echo (substr($ivalue,0,1)=='1')?'active':'';?>"><a data-toggle="tab" href="#menu1" value="11">1. Tugas Menilai</a></li>
				  <li class="<?php echo (substr($ivalue,0,1)=='2')?'active':'';?>"><a data-toggle="tab" href="#menu2" value="21">2. Hasil Penilaian Saya (Coming soon)</a></li>
				  
				</ul>
				
				 
				<div class="tab-content">
				  <div id="content1" class="tab-pane fade in active">
					<table cellpadding="2" cellspacing="2" border="0" style="width:100%;">
						<tr>
							<td style="width:100%;"><div id="jqxgrid" style="margin-top: 1px;width: 100%; " > </div></td>
						</tr>
					</table>
				  </div>
				</div>
				
			<!-- /.body-content -->
<!--/ End body content -->
                <!------------ end table ---------------------------->
                
                </div>    
              
            
          </div>
          <!-- /.box -->
       
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
      
    </section
    >
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <div class="modal fade" id="formInputEdit" style="display: none;height:650px;width:900px;">
    <div class="modal-dialog " style="width:100%;height:900px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">KBI <i>(Key Behaviour Indicator)</i></h4><br/>
			<h5 class="modal-title">Yang Di Nilai : <label id="lblNamaYgDinilai"></label> (<label id="lblStYgDiNilai"></label>)</i></h5>
			
        </div>
		
        <form role="form" class="form-horizontal" action="#" style="height:500px;">
			<div class="modal-body">
				
				<div class="form-group">
					<label class="col-sm-2 control-label" id="lblNoQuestions"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								<div id="dvQuestions"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-10">
								<div id="dvAnswers" style='white-space:normal;word-wrap:break-word;'></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-12">
								
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<div class="row">
							<button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Batalkan Semua</button>
							<button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="displayQuestion()">Berikutnya</button>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<input type="hidden" id="txtvalue" value="11" />
					<input type="hidden" id="txtrowactive" value="" />
					<input type="hidden" id="txtjtrans" value="12" />
					<input type="hidden" id="txttrxid" value="" />
				</div>        
			</div>
			<div id="dvopenLU" style="width:100%;height:520px;top:0px;left:0px;position:absolute;background-color: #ffffff;border:1px solid grey;z-index:999;display:none;">
				<div  id="jqxgridLU" style="margin-top: 1px;width: 100%; " > </div>
			</div>
			<div id="dvopenLU2" style="width:800px;height:520px;top:0px;left:0px;position:absolute;background-color: #ffffff;border:1px solid grey;z-index:999;display:none;">
				<div  id="jqxgridLU2" style="margin-top: 1px;width: 100%; " > </div>
			</div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

    