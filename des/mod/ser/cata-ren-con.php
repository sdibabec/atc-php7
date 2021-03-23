<?php





session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodEvento'])
{
    mysqli_query($conexion,"UPDATE BitEventos SET eCodEstatus = ".$_GET['eAccion']." WHERE eCodEvento =".$_GET['eCodEvento']);
    
        $fhFecha = "'".date('Y-m-d H:i:s')."'";
        $tDescripcion = "Se ha ".(($_GET['eAccion']==4) ? 'CANCELADO' : 'FINALIZADO')." el evento ".sprintf("%07d",$_GET['eCodEvento']);
        $tDescripcion = "'".$tDescripcion."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fhFecha, $tDescripcion)");
    
    echo '<script>window.location="?tCodSeccion=cata-eve-con";</script>';
              
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
function detalles(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo;
    }
function cancelar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=4&eCodEvento="+codigo;
    }
function finalizar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=8&eCodEvento="+codigo;
    }
function ruta(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo+"&bRuta=1";
    }
    
$(document).ready(function() {
             filtrar();
    
              //$('#fhFechaConsulta1, #fhFechaConsulta2').datepicker();
    
        $("#fhFechaConsulta1").datepicker({
            dateFormat: "dd/mm/yy",
            changeYear: true,
    onSelect: function(selectedDate) {
        // Set the minDate of 'to' as the selectedDate of 'from'
        $("#fhFechaConsulta2").datepicker("option", "minDate", selectedDate);
    }
});
    
$("#fhFechaConsulta2").datepicker({
    dateFormat: "dd/mm/yy",
    changeYear: true,
    onSelect: function(selectedDate) {
        // Set the minDate of 'to' as the selectedDate of 'from'
        $("#fhFechaConsulta1").datepicker("option", "maxDate", selectedDate);
    }
});
          
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
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodEvento" checked="checked"> C&oacute;digo</label></div>
    <div class="form-group col-md-3">
        <input type="text" class="form-control" name="eCodEvento" id="eCodEvento">
    </div>
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodCliente"> Cliente</label></div>
    <div class="form-group col-md-3">
        <input type="hidden" name="eCodCliente" id="eCodCliente">
        <input type="text" class="form-control" id="tCliente" placeholder="Cliente"  onkeyup="buscarClientes()" onkeypress="buscarClientes()">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="eCodEstatus"> Estatus</label></div>
    <div class="form-group col-md-3">
        <select id="eCodEstatus" name="eCodEstatus" >
        <option value="">Seleccione...</option>
        <? while($rEstatus = mysqli_fetch_array($rsEstatus)) { ?>
            <option value="<?=$rEstatus{'eCodEstatus'};?>"><?=$rEstatus{'tEstatus'};?></option>
        <? } ?>
        </select>
    </div>
    <div class="form-group col-md-3"><label><input type="radio" name="rdOrden" value="fhFechaEvento"> Fecha</label></div>
    <div class="form-group col-md-3">
        <div class="input-group date">
                    <input type="text" class="input-sm form-control" name="fhFechaConsulta1" id="fhFechaConsulta1" value="<?=date('d/m/Y',strtotime("-5 days"));?>">
            <span class="input-group-addon">-</span>
             <input type="text" class="input-sm form-control" name="fhFechaConsulta2" id="fhFechaConsulta2" value="<?=date('d/m/Y',strtotime("+5 days"));?>">
                </div>
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
                                <div class="card card-body table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>