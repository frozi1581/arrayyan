<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
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

<!-- START @THEME STYLES -->
<link href="<?php echo base_url('assets/admin/css/components.css'); ?>" rel="stylesheet">
<!-- CSS page -->

<style type="text/css">
    .modal {
        max-height: calc(100% - 100px);
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .select select {
        cursor: pointer;
        display: block;
        font-size: 1em;
        max-width: 100%;
        outline: 0;
    }

    tr.odd td:first-child,
    tr.even td:first-child {
        padding-left: 4em;
    }

    .dropdownFilter {
        margin: 0px;
        width: 120px;
        font-size: 16px;
        border: 1px solid #ccc;
        height: 34px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: aqua;
    }

    
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row" style="border-bottom: 0.5px solid red;">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-aqua">
                      <i class="far fa-building"></i>
                  </span>
                    <div class="info-box-content">
                        <span class="info-box-text">PT WIJAYA KARYA, TBK</span>
                        <span class="info-box-number" id="lbrwika">0</span>
                        <small><i>lembar</i></small>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-blue">
                      <i class="far fa-archway"></i>
                  </span>
                    <div class="info-box-content">
                        <span class="info-box-text">PT WIKA BETON, TBK</span>
                        <span class="info-box-number" id="lbrwton">0</span>
                        <small><i>lembar</i></small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-green">
                      <i class="far fa-warehouse"></i>
                  </span>
                    <div class="info-box-content">
                        <span class="info-box-text">PT WIKA GEDUNG, TBK</span>
                        <span class="info-box-number"  id="lbrwege">0</span>
                        <small><i>lembar</i></small>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-red">
                      <i class="far fa-house"></i>
                  </span>
                    <div class="info-box-content">
                        <span class="info-box-text">PT WIKA REALTY</span>
                        <span class="info-box-number" id="lbrwr">0</span>
                        <small><i>lembar</i></small>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <span class="info-box-icon bg-yellow">
                      <i class="far fa-construction"></i>
                  </span>
                    <div class="info-box-content">
                        <span class="info-box-text">PT WIKON</span>
                        <span class="info-box-number" id="lbrwikon">0</span>
                        <small><i>lembar</i></small>
                    </div>
                </div>
            </div>

        </div>
        <br/>


        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!------------  table ------------------------------->
                <!-- Start body content -->
                <div class="col-md-1">
                <button id="btnAddNew" class="btn btn-primary" style="margin-bottom: 20px;"><i class="far fa-plus">&nbsp;Tambah Pengajuan</i></button>
                </div>
                <div class="col-md-2">
                    <div class="input-group" style="margin-left:20px;">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" onclick="javascript:toggleLapBulPenjualan();"><span>Lap. Bulanan <i class="fas fa-file-pdf fa-lg"></i></span></button>
                        </span>
                        <div class="input-group" id="dvLapBulananPenjualan" style="display:none;">
                            <select id="filterBln" class="dropdownFilter">
                                <?php
                                    
                                    $arrBln=array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"Nopember", "12"=>"Desember");
                                    for($x=1;$x<=12;$x++){
                                        if($x==Date("m")){
	                                        echo "<option selected value='".sprintf("%02d",$x)."'>".$arrBln[sprintf("%02d",$x)]."</option>";
                                        }else{
	                                        echo "<option value='".sprintf("%02d",$x)."'>".$arrBln[sprintf("%02d",$x)]."</option>";
                                        }
                                        
                                    }
                                ?>
                               
                            </select>
                            <select id="filterThn" class="dropdownFilter">
	                            <?php
		                            $x = Date("Y");
		                            for($x=Date("Y")-5;$x<=Date("Y");$x++){
                                        if($x==Date("Y")){
	                                        echo "<option selected value='$x'>$x</option>";
                                        }else{
	                                        echo "<option value='$x'>$x</option>";
                                        }
			                            
		                            }
	                            ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="javascript:genLapBulanan();"><span><i class="far fa-download fa-lg"></i></span></button>
                            </span>
                        </div>
                    </div>
                </div>
                <table id="tblKepemilikan" class="display" style="width:100%;">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Group ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Unit Kerja</th>
                        <th>Kode Emiten</th>
                        <th>Sekuritas</th>
                        <th>Tgl Pengajuan</th>
                        <th>Vol (lbr)</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah (Rp)</th>
                        <th>Status</th>
                        <th>Tgl Proses</th>
                        <th>Tgl Terjual</th>
                        <th>Terima Dari Sekuritas</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Group ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Unit Kerja</th>
                        <th>Kode Emiten</th>
                        <th>Sekuritas</th>
                        <th>Tgl Pengajuan</th>
                        <th>Vol (lbr)</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah (Rp)</th>
                        <th>Status</th>
                        <th>Tgl Proses</th>
                        <th>Tgl Terjual</th>
                        <th>Terima Dari Sekuritas</th>
                        
                    </tr>
                    </tfoot>
                </table>
				
				
				
				
				<?php
				
				
				?>
                <!-- /.body-content -->
                <!--/ End body content -->
                <!------------ end table ---------------------------->

            </div>


        </div>
        <!-- /.box -->

        <!--/.col (left) -->
</div>
<!-- /.row -->

