




<?php




session_start();

$errores = array();


$eCodEvento = $data->eCodEventoCarga ? $data->eCodEventoCarga : "NULL";
$eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
$fhFechaCarga = "'".date('Y-m-d H:i:s')."'";
$eCodCamioneta = $data->eCodCamioneta ? $data->eCodCamioneta : "NULL";

$insert = "INSERT INTO SisRegistrosCargas (eCodEvento, eCodUsuario, fhFechaCarga, eCodCamioneta) VALUES ($eCodEvento, $eCodUsuario, $fhFechaCarga, $eCodCamioneta)";

$rsInsert = mysqli_query($conexion,$insert);
if($rsInsert)
{
$rBusqueda = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM SisRegistrosCargas WHERE eCodEvento = $eCodEvento"));
$eCodRegistro = $rBusqueda{'eCodRegistro'};

    foreach($data->inventario as $inventario)
    {
        $eCodInventario = $inventario->eCodInventario ? $inventario->eCodInventario : "NULL";
        $eCantidad = $inventario->eCantidad ? $inventario->eCantidad : "NULL";
        $insert = "INSERT INTO RelRegistrosCargasInventario (eCodRegistro, eCodInventario, eCantidad) VALUES ($eCodRegistro, $eCodInventario, $eCantidad)";
        
        if(!mysqli_query($conexion,$insert))
        {
            $errores[] = "Error al guardar el producto en el evento de carga";
        }
    }
    
}
else
{
    $errores[] = "Error al guardar el registro de carga";
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>