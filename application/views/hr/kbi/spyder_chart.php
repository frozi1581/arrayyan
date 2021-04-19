
<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>JavaScript Spider Chart Example</title>
    <meta name="description" content="This is an exmaple of Javascript Spider Chart series." />
    <link rel="stylesheet" href="<?php echo base_url(); ?>jqwidget/jqwidgets/styles/jqx.base.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />	
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxslider.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxradiobutton.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqwidget/jqwidgets/jqxdropdownlist.js"></script>
    
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
    
    <style>
        table, th, td {
            /*border: 1px solid black;*/
            border-collapse: collapse;
        }
        th, td {
            padding: 3px;
        }
        .jqx-chart-axis-description
        {
            color: #555555;
            font-size: 11px;
            font-family: Verdana;
        }
        span2 {background-color: #00733e;font-size: 22px;color:#010f18;
            
        }
        .btn {
            border: none;
            color: white;
            padding: 2px 18px;
            font-size: 12px;
            cursor: pointer;
        }
        
    </style>
   
    <script type="text/javascript">
        $(document).ready(function () {
            //var jml= document.getElementById("jml_kbi").value;
            var datas=[];
            var selectedId=[];
            selectedId[0] = document.getElementById("txtBL").value;
            selectedId[1] = replaceAll(document.getElementById("txtST_DATE").value,'/','-');
            selectedId[2] = replaceAll(document.getElementById("txtEND_DATE").value,'/','-');
            selectedId[3] = document.getElementById("txtNIP").value;
            selectedId[4] = document.getElementById("txtIS_MANAGER").value; 
            $.ajax({
            url: "<?php echo base_url().'hr/kbi/M_index/V_KBI_RESULT'?>",
            type: 'POST',
            data: {json: JSON.stringify(selectedId)},
            dataType: 'json',
            success: function (data) {
               //console.log(data); 
               if(data['GET_KBI'].length>0){
                    var jml_soal=data['GET_KBI'][0]['SOAL'].length;
                    var ds = new Array();var ds2 = new Array();ds_pivot= new Array();
                    var a_atasan = new Array();var a_self = new Array();
                    var a_peer1 = new Array();var a_peer2 = new Array();
                    var a_bwh1 = new Array();var a_bwh2 = new Array();var a_bwh3 = new Array();
                    var tot_nilai = {};
                    for(x=0;x<jml_soal;x++){tot_nilai[x]=0;
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
                            row_["ik_bobot"]=parseFloat(Math.round((data['GET_KBI'][i]['IK_BOBOT'][x]) * 100) / 100).toFixed(2);          //(data['GET_KBI'][i]['IK_BOBOT'][x]);
                            row_pv["ik_skor"]=data['GET_KBI'][i]['IK_SKOR'][x];
                            row_pv["ik_bobot"]=parseFloat(data['GET_KBI'][i]['IK_BOBOT'][x]);        //parseFloat(Math.round((data['GET_KBI'][i]['IK_BOBOT'][x]) * 100) / 100).toFixed(2); //data['GET_KBI'][i]['P_BOBOT'];
                            row_pv["ik_persen"]=parseFloat(data['GET_KBI'][i]['P_BOBOT']);
                            row_pv["status"]=data['GET_KBI'][i]['STATUS_PENILAI'];
                           //console.log(x+' : '+data['GET_KBI'][i]['PENILAI'].italics()+' * '+data['GET_KBI'][i]['SOAL'][x].toUpperCase()+' * '+data['GET_KBI'][i]['SOAL_IK'][x].toUpperCase());
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
                            var nilai_=parseFloat(data['GET_KBI'][i]['IK_BOBOT'][x]);
                            var subtot =tot_nilai[x] +nilai_;
                            tot_nilai[x]=subtot;
                            kriteria_[x]=data['GET_KBI'][i]['SOAL'][x].toUpperCase();
                        }
                     }
                    var html= "<div align='center'><table border='0'>\n\
                                            \n\<tr><td>Nama</td><td>:</td><td>"+data['GET_KBI'][0]['NAMA_DINILAI']+"</td></tr>\n\
                                            <tr><td>Jabatan</td><td>:</td><td>"+data['GET_KBI'][0]['KET_JBT_DINILAI']+"</td></tr>\n\
                                            <tr><td>Lokasi Kerja</td><td>:</td><td>"+data['GET_KBI'][0]['KET_PAT_DINILAI']+"</td></tr>\n\
                                            <tr><td>Bagian Kerja</td><td>:</td><td>"+data['GET_KBI'][0]['KET_GAS_DINILAI']+"</td></tr>\n\
                                            </table>"  ;
                    document.getElementById("judul_kbi").innerHTML =html;
                    //document.getElementById("judul_pivot").innerHTML =html;
                }
                var p_header=0,bb_tot=0;r_b_bwh=0;n_kbi_std=3;
                var datas=[];  //--------------- array data grafik
                for(i=0;i<ds_pivot.length;i++){
                     var s_atasan='',b_atasan=0,p_atasan='',s_peer1='',b_peer1=0,p_peer1='',s_peer2='',b_peer2=0,p_peer2='', s_bwh1=0,b_bwh1=0,p_bwh1='';
                     var s_bwh2=0,b_bwh2=0,p_bwh2='',s_bwh3=0,b_bwh3=0,p_bwh3='',s_self=0,b_self=0,p_self='';
                     if(a_atasan.length>0){s_atasan=a_atasan[i]['ik_skor'];b_atasan=a_atasan[i]['ik_bobot'];p_atasan=a_atasan[i]['ik_persen'];      }
                     if(a_peer1.length>0){s_peer1=a_peer1[i]['ik_skor'];b_peer1=a_peer1[i]['ik_bobot'];p_peer1=a_peer1[i]['ik_persen'];}
                     if(a_peer2.length>0){s_peer2=a_peer2[i]['ik_skor'];b_peer2=a_peer2[i]['ik_bobot'];p_peer2=a_peer2[i]['ik_persen'];}
                     if(a_bwh1.length>0){s_bwh1=a_bwh1[i]['ik_skor'];b_bwh1=a_bwh1[i]['ik_bobot'];p_bwh1=a_bwh1[i]['ik_persen'];}
                     if(a_bwh2.length>0){s_bwh2=a_bwh2[i]['ik_skor'];b_bwh2=a_bwh2[i]['ik_bobot'];p_bwh2=a_bwh2[i]['ik_persen'];}
                     if(a_bwh3.length>0){s_bwh3=a_bwh3[i]['ik_skor'];b_bwh3=a_bwh3[i]['ik_bobot'];p_bwh3=a_bwh3[i]['ik_persen'];}
                     if(a_self.length>0){s_self=a_self[i]['ik_skor'];b_self=a_self[i]['ik_bobot'];p_self=a_self[i]['ik_persen'];}
                     if(document.getElementById("txtIS_MANAGER").value==='1'){
                        var cnt_bwh=0;
                        if(s_bwh1>0) cnt_bwh++;
                        if(s_bwh2>0) cnt_bwh++;
                        if(s_bwh3>0) cnt_bwh++;
                        var r_s_bwh=( parseInt(s_bwh1) +parseInt(s_bwh2)+parseInt(s_bwh3))/cnt_bwh;
                        var r_b_bwh=( b_bwh1 +b_bwh2+b_bwh3)/cnt_bwh;
                    }else{var b_bwh1=0;}
                    var b_subtot=b_atasan+b_peer1+b_peer2+r_b_bwh+b_self;
                    bb_tot=bb_tot+b_subtot;

                    //---------------------- add ds summary kbi -------------------------
                /*    var row_ = {};
                    row_["soal"]=ds_pivot[i];
                    row_["nilai"]=b_subtot.toFixed(2);
                    ds2.push(row_);*/
                    //---------------------- end add ds summary kbi -------------------------
                     if(p_header===0){
                         p_header=1;
                        if(document.getElementById("txtIS_MANAGER").value==='1'){
                            $header_pv="<table border='1' cellpadding='10' style='width:100%;height:100%;table-layout:fixed;overflow:hidden'><tr style='font-weight:bold;text-align:center'><td rowspan='3' width='3%'>NO</td><td rowspan='3' width='20%'>KRITERIA PENILAIAN</td><td colspan='13' align='center'>TABULASI PENILAIAN</td><td rowspan='3'>NILAI KBI</td></tr>\n\
                             <tr style='font-weight:bold;text-align:center'><td colspan='2'>ATASAN LANGSUNG</td><td colspan='2'>PEER 1</td><td colspan='2'>PEER 2</td>\n\
                             <td rowspan='2' width='15%'>BAWAHAN<br>(1)</td><td rowspan='2' width='15%'>BAWAHAN<br>(2)</td><td rowspan='2' width='8%'>BAWAHAN<br>(3)</td>\n\
                             <td colspan='2'>BAWAHAN</td><td colspan='2'>DIRI SENDIRI</td></tr>\n\
                             <tr style='font-weight:bold;text-align:center'><td width='7%'>SCORE</td><td width='7%'>BOBOT<br>("+p_atasan+"%)</td><td style='width: 20px'>SCORE</td><td width='8%'>BOBOT<br>("+p_peer1+"%)</td><td style='width: 20px'>SCORE</td><td width='8%'>BOBOT<br>("+p_peer2+"%)</td>\n\
                             <td>SCORE</td><td>BOBOT<br>("+p_bwh1+"%)</td><td>SCORE</td><td>BOBOT<br>("+p_self+"%)</td></tr>"; 
                       }else{
                            $header_pv="<table border='1' cellpadding='10' style='width:100%;height:100%;table-layout:fixed;overflow:hidden'><tr style='font-weight:bold;text-align:center'><td rowspan='3' width='3%'>NO</td><td rowspan='3' width='25%'>KRITERIA PENILAIAN</td><td colspan='8' align='center'>TABULASI PENILAIAN</td><td rowspan='3'>NILAI KBI</td></tr>\n\
                             <tr style='font-weight:bold;text-align:center'><td colspan='2'>ATASAN LANGSUNG</td><td colspan='2'>PEER 1</td><td colspan='2'>PEER 2</td>\n\
                             <td colspan='2'>DIRI SENDIRI</td></tr>\n\
                             <tr style='font-weight:bold;text-align:center'><td width='7%'>SCORE</td><td width='7%'>BOBOT<br>("+p_atasan+"%)</td><td style='width: 20px'>SCORE</td><td style='width: 20px'>BOBOT<br>("+p_peer1+"%)</td><td style='width: 20px'>SCORE</td><td style='width: 20px'>BOBOT<br>("+p_peer2+"%)</td>\n\
                             <td>SCORE</td><td>BOBOT<br>("+p_self+"%)</td></tr>"; 
                       }
                       $header_sum="<table border='1' cellpadding='10' style='width:100%;height:100%;table-layout:fixed;overflow:hidden'><tr style='font-weight:bold;text-align:center'><td width='3%'>NO</td><td  width='20%'>KRITERIA PENILAIAN</td><td align='center' width='12%'>KBI INDIVIDU</td><td align='center' width='12%'>KBI STANDAR</td><td align='center' width='12%'>KBI FIT</td></tr>";
                     }

                    var no_urut=i+1;
                    if(document.getElementById("txtIS_MANAGER").value==='1'){
                         $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td>"+no_urut+"</td><td style='font-weight:bold;text-align:left'>"+ds_pivot[i]+"</td>\n\
                        <td>"+s_atasan+"</td><td>"+b_atasan.toFixed(2)+"</td><td>"+s_peer1+"</td><td>"+b_peer1.toFixed(2)+"</td><td>"+s_peer2+"</td><td >"+b_peer2.toFixed(2)+"</td>\n\
                        <td>"+s_bwh1+"</td><td>"+s_bwh2+"</td><td>"+s_bwh3+"</td><td>"+r_s_bwh.toFixed(2)+"</td><td>"+r_b_bwh.toFixed(2)+"</td><td>"+s_self+"</td><td>"+b_self.toFixed(2)+"</td>\n\
                        <td>"+b_subtot.toFixed(2)+"</td></tr>";

                    }else{
                        $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td>"+no_urut+"</td><td style='font-weight:bold;text-align:left'>"+ds_pivot[i]+"</td>\n\
                        <td>"+s_atasan+"</td><td>"+b_atasan.toFixed(2)+"</td><td>"+s_peer1+"</td><td>"+b_peer1.toFixed(2)+"</td><td>"+s_peer2+"</td><td >"+b_peer2.toFixed(2)+"</td>\n\
                        <td>"+s_self+"</td><td>"+b_self.toFixed(2)+"</td>\n\
                        <td>"+b_subtot.toFixed(2)+"</td></tr>";
                     /*   $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td>no_urut</td><td style='font-weight:bold;text-align:left'>ds_pivot[i]</td>\n\
                        <td>s_atasan</td><td>bb_a.toFixed(2)</td><td>s_peer1</td><td>bb_peer1.toFixed(2)</td><td>s_peer2</td><td>bb_peer2.toFixed(2)</td>\n\
                        <td>s_self</td><td>bb_self.toFixed(2)</td>\n\
                        <td>bb_subtot.toFixed(2)</td></tr>"; */   
                    }
                    var sub_kbi=b_subtot.toFixed(2)/n_kbi_std*100;
                    $header_sum=$header_sum+"<tr style='font-weight:bold;text-align:center'><td>"+no_urut+"</td><td style='font-weight:bold;text-align:left'>"+ds_pivot[i]+"</td>\n\
                        <td>"+b_subtot.toFixed(2)+"</td><td>"+n_kbi_std+"</td><td>"+sub_kbi.toFixed(2)+"</td></tr>"
                    //------------------------- set Data Grafik -----------------------------------------------
                    datas[i] = {desc:ds_pivot[i], 
                            kbi:parseFloat(b_subtot.toFixed(2)),
                          //  ue:2.37,
                            me:2.4,
                            ae:2.7,
                            o:2.85,
                            standar:3
                            
                    };
                    //-------------------------end set data grafik --------------------------------------------
                    
                    //document.getElementById("desc"+no_urut).value=ds_pivot[i];
                    //document.getElementById("subtot"+no_urut).value=  b_subtot.toFixed(2);      

                    //console.log(ds_pivot[i]+':'+a_peer1[i]['ik_skor']+':'+a_peer1[i]['ik_bobot']);
                 }
                 if(document.getElementById("txtIS_MANAGER").value==='1'){
                  $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td colspan='15'>Grand Total</td><td>"+bb_tot.toFixed(2)+"</td></tr></table>";
                }else{  $header_pv=$header_pv+"<tr style='font-weight:bold;text-align:center'><td colspan='10'>Grand Total</td><td>"+bb_tot.toFixed(2)+"</td></tr></table>";}   
              //  console.log(ds_pivot);
                $header_sum=$header_sum+"<tr style='font-weight:bold;text-align:center'><td style='font-weight:bold;text-align:left' colspan='2'>KBI Fit Individu</td>\n\
                        <td>"+(bb_tot/no_urut).toFixed(2)+"</td><td>"+n_kbi_std+"</td><td>"+((bb_tot/no_urut)/n_kbi_std*100).toFixed(2)+"</td></tr>"
                var r_BB_tot=((bb_tot.toFixed(2)/no_urut)/3*100).toFixed(2);
                document.getElementById("txtResult_Status").value = "";
                if(r_BB_tot<80) document.getElementById("txtResult_Status").value = "Under Expectation";
                if(r_BB_tot>=80 && r_BB_tot<90) document.getElementById("txtResult_Status").value = "Meet Expectation";
                if(r_BB_tot>=90 && r_BB_tot<95) document.getElementById("txtResult_Status").value = "Above Expectation";
                if(r_BB_tot>=95) document.getElementById("txtResult_Status").value = "OutStanding";
               // console.log('cek rate bobot:'+document.getElementById("txtResult_Status").value);
                $header_sum=$header_sum+"<tr style='font-weight:bold;text-align:center'><td style='font-weight:bold;text-align:left' colspan='5'>Hasil Penilaian : <span2>"+document.getElementById("txtResult_Status").value+"</span2></td></tr><table>";
                var source ={
                    localdata: ds,
                    datatype: "array"
                };
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
                        { text: 'Indikator', datafield: 'soal',width:'80%' },
                        { text: 'IK SKOR', datafield: 'ik_skor' ,width:'10%'},
                        { text: 'IK BOBOT', datafield: 'ik_bobot' ,width:'10%'}
                        //{ text: 'IK NILAI', datafield: 'ik_nilai',width:'10%' }
                    ],
                    groups: ['penilai']
                });
                // kbi_summary $header_sum
                document.getElementById("kbi_summary").innerHTML   = $header_sum;
                document.getElementById("pivot").innerHTML   = $header_pv;
                $("#jqxgrid_kbi").jqxGrid('showgroupsheader', false);
                
                //-----------------------------set grafik-----------------------
                var settings = {
                    title: "KBI Individu BADU",
                    description: "Hasil Penilaian : "+document.getElementById("txtResult_Status").value,
                    enableAnimations: false,
                    showLegend: true,
                    padding: { left: 20, top: 5, right: 20, bottom: 5 },
                    titlePadding: { left: 0, top: 0, right:0, bottom: 20 },
                    source: datas,
                    colorScheme: 'scheme05',
                    xAxis:
                    {
                        gridLinesColor: '#F5F5F5',
                        showGridLinesVisible: false,
                        dataField: 'desc',//'type',
                        displayText: 'Kriteria Penilaian',
                        valuesOnTicks: true, 
                        labels: { autoRotate: false }
                    },
                    valueAxis:
                    {
                        unitInterval: 0.5,
                        gridLinesColor: '#F5F5F5',
                       // tickMarks:true,
                        labels: {
                            formatSettings: { decimalPlaces: 2 },
                            formatFunction: function (value, itemIndex, serieIndex, groupIndex) {
                                //console.log(value);
                                var scale_ = value/3;
                                //return value.toFixed(1) ;
                                return '';
                                //return Math.round(value/3.2);
                               // return Math.round(value / 1000) + ' K';
                            }
                        }
                        
                    },
                    /*
                    categoryAxis: 
                    { 
                        gridLinesColor: '#FFFFFF',
                        showGridLines: false
                        gridLinesInterval: 10 
                    },*/
                    seriesGroups:
                        [
                            {
                                spider: true,
                                startAngle: 55,
                                endAngle: 55+360,
                                radius: 230,
                                type: 'spline',
                                series: [
                                    { dataField: 'kbi', displayText: 'KBI Indv',  opacity: 0.7, radius: 2, lineWidth: 5, symbolType: 'circle' },
                                 //   { dataField: 'ue', displayText: '<=2.37', opacity: 0.5, radius: 2, lineWidth: 0.5, symbolType: 'square' },
                                    { dataField: 'me',  color: '#C82506',   displayText: '2.4', opacity: 0.5, radius: 2, lineWidth: 3, symbolType: 'square' },
                                    { dataField: 'ae', color: '#F5D328', displayText: '2.7', opacity: 0.5, radius: 2, lineWidth: 3, symbolType: 'square' },
                                    { dataField: 'o', color: '#00882B', displayText: '2.85', opacity: 0.5, radius: 2, lineWidth: 3, symbolType: 'square' }
                                 //   { dataField: 'standar', displayText: '3', opacity: 0.5, radius: 2, lineWidth: 0.5, symbolType: 'square' }
                        ]
                            }
                        ]
                };
                  // create the chart
               $('#chartContainer').jqxChart(settings);

               // select the chart element and change the default border line color.
                $('#chartContainer').jqxChart({borderLineColor: 'GREY'}); 
                //$('#chartContainer').jqxChart({backgroundColor:'grey'});

                // refresh the chart element
                $('#chartContainer').jqxChart('refresh');
            // get the chart's instance
              var chart = $('#chartContainer').jqxChart('getInstance');
                
            },
            error: function (data) {
                console.log('error');
            }
        });
        });
    </script>
