<?php

require_once("../cls/cls-sistema.php");
require_once("../inc/cot-clc.php");




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
    
    $select =  "	SELECT  ".
	           " 	cti.tNombre as tipo,  ".
	           " 	ci.* ".
	           " FROM ".
	           " 	CatInventario ci ".
	           " 	INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario = ci.eCodTipoInventario ".
	           " 	WHERE 1=1 $termino ".
	           " ORDER BY ci.tNombre ASC";
    
    $select = "	SELECT * FROM CatInventario WHERE 1=1 ".$termino." ORDER BY eCodInventario ASC";

    
            $result = mysqli_query($conexion,$select);
    
    while($row = mysqli_fetch_array($result)){
        $response[] = array(
                            "value"=>$row{'eCodInventario'},
                            "label"=>$row{'tNombre'},
                            "maxpiezas"=>calcularInventario($conexion,$row{'eCodInventario'},$fhFecha),
                            "precioventa"=>$row{'dPrecioVenta'}
                            );
    }

    echo json_encode($response);
}
 
//30 puff

?>