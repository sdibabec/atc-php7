




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodPuntoEnergetico            = $data->eCodPuntoEnergetico ? $data->eCodPuntoEnergetico : false;
        $tNombre                = $data->tNombreTrabajo ? "'".($data->tNombreTrabajo)."'" : false;
        $tDescripcion                = $data->tNombreTrabajo ? "'".($data->tNombreTrabajo)."'" : false;
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		$fhFechaCreacion        = "'".date('Y-m-d H:i')."'";

        if(!$tNombre)
            $errores[] = 'El nombre es obligatorio';
        /*if(!$tDescripcion)
            $errores[] = 'La descripcion es obligatoria';*/

        

        
        if(!sizeof($errores))
        {
    if(!$eCodPuntoEnergetico)
        {
            $insert = " INSERT INTO CatPuntosEnergeticos
            (
            tNombre,
            tDescripcion
			)
            VALUES
            (
            $tNombre,
            $tDescripcion
            )";
            
            $bTipo = 1;
        }
        else
        {
            $insert = "UPDATE 
                            CatPuntosEnergeticos
                        SET
                            tNombre= $tNombre,
                            tDescripcion = $tDescripcion
                            WHERE
                            eCodPuntoEnergetico = ".$eCodPuntoEnergetico;
                            
                            $bTipo = 2;
        }
}
        
        
        $rs = mysqli_query($conexion,$insert);
        
        $eCodPuntoEnergetico = $eCodPuntoEnergetico ? $eCodPuntoEnergetico : mysqli_insert_id();

        if($rs)
        {
            $piedras = $data->relacion;
            if(sizeof($piedras))
            {
                mysqli_query($conexion,"DELETE FROM RelPiedrasPuntosEnergeticos WHERE eCodPuntoEnergetico = ".$eCodPuntoEnergetico);
                foreach($piedras as $punto)
                {
                    if($punto->eCodPiedra)
                    {
                        mysqli_query($conexion,"INSERT INTO RelPiedrasPuntosEnergeticos (eCodPiedra,eCodPuntoEnergetico) VALUES ($punto->eCodPiedra,$eCodPuntoEnergetico)");
                    }
                }
            }
        }

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del punto energetico '.mysqli_error();
        }
        else
        {
            $tHTML = '<tr><td><label><input type="checkbox" onclick="analizar();" id="eCodPuntoEnergetico'.((int)$eCodPuntoEnergetico-1).'" name="puntos['.((int)$eCodPuntoEnergetico-1).'][codigo]" value="'.((int)$eCodPuntoEnergetico).'" checked="checked"> '.($data->tNombre).'</label></td></tr>';
            
            $_SESSION['sesionTrabajo'] = $eCodPuntoEnergetico;
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." el punto energetico ".sprintf("%07d",$eCodPuntoEnergetico);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(
    array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'html'=>$tHTML));

?>