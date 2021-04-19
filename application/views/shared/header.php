<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SYSTEM KKMS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome-pro-5.5.0-web/css/all.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
		 folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/iCheck/flat/blue.css">
    <!-- Morris chart
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morris/morris.css">
  -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  
    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url() ?>assets/plugins/jQuery/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-format-number/jquery.number.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->

   
    <!-- DataTables -->
    <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.fixedColumns.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>


    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-3.4.1.min.css" type="text/css"">
    <script src="<?php echo base_url(); ?>assets/css/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/bootstrap-3.4.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/jquery-3.2.1.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/jquery.number.js"></script>
    <script src="<?php echo base_url(); ?>assets/css/jquery.inputmask.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lookupbox.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css">
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.lookupbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
    
    <!--
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/custom/inner_html.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxtabs.js"></script>
    -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
    <link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/dataTables.fixedColumns.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/select2/dist/css/select2.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url() ?>assets/select2/dist/js/select2.js"></script>

    <style type="text/css">

        .sidebar-toggle{
            display:none;
        }
        th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 99%;
            margin: 0 auto;
            border:1px solid #CFCFC4;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
            height:0px;
        }
        table.dataTable thead {
            background-color: #3c8dbc;
            border-bottom:1px solid #CFCFC4;
            color:#ffffff;
        }

        table.dataTable tfoot {
            background-color: #3c8dbc;
            border-bottom:1px solid #CFCFC4;
            color:#ffffff;
        }

        .btn-primary{
            background-color: #3c8dbc;
        }

        input:-moz-read-only { /* For Firefox */
            background-color: lightgrey;
        }

        input:read-only {
            background-color: lightgrey;
        }
    </style>

</head>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lookupbox.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.lookupbox.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.darkblue.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-redmond.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.ui-start.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxwindow.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>

<!-- auto search on select drop down --->
<script type="text/javascript" src="<?php echo base_url() ?>assets/select2/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/dist/css/select2.min.css" type="text/css" />

<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->

<style type="text/css">
    .jqx-grid-header
    {
        height: auto !important;vertical-align:bottom;
        cursor: col-resize;
    }
    .centerTest2{
        margin-top: 10px;margin-left: 5px
    }
    .centerTest{
        font:Verdana, Geneva, sans-serif;
        font-size:18px;
        text-align:left;
        background-color:#0F0;
        height:50px;
        display: table;
        width: 100%;
    }
    .centerTest span {
        vertical-align:middle;
        display: table-cell;
    }
    .input-disabled{
        background-color:#ffffff !important;
    }
</style>