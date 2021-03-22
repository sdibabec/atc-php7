
<?php




date_default_timezone_set('America/Mexico_City');

session_start();





$fhFecha      = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFechaConsulta = $fhFecha ? $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0] : false;

$fhFecha = preg_match($regex,$fhFecha) ? $fhFecha : date('Y-m-d');

$tHTML = '<table class="table table-striped"><tr><td><b>Nombre</b></td><td>Piezas</td><td>Disponibles</td></tr>';

$select = " SELECT * FROM CatInventario ORDER BY tNombre ASC";
$rsProductos = mysqli_query($conexion,$select);

		while($rProducto = mysqli_fetch_array($rsProductos))
		{
            $eDisponibles = calcularInventario($conexion,$rProducto{'eCodInventario'},$fhFechaConsulta);
            
            $clase = ($rProducto{'ePiezas'}!=$eDisponibles) ? 'style="font-weight:bold;"' :  '';
            
            $tHTML .= '<tr>';
            $tHTML .= '<td '.$clase.'>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$rProducto{'ePiezas'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>