<?php
use phpGrid\C_DataGrid;

require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Datagrid missing Primary Key and Table Name</title>
</head>
<body>

<?php
$dg = new C_DataGrid("SELECT * FROM orderdetails");
$dg->enable_edit('FORM');
$dg -> display();
?>


</body>
</html>