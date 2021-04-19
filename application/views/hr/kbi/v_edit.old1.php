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
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxgrid.grouping.js"></script>
    
    
    
<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->
    
 <style type="text/css">
        table { 
            border-spacing: 0;
            border-collapse: collapse;
        }
        td { 
            padding: 2px;
        }
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
          <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                 <?php 
                 if ($this->session->flashdata('message')) { ?>
                    <div class="alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
                  </div>
                 <?php } ?>
                <!--    <button type="button" id="btnBatal" class="btn btn-primary" onclick="addRow()" style="margin-top:10px;margin-bottom:10px;margin-left:10px;">Tambah Data</button>
                -->   
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
        
                <form role="form" id="fheader" class="form-horizontal" action="#" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <label for="txtBL" class="col-sm-2 control-label"   >Periode</label>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <input class="form-control" id="txtBL" name="txtBL" placeholder="mmyyyy"   onchange="javascript:get_periode(this)" maxlength="6" value="<?php echo isset($BL)?$BL:""; ?>"  required>
                            </div>
                        </div>
                        <label for="txtST_DATE" class="col-sm-2 control-label">Tgl. Mulai Penilaian</label>
                        <div class="col-sm-2">  
                            <input type="text" id="txtST_DATE" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($ST_DATE)?$ST_DATE:""; ?>" name="txtST_DATE" class="form-control" required >
                        </div>
                        <div class="col-sm-1">
                            <label for="txtEND_DATE" class="col-sm1 control-label" >Tgl. Selesai </label>
                        </DIV>    
                        <div class="form-group">
                            <div class="col-sm-2">
                                <input type="text" id="txtEND_DATE" placeholder="dd-mm-yyyy" style="width:100%;" data-date-format='dd-mm-yyyy' value="<?php echo isset($END_DATE)?$END_DATE:"";  ?>" name="txtEND_DATE" class="form-control" required>
                            </div>
                        </div> 
                    </div> 
                <button type="button" id="btnModalBack" name="btnModalBack" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUBACK()">BACK</button>
                </form>
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
                <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>hr/kbi/save_" method="POST" enctype="multipart/form-data">
            </div>
        <div class='row'>
               <div class="col-md-12">
                <div style="margin-top: 1px" id="jqxlistbox"></div>
            </div>    
        </div>    
