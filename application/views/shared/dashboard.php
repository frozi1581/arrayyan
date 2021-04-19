<!-- START @HEAD -->
    <head>
        <!-- START @META SECTION -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Dashboard notifikasi">
        <meta name="keywords" content="hcis,notifikasi">
        <meta name="author" content="BSI">
        <title>HCIS | Dashboard Notifikasi</title>
        <!--/ END META SECTION -->
 
        <link href="<?php echo base_url();?>assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      
        <!-- START @THEME STYLES -->
        <link href="<?php echo base_url();?>assets/admin/css/reset.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/admin/css/layout.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/admin/css/components.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/admin/css/plugins.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/admin/css/themes/default.theme.css" rel="stylesheet" id="theme">
        <link href="<?php echo base_url();?>assets/admin/css/custom.css" rel="stylesheet">
        <!--/ END THEME STYLES -->
    </head>
<!----------------------------------------------------------------------------------->
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
      <!--/ END HEAD -->
<!-- Start body content -->
<body class="page-session page-sound page-header-fixed page-sidebar-fixed demo-dashboard-session">
<div class="body-content animated fadeIn">
	<div class="row">   
	   <div class="col-md-3">
			<div class="recent-activity">
				<h3>Recent Activity</h3>
		
                                <!------------------------------------------------- start ---------------------------------------->
<?php $topic='';$cnt=0; foreach ($notif as $isi_notif) {
                        switch($isi_notif->priority){
                            case 'Hight':
                                $type='recent-activity-danger';
                                break;
                            case 'Medium':
                                $type='recent-activity-warning';
                                break;
                            default:
                                $type='recent-activity-last';
                        } 
                        if($isi_notif->topic<>$topic){
                            if($topic===''){ 
                                //echo "<div class= 'recent-activity-item ".$type."'>";
                                ?>
                                   <div class="recent-activity-item recent-activity-warning"> 
                                    <div class="recent-activity-badge">
                                        <span class="recent-activity-badge-userpic"></span>
                                    </div>
                                    <div class="recent-activity-body">
                                        <div class="recent-activity-body-head">
                                                <div class="recent-activity-body-head-caption">
                                                    <h5 class="recent-activity-body-title"><?php echo $isi_notif->topic.' (Priority :<i><b>'.$isi_notif->priority.'</b></i>)';?></h5>
                                                </div>
                                        </div>
                                        
                                        
                        <?php }else{
                            echo '</div></div>';
                            //echo "<div class= 'recent-activity-item ".$type."'>";
                        ?>
                            <div class="recent-activity-item recent-activity-warning">            
                            <div class="recent-activity-badge">
                                <span class="recent-activity-badge-userpic"></span>
                            </div>
                            <div class="recent-activity-body">
                                <div class="recent-activity-body-head">
                                        <div class="recent-activity-body-head-caption">
                                                   <h5 class="recent-activity-body-title"><?php echo $isi_notif->topic.' (Priority :<i><b>'.$isi_notif->priority.'</b></i>)';?></h5>
                                        </div>
                                </div>
                                
                      <?php    
                            }
                        }
                        ?>
                        <div class="recent-activity-body-content">
                            <p> <span class="text-block text-muted">
                                <?php
                                
                                echo "<a href='".
                                    base_url().'notifikasi/tb_notifikasi_dlist.php?showmaster=tb_notifikasi&fk_id='.$isi_notif->id.'&employee_id='
                                    .$this->session->userdata('username')."'>". $isi_notif->isi_notif."</a>";
                                ?>    
                               <?php
                                if($isi_notif->action!=''){
                                        echo  "<a href='".base_url()."Personal2/action/".$isi_notif->id."/".$isi_notif->action."' target='_blank'><font color='black'><i class='fa fa-check fa-2x' aria-hidden='true'></i></font></a>";
                                }
                                ?>
                                </span>
                            </p>
                        </div>
                      <?php  
                        $cnt=$cnt+1;
                        $topic= $isi_notif->topic;
                        } 
                        if($cnt>0){echo  '</div></div>';}?>                
                    <!-- End recent activity item -->
<!--------------------------------------------------end------------------------------------------->
                            <!-- Start recent activity item -->
                            <div class="recent-activity-item recent-activity-danger recent-activity-last">
                                    <div class="recent-activity-badge">
                                            <span class="recent-activity-badge-userpic"></span>
                                    </div>
                                    <div class="recent-activity-body">
                                            <div class="recent-activity-body-head">
                                                    <div class="recent-activity-body-head-caption">
                                                            <h5 class="recent-activity-body-title">.</h5>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <!-- End recent activity item -->
			</div>
		</div>
	</div>
</div>	
</body>
    <!-- /.content -->
  </div>
<!----------------------------------------------------------------------------------->





   