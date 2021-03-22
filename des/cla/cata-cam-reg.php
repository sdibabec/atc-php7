




<?php





session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodCamioneta            = $data->eCodCamioneta ? $data->eCodCamioneta : false;
        $tNombre                = $data->tNombre ? "'".utf8_encode($data->tNombre)."'" : ($data->tApellidos ? "'".utf8_encode($data->tApellidos)."'" : false);
        $tCodEstatus             = $data->tCodEstatus ? "'".utf8_encode($data->tCodEstatus)."'" : false;
        
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		

    if(!$eCodCamioneta)
        {
            $insert = " INSERT INTO CatCamionetas
            (
            tNombre,
            tCodEstatus
			)
            VALUES
            (
            $tNombre,
            $tCodEstatus
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatCamionetas
                        SET
                            tNombre= $tNombre ,
                            tCodEstatus= $tCodEstatus
                            WHERE
                            eCodCamioneta = ".$eCodCamioneta;
            
            
        }

        $pf = fopen("log.txt","w");
            fwrite($pf,$insert);
            fclose($pf);
        
        $rs = mysqli_query($conexion,$insert);
        
        $eCodCamioneta = $eCodCamioneta ? $eCodCamioneta : mysqli_insert_id($conexion);

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del vehiculo '.mysqli_error($conexion);
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el vehiculo ".sprintf("%07d",$eCodCamioneta);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>