<?php




session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

?>

<div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">Perfiles</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th class="text-right"></th>
                                                <th>Perfil</th>
                                               
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$select = "	SELECT * FROM SisPerfiles";
											$rsPublicaciones = mysqli_query($conexion,$select);
											while($rPublicacion = mysqli_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td><?php $clNav->menuEmergente($rPublicacion{'eCodPerfil'}); ?></td>
                                                <td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?php
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>