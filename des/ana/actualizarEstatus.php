




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodAnalisis            = $data->eCodAnalisis ? $data->eCodAnalisis : false;
        
        
        if(!sizeof($errores))
        {
            $insert = "UPDATE BitSolicitudesAnalisis SET eCodEtapa = 2 WHERE eCodSolicitud = $eCodAnalisis";
            $rs = mysqli_query($conexion,$insert);
            if(!$rs)
            {
                $errores[] = 'Error de insercion/actualizacion del análisis '.mysqli_error();
            }
        }
        
 

echo json_encode(
    array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'html'=>$tHTML));

?>