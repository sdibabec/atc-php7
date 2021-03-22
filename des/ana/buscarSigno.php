




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



function convertirFecha($fecha)
{
    $formato = explode("/",$fecha);
    
    $eAnio = $formato[2];
    $eMes  = $formato[1];
    $eDia  = $formato[0];
    
    $eAnio = ($eMes==1 && $eDia<=19) ? 2021 : 2020;
    
    $cadena = $eAnio.'-'.$eMes.'-'.$eDia;
    
    return $cadena;
}

function convertirFechaNacimiento($fecha)
{
    $formato = explode("/",$fecha);
    
    $eAnio = $formato[2];
    $eMes  = $formato[1];
    $eDia  = $formato[0];
    
    $cadena = $eAnio.'-'.$eMes.'-'.$eDia;
    
    return $cadena;
}

/*Preparacion de variables*/
        
   $fhFechaNacimiento = $data->fhFechaNacimiento ? "'".convertirFecha($data->fhFechaNacimiento)."'" : false;


/*signo zodiacal*/
$select = " SELECT * FROM CatSignosZodiaco WHERE $fhFechaNacimiento BETWEEN fhFechaInicio AND fhFechaTermino ";
$r = mysqli_fetch_array(mysqli_query($conexion,$select));
$eCodSignoZodiaco = $r{'eCodSignoZodiaco'};

/*horoscopo chino*/
$select = " SELECT * FROM CatHoroscopoChino WHERE '".convertirFechaNacimiento($data->fhFechaNacimiento)."' BETWEEN DATE(fhFechaInicio) AND DATE(fhFechaTermino) ";
$r = mysqli_fetch_array(mysqli_query($conexion,$select));
$eCodHoroscopo = $r{'eCodHoroscopo'};
   

echo json_encode(
                    array(
                        "exito"=>((!sizeof($errores)) ? 1 : 0), 
                        'errores'=>$errores, 
                        'signo'=>$eCodSignoZodiaco,
                        'horoscopo'=>$eCodHoroscopo
                        )
                );

?>