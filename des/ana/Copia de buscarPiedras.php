




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
   $puntos      = sizeof($data->puntos)         ? $data->puntos         : false;
   $signos      = sizeof($data->signos)         ? $data->signos         : false;
   $horoscopos  = sizeof($data->horoscopos)     ? $data->horoscopos     : false;
   $arcangeles  = sizeof($data->arcangeles)     ? $data->arcangeles     : false;
   $numerologia = sizeof($data->numerologia)    ? $data->numerologia    : false;
   $dosha       = sizeof($data->dosha)          ? $data->dosha          : false;
   $planetas    = sizeof($data->planetas)       ? $data->planetas       : false;
   $chakra      = sizeof($data->chakra)         ? $data->chakra         : false;

    $bBuscar = 1;

    if(!$puntos && !$signos && !$horoscopos && !$arcangeles && !$numerologia && !$dosha && !$planetas && !$chakra)
    {
        $bBuscar = 2;
    }

    $eCodSignoZodiaco = array();
    $eCodHoroscopo = array();
    $eCodArcangel = array();
    $eCodNumerologia = array();
    $eCodDosha = array();
    $eCodPlaneta = array();
    $eCodChakra = array();
    $eCodPuntoEnergetico = array();

    /*alimentamos arreglos*/
    foreach($data->puntos as $dato)
    { $eCodPuntoEnergetico[] = $dato->codigo; }
    foreach($data->signos as $dato)
    { $eCodSignoZodiaco[] = $dato->codigo; }
    foreach($data->horoscopos as $dato)
    { $eCodHoroscopo[] = $dato->codigo; }
    foreach($data->arcangeles as $dato)
    { $eCodArcangel[] = $dato->codigo; }
    foreach($data->numerologia as $dato)
    { $eCodNumerologia[] = $dato->codigo; }
    foreach($data->dosha as $dato)
    { $eCodDosha[] = $dato->codigo; }
    foreach($data->planetas as $dato)
    { $eCodPlaneta[] = $dato->codigo; }
    foreach($data->chakra as $dato)
    { $eCodChakra[] = $dato->codigo; }
    
    $query = array();
        
    if($signos){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasSignoZodiacal rsz ON rsz.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($signos      ? " AND rsz.eCodSignoZodiaco IN (".implode(",",$eCodSignoZodiaco).") " : "");
}
if($horoscopos){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasHoroscopo rph ON rph.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($horoscopos  ? " AND rph.eCodHoroscopo IN (".implode(",",$eCodHoroscopo).") " : "");
}
if($arcangeles){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasArcangeles rpa ON rpa.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($arcangeles  ? " AND rpa.eCodArcangel IN (".implode(",",$eCodArcangel).") " : "");
}
if($numerologia){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasNumerologia rpn ON rpn.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($numerologia ? " AND rpn.eCodNumerologia IN (".implode(",",$eCodNumerologia).") " : "");
}
if($dosha){    
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasDosha rpd ON rpd.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($dosha       ? " AND rpd.eCodDosha IN (".implode(",",$eCodDosha).") " : "");
}
if($planetas){  
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasPlanetas rpp ON rpp.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($planetas    ? " AND rpp.eCodPlaneta IN (".implode(",",$eCodPlaneta).") " : "");
}
if($chakra){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasChakras rpc ON rpc.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($chakra      ? " AND rpc.eCodChakra IN (".implode(",",$eCodChakra).") " : "");
}
if($puntos){
$query[] = " SELECT DISTINCT ".
          " cp.eCodPiedra, cp.tNombre ".
          " FROM ".
          " CatPiedras cp ".
          " LEFT JOIN RelPiedrasPuntosEnergeticos rpe ON rpe.eCodPiedra = cp.eCodPiedra ".
          " WHERE ".
          " 1=$bBuscar ".
          ($puntos      ? " AND rpe.eCodPuntoEnergetico IN (".implode(",",$eCodPuntoEnergetico).") " : "");
}

    $select = implode(" UNION ",$query);
          
          $pf = fopen("log.txt","w");
          fwrite($pf,$select);
          fclose($pf);

    $i = 0;
    $rs = mysqli_query($conexion,$select);

    $tHTML = '<ul>';
    while($r = mysqli_fetch_array($rs))
    {
        $tHTML .= '<li><input type="hidden" id="eCodPiedra'.$i.'" name="piedra['.$i.'][eCodPiedra]" value="'.$r{'eCodPiedra'}.'">'.$r{'tNombre'}.'</li>';
        $i++;    
    }
    $tHTML .= '</ul>';

echo json_encode(
                    array(
                        "exito"=>((!sizeof($errores)) ? 1 : 0), 
                        'errores'=>$errores, 
                        'html'=>$tHTML
                        )
                );

?>