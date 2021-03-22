




<?php



session_start();

$bAll = $_SESSION['bAll'];


date_default_timezone_set('America/Mexico_City');

session_start();



$eCodServicio = $data->eCodPaquete ? $data->eCodPaquete : false;
$fhFecha      = $data->fhFechaEvento ? explode("/",$data->fhFechaEvento) : false;

$fhFechaConsulta = $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0];

$select = " SELECT * FROM CatServicios WHERE eCodServicio = $eCodServicio";
$rsServicio = mysqli_query($conexion,$select);
$rServicio = mysqli_fetch_array($rsServicio);

$tHTML = '<table><tr><td colspan="3">'.$rServicio{'tNombre'}.'</td></tr>';
$tHTML .= '<tr><td colspan="3">Disponibles: <b>'.calcularPaquete($eCodServicio,$fhFechaConsulta).'</b></td></tr>';
$tHTML .= '<tr><td colspan="3" height="20"></td></tr>';

            $tHTML .= '<tr>';
            $tHTML .= '<td>Producto</td>';
            $tHTML .= '<td>Piezas Paq.</td>';
            $tHTML .= '<td>Piezas Disp.</td>';
            $tHTMl .= '</tr>';


$select = 	" SELECT  ".
					" 	rsi.ePiezas ePiezasPaquete,  ".
					" 	ci.ePiezas ePiezasInventario,  ".
					" 	ci.eCodInventario,  ".
					" 	ci.tNombre  ".
					" FROM  ".
					" 	RelServiciosInventario rsi  ".
					" INNER JOIN CatInventario ci ON ci.eCodInventario=rsi.eCodInventario  ".
					" WHERE rsi.eCodServicio = $eCodServicio";
		
		$rsProductos = mysqli_query($conexion,$select);
		while($rProducto = mysqli_fetch_array($rsProductos))
		{
            $eDisponibles = calcularInventario($conexion,$rProducto{'eCodInventario'},$fhFechaConsulta);
            
            $clase = ($eDisponibles < $rProducto{'ePiezasPaquete'}) ? 'class="status--denied"' :  '';
            
            $tHTML .= '<tr>';
            $tHTML .= '<td>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td>'.$rProducto{'ePiezasPaquete'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>