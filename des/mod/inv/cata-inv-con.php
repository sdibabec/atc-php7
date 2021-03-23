<?php



session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodInventario'])
{
    mysqli_query($conexion,"DELETE FROM CatInventario WHERE eCodInventario =".$_GET['eCodInventario']);
    echo '<script>window.location="?tCodSeccion=cata-inv-con";</script>';
}

$select = "SELECT * FROM CatTiposInventario";
$rsTiposInventario = mysqli_query($conexion,$select);

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysqli_query($conexion,$select);

//$bAll = $clSistema->validarPermiso(obtenerScript());
//$bDelete = $clSistema->validarEliminacion(obtenerScript());

?>

<script>

function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-inv-det&eCodInventario="+eCodCliente;
    }
function eliminar(eCodInventario)
    {
        window.location="?tCodSeccion=cata-inv-con&eCodInventario="+eCodInventario;
    }
    
$(document).ready(function() {
             filtrar();
    
});
    
</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                     <!--filtros-->
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left" id="eRegistros" style="font-size:16px; font-weight:bold;"></div>
                                    
                                </div>
                                
                                <div id="divFiltros" style="display:none;" class="card card-body table-responsive">
                                <form id="Datos" name="Datos">
                                    <input type="hidden" name="tAccion" id="tAccion" value="">
                                    <input type="hidden" name="eAccion" id="eAccion" value="">
                                    <input type="hidden" name="eInicio" id="eInicio" value="">
                                    
                                    
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodInventario" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodInventario" id="eCodInventario">
    </div>
    <td colspan="2">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="tNombre"> Nombre</label></div>
    <div class="form-group col-md-3">
        
        <input type="text" class="form-control" id="tNombre" name="tNombre" placeholder="">
    </div>
    <div class="form-group col-md-3"><label> Tipo Inventario</label></div>
    <div class="form-group col-md-3">
        <select id="eCodTipoInventario" name="eCodTipoInventario">
        <option value="">Seleccione...</option>
            <? while($rTipoInventario = mysqli_fetch_array($rsTiposInventario)){ ?>
            <option value="<?=$rTipoInventario{'eCodTipoInventario'};?>"><?=utf8_encode($rTipoInventario{'tNombre'});?></option>
            <? } ?>
        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3">Mostrar</div>
    <div class="form-group col-md-3">
        <select id="eMaxRegistros" name="eMaxRegistros" >
        <option value="">Seleccione...</option>
        <? while($rRegistro = mysqli_fetch_array($rsMaximos)) { ?>
            <option value="<?=$rRegistro{'eRegistros'};?>"><?=$rRegistro{'eRegistros'};?> registros</option>
        <? } ?>
        </select>
    </div>
    <div class="form-group col-md-3">Orden</div>
    <div class="form-group col-md-3">
        <select id="rOrden" name="rOrden" >
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
                                <div class="table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>