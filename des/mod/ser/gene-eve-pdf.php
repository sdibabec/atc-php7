<?php

require_once("../../cls/cls-sistema.php");
require_once("../../cls/cls-nav.php");

$clSistema = new clSis();
$clNav = new clNav();

$conexion = $clSistema->conectarBD();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

if($_GET['v2']=="cotizacion")
{
$url = $clNav->obtenerURL()."des/mod/ser/light-eve-det.php?eCodEvento=".$_GET['v1'];
}
if($_GET['v2']=="maestra")
{
$url = $clNav->obtenerURL()."des/mod/pdf/hoja-maestra.php?eCodEvento=".$_GET['v1'];
}

$html=file_get_contents($url);



$html=str_replace('font-size:14px;','font-size:12px;',$html);






//==============================================================
//==============================================================
//==============================================================


include("../../../mpdf/mpdf-2.php");
$mpdf=new mPDF('c'); 

//if($_GET['v2']=="maestra")
//{
//    $mpdf->AddPage('L');
//}

$mpdf->mirrorMargins = true;

$mpdf->SetDisplayMode('fullpage','two');

$mpdf->WriteHTML($html);



$mpdf->Output();
exit;


//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>