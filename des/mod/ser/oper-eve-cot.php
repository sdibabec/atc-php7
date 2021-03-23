<?php







session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$select = "SELECT be.*, cc.tNombres, cc.tApellidos, cc.bLibre, cc.bFrecuente FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEstatus IN (1,2) AND be.eCodEvento = ".$_GET['v1'];
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);



$horas = array();

$horas[] = array('00:00','00:00 - 05:00');
$horas[] = array('00:30','00:30 - 05:30');
$horas[] = array('01:00','01:00 - 06:00');
$horas[] = array('01:30','01:30 - 06:30');
$horas[] = array('02:00','02:00 - 07:00');
$horas[] = array('02:30','02:30 - 07:30');
$horas[] = array('03:00','03:00 - 08:00');
$horas[] = array('03:30','03:30 - 08:30');
$horas[] = array('04:00','04:00 - 09:00');
$horas[] = array('04:30','04:30 - 09:30');
$horas[] = array('05:00','05:00 - 10:00');
$horas[] = array('05:30','05:30 - 10:30');
$horas[] = array('06:00','06:00 - 11:00');
$horas[] = array('06:30','06:30 - 11:30');
$horas[] = array('07:00','07:00 - 12:00');
$horas[] = array('07:30','07:30 - 12:30');
$horas[] = array('08:00','08:00 - 13:00');
$horas[] = array('08:30','08:30 - 13:30');
$horas[] = array('09:00','09:00 - 14:00');
$horas[] = array('09:30','09:30 - 14:30');
$horas[] = array('10:00','10:00 - 15:00');
$horas[] = array('10:30','10:30 - 15:30');
$horas[] = array('11:00','11:00 - 16:00');
$horas[] = array('11:30','11:30 - 16:30');
$horas[] = array('12:00','12:00 - 17:00');
$horas[] = array('12:30','12:30 - 17:30');
$horas[] = array('13:00','13:00 - 18:00');
$horas[] = array('13:30','13:30 - 18:30');
$horas[] = array('14:00','14:00 - 19:00');
$horas[] = array('14:30','14:30 - 19:30');
$horas[] = array('15:00','15:00 - 20:00');
$horas[] = array('15:30','15:30 - 20:30');
$horas[] = array('16:00','16:00 - 21:00');
$horas[] = array('16:30','16:30 - 21:30');
$horas[] = array('17:00','17:00 - 22:00');
$horas[] = array('17:30','17:30 - 22:30');
$horas[] = array('18:00','18:00 - 23:00');
$horas[] = array('18:30','18:30 - 23:30');
$horas[] = array('19:00','19:00 - 00:00');
$horas[] = array('19:30','19:30 - 00:30');
$horas[] = array('20:00','20:00 - 01:00');
$horas[] = array('20:30','20:30 - 01:30');
$horas[] = array('21:00','21:00 - 02:00');
$horas[] = array('21:30','21:30 - 02:30');
$horas[] = array('22:00','22:00 - 03:00');
$horas[] = array('22:30','22:30 - 03:30');
$horas[] = array('23:00','23:00 - 04:00');
$horas[] = array('23:30','23:30 - 04:30');

?>

