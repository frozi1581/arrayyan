<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.material.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-redmond.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-start.css" type="text/css" />
	
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdraw.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxchart.core.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    
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
	/*jqxChart Style*/
	.jqx-chart-axis-text,
	.jqx-chart-label-text, 
	.jqx-chart-tooltip-text
	{
		fill: #333333;
		color: #333333;
		font-size: 9px;
		font-family: Verdana;
	}
	.jqx-chart-legend-text
	{
		fill: #333333;
		color: #333333;
		font-size: 11px;
		font-family: Verdana;
	}
	.jqx-chart-axis-description
	{
		fill: #555555;
		color: #555555;
		font-size: 11px;
		font-family: Verdana;
	}
	.jqx-chart-title-text
	{
		fill: #111111;
		color: #111111;
		font-size: 14px;
		font-weight: bold;
		font-family: Verdana;
	}
	.jqx-chart-title-description
	{
		fill: #111111;
		color: #111111;
		font-size: 12px;
		font-weight: normal;
		font-family: Verdana;
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
                <!------------  table ------------------------------->
                <!-- Start body content -->
				<?php 
					include("v_m_kbi_list_js.php");
					include("v_m_kbi_tabs_grid.php");
				?>
				
				
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
  
  
 <div class="modal fade" id="formLoaderGif" style="z-index:9999;width:260px;height:260px;overflow-x:hidden;overflow-y:hidden;">
    <div class="modal-dialog " style="z-index:9999;background:transparent;border:0px;width:100%;overflow-x:hidden;overflow-y:hidden;">
      <div class="modal-content" style="z-index:9999;background:transparent;border:0px;width:100%;margin-top:-30px;overflow-x:hidden;overflow-y:hidden;">
		<img src="<?php echo base_url(); ?>assets/images/lg.rotating-squares-preloader2-gif.gif"  style="z-index:9999;width:100%;" />
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 
<!-- modal   Upload -->
<div class="modal fade" id="show_upload" style="z-index:9999;display: none;margin-top: -115px;">
    <div class="modal-dialog " style="z-index:9999;border:0px;width:100%;overflow-x:hidden;overflow-y:hidden;">
      <div class="modal-content" style="z-index:9999;border:0px;width:100%;margin-top:-10px;overflow-x:hidden;overflow-y:hidden;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload Materi KBI</h4>
        </div>
          <form role="form" class="form-horizontal" id="fupload" method="post" name="fupload" action="<?php echo base_url().'hr/kbi-rev/M_KBI/f_upload'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                    <label for="txtTGL_BERLAKU" class="col-sm-3 control-label">Tgl. Berlaku</label>
                    <div class="form-group">
                        <div class="col-sm-3">  
                            <input type="text" id="txtTGL_BERLAKU" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($TGL_BERLAKU)?$TGL_BERLAKU:""; ?>" name="txtTGL_BERLAKU" class="form-control" required >
                        </div>
                    </div> 
                    <label for="txtIsMan" class="col-sm-3 control-label">Level</label>
                    <div class="form-group">
                            <div class="col-sm-5">
                                <select class="form-control" name="txtIsMan" id="txtIsMan" >
                                <?php $isMan=""; foreach ($DDListIsMan as $d1) { ?>
                                    <option  value="<?php echo $d1['id']; ?>" <?php
                                      if($isMan===$d1['id']){
                                          echo "selected";
                                      }
                                      ?> ><?php echo $d1['status'] ?></option>
                                <?php } ?>
                                </select>
                            </div>    
                    </div>
                    <label for="kbifilePeserta" class="col-sm-3 control-label">Attachment</label>
                    <div class="form-group">
                        <input type="file" name="kbifile" id="kbifile">
                        <p class="help-block"></p>
                    </div>
             </div> 
           <!-------------------- end form upload ---------------------------------------------------------------------->
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Upload</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Cetakan -->
<!-- modal   Upload -->
<div class="modal fade" id="show_upload_peserta" style="z-index:9999;display: none;margin-top: -115px;">
    <div class="modal-dialog " style="z-index:9999;border:0px;width:100%;">
      <div class="modal-content" style="z-index:9999;border:0px;width:100%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload Peserta KBI</h4>
        </div>
          <form role="form" class="form-horizontal" id="fupload_peserta" method="post" name="fupload_peserta" action="<?php echo base_url().'hr/kbi-rev/M_KBI/f_upload_peserta'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                    <label for="txtBL" class="col-sm-3 control-label"   >Periode</label>
                    <div class="form-group">
                        <div class="col-sm-2"> 
                            <input class="form-control" id="txtBL" style="width:120%;" name="txtBL" placeholder="mmyyyy"   onchange="javascript:get_periode(this)" maxlength="6" required>
                        </div> 
                    </div>
                    <label for="txtTGL_AWAL" class="col-sm-3 control-label">Tgl. Berlaku</label>
                    <div class="form-group">
                        <div class="col-sm-2">  
                            <input type="text" id="txtTGL_AWAL" placeholder="dd-mm-yyyy" style="width:140%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($TGL_AWAL)?$TGL_AWAL:""; ?>" name="txtTGL_AWAL" class="form-control" required >
                        </div><label for="txtTGL_AHIR" class="col-sm-1 control-label" style="width:10%;margin-left:  3px">s/d</label>
                        <div class="col-sm-2">  
                            <input type="text" id="txtTGL_AHIR" placeholder="dd-mm-yyyy" style="width:140%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($TGL_AHIR)?$TGL_AHIR:""; ?>" name="txtTGL_AHIR" class="form-control" required >
                        </div>
                    </div> 
                    <label for="kbifilePeserta" class="col-sm-3 control-label">Attachment</label>
                    <div class="form-group">
                        <input type="file" name="kbifilePeserta" id="kbifilePeserta">
                        <p class="help-block"></p>
                    </div>
             </div> 
           <!-------------------- end form upload ---------------------------------------------------------------------->
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUploadPeserta()">Upload</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Cetakan -->
    