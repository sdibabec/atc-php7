




<?php






session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;


$eCodSubclasificacion = $data->eCodSubclasificacion ? $data->eCodSubclasificacion : false;
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
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodSubclasificacion';

switch($accion)
{
    case 'D':
        $select = "SELECT * FROM BitEventos WHERE eCodSubclasificacion = ".$_GET['eCodSubclasificacion'];
            $rs = mysqli_query($conexion,$select);
            
            if(mysqli_num_rows($rs)>0)
            {
                $insert = "UPDATE CatClientes SET eCodEstatus=7 WHERE eCodSubclasificacion = ".$codigo;
            }
            else
            {
                $insert = "DELETE FROM CatClientes WHERE eCodSubclasificacion = ".$codigo;
            }
        break;
    case 'F':
        $insert = "UPDATE CatClientes SET eCodEstatus = 8 WHERE eCodSubclasificacion = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">Código</th>'.
		'<th>Tipo</th>'.
        '<th>Nombre</th>'.
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select1 = "SELECT * FROM ( ".
            " SELECT 
				cs.eCodSubclasificacion,
                cti.tNombre tTipo,
                cs.tNombre tSubclasificacion
			FROM
				CatSubClasificacionesInventarios cs
                INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario=cs.eCodTipoInventario ".
            " WHERE 1=1 ".
            //($_SESSION['sessionAdmin']['bAll'] ? "" : " AND cc.eCodEstatus<> 7").
            ($eCodSubclasificacion ? " AND cs.eCodSubclasificacion = ".$eCodSubclasificacion : "").
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
        '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodSubclasificacion'},'cata-sbc-con').'</td>'.
		'<td>'.utf8_decode($rConsulta{'tTipo'}).'</td>'.
		'<td>'.utf8_decode($rConsulta{'tSubclasificacion'}).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        
        $tHTML .=   '<tr>'.
                    '<td colspan="3" align="center">';
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