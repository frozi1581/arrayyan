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
<!--  class untuk add javascript didalam inner html -->
<script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/custom/inner_html.js"></script>  
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
        .center{
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
      .row{margin-top: 10px;margin-left: 2px}
      .row2{margin-top: 5px;margin-left: 2px}
      .input-disabled{
            background-color:#eee !important;
        }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#txtTgl_surat').attr('readonly', true);$('#txtTgl_surat').addClass('input-disabled');
        $('#txtInduk').attr('readonly', true);$('#txtInduk').addClass('input-disabled');
        $('#txtPrimer').attr('readonly', true);$('#txtPrimer').addClass('input-disabled');
        $('#txtSekunder').attr('readonly', true);$('#txtSekunder').addClass('input-disabled');
        $('#txtNo_surat').attr('readonly', true);$('#txtNo_surat').addClass('input-disabled');
        var nextbutton =  $('#nextbutton').jqxButton({theme:'ui-start', width:'100px', height:'35px'});
        var btnModalSubmit =  $('#btnModalSubmit').jqxButton({theme:'ui-start', width:'100px', height:'35px'});
        var HomeButton =  $('#btnHome').jqxButton({theme:'ui-start', width:'50px', height:'45px'});
        var lampiran_="<?php echo isset($lampiran)?$lampiran:""; ?>";
        var f_status="<?php echo  isset($f_status)?$f_status:""; ?>";  
        //---------------------------- auto add input-------------------
        if( f_status==='NEW'){
            var txtDoc='';
            txtDoc=txtDoc+"<div class='col-sm-12'>";
            txtDoc=txtDoc+"<input type='text' name='txtTujuanEx[]' id='txtTujuanEx[]' value='' style='width: 95%' autocomplete='off'>";
            txtDoc=txtDoc+"<a href='javascript:void(0);' class='add_button' title='Tambah tujuan eksternal'>&nbsp<i class='fa fa-plus' style='font-size:17px;'></i></a></div>";
            document.getElementById("tujuanExt").innerHTML=txtDoc;
        }
        if(f_status==='EDIT' || f_status==='VIEW'){
            var external=[];
            var txtDoc='';
            var i=0;
            var txtDoc='';
                   
            <?php
            
            $aTujuan=isset($aTujuanExt)?$aTujuanExt:"";
            
            if(count($aTujuan )<1){
                ?>
                    txtDoc=txtDoc+"<div class='col-sm-12'>";
                    txtDoc=txtDoc+"<input type='text' name='txtTujuanEx[]' id='txtTujuanEx[]' value='' style='width: 95%' autocomplete='off'>";
                    txtDoc=txtDoc+"<a href='javascript:void(0);' class='add_button' title='Tambah tujuan eksternal'>&nbsp<i class='fa fa-plus' style='font-size:17px;'></i></a></div>";
                <?php            
            }
            ?>
              <?php if($aTujuan>0){ foreach($aTujuan as $key => $val){ ?>
                external.push('<?php echo $val; ?>');
                if(i===0){
                    txtDoc=txtDoc+"<div class='col-sm-12'>";
                    txtDoc=txtDoc+"<input type='text' name='txtTujuanEx[]' id='txtTujuanEx[]' value='<?php echo $val; ?>' style='width: 95%' autocomplete='off'>";
                    txtDoc=txtDoc+"<a href='javascript:void(0);' class='add_button' title='Tambah tujuan eksternal'>&nbsp<i class='fa fa-plus' style='font-size:17px;'></i></a></div>";
                }else{
                    txtDoc=txtDoc+'<div  class="col-sm-12"><input type="text" id="txtTujuanEx[]" name="txtTujuanEx[]" value="<?php echo $val; ?>" style="width: 95%;margin-top:10px" autocomplete="off"><a href="javascript:void(0);" class="remove_button" title="Hapus tujuan eksternal">&nbsp<i class="fa fa-minus" style="font-size:17px;"></i></a></div>';
                }
                i++;
              <?php }} ?>
            document.getElementById("tujuanExt").innerHTML=txtDoc;

        }
        if( f_status==='VIEW'){
            txtDoc="";
            <?php if($aTujuan>0){ foreach($aTujuan as $key => $val){ ?>
                external.push('<?php echo $val; ?>');
                txtDoc=txtDoc+"<div class='col-sm-12'>";
                txtDoc=txtDoc+"<input type='text' name='txtTujuanEx[]' id='txtTujuanEx[]' value='<?php echo $val; ?>' style='width: 95%;margin-top:10px' autocomplete='off'></div>";
                i++;
              <?php }} ?>
            document.getElementById("tujuanExt").innerHTML=txtDoc;
        }
        
        
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div  class="col-sm-12"><input type="text" id="txtTujuanEx[]" name="txtTujuanEx[]" value="" style="width: 95%;margin-top:10px" autocomplete="off"><a href="javascript:void(0);" class="remove_button" title="Hapus tujuan eksternal">&nbsp<i class="fa fa-minus" style="font-size:17px;"></i></a></div>'; //New input field html <img src="remove-icon.png"/>
        var x = 1; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(f_status==='EDIT' || f_status==='NEW'){
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            }
        });
      //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

        //---------------------------- end auto add input --------------
        if(f_status==='EDIT' || f_status==='NEW'){
            var txtDoc='';
            txtDoc=txtDoc+'<div class="row" id="show_btn_submit">';
            var mButton  = '<button  id="btnModalSubmit" name="btnModalSubmit" onclick="CEK_SUBMIT()" type="button" value="" title="Simpan Dokumen Penomoran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:90px;" ><i class="fas fa-save fa-lg fa-fw">&nbsp</i>Simpan</button>';
            //type="submit"
            txtDoc+=mButton;
            //txtDoc=txtDoc+'<button type="submit" id="btnModalSubmit" name="btnModalSubmit" class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start"  style="margin-right: 0px;margin-bottom: 13px;margin-top: 5px" class="btn btn-primary" title="Simpan Dokumen Penomoran Surat">Simpan</button></div>';
            document.getElementById("TombolSimpan").innerHTML=txtDoc;document.getElementById("TombolSimpan2").innerHTML=txtDoc;
            var txtDoc='';
            txtDoc=txtDoc+'<div class="col-sm-6"><label for="foto" style="text-align: left;width: 50px;" >Upload Lampiran </label><input id="txtUpload_file" type="file" class="form-control"  name="txtUpload_file" style=" width: calc(100% - (50px + 50px))"></div>';
            document.getElementById("show_upl_lampiran").innerHTML=txtDoc;
        }else{
           // document.getElementById("btnAddEks").style.display='block';
        }    
        if(f_status==='NEW'){
            document.getElementById("txtTgl_surat").value='<?php echo  $tgl_create=date("d-m-Y"); ?>   ';
        }
        if(lampiran_!==''){
          //  var txtDoc="<label for='' >Lampiran </label>";
            var txtDoc='';
            txtDoc=txtDoc+"<div class='col-sm-1'><label for='' style='margin-left:15px;margin-top:5px'>Lampiran </label></div><div class='col-sm-2'><span class='logo-lg' style='margin-left:5px;margin-top:10px'>";
            var downloadButton = '<button id="downloadrowbutton" type="button" value="" title="View Lampiran Surat"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:90px;"  onclick="viewLampiran('+"'"+lampiran_+"'"+')"><i class="fas fa-paperclip fa-lg fa-fw">&nbsp;</i>Lampiran</button>';
            txtDoc=txtDoc+ downloadButton; 
            txtDoc=txtDoc+"</span></div>";
            document.getElementById("show_lampiran").innerHTML=txtDoc;
        }
        //--------------------------------------- load jqxGrid Undangan ---------------------------------------------------------------
            var no_surat_='<?php echo isset($no_surat)?$no_surat:"";  ?>';
            no_surat_=no_surat_.replace(/\//g, "_");
            if(document.getElementById("f_status").value==='NEW')
                no_surat_= '<?php echo $this->session->userdata('s_uID'); ?>';
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
                url: '<?php echo base_url().'hr/surat/M_index/list_Invite/'?>'+no_surat_,
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
                {   if (data != null)
                    {
                        source.totalrecords = data[0].TotalRows;	

                        if(data[0].ErrorMsg!=""){
                                alert(data[0].ErrorMsg);
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
           var theme = 'darkblue';
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {width: '100%',
                source: dataadapter,
                theme: theme,
                filterable:true,
                showfilterrow: true,
                pageable: true,
                pagesize: 15,
                autoheight:true,
                autorowheight: true,
                sortable: true,
                virtualmode: true,
                showtoolbar: true,
                
                rendertoolbar: function (toolbar) {
                    var me = this;
                    var container = $("<div style='margin: 2px;'></div>");
                    var btnAdd = '<button id="addrowbutton" type="button" value="" title="Tambah Tujuan Internal"  style="cursor:pointer;padding: 5px; margin: 3px;float:left;"><i class="fas fa-plus fa-lg fa-fw">&nbsp;</i>Tambah Data</button>';
                    var btnDel = '<button id="deleterowbutton" type="button" value="" title="Hapus Tujuan Internal"  style="cursor:pointer;padding: 5px; margin: 3px;float:left;"><span class="glyphicon glyphicon-trash"></span>Hapus</button>';
                    var addButton = $(btnAdd);addButton.jqxButton({theme:'ui-start', width:'130px', height:'25px'});
                    var delButton = $(btnDel);delButton.jqxButton({theme:'ui-start', width:'130px', height:'25px'});
                    container.append(addButton);container.append(delButton);
                    toolbar.append(container);
                   
                    $("#addrowbutton").on('click', function () {
                        document.getElementById("judul_undangan").innerHTML='Tambah Daftar Undangan';
                        document.getElementById("btn_LUNIPinvite").style.display='block';
                        document.getElementById("inviteBtnDel").style.display='none';
                        document.getElementById("inviteBtnSave").style.display='block';
                        document.getElementById("btnFindPAT").style.display='block';
                        document.getElementById("btnFindGAS").style.display='block';
                        document.getElementById('txtNama_Diundang').value='';
                        document.getElementById('txtPATKET_Diundang').value='';
                        document.getElementById('txtGASKET_Diundang').value='';
                        document.getElementById('txtPAT_Diundang').value='';
                        document.getElementById('txtGAS_Diundang').value='';
                        $('#show_fUndangan').modal('show');
                        return false;  
                    });
                    $("#deleterowbutton").on('click', function () {
                        document.getElementById("judul_undangan").innerHTML='Hapus Daftar Undangan';
                        document.getElementById("btn_LUNIPinvite").style.display='none';
                        document.getElementById("btnFindPAT").style.display='none';
                        document.getElementById("btnFindGAS").style.display='none';
                        document.getElementById("inviteBtnDel").style.display='block';
                        document.getElementById("inviteBtnSave").style.display='none';
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        document.getElementById('txtNama_Diundang').value=dataadapter['recordids'][selectedrowindex]['nama_diundang'];
                        document.getElementById('txtPATKET_Diundang').value=dataadapter['recordids'][selectedrowindex]['ket_pat'];
                        document.getElementById('txtGASKET_Diundang').value=dataadapter['recordids'][selectedrowindex]['ket_gas'];
                        document.getElementById('txtNIP_Diundang').value=dataadapter['recordids'][selectedrowindex]['employee_id'];
                        document.getElementById('txtSEQ_Diundang').value=dataadapter['recordids'][selectedrowindex]['seq'];
                        $('#show_fUndangan').modal('show');
                       return false;  
                    });

                    $("#deleterowbuttonX").on('click', function () {
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex')%15;
                        var selectedId=[];
                        selectedId[0] = dataadapter['recordids'][selectedrowindex]['no_surat'];
                        selectedId[1] = dataadapter['recordids'][selectedrowindex]['seq']; 
                        $.ajax({
                            url: "<?php echo base_url().'hr/surat/M_index/del_diundang'?>",
                            type: 'POST',
                            data: {json: JSON.stringify(selectedId)},
                           // dataType: 'json',
                            dataType: 'json',
                            success: function (data) {
                               $("#jqxgrid").jqxGrid('updatebounddata');
                               deleteInvite(); 
                            },
                            error: function (data) {
                               // console.log(data);
                                console.log('error');
                            }
                        });  
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
                                                if($key2=='hidden' || $key2=='cellsrenderer' || $key2=='buttonclick' || $key2=='filterable' || $key2=='sortable'){
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
        //--------------------------------------- end load jqxGrid Undangan -----------------------------------------------------------
        if(document.getElementById("f_status").value==='NEW' || document.getElementById("f_status").value==='EDIT') {
            if(document.getElementById("f_status").value==='NEW' ){
                document.getElementById("btnInduk").style.display = "block";
                document.getElementById("btnPrimer").style.display = "block";
                document.getElementById("btnSekunder").style.display = "block";
            }
            document.getElementById("lbl_tab_0").innerHTML=' ('+document.getElementById("f_status").value+')';
            document.getElementById("txtTgl_input").value=  '<?php echo date("d-m-Y"); ?>';
            document.getElementById("txtDibuat").value= "<?php echo $this->session->userdata('s_uNAME'); ?>";
            document.getElementById("txtJabatan").value="<?php echo  $this->session->userdata('s_uJBT_KET'); ?>";
            document.getElementById("txtBiro").value="<?php echo  $this->session->userdata('s_uGAS_KET'); ?>";
            document.getElementById("txtUnit").value="<?php echo  $this->session->userdata('s_uPAT_KET'); ?>";
            document.getElementById("txtKdPAT").value="<?php echo $this->session->userdata('s_uPAT');?>";
        }
        var selectedId='';
        $.ajax({
            url: "<?php echo base_url().'hr/LU_help/LU_KD_INDUK'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
           // dataType: 'json',
            dataType: 'json',
            success: function (data) {
                var htmlContent = '';
                htmlContent += data['gridLUINDUK'];

                // run the scripts inside the dom node
                var $container = document.querySelector('.containerInduk');
                $container.innerHTML = htmlContent;
                runScripts($container);

               // console.log(data);
            },
            error: function (data) {
                console.log('error');
            }
        });
        $("#btnInduk").on('click', function () {
            //var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
            $('#show_kdInduk').modal('show');
            return false;
        });
        
        $("#btnPrimer").on('click', function () {
            //var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
           // $('#show_kdInduk').modal('show');
            var selectedId=document.getElementById('txtInduk').value;
            $.ajax({
                url: "<?php echo base_url().'hr/LU_help/LU_KD_PRIMER';   ?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    var htmlContent = '';
                    htmlContent += data['gridLUPRIMER'];
                    // run the scripts inside the dom node
                    var $container = document.querySelector('.container');
                    $container.innerHTML = htmlContent;
                    runScripts($container);
                    $('#show_kdPrimer').modal('show');
                },
                error: function (data) {
                   // console.log(data);
                    console.log('error');
                }
            });
            return false;
        });
        $("#btnFindNIP").on('click', function () {
            var selectedId=[];
            selectedId[0]=document.getElementById('txtPAT_Diundang').value;
            selectedId[1]=document.getElementById('txtGAS_Diundang').value;
            $.ajax({
                url: "<?php echo base_url().'hr/LU_help/LU_Pegawai'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    var htmlContent = '';
                    htmlContent += data['gridLUNIP'];
                    // run the scripts inside the dom node
                    var $container = document.querySelector('.containerLU');
                    $container.innerHTML = htmlContent;
                    runScripts($container);
                    document.getElementById('txtJnsLU').value='LUNIP';
                    document.getElementById('jdlLU').innerHTML='Daftar Pegawai';
                    var d = document.getElementsByClassName('modal-dialog');
                    d[4].style.width = "80%";
                    $('#show_LU').modal('show');
                },
                error: function (data) {
                    console.log('error');
                }
            });
            return false;
        });
        $("#btnFindPAT").on('click', function () {
            var selectedId='';
            $.ajax({
                url: "<?php echo base_url().'hr/LU_help/LU_PAT'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    var htmlContent = '';
                    htmlContent += data['gridLUPAT'];
                    var $container = document.querySelector('.containerLU');
                    $container.innerHTML = htmlContent;
                    runScripts($container);
                    document.getElementById('txtJnsLU').value='LUPAT';
                    document.getElementById('jdlLU').innerHTML='Daftar PPU';
                    var d = document.getElementsByClassName('modal-dialog')
                    d[4].style.width = "600px";
                    $('#show_LU').modal('show');
                },
                error: function (data) {
                    console.log('error');
                }
            });
            return false;
        });
        $("#btnFindGAS").on('click', function () {
            var selectedId=[];
            selectedId[0]=document.getElementById('txtPAT_Diundang').value;
            $.ajax({
                url: "<?php echo base_url().'hr/LU_help/LU_GAS'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    var htmlContent = '';
                    htmlContent += data['gridLUGAS'];
                    var $container = document.querySelector('.containerLU');
                    $container.innerHTML = htmlContent;
                    runScripts($container);
                    document.getElementById('txtJnsLU').value='LUGAS';
                    document.getElementById('jdlLU').innerHTML='Daftar Biro/Seksi';
                    var d = document.getElementsByClassName('modal-dialog')
                    d[4].style.width = "730px";
                    $('#show_LU').modal('show');
                },
                error: function (data) {
                    console.log('error');
                }
            });
            return false;
        });
        $("#btnSekunder").on('click', function () {
            //var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
           // $('#show_kdInduk').modal('show');
            var selectedId=document.getElementById('txtPrimer').value;
            $.ajax({
                url: "<?php echo base_url().'hr/LU_help/LU_KD_SEKUNDER'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    var htmlContent = '';
                    htmlContent += data['gridLUSEKUNDER'];

                    // run the scripts inside the dom node
                    var $container = document.querySelector('.containerSekunder')
                    $container.innerHTML = htmlContent
                    runScripts($container)
                    $('#show_kdSekunder').modal('show');
                },
                error: function (data) {
                   // console.log(data);

                    console.log('error');
                }
            });
            return false;
        });
        
        $("#btnHome").on('click', function () {  
            window.location.href='<?=base_url()?>hr/surat/M_index';
        });
        
    });
    function viewLampiran(row_){
          window.open(row_, "_blank", "toolbar=no,scrollbars=yes,location=no,titlebar=no,menubar=no,directories=no,location=no, resizable=yes,top=100,left=200,width=800,height=800");
        }
    function submitLUNINDUK(){
           var selectedrowindex = $("#jqxGridINDUK").jqxGrid('getselectedrowindex');
           document.getElementById('txtInduk').value = $('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
           document.getElementById('txtKet_masalah_induk').value = $('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'KET_MASALAH_INDUK');
           document.getElementById('txtNo_surat').value=$('#jqxGridINDUK').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
           document.getElementById('txtPrimer').value ="";document.getElementById('txtSekunder').value = "";
           document.getElementById('txtKet_masalah_primer').value ="";document.getElementById('txtKet_masalah_sekunder').value ="";
           $('#show_kdInduk').modal('hide');$('#show_Header').modal('show');
    }
    function submitLUPRIMER(){
          var selectedrowindex = $("#jqxGridPRIMER").jqxGrid('getselectedrowindex');
          document.getElementById('txtPrimer').value = $('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
          document.getElementById('txtKet_masalah_primer').value = $('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'KET_MASALAH_PRIMER');
          document.getElementById('txtNo_surat').value=$('#jqxGridPRIMER').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
          document.getElementById('txtSekunder').value = "";document.getElementById('txtKet_masalah_sekunder').value ="";
          $('#show_kdPrimer').modal('hide');$('#show_Header').modal('show');
    }
    function submitLUSEKUNDER(){
        var selectedrowindex = $("#jqxGridSEKUNDER").jqxGrid('getselectedrowindex');
        document.getElementById('txtSekunder').value = $('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN');
        document.getElementById('txtKet_masalah_sekunder').value = ($('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'KET_MASALAH_SEKUNDER')).toUpperCase();
        document.getElementById('txtNo_surat').value=$('#jqxGridSEKUNDER').jqxGrid('getcellvalue', selectedrowindex, 'KD_DOKUMEN')+"/WB-"+"<?php echo $this->session->userdata('s_uPAT'); ?>"+".####/"+"<?php echo date("Y"); ?>";
        $('#show_kdSekunder').modal('hide');$('#show_Header').modal('show');
    }
    function submitLUNIP(){
        if(document.getElementById('txtJnsLU').value==='LUNIP'){
            var selectedrowindex = $("#jqxGridNIP").jqxGrid('getselectedrowindex');
            document.getElementById('txtNIP_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'ID');
            document.getElementById('txtNama_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'EMPLOYEE_NAME');
            document.getElementById('txtPAT_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'KD_PAT');
            document.getElementById('txtPATKET_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'KET_PAT');
            document.getElementById('txtGAS_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'KD_GAS');
            document.getElementById('txtGASKET_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'KET_GAS');
            document.getElementById('txtKDJBT_Diundang').value = $('#jqxGridNIP').jqxGrid('getcellvalue', selectedrowindex, 'KD_JBT');
        }
        if(document.getElementById('txtJnsLU').value==='LUPAT'){
            var selectedrowindex = $("#jqxGridPAT").jqxGrid('getselectedrowindex');
            document.getElementById('txtPAT_Diundang').value = $('#jqxGridPAT').jqxGrid('getcellvalue', selectedrowindex, 'ID');
            document.getElementById('txtPATKET_Diundang').value = $('#jqxGridPAT').jqxGrid('getcellvalue', selectedrowindex, 'KET');
            document.getElementById('txtNIP_Diundang').value = '';
            document.getElementById('txtNama_Diundang').value = '';
            document.getElementById('txtGAS_Diundang').value = '';
            document.getElementById('txtGASKET_Diundang').value = '';
            document.getElementById('txtKDJBT_Diundang').value = '';
        
        }
        if(document.getElementById('txtJnsLU').value==='LUGAS'){
            var selectedrowindex = $("#jqxGridGAS").jqxGrid('getselectedrowindex');
            document.getElementById('txtGAS_Diundang').value = $('#jqxGridGAS').jqxGrid('getcellvalue', selectedrowindex, 'KD_GAS');
            document.getElementById('txtGASKET_Diundang').value = $('#jqxGridGAS').jqxGrid('getcellvalue', selectedrowindex, 'KET');
            document.getElementById('txtNIP_Diundang').value = '';
            document.getElementById('txtNama_Diundang').value = '';
            document.getElementById('txtKDJBT_Diundang').value = '';
        }
        $('#show_LU').modal('hide');
         //jdlLU txtJnsLU
    }
    function moveTab(tab){
          $('.nav-pills a[href="#' + tab + '"]').tab('show');
      }

    function DelINVITE(){
        $('#show_fUndangan').modal('hide');
        var selectedId=[];
        if(document.getElementById('f_status').value ==='NEW') selectedId[0] = "<?php echo $this->session->userdata('s_uID'); ?>";
        if(document.getElementById('f_status').value ==='EDIT') selectedId[0] = "<?php echo  isset($no_surat)?$no_surat:""; ?>";
        selectedId[1] = document.getElementById('txtPAT_Diundang').value;
        selectedId[2] = document.getElementById('txtGAS_Diundang').value;
        selectedId[3] = document.getElementById('txtNIP_Diundang').value;
        selectedId[4] = document.getElementById('txtSEQ_Diundang').value;
        $.ajax({
            url: "<?php echo base_url().'hr/surat/M_index/del_diundang'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
           // dataType: 'json',
            dataType: 'json',
            success: function (data) {
               $("#jqxgrid").jqxGrid('updatebounddata');
            },
            error: function (data) {
               // console.log(data);
                console.log('error');
            }
        }); 
         
    }
    function submitLUINVITE(){
        if(document.getElementById('f_status').value ==='NEW' || document.getElementById('f_status').value ==='EDIT'){
            $('#show_fUndangan').modal('hide');
            var selectedId=[];
            selectedId[0] = document.getElementById('f_status').value;
            selectedId[1] = document.getElementById('txtPAT_Diundang').value;
            selectedId[2] = document.getElementById('txtGAS_Diundang').value;
            selectedId[3] = document.getElementById('txtKDJBT_Diundang').value;
            selectedId[4] = document.getElementById('txtNIP_Diundang').value;
            if(document.getElementById('f_status').value ==='NEW') selectedId[5] = "<?php echo $this->session->userdata('s_uID'); ?>";
            if(document.getElementById('f_status').value ==='EDIT') selectedId[5] = "<?php echo isset($no_surat)?$no_surat:""; ?>";
            
            //var dataCount = $('#jqxgrid').jqxGrid('getrows');  
            //var jml=dataCount.length;  
            selectedId[6] =Math.floor(Math.random() * 1000);
            selectedId[7] ='1';
            $.ajax({
                url: "<?php echo base_url().'hr/surat/M_index/save_diundang'?>",
                type: 'POST',
                data: {json: JSON.stringify(selectedId)},
               // dataType: 'json',
                dataType: 'json',
                success: function (data) {
                    $("#jqxgrid").jqxGrid('updatebounddata');
                },
                error: function (data) {
                   // console.log(data);
                    console.log('error');
                }
            });  
        }
    }
    function show_dp(){
      $( "#txtTgl_surat" ).datepicker('show'); //Show on click of button
    }
    $(function() {
        var creat_by ='<?php echo isset($employee_pengirim)?$employee_pengirim:""; ?>';
        var uID= '<?php echo $this->session->userdata("s_uID"); ?>';
        var f_status='<?php echo $f_status; ?>';
        if((uID===creat_by && f_status==='EDIT')  || document.getElementById('f_status').value ==='NEW'){
            document.getElementById("btn_Tgl").style.display='block';
            document.getElementById("show_btn_submit").style.display='block';
         }else{
            document.getElementById("btn_Tgl").style.display='none';  //document.getElementById("show_btn_submit").style.display='none';
        }
    });
    function CEK_SUBMIT(){
        var name = $.trim($('#txtInduk').val());
        if (name === '') {
            alert('Kode Induk Tidak Boleh Kosong.');
            return false;
        }
        var name = $.trim($('#txtPrimer').val());
        if (name === '') {
            alert('Kode Primer Tidak Boleh Kosong.');
            return false;
        }
        var name = $.trim($('#txtSekunder').val());
        if (name === '') {
            alert('Kode Sekunder Tidak Boleh Kosong.');
            return false;
        }
        var name = $.trim($('#txtPerihal').val());
        if (name === '') {
            alert('Perihal Tidak Boleh Kosong.');
            return false;
        }
        var name = $.trim($('#txtTgl_surat').val());
        if (name === '') {
            alert('Tanggal Surat Tidak Boleh Kosong.');
            return false;
        }
         $("#fheader").submit();
    }
    
</script>    

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
                  <button id="btnHome"  type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 10px;margin-bottom: 2px;margin-top: -5px" data-dismiss="modal"><i class="fa fa-home fa-lg fa-3x" ></i></button>
                  <h3 class="box-title"><?php echo $title; ?><div id="lbl_tab_0"></div></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
            <?php if ($this->session->flashdata('message')) { ?>
               <div class="alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <strong>Info!</strong> <?php echo $this->session->flashdata('message'); ?>
             </div>
            <?php } ?>
           <!--    <button type="button" id="btnBatal" class="btn btn-primary" onclick="addRow()" style="margin-top:10px;margin-bottom:10px;margin-left:10px;">Tambah Data</button>
           -->
           </div>   
            <form role="form" id="fheader" class="form-horizontal" action="<?=base_url()?>hr/surat/M_index/f_submit" method="POST" enctype="multipart/form-data">
                <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
                <!--------------isi form <div class="modal-body"> ------------->
                     <div class="form-group" >
                        <div class="form-group" > <input type="hidden" id="txtStatus" name="txtStatus" >
                            <input type="hidden" id="txtKdPAT" name="txtKdPAT" > <input type="hidden" id="txtLampiran" name="txtLampiran" >
                        </div>
                        <div class="row">
                            <!--------menu tab--------->
                            <ul class="nav nav-pills">
                                <li class="tab active"><a data-toggle="pill" href="#home">Permintaan Nomor Surat</a></li>
                                <li><a class="tab" data-toggle="pill" href="#menu1">Tujuan Internal</a></li>
                                <li><a class="tab" data-toggle="pill" href="#menu3">Tujuan Eksternal</a></li>
                                <!--<li><a class="tab" data-toggle="pill" href="#menu2">Dibuat oleh</a></li>-->
                            </ul>
                            <div class="tab-content">
                                <div id="menu2" class="tab-pane fade">
                                  <!-- start row -->
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid">
                                       <!-- <div class="box-header">
                                          <h3 class="box-title">Dibuat Oleh</h3>
                                        </div>-->
                                           <!-- /.box-header -->
                                            <div class="box-body"> 
                                                <div class="row">
                                                      <div class="form-group" >
                                                            <label for="txtDibuat" class="col-sm-1 control-label">Nama Pegawai</label>
                                                            <div class="col-sm-4">  
                                                                <input type="text" id="txtDibuat" style="width:100%;" name="txtDibuat" value="<?php echo isset($nama_pengirim)?$nama_pengirim:""; ?>" class="form-control" required readonly>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                    <label for="txtJabatan" class="col-sm-1 control-label">Jabatan</label>
                                                    <div class="col-sm-4">  
                                                        <input type="text" id="txtJabatan" style="width:100%;" name="txtJabatan" value="<?php echo isset($jabatan_pengirim)?$jabatan_pengirim:""; ?>" class="form-control" required readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="txtBiro" class="col-sm-1 control-label">Biro/Bagian</label>
                                                    <div class="col-sm-4">  
                                                        <input type="text" id="txtBiro" style="width:100%;" name="txtBiro"  value="<?php echo isset($ket_gas_pengirim)?$ket_gas_pengirim:""; ?>" class="form-control" required readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="txtBiro" class="col-sm-1 control-label">Unit Kerja</label>
                                                    <div class="col-sm-4">  
                                                        <input type="text" id="txtUnit" style="width:100%;" name="txtUnit" value="<?php echo isset($ket_pat_pengirim)?$ket_pat_pengirim:""; ?>" class="form-control" required readonly>
                                                    </div>
                                                </div>
                                         
                                            </div>
                                          <!-- /.box-body -->
                                         </div>
                                    </div>
                                  </div>
                                  <!-- end row -->
                                </div>
                                <div id="home" class="tab-pane fade in active">
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <div class="box box-primary box-solid">
                                         <!-- <div class="box-header">
                                              <h3 class="box-title"><div id="lbl_tab_0"></div></h3>
                                          </div>-->
                                          <!-- /.box-header -->
                                          <div class="box-body"> 
                                                <div class="row">
                                                        <input type="hidden" id="f_status" style="width:100%" name="f_status" value="<?php echo isset($f_status)?$f_status:""; ?>" class="form-control" required readonly>
                                                        <label for="txtKet_masalah_induk" style="font-weight:bold;text-align: left" class="col-sm-2 control-label">*Kode Masalah Induk</label>
                                                            <div class="col-sm-2">  
                                                                <input type="text" id="txtInduk" style="width:100%;" name="txtInduk" value="<?php echo isset($kd_induk)?$kd_induk:""; ?>"  class="form-control" required >
                                                            </div>    
                                                        <div class="col-sm-7">  
                                                            <input type="text" id="txtKet_masalah_induk" style="width:100%;background-color : #eee;" name="txtKet_masalah_induk" value="<?php echo isset($ket_masalah_induk)?$ket_masalah_induk:""; ?>" class="form-control" required readonly>
                                                        </div>
                                                        <div class="col-sm-1"><button type="button" id="btnInduk" name="btnInduk"  class="btn btn-default pull-left" style="margin-right: 3px;margin-bottom: 5px;display:none;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                                                        </div>
                                                </div> 
                                                <div class="row">
                                                    <label for="txtKet_masalah_primer" style="font-weight:bold;text-align: left"  class="col-sm-2 control-label">*Kode Masalah Primer</label>
                                                    <div class="col-sm-2">  
                                                        <input type="text" id="txtPrimer" style="width:100%;" name="txtPrimer" value="<?php echo isset($kd_primer)?$kd_primer:""; ?>" class="form-control" required >
                                                    </div>    
                                                    <div class="col-sm-7">
                                                        <input type="text" id="txtKet_masalah_primer" style="width:100%;background-color : #eee;" name="txtKet_masalah_primer" value="<?php echo isset($ket_masalah_primer)?$ket_masalah_primer:""; ?>" class="form-control" required readonly>
                                                      <!--  <textarea id="txtKet_masalah_primer" name="txtKet_masalah_primer"  style="width:450px;height:50px;color:#336600;background-color : #eee;padding:10px; " readonly required><?php echo isset($ket_masalah_primer)?$ket_masalah_primer:""; ?></textarea>-->
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" id="btnPrimer" name="btnPrimer" class="btn btn-default pull-left" style="margin-right: 3px;margin-bottom: 5px;display:none;" data-dismiss="modal"><i class="fa fa-search"></i></button>
                                                   </div>
                                                </div>     
                                                <div class="row">
                                                        <label for="txtKet_masalah_sekunder" style="font-weight:bold;text-align: left"  class="col-sm-2 control-label">*Kode Masalah Sekunder</label>
                                                        <div class="col-sm-2">  
                                                            <input type="text" id="txtSekunder" style="width:100%;" name="txtSekunder" value="<?php echo isset($kd_sekunder)?$kd_sekunder:""; ?>" class="form-control"   autocomplete="off" required>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <textarea id="txtKet_masalah_sekunder" name="txtKet_masalah_sekunder"  style="width:100%;height:80px;color:#336600;background-color : #eee;padding:10px;" class="form-control"  readonly required><?php echo isset($ket_masalah_sekunder)? strtoupper($ket_masalah_sekunder):""; ?></textarea>
                                                        </div>
                                                        <div class="col-sm-1"><button id="btnSekunder" type="button" class="btn btn-default pull-left" style="margin-right: 3px;margin-bottom: 5px;display:none;" data-dismiss="modal"><i class="fa fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                <div class="row" style="background-color:#ffffff;width:99%">
                                                        <div class="row2" >
                                                             <div class="form-group">
                                                                 <label for="txtNo_surat" style="font-weight:bold;text-align: left"  class="col-sm-2 control-label">*No. Surat</label>
                                                                 <div class="col-sm-8">  
                                                                    <input type="text" id="txtNo_surat" name="txtNo_surat" placeholder="No. Dokumen (Otomatis)"  maxlength="35" style="width:40%;" name="txtNo_surat" value="<?php echo isset($no_surat)?$no_surat:""; ?>"  class="form-control" required >
                                                                 </div>
                                                             </div>
                                                        </div>
                                                        <div class="row2">
                                                            <!--<label for="txtTgl_surat" class="col-sm-1 control-label" style="text-align: left;font-weight: bold">Tgl. Surat</label>-->
                                                            <div class="form-group">
                                                                <label for="txtTgl_surat" style="font-weight:bold;text-align: left; "  class="col-sm-2 control-label">*Tgl. Surat</label>
                                                                <div class="col-sm-1">
                                                                   <input type="text" id="txtTgl_surat" placeholder="dd-mm-yyyy" style="width:120%;"  data-date-format='dd-mm-yyyy' name="txtTgl_surat" value="<?php echo isset($tgl_surat)?$tgl_surat:""; ?>" class="form-control" required  >
                                                                </div>
                                                                <div class="col-sm-1" id='btn_Tgl' style="width:5%;"><button type="button" id="btn_Tgl" name="btn_Tgl" onclick="show_dp();" class="btn btn-default pull-left" data-dismiss="modal"  ><i class="fa fa-calendar"></i></button>
                                                                </div>
                                                                <label for="txtTgl_input" style="font-weight:bold;text-align: right;margin-left: 10px "  class="col-sm-2 control-label">Tgl. Input</label>
                                                                <div class="col-sm-3">
                                                                   <input type="text" id="txtTgl_input" placeholder="dd-mm-yyyy" style="width:35%;margin-left: 20px " data-date-format='dd-mm-yyyy' name="txtTgl_input" value="<?php echo isset($created_date)?$created_date:""; ?>" class="form-control" required readonly>
                                                                </div>
                                                            </div>  
                                                        </div>  
                                                        <div class="row2">
                                                            <div class="form-group">
                                                                 <label for="txtPerihal" style="font-weight:bold;text-align: left; "  class="col-sm-2 control-label">*Perihal</label>
                                                                 <div class="col-sm-10">  
                                                                    <input type="text" id="txtPerihal" style="width:100%;" name="txtPerihal" value="<?php echo isset($perihal)?$perihal:""; ?>" class="form-control"  autocomplete="off" required >
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="row2" style="margin-bottom: 15px">
                                                                <div class="form-group" >
                                                                    <div id="show_upl_lampiran" style='margin-left:5px;margin-top:5px'></div>
                                                                    <div id="show_lampiran" style='margin-left:15px;margin-top:5px'></div>
                                                                </div>
                                                        </div>   
                                                        <div class="row2" style="margin-bottom: 15px">
                                                            <button id="nextbutton" type="button" value="" title="Isi Tujuan Surat Internal"  class="jqx-rc-all jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-widget jqx-widget-ui-start jqx-fill-state-normal jqx-fill-state-normal-ui-start" style="cursor:pointer;padding: 2px; margin: 1px;float:left;height:40px;width:90px;"  onclick="moveTab('menu1')"><i class="fas fa-forward fa-lg fa-fw">&nbsp</i>Berikut</button>
                                                        </div>
                                                </div>
                                          </div>
                                          <!-- /.box-body -->
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                  <h3></h3>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid">
                                        <!--<div class="box-header">
                                          <h3 class="box-title">Tujuan Surat</h3>
                                        </div>-->
                                        <!---------- isi ------------------>
                                        <!-- /.box-header -->
                                          <div class="box-body"> 
                                                <div class="row">
                                                    <div class="form-group" >
                                                        <div  id="jqxgrid" style="margin-top: 1px;width: 100%;" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div id="TombolSimpan"></div>
                                                </div>
                                          <!-- /.box-body --> 
                                        <!---------- end isi -------------->
                                       </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                                <div id="menu3" class="tab-pane fade">
                                  <h3></h3>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <div class="box box-primary box-solid">
                                        <!--<div class="box-header">
                                          <h3 class="box-title">Tujuan Surat</h3>
                                        </div>-->
                                        <!---------- isi ------------------>
                                        <!-- /.box-header -->
                                          <div class="box-body">
                                            <div class="row">
                                                <!------------Multiple input text ----------------->
                                                <div class="field_wrapper">
                                                    <div id="tujuanExt"></div>
                                                </div>
                                                <!------------end Multiple input text-------------->
                                            </div>
                                            <div class="row">
                                                <div id="TombolSimpan2"></div>    
                                            </div>  
                                           <!-- <div class="row">
                                                <div class="form-group" >  
                                                    <label for="txtTujuan_surat" class="col-sm-1 control-label" >Ditujukan Eksternal :</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="txtTujuan_surat" style="width:100%;margin-left: 40px;text-transform:uppercase" placeholder="isi untuk tujuan external"   name="txtTujuan_surat" value="<?php echo isset($tujuan_surat)?$tujuan_surat:""; ?>" class="form-control"  autocomplete="off" >
                                                    </div>
                                                </div>
                                            </div> -->
                                          <!-- /.box-body --> 
                                        <!---------- end isi -------------->
                                       </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                     
                            <!--------menu------------->
                        </div>     
                
                    <!--------------end isi form </div> --------->
                <div class="body-content animated fadeIn" style="background-color: #005000;color: #ffffff">
                </div><!-- /.body-content -->
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
<!-- modal   Lookup Kode Dokumen Induk -->
  <div class="modal fade" id="show_kdInduk" style="display: none;">
    <div class="modal-dialog " style="width:680px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Daftar Kode Induk<?php //echo isset($gridLUINDUK)?$gridLUINDUK:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="form-group">
                    <div class="containerInduk">
                    </div>
                </div>
                <?php //echo isset($gridLUINDUK)?$gridLUINDUK:""; ?>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUNINDUK()">OK</button>
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
<!-- modal   Lookup Kode Dokumen Primer -->
  <div class="modal fade" id="show_kdPrimer" style="display: none;">
    <div class="modal-dialog " style="width:680px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Daftar Kode Primer<?php //echo isset($gridLUINDUK)?$gridLUINDUK:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUPRIMER()">OK</button>
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
<!-- modal   Lookup Kode Dokumen Sekunder -->
  <div class="modal fade" id="show_kdSekunder" style="display: none;">
    <div class="modal-dialog " style="width:870px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Daftar Kode Sekunder<?php //echo isset($gridLUINDUK)?$gridLUINDUK:"";?></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="containerSekunder">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUSEKUNDER()">OK</button>
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
<!-- modal   Lookup Add Form Undangan -->
  <div class="modal fade" id="show_fUndangan" style="display: none;">
    <div class="modal-dialog " style="width:680px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><div id='judul_undangan'></div></h4>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="form-group" >
                            <label for="txtPAT_Diundang" class="col-sm-2 control-label">Unit Kerja</label>
                            <div class="col-sm-7">  
                                <input type="text" id="txtPATKET_Diundang" style="width:100%;" name="txtPATKET_Diundang" class="form-control" required readonly>
                                <input type="hidden" id="txtPAT_Diundang" style="width:95%;" name="txtPAT_Diundang" class="form-control" required readonly>
                                <input type="hidden" id="txtSEQ_Diundang" style="width:95%;" name="txtSEQ_Diundang" class="form-control" required readonly>
                            </div>
                            <div class="col-sm-1"><button type="button" id="btnFindPAT" name="btnFindPAT"  class="btn btn-default pull-left" style="margin-left: 12px;margin-right: 5px;margin-bottom: 5px;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                            </div>
                    </div>  
                </div>    
                <div class="row">
                    <div class="form-group" >
                            <label for="txtGAS_Diundang" class="col-sm-2 control-label">Biro/Seksi</label>
                            <div class="col-sm-7">  
                                <input type="text" id="txtGASKET_Diundang" style="width:100%;" name="txtGASKET_Diundang" class="form-control" required readonly>
                                <input type="hidden" id="txtGAS_Diundang" style="width:95%;" name="txtGAS_Diundang" class="form-control" required readonly>
                                <input type="hidden" id="txtKDJBT_Diundang" style="width:100%;" name="txtKDJBT_Diundang" class="form-control" required readonly>
                            </div>
                            <div class="col-sm-1"><button type="button" id="btnFindGAS" name="btnFindGAS"  class="btn btn-default pull-left" style="margin-left: 12px;margin-right: 5px;margin-bottom: 5px;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                            </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="form-group" >
                            <label for="txtNIP_Diundang" class="col-sm-2 control-label">Nama Pegawai</label>
                            <div class="col-sm-7">  
                                <input type="text" id="txtNama_Diundang" style="width:100%;" name="txtNama_Diundang" class="form-control" required readonly>
                                <input type="hidden" id="txtNIP_Diundang" style="width:95%;" name="txtNIP_Diundang" class="form-control" required readonly>
                            </div>
                            <div class="col-sm-1" id='btn_LUNIPinvite'><button type="button" id="btnFindNIP" name="btnFindNIP"  class="btn btn-default pull-left" style="margin-left: 12px;margin-right: 5px;margin-bottom: 5px;" data-dismiss="modal"  ><i class="fa fa-search"></i></button>
                            </div>
                    </div>
                </div>    
            </div>
            <div class="form-group">
                <div class="col-sm-8">  
                    <button type="button" class="btn btn-default pull-left" style="margin-left: 10px;margin-right: 5px;margin-bottom: 5px" data-dismiss="modal">Close</button>
                    <div id='inviteBtnSave' class="col-sm-1"><button type="button" id="btnModalSubmit" name="btnModalSubmit" style="margin-left: 5px;margin-bottom: 5px;" class="btn btn-primary" onclick="submitLUINVITE()">OK</button></div>
                    <div id='inviteBtnDel' class="col-sm-1"><button type="button" id="btnModalDEL" name="btnModalDEL" style="margin-left: 5px;margin-bottom: 5px;" class="btn btn-primary" onclick="DelINVITE()">Hapus</button></div>
              
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
<!-- modal   Lookup Kode Dokumen Primer -->
  <div class="modal fade" id="show_LU" style="display: none;">
    <div class="modal-dialog " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><div id="jdlLU"></div></h4>
          <input type="hidden" id="txtJnsLU" style="width:100%;" name="txtJnsLU" class="form-control" required readonly>
        </div>
        <form role="form" class="form-horizontal" action="#" >
        <div class="modal-body">
            <div class="form-group">
                <div class="containerLU">
                </div>
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
