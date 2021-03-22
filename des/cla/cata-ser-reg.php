




<?php





session_start();

$errores = array();



$pf = fopen("jsonInventarioPaquete.txt","w");
fwrite($pf,date('Y-m-d H:i:s')."\n");
fwrite($pf,json_encode($data)."\n\n");
fclose($pf);

/*Preparacion de variables*/
        
        $eCodServicio = $data->eCodServicio ? $data->eCodServicio : false;
        $tNombre = "'".utf8_encode($data->tNombre)."'";
        $tDescripcion = "'".base64_encode($data->tDescripcion)."'";
        $dPrecio = $data->dPrecio;
        $eHoras = $data->eHoras ? $data->eHoras : false;
        $dHoraExtra = $data->dHoraExtra ? $data->dHoraExtra : "NULL";

if(!trim($data->tNombre))
{
    $errores[] = 'El nombre es obligatorio';
}

if(!trim($data->tDescripcion))
{
    $errores[] = 'La descripcion es obligatorio';
}

if(!trim($data->dPrecio))
{
    $errores[] = 'El precio es obligaorio';
}

if(!$eHoras)
{
    $errores[] = 'Las horas de servicio son obligatorias';
}

 foreach($data->inventario as $inventario)
	       {  
	       	$eCodInventario   =   $inventario->eCodInventario ? $inventario->eCodInventario : false;
	       	$ePiezas          =   $inventario->ePiezas;
            
                if($eCodInventario && !(int)$ePiezas)
                       {
                           $errores[] = 'Las piezas deben ser enteras';
                       } 
            
                  
	       }
        
if(!sizeof($errores))
    {
    //mysqli_query($conexion,"START TRANSACTION");
    
        if(!$eCodServicio)
        {
            $insert = " INSERT INTO CatServicios
            (
            tNombre,
            tDescripcion,
            dPrecioVenta,
            dHoraExtra,
            eHoras
			)
            VALUES
            (
            $tNombre,
            $tDescripcion,
            $dPrecio,
            $dHoraExtra,
            $eHoras
            )";
            
            $bTipo = 1;
        }
        else
        {
            $insert = "UPDATE 
                            CatServicios
                        SET
                            tNombre= $tNombre,
                            tDescripcion= $tDescripcion,
                            dPrecioVenta= $dPrecio,
                            dHoraExtra = $dHoraExtra,
                            eHoras = $eHoras
                            WHERE
                            eCodServicio = ".$eCodServicio;
            
            $bTipo = 2;
        }
    
    
        $pf = fopen("logEdicionPaquete.txt","a");
fwrite($pf,$insert."\n");
fclose($pf);
        
        $rs = mysqli_query($conexion,$insert);

        if(!$rs)
        {
            $errores[] = 'Error de '.(($bTipo==1) ? 'inserción' : 'actualizacion').' del paquete '.mysqli_error($conexion);
        }
        else
        {
        $select = "SELECT MAX(eCodServicio) eCodServicio FROM CatServicios";
        $rServicio = mysqli_fetch_array(mysqli_query($conexion,$select));
		
		$eCodServicio = $eCodServicio ? $eCodServicio : $rServicio{'eCodServicio'};
		
		mysqli_query($conexion,"DELETE FROM RelServiciosInventario WHERE eCodServicio = $eCodServicio");
    
            $inventario = $data->inventario;
            
            
	       
            foreach($data->inventario as $inventario)
	       {
                
                
                
	       	$eCodInventario   =   $inventario->eCodInventario ? $inventario->eCodInventario : false;
	       	$ePiezas          =   $inventario->ePiezas;
                
                if($eCodInventario && $ePiezas && (int)$ePiezas)
                {
                   $rs = "INSERT INTO RelServiciosInventario (eCodServicio, eCodInventario, ePiezas) VALUES ($eCodServicio, $eCodInventario, $ePiezas)";
                   
                   $pf = fopen("logEdicionPaquete.txt","a");
                    fwrite($pf,$rs."\n");
                    fclose($pf);
                
	       	       if(!mysqli_query($conexion,$rs))
                        {
                            $errores[] = 'Error al agregar producto de inventario al paquete';
                        } 
                }
                
                
	       }
            
            $pf = fopen("logEdicionPaquete.txt","a");
fwrite($pf,"\n\n");
fclose($pf);
        }
    }

//mysqli_query($conexion,(!sizeof($errores)) ? "COMMIT TRANSACTION" : "ROLLBACK TRANSACTION");

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." el paquete ".sprintf("%07d",$eCodServicio);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 2), "errores"=>$errores));

?>