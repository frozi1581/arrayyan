<?php
use phpGrid\C_DataGrid;

require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Auto-resize PHP Datagrid Like Excel Spreadsheet</title>
</head>
<body>


<div id="mydiv" style="width:600px">
<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$dg->enable_autowidth(true)->enable_autoheight(true);
$dg->set_pagesize(100); // need to be a large number
$dg->set_scroll(true);
$dg->enable_kb_nav(true);

$dg->enable_edit('INLINE');

/* // uncomment to set width to parent DIV instead
$dg->before_script_end .= 'setTimeout(function(){$(window).bind("resize", function() {
        phpGrid_orders.setGridWidth($("#mydiv").width());
    }).trigger("resize");}, 0)';
*/
$dg -> display();
?>
<style>
    /* optional. removes page margin */
    body{margin:0px;}
</style>


<script>
// hide horizontal scroll bar 
$(function($){
	$('.ui-jqgrid .ui-jqgrid-bdiv').css('overflow-x', 'hidden');
});
</script>

</div>

</body>
</html>