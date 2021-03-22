




<?php





session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodTipoInventario     = $data->eCodTipoInventario     ? $data->eCodTipoInventario             : false;
        $eCodSubclasificacion   = $data->eCodSubclasificacion   ? $data->eCodSubclasificacion           : false;
        $ePosicion              = $data->ePosicion              ? $data->ePosicion                      : false;
        $tNombre                = $data->tNombre                ? "'".utf8_encode($data->tNombre)."'"   : false;
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		$fhFechaCreacion        = "'".date('Y-m-d H:i')."'";

        if(!$eCodTipoInventario)
            $errores[] = 'El tipo de inventario es obligatorio';

        if(!$tNombre)
            $errores[] = 'El nombre es obligatorio';

        if(!$ePosicion)
            $errores[] = 'La posición es obligatoria';


        

        
        if(!sizeof($errores))
        {
    if(!$eCodSubclasificacion)
        {
            $insert = " INSERT INTO CatSubClasificacionesInventarios
            (
            eCodTipoInventario,
            tNombre,
            ePosicion
			)
            VALUES
            (
            $eCodTipoInventario,
            $tNombre,
            $ePosicion
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatSubClasificacionesInventarios
                        SET
                            tNombre= $tNombre,
                            eCodTipoInventario= $eCodTipoInventario,
                            ePosicion=$ePosicion
                            WHERE
                            eCodSubclasificacion = ".$eCodSubclasificacion;
        }
}
        
        
        $rs = mysqli_query($conexion,$insert);
        
        $eCodTipoInventario = $eCodTipoInventario ? $eCodTipoInventario : mysqli_insert_id($conexion);

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del cliente '.mysqli_error($conexion);
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el tipo de inventario ".sprintf("%07d",$eCodCliente);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>