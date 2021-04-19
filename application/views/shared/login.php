<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>HCIS | Log in</title>
  <link rel="stylesheet" href="<?php echo base_url() ?>assets//css/bootstrap.min.css">
  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style2.css">
  <link href="../picture/hc.ico" rel="shortcut icon" sizes="20x20">
    
</head>

<body >
    <div class="container">
        <header class="header">
            <span class="text2">Human Capital Information System v.1.0</span>
        </header>
        <div class="row">
            <div class="col-sm-6" >
                         <img src="../picture/hc_img.png"  width="60%" height="40%">
                <div class="col-sm-12">
                                 <span class="desc" >HCIS is a HR solution which integrate & automate all the main HR process and manages the entire lifecycle of organization workforce. </span>
                </div>
            </div>
            <div class="col-sm-6" >
                <div class="login-container">
                    <img src="../picture/witon.png"  width="30%" height="40%">
                    <div class="form-box">
                        <form class="form" action="<?=base_url();?>auth/authcheck" method="POST">
                            <div id='profile__fields'>
                                <div class="field">
                                    <input type="text" name="username" class="input" autocomplete="off" placeholder="username" required pattern=.*\S.* />
                                </div>
                               <div class="field">
                                    <input type="password"  name="password"  class="input" autocomplete="off" placeholder="password" required pattern=.*\S.* />
                                </div>
                            </div>

                           <!-- <input name="username" type="text" placeholder="username" autocomplete="off"> -->
                           <!-- <input type="password" name="password" placeholder="password" autocomplete="off">-->
                            <button class="btn btn-info btn-block login" type="submit">Login</button>
                        </form>
                        <span class="footer">
                            <font color="red">
                                <?php if ($this->session->flashdata('warning')) {  echo $this->session->flashdata('warning').'<br>';  } ?>
                            </font>
                            <div class="col-sm-6" style="background-color:lavender;width:100%;font-size:10 ">This computer application system, its network and data contained therein the property of the PT Wijaya Karya Beton Tbk (WIKA BETON). Access to this system and network are restricted. Unauthorized access is prohibited and is wrongful under law. Do not proceed if you are not authorized. Any unauthorized access will be prosecuted to the fullest extent of the law. </div>
            
                        </span>
                    </div>
                </div>
            </div>
        </div>
            
             
    </div>    
</button>
  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
  <script  src="<?php echo base_url() ?>assets/js/index.js"></script>
</body>
</html>