</section
>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
    function genLapBulanan(){
        
        var ithn = $('#filterThn').val();
        var ibln = $('#filterBln').val();
        console.log(ithn + '-' + ibln);
        window.open('https://kkms.wika-beton.net/kkms/M_penjualan2/genLapRekapBulanan?iblnfilter='+ibln+'&ithnfilter='+ithn);
    }
    function toggleLapBulPenjualan(){
        $('#dvLapBulananPenjualan').toggle(750);
        
    }
    
    function openPrintLap(idbatch){
        window.open('https://kkms.wika-beton.net/kkms/M_penjualan2/genLapRekapharian?iidbatch='+idbatch);
    }
    
    function setTerjual(kodeemiten, sekuritas){
        window.location.href='https://kkms.wika-beton.net/kkms/M_penjualan2/setTerjualForm?kodeemiten=' + kodeemiten + '&sekuritas=' + encodeURIComponent(sekuritas);
    }

    function setTerjualEdit(kodeemiten, sekuritas, idbatch){
        window.location.href='https://kkms.wika-beton.net/kkms/M_penjualan2/setTerjualForm?kodeemiten=' + kodeemiten + '&sekuritas=' + encodeURIComponent(sekuritas) + '&idbatch=' + idbatch;
    }

    function setTerjualDel(kodeemiten, sekuritas, idbatch){
        var theres = confirm('Yakin Batalkan Penjualan ini ?');
        if (theres == true) {
            window.location.href = 'https://kkms.wika-beton.net/kkms/M_penjualan2/setTerjualFormDel?kodeemiten=' + kodeemiten + '&sekuritas=' + encodeURIComponent(sekuritas) + '&idbatch=' + idbatch;
        }
    }
    
    
    function delRowData(idrec){
        var theres = confirm('Yakin hapus data ini ?');
        if (theres == true) {
            window.location.href='https://kkms.wika-beton.net/kkms/M_penjualan2/deleteData?iID=' + idrec;
        }
    }
    function editPengajuan(idrec){
        window.location.href='https://kkms.wika-beton.net/kkms/M_penjualan2/editData?idrec=' + idrec;
    }
    
    $(document).ready(function() {
        $('#btnAddNew').on('click',function(){
            window.location.href='https://kkms.wika-beton.net/kkms/M_penjualan2/addNewData';
        });
        $.fn.dataTable.ext.errMode = 'none';
        $('#tblKepemilikan').DataTable( {
            pageLength: 10,
            filter: true,
            deferRender: true,
            "ajax": 'https://kkms.wika-beton.net/kkms/M_penjualan2/getgridData',
            "fnInitComplete": function(oSettings, json) {
                //console.log(json['total'][0]);
                $('#lbrwika').html(json['total'][0]);
                $('#lbrwton').html(json['total'][1]);
                $('#lbrwege').html(json['total'][2]);
                $('#lbrwr').html(json['total'][3]);
                $('#lbrwikon').html(json['total'][4]);
            },
            "order": [[ 12, "desc" ],[0, "desc"]],
            responsive:true,
            rowGroup: {
                dataSrc: 2,
                startRender: function ( rows, group ) {
                    //console.log(rows.data()[0]);
                    //console.log();
                    var batchid = rows.data()[0][0];
                    var statusjual = rows.data()[0][12];
                    var kodeemiten = rows.data()[0][6];
                    var sekuritas = rows.data()[0][7];
                    
                    if(statusjual=='PENGAJUAN'){
                        return '&nbsp<button class="btn btn-primary" onclick="javascript:setTerjual(\'' + kodeemiten + '\',\'' + sekuritas + '\');"><i class="far fa-check"></i></button>&nbsp;&nbsp;' + group;
                    }else{
                        return '&nbsp;<button class="btn btn-warning" onclick="javascript:setTerjualEdit(\'' + kodeemiten + '\',\'' + sekuritas + '\',\'' + batchid + '\');"><i class="far fa-edit"></i></button>&nbsp;<button class="btn btn-danger" onclick="javascript:setTerjualDel(\'' + kodeemiten + '\',\'' + sekuritas + '\',\'' + batchid + '\');"><i class="far fa-trash"></i></button>&nbsp;<button class="btn btn-primary" onclick="javascript:openPrintLap('+batchid+');"><i class="far fa-print"></i></button>&nbsp;&nbsp;' + group;
                    }
                    
                }
            },
            columnDefs: [
                {
                    targets: [1,2,6,7,13,14,15],
                    visible: false
                },
                {
                  targets:[0],
                    "render": function ( data, type, row ) {
                        var statusjual = row[12];
                        var idrec = row[1];
                        if(statusjual=='PENGAJUAN'){
                            return '&nbsp;<button class="btn btn-warning" onclick="javascript:editPengajuan('+idrec+');"><i class="far fa-edit"></i></button>&nbsp;<button class="btn btn-danger" onclick="javascript:delRowData('+idrec+');"><i class="far fa-trash"></i></button>';
                        }else{
                            return '';
                        }
                        
                    },
                    className: 'dt-body-center dt-head-center'
                },
                {
                    targets: [12],
                    "render": function ( data, type, row ) {
                        if(data=='TERJUAL'){
                            return ' <i class="fas fa-check fa-lg"></i>';
                        }else{
                            return data;
                        }
                        
                    },
                    className: 'dt-body-center dt-head-center'
                },
                {
                    targets: [9,10,11],
                    className: 'dt-body-right dt-head-right'
                }
            ]
        } );
    } );
</script>
