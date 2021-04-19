<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lookupbox.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.lookupbox.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
<!----

--->
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.base.css" type="text/css" />
    
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmaskedinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxswitchbutton.js"></script>
	

	<script type="text/javascript">
		
		
		$(document).ready(function () {
			var theme='energyblue';
			
			$("#jqxNamaVendor").jqxInput(
			{
				theme: theme,
				width: '100%',
				height: 25,
				source: function (query, response) {
					var dataAdapter = new $.jqx.dataAdapter
					(
						{
							datatype: "json",
							datafields: [
								{ name: 'NAMA', type: 'string'}
							],
							url: '<?php echo base_url().'shared/M_vendor/getVendorLookup/'?>',
						},
						{
							autoBind: true,
							formatData: function (data) {
								data.query = query;
								return data;
							},
							loadComplete: function (data) {
								if (data.length > 0) {
									response($.map(data, function (item) {
										return item.NAMA;
									}));
								}
							}
						}
					);
				}
			}); 
			
			$("#jqxNPWP").jqxMaskedInput({ theme: theme, width: 160, height: 25, mask: '##.###.###.#-###.###'});
			$("#jqxAlamat").jqxInput({ theme: theme, width: '100%', height: 25});
			$("#jqxTelp").jqxInput({ theme: theme, width: 100, height: 25});
			$("#jqxFax").jqxInput({ theme: theme, width: 100, height: 25});
			
			$('#btnBerelasi').jqxSwitchButton({ theme: theme, height: 27, width: 120,  checked: true , onLabel:'Ya', offLabel:'Tidak'});
			
			
		});
        </script>
		
 
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
    
		
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display:none;">
      <h1>
        <small><?php echo $title; ?></small>
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>&nbsp;
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
              </div>
             <?php } ?>
           <form role="form" id="formInput" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
               <div class="box-body">
                    <div class="form-group">
                            <label for="nama_vendor" class="col-sm-2 control-label">Nama Vendor</label>
                            <div class="col-sm-4">
                                <input id="jqxNamaVendor" />
                            </div>
                    </div>  
                    
					<div class="form-group">
                            <label for="npwp" class="col-sm-2 control-label">NPWP</label>
                            <div class="col-sm-4">
                                <input id="jqxNPWP" />
                            </div>
                    </div>  
					
					<div class="form-group">
                            <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-4">
                                <input id="jqxAlamat" />
                            </div>
                    </div>  
					
					<div class="form-group">
                            <label for="telp" class="col-sm-2 control-label">Telp</label>
                            <div class="col-sm-4">
                                <input id="jqxTelp" />
                            </div>
                    </div>  
					
					<div class="form-group">
                            <label for="fax" class="col-sm-2 control-label">Fax</label>
                            <div class="col-sm-4">
                                <input id="jqxFax" />
                            </div>
                    </div>  
					
					<div class="form-group">
                            <label for="berelasi" class="col-sm-2 control-label">Berelasi</label>
                            <div class="col-sm-4">
								<div class="settings-setter"><div id="btnBerelasi"></div></div>
                            </div>
                    </div> 
					
					<div class="form-group">
						 <label for="berelasi" class="col-sm-2 control-label"></label>
						<div class="col-sm-2">
                            <button id="savebutton" type="button" class="btn btn-primary" >Simpan</button>
							<button id="cancelButton" type="button" class="btn btn-primary" onclick="cancelButtonEvt()">Batal</button>
						</div>
                    </div> 
                </div>
				<script type="text/javascript">
					var cancelButtonEvt = function(event){
						window.location.href='<?=base_url()?>shared/M_vendor';
					}
					
				</script>
        

                <!------------  table ------------------------------->
                <!-- Start body content -->
<div class="body-content animated fadeIn">


</div><!-- /.body-content -->
<!--/ End body content -->
                <!------------ end table ---------------------------->
                
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

    