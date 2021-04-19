<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.js"></script>


<style type="text/css">
	.thumb-image{
	 float:left;width:'100%';height:300px;
	 position:relative;
	 padding:5px;
	}
</style>

<script>
  var total = 0;
  var thousandSeparator = ',';
  var decimalSeparator = '.';
  
 
</script>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small><?php echo $title; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i></a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Input Data KPI</h3>
            </div>
              <form class="form-horizontal" action="<?php echo base_url()?>hr/kpi-admin/M_KPI_ADMIN/saveDataL1/?sessid=<?php echo $isessid; ?>" method="post" enctype="multipart/form-data">

              <div class="box-body">

                <!-- Alert Notification -->
                  <?php if ($this->session->flashdata('success')) { ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php } ?>

                  <?php if ($this->session->flashdata('error')) { ?>
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>

                  <?php if ($this->session->flashdata('warning')) { ?>
                  <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                    <?php echo $this->session->flashdata('warning'); ?>
                  </div>
                  <?php } ?>
                <!-- end notif -->

                <div class="form-group">
                  <label class="col-sm-2 control-label">TAHUN</label>
                  <div class="col-sm-1">
                    <input type="text" id="txtThn" name="txtThn" class="form-control" value="<?php echo Date('Y'); ?>">
                  </div>
                </div>
				
				<div class="form-group" id="vw_kinerja">
                  <label for="vw_kinerja" class="col-sm-2 control-label">KINERJA</label>
                  <div class="col-sm-4">
				  	
                    <select name="id_kinerja" id="id_kinerja" class="form-control">
                      <option value="" >-- Silahkan Pilih --</option>
                    </select>
                  </div>
                </div>
				
				<div class="form-group" id="vw_indikunkunci">
                  <label for="vw_kinerja" class="col-sm-2 control-label">INDIKATOR KINERJA KUNCI</label>
				  <div class="col-sm-1">
                    <select name="no_idindikinkunci" id="no_idindikinkunci" class="form-control">
                      <option value="" >--Pilih --</option>
					  <?php 
							for($i=1;$i<30;$i++){
								echo "<option value='$i'>$i</option>";
							}
					  ?>
                    </select>
				  </div>
                  <div class="col-sm-4">
                    <select name="id_indikinkunci" id="id_indikinkunci" class="form-control">
                      <option value="" >-- Silahkan Pilih --</option>
                    </select>
                  </div>
                </div>
				
				<div class="form-group" id="vw_formula">
                  <label for="vw_formula" class="col-sm-2 control-label">FORMULA</label>
                  <div class="col-sm-8">
				  		<div id="wrapper" style="margin-top: 20px;">
							<input id="fileUpload" name="fileUpload" multiple="multiple" type="file"/> 
							<div id="image-holder"></div>
						</div>
                  </div>
				</div>
				
				<div class="form-group" id="vw_satuan">
                  <label for="vw_satuan" class="col-sm-2 control-label">SATUAN</label>
                  <div class="col-sm-2">
				  		<input type="text" id="txtSatuan" name="txtSatuan" class="form-control" value="">
                  </div>
				</div>
				
				<div class="form-group" id="vw_bobot">
                  <label for="vw_formula" class="col-sm-2 control-label">BOBOT CORPORAT</label>
                  <div class="col-sm-2">
				  		<input type="text" id="txtBobot" name="txtBobot" class="form-control" value="">
                  </div>
				</div>
				
				<div class="form-group" id="vw_target">
                  <label for="vw_formula" class="col-sm-2 control-label">TARGET CORPORAT</label>
                  <div class="col-sm-2">
				  		<input type="text" id="txtTarget" name="txtTarget" class="form-control" value="">
                  </div>
				</div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn btn-success">SIMPAN</button>
              </div>
            </form>
         
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(
      function () {

		  $("#fileUpload").on('change', function () {

			 //Get count of selected files
			 var countFiles = $(this)[0].files.length;

			 var imgPath = $(this)[0].value;
			 var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			 var image_holder = $("#image-holder");
			 image_holder.empty();

			 if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
				 if (typeof (FileReader) != "undefined") {

					 //loop for each file selected for uploaded.
					 for (var i = 0; i < countFiles; i++) {

						 var reader = new FileReader();
						 reader.onload = function (e) {
							 $("<img />", {
								 "src": e.target.result,
									 "class": "thumb-image"
							 }).appendTo(image_holder);
						 }

						 image_holder.show();
						 reader.readAsDataURL($(this)[0].files[i]);
					 }

				 } else {
					 alert("This browser does not support FileReader.");
				 }
			 } else {
				 alert("Pls select only images");
			 }
		 });

		  $('#id_kinerja').select2({
			  ajax: {
					url: '<?php echo base_url(); ?>hr/kpi-admin/M_KPI_ADMIN/getDataLU?idlu=datakinerja&sessid=<?php echo $isessid; ?>',
					dataType: 'json',
					type:'GET',
					data: function (params) {
					  var query = {
						search: params.term,
						page: params.page || 1
					  }
					  
					  // Query parameters will be ?search=[term]&page=[page]
					  return query;
					}
			  }// end of ajax
		 });		
		
		 $("#id_kinerja").change(function(){
			 getIndiKinKunci();
			 //alert('......');
		 });		
		 
		 

		 var getIndiKinKunci =  function(){
			var filter1 = $('#id_kinerja').val();
			$('#id_indikinkunci').select2({
				  ajax: {
						url: '<?php echo base_url(); ?>hr/kpi-admin/M_KPI_ADMIN/getDataLU?idlu=dataindikinkunci&filter1=' + filter1 + '&sessid=<?php echo $isessid; ?>',
						dataType: 'json',
						type:'GET',
						data: function (params) {
						  var query = {
							search: params.term,
							page: params.page || 1
						  }
						  
						  // Query parameters will be ?search=[term]&page=[page]
						  return query;
						}
				  }//end of ajax
			});	
		 };
		 
		 $('#no_idindikinkunci').select2();
		 getIndiKinKunci();
		

	  }
  );

</script>
