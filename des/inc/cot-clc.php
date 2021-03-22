<?php
include("../cnx/swgc-mysql.php");


date_default_timezone_set('America/America/Mexico_City');


	function calcularInventario($eCodInventario,$fhFecha)
	{
		$ePiezas = 0;
		
		$select = "SELECT ePiezas FROM CatInventario WHERE eCodInventario = $eCodInventario";
		$rsInventario = mysqli_query($conexion,$select);
		$rInventario = mysqli_fetch_array($rsInventario);
        
        if($fhFecha)
        {
            $select = "SELECT ci.ePiezas, ( SELECT SUM( re.eCantidad ) eCantidad FROM RelEventosPaquetes re INNER JOIN BitEventos be ON be.eCodEvento= re.eCodEvento WHERE re.eCodServicio = ci.eCodInventario AND re.eCodTipo = 2 AND be.eCodEstatus=2 AND DATE ( be.fhFechaEvento ) = '".$fhFecha."' ) eOcupados FROM CatInventario ci WHERE eCodInventario = ".$eCodInventario;
            $rsCalculado = mysqli_query($conexion,$select);
            $rCalculado = mysqli_fetch_array($rsCalculado);
            
        }
		
		$ePiezas = (!$fhFecha) ? $rInventario{'ePiezas'} : ( (int)$rInventario{'ePiezas'} - (int)$rCalculado{'eOcupados'});
		
		return $ePiezas;
	}
    
//floor(number) returns the nearest DOWN of a number

	function  calcularPaquete($eCodServicio,$fhFecha)
	{
		$eCantidad = 0;
		
		$eCantidades = array();
        
		$select = 	" SELECT  ".
					" 	rsi.ePiezas ePiezasPaquete,  ".
					" 	ci.ePiezas ePiezasInventario,  ".
					" 	ci.eCodInventario  ".
					" FROM  ".
					" 	RelServiciosInventario rsi  ".
					" INNER JOIN CatInventario ci ON ci.eCodInventario=rsi.eCodInventario  ".
					" WHERE rsi.eCodServicio = $eCodServicio";
		
		$rsProductos = mysqli_query($conexion,$select);
		while($rProducto = mysqli_fetch_array($rsProductos))
		{
           
            $eTotal = ($fhFecha ? calcularInventario($rProducto{'eCodInventario'},$fhFecha) : (int)$rProducto{'ePiezasInventario'}) / (int)$rProducto{'ePiezasPaquete'};
            $eTotal = floor($eTotal);
			$eCantidades[] = $eTotal;
		}
        
		return min($eCantidades);
	}
?>