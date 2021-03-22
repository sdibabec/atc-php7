




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodAnalisis      = $data->eCodAnalisis ? $data->eCodAnalisis : false;
        $dPrecio           = $data->dPrecio ? $data->dPrecio : false;
        $eCodTipoPieza     = $data->eCodTipoPieza ? $data->eCodTipoPieza : false;
        $eCodBroche        = $data->eCodBroche ? $data->eCodBroche : "null";
        $eCodMaterial      = $data->eCodMaterial ? $data->eCodMaterial : "null";
        $eLargo            = $data->eLargo ? $data->eLargo : "null";
        $tColor            = $data->tColor ? "'".$data->tColor."'" : "'N/A'";
        $tDijes            = $data->tDijes ? "'".$data->tDijes."'" : "'N/A'";
        $tPieza            = $data->tPieza ? "'".($data->tPieza)."'" : "null";
        $eCodOrnamento     = $data->eCodOrnamento ? ($data->eCodOrnamento) : "null";
        $eCodPieza         = $data->eCodPieza ? $data->eCodPieza : false;

        if(!$tPieza)
            $errores[] = 'El detalle de la pieza es obligatorio';
        if(!$dPrecio)
            $errores[] = 'El precio es obligatorio';
        if(!sizeof(!$data->piedras))
            $errores[] = 'Debe indicar al menos una piedra';

        

        
        if(!sizeof($errores))
        {
    if(!$eCodPieza)
        {
            $insert = " INSERT INTO RelSolicitudesAnalisisPiezas
            (
            eCodSolicitud,
            tPieza,
            dPrecio,
            eCodTipoPieza,
            eCodBroche,
            eCodMaterial,
            eLargo,
            tColor,
            tDijes,
            eCodOrnamento
			)
            VALUES
            (
            $eCodAnalisis,
            $tPieza,
            $dPrecio,
            $eCodTipoPieza,
            $eCodBroche,
            $eCodMaterial,
            $eLargo,
            $tColor,
            $tDijes,
            $eCodOrnamento
            )";
            
            $bTipo = 1;
        }
        else
        {
            $insert = "SELECT 1";
                            
                            $bTipo = 2;
        }
}
        
        
        $rs = mysqli_query($conexion,$insert);
        
        $eCodPieza = $eCodPieza ? $eCodPieza : mysqli_insert_id();

        if($rs)
        {
            $piedras = $data->piedras;
            if(sizeof($piedras))
            {
                mysqli_query($conexion,"DELETE FROM RelPiezasPiedras WHERE eCodPieza = ".$eCodPieza);
                foreach($piedras as $punto)
                {
                    if($punto->codigo)
                    {
                        mysqli_query($conexion,"INSERT INTO RelPiezasPiedras (eCodPieza,eCodPiedra) VALUES ($eCodPieza,$punto->codigo)");
                    }
                }
            }
            
            $select = " SELECT eCodEtapa FROM BitSolicitudesAnalisis WHERE eCodSolicitud = ".$eCodAnalisis;
            $rEtapa = mysqli_fetch_array(mysqli_query($conexion,$select));
            
            mysqli_query($conexion,"UPDATE BitSolicitudesAnalisis SET eCodEtapa = ".($rEtapa{'ecodEtaoa'}>2 ? $rEtapa{'ecodEtaoa'} : 2)." WHERE eCodSolicitud = ".$eCodAnalisis);
        }

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion de la pieza '.mysqli_error();
        }
        else
        {
            
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." el punto energetico ".sprintf("%07d",$eCodPieza);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(
    array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>