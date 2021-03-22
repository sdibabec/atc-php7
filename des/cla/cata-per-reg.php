




<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }



session_start();

$pf = fopen("logPerfil.txt","a");

$errores = array();




/*Preparacion de variables*/
        
        $eCodPerfil = $data->eCodPerfil ? $data->eCodPerfil : false;
    if(!$eCodPerfil)
    {
        $tNombre = "'".$data->tNombre."'";
        $insert = "INSERT INTO SisPerfiles (tNombre) VALUES($tNombre)";
        $rsNuevo = mysqli_query($conexion,$insert);
        
        $select = "SELECT eCodPerfil FROM SisPerfiles WHERE tNombre = $tNombre";
        $rPerfil = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $eCodPerfil = $rPerfil{'eCodPerfil'};
        
        if(!$rsNuevo)
        {
            $errores[] = 'Error de creacion del perfil '.mysqli_error($conexion);
        }
    }
    
    mysqli_query($conexion,"DELETE FROM SisSeccionesPerfilesInicio WHERE eCodPerfil = $eCodPerfil");
    mysqli_query($conexion,"INSERT INTO SisSeccionesPerfilesInicio (eCodPerfil, tCodSeccion) VALUES ($eCodPerfil,'".$data->tCodSeccionInicio."')");
    
	mysqli_query($conexion,"DELETE FROM SisSeccionesPerfiles WHERE eCodPerfil = $eCodPerfil");

    
	foreach($data->secciones as $secciones)
	{
		$tCodSeccion = $secciones->tCodSeccion ? "'".$secciones->tCodSeccion."'" : false;
		$bAll = $secciones->bAll ? $secciones->bAll : 0;
        $bDelete = $secciones->bDelete ? $secciones->bDelete : 0;
        
        if($tCodSeccion)
        { 
            $insert = "INSERT INTO SisSeccionesPerfiles (eCodPerfil, tCodSeccion, bAll, bDelete) VALUES ($eCodPerfil, $tCodSeccion, $bAll, $bDelete)";
            fwrite($pf,$insert."\n");
            $rs = mysqli_query($conexion,$insert);

            if(!$rs)
            {
                $errores[] = 'Error al adjuntar la secci&oacute;n '.$secciones->tCodSeccion.' al perfil '.mysqli_error($conexion);
            } 
        }
	}
        
  

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>