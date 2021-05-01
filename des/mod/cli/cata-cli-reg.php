<?php



session_start();

$select = "SELECT * FROM CatClientes WHERE eCodCliente = ".$_GET['v1'];
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);

?>


    <div class="col-lg-12">
<div class="row">
    
    <form id="datos" class="col-lg-12" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eCodCliente" id="eCodCliente" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=utf8_decode($rPublicacion{'tNombres'})?>" >
           </div>
           <div class="form-group">
              <label>Apellidos</label>
              <input type="text" class="form-control" name="tApellidos" id="tApellidos" placeholder="Apellidos" value="<?=utf8_decode($rPublicacion{'tApellidos'})?>" >
           </div>
           <div class="form-group">
              <label>E-mail</label>
              <input type="email" class="form-control" name="tCorreo" id="tCorreo" placeholder="E-mail" value="<?=utf8_decode($rPublicacion{'tCorreo'})?>" >
           </div>
           <div class="form-group">
              <label>Tel&eacute;fono Fijo</label>
              <input type="text" class="form-control" name="tTelefonoFijo" id="tTelefonoFijo" placeholder="Tel&eacute;fono Fijo" value="<?=utf8_decode($rPublicacion{'tTelefonoFijo'})?>" >
           </div>
           <div class="form-group">
              <label>Tel&eacute;fono M&oacute;vil</label>
              <input type="text" class="form-control" name="tTelefonoMovil" id="tTelefonoMovil" placeholder="Tel&eacute;fono M&oacute;vil" value="<?=utf8_decode($rPublicacion{'tTelefonoMovil'})?>" >
           </div>
            <div class="form-group">
              <label>Comentarios</label>

              <textarea rows="5" class="form-control" name="tComentarios" id="tComentarios" ><?=utf8_decode($rPublicacion{'tComentarios'})?></textarea>

           </div>
           <div class="form-group">
              <label><input type="checkbox" id="bFrecuente" name="bFrecuente" value="1" <?=($rPublicacion{'bFrecuente'} ? 'checked="checked"' : '')?>>Cliente Frecuente</label>
              
           </div>
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>