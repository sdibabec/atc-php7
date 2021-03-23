




<?php






session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;


$eCodCliente = $data->eCodCliente ? $data->eCodCliente : false;
$eCodTransaccion = $data->eCodTransaccion ? $data->eCodTransaccion : false;
$eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;

$fhFechaInicio = $data->fhFechaConsulta1 ? explode("/",$data->fhFechaConsulta1) : false;
$fhFechaFin = $data->fhFechaConsulta2 ? explode("/",$data->fhFechaConsulta2) : $fhFechaInicio;

$fhFecha1 = $fhFechaInicio[2].'-'.$fhFechaInicio[1].'-'.$fhFechaInicio[0];
$fhFecha2 = $data->fhFechaConsulta2 ? $fhFechaFin[2].'-'.$fhFechaFin[1].'-'.$fhFechaFin[0] : $fhFecha1;

$terms = explode(" ",$data->tNombres);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND cc.tNombres like '%".$terms[$i]."%' ";
    }

$terms2 = explode(" ",$data->tApellidos);
    
    $termino2 = "";
    
    for($i=0;$i<sizeof($terms2);$i++)
    {
        $termino2 .= " AND cc.tApellidos like '%".$terms2[$i]."%' ";
    }

$eInicio = (int)$data->eInicio>0 ? (($data->eInicio * 15)-15) : 0;
//$eTermino = ($eInicio>0 ? $eInicio : 1) + 15;
$eTermino = 15;

$ePagina = $data->eInicio ? $data->eInicio : 1;

$eLimit = $data->eMaxRegistros ? $data->eMaxRegistros : 250;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodCliente';

switch($accion)
{
    case 'D':
        $select = "SELECT * FROM BitEventos WHERE eCodCliente = ".$_GET['eCodCliente'];
            $rs = mysqli_query($conexion,$select);
            
            if(mysqli_num_rows($rs)>0)
            {
                $insert = "UPDATE CatClientes SET eCodEstatus=7 WHERE eCodCliente = ".$codigo;
            }
            else
            {
                $insert = "DELETE FROM CatClientes WHERE eCodCliente = ".$codigo;
            }
        break;
    case 'F':
        $insert = "UPDATE CatClientes SET eCodEstatus = 8 WHERE eCodCliente = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th>Código</th>'.
		'<th>Cotizacion</th>'.
        '<th>Fecha</th>'.
        '<th>Cliente</th>'.
        '<th>Usuario</th>'.
        '<th>Forma de Pago</th>'.
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select1 = "SELECT * FROM ( ".
            " SELECT ".
            " bt.eCodTransaccion,bt.eCodEvento, ".
            " bt.fhFecha, bt.eCodEvento, ".
            " cc.tNombres as nombreCliente, ".
            " cc.tApellidos as apellidosCliente, ".
            " bt.dMonto, ctp.tNombre, (su.tNombre) as nombreUsuario, ".
            " su.tApellidos as apellidosUsuario ".
            " FROM BitTransacciones bt ".
            " INNER JOIN CatTiposPagos ctp ON ctp.eCodTipoPago = bt.eCodTipoPago ".
            " INNER JOIN BitEventos be ON be.eCodEvento = bt.eCodEvento ".
            " INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente ".
            " INNER JOIN SisUsuarios su ON su.eCodUsuario = bt.eCodUsuario ".
            " WHERE 1=1 ".
            //($_SESSION['sessionAdmin']['bAll'] ? "" : " AND cc.eCodEstatus<> 7").
		    ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
		    ($eCodTransaccion ? " AND bt.eCodTransaccion = ".$eCodTransaccion : "").
            ($eCodCliente ? " AND cc.eCodCliente = ".$eCodCliente : "").
            $data->fhFechaConsulta1 ? " AND DATE(bt.fhFecha) BETWEEN  '$fhFecha1' AND '$fhFecha2'" : "").
            //" ORDER BY cc.$rdOrden $bOrden".
            " LIMIT 0, $eLimit ".
		  ")N0 ";
        
        $eFilas = mysqli_num_rows(mysqli_query($conexion,$select1));
        
        $ePaginas = round($eFilas / 15);
        
        $select = "SELECT * FROM ($select1) N0 ORDER BY $rdOrden $bOrden LIMIT $eInicio, $eTermino";
		
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
            //imprimimos
       $tHTML .=    '<tr>'.
        '<td>'.sprintf("%07d",$rConsulta{'eCodTransaccion'}).'</td>'.
        '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodEvento'},'cata-tra-con').'</td>'.
        '<td>'.date('d/m/Y',strtotime($rConsulta{'fhFecha'})).'</td>'.
        '<td>'.utf8_decode($rConsulta{'nombreCliente'} . ' '.$rConsulta{'apellidosCliente'}).'</td>'.
		'<td>'.utf8_decode($rConsulta{'nombreUsuario'}.' '.$rConsulta{'apellidosUsuario'}).'</td>'.
		'<td>'.utf8_decode($rConsulta{'tNombre'}).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        
        $tHTML .=   '<tr>'.
                    '<td colspan="6" align="center">';
        $tHTML .= $clNav->paginas((int)$ePagina,(int)$ePaginas);
        $tHTML .=   '</td>';
        $tHTML .=   '</tr>';
        
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
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el cliente código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)$eFilas,"consulta"=>$tHTML,"select",$select));

?>