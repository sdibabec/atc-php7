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
                                    
                                    
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodCamioneta" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodCamioneta" id="eCodCamioneta">
    </div>
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodEstatus"> Estatus</label></div>
    <div class="form-group col-md-3">
        <select id="eCodEstatus" name="eCodEstatus" class="form-control">
        <option value="">Seleccione...</option>
        <? while($rEstatus = mysqli_fetch_array($rsEstatus)) { ?>
            <option value="<?=$rEstatus{'eCodEstatus'};?>"><?=$rEstatus{'tEstatus'};?></option>
        <? } ?>
        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3">Mostrar</div>
    <div class="form-group col-md-3">
        <select id="eMaxRegistros" name="eMaxRegistros"  class="form-control">
        <option value="">Seleccione...</option>
        <?=$clNav->maximos();?>
        </select>
    </div>
    <div class="form-group col-md-3">Orden</div>
    <div class="form-group col-md-3">
        <select id="rOrden" name="rOrden"  class="form-control">
        <option value="DESC">Descendente</option>
        <option value="ASC">Ascendente</option>
        </select>
    </div>
</div>

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