<div class="col-lg-12">
               <div class="row">

    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" class="col-lg-12">
        <input type="hidden" name="eCodEvento" id="eCodEvento" value="<?=$_GET['v1']?>">
        <input type="hidden" name="nvaFecha" id="nvaFecha">
        <input type="hidden" name="eCodTipoDocumento" value="1">
        <input type="hidden" name="eAccion" id="eAccion">
        
        <input type="hidden" name="eCodPaquete" id="eCodPaquete">
        <!--tabs-->
        <ul class="nav nav-tabs md-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-content-0"role="tab">Datos Principales</a>
                <div class="slide"></div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-content-1" role="tab">Art&iacute;culos</a>
                <div class="slide"></div>
            </li>
        </ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab-content-0" role="tabpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Datos Principales</h5>
                        <!--campos-->
                        <div class="position-relative form-group">
              <label> Cliente</label> 
               <input type="hidden" name="eCodCliente" id="eCodCliente" value="<?=$rPublicacion{'eCodCliente'};?>"> 
               <input type="hidden" name="bLibre" id="bLibre" value="<?=($rPublicacion{'bLibre'} ? 1 : 2);?>"> 
               <input type="hidden" name="bFrecuente" id="bFrecuente" value="<?=($rPublicacion{'bFrecuente'} ? 1 : '');?>"> 
               <input type="text" class="form-control" id="tCliente" <?=(($_GET['v1']) ? 'readonly="readonly"' : '' )?> value="<?=(($rPublicacion{'eCodCliente'}) ? $rPublicacion{'tNombres'} . ' '.$rPublicacion{'tApellidos'} : '');?>" placeholder="Cliente" onkeyup="buscarClientes()" onkeypress="buscarClientes()"> 
               <small>Buscar y seleccionar el cliente de la lista</small>
               </div>
           
           <div class="position-relative form-group">
              <label>I.V.A ?<input type="checkbox" class="form-control" name="bIVA" id="bIVA" value="1" <?=$rPublicacion{'bIVA'} ? "checked" : ""?> onclick="calcular();"></label>
           </div>
           <div class="position-relative form-group">
              <label>Expr&eacute;s ?<input type="checkbox" class="form-control" name="bExpress" id="bExpress" value="1" <?=$rPublicacion{'bExpress'} ? "checked" : ""?>></label>
           </div>
           <div class="position-relative form-group" style="display:none;">
              <label>Incluir Hora Extra ?<input type="checkbox" class="form-control" name="bHoraExtra" id="bHoraExtra" value="1" <?=$rPublicacion{'bHoraExtra'} ? "checked" : ""?>></label>
           </div>
            
           <div class="position-relative form-group">    
              <label>Fecha del Evento</label>
              <input type="text" class="form-control" name="fhFechaEvento" id="fhFechaEvento" value="<?=$rPublicacion{'fhFechaEvento'} ? date('d/m/Y',strtotime($rPublicacion{'fhFechaEvento'})) : ""?>" >
           
                                        </div>
              <div class="position-relative form-group">
              <label>Hora de Servicio</label>
               <select id="tmHoraServicio" name="tmHoraServicio" class="form-control">
               <option value="">Seleccione...</option>
                    <? for($i=0;$i<sizeof($horas);$i++) { ?>
                    <option value="<?=$horas[$i][0]?>" <?=(($rPublicacion{'fhFechaEvento'} && ($horas[$i][0]==date('H:i',strtotime($rPublicacion{'fhFechaEvento'})))) ? 'selected="selected"' : '')?>><?=$horas[$i][1]?></option>
                    <? } ?>
               </select>
           </div>
                                        
           <div class="position-relative form-group">
              <label>Direcci&oacute;n</label>
              <textarea class="form-control" rows="5" style="resize:none;" name="tDireccion" id="tDireccion" maxlength="250"><?=base64_decode(utf8_decode($rPublicacion{'tDireccion'}))?></textarea>
           </div>
           <div class="position-relative form-group">
              <label>Observaciones</label>
              <textarea class="form-control" rows="5" style="resize:none;" name="tObservaciones" id="tObservaciones"><?=base64_decode(utf8_decode($rPublicacion{'tObservaciones'}))?></textarea>
           </div>
                        <!--campos-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tab-content-1" role="tabpanel">
        <div class="row">
            <div class="col-md-8">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Paquetes</h5>
                        <div class="table-responsive">
                            <table class="table table-hover" id="paquetes" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>O.T.</th>
												<th width="60%">Paquete</th>
                                                <th width="10%">Cantidad</th>
                                                <th width="15%">H.Extra</th>
                                                <th width="5%">Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.eCodTipo,
                                                            rep.dMonto,
                                                            rep.bSuma,
                                                            cs.dHoraExtra,
                                                            rep.eHorasExtra
                                                        FROM CatServicios cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio AND rep.eCodTipo = 1
                                                        WHERE rep.eCodEvento = ".$_GET['v1'];
											$rsProductos = mysqli_query($conexion,$select);
                                            
											while($rProducto = mysqli_fetch_array($rsProductos))
											{
												?>
											<tr id="paq<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('paq<?=$i?>','paquetes')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="paquete<?=$i;?>-bSuma" name="paquete[<?=$i;?>][bSuma]" value="1" <?=(($rProducto{'bSuma'}==1) ? 'checked' : '')?> onclick="calcular();">
                                                    
                                                    <i class="fas fa-info-circle" onclick="asignarPaquete(<?=$i;?>)"></i>
                                                    
                                                </td>
                                                <td><input type="text" name="tPaquete<?=$i?>" id="tPaquete<?=$i;?>" class="form-control" onkeypress="agregarPaquete(<?=$i;?>)" onkeyup="agregarPaquete(<?=$i;?>)" value="<?=$rProducto{'tNombre'}?>" onblur="validarPaquete(<?=$i;?>)"></td>
                                                <td>
                                                <input type="hidden" name="paquete[<?=$i;?>][eCodServicio]" id="paquete<?=$i;?>-eCodServicio" value="<?=$rProducto{'eCodServicio'}?>">
                                                <input type="hidden" name="paquete[<?=$i;?>][dImporte]" id="paquete<?=$i;?>-dImporte" value="<?=$rProducto{'dPrecioVenta'}?>">
                                                <input type="text" name="paquete[<?=$i;?>][ePiezas]" id="paquete<?=$i;?>-ePiezas" value="<?=$rProducto{'eCantidad'}?>" class="form-control" onblur="validarPaquete(<?=$i;?>)">
                                                <input type="hidden" name="paquete[<?=$i;?>][eMaxPiezas]" id="paquete<?=$i;?>-eMaxPiezas" value="<?=calcularPaquete($rProducto{'eCodServicio'},$rPublicacion{'fhFechaEvento'});?>" onkeyup="validarPiezas('paquete<?=$i;?>');">
                                                <input type="hidden" name="paquete[<?=$i;?>][dHoraExtra]" id="paquete<?=$i;?>-dHoraExtra" value="<?=($rProducto{'dHoraExtra'});?>">
                                                </td>
                                                <td>
                                                <input type="text" class="form-control"  onkeyup="calcularTotalPaquete('<?=$i;?>'); calcular();" onblur="calcularTotalPaquete(<?=$i;?>); calcular();" name="paquete[<?=$i;?>][eHorasExtra]" id="paquete<?=$i;?>-eHorasExtra" value="<?=($rProducto{'eHorasExtra'});?>" >
                                                </td>
                                                <td>
                                                <input type="text" name="paquete[<?=$i;?>][dMonto]" id="paquete<?=$i;?>-dMonto" value="<?=number_format($rProducto{'dMonto'},2)?>" readonly >
                                                </td>
                                            </tr>
											<?
											$i++;
											}
                                            ?>
                                            <tr id="paq<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('paq<?=$i?>','paquetes')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="paquete<?=$i;?>-bSuma" name="paquete[<?=$i;?>][bSuma]" value="1" <?=(($rProducto{'bSuma'}==1) ? 'checked' : '')?> onclick="calcular();">
                                                    
                                                    <i class="fas fa-info-circle" onclick="asignarPaquete(<?=$i;?>)"></i>
                                                    
                                                </td>
                                                <td><input type="text" name="tPaquete<?=$i?>" id="tPaquete<?=$i;?>" class="form-control" onkeypress="agregarPaquete(<?=$i;?>)" onkeyup="agregarPaquete(<?=$i;?>)" value="<?=$rProducto{'tNombre'}?>" onblur="validarPaquete(<?=$i;?>)"></td>
                                                <td>
                                                <input type="hidden" name="paquete[<?=$i;?>][eCodServicio]" id="paquete<?=$i;?>-eCodServicio" value="<?=$rProducto{'eCodServicio'}?>">
                                                <input type="hidden" name="paquete[<?=$i;?>][dImporte]" id="paquete<?=$i;?>-dImporte" value="<?=$rProducto{'dPrecioVenta'}?>">
                                                <input type="text" name="paquete[<?=$i;?>][ePiezas]" id="paquete<?=$i;?>-ePiezas" value="<?=$rProducto{'eCantidad'}?>" class="form-control" onblur="validarPaquete(<?=$i;?>)" onkeyup="validarPiezas('paquete<?=$i;?>');">
                                                <input type="hidden" name="paquete[<?=$i;?>][eMaxPiezas]" id="paquete<?=$i;?>-eMaxPiezas" value="<?=calcularPaquete($rProducto{'eCodServicio'},$rPublicacion{'fhFechaEvento'});?>">
                                                <input type="hidden" name="paquete[<?=$i;?>][dHoraExtra]" id="paquete<?=$i;?>-dHoraExtra" value="">
                                                </td>
                                                <td>
                                                <input type="text" class="form-control"  onkeyup="calcularTotalPaquete('<?=$i;?>'); calcular();" onblur="calcularTotalPaquete(<?=$i;?>); calcular();" name="paquete[<?=$i;?>][eHorasExtra]" id="paquete<?=$i;?>-eHorasExtra" >
                                                </td>
                                                <td>
                                                <input type="text" name="paquete[<?=$i;?>][dMonto]" id="paquete<?=$i;?>-dMonto" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                        
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Inventario</h5>
                        <div class="table-responsive">
                             <table class="table table-hover" id="invs" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>O.T.</th>
												<th width="70%">Producto</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="5%">Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.eCodTipo,
                                                            rep.dMonto,
                                                            rep.bSuma
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$_GET['v1'];
											$rsProductos = mysqli_query($conexion,$select);
                                            
											while($rProducto = mysqli_fetch_array($rsProductos))
											{
												?>
											<tr id="inv<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('inv<?=$i?>','invs')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="inventario<?=$i;?>-bSuma" name="inventario[<?=$i;?>][bSuma]" value="1" <?=(($rProducto{'bSuma'}==1) ? 'checked' : '')?> onclick="calcular();">
                                                </td>
                                                <td><input type="text" name="tInventario<?=$i?>" id="tInventario<?=$i;?>" class="form-control" onkeypress="agregarInventario(<?=$i;?>)" onkeyup="agregarInventario(<?=$i;?>)" value="<?=$rProducto{'tNombre'}?>" onblur="validarInventario(<?=$i;?>)"></td>
                                                <td>
                                                <input type="hidden" name="inventario[<?=$i;?>][eCodInventario]" id="inventario<?=$i;?>-eCodInventario" value="<?=$rProducto{'eCodServicio'}?>">
                                                <input type="hidden" name="inventario[<?=$i;?>][dImporte]" id="inventario<?=$i;?>-dImporte" value="<?=$rProducto{'dPrecioVenta'}?>">
                                                <input type="text" name="inventario[<?=$i;?>][ePiezas]" id="inventario<?=$i;?>-ePiezas" value="<?=$rProducto{'eCantidad'}?>" class="form-control">
                                                <input type="hidden" name="inventario[<?=$i;?>][eMaxPiezas]" id="inventario<?=$i;?>-eMaxPiezas" value="<?=calcularInventario($rProducto{'eCodServicio'},$rPublicacion{'fhFechaEvento'});?>" onblur="validarInventario(<?=$i;?>)" onkeyup="validarPiezas('inventario<?=$i;?>');">
                                                </td>
                                                <td>
                                                <input type="text" name="inventario[<?=$i;?>][dMonto]" id="inventario<?=$i;?>-dMonto" value="<?=number_format($rProducto{'dMonto'},2)?>" readonly>
                                                </td>
                                            </tr>
											<?
											$i++;
											}
                                            ?>
                                            <tr id="inv<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('inv<?=$i?>','invs')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="inventario<?=$i;?>-bSuma" name="inventario[<?=$i;?>][bSuma]" value="1" onclick="calcular();">
                                                </td>
                                                <td><input type="text" name="tInventario<?=$i?>" id="tInventario<?=$i;?>" class="form-control" onkeypress="agregarInventario(<?=$i;?>)" onkeyup="agregarInventario(<?=$i;?>)" onblur="validarInventario(<?=$i;?>)"></td>
                                                <td>
                                                <input type="hidden" name="inventario[<?=$i;?>][eCodInventario]" id="inventario<?=$i;?>-eCodInventario">
                                                <input type="hidden" name="inventario[<?=$i;?>][dImporte]" id="inventario<?=$i;?>-dImporte">
                                                <input type="text" name="inventario[<?=$i;?>][ePiezas]" id="inventario<?=$i;?>-ePiezas" class="form-control" onblur="validarInventario(<?=$i;?>)" onkeyup="validarPiezas('inventario<?=$i;?>');">
                                                <input type="hidden" name="inventario[<?=$i;?>][eMaxPiezas]" id="inventario<?=$i;?>-eMaxPiezas">
                                                </td>
                                                <td>
                                                <input type="text" name="inventario[<?=$i;?>][dMonto]" id="inventario<?=$i;?>-dMonto" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                               
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Extras</h5>
                        <div class="table-responsive">
                            <table class="table table-hover" id="extras" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>O.T.</th>
												<th width="88%">Extra</th>
                                                <th width="5%">Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
                                            $i = 0;
											$select = "	SELECT *
                                                        FROM RelEventosExtras
                                                        WHERE eCodEvento = ".$_GET['v1'];
											$rsPublicaciones = mysqli_query($conexion,$select);
                                            
											while($rPublicacion = mysqli_fetch_array($rsPublicaciones))
											{
												?>
											<tr id="ext<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('ext<?=$i?>')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="extra<?=$i;?>-bSuma" name="extra[<?=$i;?>][bSuma]" value="1" <?=(($rPublicacion{'bSuma'}==1) ? 'checked' : '')?> onclick="calcular();">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="extra<?=$i;?>-tDescripcion" name="extra[<?=$i;?>][tDescripcion]" value="<?=$rPublicacion{'tDescripcion'}?>" onchange="validarExtra(<?=$i;?>)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="extra<?=$i;?>-dImporte" name="extra[<?=$i;?>][dImporte]" value="<?=$rPublicacion{'dImporte'}?>" onchange="validarExtra(<?=$i;?>)">
                                                </td>
                                            </tr>
											<?
											$i++;
											} ?>
                                            <tr id="ext<?=$i?>">
                                                <td><i class="far fa-trash-alt" onclick="deleteRow('ext<?=$i?>')"></i></td>
                                                <td>
                                                    <input type="checkbox" id="extra<?=$i;?>-bSuma" name="extra[<?=$i;?>][bSuma]" value="1" onclick="calcular();">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="extra<?=$i;?>-tDescripcion" name="extra[<?=$i;?>][tDescripcion]" value="<?=$rPublicacion{'tNombre'}?>" onchange="validarExtra(<?=$i;?>)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="extra<?=$i;?>-dImporte" name="extra[<?=$i;?>][dImporte]" value="<?=$rPublicacion{'dImporte'}?>" onchange="validarExtra(<?=$i;?>)">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Totales</h5>
                        <div>
                            <table class="table table-borderless ">
                                        <thead>
                                            <tr>
                                                
                                                <td align="left" width="85%">
                                                    
                                                    <input type="hidden" id="totEvento" value="0">
                                                </td>
                                                <td id="totalVenta" align="left">
                                                    
                                                </td>
                                            </tr>
                                            <tr id="brIVA" hidden>
                                                
                                                <td align="left" width="85%">
                                                    
                                                    
                                                </td>
                                                <td id="totalIVA" align="left">
                                                    
                                                </td>
                                            </tr>
                                            <tr id="brTotal" hidden>
                                                
                                                <td align="left" width="85%">
                                                    
                                                   
                                                </td>
                                                <td id="totalTotal" align="left">
                                                    
                                                </td>
                                            </tr>
                                            
                                        </thead>
                                    </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
        <!--tabs-->
        <input type="hidden" name="eFilas" id="eFilas" value="<?=$i?>">
        <input type="hidden" id="dTotalImportes" value="0">
    </form>
    
    </div></div>
   
