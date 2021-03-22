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
                            "label"=>$row{'tNombre'}.' Servicio de '.$row{'eHoras'}.' horas',
                            "maxpiezas"=>calcularPaquete($row{'eCodServicio'},$fhFecha),
                            "precioventa"=>$row{'dPrecioVenta'},
                            "horaextra"=>$row{'dHoraExtra'}
                            );
    }

    echo json_encode($response);
}
 
//30 puff

?>