




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
   $puntos = array();

foreach($data->puntos as $punto)
{
    $puntos[] = $punto->codigo;
}

$tHTML = '';
$select = " SELECT * FROM CatPuntosEnergeticos ORDER BY tNombre ASC ";
$rs = mysqli_query($conexion,$select);
$i = 0;
while($r = mysqli_fetch_array($rs))
{
    $eCodPuntoEnergetico = $r{'eCodPuntoEnergetico'};
    $tNombre = $r{'tNombre'};
    $bSeleccionado = ((in_array($eCodPuntoEnergetico, $puntos) || $eCodPuntoEnergetico == $_SESSION['sesionTrabajo'] ) ? 'checked="checked"' : '');
    $tHTML .= '<tr><td><label><input type="checkbox" onclick="analizar();" id="eCodPuntoEnergetico'.((int)$i).'" name="puntos['.((int)$i).'][codigo]" value="'.((int)$eCodPuntoEnergetico).'" '.$bSeleccionado.'> '.($tNombre).'</label></td></tr>';
    
    $i++;
}

$_SESSION['sesionTrabajo'] = false;
    
echo json_encode(
                    array(
                        "exito"=>((!sizeof($errores)) ? 1 : 0), 
                        'errores'=>$errores, 
                        'html'=>$tHTML
                        )
                );

?>