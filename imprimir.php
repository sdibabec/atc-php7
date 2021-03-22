<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);


require_once("./des/cls/cls-sistema.php");


$clSistema = new clSis();

$conexion = $clSistema->conectarBD();

$select = " SELECT cc.tNombre, cc.tApellidos, cc.tPerfil, bs.fhFecha, bs.eCodSolicitud, bs.tResumen, cc.fhFechaNacimiento FROM BitSolicitudesAnalisis bs INNER JOIN CatClientes cc ON cc.eCodCliente = bs.eCodCliente WHERE bs.eCodSolicitud = ".$_GET['v1'];
$rs = mysqli_query($conexion,$select);
$rDetalle = mysqli_fetch_array($rs);

$opciones = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);



$contexto = stream_context_create($opciones);

$url = $clSistema->variablesSistema('tURL');

$html = file_get_contents($url.'/generador.php?v1='.$_GET['v1'], false, $contexto);

$stylesheet = file_get_contents('https://use.typekit.net/xyj7mbb.css',false,$contexto);

//==============================================================
//==============================================================
//==============================================================
include("./mpdf/mpdf.php");
$mpdf=new mPDF('c'); 

//$mpdf->SetFont('indieflower');

//$mpdf->SetAutoFont('indieflower');

$mpdf->WriteHTML($stylesheet,1);

$mpdf->mirrorMargins = false;



$portada = '<html>
<head>
    <style type="text/css">
        body
        {
           
            background-image: url(\'/hojas/portada.jpg\');
            background-size: cover;
            text-align:center !important;
        }
        .titulo
        {
            text-align:center !important;
            font-size: 2.5em !important;
            font-weight: bold;
        }
    </style>
</head>

<body>
<h3>Fecha del an&aacute;lisis: '.($rDetalle{'fhFecha'} ? date('d/m/Y',strtotime($rDetalle{'fhFecha'})) : '').'</h3>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h1 class="titulo"><i>'.($rDetalle{'tNombre'} ? ($rDetalle{'tNombre'}.' '.$rDetalle{'tApellidos'}) : $rDetalle{'tPerfil'}).'</i></h1><h2><i>
'.($rDetalle{'fhFechaNacimiento'} ? date('d/m/Y',strtotime($rDetalle{'fhFechaNacimiento'})) : '').'</i></h2>
</body></html>';

$mpdf->WriteHTML($portada);

$mpdf->AddPage();

$mpdf->defaultfooterline = 0;

$mpdf->SetFooter('{PAGENO} / {nb}');

$mpdf->defaultfooterline = 0;

$mpdf->SetDisplayMode('fullpage','continuous');

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html);





$mpdf->Output(($rDetalle{'tNombre'} ? ($rDetalle{'tNombre'}.'-'.$rDetalle{'tApellidos'}) : $rDetalle{'tPerfil'}).'.pdf', 'I');
exit;
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>