<script type="text/javascript">
        function replaceAll(str, find, replace) {
            return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
        }
        function escapeRegExp(str) {
            return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
        }
        $(document).ready(function () {
            $( "#txtST_DATE" ).datepicker();
            $( "#txtEND_DATE" ).datepicker();
            var selectedId=[];
            selectedId[0]= document.getElementById("txtBL").value;
            selectedId[1]= replaceAll(document.getElementById("txtST_DATE").value,'/','-');
            selectedId[2]= replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
           // var params = JSON.stringify(selectedId);
           var params = selectedId[0]+'_'+selectedId[1]+'_'+ selectedId[2];
            var source =
            {   datatype: "json",
                datafields: [
                    <?php
                        $i=0;
                        foreach($grid["source"]["datafields"] as $key=>$value){
                                if($i==(count($grid["source"]["datafields"])-1) ){
                                        echo "{name:'".$value["name"]."', type:'".$value["type"]."'}\n";
                                }else{
                                        echo "{name:'".$value["name"]."', type:'".$value["type"]."'},\n";
                                }
                                $i++;
                        }
                    ?>
		],
                //data: {json: JSON.stringify(selectedId)},
                url: '<?php echo base_url().'hr/kbi/M_index/getGridDataEdit/';?>'+params,
                root: 'Rows',
                        
                id: '<?php echo $grid["source"]["ID"]; ?>',
                filter: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                        // update the grid and send a request to the server.
                        $("#jqxgrid").jqxGrid('updatebounddata', 'sort');
                },
                beforeprocessing: function(data)
                {	
                    console.log(data);
                    if (data != null)
                    {
                        source.totalrecords = data[0].TotalRows;	
                        if(data[0].ErrorMsg!=""){
                                //alert(data[0].ErrorMsg);
                        }
                    }
                }
            };
            var dataadapter = new $.jqx.dataAdapter(source, {
                loadError: function(xhr, status, error)
                {
                   // alert(status);
                }
                }
            );
    
            var getLocalization = function () {
                var localizationobj = {};                
                localizationobj.currencysymbol = " ";                
                return localizationobj;
            }
            var renderer = function (id) {
                  var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", id);
                    strDivActions = '<div style="width:99%;text-align:left;">';
                    strEdit = '<button onClick="editRow(event)" id="btnEdit' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Edit"><i class="fa fa-edit fa-lg"></i></button>';
                    strDelete = '<button onClick="deleteRow(event)" id="btnDel' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Hapus"><i class="fa fa-trash fa-lg"></i></button>';
                    strInfo = '<button onClick="infoRow(event)" id="btnInfo' + id + '" style="margin-top:1px;margin-right:0px;height:10px;border:0px;background:transparent;" title="Info"><i class="fa fa-info-circle fa-lg"></i></button>';
                    strApproval = '<button onClick="approveRow(event)" id="btnApprove' + id + '" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o fa-lg"></i></button>';
                    //--------------------- render search data -------------------
                    strRet = strDivActions + strInfo + '</div>';
                    return strRet;
                    //return '<input type="button" onClick="buttonclick(event)" class="gridButton" id="btn' + id + '" value=""/>'
            };
           		
           
            var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {	width: '99%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                editable:false,
                showaggregates: true,
                showstatusbar: true,
		pagesize: 15,
                autoheight:false,
                autorowheight: true,
                autoheight: true,
                height:550,
                rowsheight: 28,
                sortable: true,
                virtualmode: true,
                altrows:true,
               // selectionmode: 'checkbox',
                showtoolbar: true,
                localization: getLocalization(),
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 2px;'></div>");
                    toolbar.append(container);
                    strNew = '<button id="addrowbutton" name="addrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Tambah Daftar Penilaian Pegawai"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-plus jqx-icon-plus-darkblue"></div></button>';
                    strEdit = '<button id="editrowbutton" name="editrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Edit Daftar Pegawai"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-edit jqx-icon-edit-darkblue"></div></i></button>';
                    strDel = '<button id="deleterowbutton" name="deleterowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Hapus Daftar Pegawai"><div style="margin: 4px; width: 16px; height: 16px;" class="jqx-icon-delete jqx-icon-delete-darkblue"></div></button>';
                    strUsers = '<button id="usersrowbutton" name="usersrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Tambah Daftar Penilai Pegawai"><i class="fa fa-users" style="font-size:24px;"></i></button>';
                    strApp = '<button id="approwbutton" name="approwbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Approve"><i class="fa fa-check-square-o" style="font-size:24px;"></i></button>';
                    strVSoal = '<button id="questbutton" name="questbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="View Questioner"><i class="fa fa-pencil-square-o" style="font-size:24px;"></i></button>';
                    strUpload = '<button id="uplrowbutton" name="uplrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Upload Daftar Peserta KBI"><i class="fa fa-upload" style="font-size:24px;"></i></button>';
                    strKBI = '<button id="kbirowbutton" name="kbirowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="View Score KBI"><i class="fa fa-tachometer" style="font-size:24px;"></i></button>';
               
        /*    strDelAll = '<button id="clearrowbutton" name="clearrowbutton" style="margin-right:0px;height:20px;border:0px;background:transparent;" title="Delete All Item"><i class="fa fa-trash-o fa-lg" style="font-size:20px;color:white;"></i></button>';
		  */ // container.append(strEdit);
                   container.append(strUpload);container.append(strNew);
                   container.append(strEdit);container.append(strDel) ;container.append(strUsers); container.append(strApp); container.append(strVSoal);container.append(strKBI);
                    $("#jqxgrid").bind('cellendedit', function (event) {
				var args = event.args;
				var columnDataField = args.datafield;
				var rowIndex = args.rowindex;
				var cellValue = args.value;
				var oldValue = args.oldvalue;
			});
                    $("#kbirowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var selectedId=[];
                        selectedId[0] = document.getElementById("txtBL").value;
                        selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
                        selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
                        selectedId[3] = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        selectedId[4] = dataadapter['recordids'][selectedrowindex]['IS_MANAGER'];
                        
                                               
                        $.ajax({
                                    url: "<?php echo base_url().'hr/kbi/M_index/V_KBI_RESULT'?>",
                                    type: 'POST',
                                    data: {json: JSON.stringify(selectedId)},
                                    dataType: 'json',
                                    success: function (data) {
                                       console.log(data); 
                                       if(data['GET_KBI'].length>0){
                                            var jml_soal=data['GET_KBI'][0]['SOAL'].length;
                                            var ds = new Array();var ds2 = new Array();ds_pivot= new Array();
                                            var a_atasan = new Array();var a_self = new Array();
                                            var a_peer1 = new Array();var a_peer2 = new Array();
                                            var a_bwh1 = new Array();var a_bwh2 = new Array();var a_bwh3 = new Array();
                                            var tot_nilai = {};
                                            for(x=0;x<jml_soal-1;x++){tot_nilai[x]=0;
                                            }
                                            var kriteria_ = {};
                                            for(i=0;i<data['GET_KBI'].length;i++){
                                                for(x=0;x<jml_soal;x++){
                                                    var row_ = {};var row_pv = {};
                                                    //var penilai = data['GET_KBI'][i]['PENILAI'].italics();
                                                    //var jns_kriteria = data['GET_SOAL'][i]['JNS_KRITERIA_NILAI'].toUpperCase();
                                                    row_["penilai"]=data['GET_KBI'][i]['PENILAI'].italics();
                                                    row_["soal"]=data['GET_KBI'][i]['SOAL'][x].toUpperCase();
                                                    row_["soal_ik"]=data['GET_KBI'][i]['SOAL_IK'][x].toUpperCase();
                                                    row_["ik_skor"]=data['GET_KBI'][i]['IK_SKOR'][x];
                                                    row_["ik_bobot"]=(data['GET_KBI'][i]['IK_BOBOT'][x]*100)+'%';
                                                    row_["ik_nilai"]=data['GET_KBI'][i]['IK_NILAI'][x];
                                                    row_pv["ik_skor"]=data['GET_KBI'][i]['IK_SKOR'][x];
                                                    row_pv["ik_bobot"]=data['GET_KBI'][i]['P_BOBOT'];
                                                    row_pv["status"]=data['GET_KBI'][i]['STATUS_PENILAI'];
                                                    ds.push(row_);
                                                    
                                                    if(ds_pivot.length<jml_soal)
                                                        ds_pivot.push(row_["soal_ik"]);
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='DIRI SENDIRI'){a_self.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='ATASAN'){a_atasan.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='PEER1'){a_peer1.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='PEER2'){a_peer2.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='SUB1'){a_bwh1.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='SUB2'){a_bwh2.push(row_pv);}    
                                                    if(data['GET_KBI'][i]['STATUS_PENILAI']==='SUB3'){a_bwh3.push(row_pv);}    
                                                    var nilai_=parseFloat(data['GET_KBI'][i]['IK_NILAI'][x] );
                                                    var subtot =tot_nilai[x] +nilai_;
                                                    tot_nilai[x]=subtot;
                                                    kriteria_[x]=data['GET_KBI'][i]['SOAL'][x].toUpperCase();
                                                }
                                             }
                                            for(x=0;x<jml_soal;x++){
                                                var row_ = {};
                                                row_["soal"]=kriteria_[x];
                                                row_["nilai"]=Number(Math.round(tot_nilai[x] + 'e' + 2) + 'e-' + 2);//tot_nilai[x];
                                                ds2.push(row_);
                                            }
                                            var html= "<div align='center'><b>Hasil Penilaian KBI "+data['GET_KBI'][0]['NAMA_DINILAI']+"\n\
                                                                    </b></div><br><table border='0'>\n\
                                                                    <tr><td>Jabatan</td><td>:</td><td>"+data['GET_KBI'][0]['KET_JBT_DINILAI']+"</td></tr>\n\
                                                                    <tr><td>Lokasi Kerja</td><td>:</td><td>"+data['GET_KBI'][0]['KET_PAT_DINILAI']+"</td></tr>\n\
                                                                    <tr><td>Bagian Kerja</td><td>:</td><td>"+data['GET_KBI'][0]['KET_GAS_DINILAI']+"</td></tr>\n\
                                                                    </table>"  ;
                                            document.getElementById("judul_kbi").innerHTML =html;
                                            document.getElementById("judul_pivot").innerHTML =html;
                                            
                                            
                                        }
                                        console.log(a_atasan);
                                        var p_header=0,bb_tot=0;
                                         for(i=0;i<ds_pivot.length;i++){
                                             var s_atasan='',b_atasan='',s_peer1='',b_peer1='',s_peer2='',b_peer2='',s_bwh1=0,b_bwh1='';
                                             var s_bwh2=0,b_bwh2='',s_bwh3=0,b_bwh3='',s_self=0,b_self='';
                                             if(a_atasan.length>0){s_atasan=a_atasan[i]['ik_skor'];b_atasan=a_atasan[i]['ik_bobot'];}
                                             if(a_peer1.length>0){s_peer1=a_peer1[i]['ik_skor'];b_peer1=a_peer1[i]['ik_bobot'];}
                                             if(a_peer2.length>0){s_peer2=a_peer2[i]['ik_skor'];b_peer2=a_peer2[i]['ik_bobot'];}
                                             if(a_bwh1.length>0){s_bwh1=a_bwh1[i]['ik_skor'];b_bwh1=a_bwh1[i]['ik_bobot'];}
                                             if(a_bwh2.length>0){s_bwh2=a_bwh2[i]['ik_skor'];b_bwh2=a_bwh2[i]['ik_bobot'];}
                                             if(a_bwh3.length>0){s_bwh3=a_bwh3[i]['ik_skor'];b_bwh3=a_bwh3[i]['ik_bobot'];}
                                             if(a_self.length>0){s_self=a_self[i]['ik_skor'];b_self=a_self[i]['ik_bobot'];}
                                             
                                             
                                             var cnt_bwh=0;
                                             if(s_bwh1>0) cnt_bwh++;
                                             if(s_bwh2>0) cnt_bwh++;
                                             if(s_bwh3>0) cnt_bwh++;
                                             var r_s_bwh=( parseInt(s_bwh1) +parseInt(s_bwh2)+parseInt(s_bwh3))/cnt_bwh;
                                             var bb_a=b_atasan/100*s_atasan;
                                             var bb_peer1=b_peer1/100*s_peer1;
                                             var bb_peer2=b_peer2/100*s_peer2;
                                             var bb_bwh1= b_bwh1/100*r_s_bwh;
                                             var bb_self=b_self/100*s_self;
                                             var bb_subtot=bb_a+bb_peer1+bb_peer2+bb_bwh1+bb_bwh1+bb_self+bb_self;
                                             bb_tot=bb_tot+bb_subtot;
                                             if(p_header===0){
                                                 p_header=1;
                                                if(dataadapter['recordids'][selectedrowindex]['IS_MANAGER']==='1'){
                                                    $header_pv="<table border='1'><tr style='font-weight:bold;text-align:center'><td rowspan='3'>NO</td><td rowspan='3'>KRITERIA PENILAIAN</td><td colspan='13' align='center'>TABULASI PENILAIAN</td><td rowspan='3'>NILAI KBI</td></tr>\n\
                                                     <tr style='font-weight:bold;text-align:center'><td colspan='2'>ATASAN LANGSUNG</td><td colspan='2'>PEER 1</td><td colspan='2'>PEER 2</td>\n\
                                                     <td rowspan='2'>BAWAHAN 1</td><td rowspan='2'>BAWAHAN 2</td><td rowspan='2'>BAWAHAN 3</td>\n\
                                                     <td colspan='2'>BAWAHAN</td><td colspan='2'>DIRI SENDIRI</td></tr>\n\
                                                     <tr style='font-weight:bold;text-align:center'><td width='7%'>SCORE</td><td width='7%'>BOBOT<br>("+b_atasan+"%)</td><td style='width: 20px'>SCORE</td><td style='width: 20px'>BOBOT<br>("+b_peer1+"%)</td><td style='width: 20px'>SCORE</td><td style='width: 20px'>BOBOT<br>("+b_peer2+"%)</td>\n\
                                                     <td>SCORE</td><td>BOBOT<br>("+b_bwh1+"%)</td><td>SCORE</td><td>BOBOT<br>("+b_self+"%)</td></tr>"; 
                                               }else{
                                                   $header_pv="<table border='1'><tr><td rowspan='3'>NO</td><td colspan='13'></td><td rowspan='3'>NILAI KBI</td></tr>\n\
                                                     <tr><td colspan='2'>ATASAN LANGSUNG</td><td colspan='2'>PEER 1</td><td colspan='2'>PEER 2</td>\n\
                                                     <td colspan='2'>DIRI SENDIRI</td></tr>\n\
                                                     <tr><td>SCORE</td><td>BOBOT</td><td>SCORE</td><td>BOBOT</td><td>SCORE</td><td>BOBOT</td>\n\
                                                     <td>SCORE</td><td>BOBOT</td></tr></table>"; 

                                               }
                                             }
                                             var no_urut=i+1;
                                             $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td>"+no_urut+"</td><td style='font-weight:bold;text-align:left'>"+ds_pivot[i]+"</td>\n\
                                             <td>"+s_atasan+"</td><td>"+bb_a.toFixed(2)+"</td><td>"+s_peer1+"</td><td>"+bb_peer1.toFixed(2)+"</td><td>"+s_peer2+"</td><td >"+bb_peer2.toFixed(2)+"</td>\n\
                                             <td>"+s_bwh1+"</td><td>"+s_bwh2+"</td><td>"+s_bwh3+"</td><td>"+r_s_bwh+"</td><td>"+bb_bwh1.toFixed(2)+"</td><td>"+s_self+"</td><td>"+bb_self.toFixed(2)+"</td>\n\
                                             <td>"+bb_subtot.toFixed(2)+"</td></tr>";
                                             console.log(ds_pivot[i]+':'+a_peer1[i]['ik_skor']+':'+a_peer1[i]['ik_bobot']);
                                         }
                                          $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td colspan='15'>Grand Total</td><td>"+bb_tot.toFixed(2)+"</td></tr>";
                                            
                                        
                                      //  console.log(ds_pivot);
                                        
                                        var source ={
                                            localdata: ds,
                                            datatype: "array"
                                        };
                                        var source2 ={
                                            localdata: ds2,
                                            datatype: "array"
                                        };
                                        $("#jqxgrid_summary").jqxGrid({
                                            height: 300,
                                            width: '100%',
                                            showheader: true,
                                            source: source2,
                                            sortable:true,
                                          //  autorowheight: true,
                                          // autoheight: true,
                                          // altrows: true,
                                            columns: [
                                                { text: 'Kriteria Penilaian', datafield: 'soal',width:'90%' },
                                                { text: 'Total Nilai', datafield: 'nilai' ,width:'10%'}
                                             ]
                                        });
                                        
                                        $("#jqxgrid_kbi").jqxGrid({
                                            height: 300,
                                            width: '100%',
                                            source: source,
                                            autorowheight: true,
                                            autoheight: true,
                                            altrows: true,
                                            groupable: true,
                                            columns: [
                                                { text: 'Penilai', datafield: 'penilai',hidden:'true' },
                                                { text: 'Indikator', datafield: 'soal',width:'70%' },
                                                { text: 'IK SKOR', datafield: 'ik_skor' ,width:'10%'},
                                                { text: 'IK BOBOT', datafield: 'ik_bobot' ,width:'10%'},
                                                { text: 'IK NILAI', datafield: 'ik_nilai',width:'10%' }
                                            ],
                                            groups: ['penilai']
                                        });
                                        document.getElementById("pivot").innerHTML   = $header_pv;
                                        $("#jqxgrid_kbi").jqxGrid('showgroupsheader', false);
                                        $('#show_kbi').modal('show');
                        
                                    },
                                    error: function (data) {
                                        console.log('error');
                                    }
                        });
                    });  
                    
                             
                    
                    $("#questbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var selectedId=[];
                        selectedId[0] = document.getElementById("txtBL").value;
                        selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
                        selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
                        selectedId[3] = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        if(dataadapter['recordids'][selectedrowindex]['IS_MANAGER']==='1'){
                           $is_manager = 'u/ Manager';
                        }else{
                            $is_manager = 'u/ non Manager';
                        }
                        $.ajax({
                                    url: "<?php echo base_url().'hr/kbi/M_index/V_SOAL'?>",
                                    type: 'POST',
                                    data: {json: JSON.stringify(selectedId)},
                                   // dataType: 'json',
                                   dataType: 'json',
                                    success: function (data) {
                                       if(data['GET_SOAL'].length>0){
                                            var ds = new Array();
                                            var jns_kriteria = new Array();
                                            var pilihan = new Array();
                                           // console.log($is_manager);
                                            document.getElementById("judul_soal").innerHTML = 'Kriteria Penilaian KBI '.concat($is_manager)  ;
                                            for(i=0;i<data['GET_SOAL'].length;i++){
                                                for(x=0;x<4;x++){
                                                    var row_ = {};
                                                    var kriteria_n = data['GET_SOAL'][i]['KRITERIA_NILAI'].italics();
                                                    var jns_kriteria = data['GET_SOAL'][i]['JNS_KRITERIA_NILAI'].toUpperCase();
                                                    row_["jns_kriteria"]=((jns_kriteria).concat(':')).concat( kriteria_n );//((data['GET_SOAL'][i]['JNS_KRITERIA_NILAI'].concat('(')).concat(data['GET_SOAL'][i]['KRITERIA_NILAI']).concat(')');
                                                   // row_["desc_kriteria"]=data['GET_SOAL'][i]['KRITERIA_NILAI'];
                                                    row_["pilihan"]=data['GET_SOAL'][i]['SOAL'][x];
                                                  //  console.log(data['GET_SOAL'][i]['SOAL'][x]);
                                                    ds.push(row_); 
                                               }
                                                        
                                             }
                                       }
                                       var source =
                                        {
                                            localdata: ds,
                                            datatype: "array"
                                        };
                                        $("#jqxgrid_soal").jqxGrid({
                                            height: 300,
                                            width: '100%',
                                            source: source,
                                            groupable: true,
                                            columns: [
                                                { text: 'Indikator Kinerja', datafield: 'pilihan',width:'100%' },
                                          { text: 'Kriteria Penilaian', datafield: 'jns_kriteria' ,hidden:'true'}
                                              //{ text: 'Keterangan', datafield: 'desc_kriteria' },
                                            ],
                                            groups: ['jns_kriteria']
                                        });
                                        $("#jqxgrid_soal").jqxGrid('showgroupsheader', false);
                                        $('#show_soal').modal('show');
                        
                                     //location.reload();
                                    },
                                    error: function (data) {
                                        console.log('error');
                                    }
                                    
                                    
                                    
                        });

                    });
                    $("#usersrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var selectedId=[];
                        selectedId[0] = document.getElementById("txtBL").value;
                        selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
                        selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
                        selectedId[3] = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        selectedId[4] = dataadapter['recordids'][selectedrowindex]['ESELON'];
                        selectedId[5] = dataadapter['recordids'][selectedrowindex]['IS_MANAGER'];
                        var params = selectedId[0]+'_'+selectedId[1]+'_'+ selectedId[2]+'_'+ selectedId[3]+'_'+ selectedId[4]+'_'+ selectedId[5];
                        window.location.href='<?=base_url()?>hr/kbi/M_index/addPenilai/'+params;
                    });
                    $("#deleterowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var selectedId=[];
                        selectedId[0] = document.getElementById("txtBL").value;
                        selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
                        selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
                        selectedId[3] = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        if(dataadapter['recordids'][selectedrowindex]['APP']==='1'){
                            alert('Data Sudah diAprove, tidak bisa dihapus.');
                        }else{
                            if(confirm("Anda Yakin Hapus Penilaian NIP : "+selectedId[3])){
                                $.ajax({
                                    url: "<?php echo base_url().'hr/kbi/M_index/DELETE_PESERTA'?>",
                                    type: 'POST',
                                    data: {json: JSON.stringify(selectedId)},
                                   // dataType: 'json',
                                   dataType: 'json',
                                    success: function (data) {
                                       // console.log(data);
                                        location.reload();
                                    },
                                    error: function (data) {
                                        console.log('error');
                                    }
                                });
                            }
                        }    
                        
                    });
                    
                    $("#uplrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        document.getElementById("txtBL_M").value = document.getElementById("txtBL").value;
                        document.getElementById("txtST_DATE_M").value= document.getElementById("txtST_DATE").value;
                        document.getElementById("txtEND_DATE_M").value= document.getElementById("txtEND_DATE").value;
                        $('#show_upload').modal('show');
                        return false;
                    });
          
                    
                    $("#approwbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        var selectedId=[];
                        selectedId[0] = document.getElementById("txtBL").value;
                        selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
                        selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
                        selectedId[3] = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        selectedId[4] = dataadapter['recordids'][selectedrowindex]['IS_MANAGER'];
                        $.ajax({
                              url: "<?php echo base_url().'hr/kbi/M_index/APPROVE'?>",
                              type: 'POST',
                              data: {json: JSON.stringify(selectedId)},
                             // dataType: 'json',
                             dataType: 'json',
                              success: function (data) {
                                  console.log(data);
                                 location.reload();
                              },
                              error: function (data) {
                                  console.log(data);
                                 // console.log('error');
                              }
                          });
                    });
                    $("#addrowbutton").on('click', function () {
                        $('#show_add').modal('show');   
                        return false;
                    });
                    $("#editrowbutton").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation');
                        document.getElementById("txtEMPLOYEE_ID").value = dataadapter['recordids'][selectedrowindex]['EMPLOYEE_ID'];
                        document.getElementById("txtNama").value= dataadapter['recordids'][selectedrowindex]['EMPLOYEE_NAME'];
                        document.getElementById("txtEselon").value= dataadapter['recordids'][selectedrowindex]['ESELON'];
                        document.getElementById("txtIsMan").value= dataadapter['recordids'][selectedrowindex]['IS_MANAGER'];
                        $('#show_add').modal('show');
                        return false;
                    });
                    $("#deleterowbutton").on('click', function () {
                       // var selectedrowindexs = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                       var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       var nip_ = $('#jqxgrid').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
                       var jns_Potongan = document.getElementById("WT_KET").value;
                        if(confirm("Anda Yakin Hapus "+jns_Potongan +" Pegawai : "+nip_)){
                            var selectedId=[];
                            selectedId[0]= document.getElementById("KD_PAT").value;
                            selectedId[1]= document.getElementById("NO_TRANS").value;
                            selectedId[2]= document.getElementById("WT").value;
                            selectedId[3]= nip_;
            
                           // window.location.href='<?=base_url()?>os/cetakan/M_cetakan/deleteData?recId='+selectedId;
                           $.ajax({
                              url: "<?php echo base_url().'hr/potongan/M_index/delPotong'?>",
                              type: 'POST',
                              data: {json: JSON.stringify(selectedId)},
                             // dataType: 'json',
                             dataType: 'json',
                              success: function (data) {
                                   location.reload();
                              },
                              error: function (data) {
                                  console.log('error');
                              }
                          });
                        }
                        return false;
                    });
                },
                rendergridrows: function () {
                return dataadapter.records;
                },					
               columns: [
                        <?php 
                                $i=0;
                                foreach($grid["columns"] as $key=>$value){
                                        $strListColumns="{ align:'left',";
                                        foreach($value as $key2=>$value2){
                                        if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable' ||  $key2=='editable'||  $key2=='aggregates' ){
                                                        $strListColumns .= $key2.":".$value2.",";
                                                }else{
                                                        $strListColumns .= $key2.":'".$value2."',";
                                                }
                                        }
                                        $strListColumns = (substr($strListColumns,-1) == ',') ? substr($strListColumns, 0, -1) : $strListColumns;

                                        if($i==(count($grid["columns"])-1) ){
                                                $strListColumns.="}";
                                        }else{
                                                $strListColumns.="},";
                                        }
                                        echo $strListColumns."\n";
                                        $i++;
                                }
                        ?>
					
                    ]
            });
			
		
	});
         var localizationobj = {};
            localizationobj.currencysymbol = "";
            localizationobj.decimalseparator = ",";
            localizationobj.thousandsseparator = ".";
            $("#jqxgrid").jqxGrid('localizestrings', localizationobj);

         var renderVAL = function(val_){
               //obj=$("#jqxgrid").jqxGrid("getrowdata", val_);
              // html='<div style="width:99%;text-align:right;">'+f_dec2(obj.JML)+'</div>';
               html='<div style="width:99%;text-align:right;">0%</div>';
               return html;
            };
         var renderAPP = function(row_){
            var dataRecord = $("#jqxgrid").jqxGrid("getrowdata", row_);
              if(dataRecord.APP==='1'){
                  html='<div style="width:99%;text-align:right;">Approved</div>';
                //  html='<span style="background-color: #4dffff;position: relative;top: 5px;left: 5px;">Approved</span>';
              }else{
                  html='<div style="width:99%;text-align:right;">not Approved</div>';
                 // html='<span style="background-color: #4dffff;position: relative;top: 5px;left: 5px;">Not Approve</span>';
              }
               return html;
            };   
         function f_dec2(val_){
            var nilai =(val_.toString()).replace(/,/g, '');
            nilai = nilai.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            return nilai;
        }; 
       function f_dec(obj){
            var nilai = $(obj).val().replace(/,/g, '');
            $(obj).val(nilai.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $(obj).on("input", function() {
                // allow numbers, a comma or a dot
                var v= $(this).val().replace(/,/g, '');
               // v = v.replace(/[^0-9]/, '');
               // v = v.replace(/,/, '');  
                $(this).val(v.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            });
        };
        
        function submitLUNIP(){
            var selectedrowindex = $("#jqxGridNIP").jqxGrid('getselectedrowindex');
            var Value_ = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_ID');
            var Value_1 = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'NAMA');
            var Value_2 = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'ESELON');
            document.getElementById("txtEMPLOYEE_ID").value=Value_; 
            document.getElementById("txtNama").value=Value_1; 
            document.getElementById("txtEselon").value=Value_2; 
            $('#show_nip').modal('hide');
        }
        function evtOpenLU(){
             $('#show_nip').modal('show');
        }
        function submitPIVOT(){
            $('#show_pivot').on('shown.bs.modal', function () {
                $(this).find('.modal-dialog').css({width:'auto',
                                           height:'auto', 
                                          'max-height':'100%'});
            });
             $('#show_pivot').modal('show');
        }
        function submitLUBACK(){
             window.location.href = "<?php echo base_url().'hr/kbi/M_index/';?>";
          //  window.location.reload(true);
                                
        }
        function submitUpload(){
            if(document.getElementById("kbifile").value===''){
                alert('Silahkan pilih File yang akan diupload.');
            }else{document.getElementById("fupload").submit(); 
            }
        }
       
        function submitLUPOT(){
             $('#show_add').modal('hide');
           //   txtBL,txtST_DATE,txtEND_DATE,txtEMPLOYEE_ID,txtEselon,txtIsMan
             var selectedId=[];
            selectedId[0]= document.getElementById("txtBL").value;
            selectedId[1]= document.getElementById("txtST_DATE").value;
            selectedId[2]= document.getElementById("txtEND_DATE").value;
            selectedId[3]= document.getElementById("txtEMPLOYEE_ID").value;
            selectedId[4]= document.getElementById("txtEselon").value;
            selectedId[5]= document.getElementById("txtIsMan").value;
            $.ajax({
                              url: "<?php echo base_url().'hr/kbi/M_index/addPeserta'?>",
                              type: 'POST',
                              data: {json: JSON.stringify(selectedId)},
                             dataType: 'json',
                              success: function (data) {
                                  location.reload();
                              },
                              error: function (data) {
                                  console.log('error');
                              }
                          });
                         
        }
        
         
        
        
