




<?php



//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);



//$pf = fopen("logUSR.txt","a");

session_start();

$tCodPadre = "'".$_SESSION['sessionAdmin']['tCodUsuario']."'";

$errores = array();



$tUUID = "'".substr(str_replace("-","",uniqid()),0,16)."'";

//fwrite($pf,json_encode($data)."\n\n");

$eCodUsuario = $data->eCodUsuario ? $data->eCodUsuario : false;
        $eCodPerfil = $data->eCodPerfil ? $data->eCodPerfil : false;
        $tNombre = $data->tNombre ? "'".utf8_encode($data->tNombre)."'" : false;
        $tApellidos = $data->tApellidos ? "'".utf8_encode($data->tApellidos)."'" : false;
        $tPasswordAcceso = $data->tPasswordAcceso ? "'".base64_encode($data->tPasswordAcceso)."'" : false;
        $tPasswordOperaciones = $data->tPasswordAcceso ? "'".base64_encode($data->tPasswordAcceso)."'" : false;
        //$tPasswordOperaciones = $data->tPasswordOperaciones ? "'".base64_encode($data->tPasswordOperaciones)."'" : false;
        $tCorreo = $data->tCorreo ? "'".$data->tCorreo."'" : false;
        $eCodCliente = $data->eCodCliente ? $data->eCodCliente : "NULL";
        $bAll = $data->bAll ? 1 : 0;
        $eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;
        
        $fhFechaCreacion = "'".date('Y-m-d H:i:s')."'";
 if(!$eCodPerfil)  
 {$errores[] = 'El perfil es obligatorio';}
 if(!$tNombre)  
 {$errores[] = 'El nombre es obligatorio';}
 if(!$tApellidos)  
 {$errores[] = 'Los apellidos son obligatorios';}
 if(!$tPasswordAcceso)  
 {$errores[] = 'El password de acceso es obligatorio';}
 //if(!$tPasswordOperaciones)  
 //{$errores[] = 'El password de operaciones es obligatorio';}
 if(!$tCorreo)  
 {$errores[] = 'El correo es obligatorio';}
 if(!$eCodEstatus)  
 {$errores[] = 'El estatus es obligatorio';}

if(!sizeof($errores))
{
        if(!$eCodUsuario)
        {
            $insert = "INSERT INTO SisUsuarios (tNombre, tApellidos, tCorreo, tPasswordAcceso, tPasswordOperaciones,  eCodEstatus, eCodPerfil, fhFechaCreacion,bAll, tCodUsuario,tCodPadre) VALUES ($tNombre, $tApellidos, $tCorreo, $tPasswordAcceso, $tPasswordOperaciones, $eCodEstatus, $eCodPerfil, $fhFechaCreacion,$bAll, $tUUID,$tCodPadre)";
        }
        else
        {
            $insert = "UPDATE SisUsuarios SET
            tPasswordAcceso = $tPasswordAcceso,
            tPasswordOperaciones = $tPasswordOperaciones,
            eCodPerfil = $eCodPerfil,
            tNombre = $tNombre,
            tApellidos = $tApellidos,
            bAll = $bAll,
            tCorreo = $tCorreo,
            eCodEstatus = $eCodEstatus
            WHERE
            eCodUsuario = $eCodUsuario";
        }
}
        //fwrite($pf,$insert."\n\n");
        //fclose($pf);
        $rs = mysqli_query($conexion,$conexion,$insert);

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del usuario';
        }

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>