<?php
use phpGrid\C_DataGrid;

require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>phpGrid Grouping Header</title>
</head>
<body>

<?php
$dg = new C_DataGrid("SELECT * FROM payments", "customerNumber", "orders");

$dg->set_grid_method('setGroupHeaders', array(
                                array('useColSpanStyle'=>true),
                                'groupHeaders'=>array(
                                        array('startColumnName'=>'customerNumber',
                                              'numberOfColumns'=>2,
                                              'titleText'=>'Numbers Header') )));
$dg->set_col_hidden('paymentDate');
$dg->enable_edit('FORM');
$dg->set_theme('cobalt')->set_dimension('600px');
$dg -> display();
?>

</body>
</html>