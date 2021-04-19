<script type="text/javascript">
	$(document).ready(function () {
			
			var ivalue='<?php echo $ivalue;?>';
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			  //var target = $(e.target).attr("href") // activated tab
			  var ivalue = $(e.target).attr("value");
			  $('#jqxgrid').html('');
			  window.location.href = '<?php echo base_url().'hr/slip-gaji/M_SlipGaji/?ivalue='?>'+ivalue;
			  
			});
			
			$("#cancelButton").click(function(){
				$('#formInput').fadeOut('slow');
			}); 
				
			
	});
</script>
	<?php
		switch($ivalue)
		{
			case "2019":
				include("v_m_slip_gaji_list_js01.php");
				break;
			
			
		}
	?>

