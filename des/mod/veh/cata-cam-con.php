<?php





session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];
$select = " SELECT DISTINCT eCodEstatus,tNombre tEstatus FROM CatEstatus WHERE tCodEstatus IN (SELECT DISTINCT tCodEstatus FROM CatCamionetas)";
$rsEstatus = mysqli_query($conexion,$select);

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysqli_query($conexion,$select);

?>
<script>
    $(document).ready(function() {
             filtrar();
          });
</script>                       
<div class="col-lg-12">
                            <div class="row">
                                
                                
                                <!--filtros-->
                                <div class="col-md-12">
                                    <div id="eRegistros" style="font-size:16px; font-weight:bold;"></div>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div id="divFiltros" style="display:none;" class="card card-body table-responsive">
                                <form id="Datos" name="Datos">
                                    <input type="hidden" name="tAccion" id="tAccion" value="">
                                    <input type="hidden" name="eAccion" id="eAccion" value="">
                                    <table width="100%" cellpadding="10" class="table">
                                    <tr hidden>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                    </tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="eCodCamioneta" checked="checked"> C&oacute;digo</label></td>
    <td>
        <input type="text" class="form-control" name="eCodCamioneta" id="eCodCamioneta">
    </td>
    <td><label><input type="radio" name="rdOrden" value="eCodEstatus"> Estatus</label></td>
    <td>
        <select id="eCodEstatus" name="eCodEstatus" class="form-control">
        <option value="">Seleccione...</option>
        <? while($rEstatus = mysqli_fetch_array($rsEstatus)) { ?>
            <option value="<?=$rEstatus{'eCodEstatus'};?>"><?=$rEstatus{'tEstatus'};?></option>
        <? } ?>
        </select>
    </td>
</tr>
<tr>
    <td>Mostrar</td>
    <td>
        <select id="eMaxRegistros" name="eMaxRegistros"  class="form-control">
        <? while($rRegistro = mysqli_fetch_array($rsMaximos)) { ?>
            <option value="<?=$rRegistro{'eRegistros'};?>"><?=$rRegistro{'eRegistros'};?> registros</option>
        <? } ?>
        </select>
    </td>
    <td>Orden</td>
    <td>
        <select id="rOrden" name="rOrden"  class="form-control">
        <option value="DESC">Descendente</option>
        <option value="ASC">Ascendente</option>
        </select>
    </td>
</tr>
</table>
                                    </form>
                                </div>
                                
                                <div class="clearfix" style="padding:10px;"><img src="/images/separador.jpg" class="img-responsive" style="width:100%;"></div>
                                <!--filtros-->
                                
                                <!--tabla-->
                                <div class="card card-body table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>