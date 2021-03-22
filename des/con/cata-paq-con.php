
<?php




date_default_timezone_set('America/Mexico_City');

session_start();



$fhFecha      = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFechaConsulta = $fhFecha ? $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0] : false;

$tHTML = '<table class="table table-striped"><tr><td><b>Nombre</b></td><td>Disponibles</td></tr>';

$select = " SELECT * FROM CatServicios ORDER BY tNombre ASC";
$rsProductos = mysqli_query($conexion,$select);

		while($rProducto = mysqli_fetch_array($rsProductos))
		{
            $eDisponibles = calcularPaquete($conexion,$rProducto{'eCodServicio'},$fhFechaConsulta);
            
            
            $tHTML .= '<tr>';
            $tHTML .= '<td>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>