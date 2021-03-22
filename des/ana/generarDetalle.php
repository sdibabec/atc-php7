




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

    /*if(!$puntos && !$signos && !$horoscopos && !$arcangeles && !$numerologia && !$dosha && !$planetas && !$chakra)
    {
        $bBuscar = 2;
    }*/

    
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
    
    $tHTML = '<ul>';
    foreach($data->piedra as $piedra)
    {
      $eCodPiedra = $piedra->eCodPiedra;  
    $query = array();
      
    if($data->eCodSignoZodiacalAscendente){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatSignosZodiaco cp ".
                    " INNER JOIN RelPiedrasSignoZodiacal rsz ON rsz.eCodSignoZodiaco = cp.eCodSignoZodiaco ".
                    " WHERE ".
                    " 1=1 ".
                    " AND rsz.eCodPiedra IN (".$eCodPiedra.") ".
                    ($data->eCodSignoZodiacalAscendente      ? " AND rsz.eCodSignoZodiaco IN (".$data->eCodSignoZodiacalAscendente.") " : "");
}    
    if($data->eCodSignoZodiacal){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatSignosZodiaco cp ".
                    " INNER JOIN RelPiedrasSignoZodiacal rsz ON rsz.eCodSignoZodiaco = cp.eCodSignoZodiaco ".
                    " WHERE ".
                    " 1=1 ".
                    " AND rsz.eCodPiedra IN (".$eCodPiedra.") ".
                    ($data->eCodSignoZodiacal      ? " AND rsz.eCodSignoZodiaco IN (".$data->eCodSignoZodiacal.") " : "");
}
    if($data->eCodHoroscopo){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatHoroscopoChino cp ".
                    " INNER JOIN RelPiedrasHoroscopo rph ON rph.eCodHoroscopo = cp.eCodHoroscopo ".
                    " WHERE ".
                    " 1=1 ".
                    " AND rph.eCodPiedra IN (".$eCodPiedra.") ".
                    ($data->eCodHoroscopo  ? " AND rph.eCodHoroscopo IN (".$data->eCodHoroscopo.") " : "");
    }
        
    if($signos){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatSignosZodiaco cp ".
                    " INNER JOIN RelPiedrasSignoZodiacal rsz ON rsz.eCodSignoZodiaco = cp.eCodSignoZodiaco ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rsz.eCodPiedra IN (".$eCodPiedra.") ".
                    ($signos      ? " AND rsz.eCodSignoZodiaco IN (".implode(",",$eCodSignoZodiaco).") " : "");
}
    if($horoscopos){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatHoroscopoChino cp ".
                    " INNER JOIN RelPiedrasHoroscopo rph ON rph.eCodHoroscopo = cp.eCodHoroscopo ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rph.eCodPiedra IN (".$eCodPiedra.") ".
                    ($horoscopos  ? " AND rph.eCodHoroscopo IN (".implode(",",$eCodHoroscopo).") " : "");
    }
    if($arcangeles){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatArcangeles cp ".
                    " INNER JOIN RelPiedrasArcangeles rpa ON rpa.eCodArcangel = cp.eCodArcangel ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpa.eCodPiedra IN (".$eCodPiedra.") ".
                    ($arcangeles  ? " AND rpa.eCodArcangel IN (".implode(",",$eCodArcangel).") " : "");
    }
    if($numerologia){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatNumerologia cp ".
                    " INNER JOIN RelPiedrasNumerologia rpn ON rpn.eCodNumerologia = cp.eCodNumerologia ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpn.eCodPiedra IN (".$eCodPiedra.") ".
                    ($numerologia ? " AND rpn.eCodNumerologia IN (".implode(",",$eCodNumerologia).") " : "");
    }
    if($dosha){    
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatDosha cp ".
                    " INNER JOIN RelPiedrasDosha rpd ON rpd.eCodDosha = cp.eCodDosha ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpd.eCodPiedra IN (".$eCodPiedra.") ".
                    ($dosha       ? " AND rpd.eCodDosha IN (".implode(",",$eCodDosha).") " : "");
    }
    if($planetas){  
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatPlanetas cp ".
                    " INNER JOIN RelPiedrasPlanetas rpp ON rpp.eCodPlaneta = cp.eCodPlaneta ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpp.eCodPiedra IN (".$eCodPiedra.") ".
                    ($planetas    ? " AND rpp.eCodPlaneta IN (".implode(",",$eCodPlaneta).") " : "");
    }
    if($chakra){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatChakra cp ".
                    " INNER JOIN RelPiedrasChakras rpc ON rpc.eCodChakra = cp.eCodChakra ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpc.eCodPiedra IN (".$eCodPiedra.") ".
                    ($chakra      ? " AND rpc.eCodChakra IN (".implode(",",$eCodChakra).") " : "");
    }
    if($puntos){
        $query[] =  " SELECT DISTINCT ".
                    " cp.tNombre ".
                    " FROM ".
                    " CatPuntosEnergeticos cp ".
                    " INNER JOIN RelPiedrasPuntosEnergeticos rpe ON rpe.eCodPuntoEnergetico = cp.eCodPuntoEnergetico ".
                    " WHERE ".
                    " 1=$bBuscar ".
                    " AND rpe.eCodPiedra IN (".$eCodPiedra.") ".
                    ($puntos      ? " AND rpe.eCodPuntoEnergetico IN (".implode(",",$eCodPuntoEnergetico).") " : "");
    }

    $queries = $select = implode(" UNION ",$query);
    

    $i = 0;
    $rs = mysqli_query($conexion,$select);
        $queries = $select;
    $resultado = array();
        while($r = mysqli_fetch_array($rs))
        {
            $resultado[] = ucfirst($r{'tNombre'});
        }
        
    $select = "SELECT * FROM CatPiedras WHERE eCodPiedra = ".$eCodPiedra;
        $r = mysqli_fetch_array(mysqli_query($conexion,$select));
        
    $tHTML .= '<li>';
    $tHTML .= '<p align="justify">';
    $tHTML .= '<b>'.ucfirst($r{'tNombre'}).'</b><br>';
    $tHTML .= '<i>'.(sizeof($resultado) ? '('.implode(",",$resultado).')' : '').'</i><br>';
    $tHTML .= $r{'tDescripcion'};
    $tHTML .= '</p>';
    $tHTML .= '</li>';
    
    }

    $tHTML .= '</ul>';

echo json_encode(
                    array(
                        "exito"=>((!sizeof($errores)) ? 1 : 0), 
                        'errores'=>$errores, 
                        'html'=>$tHTML,
                        'query'=>$queries
                        )
                );

?>