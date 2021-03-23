




<?php






session_start();

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodServicio = $data->eCodServicio ? $data->eCodServicio : false;
$eCodInventario = $data->eCodInventario ? $data->eCodInventario : false;

$eInicio = $data->eInicio ? (($data->eInicio * 15)-15) : 0;
$eTermino = ($eInicio>0 ? $eInicio : 1) * 15;

    $terms = explode(" ",$data->tNombre);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND tNombre like '%".$terms[$i]."%' ";
    }


$eLimit = $data->eMaxRegistros ? $data->eMaxRegistros : 250;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodServicio';


switch($accion)
{
    case 'D':
        $select = "SELECT COUNT(*) ePaquetes FROM RelEventosPaquetes WHERE eCodTipo = 1 AND eCodServicio = $codigo";
        $rContador = mysqli_fetch_array(mysqli_query($conexion,$select));
        if($rContador{'ePaquetes'}>=1)
        {
            $errores[] = 'El paquete se encuentra en '.$rContador{'ePaquetes'}.' cotizacion(es). Imposible eliminar';
        }
        else
        {
        $insert = "DELETE FROM CatServicios WHERE eCodServicio = ".$codigo;
        }
        break;
    case 'F':
        $insert = "UPDATE CatServicios SET eCodEstatus = 8 WHERE eCodServicio = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">C&oacute;digo</th>'.
        '<th>Nombre</th>'.
        //'<th>Descripci&oacute;n</th>'.
        '<th>Productos</th>'.
        '<th class="text-right">Precio</th>'.                   
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select1 = "SELECT DISTINCT
        cs.*, (SELECT COUNT(*) FROM RelServiciosInventario WHERE eCodServicio=cs.eCodServicio) eProductos
        FROM
		  CatServicios cs
        LEFT JOIN RelServiciosInventario rs ON rs.eCodServicio=cs.eCodServicio
		 WHERE 1=1 ".
        ($eCodServicio ? " AND cs.eCodServicio = $eCodServicio" : "").
        ($eCodInventario ? " AND rs.eCodInventario = $eCodInventario" : "").
        ($data->tNombre ? $termino : "").
		" LIMIT 0, $eLimit ";
        
        $eFilas = mysqli_num_rows(mysqli_query($conexion,$select1));
        
        $ePaginas = round($eFilas / 15);
        
        $select = "SELECT * FROM ($select1) N0 ORDER BY $rdOrden $bOrden LIMIT $eInicio, $eTermino";
        
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
         /* validamos si est√° cargado */
           
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodServicio'},'cata-ser-con').'</td>'.
			        '<td>'.($rConsulta{'tNombre'}).'</td>'.
			        //'<td>'.substr(base64_decode($rConsulta{'tDescripcion'}),0,50).'</td>'.
			        '<td>'.($rConsulta{'eProductos'}).'</td>'.
                    '<td>'.number_format($rConsulta{'dPrecioVenta'},2).'</td>'.
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
         $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el paquete c®Ædigo ".sprintf("%07d",$codigo);
         $tDescripcion = "'".utf8_encode($tDescripcion)."'";
         $fecha = "'".date('Y-m-d H:i:s')."'";
         $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
         mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
     }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML));

?>