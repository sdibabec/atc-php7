




<?php






session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodEvento = $data->eCodEvento ? $data->eCodEvento : false;
$eCodCliente = $data->eCodCliente ? $data->eCodCliente : false;
$eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;
$fhFechaInicio = $data->fhFechaConsulta1 ? explode("/",$data->fhFechaConsulta1) : false;
$fhFechaFin = $data->fhFechaConsulta2 ? explode("/",$data->fhFechaConsulta2) : $fhFechaInicio;

$fhFecha1 = $fhFechaInicio[2].'-'.$fhFechaInicio[1].'-'.$fhFechaInicio[0];
$fhFecha2 = $data->fhFechaConsulta2 ? $fhFechaFin[2].'-'.$fhFechaFin[1].'-'.$fhFechaFin[0] : $fhFecha1;

$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodEvento';

switch($accion)
{
    case 'D':
        $insert = "UPDATE BitEventos SET eCodEstatus = 4 WHERE eCodEvento = ".$codigo;
        break;
    case 'F':
        $insert = "UPDATE BitEventos SET eCodEstatus = 8 WHERE eCodEvento = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">Codigo</th>'.
        '<th class="text-right">E</th>'.
        '<th class="text-right">C</th>'.
		'<th class="text-right">Cliente</th>'.
		'<th class="text-right">Fecha Evento (Hora de montaje)</th>'.
		'<th class="text-right">Promotor</th>'.                   
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select = "SELECT * FROM (SELECT 
        be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
        su.tNombre as promotor, ce.tIcono 
        FROM BitEventos be 
        INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
        INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
		LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario".
        " WHERE be.eCodTipoDocumento=1 ".
		($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
        //($bAll ? "" : " AND be.eCodEstatus<>4").
        ($eCodEvento ? " AND be.eCodEvento = $eCodEvento" : "").
        ($eCodCliente ? " AND be.eCodCliente = $eCodCliente" : "").
        ($eCodEstatus ? " AND be.eCodEstatus = $eCodEstatus" : "").
        ($data->fhFechaConsulta1 ? " AND DATE(be.fhFechaEvento) BETWEEN  '$fhFecha1' AND '$fhFecha2'" : "").
        " LIMIT 0, $eLimit ".
		")N0 ORDER BY $rdOrden $bOrden";
		
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
         /* validamos si está cargado */
            $bCargado = (mysqli_num_rows(mysqli_query($conexion,"SELECT * FROM SisRegistrosCargas WHERE eCodEvento = ".$rConsulta{'eCodEvento'}))) ? true : false;
            
            $arrEstados = array();
            $arrEstados[0] = true;
            $arrEstados[1] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[2] = true;
            $arrEstados[3] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[4] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[5] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodEvento'},'cata-eve-con',$arrEstados).'</td>'.
                    '<td align="center"><i class="'.$rConsulta{'tIcono'}.'"></i></td>'.
                    '<td align="center"><i class="fas fa-truck-moving" '.((!$bCargado) ? 'style="display:none;"' : '').'></i></td>'.
			        '<td>'.utf8_decode($rConsulta{'nombreCliente'}.' '.$rConsulta{'apellidosCliente'}).'</td>'.
			        '<td>'.date('d/m/Y H:i', strtotime($rConsulta{'fhFechaEvento'})).'</td>'.
			        '<td>'.utf8_decode($rConsulta{'promotor'}).'</td>'.
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
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el evento código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
    
    
    
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML));

?>