<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once("./des/cls/cls-sistema.php");
require_once("./des/cls/cls-nav.php");
include("./des/inc/cot-clc.php");



$clSistema = new clSis();
$clNav = new clNav();
session_start();



$_SESSION['sesionNavegacion'] = array();

date_default_timezone_set('America/Mexico_City');

if(!$_SESSION['sessionAdmin'] || !$_GET['tCodSeccion'] || !$clSistema->validarSeccion($_GET['tCodSeccion']))
{
	echo '<script>window.location="'.$clNav->obtenerURL().'login/";</script>';
}
else
{
    $clNav->breadCrumb($_GET['tCodSeccion'],0);
    
    $secciones = array_reverse($_SESSION['sesionNavegacion']);
    
    $clSistema->validarPermiso($_GET['tCodSeccion']);
    
    $clSistema->validarEliminacion($_GET['tCodSeccion']);
	
	$conexion = $clSistema->conectarBD();
    
}

?>
<html lang="es">

<head>
    <title><?=$clSistema->variablesSistema('tSistema');?> [<?=$clSistema->tituloSeccion($_GET['tCodSeccion']);?>]</title>
    
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
    <!-- waves.css -->
    <link rel="stylesheet" href="/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="/assets/icon/themify-icons/themify-icons.css">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-n.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.mCustomScrollbar.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!--texteditor-->
    <link rel="stylesheet" type="text/css" href="/assets/texteditor/ui/trumbowyg.min.css">
    <!--DatePicker-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/Base/jquery-ui.css">
    
    <link href="/assets/css/calendario.css" rel="stylesheet" media="all">
    
    
    <!--javascripts-->
    <!-- Required Jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!--<script type="text/javascript" src="/assets/js/jquery/jquery.min.js "></script>-->
    <script type="text/javascript" src="/assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="/assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="/assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="/assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- slimscroll js -->
    <script src="/assets/js/jquery.mCustomScrollbar.concat.min.js "></script>

    <!-- menu js -->
    <script src="/assets/js/pcoded.min.js"></script>
    <script src="/assets/js/vertical/vertical-layout.min.js "></script>

    <script type="text/javascript" src="/assets/js/script.js "></script>
    
    <!--DatePicker bootstrap-->
    
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker.js"></script>
    
    
    <script src="/assets/texteditor/trumbowyg.min.js"></script>
    <script src="/assets/texteditor/plugins/base64/trumbowyg.base64.min.js"></script>
        
    <!-- Script -->
    <script src="/assets/js/aplicacion.js"></script>
    
    
    <!--DataTables-->
    <script type="text/javascript" src="/DataTables/datatables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.serializejson.js"></script>
</head>

