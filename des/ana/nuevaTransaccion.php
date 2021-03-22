




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodAnalisis        = $data->eCodPedido ? $data->eCodPedido : false;
        $dMonto           = $data->dMonto ? $data->dMonto : false;
        $eCodTipoPago      = $data->eCodTipoPago ? $data->eCodTipoPago : false;

        $fhFecha = "'".date('Y-m-d')."'";
        

        if(!$eCodAnalisis)
            $errores[] = 'El analisis es obligatorio';
        if(!$dMonto)
            $errores[] = 'El monto es obligatorio';
        if(!$eCodTipoPago)
            $errores[] = 'La forma de pago es obligatoria';

        

        
        if(!sizeof($errores))
        {
            $insert = " INSERT INTO BitTransacciones
            (
            eCodAnalisis,
            dImporte,
            fhFecha,
            eCodTipoPago
			)
            VALUES
            (
            $eCodAnalisis,
            $dMonto,
            $fhFecha,
            $eCodTipoPago
            )";
            
            $bTipo = 1;
}
        
        
        $rs = mysqli_query($conexion,$insert);
        
        $eCodTransaccion = $eCodTransaccion ? $eCodTransaccion : mysqli_insert_id();


        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion de la transaccion '.mysqli_error();
        }
        else
        {
            
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." la transaccion ".sprintf("%07d",$eCodTransaccion);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(
    array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>