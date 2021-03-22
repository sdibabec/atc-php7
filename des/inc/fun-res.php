<?php
/**
 * Funcion para redimensionar imagenes
 * @param  $archivo - Archivo a redimensionar
 * @param  $datos - Datos de la imagen como string, por defect es NULL
 * @param  $width - Nuevo ancho
 * @param  $height - Nuevo alto
 * @param  $proporcion - Mantener proporciones, por defecto es FALSE
 * @param  $salida - Nuevo nombre del archivo (se sobre-escribe si es el mismo)
 * @param  $elim_original - Eliminar original, por defecto es TRUE
 * @param  $usar_comando_linux - Usar comandos linux, por defecto es FALSE
 * @param  $calidad - Calidad (1-100) donde 100 es la maxima
 * @param  $sepia - Escala de grises (Por defecto es FALSE)
 * @return boolean|resource
 */
  function smart_resize_image($archivo,
                              $datos             = null,
                              $width              = 0, 
                              $height             = 0, 
                              $proporcion       = false, 
                              $salida             = 'file', 
                              $elim_original    = true, 
                              $usar_comando_linux = false,
                              $calidad            = 100,
                              $sepia          = false
  		 ) {
      
    if ( $height <= 0 && $width <= 0 ) return false;
    if ( $archivo === null && $datos === null ) return false;
    # Establecemos los defaults
    $info                         = $archivo !== null ? getimagesize($archivo) : getimagesizefromstring($datos);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;
    # Cálculo de proporciones (solo cuando no se envía el width y height)
    if ($proporcion) {
      if      ($width  == 0)  $factor = $height/$height_old;
      elseif  ($height == 0)  $factor = $width/$width_old;
      else                    $factor = min( $width / $width_old, $height / $height_old );
      $final_width  = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
	  $widthX = $width_old / $width;
	  $heightX = $height_old / $height;
	  
	  $x = min($widthX, $heightX);
	  $cropWidth = ($width_old - $width * $x) / 2;
	  $cropHeight = ($height_old - $height * $x) / 2;
    }
    # Carga la imagen a memoria de acuerdo al tipo
    switch ( $info[2] ) {
      case IMAGETYPE_JPEG:  $archivo !== null ? $image = imagecreatefromjpeg($archivo) : $image = imagecreatefromstring($datos);  break;
      case IMAGETYPE_GIF:   $archivo !== null ? $image = imagecreatefromgif($archivo)  : $image = imagecreatefromstring($datos);  break;
      case IMAGETYPE_PNG:   $archivo !== null ? $image = imagecreatefrompng($archivo)  : $image = imagecreatefromstring($datos);  break;
      default: return false;
    }
    
    # Se cambia a escala de grises si así fue establecido
    if ($sepia) {
      imagefilter($image, IMG_FILTER_GRAYSCALE);
    }    
    
    # Aqui es donde se hace el cambio de tamaño / resampling / preservación de la transparencia
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);
      $palletsize = imagecolorstotal($image);
      if ($transparency >= 0 && $transparency < $palletsize) {
        $transparent_color  = imagecolorsforindex($image, $transparency);
        $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
	
	
    # Se genera la eliminación del archivo original (cuando se solicita en el llamado)
    if ( $elim_original ) {
      if ( $usar_comando_linux ) exec('rm '.$archivo);
      else @unlink($archivo);
    }
    # Se prepara el método para el resultado
    switch ( strtolower($salida) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $salida = NULL;
      break;
      case 'file':
        $salida = $archivo;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Creando imagen con nuevo tamaño y acorde al formato recibido
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   imagegif($image_resized, $salida);    break;
      case IMAGETYPE_JPEG:  imagejpeg($image_resized, $salida, $calidad);   break;
      case IMAGETYPE_PNG:
        $calidad = 9 - (int)((0.9*$calidad)/10.0);
        imagepng($image_resized, $salida, $calidad);
        break;
      default: return false;
    }
    return true;
  }
?>