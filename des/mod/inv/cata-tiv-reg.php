<?php



session_start();

$select = "	SELECT 
	ci.*
FROM
	CatTiposInventario ci
WHERE ci.eCodTipoInventario = ".$_GET['v1'];
//echo $select;
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);

?>
<?
if($_POST)
{
    $res = $clSistema -> registrarInventario();
    
    if($res)
    {
        ?>
            <div class="alert alert-success" role="alert">
                El producto se guard&oacute; correctamente!
            </div>
<script>
setTimeout(function(){
    window.location="?tCodSeccion=cata-inv-con";
},2500);
</script>
<?
    }
    else
    {
  ?>
            <div class="alert alert-danger" role="alert">
                Error al procesar la solicitud!
            </div>
<?
    }
}
?>

    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="eCodTipoInventario" name="eCodTipoInventario" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
           
		                                    <div class="form-group">
                                               <label>Nombre</label>
                                               <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=($rPublicacion{'tNombre'})?>" >
                                            </div>
                                            <div class="form-group">
                                               <label>Posici&oacute;n</label>
                                               <input type="text" class="form-control" name="ePosicion" id="ePosicion" placeholder="Posición" value="<?=($rPublicacion{'ePosicion'})?>" >
                                            </div>
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>