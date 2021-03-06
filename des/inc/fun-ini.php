<?php
include("../cnx/swgc-mysql.php");
include("fun-res.php");

session_start(); 
date_default_timezone_set('America/America/Mexico_City');

    

	function obtenerURL()
	{
		$select = "SELECT tValor FROM SisVariables WHERE tNombre = 'tURL'";
        $rCFG = mysqli_fetch_array(mysqli_query($conexion,$select));
        return $rCFG{'tValor'};
	}
	
    function generarUrl($seccion, $bServidor = true,$accion,$codigo)
    {
        $base = explode('-',$seccion);
        $tAccion = $base[2];
        $tTipo = $base[0];
        $tSeccion = $base[1];
        
        $select = "SELECT tTitulo, tDirectorio FROM SisSecciones WHERE tCodSeccion = '".$seccion."'";
        $rAccion = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        
        $url = 'apl/'.($rAccion['tDirectorio'] ? $rAccion['tDirectorio'] : $_GET['tDirectorio']).'/'.$seccion.'/'.generarTitulo($seccion).'/'.($codigo ? 'v1/'.$codigo.'/' : '');
        
        $servidor = obtenerURL();
        
        return ($bServidor ? $servidor : '').$url;
    }

    function generarTitulo($seccion)
    {
        $base = explode('-',$seccion);
        $tAccion = $base[2];
        $tTipo = $base[0];
        $tSeccion = $base[1];
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tAccion."'";
        $rAccion = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tTipo."'";
        $rTipo = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tSeccion."'";
        $rSeccion = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $select = "SELECT tTitulo FROM SisSecciones WHERE tCodSeccion = '$seccion'";
        $r = mysqli_fetch_array(mysqli_query($conexion,$select));
        
        $titulo = str_replace("+ ","",str_replace(array("á","é","í","ó","ú"),array("a","e","i","o","u"),$r{'tTitulo'}));
        
        //$url = $rAccion{'tNombre'}.'-'.$rTipo{'tNombre'}.'-'.$rSeccion{'tNombre'};
        $url = strtolower(str_replace("+ ","",str_replace(array("á","é","í","ó","ú"),array("a","e","i","o","u"),$r{'tTitulo'})));
        
        
        return str_replace(" ","-",$url);
    }

    /* Validamos permisos */

    function validarEliminacion($seccion)
	{
		$bAll = $_SESSION['sessionAdmin']['bAll'];
		$select = 	"SELECT * FROM SisSeccionesPerfiles ".
					($bAll ? "" : " WHERE eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']." AND tCodSeccion = '".$seccion."'");
		
		$rsSeccion = mysqli_query($conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
		if($rSeccion{'bDelete'} || $bAll)
		{
			return true;
		}
        else
        {
            return false;
        }
	}

    /*Buscamos los botones*/

    function botones($codigo)
    {
        $tCodSeccion = $_GET['tCodSeccion'];
        
        $join = $_SESSION['sessionAdmin']['bAll'] ? 'LEFT ' : 'INNER ';
        
        $select = "SELECT DISTINCT
                        ssb.tCodPadre,ssb.tCodSeccion,ssb.tEtiqueta, sb.*, ssb.tCodBoton boton, ssb.tFuncion funcion 
                    FROM 
                        SisSeccionesBotones ssb 
                    INNER JOIN SisBotones sb on sb.tCodBoton=ssb.tCodBoton 
                    $join JOIN SisSeccionesPerfiles ssp ON ssp.tCodSeccion=ssb.tCodSeccion 
                    $join JOIN SisSeccionesPerfiles sss on sss.tCodSeccion=ssb.tCodSeccion 
                    WHERE
                    1=1 ".
                    ($_SESSION['sessionAdmin']['bAll'] ? "" :" AND ssp.eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']).
                    " AND ssb.tCodPadre = '".$tCodSeccion."'".
                    " ORDER BY ssb.ePosicion ASC ";
        
        //echo $select;
        $rsBotones = mysqli_query($conexion,$select);
        while($rBoton = mysqli_fetch_array($rsBotones))
        { 
        $accion = ($rBoton{'tAccion'}) ? $rBoton{'tAccion'} : false;
         
        if($rBoton{'tCodBoton'}!="CO")   
         { $seccion = generarUrl($rBoton{'tCodSeccion'},true, $accion,(($codigo) ? sprintf("%07d",$codigo) : false)); }
        else
         { $seccion = generarUrl($rBoton{'tCodSeccion'},true, $accion); }
            
         if($rBoton{'tCodBoton'}!="CO")   
         {  $funcion = str_replace(array('url','codigo'),array($seccion,$codigo),$rBoton{'tFuncion'}); }
            else
         {  $funcion = str_replace('url',$seccion,$rBoton{'tFuncion'}); }
         ?>
            <button style="margin-left:10px;" type="button" class="<?=$rBoton{'tClase'}?>" <?=($rBoton{'bDeshabilitado'}) ? 'disabled' : ''?> onclick="<?=($rBoton{'funcion'}) ? $rBoton{'funcion'} : $funcion?>" id="<?=(($rBoton{'tId'}) ? $rBoton{'tId'} : $rBoton{'tCodBoton'} )?>">
            <?=$rBoton{'tIcono'}?> <?=($rBoton{'tEtiqueta'}) ? $rBoton{'tEtiqueta'} : $rBoton{'tTitulo'}?></button><?=$rBoton{'tHTML'}?>
           <? unset($funcion); ?>
           <? }
    }

    function menuEmergente($codigo)
    {
       
        
        $tCodSeccion = $_GET['tCodSeccion'];
        
        $bDelete = validarEliminacion($tCodSeccion);
        
        $join = $_SESSION['sessionAdmin']['bAll'] ? 'LEFT ' : 'INNER ';

        $select = "SELECT DISTINCT
                        ssb.tCodPadre, 
                        ssb.tCodSeccion,
                        ssb.tCodPermiso, 
                        ssb.tTitulo, 
                        ssb.tAccion, 
                        ssb.tFuncion, 
                        ssb.tValor, 
                        ssb.ePosicion
                    FROM 
                        SisSeccionesMenusEmergentes ssb 
                    $join JOIN SisSeccionesPerfiles ssp ON ssp.tCodSeccion=ssb.tCodSeccion 
                    $join JOIN SisSeccionesPerfiles sss on sss.tCodSeccion=ssb.tCodSeccion 
                    WHERE
                    1=1 ".
                    ($_SESSION['sessionAdmin']['bAll'] ? "" :" AND ssp.eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']).
                    " AND ssb.tCodPadre = '".$tCodSeccion."'
                    ORDER BY ssb.tCodPadre ASC, ssb.ePosicion ASC";
        //echo $select;
        ?>
                <div class="dropdown" style="width:100%;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;">
                <?=sprintf("%07d",$codigo)?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?
        
        //echo $select;
        $rsBotones = mysqli_query($conexion,$select);
        while($rBoton = mysqli_fetch_array($rsBotones))
        { 
        $accion = ($rBoton{'tAccion'}) ? $rBoton{'tAccion'} : false;
        $seccion = generarUrl($rBoton{'tCodSeccion'},true, $accion,sprintf("%07d",$codigo));
        $funcion = str_replace(array('url','codigo'),array($seccion,$codigo),$rBoton{'tFuncion'});
        //$funcion = str_replace('seccion',$rBoton{'tCodSeccion'},$rBoton{'tFuncion'});
        //$funcion = str_replace('codigo',$codigo,$rBoton{'tFuncion'});
        
        $mostrar = ($bDelete) ? '' : 'style="display:none;"';
         ?>
            <a class="dropdown-item" href="#" onclick="<?=$funcion?>" <?=($rBoton{'tCodPermiso'}=="D" ? $mostrar : '')?>><?=$rBoton{'tTitulo'}?></a>
           <? }
               ?></div></div><?
    }

    function menuEmergenteJSON($codigo,$tCodSeccion, $tEstados = false)
    {
       
        
        //$tCodSeccion = $_GET['tCodSeccion'];
        
        $bDelete = validarEliminacion($tCodSeccion);
        
        $join = $_SESSION['sessionAdmin']['bAll'] ? 'LEFT ' : 'INNER ';

        $select = "SELECT DISTINCT
                        ssb.tCodPadre, 
                        ssb.tCodSeccion,
                        ssb.tCodPermiso, 
                        ssb.tTitulo, 
                        ssb.tAccion, 
                        ssb.tFuncion, 
                        ssb.tValor, 
                        ssb.ePosicion
                    FROM 
                        SisSeccionesMenusEmergentes ssb 
                    $join JOIN SisSeccionesPerfiles ssp ON ssp.tCodSeccion=ssb.tCodSeccion 
                    $join JOIN SisSeccionesPerfiles sss on sss.tCodSeccion=ssb.tCodSeccion 
                    WHERE
                    1=1 ".
                    ($_SESSION['sessionAdmin']['bAll'] ? "" :" AND ssp.eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']).
                    " AND ssb.tCodPadre = '".$tCodSeccion."'
                    ORDER BY ssb.tCodPadre ASC, ssb.ePosicion ASC";
        //echo $select;
        
                $tHTML = '<div class="dropdown" style="width:100%;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;">
                '.sprintf("%07d",$codigo).'
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
    
        
        //echo $select;
        $rsBotones = mysqli_query($conexion,$select);
        while($rBoton = mysqli_fetch_array($rsBotones))
        { 
        $accion = ($rBoton{'tAccion'}) ? $rBoton{'tAccion'} : false;
        $seccion = generarUrl($rBoton{'tCodSeccion'},true, $accion,sprintf("%07d",$codigo));
        $funcion = str_replace(array('url','codigo'),array($seccion,$codigo),$rBoton{'tFuncion'});
        //$funcion = str_replace('seccion',$rBoton{'tCodSeccion'},$rBoton{'tFuncion'});
        //$funcion = str_replace('codigo',$codigo,$rBoton{'tFuncion'});
            
        $bBloquear = 'onclick="'.$funcion.'" ';
        if($tEstados && !$tEstados[$rBoton{'ePosicion'}])
        { $bBloquear = 'onclick="return false;" style="cursor: not-allowed; text-decoration: line-through;"'; }
        
        $mostrar = ($bDelete) ? '' : 'style="display:none;"';
            
            $tHTML .= '<a class="dropdown-item" 
                            href="#" '.
                    ($rBoton{'tCodPermiso'}=="D" ? $mostrar : '').' '.$bBloquear.'>'.$rBoton{'tTitulo'}.'</a>';
          }
               $tHTML .= '</div></div>';
        
        return $tHTML;
    }
    
    function base64blob($datos,$width = false)
    {
        $regex = '/(data)(\:)([a-z0-9]+)(\/)([a-z0-9]+)(\;)/';
        
        preg_match($regex,$datos,$res);
        
        $uuid = uniqid();
        $nombre = "../cni/".$uuid.'.'.$res[5];
        $datos1 = explode(',', ($datos));
        $content = base64_decode($datos1[1]);
        
        $pf = fopen($nombre,"w");
        fwrite($pf,$content);
        fclose($pf);
        
        if($width)
        {
            redimensionar($nombre,$width);
        }
        
        return str_replace("../cni/","",$nombre);
        
    }

    function breadCrumb($seccion,$i=0)
	{
        
		$select = 	"SELECT tTitulo,tCodPadre FROM SisSecciones ".
					" WHERE tCodSeccion = '".$seccion."'";
		
		$rsSeccion = mysqli_query($conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
        
        $_SESSION['sesionNavegacion'][] = ($rSeccion{'tTitulo'});
        
        if($rSeccion{'tCodPadre'})
        { breadCrumb($rSeccion{'tCodPadre'}); }
        
	}

    function redimensionar($tArchivo,$minWidth)
    {
	$extension 	= pathinfo($tArchivo, PATHINFO_EXTENSION);
	if($extension=='jpg'||$extension=='jpeg'||$extension=='png'||$extension=='.jpg'||$extension=='.jpeg'||$extension=='.png')
			{
				$imageRatios=getimagesize($tArchivo);
				$width=$imageRatios[0];
				$height=$imageRatios[1];
				
				$aspectRatio=$minWidth/$width;
				
				$nWidth=$width*$aspectRatio;
				$nHeight=$height*$aspectRatio;
				if($width>$minWidth)
				{
					smart_resize_image($tArchivo,NULL,$nWidth,$nHeight,false,$tArchivo,false,false,100,false);	
				}
			}
    }

?>