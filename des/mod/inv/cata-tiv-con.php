<?php



session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodTipoInventario'])
{
    mysqli_query($conexion,"DELETE FROM CatInventario WHERE eCodTipoInventario =".$_GET['eCodTipoInventario']);
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
        window.location="?tCodSeccion=cata-inv-det&eCodTipoInventario="+eCodCliente;
    }
function eliminar(eCodTipoInventario)
    {
        window.location="?tCodSeccion=cata-inv-con&eCodTipoInventario="+eCodTipoInventario;
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
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodTipoInventario" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodTipoInventario" id="eCodTipoInventario">
    </div>
    
</div>
<div class="form-row">
    <div class="form-group col-md-3">Mostrar</div>
    <div class="form-group col-md-3">
        <select id="eMaxRegistros" name="eMaxRegistros" class="form-control">
        <?=$clNav->maximos();?>
        </select>
    </div>
    <div class="form-group col-md-3">Orden</div>
    <div class="form-group col-md-3">
        <select id="rOrden" name="rOrden" class="form-control">
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