</head>
<body class='default'>
    <!-- <script type="text/javascript" src="../../scripts/demos.js"></script>-->
    <div class="box-header with-border">
        <button type="button" id="btnModalBack" name="btnModalBack" style="margin-top:1px;margin-right:0px;height:30px;width:50px;border:0px;" class="btn btn-primary" onclick="submitLUBACK()"><i class="fa fa-home fa-lg"></i></button>
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div>
    <div class="form-group">
        <input class="form-control" id="txtBL" name="txtBL" placeholder="mmyyyy"  maxlength="6" value="<?php echo isset($BL)?$BL:""; ?>"  required readonly type="hidden">
        <input class="form-control" id="txtST_DATE" name="txtST_DATE" value="<?php echo isset($ST_DATE)?$ST_DATE:""; ?>" readonly  type="hidden">
        <input class="form-control" id="txtEND_DATE" name="txtEND_DATE" value="<?php echo isset($END_DATE)?$END_DATE:""; ?>" readonly type="hidden">
        <input class="form-control" id="txtNIP" name="txtNIP"  value="<?php echo isset($NIP)?$NIP:""; ?>"  required readonly type="hidden">
        <input class="form-control" id="txtESELON" name="txtESELON" value="<?php echo isset($ESELON)?$ESELON:""; ?>" readonly  type="hidden">
        <input class="form-control" id="txtIS_MANAGER" name="txtIS_MANAGER" value="<?php echo isset($IS_MANAGER)?$IS_MANAGER:""; ?>" readonly  type="hidden">
        <input class="form-control" id="txtResult_Status" name="txtResult_Status" readonly  type="hidden">
    </div>
    <div class="modal-header">
        <div class="col-sm-2">
            <div id="judul_kbi"></div>
        </div>
    </div>
    <ul class="nav nav-pills">
           <!-- <li><button type="button" id="btnModalBack" name="btnModalBack" style="margin-left: 5px;margin-bottom: 5px" class="btn btn-primary" onclick="submitLUBACK()">BACK</button>
            </li>-->
             <li class="tab active"><a data-toggle="pill" href="#home">KBI perPenilai</a></li>
             <li><a class="tab" data-toggle="pill" href="#menu1">Tabulasi KBI</a></li>
             <li><a class="tab" data-toggle="pill" href="#menu2">Summary</a></li>
             <li><a class="tab" data-toggle="pill" href="#menu3">Grafik</a></li>
           </ul>
    <div class="tab-content">
               <div id="home" class="tab-pane fade in active">
                   <div class="row">
                     <div class="col-xs-12">
                       <div class="box box-primary box-solid">
                           <div class="box-body"> 
                               <div class="form-group">
                                   <div id="jqxgrid_kbi"></div> <!-----------Show hasil KBI per Penilai ------------------------------->
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
                        <div class="box-body">  
                           <div id="pivot"></div>   <!---------Tabulasi PV---------------->
                       </div>
                      </div>
                   </div>
                 </div>
               </div>
               <div id="menu2" class="tab-pane fade">
                    <h3></h3>
                    <!-- start row -->
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-primary box-solid">
                          <div class="box-body">  
                                <div id="kbi_summary"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- end row -->
                </div>
               <div id="menu3" class="tab-pane fade">
                 <h3></h3>
                 <!-- start row -->
                 <div class="row">
                    <div class="col-xs-9">
                        <div class="box box-primary box-solid">
                            <div class="box-body">  
                                 <div id='chartContainer' style="width: 95%; height: 705px">
                            </div>
                          </div>
                        </div>
                    </div>
                    <button class="btn" style="background-color: #1CA3E3;">KETERANGAN</button><br>
                    <table border="0"><tr><td>Under Expectation</td><td width="10"></td><td>Kurang dari 2.4</td><tr>
                        <tr><td>Meet Expectation</td><td></td><td>>=2.4 sd. 2.69</td><tr>
                        <tr><td>Above Expectation</td><td></td><td>2.7 sd. 2.84</td><tr>
                        <tr><td>Outstanding </td><td></td><td> Lebih Besar dari 2.85</td><tr>
                    </table>

                   <!-- <rect x="378.5" y="681.5" width="10" height="10" fill="#1CA3E3" fill-opacity="0.7" stroke="#1F99D3" stroke-width="1" stroke-opacity="0.7"></rect>
                   -->
                </div>
                     
               </div>
                 
            </div>
      </div>
</body>
</html>
<script type="text/javascript">
    function replaceAll(str, find, replace) {
            return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(str) {
        return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    function submitLUBACK(){
           //  window.location.href = "<?php echo base_url().'hr/kbi/M_index/';?>";
          //  window.location.reload(true);
          window.history.back();
    }

   $(document).ready(function () {
        
    })
</script>

