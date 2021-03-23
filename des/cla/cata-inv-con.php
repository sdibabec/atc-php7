




<?php






session_start();

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodInventario = $data->eCodInventario ? $data->eCodInventario : false;
$eCodTipoInventario = $data->eCodTipoInventario ? $data->eCodTipoInventario : false;

    $terms = explode(" ",$data->tNombre);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND ci.tNombre like '%".$terms[$i]."%' ";
    }


$eInicio = $data->eInicio ? (($data->eInicio * 10)-10) : 0;
$eTermino = ($eInicio>0 ? $eInicio : 1) * 10;

$eLimit = $data->eMaxRegistros ? $data->eMaxRegistros : 250;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodInventario';


switch($accion)
{
    case 'D':
        $select = "SELECT COUNT(*) eRegistros FROM RelServiciosInventario WHERE eCodInventario = $codigo";
        $rContador = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $select = "SELECT COUNT(*) eRegistros FROM RelEventosPaquetes WHERE eCodTipo = 2 AND eCodServicio = $codigo";
        $rContadorEventos = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        if($rContador{'eRegistros'}>=1 || $rContadorEventos{'eRegistros'}>=1)
        {
            $select = "SELECT DISTINCT eCodServicio FROM RelServiciosInventario WHERE eCodInventario = $codigo";
            $rsPaquetes = mysqli_query($conexion,$select);
            $paquetes = array();
            while($rPaquete = mysqli_fetch_array($rsPaquetes))
            { $paquetes[] = sprintf("%07d",$rPaquete{'eCodServicio'}); }
            
            $errores[] = 'El producto se encuentra en '.$rContador{'eRegistros'}.' paquete(s) y/o en '.$rContadorEventos{'eRegistros'}.' cotizacion(es). Imposible eliminar';
            
            $errores[] = 'El producto se encuentra en el/los paquete(s): '.implode(", ",$paquetes);
        }
        else
        {
        $insert = "DELETE FROM CatInventario WHERE eCodInventario = ".$codigo;
        }
        break;
    case 'F':
        $insert = "UPDATE CatInventario SET eCodEstatus = 8 WHERE eCodInventario = ".$codigo;
        break;
    case 'C':
        $tHTML = '<table class="table table-hover">'.
                 '<thead>'.
                 '    <tr>'.
                 '        <th>C&oacute;digo</th>'.
				 '		  <th>Tipo</th>'.
				 '		  <th>Nombre</th>'.
                 '        <th>Marca</th>'.
                 '        <th>Precio Interno</th>'.
                 '        <th>Precio P&uacute;blico</th>'.
                 '        <th>Existencia</th>'.
                 '        '.
                 '    </tr>'.
                 '</thead>'.
                 '<tbody>';
        $select1 = "	SELECT * FROM (SELECT 
					cti.tNombre as tipo, 
                    csi.tNombre subclasificacion,
					ci.*
					FROM
						CatInventario ci
					INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario = ci.eCodTipoInventario
                    LEFT JOIN CatSubClasificacionesInventarios csi ON csi.eCodSubclasificacion=ci.eCodSubclasificacion ".
					" WHERE 1=1".
                ($eCodInventario ? " AND ci.eCodInventario = $eCodInventario " : "").
                ($eCodTipoInventario ? " AND ci.eCodTipoInventario = $eCodTipoInventario " : "").
                ($data->tNombre ? $termino : "").
                "  LIMIT 0, $eLimit".
				")N0 ";
        
        $eFilas = mysqli_num_rows(mysqli_query($conexion,$select1));
        
        $ePaginas = round($eFilas / 10);
        
        $select = "SELECT * FROM ($select1) N0 ORDER BY $rdOrden $bOrden LIMIT $eInicio, $eTermino";
        
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
         /* validamos si está cargado */
           
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodInventario'},'cata-inv-con').'</td>'.
			        '<td>'.utf8_encode($rConsulta{'tipo'}).'</td>'.
			        '<td>'.utf8_encode($rConsulta{'tNombre'}).'</td>'.
			        '<td>'.utf8_encode($rConsulta{'tMarca'}).'</td>'.
                    '<td>$'.number_format($rConsulta{'dPrecioInterno'},2).'</td>'.
					'<td>$'.number_format($rConsulta{'dPrecioVenta'},2).'</td>'.
					'<td>'.$rConsulta{'ePiezas'}.'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        if($ePaginas>1)
        {
        $tHTML .=   '<tr>'.
                    '<td colspan="4" align="right">';
        $tHTML .= $clNav->paginas($data->eInicio,$ePaginas);
        $tHTML .=   '</td>';
        $tHTML .=   '</tr>';
        }
        $tHTML .= '</tbody>'.
            '</table>';
        break;
}
        
if(!sizeof($errores) && ($accion=="D" || $accion=="F"))
{      
        $rs = mysqli_query($conexion,$insert);

        if(!$rs)
        {
            $errores[] = 'Error al efectuar la operacion '.mysqli_error($conexion);
        }

    if(!sizeof($errores))
    {
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el producto del inventario código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML,"select"=>$select));

?>