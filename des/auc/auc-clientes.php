<?php
<<<<<<< HEAD
require_once("../cnx/swgc-mysql.php");
=======
require_once("cnx/swgc-mysql.php");
>>>>>>> 1798ee66a08257a96aae30de33690da99f0f4af2
header('Content-Type: application/json');

$paquetes = array();

$select = "SELECT * FROM CatClientes";
$rsPaquetes = mysqli_query($conexion,$select);
while($rPaquete = mysqli_fetch_array($rsPaquetes))
{
<<<<<<< HEAD
	$paquetes[] = array('codigo'=>$rPaquete{'eCodCliente'},'nombre'=>$rPaquete{'tNombres'}.' '.$rPaquete{'tApellidos'}.' ('.$rPaquete{'tCorreo'}.')');
=======
	$paquetes[] = array('codigo'=>$rPaquete{'eCodCliente'},'cliente'=>$rPaquete{'tNombres'}.' '.$rPaquete{'tApellidos'}.' ('.$rPaquete{'tCorreo'}.')');
>>>>>>> 1798ee66a08257a96aae30de33690da99f0f4af2
}

echo json_encode($paquetes);

?>