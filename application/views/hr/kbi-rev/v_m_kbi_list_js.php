<script type="text/javascript">
	$(document).ready(function () {
			
			var ivalue='<?php echo $ivalue;?>';
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			  //var target = $(e.target).attr("href") // activated tab
			  var ivalue = $(e.target).attr("value");
                          $('#jqxgrid').html('');$('#jqxgrid1C').html('');
			  window.location.href = '<?php echo base_url().'hr/kbi-rev/M_KBI/?ivalue='?>'+ivalue;
			});
			
			$("#cancelButton").click(function(){
				$('#formInput').fadeOut('slow');
			}); 
			
	});
</script>
	<?php
		if($ivalue!=""){
                    	include("v_m_kbi_list_js01.php");
                        include("v_m_kbi_list_js03.php");
                }
	?>