<script>
    
    //autocompletes
    function agregarInventario(indice)
        {
            var tInventario = document.getElementById('tInventario'+indice),
                eCodInventario = document.getElementById('inventario'+indice+'-eCodInventario'),
                eMaxPiezas = document.getElementById('inventario'+indice+'-eMaxPiezas'),
                dImporte = document.getElementById('inventario'+indice+'-dImporte');
            
            if(tInventario.value=="" || !tInventario.value)
                {
                    eCodInventario.value="";
                    eMaxPiezas.value="";
                    dImporte.value="";
                }
            
            var fhFecha = document.getElementById('fhFechaEvento');
            
             $( function() {
  
        $( "#tInventario"+indice ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-inventario/",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term,
                        fhfecha: ((fhFecha && fhFecha.value) ? fhFecha.value : "")
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tInventario'+indice).val(ui.item.label);
                $('#inventario'+indice+'-eCodInventario').val(ui.item.value); 
                $('#inventario'+indice+'-eMaxPiezas').val(ui.item.maxpiezas);
                $('#inventario'+indice+'-dImporte').val(ui.item.precioventa);
                return false;
                
            }
        });

       
        }); 
        }
    
    function agregarPaquete(indice)
        {
            var tPaquete = document.getElementById('tPaquete'+indice),
                eCodServicio = document.getElementById('paquete'+indice+'-eCodServicio'),
                eMaxPiezas = document.getElementById('paquete'+indice+'-eMaxPiezas'),
                dImporte = document.getElementById('paquete'+indice+'-dImporte');
            
            if(tPaquete.value=="" || !tPaquete.value)
                {
                    eCodServicio.value="";
                    eMaxPiezas.value="";
                    dImporte.value="";
                }
            
            var fhFecha = document.getElementById('fhFechaEvento');
            
             $( function() {
  
        $( "#tPaquete"+indice ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-paquetes/",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term,
                        fhfecha: ((fhFecha && fhFecha.value) ? fhFecha.value : "")
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tPaquete'+indice).val(ui.item.label);
                $('#paquete'+indice+'-eCodServicio').val(ui.item.value); 
                $('#paquete'+indice+'-eMaxPiezas').val(ui.item.maxpiezas);
                $('#paquete'+indice+'-dImporte').val(ui.item.precioventa);
                $('#paquete'+indice+'-dHoraExtra').val(ui.item.horaextra);
                return false;
                
            }
        });

       
        }); 
        }

    function calcularTotalPaquete(indice)
    {
        var bSuma       = document.getElementById('paquete'+indice+'-bSuma'),
            dImporte    = document.getElementById('paquete'+indice+'-dImporte'),
            ePiezas     = document.getElementById('paquete'+indice+'-ePiezas'),
            eHorasExtra = document.getElementById('paquete'+indice+'-eHorasExtra'),
            dHoraExtra = document.getElementById('paquete'+indice+'-dHoraExtra'),
            dMonto      = document.getElementById('paquete'+indice+'-dMonto');
        
        var total = 0;
        
        var dExtra = 0;
        
        if(eHorasExtra.value && eHorasExtra.value>0)
            {
                dExtra = (parseFloat(eHorasExtra.value)*parseFloat(dHoraExtra.value));
            }
        
        total = parseFloat(dImporte.value)*parseFloat(ePiezas.value) + dExtra;
        
        dMonto.value = (dImporte.value) ? total.toFixed(2) : '';
        
    }
    
    function calcularTotalInventario(indice)
    {
        var bSuma       = document.getElementById('inventario'+indice+'-bSuma'),
            dImporte    = document.getElementById('inventario'+indice+'-dImporte'),
            ePiezas     = document.getElementById('inventario'+indice+'-ePiezas'),
            dMonto      = document.getElementById('inventario'+indice+'-dMonto');
        
        var total = 0;
        
        total = parseFloat(dImporte.value)*parseFloat(ePiezas.value);
        
        dMonto.value = (dImporte.value) ? total.toFixed(2) : '';
        
        
    }
    
    
    function calcular()
    {
        var venta = 0;
        var cmbExtras = document.querySelectorAll("tr[id^=ext]");
        var cmbPaq = document.querySelectorAll("tr[id^=paq]");
        var cmbInv = document.querySelectorAll("tr[id^=inv]");
        var iva;
        var total;
        
        var bIVA = document.getElementById('bIVA');
        
        var leyenda="";
        leyenda = (bIVA.checked==true) ? "Subtotal" : "Total";
        
        var ocultar = (!bIVA.checked) ? true : false;
        
        cmbPaq.forEach(function(nodo){
            
            var idx = nodo.id.replace("paq","");
            
            calcularTotalPaquete(idx);
            
           
        });
        cmbInv.forEach(function(nodo){
            
            var idx = nodo.id.replace("inv","");
            
            calcularTotalInventario(idx);
           
        });
        
        
        cmbPaq.forEach(function(nodo){
            
            var idx = nodo.id.replace("paq","");
            
            
            
            var dImporte = document.getElementById('paquete'+idx+'-dMonto'),
                bSuma    =  document.getElementById('paquete'+idx+'-bSuma');
            
            dImporte.style.display = (bSuma.checked) ? 'none' : 'inline';
            
            venta = parseInt(venta) + parseInt((dImporte.value && bSuma.checked==false) ? dImporte.value : 0);
            iva = (bIVA.checked) ? venta*0.16 : 0;
            total = (bIVA.checked) ? venta*1.16 : venta;
        });
        cmbInv.forEach(function(nodo){
            
            var idx = nodo.id.replace("inv","");
            
            
            
            var dImporte = document.getElementById('inventario'+idx+'-dMonto'),
                bSuma    =  document.getElementById('inventario'+idx+'-bSuma');
            
            dImporte.style.display = (bSuma.checked) ? 'none' : 'inline';
            
            venta = parseInt(venta) + parseInt((dImporte.value && bSuma.checked==false) ? dImporte.value : 0);
            iva = (bIVA.checked) ? venta*0.16 : 0;
            total = (bIVA.checked) ? venta*1.16 : venta;
        });
        cmbExtras.forEach(function(nodo){
            
            var idx = nodo.id.replace("ext","");
            
            var dImporte = document.getElementById('extra'+idx+'-dImporte'),
                bSuma    =  document.getElementById('extra'+idx+'-bSuma');
            
            
            venta = parseInt(venta) + parseInt((dImporte.value && bSuma.checked==false) ? dImporte.value : 0);
            iva = (bIVA.checked) ? venta*0.16 : 0;
            total = (bIVA.checked) ? venta*1.16 : venta;
        });
        
        var cmbMontos = document.querySelectorAll("[id^=dMonto]");
        cmbMontos.forEach(function(nodo){
            if(parseInt(nodo.value)>0)
                {
            venta = parseFloat(venta) + parseFloat(nodo.value);
                }
        });
        
        
        
        document.getElementById('totalVenta').innerHTML = leyenda+" $"+venta.toFixed(2);
        document.getElementById('totalIVA').innerHTML = "I.V.A. $"+iva.toFixed(2);
        document.getElementById('totalTotal').innerHTML = "Total $"+total.toFixed(2);
        document.getElementById('brIVA').hidden = ocultar;
        document.getElementById('brTotal').hidden = ocultar;
    }
    
    $(document).ready(function() {
              $('#fhFechaEvento').datepicker({
                  locale:'es',
                  dateFormat: "dd/mm/yy"
              });
          });
    
    calcular();
    

		</script>