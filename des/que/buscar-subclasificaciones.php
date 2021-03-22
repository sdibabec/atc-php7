<?php header('Access-Control-Allow-Origin: *');  ?>
<?php header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); ?>
<?php header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE"); ?>
<?php header("Allow: GET, POST, OPTIONS, PUT, DELETE"); ?>
<?php header('Content-Type: application/json'); ?>
<?php

if (isset($_SERVER{'HTTP_ORIGIN'})) {
        header("Access-Control-Allow-Origin: {$_SERVER{'HTTP_ORIGIN'}}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }



session_start();
$conexion = $clSistema->conectarBD();
$errores = array();

$valores = '<option value="">Seleccione...</option>';


$data = json_decode( file_get_contents('php://input') );

/*Preparacion de variables*/
 
		$eCodTipoInventario = $data->eCodTipoInventario;

$select = "SELECT eCodSubclasificacion,tNombre FROM CatSubClasificacionesInventarios WHERE eCodTipoInventario=$eCodTipoInventario";
$rsSubclasificaciones = mysqli_query($conexion,$select);

while($rSubclasificacion = mysqli_fetch_array($rsSubclasificaciones))
{
   $valores .= '<option value="'.$rSubclasificacion{'eCodSubclasificacion'}.'">'.utf8_encode($rSubclasificacion{'tNombre'}).'</option>'; 
}


echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0),'valores'=>$valores, 'errores'=>$errores));

?>