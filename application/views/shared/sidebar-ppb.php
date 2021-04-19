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
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="<?php echo base_url();?>Personal" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
         

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                 
                 
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                     </div>
                  <div class="pull-right">
		   
                  </div>
                </li>
              </ul>
            </li>
          
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
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">  <?php echo $this->session->userdata('nama_pegawai').'<br>'.$this->session->userdata('nip'); ?> </li>
            
            <li>
                <a href="#"><i class="fa fa-circle-o"></i> Pabrik Produk Beton
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
					<?php
						if(isset($this->session->listOfPPB))
						{
							foreach($this->session->listOfPPB as $key=>$value)
							{
								echo "<li><a data-toogle='pill' href=\"javascript:changePPB('".$value["KD_PAT"]."','".$value["KET"]."');\"><i class='fa fa-circle-o'></i>".$value["KET"]."</a></li>";
							}
							
						}
					?>
                    

                </ul>
            </li>
        </li>
        </ul>
       
                  </section>
      <!-- /.sidebar -->
    </aside>