</script>

                <!------------  table ------------------------------->
                <!------------ end table ---------------------------->
                
                </div>    
            </form>
          </div>
          <!-- /.box -->
       
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- modal   Lookup Tambah Potongan -->
  <div class="modal fade" id="show_add" style="display: none;">
    <div class="modal-dialog " style="width:650px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Tambah Objek Penilaian</h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="form-group">
                       <?php $isMan=''; ?>
                        <label for="" class="col-sm-2 control-label"   >NIP Pegawai</label>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <input class="form-control" id="txtEMPLOYEE_ID" name="txtEMPLOYEE_ID" readonly>
                            </div>
                            <button type="button" id="btnopenLUNIP" class="btn btn-primary"   onclick="evtOpenLU()" ><i class="fa fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <label for="txtIsMan" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="txtIsMan" id="txtIsMan" >
                                <?php  foreach ($DDListIsMan as $d1) { ?>
                                    <option  value="<?php echo $d1['id']; ?>" <?php
                                      if($isMan===$d1['id']){
                                          echo "selected";
                                      }
                                      ?> ><?php echo $d1['status'] ?></option>
                                <?php } ?>
                                </select>
                            </div>    
                        </div>
                        <label for="" class="col-sm-2 control-label"   >Nama Pegawai</label>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input class="form-control" id="txtNama" name="txtNama" readonly>
                            </div>
                        </div>
                        <label for="" class="col-sm-2 control-label"   >Eselon</label>
                        <div class="form-group">
                            <div class="col-sm-1">
                                <input class="form-control" id="txtEselon" name="txtEselon" readonly>
                            </div>
                        </div>   
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUPOT()">OK</button>
                </div>
            </div>
        </form>
        </div>
        
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Tambah Potongan -->
<!-- modal   Lookup NIP -->
  <div class="modal fade" id="show_nip" style="display: none;">
    <div class="modal-dialog " style="width:1100px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo isset($gridLUNIP)?$gridLUNIP:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <?php echo isset($gridLUNIP)?$gridLUNIP:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Cetakan -->