<body>
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
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="index.html">
                            <img class="img-fluid" src="/assets/images/logo.png" alt="Theme-Logo" style="max-height:50px;" />
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                            <li>
                                
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <img src="/assets/images/avatar-4.png" class="img-radius" alt="S.G.E.">
                                    <span><?=$_SESSION['sessionAdmin']['tNombre']?></span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="#" onclick="cerrarSesion();">
                                            <i class="ti-layout-sidebar-left"></i> Cerrar Sesi&oacute;n
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="">
                                <div class="main-menu-header">
                                    <img class="img-80 img-radius" src="/assets/images/avatar-4.png" alt="User-Profile-Image">
                                    <div class="user-details">
                                        <span ><?=$_SESSION['sessionAdmin']['tNombre']?></span>
                                    </div>
                                </div>
                                <div class="main-menu-content" style="display:none">
                                    <ul>
                                        <li class="more-details">
                                            <a href="#!"><i class="ti-settings"></i>-</a>
                                            <a href="#!"><i class="ti-settings"></i>-</a>
                                            <a href="#!"><i class="ti-settings"></i>-</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 p-b-0">
                                <form class="form-material">
                                    <div class="form-group form-primary">
                                        <!--<input type="text" id="tSecciones" name="tSecciones" class="form-control" onkeypress="buscarSeccionRapida()" onkeyup="buscarSeccionRapida()" placeholder="Ir a...">
                                        <!--<span class="form-bar"></span>
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Ir a...</label>-->
                                    </div>
                                </form>
                            </div>
                            <!--menu-->
                                <?=$clSistema->generarMenu();?>
                            <!--menu-->
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10"><?=$clSistema->tituloSeccion($_GET['tCodSeccion']);?></h5>
                                            <p class="m-b-0"><?=implode(" &rang;&rang; ",$secciones);?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="display: none;">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">
                                           
                                           <div class="col-xl-12" style="padding-bottom:20px;">
                                                <div class="row">
                                                    <input type="hidden" id="tPasswordVerificador"  style="display:none;" value="<?=base64_decode($_SESSION['sessionAdmin']['tPasswordOperaciones'])?>">
                    						        <!--botones-->
                    						        <? $clNav->botones(($_GET['v1']) ? $_GET['v1'] : false); ?>
                    						        <!--botones-->
                    						        <img id="imgProceso" src="/res/loading.gif" style="max-height:30px; display:none">
                                                </div>
                                            </div>
                                           
                                           <!--contenido-->
                                           <?
                                           $fichero = './des/mod/'.$_GET['tDirectorio'].'/'.$_GET['tCodSeccion'].'.php';
            
            mysqli_query($conexion,$conexion,"INSERT INTO SisUsuariosSeccionesAccesos (eCodUsuario, tCodSeccion,  fhFecha) VALUES (".$_SESSION['sessionAdmin']['eCodUsuario'].",'".$_GET['tCodSeccion']."','".date('Y-m-d H:i:s')."')");
			//echo ($fichero);
			include($fichero);
                                           ?>
                                           <? //$clSistema->cargarSeccion(); ?>
                                           <!--contenido-->
                                           
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--modals-->
    
    <!--transacciones-->
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaTran">
              <input type="hidden" name="eCodTransaccion" id="eCodTransaccion">
              <input type="hidden" id="eCodEventoTransaccion" name="eCodEventoTransaccion">
              <input type="hidden" id="tCodEstatusTransaccion" name="tCodEstatusTransaccion">
            <label>Monto: $<input type="text" class="form-control" name="dMonto" id="dMonto" required></label><br>
            <label>Comprobante: <input type="hidden" id="tArchivo" name="tArchivo"><input type="file" class="form-control" name="tComprobante" id="tComprobante" required onchange="adjuntarComprobante(this,'tArchivo')"></label><br>
            <label>Forma de pago: 
              <select name="eCodTipoPago" id="eCodTipoPago">
                <?
    $select = "SELECT * FROM CatTiposPagos ORDER BY tNombre ASC";
                                        $rsTiposPagos = mysqli_query($conexion,$select);
                                        while($rTipoPago = mysqli_fetch_array($rsTiposPagos))
                                        {
                                            ?>
                  <option value="<?=$rTipoPago{'eCodTipoPago'}?>"><?=utf8_encode($rTipoPago{'tNombre'});?></option>
                  <?
                                        }
    ?>
                </select>
              </label><br>
              <textarea name="tMotivoCancelacion" id="tMotivoCancelacion" placeholder="Motivo de cancelación" style="display:none; resize:none;" class="form-control"></textarea>
              <br>
              <input type="button" onclick="nvaTran();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
    
    <!--modal de responsable-->
    <div class="modal fade" id="myModalOperador" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaOperador">
              
              <input type="hidden" id="eCodEventoOperador" name="eCodEventoOperador">
              <label><input type="radio" value="tOperadorEntrega" name="tCampo"> A la Entrega </label><br>
            <label><input type="radio" value="tOperadorRecoleccion" name="tCampo"> A la Recolecci&oacute;n </label><br>
               <label>Veh&iacute;culo</label>
         <select class="form-control" id="eCodCamioneta" name="eCodCamioneta">
              <option value="">Seleccione...</option>
             <?php 
                $select = "SELECT * FROM CatCamionetas WHERE tCodEstatus = 'AC' ORDER BY eCodCamioneta ASC";
                $rsCamionetas = mysqli_query($conexion,$select);
                while($rCamioneta = mysqli_fetch_array($rsCamionetas)) { ?>
             <option value="<?=$rCamioneta{'eCodCamioneta'};?>"><?=$rCamioneta{'tNombre'};?></option>
             <? } ?>
              </select>
             <br><br> 
            
            <label>Responsable: 
              <input type="text" class="form-control" name="tResponsable" id="tResponsable" required>
              </label><br>
              <input type="button" onclick="nvaOper();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
        
   <!--modal de paquete-->
    <div class="modal fade" id="myModalPaquete" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body" id="detPaquete" style="max-height:500px; overflow-y: scroll;">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
        
        <!-- Modal -->
  <div class="modal fade" id="resProceso" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img style="width:75px; height:75px;" src="/res/loading.gif"><br>
            <h3>Procesando...</h3>
            </center>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resExito" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <!--<div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/ok.png" style="width:75px; height:75px;"><br>
              <h3>Registro Guardado Exitosamente</h3><br>
            </center>
        </div>
      </div>-->
       <div class="alert alert-success">
  <strong>&Eacute;xito!</strong> Registro Guardado Exitosamente
