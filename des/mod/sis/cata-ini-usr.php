<?php





session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];
?>


<div class="row">
                            <div class="col-lg-12">
                                
                                    <table class="display" id="tblLogs" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <td>#</td>
												<th>Fecha</th>
												<th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$select = "	SELECT sl.*,su.tNombre as Usuario FROM SisUsuariosAccesos sl INNER JOIN SisUsuarios su ON su.eCodUsuario = sl.eCodUsuario ORDER BY sl.eCodRegistro DESC";
											$rsPublicaciones = mysqli_query($conexion,$select);
											while($rPublicacion = mysqli_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td><?=utf8_decode($rPublicacion{'eCodRegistro'})?></td>
                                                <td><?=date('d/m/Y H:i:s',strtotime($rPublicacion{'fhFecha'}))?></td>
                                                <td><?=utf8_decode($rPublicacion{'Usuario'})?></td>
												
                                            </tr>
											<?php
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>