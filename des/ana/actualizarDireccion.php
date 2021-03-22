




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
        $eCodAnalisis            = $data->eCodAnalisis ? $data->eCodAnalisis : false;
        $tTelefono               = $data->tTelefono ? "'".($data->tTelefono)."'" : false;
        $tDireccion              = $data->tDireccion ? "'".($data->tDireccion)."'" : false;
		

        if(!$tTelefono)
            $errores[] = 'El telefono es obligatorio';
        if(!$tDireccion)
            $errores[] = 'La direccion es obligatoria';
        /*if(!$tDescripcion)
            $errores[] = 'La descripcion es obligatoria';*/

        

        
        if(!sizeof($errores))
        {
            $insert = "UPDATE CatClientes SET tTelefono=$tTelefono, tDireccion=$tDireccion WHERE eCodCliente = (SELECT eCodCliente FROM BitSolicitudesAnalisis WHERE eCodSolicitud = $eCodAnalisis)";
            $rs = mysqli_query($conexion,$insert);
            if(!$rs)
            {
                $errores[] = 'Error de insercion/actualizacion de la direccion '.mysqli_error();
            }
        }
        
 

echo json_encode(
    array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'html'=>$tHTML));

?>