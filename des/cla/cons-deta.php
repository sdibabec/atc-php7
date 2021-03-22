




<?php







$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

session_start();



$eCodEvento = $data->eCodEvento ? $data->eCodEvento : $_GET['eCodEvento'];



      $select = "SELECT be.*, cc.tNombres, cc.tApellidos, cc.tCorreo, cc.tTelefonoFijo, cc.tTelefonoMovil as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$eCodEvento;
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);


       $detalle = '<table class="table table-borderless " width="100%">
            <tr>
                <td>
                                Evento # '.sprintf("%07d",$eCodEvento).'<br>
                                Fecha: '.date('d/m/Y H:i',strtotime($rPublicacion{'fhFechaEvento'})).'<br>
                                Hora de Montaje: '.($rPublicacion{'tmHoraMontaje'}).' <br>
                                Responsable Entrega: '.($rPublicacion{'tOperadorEntrega'} ? $rPublicacion{'tOperadorEntrega'} : 'Pendiente').'<br>
                                Responsable Recolecci&oacute;n: '.($rPublicacion{'tOperadorRecoleccion'} ? $rPublicacion{'tOperadorRecoleccion'} : 'Pendiente').'
                </td>
            </tr>
            <tr>
            <td>
                <table>
                    <thead>
                        <tr>
                            <td colspan="3"><b>Transacciones</b></td>
                        </tr>
                        <tr>
							<th>Fecha</th>
							<th>Monto</th>
							<th>Forma</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
$select = "SELECT bt.eCodTransaccion, bt.eCodTipoPago, bt.eCodEvento, bt.fhFecha, bt.dMonto, ctp.tNombre FROM BitTransacciones bt INNER JOIN CatTiposPagos ctp ON ctp.eCodTipoPago = bt.eCodTipoPago WHERE bt.tCodEstatus = 'AC' AND bt.eCodEvento = ".$eCodEvento;
											$rsTransacciones = mysqli_query($conexion,$select);
											$i = 1;
											while($rTransaccion = mysqli_fetch_array($rsTransacciones))
											{
                                             $detalle .= '<tr>
                                             <td>'.date('d/m/Y',strtotime($rTransaccion{'fhFecha'})).'</td>
												<td>$'.$rTransaccion{'dMonto'}.'</td>
												<td>'.utf8_encode($rTransaccion{'tNombre'}).'</td>
                                             </tr>';   
                                            }

$detalle .= '       </tbody>
                </table>
            </td>
            </tr>
            <tr>
                <td>  ';

$detalle .= $rPublicacion{'tNombres'}.' '.$rPublicacion{'tApellidos'}.' <br>'.$rPublicacion{'tCorreo'}.'<br>Tel.'.$rPublicacion{'tTelefonoFijo'}.'<br>Cel.'.$rPaquete{'tTelefonoMovil'};
                                 
     while($rPaquete = mysqli_fetch_array($rsClientes))
{ 
                  $detalle .=(($rPublicacion{'eCodCliente'}==$rPaquete{'eCodCliente'}) ? $rPaquete{'tNombres'}.' '.$rPaquete{'tApellidos'}.' <br>'.$rPaquete{'tCorreo'}.'<br>Tel.'.$rPaquete{'tTelefonoFijo'}.'<br>Cel.'.$rPaquete{'tTelefonoMovil'} : '');
                  
} 
                            $detalle .='</td>
            </tr>
            <tr>
                            <td>
                               Direcci&oacute;n:  '.nl2br(base64_decode(utf8_decode($rPublicacion{'tDireccion'}))).'
                            </td>
            </tr>
            <tr>
                <td>
                    Descripci&oacute;n
                </td>
            </tr>';
											
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
                                                         $detalle .='<li style="margin-left:15px;"><b>x'.($rPaquete{'eCantidad'}*$rDetalle{'unidad'}).'</b> - '.($rDetalle{'tNombre'}).'</li>';
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
                                                            rep.dMonto
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
                                                    <b>'.$rInventario{'eCantidad'}.'</b> - '.utf8_decode($rInventario{'tNombre'}).'
                                                </td>
                                            </tr>';
											 }  
    }
											
            
        $detalle .='</table>';
                                                
                                            





echo json_encode(array('detalle'=>$detalle));

?>