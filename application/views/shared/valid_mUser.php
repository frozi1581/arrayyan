    <style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>


    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tooltip.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidgets/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
    
<!--     <script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.11.1.min.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidgets/jqxdropdownlist.js"></script>
   
    
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small><?php echo $title; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Data Pegawai</a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content demo">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
               <!--<h3 class="box-title"><?php echo $title; ?></h3><br>-->
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i><h> Info </h4>
                <?php echo $this->session->flashdata('message'); ?>
              </div>
            <?php } ?>
  
            <!-- /.box-header -->
            <!-- form start -->
            <input name='statEdit' id='statEdit' type="hidden" value="<?php echo $statEdit ?>">
            <input name='idUser' id='idUser' type="hidden" value="<?php echo $nip ?>">
            <input name='baseurl' id='baseurl' type='hidden' value="<?=base_url()?>">
            <input name='statEdit' type="hidden" value="<?php echo $statEdit ?>">
            <script type="text/javascript">
                var r_data=[];
                var id_user=document.getElementById('idUser').value;
                $(document).ready(function () {
                    $.ajax({
                            url: "<?php echo base_url().'Personal2/contentManagement/valid_m_userJQW/'?>"+id_user,
                            type: 'POST',
                            dataType: 'json',
                    success: function ( data) {
                        
                             var jml_a        = data.user_a.length;
                             var id_a         = data.id_a;
                             var nip_a        = data.nip_a;
                             var photo_a      = data.photo_a;
                             var user_a       = data.user_a;
                             var ppu_a        = data.ppu_a;
                             var bagian_a     = data.bagian_a;
                             var info_a       = data.info_a;  
                             var approve_a    = data.approve_a;  
                             view_grid_a(jml_a,id_a,nip_a,photo_a,user_a,ppu_a,bagian_a,info_a,approve_a);
                            },
                            error: function ( data ) {
                                console.log('error');
                            }
                        });
                });
                //-------------------------------------------------------
                 function  view_grid_a(jml_a,id_a,nip_a,photo_a,user_a,ppu_a,bagian_a,info_a,approve_a){
                        var seq=parseInt(jml_a);
                        r_data=[];
                        for(i=0;i<seq;i++){
                                var row=[];
                                row["link"]     = 'Approve';
                                row["viewf"]    = 'View';
                                row["id_a"]     = id_a[i];
                                row["nip_a"]    = nip_a[i];
                                row["photo_a"]  = photo_a[i];
                                row["user_a"]   = user_a[i];
                                row["ppu_a"]    = ppu_a[i];
                                row["bagian_a"] = bagian_a[i];
                                row["info_a"]   = info_a[i];
                                row["approve_a"]= approve_a[i];
                                r_data[i]=row;
                        };
                        var source = {
                              localdata:r_data,
                              datatype:"array",
                              datafields:
                                    [{name:'link',type:'string'}
                                    ,{name:'viewf',type:'string'}
                                    ,{name:'id_a',type:'string'}
                                    ,{name:'nip_a',type:'string'}
                                    ,{name:'photo_a',type:'string'}
                                    ,{name:'user_a',type:'string'}
                                    ,{name:'ppu_a',type:'string'}
                                    ,{name:'bagian_a',type:'string'}
                                    ,{name:'info_a',type:'string'}
                                    ,{name:'approve_a',type:'string'}
                                    ]
                                ,root: 'DATA'
                                ,record: 'ROW'
                        };
                    var dataAdapter = new $.jqx.dataAdapter(source);
                    var linkrenderer = function (row, column, value) {
                        if (value.indexOf('#') !== -1) {
                            value = value.substring(0, value.indexOf('#'));
                        }
                      // var nip=(document.getElementById('idUser').value).trim();
                       var html1 = '<a target="_self" href="'+(document.getElementById('baseurl').value).trim()+ 'Personal2/valid_m_users/'+r_data[row].nip_a+'/'+r_data[row].id_a+'" title="Approve"><i class="fa fa-check " aria-hidden="true"></i></a>';
                       var html = html1; 
                       return html;
                    };
                    var linkrenderer2 = function (row, column, value) {
                        if (value.indexOf('#') !== -1) {
                            value = value.substring(0, value.indexOf('#'));
                        }
                      // var nip=(document.getElementById('idUser').value).trim();
                       var html1 = '<a target="_blank" href="'+(document.getElementById('baseurl').value).trim()+ 'data_uploads/photo_profile/'+r_data[row].photo_a+'"   title="Zoom Out">  \n\
                                    <img src="'+(document.getElementById('baseurl').value).trim()+ 'data_uploads/photo_profile/'+r_data[row].photo_a+'" style="width:100%;height:100%;"></a>';            
                       return html1;
                    };
                    var linkrenderer3 = function (row, column, value) {
                        if (value.indexOf('#') !== -1) {
                            value = value.substring(0, value.indexOf('#'));
                        }
                      // var nip=(document.getElementById('idUser').value).trim();
                        if(r_data[row].approve_a==='Y'){
                           html='<mark>Approved</mark>';
                        }else{
                            html='<mark>Request</mark>';
                        }    
                       return html;
                    };
                    
                    
                    
                   // $("#updaterowbutton").jqxButton({ theme: theme });
                    // --------- update row--------------.
                    $("#updaterowbutton").bind('click', function () {
                        //var datarow = generaterow();
                        var selectedrowindexs = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        var selectedId = [];
                        for (var index in selectedrowindexs){
                            if(selectedrowindexs[index]!==-1){
                                selectedId[index]= r_data[selectedrowindexs[index]].id_a+','+r_data[selectedrowindexs[index]].user_a;
                            }   
                        }
                        if(selectedId.length>0){
                            $(document).ready(function () {
                                $.ajax({
                                        url: "<?php echo base_url().'Personal2/valid_m_users'?>",
                                        type: 'POST',
                                        data: {json: JSON.stringify(selectedId)},
                                       // dataType: 'json',
                                       dataType: 'text',
                                        success: function (data) {
                                            window.location.reload(true);
                                        },
                                        error: function (data) {
                                            console.log('error');
                                        }
                                    });
                            });
                        }
                    });
                    // --------- Delete row--------------.
                    $("#deleterowbutton").bind('click', function () {
                        //var datarow = generaterow();
                        var selectedrowindexs = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        var selectedId = [];
                        for (var index in selectedrowindexs){
                            if(selectedrowindexs[index]!==-1){
                                selectedId[index]= r_data[selectedrowindexs[index]].id_a+','+r_data[selectedrowindexs[index]].user_a;
                            }   
                        }
                        if(selectedId.length>0){
                            $(document).ready(function () {
                                $.ajax({
                                        url: "<?php echo base_url().'Personal2/delete_m_users'?>",
                                        type: 'POST',
                                        data: {json: JSON.stringify(selectedId)},
                                        dataType: 'json',
                                        success: function (data) {
                                            window.location.reload(true);
                                        },
                                        error: function (data) {
                                            console.log('error');
                                        }
                                    });
                            });
                        }
                    });
                    // --------- Disable User--------------.
                    $("#disablerowbutton").bind('click', function () {
                        //var datarow = generaterow();
                        var selectedrowindexs = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        var selectedId = [];
                        for (var index in selectedrowindexs){
                            if(selectedrowindexs[index]!==-1){
                                selectedId[index]= r_data[selectedrowindexs[index]].id_a+','+r_data[selectedrowindexs[index]].user_a;
                            }   
                        }
                        if(selectedId.length>0){
                            $(document).ready(function () {
                                $.ajax({
                                        url: "<?php echo base_url().'Personal2/disable_m_users'?>",
                                        type: 'POST',
                                        data: {json: JSON.stringify(selectedId)},
                                        dataType: 'json',
                                        success: function (data) {
                                            window.location.reload(true);
                                        },
                                        error: function (data) {
                                            console.log('error');
                                        }
                                    });
                            });
                        }
                    });

                    
                    var divlok='#jqxgrid'; var dataAd=dataAdapter;
                    $(divlok).jqxGrid( //jqxDataTable(
                          {
                              source: dataAd,
                              pageable: true,
                             // autowidth: true,
                              theme: 'energyblue',
                             // altRows: true,
                              filterable: true,
                              selectionmode: 'checkbox',
                              //autoresize: true,
                              width: '100%',
                              rowsheight:50,
                              columns: [
                               // { text: 'Action', datafield: 'link', width: '5%', cellsrenderer: linkrenderer},
                                { text: 'NIP', cellsAlign: 'left', cellsformat: 'd', align: 'left', dataField: 'nip_a', width:  "8%" },
                                { text: 'Nama Pegawai', cellsAlign: 'left', cellsformat: 'd', align: 'left', dataField: 'user_a', width:  "18%" },
                                { text: 'PAT', dataField: 'ppu_a', cellsformat: 'd', cellsAlign: 'left', align: 'left', width:  "15%" },
                                { text: 'Nama Bagian', dataField: 'bagian_a', cellsformat: 'd', cellsAlign: 'left',width:  "20%"},
                                { text: 'Info Device', dataField: 'info_a', cellsformat: 'd', cellsAlign: 'left',width:  "15%"},
                                { text: 'Status', datafield: 'link', width: '8%', cellsrenderer: linkrenderer3},
                                { text: 'Photo',  width: '10%', cellsAlign : 'center', cellsrenderer: linkrenderer2}
                               ]
                          });
                        return;
                }
                </script>
                    <button id="updaterowbutton" type ='button' class="btn btn-facebook pull-left" style="position: relative" data-tooltip='Approve User'>
                            <i class="fa fa-check-square" aria-hidden="true"></i> 
                    </button>
                    <button id="deleterowbutton" type="button" class="btn btn-facebook pull-left"  style="position: relative"  data-tooltip='Delete User' >
                        <i class="fa fa-trash-o" aria-hidden="true"></i> 
                    </button>                    
                    <button id="disablerowbutton" type="button" class="btn btn-facebook pull-left"  style="position: relative"  data-tooltip='non Active User' >
                        <i class="fa fa-chain-broken" aria-hidden="true"></i> 
                    </button>
                <div  id="jqxgrid" style="margin-top: 1px;width: 100%">
                <div style="margin-top: 1px" id="jqxlistbox"></div>	
                </div>
                
                    
                </div>
      <!-- /.row -->

    </section
    >
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