<!-- modal   Upload -->
<div class="modal fade" id="show_upload" style="display: none;">
    <div class="modal-dialog " style="width:610px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload Pegawai Dinilai</h4>
        </div>
          <form role="form" class="form-horizontal" id="fupload" method="post" name="fupload" action="<?php echo base_url().'hr/kbi/M_index/f_upload_peserta'?>" enctype="multipart/form-data" >
        <div class="modal-body">
            <!-------------------- form upload -------------------------------------------------------------------------->
            <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-3">   
                            <input class="form-control" id="txtBL_M" name="txtBL_M" readonly type="hidden">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" id="txtST_DATE_M" name="txtST_DATE_M" readonly type="hidden">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" id="txtEND_DATE_M" name="txtEND_DATE_M" readonly type="hidden">
                        </div>
                    </div>
                    <label for="kbifile" class="col-sm-3 control-label">Attachment</label>
                    <div class="form-group">
                        <input type="file" name="kbifile" id="kbifile">
                        <p class="help-block"></p>
                    </div>
            </div> 
            <!-------------------- end form upload ---------------------------------------------------------------------->
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitUpload()">Upload</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- end modal Upload -->
<!-- modal   Lookup SOAL -->
  <div class="modal fade" id="show_soal" style="display: none;">
    <div class="modal-dialog " style="width:1100px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><div id="judul_soal"></div></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div id="jqxgrid_soal"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- modal   Lookup KBI -->
  <div class="modal fade" id="show_kbi" style="display: none;">
    <div class="modal-dialog " style="width:1100px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><div id="judul_kbi"></div></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <button type="button" id="btnPivot" name="btnPivot" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitPIVOT()">View Pivot</button>
            </div>
            <div class="form-group">
                <div id="jqxgrid_summary"></div>
            </div>
            <div class="form-group">
                <div id="jqxgrid_kbi"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNIP()">OK</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!----- View Pivot --->
 <div class="modal fade" id="show_pivot" style="display: none;">
    <div class="modal-dialog " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><div id="judul_pivot"></div></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div id="pivot"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
    