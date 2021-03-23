<?php





session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['bEliminar']==1)
{
    
        $update = "DELETE FROM CatServicios WHERE eCodServicio = ".$_GET['eCodServicio'];
    
    mysqli_query($conexion,$update);
    echo '<script>window.location="?tCodSeccion='.$_GET['tCodSeccion'].'";</script>';
}

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

?>

<div class="row">
                            <div class="col-lg-12">
                                
                                
                                    <table class="display" id="table" width="100%">
                                        <thead>
                                            
                                            <tr>
												<th class="text-right">C&oacute;digo</th>
												<th>Tipo</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT 
															cs.eCodSubclasificacion,
                                                            cti.tNombre tTipo,
                                                            cs.tNombre tSubclasificacion
														FROM
															CatSubClasificacionesInventarios cs
                                                            INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario=cs.eCodTipoInventario
														ORDER BY cs.tNombre ASC";
											$rsPublicaciones = mysqli_query($conexion,$select);
											while($rPublicacion = mysqli_fetch_array($rsPublicaciones))
											{
                                                
                                                $mostrar = (!$bDelete) ? 'style="display:none;"' : '';
												?>
											<tr>
                                                <td><? menuEmergente($rPublicacion{'eCodSubclasificacion'}); ?></td>
												<td><?=utf8_decode($rPublicacion{'tTipo'})?></td>
												<td><?=utf8_decode($rPublicacion{'tSubclasificacion'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>