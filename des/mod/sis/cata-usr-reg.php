<?php


session_start();
$bAll = $_SESSION['bAll'];

$select = "SELECT su.* FROM SisUsuarios su WHERE su.eCodUsuario = ".$_GET['v1'];
$rsUsuario = mysqli_query($conexion,$select);
$rUsuario = mysqli_fetch_array($rsUsuario);

?>

<script>
function validar()
    {
        guardar();
    }
</script>
<div class="row">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
        <input type="hidden" name="eCodUsuario" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card">
                                    
                                    <div class="card-body card-block">
                                        <?php
                                        if($_SESSION['sessionAdmin']['bAll'])
                                        {
                                        ?>
                                        <div class="form-group">
                                            <label for="company" class=" form-control-label">Administrador?</label>
                                            <input type="checkbox" name="bAll" <?=($rUsuario{'bAll'} ? "checked" : "")?> value="1">
                                        </div>
                                        <?php
                                        }
                                            ?>
                                        <div class="form-group">
                                            <label for="company" class=" form-control-label">Estatus</label>
                                            <select class="form-control" id="eCodEstatus" name="eCodEstatus">
                                            <option value="">Seleccione...</option>
                                                <?php 
                                                $select = "SELECT * FROM CatEstatus WHERE eCodEstatus IN(1,3,7)"; 
                                                $rsEstatus = mysqli_query($conexion,$select);
                                                while($rEstatus = mysqli_fetch_array($rsEstatus)){ ?>
                                                <option value="<?=$rEstatus{'eCodEstatus'};?>" <?=(($rUsuario{'eCodEstatus'}==$rEstatus{'eCodEstatus'}) ? 'selected' : '')?>><?=$rEstatus{'tNombre'};?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="company" class=" form-control-label">Correo electr&oacute;nico</label>
                                            <input type="text" name="tCorreo" placeholder="Correo electrónico" value="<?=$rUsuario{'tCorreo'}?>" class="form-control"<?=$_GET['eCodUsuario'] ? 'readonly' : ''?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label">Password Acceso</label>
                                            <input type="password" name="tPasswordAcceso" placeholder="Password Acceso" value="<?=base64_decode($rUsuario{'tPasswordAcceso'})?>" class="form-control">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label for="street" class=" form-control-label">Password Operaciones</label>
                                            <input type="password" name="tPasswordOperaciones" placeholder="Password Operaciones" value="<?=base64_decode($rUsuario{'tPasswordOperaciones'})?>" class="form-control">
                                        </div>
                                        
                                                <div class="form-group">
                                                    <label for="city" class=" form-control-label">Nombre(s)</label>
                                                    <input type="text" name="tNombre" placeholder="Nombre(s)" value="<?=utf8_decode($rUsuario{'tNombre'})?>" class="form-control" <?=$_GET['eCodUsuario'] ? 'readonly' : ''?>>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="postal-code" class=" form-control-label">Apellido(s)</label>
                                                    <input type="text" name="tApellidos" placeholder="Apellido(s)" value="<?=utf8_decode($rUsuario{'tApellidos'})?>" class="form-control"<?=$_GET['eCodUsuario'] ? 'readonly' : ''?>>
                                                </div>
                                          
                                        <div class="form-group">
                                            <label for="country" class=" form-control-label">Perfil</label>
											<select id="eCodPerfil" name="eCodPerfil" class="form-control col-md-6">
											<option value="">Seleccione</option>
												<?php
												$select = "SELECT * FROM SisPerfiles".
															($_SESSION['sessionAdmin']['bAll'] ? "" : " WHERE eCodPerfil > 2").
															" ORDER BY eCodPerfil ASC";
												$rsPerfiles = mysqli_query($conexion,$select);
												while($rPerfil = mysqli_fetch_array($rsPerfiles))
												{
													?>
												<option value="<?=$rPerfil{'eCodPerfil'}?>" <?=($rUsuario{'eCodPerfil'}==$rPerfil{'eCodPerfil'}) ? 'selected="selected"': '' ?>><?=$rPerfil{'tNombre'}?></option>
												<?php
												}
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </form>
                        </div>