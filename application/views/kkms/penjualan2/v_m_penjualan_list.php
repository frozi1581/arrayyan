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
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcalendar.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.grouping.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script>
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

    .datepicker{ z-index:99999 !important; }
 
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
                    /*
					switch($subpage){
						case 0:
							include("v_m_penjualan_list_js01.php");
							break;
						case 1:
							include("v_m_penjualan_list_js02.php");
							break;
						case 2:
							include("v_m_penjualan_list_js03.php");
							break;
						default:
							break;
					}
					*/
					include("v_m_penjualan_tabs_grid.php");
				?>
	
	        <?php
		       
	
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
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<form role="form" class="form-horizontal" id="frmedit" method="post" name="frmedit" action="<?php echo base_url().'kkms/M_penjualan/editData'?>" enctype="multipart/form-data" >
<input type="hidden" id="idrec" name="idrec" value=""/>
</form>

<div id='jqxwindow'>
    <div>Konfirmasi Penjualan Saham</div>
    <div>
        <div class="modal-body">
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Sekuritas</label>
                <div class="form-group">
                    <div class="col-sm-5">
                        <input type="text" id="txtSekuritas"  style="width:100%;" value="" name="txtSekuritas" class="form-control" readonly >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Emiten</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" id="txtEmiten"  style="width:100%;" value="" name="txtEmiten" class="form-control" readonly >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Jumlah Lembar Diajukan</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" id="txtJmlLbrPengajuan"  style="width:100%;text-align: right;" value="" name="txtJmlLbrPengajuan" class="form-control" readonly >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Harga Max Diajukan</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" id="txtMaxHrgPengajuan"  style="width:100%;text-align: right;" value="" name="txtMaxHrgPengajuan" class="form-control" readonly >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Tanggal Terjual</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input id="tgldokId" type="text" value="<?php echo isset($TglDok)?$TglDok:""; if ($this->session->flashdata('message')) { $data=$this->session->flashdata('message'); if (isset($data['TglDok'])) { echo $data['TglDok']; } }?>" class="form-control tgl-dok" name="txtTglDok" />
                            <span class="input-group-btn">
						        <button type="button" class="btn btn-primary" data-toggle="datepicker" data-target-name="txtTglDok"><span class="glyphicon glyphicon-calendar"></span></button></span>
                        </div>
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Jumlah Lembar Terjual</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" id="txtJmlLbr"  style="width:100%;text-align: right;" value="" name="txtJmlLbr" class="form-control" required >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="box-body">
                <label for="jml" class="col-sm-4 control-label">Terima Dana Dari Sekuritas</label>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" id="txtTerimaDana"  style="width:100%;text-align: right;" value="" name="txtTerimaDana" class="form-control" required >
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Submit</button>
                    <input type="hidden" id="dmlmode" value="addnew" />
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div id='jqxwindow2'>
    <div>Cetak Laporan harian</div>
    <div>
        <div class="modal-body">
            <div class="box-body">
                <label for="tgl" class="col-sm-4 control-label">Tanggal</label>
                <div class="form-group">
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input id="tgldokId" type="text" value="" class="form-control tgl-dok" name="txtTglDok" />
                            <span class="input-group-btn">
						        <button type="button" class="btn btn-primary" data-toggle="datepicker" data-target-name="txtTglDok"><span class="glyphicon glyphicon-calendar"></span></button></span>
                        </div>
                    </div>
                    <div class="col-sm-1" id="msgNIP">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Submit</button>
                    <input type="hidden" id="dmlmode" value="addnew" />
                </div>
            </div>
        </div>
    </div>
</div>
-->


<script type="text/javascript">
    $(document).ready(function() {
        
        $('[data-toggle=datepicker]').each(function() {
            var target = $(this).data('target-name');
            var t = $('input[name=' + target + ']');
            t.datepicker({
                dateFormat: 'dd/mm/yy',
                theme: 'classic'
            });
            console.log('1');
            $(this).on("click", function() {
                t.datepicker("show");
                console.log('2');
            });
        });

        $(".tgl-dok").datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateText) {

                //console.log(dateText);

            }
        });
        
    } );
</script>