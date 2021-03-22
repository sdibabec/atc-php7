




<?php





session_start();

$errores = array();





    $eCodEvento = $data->eCodEventoOperador;
    $eCodCamioneta = $data->eCodCamioneta;
    $tCampo = $data->tCampo;
    $tOperador = "'".$data->tResponsable."'";
    
   
        
    mysqli_query($conexion,"UPDATE BitEventos SET eCodCamioneta = $eCodCamioneta, $tCampo = $tOperador WHERE eCodEvento = ".$eCodEvento);

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>