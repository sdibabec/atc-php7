<?php
require_once("des/cnx/swgc-mysql.php");
require_once("des/cls/cls-sistema.php");
require_once("des/cls/cls-nav.php");
$clSistema = new clSis();
$clNav = new clNav();

session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title><?=$clSistema->variablesSistema('tSistema');?></title>
    
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      <meta name="keywords" content="<?=$clSistema->variablesSistema('tSistema');?>" />
      <meta name="author" content="<?=$clSistema->variablesSistema('tSistema');?>" />
      <!-- Favicon icon -->

      <link rel="icon" href="/assets/images/avatar-4.png" type="image/x-icon">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap/css/bootstrap.min.css">
      <!-- waves.css -->
      <link rel="stylesheet" href="/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="/assets/icon/themify-icons/themify-icons.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="/assets/icon/icofont/css/icofont.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="/assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
  </head>

  <body themebg-pattern="theme1">
      
      
      
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                        <form class="md-float-material form-material" action="<?=$clNav->obtenerURL();?>login/" method="post">
                            <div class="text-center">
                                <img src="/assets/images/avatar-4.png" alt="S.R.M:">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        
                                        <?
if($_POST)
{
	$res = $clSistema->iniciarSesion();
    
    
    
	if($res['exito']==1 && $_SESSION['sessionAdmin']['eCodUsuario']>0)
	{  ?>
       <div class="alert alert-success" role="alert">
                Inicio de Sesi&oacute;n Correcto. Redirigiendo...
            </div>                  
      <script>
setTimeout(function(){
    window.location="/<?=base64_decode($res['seccion']);?>";
},2500);
</script>
	<? }
    else
    { ?>
    <center>
       <div class="alert alert-danger" role="alert">
                Error de Inicio de Sesi&oacute;n!
            </div> 
            </center>
    <? }
}
else
{
    session_start();
    $_SESSION = array();
    $_SESSION['sessionAdmin'] = NULL;
    session_destroy();
}
?>
                                        
                                        <div class="col-md-12">
                                            <h3 class="text-center">Acceso al Sistema</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="tCorreo" class="form-control" value="<?=($_POST['tCorreo'] ? $_POST['tCorreo'] : '');?>">
                                        <span class="form-bar"></span>
                                        <label class="float-label">E-mail</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="tPasswordAcceso" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Password</label>
                                    </div>
                                    
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Entrar</button>
                                        </div>
                                    </div>
                                    <hr/>
                                    
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
    
<!-- Required Jquery -->
<script type="text/javascript" src="/assets/js/jquery/jquery.min.js "></script>
<script type="text/javascript" src="/assets/js/jquery-ui/jquery-ui.min.js "></script>
<script type="text/javascript" src="/assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/js/bootstrap.min.js "></script>
<!-- waves js -->
<script src="/assets/pages/waves/js/waves.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="/assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<script type="text/javascript" src="/assets/js/common-pages.js"></script>
</body>

</html>