</div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resConsulta" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/loading.gif" style="width:75px; height:75px;"><br>
              <h3>Consultando fecha</h3><br>
            </center>
        </div>
          
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="resDetalle" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body" id="detalleEvento">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="detCarga" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <form id="carga" name="carga">
              <input type="hidden" id="eCodEventoCarga" name="eCodEventoCarga">
            <div class="modal-body">
                <div class="modal-body" id="detalleCarga" >
         
                </div>
            </div>    
        
              <div class="modal-body" style="text-align:center;">
         <button type="button" id="guardarCarga" class="btn btn-info" style="display:none;" onclick="registrarCarga();">Guardar</button>
        </div>
            </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resError" role="dialog">
    <div class="modal-dialog" id="divErrores">
    
      <!-- Modal content-->
      <!--<div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/error.png" style="width:75px; height:75px;"><br>
              <h3>Error al procesar la solicitud</h3><br>
            </center>
            <div id="divErrores" name="divErrores"></div>
        </div>
      </div>-->
        <div class="alert alert-danger">
            <strong>Error!</strong> Favor de validar la siguiente informaci&oacute;n
        </div>
      
    </div>
  </div>
    
    <!-- Modal -->
  <div class="modal fade" id="modClientes" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <form method="post" action="<?=$clNav->obtenerURL();?>xls/<?=$_GET['tCodSeccion']?>/" target="_blank">
          <div class="modal-body">
              <label>Selecciona el mes</label>
         <select class="form-control" id="eMes" name="eMes">
              <option value="">Seleccione...</option>
             <option value="1">Enero</option>
             <option value="2">Febrero</option>
             <option value="3">Marzo</option>
             <option value="4">Abril</option>
             <option value="5">Mayo</option>
             <option value="6">Junio</option>
             <option value="7">Julio</option>
             <option value="8">Agosto</option>
             <option value="9">Septiembre</option>
             <option value="10">Octubre</option>
             <option value="11">Noviembre</option>
             <option value="12">Diciembre</option>
              </select>
              <br>
             <center> <input type="submit" class="btn btn-info" value="Generar XLS"> </center>
            </div>    
            <div class="modal-footer">
              <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
          
      </div>
      
    </div>
  </div>
        
     <!-- Modal guardar cambios -->
<div class="modal fade" id="modGuardar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td colspan="2" align="center">¿Confirmas que deseas guardar los cambios?</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <button type="button" class="form-control btn btn-success" onclick="serializar()">Guardar</button>
                        </td>
                        <td align="center">
                            <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
