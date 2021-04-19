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
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-aqua">
                      <i class="far fa-building"></i>
                  </span>
                  <div class="info-box-content">
                        <span class="info-box-text">PT WIJAYA KARYA, TBK</span>
                        <span class="info-box-number" id="lbrwika">0</span>
                      <small><i>lembar</i></small>
                  </div>
              </div>
          </div>

          <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-blue">
                      <i class="far fa-archway"></i>
                  </span>
                  <div class="info-box-content">
                      <span class="info-box-text">PT WIKA BETON, TBK</span>
                      <span class="info-box-number" id="lbrwton">0</span>
                      <small><i>lembar</i></small>
                  </div>
              </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-green">
                      <i class="far fa-warehouse"></i>
                  </span>
                  <div class="info-box-content">
                      <span class="info-box-text">PT WIKA GEDUNG, TBK</span>
                      <span class="info-box-number"  id="lbrwege">0</span>
                      <small><i>lembar</i></small>
                  </div>
              </div>
          </div>

          <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-red">
                      <i class="far fa-house"></i>
                  </span>
                  <div class="info-box-content">
                      <span class="info-box-text">PT WIKA REALTY</span>
                      <span class="info-box-number" id="lbrwr">0</span>
                      <small><i>lembar</i></small>
                  </div>
              </div>
          </div>

          <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-yellow">
                      <i class="far fa-construction"></i>
                  </span>
                  <div class="info-box-content">
                      <span class="info-box-text">PT WIKON</span>
                      <span class="info-box-number" id="lbrwikon">0</span>
                      <small><i>lembar</i></small>
                  </div>
              </div>
          </div>
          
      </div>
      
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
                <!------------  table ------------------------------->
                <!-- Start body content -->
            
            <table id="tblKepemilikan" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>ACTIONS</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>WIKA</th>
                    <th>WTON</th>
                    <th>WEGE</th>
                    <th>WR</th>
                    <th>WIKON</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ACTIONS</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Kerja</th>
                    <th>WIKA</th>
                    <th>WTON</th>
                    <th>WEGE</th>
                    <th>WR</th>
                    <th>WIKON</th>
                </tr>
                </tfoot>
            </table>
            
            
            
	
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
      
    </section
    >
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<script type="text/javascript">
    function genLapKepemilikan(idrec){
        window.open('https://kkms.wika-beton.net/kkms/M_kepemilikan2/genKartuKepemilikan?inip=' + idrec);
    }
    
    $(document).ready(function() {
        $('#tblKepemilikan').DataTable( {
            pageLength: 10,
            filter: true,
            deferRender: true,
            "ajax": 'https://kkms.wika-beton.net/kkms/M_kepemilikan2/getgridData',
            "fnInitComplete": function(oSettings, json) {
                console.log(json['total'][0]);
                $('#lbrwika').html(json['total'][0]);
                $('#lbrwton').html(json['total'][1]);
                $('#lbrwege').html(json['total'][2]);
                $('#lbrwr').html(json['total'][3]);
                $('#lbrwikon').html(json['total'][4]);
            },
            columnDefs: [
                /*{
                    "targets": 0,
                    "data": null,
                    "defaultContent": "<a class='btn'><i class='fas fa-file-pdf fa-lg'></i><a>",
                    className: 'dt-body-center'
                },*/
                {
                    targets:[0],
                    "render": function ( data, type, row ) {
                        var idrec = row[1];
                        return '&nbsp;<button class="btn btn-default" onclick="javascript:genLapKepemilikan(\'' + idrec + '\');"><i class="far fa-file-pdf fa-xl"></i></button>';
                        
                    },
                    className: 'dt-body-center dt-head-center'
                },
                {
                    targets: -1,
                    className: 'dt-body-right'
                },
                {
                    targets: -2,
                    className: 'dt-body-right'
                },
                {
                    targets: -3,
                    className: 'dt-body-right'
                },
                {
                    targets: -4,
                    className: 'dt-body-right'
                },
                {
                    targets: -5,
                    className: 'dt-body-right'
                }
            ]
        } );
    } );
</script>
