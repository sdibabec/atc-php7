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
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT 
															*
														FROM
															CatTiposInventario
														ORDER BY tNombre ASC";
											$rsPublicaciones = mysqli_query($conexion,$select);
											while($rPublicacion = mysqli_fetch_array($rsPublicaciones))
											{
                                                
                                                $mostrar = (!$bDelete) ? 'style="display:none;"' : '';
												?>
											<tr>
                                                <td><? menuEmergente($rPublicacion{'eCodTipoInventario'}); ?></td>
												<td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>