<?php





session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];


$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysqli_query($conexion,$select);

$select = "SELECT * FROM CatClientes WHERE ecodCliente = ".$_SESSION['sessionAdmin']['eCodCliente'];
$rsCliente = mysqli_query($conexion,$select);
$rCliente = mysqli_fetch_array($rsCliente);
        
$select = "SELECT DISTINCT
	ce.tNombre tEstatus,
	ce.tCodEstatus 
FROM
	CatEstatus ce
	INNER JOIN BitPublicaciones be ON be.tCodEstatus = ce.tCodEstatus
    WHERE 1=1 ".
    ($_SESSION['sessionAdmin']['bAll'] ? "" : " AND eCodEstatus<>4").
" ORDER BY
	ce.tNombre ASC";
$rsEstatus = mysqli_query($conexion,$select);

$select = "SELECT * FROM CatTiposPublicaciones WHERE tCodEstatus = 'AC'";
$rsTipos = mysqli_query($conexion,$select);

?>

                            <div class="col-lg-12" style="max-height:60vh; overflow-y:scroll;">
                                
                                <div class="row">
                                
                                <table class="table col-lg-12 table-hover">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Usuario</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <? $select = "SELECT sa.eCodRegistro, sa.fhFecha, su.tNombre FROM SisUsuariosAccesos sa INNER JOIN SisUsuarios su ON su.eCodUsuario=sa.ecodUsuario ORDER BY sa.eCodRegistro DESC LIMIT 0,100 ";
                                      $rs = mysqli_query($conexion,$select);
                                      while($r = mysqli_fetch_array($rs)){ ?>
                                    <tr>
                                      <th scope="row"><?=$r{'eCodRegistro'};?></th>
                                      <td><?=date('d/m/Y H:i',strtotime($r{'eCodRegistro'}));?></td>
                                      <td><?=$r{'tNombre'};?></td>
                                      
                                    </tr>
                                    <? } ?>
                                    
                                  </tbody>
                                </table>
                               
                                
                            </div>
                        </div>