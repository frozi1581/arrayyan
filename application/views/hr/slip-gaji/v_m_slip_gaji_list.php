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
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxprogressbar.js"></script>
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
					include("v_m_slip_gaji_list_js.php");
					include("v_m_slip_gaji_tabs_grid.php");
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
  
  <?php
		/*switch($ivalue)
		{
			case "11":
			case "12":
				include("v_m_trans_produksi_form00.php");
				break;
			case "61":
			case "21":
				include("v_m_trans_produksi_form01.php");
				break;
			
		}
		*/		
	?>
  
  

    