</div>
        
    <div class="modal fade" id="modMenu" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        
						<?
						echo $clSistema->generarMenu();
						?>
                        
                    </ul>
                </div>
            </nav>
            </div>

        </div>

    </div>
</div>
        
  <script>
       
          function mostrarFiltros() {
  var x = document.getElementById("divFiltros");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
        
        function toogleInput() {
            var cmbBtn = document.querySelectorAll("[id^=divConsulta]");
            cmbBtn.forEach(function(nodo){
               if (nodo.style.display === "none") {
    nodo.style.display = "block";
  } else {
    nodo.style.display = "none";
  }
            });
          
}
        
      /* proceso de guardado*/
        function procesoGuardar(bloquear = false)
        {
            var cmbBtn = document.querySelectorAll("input[type=button]");
            cmbBtn.forEach(function(nodo){
                nodo.disabled = (bloquear) ? true : false;
            });
            document.getElementById('imgProceso').style.display = (bloquear) ? 'inline' : 'none';
        }
      /*Preparación y envío*/
      function guardar(cierre)
      {
          procesoGuardar(true);
          $('#modGuardar').modal('show');
          //var formulario = document.getElementById('datos'),
          //    eAccion = document.getElementById('eAccion');
          //
          //        eAccion.value = 1;
          //          if(confirm((cierre ? "Tu sesión se cerrará al guardar los cambios\n" : "") + "Deseas guardar la información?"))
          //              {
          //                  serializar();
          //              }
      }

      function enviar(cadena)
      {
          
          document.getElementById('imgProceso').style.display = 'inline';
         //alert(cadena);
          
          var divErrores = document.getElementById('divErrores');
          
            $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: cadena,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('imgProceso').style.display = 'none';
                  procesoGuardar(false);
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                      setTimeout(function(){ window.location="<?=(($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $clSistema->seccionPadre($_GET['tCodSeccion']) );?>"; }, 3500);
                  }
                  else
                      {
                          var mensaje="";
                          var msgHTML="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                         msgHTML += "<div class=\"alert alert-danger\"><strong>"+data.errores[i]+"</strong></div>";
                     }
                          document.getElementById('divErrores').innerHTML = "<div class=\"alert alert-danger\"><strong>Error!</strong> Favor de validar la siguiente informaci&oacute;n</div>";
                          document.getElementById('divErrores').innerHTML += msgHTML;
                          setTimeout(function(){
                                $('#resError').modal('show');
                          },200);
                          //alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
                  
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
          
      }

      function serializar()
      {
          $('#modGuardar').modal('hide');
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          //alert(jsonString);
          enviar(jsonString);
      }
            
      function cambiarFecha(mes,anio, bCarga)
      {
          document.getElementById('nvaFecha').value=mes+'-'+anio;
          
          var obj = $('#frmCalendario').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/des/inc/inc-cal.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('calendario').innerHTML = data.calendario;
                  if(bCarga)
                      {
                          asignarFecha('<?=date('d/m/Y');?>','<?=date('d/m/Y');?>');
                          consultarFecha();
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      function consultarFecha()
      {
          $('#resConsulta').modal('show');
          
                      
          var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          setTimeout(function(){
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                   $('#resConsulta').modal('hide'); 
                 
                  if(data.eventos.length<1||!data.eventos.length)
                      {
                          document.getElementById('eventos').innerHTML = '<h2>Sin eventos en la fecha seleccionada</h2>';
                          
                      }
                  if(data.rentas.length<1||!data.rentas.length)
                      {
                          document.getElementById('rentas').innerHTML = '<h2>Sin eventos en la fecha seleccionada</h2>';
                      }
                  if(data.eventos.length>0)
                      {
                          document.getElementById('eventos').innerHTML = '';
                          for(var i=0;i<data.eventos.length;i++)
                              {
                                 document.getElementById('eventos').innerHTML += data.eventos[i]; 
                              }
                          
                      }
                  if(data.rentas.length>0)
                      {
                          document.getElementById('rentas').innerHTML = '';
                          for(var i=0;i<data.rentas.length;i++)
                              {
                                 document.getElementById('rentas').innerHTML += data.rentas[i]; 
                              }
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
              }, 200);
          
      }
            
      function consultarDetalle(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#resDetalle').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/cons-deta.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleEvento').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
             
          
      }
            
      function cargarTransporte(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          document.getElementById('eCodEventoCarga').value=codigo;
          
          document.getElementById('eCodCamioneta').value="";
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#detCarga').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/deta-reg.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleCarga').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
             
          
      }
    
      function nvaTran()
      {
          var obj = $('#nvaTran').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-tran.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                        document.getElementById('eCodEventoTransaccion').value = "";
                        document.getElementById('eCodTransaccion').value = ""; 
                        document.getElementById('eCodTipoPago').value = ""; 
                        document.getElementById('dMonto').value = ""; 
                        document.getElementById('tMotivoCancelacion').value = ""; 
                  }
                  else
                      {
                          var mensaje="";
                          var msgHTML="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                         msgHTML += "<div class=\"alert alert-danger\"><strong>"+data.errores[i]+"</strong></div>";
                     }
                          document.getElementById('divErrores').innerHTML = "<div class=\"alert alert-danger\"><strong>Error!</strong> Favor de validar la siguiente informaci&oacute;n</div>";
                          document.getElementById('divErrores').innerHTML += msgHTML;
                          setTimeout(function(){
                                $('#resError').modal('show');
                          },200);
                          //alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      function nvaOper()
      {
          var obj = $('#nvaOperador').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-oper.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      /*Ejecutar accion*/
      function acciones(codigo,accion)
      {
          document.getElementById('eCodAccion').value=codigo;
          document.getElementById('tCodAccion').value=accion;
          
          var obj = $('#execAccion').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                      location.reload();
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
      /*Asignaciones*/
      function asignarParametro(codigo,nombre)
      {
          document.getElementById('eCodCliente').value = codigo;
          document.getElementById('tNombreCliente').value = nombre;
          document.getElementById('tNombreCliente').style.display = 'inline';
          document.getElementById('asignarCliente').style.display = 'inline';
          document.getElementById('cot1').style.display = 'inline';
          document.getElementById('cot2').style.display = 'inline';
          document.getElementById('cot3').style.display = 'inline';
          var tblClientes = document.getElementById('mostrarTabla');
          if(tblClientes)
          {
          tblClientes.style.display='none';
          }
      }
      
      function verMisClientes()
      {
          $('#misClientes').modal({
                show: 'false'
            });
      }
      
      function agregarTransaccion(codigo)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
      }
            
      function nuevaTransaccion(codigo,transaccion,tipopago,dmonto,bCancelar)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
          
          var eCodTransaccion = document.getElementById('eCodTransaccion'); 
          var eCodTipoPago = document.getElementById('eCodTipoPago'); 
          var dMonto = document.getElementById('dMonto');
          
          if(transaccion)
              { 
                  eCodTransaccion.value = transaccion; 
                  eCodTipoPago.value = tipopago; 
                  dMonto.value = dmonto; 
                  if(bCancelar)
                      {
                            document.getElementById('tMotivoCancelacion').style.display='inline';
                            document.getElementById('tCodEstatusTransaccion').value = 'CA';
                            eCodTransaccion.readOnly = true;
                            eCodTipoPago.disabled = true;
                            dMonto.readOnly = true; 
                      }
                  else
                      {
                            document.getElementById('tMotivoCancelacion').style.display='none';
                            document.getElementById('tCodEstatusTransaccion').value = 'AC';
                            eCodTransaccion.readOnly = false;
                            eCodTipoPago.disabled = false;
                            dMonto.readOnly = false; 
                      }
              }
          $('#myModal').modal('show');
      }
      
      function agregarOperador(codigo)
      {
          document.getElementById('eCodEventoOperador').value = codigo;
      }
            
    function asignarFecha(fecha,etiqueta)
      {
          document.getElementById('fhFechaConsulta').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
          consultarFecha();
      }
            
    function cambiarFechaEvento(mes,anio)
      {
          document.getElementById('nvaFecha').value=mes+'-'+anio;
          
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/des/inc/cal-cot.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('calendario').innerHTML = data.calendario;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
    function asignarFechaEvento(fecha,etiqueta,codigo)
      {
          document.getElementById('fhFechaEvento').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
      }
            
    function validarCarga()
      {
          var cmbTotal = document.querySelectorAll("[id^=eCodInventario]"),
              eCodCamioneta = document.getElementById('eCodCamioneta'),
              clickeado = 0;
          
          cmbTotal.forEach(function(nodo){
            if(nodo.checked==true)
                { clickeado++;}
        });
          
          if(clickeado==cmbTotal.length && eCodCamioneta.value>0)
              { document.getElementById('guardarCarga').style.display = 'inline'; }
          else
              { document.getElementById('guardarCarga').style.display = 'none'; }
      }
            
    function registrarCarga()
        {
            $('#detCarga').modal('hide');
            
            var obj = $('#carga').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/reg-carga-eve.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); consultarFecha(); }, 3000);
                      
                  }
                  else
                      {
                          $('#detCarga').modal('show');
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }
        
    
        //tabla
    function agregarFilaInventario(indice) {
		
				var nIndice = parseInt(indice)+1;
        		var tInventario = document.getElementById("tInventario"+nIndice);
          		if(typeof tInventario != "undefined")  
            	  {
		    	      var x = document.getElementById("tbInventario").rows.length;
            	
            	      var table = document.getElementById("tbInventario");
            	      var row = table.insertRow(x);
            	      row.id="inv"+(nIndice);
            	      row.innerHTML = '<td style="padding:5px;"><i class="far fa-trash-alt" onclick="eliminarFilaInventario('+nIndice+')"></i><input type="hidden" name="inventario['+nIndice+'][eCodInventario]" id="eCodInventario'+nIndice+'"></td>';
            	      row.innerHTML += '<td><input type="text" class="form-control" id="tInventario'+nIndice+'" name="tInventario'+nIndice+'" onchange="agregarFilaInventario('+nIndice+')" onkeyup="agregarInventario('+nIndice+')" onkeypress="agregarInventario('+nIndice+')"></td>';
            	      row.innerHTML += '<td><input type="text" class="form-control" name="inventario['+nIndice+'][ePiezas]" id="ePiezas'+nIndice+'" onblur="validaNumero(this.value);"></td>';
            	  }
			
    }
    
    function eliminarFilaInventario(rowid)  {   
    var row = document.getElementById('inv'+rowid);
    row.parentNode.removeChild(row);
      
}
    //otros
         function buscarSubclasificacion()
        {
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/que/buscar-subclasificaciones.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('eCodSubclasificacion').innerHTML = data.valores;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }
        
        function crearPDF(tipo)
        {
            if(tipo=="cotizacion")
            {
                window.open('<?=$clNav->obtenerURL();?>crear/pdf/cotizacion/<?=$_GET['v1'];?>/', '_blank');
            }
        }
            
        function extraerClientes()
        {
            $('#modClientes').modal('show');
        }
            
        function generarArchivo(tipo)
        {  
                window.open('<?=$clNav->obtenerURL();?>'+tipo+'/<?=$_GET['tCodSeccion'];?>/<?=(($_GET['v1']) ? 'v1/'.$_GET['v1'].'/' : '');?>', '_blank');
        }
        
        function generarPDF(codigo)
        {
            
                window.open('<?=$clNav->obtenerURL();?>crear/pdf/cotizacion/'+codigo+'/', '_blank');
            
        }
        
        function generarMaestra(codigo)
        {
            
                window.open('<?=$clNav->obtenerURL();?>crear/pdf/maestra/'+codigo+'/', '_blank');
            
        }
        
        function buscarClientes()
        {
            var tCliente = document.getElementById('tCliente');
            
            if(tCliente.value=="" || !tCliente.value)
                { document.getElementById('eCodCliente').value=""; }
            $( function() {
  
        $( "#tCliente" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/buscar-clientes-cotizaciones.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tCliente').val(ui.item.label); // display the selected text
                $('#eCodCliente').val(ui.item.value); // save selected id to input
                var bLibre = document.getElementById('bLibre');
                if(bLibre)
                    {
                        bLibre.value = ui.item.bLibre;
                    }
                var bFrecuente = document.getElementById('bFrecuente');
                if(bFrecuente)
                    {
                        bFrecuente.value = ui.item.bFrecuente;
                    }
                //$('#bLibre').val(ui.item.bLibre); // save selected id to input
                return false;
            }
        });

       
        });
        }
        
        function buscarPaquetes()
        {
            var fhFecha = document.getElementById('fhFechaEvento');
            $( function() {
  
        $( "#tPaquete" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-paquetes.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term,
                        fhfecha: ((fhFecha && fhFecha.value) ? fhFecha.value : "")
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tPaquete').val(ui.item.label); // display the selected text
                $('#eCodServicio').val(ui.item.value); // save selected id to input
                $('#eMaxPiezas').val(ui.item.maxpiezas); // save selected id to input
                $('#dPrecioVenta').val(ui.item.precioventa); // save selected id to input
                return false;
            }
        });

       
        });
        }
        
        function verFecha(tipo)
        {
            procesoGuardar(true); 
             var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
            
              //lanzamos
                $.ajax({
                  type: "POST",
                  url: "/des/con/cata-"+tipo+"-con.php",
                  data: jsonString,
                  contentType: "application/json; charset=utf-8",
                  dataType: "json",
                  success: function(data){
                      procesoGuardar(false); 
                      $('#myModalPaquete').modal('show');
                      document.getElementById('detPaquete').innerHTML = data.html;
                  },
                  failure: function(errMsg) {
                      alert('Error al enviar los datos.');
                  }
              }); 
              //lanzamos   
            
        }
        
        function asignarPaquete(indice)
        {
            var eCodPaquete = document.getElementById('eCodPaquete'),
                eCodServicio = document.getElementById('paquete'+indice+'-eCodServicio');
            
            eCodPaquete.value=eCodServicio.value;
            verPaquete();
        }
        
        function verPaquete()
        {
            var eCodServicio = document.getElementById('eCodPaquete'),
                fhFechaEvento = document.getElementById('fhFechaEvento');
            
             var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
            
          if(eCodServicio.value && fhFechaEvento.value)
              {
                  
                 //document.getElementById('imgProceso').style.display = 'inline';
                  procesoGuardar(true); 
                  
              //lanzamos
                $.ajax({
                  type: "POST",
                  url: "/cla/con-paq.php",
                  data: jsonString,
                  contentType: "application/json; charset=utf-8",
                  dataType: "json",
                  success: function(data){
                      
                      //document.getElementById('imgProceso').style.display = 'none';
                  procesoGuardar(false); 
                  
                      $('#myModalPaquete').modal('show');
                      document.getElementById('detPaquete').innerHTML = data.html;
                  },
                  failure: function(errMsg) {
                      alert('Error al enviar los datos.');
                  }
              }); 
              //lanzamos   
            }
            else
                {
                    alert("Es necesario indicar la fecha del evento y el paquete a consultar");
                }
        }
        
        function buscarInventario(indice = false)
        {
             var fhFecha = document.getElementById('fhFechaEvento');
            
            $( function() {
  
        $( "#tInventario"+(indice ? indice : "") ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-inventario.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term,
                        fhfecha: ((fhFecha && fhFecha.value) ? fhFecha.value : "")
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tInventario'+(indice ? indice : "")).val(ui.item.label); // display the selected text
                $('#eCodServicio'+(indice ? indice : "")).val(ui.item.value); // save selected id to input
                $('#eMaxPiezas'+(indice ? indice : "")).val(ui.item.maxpiezas); // save selected id to input
                $('#dPrecioVenta'+(indice ? indice : "")).val(ui.item.precioventa); // save selected id to input
                
                var eCodInventario = document.getElementById('eCodInventario');
                if(eCodInventario)
                    {
                        eCodInventario.value = ui.item.value;
                    }
                
                return false;
            }
        });

       
        });
        }
        
        function filtrar()
        {
          document.getElementById('tAccion').value="C";
            
            document.getElementById('imgProceso').style.display = 'inline';
            
          var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  document.getElementById('imgProceso').style.display = 'none';
                  
                  document.getElementById('eRegistros').innerHTML = data.registros + " registros encontrados";
                  document.getElementById('divXHR').innerHTML = data.consulta;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
            
        }
        
        function eliminarGD(codigo)
        {
          document.getElementById('tAccion').value="D";
          document.getElementById('eAccion').value=codigo;
            
            document.getElementById('imgProceso').style.display = 'inline';
            
          var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('imgProceso').style.display = 'none';
                  if(data.exito==1)
                  {
                  $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide');  filtrar();  }, 1500);
                  }
                  else
                      {
                          var mensaje="";
                          var msgHTML="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                         msgHTML += "<div class=\"alert alert-danger\"><strong>"+data.errores[i]+"</strong></div>";
                     }
                          document.getElementById('divErrores').innerHTML = "<div class=\"alert alert-danger\"><strong>Error!</strong> Favor de validar la siguiente informaci&oacute;n</div>";
                          document.getElementById('divErrores').innerHTML += msgHTML;
                          setTimeout(function(){
                                $('#resError').modal('show');
                          },200);
                          //alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
                  
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
            
      
        }
        
        function finalizar(codigo)
        {
          document.getElementById('tAccion').value="F";
          document.getElementById('eAccion').value=codigo;
            
            document.getElementById('imgProceso').style.display = 'inline';
            
          var obj = $('#Datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/<?=$_GET['tCodSeccion'];?>/",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('imgProceso').style.display = 'none';
                  
                  $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide');  filtrar(); }, 1500);
                  
                 
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
            
      
        }
        
        function adjuntarComprobante(input,destino) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#falseinput').attr('src', e.target.result);
					$('#base').val(e.target.result);
          document.getElementById(destino).value=e.target.result;
          //llenar();
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
        
        function buscarSeccionRapida()
        {
           
             $( function() {
  
        $( "#tSecciones" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-secciones.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tSecciones').val(ui.item.label); // display the selected text
                window.location=ui.item.value;
                return false;
            }
        });

       
        }); 
        }
        
            
      $(document).ready( function () {
          
          //datepicker
          $(document).ready(function() {
              $('#fhFechaConsulta, #fhFechaEvento, #fhFecha').datepicker({
                  locale:'es',
                  dateFormat: "dd/mm/yy"
              });
          });
          
          
          
          if(document.getElementById('frmCalendario') && document.getElementById('calendario'))
              {
                  cambiarFecha(<?=date('m');?>,<?=date('Y');?>,1);
              }
          
          if(document.getElementById('datos') && document.getElementById('calendario'))
              {
                  cambiarFechaEvento(<?=date('m');?>,<?=date('Y');?>);
              }
          
         $('#cliTable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
    } );
          
          $('#cliTable, #misClientes1, #table, #tblClientes, #table0, #table1, #table2, #table3, #table4, #table5, #tblLogs').DataTable( {
        "scrollY": 400,
        "scrollX": true,
              paging: false,
              "order": [[ 0, "desc" ]]
    } );
           
      } );
        </script>  
    
</body>

</html>
