




<?php





session_start();

$errores = array();

function base64toImage($datos)
{
    $fname = "../inv/".uniqid().'.jpg';
        $datos1 = explode(',', base64_decode($datos));
        $content = base64_decode($datos1[1]);
        //$img = filter_input(INPUT_POST, "image");
        //$img = str_replace(array('data:image/png;base64,','data:image/jpg;base64,'), '', base64_decode($data));
        //$img = str_replace(' ', '+', $img);
        //$img = base64_decode($img);
        
        //file_put_contents($fname, $img);
        
        $pf = fopen($fname,"w");
        fwrite($pf,$content);
        fclose($pf);
        
        return $fname;
}



/*Preparacion de variables*/
        
        $eCodInventario = $data->eCodInventario ? $data->eCodInventario : false;
		$eCodTipoInventario = $data->eCodTipoInventario;
		$eCodSubclasificacion = $data->eCodSubclasificacion;
        $tNombre = "'".$data->tNombre."'";
        $tMarca = "'".$data->tMarca."'";
        $tDescripcion = "'".$data->tDescripcion."'";
        $dPrecioInterno = $data->dPrecioInterno;
        $dPrecioVenta = $data->dPrecioVenta;
        $ePiezas = $data->ePiezas;
        $eStock = $data->eStock;
        $tImagen = $data->bFichero ? "'".$data->tFichero."'" : ($data->tImagen ? "'".base64toImage(base64_encode($data->tImagen))."'" : "NULL");

if(!$eCodTipoInventario)
   $errores[] = 'El tipo de producto es obligatorio'; 

if(!$eCodSubclasificacion)
   $errores[] = 'La subclasificacion es obligatoria'; 

if(!$tNombre)
   $errores[] = 'El nombre de producto es obligatorio'; 

if(!$tMarca)
   $errores[] = 'La marca de producto es obligatorio'; 

if(!$tDescripcion)
   $errores[] = 'La descripcion de producto es obligatorio'; 

if(!$dPrecioInterno)
   $errores[] = 'El precio interno de producto es obligatorio'; 

if(!$dPrecioVenta)
   $errores[] = 'El precio de venta de producto es obligatorio'; 

if(!$ePiezas)
   $errores[] = 'Las piezas de producto son obligatorias'; 

if(!$eStock)
   $errores[] = 'El stock es obligatorio'; 


        
if(!sizeof($errores))
{
        if(!$eCodInventario)
        {
            $insert = " INSERT INTO CatInventario
            (
			eCodTipoInventario,
			eCodSubclasificacion,
            tNombre,
            tMarca,
            tDescripcion,
            dPrecioVenta,
			dPrecioInterno,
			tImagen,
			ePiezas,
			eStock
			)
            VALUES
            (
            $eCodTipoInventario,
            $eCodSubclasificacion,
            $tNombre,
            $tMarca,
            $tDescripcion,
            $dPrecioVenta,
			$dPrecioInterno,
			$tImagen,
			$ePiezas,
			$eStock
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatInventario
                        SET
                            eCodTipoInventario=$eCodTipoInventario,
                            eCodSubclasificacion=$eCodSubclasificacion,
            				tNombre=$tNombre,
            				tMarca=$tMarca,
            				tDescripcion=$tDescripcion,
            				dPrecioVenta=$dPrecioVenta,
							dPrecioInterno=$dPrecioInterno,
							tImagen=$tImagen,
							ePiezas=$ePiezas,
							eStock=$eStock
                            WHERE
                            eCodInventario = ".$eCodInventario;
        }
}
        
        $rs = mysqli_query($conexion,$insert);

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del producto en inventario '.mysqli_error($conexion);
        }
        
        $eCodInventario = $eCodInventario ? $eCodInventario : mysqli_insert_id($conexion);

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el producto ".sprintf("%07d",$eCodInventario);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin'][0]['eCodUsuario'];
    mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>