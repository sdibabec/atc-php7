




<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);




date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();



/*Preparacion de variables*/
        
$eCodTipoPieza = $data->eCodTipoPieza ? $data->eCodTipoPieza : false;
if($eCodTipoPieza){
    $select = " SELECT * FROM CatTiposPiezas WHERE eCodTipoPieza = ".$eCodTipoPieza;
    $rs = mysqli_query($conexion,$select);
    $rPieza = mysqli_fetch_array($rs);
}

                    $select =   " SELECT ".
                                " cb.eCodBroche, ".
                                " cb.tNombre ".
                                " FROM ".
                                " CatBrochesPizas cb ".
                                " INNER JOIN RelBrochesPiezas rb ON rb.eCodBroche = cb.eCodBroche ".
                                " AND rb.eCodTipoPieza = ".$rPieza{'eCodTipoPieza'}.
                                " WHERE cb.tCodEstatus = 'AC' ";
                   
                    $rsBroches = mysqli_query($conexion,$select);
                   //print mysqli_error();
                   
          $i = 0;
            $tBroches = '<option value="">Seleccione...</option>';
          while($r = mysqli_fetch_array($rsBroches)){
              $tBroches .= '<option value="'.$r{'eCodBroche'}.'"> '.($r{'tNombre'}).'</option>';
              $i++;
          }

                    $select =   " SELECT ".
                                " cb.eCodMaterial, ".
                                " cb.tNombre ".
                                " FROM ".
                                " CatMaterialesPiezas cb ".
                                " LEFT JOIN RelMaterialesPiezas rb ON rb.eCodMaterial = cb.eCodMaterial ".
                                " AND rb.eCodTipoPieza = ".$rPieza{'eCodTipoPieza'}.
                                " WHERE cb.tCodEstatus = 'AC' ";
                   
                    $rsMateriales = mysqli_query($conexion,$select);
                   //print mysqli_error();
                   
          $i = 0;
            $tMateriales = '<option value="">Seleccione...</option>';
          while($r = mysqli_fetch_array($rsMateriales)){
              $tMateriales .= '<option value="'.$r{'eCodMaterial'}.'"> '.$r{'tNombre'}.'</option>';
              $i++;
          }
    
echo json_encode(
                    array(
                        "exito"=>((!sizeof($errores)) ? 1 : 0), 
                        'errores'=>$errores, 
                        'largo'=>($rPieza{'eLargo'} ? 1 : 0),
                        'color'=>($rPieza{'bColor'} ? 1 : 0),
                        'dijes'=>($rPieza{'bDijes'} ? 1 : 0),
                        'ornamento'=>($rPieza{'bOrnamento'} ? 1 : 0),
                        'materiales'=>$tMateriales,
                        'broches'=>$tBroches
                        )
                );

?>