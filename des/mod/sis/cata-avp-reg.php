<?php
require_once ("des/cnx/swgc-mysql.php");
require_once ("des/cls/cls-sistema.php");


session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$select = "SELECT bp.* FROM CatAvisoPrivacidad bp WHERE bp.eCodAviso = 1";
$rsPublicacion = mysqli_query($conexion,$select);
$rPublicacion = mysqli_fetch_array($rsPublicacion);

$select = "SELECT * FROM CatTiposPublicaciones WHERE tCodEstatus = 'AC'";
$rsTipos = mysqli_query($conexion,$select);

?>



	<script type="text/javascript">
		function readURL(input,destino) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#falseinput').attr('src', e.target.result);
					$('#base').val(e.target.result);
          document.getElementById(destino).value=e.target.result;
          //llenar();
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
        
        function guardarImagen() {
  var preview = document.getElementById('imgArchivo');
  var file    = document.getElementById('tArchivo').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.value = reader.result;

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.value = "";
  }
}
}
</script>
  <div class="col-xl-12">
<div class="card proj-progress-card">
    <div class="card-block">
        <div class="row">
        <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data" style="width:100% !important;">
        <input type="hidden" name="eCodAviso" id="eCodAviso" value="1">
        <input type="hidden" name="nvaFecha" id="nvaFecha">
        <input type="hidden" name="eAccion" id="eAccion">
       
                        <!--campos-->
             <div class="form-group row">    
              <label class="col-sm-2 col-form-label">Elementos de posici&oacute;n</label>
               <div class="col-sm-10">
                   [nombre]<br>
                   [apellidos]<br>
                   [correo]
               </div>
            </div>
                        
           <div class="form-group row">    
              <label class="col-sm-2 col-form-label">Aviso de Privacidad</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="tContenido" id="trumbowyg-demo"  placeholder="Contenido" rows="10" style="resize:none;"><?=$rPublicacion{'tContenido'} ? base64_decode($rPublicacion{'tContenido'}) : "" ?></textarea>
               </div>
            </div>
            
                        <!--campos-->
                    
    </form>
        </div>
    </div>
      </div> 
</div> 

<script>
    
    //autocompletes
   
   
    

		</script>


