<?php





session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

if($_GET['bEliminar']==1)
{
    $select = "SELECT * FROM BitEventos WHERE eCodCliente = ".$_GET['eCodCliente'];
    $rs = mysqli_query($conexion,$select);
    
    if(mysqli_num_rows($rs)>0)
    {
        $update = "UPDATE CatClientes SET eCodEstatus=7 WHERE eCodCliente = ".$_GET['eCodCliente'];
    }
    else
    {
        $update = "DELETE FROM CatClientes WHERE eCodCliente = ".$_GET['eCodCliente'];
    }
    mysqli_query($conexion,$update);
    echo '<script>window.location="?tCodSeccion='.$_GET['tCodSeccion'].'";</script>';
}

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysqli_query($conexion,$select);
        
$select = "SELECT DISTINCT
	ce.tNombre tEstatus,
	ce.eCodEstatus 
FROM
	CatEstatus ce
	INNER JOIN BitEventos be ON be.eCodEstatus = ce.eCodEstatus
    WHERE 1=1 ".
    ($_SESSION['sessionAdmin']['bAll'] ? "" : " AND eCodEstatus<>4").
" ORDER BY
	ce.tNombre ASC";
$rsEstatus = mysqli_query($conexion,$select);

?>
<script>
function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-cli-det&eCodCliente="+eCodCliente;
    }
function exportar()
    {
        window.location="gene-cli-xls.php";
    }
    
$(document).ready(function() {
             filtrar();
          });
    
</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                <!--filtros-->
                                <div class="col-md-12">
                                    <div id="eRegistros" style="font-size:16px; font-weight:bold;"></div>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div id="divFiltros" style="display:none;" class="card card-body table-responsive">
                                <form id="Datos" name="Datos">
                                    <input type="hidden" name="tAccion" id="tAccion" value="">
                                    <input type="hidden" name="eAccion" id="eAccion" value="">
                                    <input type="hidden" name="eInicio" id="eInicio" value="">
                                    
                                    
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodCliente" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodCliente" id="eCodCliente">
    </div>
    <div class="form-group col-md-3"></div>
    <div class="form-group col-md-3">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="tNombres" checked="checked"> Nombre(s)</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="tNombres" id="tNombres">
    </div>
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="tApellidos" checked="checked"> Apellido(s)</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="tApellidos" id="tApellidos">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3">Mostrar</div>
    <div class="form-group col-md-3">
        <select id="eMaxRegistros" name="eMaxRegistros" >
        <?=$clNav->maximos();?>
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
                                <div class="card card-body table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>