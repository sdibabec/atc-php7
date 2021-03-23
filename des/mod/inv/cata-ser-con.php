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

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysqli_query($conexion,$select);

?>
 
<script>
function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-ser-det&eCodServicio="+eCodCliente;
    }
    
    //autocomplete
    function buscarInventarioConsulta()
        {
            var eCodInventario = document.getElementById('eCodInventario'),
                tInventario = document.getElementById('tInventario');
            
            if(!tInventario.value || tInventario.value=="")
                { eCodInventario.value=""; }
             $( function() {
  
        $( "#tInventario" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-inventario/",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tInventario').val(ui.item.label); // display the selected text
                $('#eCodInventario').val(ui.item.value); // save selected id to input
                return false;
            }
        });

       
        }); 
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
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodServicio" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodServicio" id="eCodServicio">
    </div>
    
</div>
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="tNombre"> Nombre</label></div>
    <div class="form-group col-md-3">
        
        <input type="text" class="form-control" id="tNombre" name="tNombre" placeholder="">
    </div>
    <div class="form-group col-md-3"><label> Inventario</label></div>
    <div class="form-group col-md-3">
        <input type="hidden" name="eCodInventario" id="eCodInventario">
        <input type="text" class="form-control" id="tInventario" placeholder="Inventario" onkeyup="buscarInventarioConsulta()" onkeypress="buscarInventarioConsulta()">
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