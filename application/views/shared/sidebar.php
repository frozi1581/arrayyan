<style>
</style>
<body class="skin-blue-light sidebar-menu sidebar-collapse">
<!-- class="hold-transition skin-blue sidebar-mini" -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->

    <?php  if( $this->session->userdata('mobile')===''){  ?> 
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        
        <!-- logo for regular state and mobile devices -->
       
      </a>
     <?php  }  ?> 
   <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" ">
        <!-- Sidebar toggle button-->
        <!--<a href="<?php echo base_url();?>Personal" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>-->
         

        <div class="navbar-custom-menu" style="float:left;padding:10px;">
          <ul class="nav navbar-nav" style="color:white;">
            <!-- User Account: style can be found in dropdown.less -->
              <li class="user user-menu" style="margin-right:5px;font-size:medium;"><a href="<?php echo base_url().'/kkms/M_kepemilikan2';?>">[Kepemilikan Saham]</a></li>
              <li style="margin-right:5px;font-size:medium;"><a href="<?php echo base_url().'/kkms/M_penjualan';?>">[Penjualan]</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
              
            
          </div>
          <div class="pull-left info">
            
          </div>
        </div>
        
                  </section>
      <!-- /.sidebar -->
    </aside>
