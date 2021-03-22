




<?php






session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodCamioneta = $data->eCodCamioneta ? $data->eCodCamioneta : false;
$eCodCliente = $data->eCodCliente ? $data->eCodCliente : false;
$eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;
$fhFechaInicio = $data->fhFechaConsulta1 ? explode("/",$data->fhFechaConsulta1) : false;
$fhFechaFin = $data->fhFechaConsulta2 ? explode("/",$data->fhFechaConsulta2) : $fhFechaInicio;

$fhFecha1 = $fhFechaInicio[2].'-'.$fhFechaInicio[1].'-'.$fhFechaInicio[0];
$fhFecha2 = $data->fhFechaConsulta2 ? $fhFechaFin[2].'-'.$fhFechaFin[1].'-'.$fhFechaFin[0] : $fhFecha1;

$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodCamioneta';

switch($accion)
{
    case 'D':
        $insert = "UPDATE BitEventos SET tCodEstatus = 'EL' WHERE eCodCamioneta = ".$codigo;
        break;
    case 'F':
        $insert = "UPDATE BitEventos SET tCodEstatus = 'FI' WHERE eCodCamioneta = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">Codigo</th>'.
        '<th class="text-right">E</th>'.
        '<th class="text-right">Nombre</th>'.
		'</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select = "SELECT * FROM (SELECT cc.*, ce.tIcono estatus FROM CatCamionetas cc INNER JOIN CatEstatus ce ON ce.tCodEstatus=cc.tCodEstatus ORDER BY cc.eCodCamioneta ASC ".
		($eCodCamioneta ? " AND be.eCodCamioneta = $eCodCamioneta" : "").
        ($eCodEstatus ? " AND ce.eCodEstatus = $eCodEstatus" : "").
        " LIMIT 0, $eLimit ".
		")N0 ORDER BY $rdOrden $bOrden";
		
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
         /* validamos si está cargado */
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodCamioneta'},'cata-cam-con',$arrEstados).'</td>'.
                    '<td align="center"><i class="'.$rConsulta{'tIcono'}.'"></i></td>'.
			        '<td>'.utf8_decode($rConsulta{'tNombre'}).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        $tHTML .= '</tbody>'.
            '</table>';
        break;
}
        
if($accion=="D" || $accion=="F")
{
    $rs = mysqli_query($conexion,$insert);

    if(!$rs)
    {
        $errores[] = 'Error al efectuar la operacion '.mysqli_error($conexion);
    }

    if(!sizeof($errores))
    {
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." la renta código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
    
    echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));
    
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML,"select"=>$select));

?>