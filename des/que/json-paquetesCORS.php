<?php header('Access-Control-Allow-Origin: *');  ?>
<?php header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); ?>
<?php header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE"); ?>
<?php header("Allow: GET, POST, OPTIONS, PUT, DELETE"); ?>
<?php header('Content-Type: application/json'); ?>
<?php


require_once("../cls/cls-sistema.php");




$clSistema = new clSis();
session_start();
$conexion = $clSistema->conectarBD();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$response = array();

if($_POST['search'] || $_GET['search']){
    $search = $_POST['search'] ? $_POST['search'] : $_GET['search'];
    $fhFecha = $_POST['fhfecha'] ? $_POST['fhfecha'] : ($_GET['fhfecha'] ? $_GET['fhfecha'] : false);
    
    
    $terms = explode(" ",$search);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND tNombre like '%".$terms[$i]."%' ";
    }
    
    $select = "	SELECT * FROM CatServicios WHERE 1=1 ".$termino." ORDER BY eCodServicio ASC";

    
            $result = mysqli_query($conexion,$select);
    
    while($row = mysqli_fetch_array($result)){
        $response[] = array(
                            "value"=>$row{'eCodServicio'},
                            "label"=>$row{'tNombre'},
                            "maxpiezas"=>calcularPaquete($row{'eCodServicio'},$fhFecha),
                            "precioventa"=>$row{'dPrecioVenta'}
                            );
    }

    echo json_encode($response);
}
 
//30 puff

?>