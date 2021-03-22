




<?php







$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

session_start();



$eCodEvento = $data->eCodEvento ? $data->eCodEvento : $_GET['eCodEvento'];



      $select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$eCodEvento;
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);

    $select = "SELECT cc.* FROM CatCamionetas cc INNER JOIN BitEventos be ON be.eCodCamioneta=cc.eCodCamioneta WHERE be.eCodEvento = ".$eCodEvento;
$rCamioneta = mysqli_fetch_array(mysqli_query($conexion,$select));


       $detalle = '<table class="table table-borderless " width="100%">';
        $detalle .= '<tr><td>Veh&iacute;culo; '.(($rCamioneta{'eCodCamioneta'}) ? 'No Asignada - NO CARGAR' : $rCamioneta{'tNombre'}).' <input type="hidden" id="eCodCamioneta" name="eCodCamioneta" value="'.$rCamioneta{'eCodCamioneta'}.'"><br>
        Responsable Entrega: '.($rPublicacion{'tOperadorEntrega'} ? $rPublicacion{'tOperadorEntrega'} : 'Pendiente').'<br>
        Responsable Recolecci&oacute;n: '.($rPublicacion{'tOperadorRecoleccion'} ? $rPublicacion{'tOperadorRecoleccion'} : 'Pendiente').'
        </td></tr>';
      
                            
											
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            cs.eCodServicio,
                                                            rep.dMonto
                                                        FROM CatServicios cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio and rep.eCodTipo = 1
                                                        WHERE rep.eCodEvento = ".$eCodEvento;
											$rsPaquetes = mysqli_query($conexion,$select);
                                            $dTotalEvento = 0;
											while($rPaquete = mysqli_fetch_array($rsPaquetes))
											{
												
											$detalle .='<tr>
                <td>
                    <b>'.$rPaquete{'eCantidad'}.'</b> - '.utf8_decode($rPaquete{'tNombre'}).'<br>';
                    
                        $select = "SELECT 
															cti.tNombre as tipo, 
															ci.*,
															rti.ePiezas as unidad
														FROM
															CatInventario ci
															INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario = ci.eCodTipoInventario
															INNER JOIN RelServiciosInventario rti ON rti.eCodInventario=ci.eCodInventario
															WHERE
                                                             rti.eCodServicio = ".$rPaquete{'eCodServicio'}."
															ORDER BY ci.tNombre ASC";
                                                $rsDetalle = mysqli_query($conexion,$select);
                                                
                                                if(mysqli_num_rows($rsDetalle))
                                                {
                                                    $detalle .= '<ul style="margin-left:15px;">';
                                                    while($rDetalle = mysqli_fetch_array($rsDetalle))
                                                    { 
                                                         $detalle .='<li style="margin-left:15px;"><input type="checkbox" id="eCodInventario'.$i.'" name="inventario['.$i.'][eCodInventario]" value="'.$rDetalle{'eCodInventario'}.'" onclick="validarCarga()"> 
                                                         <input type="hidden" id="inventario['.$i.'][eCantidad]" name="inventario['.$i.'][eCantidad]" value="'.$rDetalle{'unidad'}.'">
                                                         <b>x'.$rDetalle{'unidad'}.'</b> - '.($rDetalle{'tNombre'}).'</li>';
                                                        $i++;
                                                    }
                                                    $detalle .= '</ul>';
                                                }
                                                    $detalle .='</td></tr>';
											
											$i++;
                                                $dTotalEvento = $dTotalEvento + ($rPublicacion{'dMonto'});
											 
                                            }
    
                                            $select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.dMonto,
                                                            cs.eCodInventario
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$eCodEvento;
											$rsInventario = mysqli_query($conexion,$select);
                                            
    if(mysqli_num_rows($rsInventario))
    {
       while($rInventario = mysqli_fetch_array($rsInventario))
											{ 
											$detalle .='<tr>
                                                <td>
                                                    <input type="checkbox" id="eCodInventario'.$i.'" name="inventario['.$i.'][eCodInventario]" value="'.$rInventario{'eCodInventario'}.'" onclick="validarCarga()">
                                                    <input type="hidden" id="inventario['.$i.'][eCantidad]" name="inventario['.$i.'][eCantidad]" value="'.$rInventario{'eCantidad'}.'">
                                                    <b>'.$rInventario{'eCantidad'}.'</b> - '.utf8_decode($rInventario{'tNombre'}).'
                                                </td>
                                            </tr>';
           $i++;
											 }  
    }
											
            
        $detalle .='</table>';
                                                
                                            





echo json_encode(array('detalle'=>$detalle));

?>