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
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
 
 
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
 <style type="text/css">
        .jqx-grid-header
        {
            height: 100px !important;vertical-align:middle;
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
          <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                 <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
                  </div>
                 <?php } ?>
                <!--    <button type="button" id="btnBatal" class="btn btn-primary" onclick="addRow()" style="margin-top:10px;margin-bottom:10px;margin-left:10px;">Tambah Data</button>
                -->   
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
                <script type="text/javascript">
                    //--------------------------- info pasar List ---------------
                        var doProses = function(param){
                             $.ajax({
                              url: "<?php echo base_url().'hr/proses_bandrol/M_bandroll/getProses'?>",
                              type: 'POST',
                              data: {json: JSON.stringify(param)},
                             // dataType: 'json',
                             dataType: 'text',
                              success: function (data) {
                                  document.location.href ="<?php echo base_url().'hr/proses_bandrol/M_bandroll/';?>";
                                  //window.location.reload(true);
                              },
                              error: function (data) {
                                  console.log('error');
                              }
                          });
                        };
                        var doCabut = function(param){
                             $.ajax({
                              url: "<?php echo base_url().'hr/proses_bandrol/M_bandroll/getCabut'?>",
                              type: 'POST',
                              data: {json: JSON.stringify(param)},
                             // dataType: 'json',
                             dataType: 'text',
                              success: function (data) {
                                  document.location.href ="<?php echo base_url().'hr/proses_bandrol/M_bandroll/';?>";
                                  //window.location.reload(true);
                              },
                              error: function (data) {
                                  console.log('error');
                              }
                          });
                        };
                </script>
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>Skbdn/save_spb" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
               <div class="col-md-12">
                
                <div style="margin-top: 1px" id="jqxlistbox"></div>
            </div>    
        </div>    
<script type="text/javascript">
	$(document).ready(function () {
            var source =
            {   datatype: "json",
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
                url: '<?php echo base_url().'hr/proses_bandrol/M_bandroll/getGridData/'?>',
                root: 'Rows',
                id: '<?php echo $grid["source"]["ID"]; ?>',
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
                        console.log(data);
                        source.totalrecords = data[0].TotalRows;	

                        if(data[0].ErrorMsg!=""){
                                alert(data[0].ErrorMsg);
                        }
                    }
                }
            };
            var dataadapter = new $.jqx.dataAdapter(source, {
                loadError: function(xhr, status, error)
                {
                   // alert(status);
                }
                }
            );
            var renderer2 = function(APP){
                var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", APP);
                html='<span style="background-color: #4dffff;position: relative;top: 5px;left: 5px;">Belum Approve</span>';
                if(dataRecord.APP==='1')
                    html='<span style="background-color:#55ff00;position: relative;top: 5px;left: 5px;">Baik</span>';
                if(dataRecord.APP==='2')
                    html='<span style="background-color: #ff4000;position: relative;top: 5px;left: 5px;">Rusak</span>';
                if(dataRecord.APP==='3')
                    html='<span style="background-color: #6666ff;position: relative;top: 5px;left: 5px;">Dalam Perbaikan</span>';
                if(dataRecord.APP==='4')
                    html='<span style="background-color: #1a1a00;position: relative;top: 5px;left: 5px;">Tidak Dapat Diperbaiki</span>';
                return html;
            };
            var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '99%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 15,
                autoheight:false,
                height:550,
                rowsheight: 28,
                sortable: true,
                virtualmode: true,
                altrows:true,
                //selectionmode: 'checkbox',
                showtoolbar: true,
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 2px;'></div>");
                    toolbar.append(container);
                    strNew = '<button id="addrowbutton" name="addrowbutton" style="margin-top:2px;margin-right:5px;height:20px;border:1px;background:green;" title="Proses Bandrol">Proses</button>';
                    strEdit = '<button id="editrowbutton" name="editrowbutton" style="margin-top:2px;margin-right:0px;height:20px;border:1px;background:green;" title="Cabut Bandrol">Cabut</button>';
                    strDel = '<button id="deleterowbutton" name="deleterowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Delete"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-delete jqx-icon-delete-darkblue"></div></button>';
                /*    strDelAll = '<button id="clearrowbutton" name="clearrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Delete All Item"><i class="fa fa-trash-o fa-lg" style="font-size:20px;color:white;"></i></button>';
		  */  container.append(strNew);container.append(strEdit);//container.append(strDel);//container.append(strDelAll);
                    $("#addrowbutton").on('click', function () {
                      
                      var selected_row=$("#jqxgrid").jqxGrid('getselectedrowindex');
                      var bl_select = $('#jqxgrid').jqxGrid('getcellvalue', selected_row, 'BL');
                      doProses(bl_select);
                       return false;
                    });
                    $("#editrowbutton").on('click', function () {
                      var selected_row=$("#jqxgrid").jqxGrid('getselectedrowindex');
                      var bl_select = $('#jqxgrid').jqxGrid('getcellvalue', selected_row, 'BL');
                      doCabut(bl_select);
                       return false;
                    });
                },
                rendergridrows: function () {
                return dataadapter.records;
                },					
                columns: [
                        <?php 
                                      
                                $i=0;
                                echo " { align:'center',text:'PERIODE',datafield:'BL',width:'8%',cellsalign:'left',hidden:false},"; 
                                echo " { align:'center',text:'TANGGAL',datafield:'TANGGAL',width:'20%',cellsalign:'left',hidden:false},";
                                echo "  { align:'left',text:'STATUS',datafield:'TOT',width:'10%',cellsalign:'left',hidden:false},";
                           //     echo "  { align:'left',text:'JAM',datafield:'TIMERECORD',width:'10%',cellsalign:'left',hidden:false},";
                                echo "  { align:'center',text:'FLAG_DATA',datafield:'FLAG_DATA',width:'5%',hidden:true}";
                        ?>
                  ]
            });
	});
</script>
       <!-- Start body content -->
<div class="body-content animated fadeIn">
</div><!-- /.body-content -->
                </div>    
              
            </form>
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

    