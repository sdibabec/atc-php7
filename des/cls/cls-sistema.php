<?php

session_start();
date_default_timezone_set('America/Mexico_City');

ini_set(session.cookie_lifetime, 108000);
ini_set(session.gc_maxlifetime, 108000);

/* establecer el limitador de caché a 'private' */

session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* establecer la caducidad de la caché a 30 minutos */
session_cache_expire(30);
$cache_expire = session_cache_expire();

class clSis
{
	public function __construct()
	{
		//include("cnx/swgc-mysql.php");
        
        $servidor 	= "localhost";
        $usuario 	= "mobiliar_root";
        $password 	= "B@surto91";
        $database 	= "mobiliar_sge3";
		
		$this->conexion = mysqli_connect($servidor,$usuario,$password,$database);
        
        mysqli_connect($servidor, $usuario, $password, $database);

        if (!$this->conexion) {
            echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
            echo "errno de depuraci贸n: " . mysqli_connect_errno() . PHP_EOL;
            echo "error de depuraci贸n: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
		
		$select = "SELECT tValor FROM SisVariables WHERE tNombre = 'tURL'";
        $rCFG = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        $this->url = $rCFG{'tValor'};
	}
	
	public function conectarBD()
	{
		return $this->conexion;
	}
	
	public function iniciarSesion()
	{
		$tCorreo = "'".$_POST['tCorreo']."'";
		$tPasswordAcceso = "'".base64_encode($_POST['tPasswordAcceso'])."'";
		
		$select = "SELECT * FROM SisUsuarios WHERE eCodEstatus=3 AND tCorreo = $tCorreo AND tPasswordAcceso = $tPasswordAcceso";
		$rsUsuario = mysqli_query($this->conexion,$select);
		$rUsuario = mysqli_fetch_array($rsUsuario);
        
		if($rsUsuario)
		{
			$_SESSION['sessionAdmin'] = $rUsuario;
            $rInicio = mysqli_fetch_array(mysqli_query($this->conexion,"SELECT * FROM SisSeccionesPerfilesInicio WHERE eCodPerfil = ".$rUsuario{'eCodPerfil'}));
            $url = base64_encode($this->generarUrl($rInicio{'tCodSeccion'}));
            
            mysqli_query($this->conexion,"INSERT INTO SisUsuariosAccesos (eCodUsuario, fhFecha) VALUES (".$rUsuario{'eCodUsuario'}.",'".date('Y-m-d H:i:s')."')");
            
            if($rUsuario{'eCodPerfil'}==4)
            { $this->consultarPromotoria(); }
            
			return array('exito'=>1,'seccion'=>$url);
		}
		else
		{
			return array('exito'=>0);
		}
	}
	
	public function cargarSeccion($seccion)
	{
		//$res->validarSeccion($_GET['tCodSeccion']);
		//$res = $this->validarSeccion($_GET['tCodSeccion']);
	
        
        //generar url de archivo
        
        //incluimos
			$fichero = '/des/mod/'.$_GET['tDirectorio'].'/'.$_GET['tCodSeccion'].'.php';
            
            mysqli_query($this->conexion,"INSERT INTO SisUsuariosSeccionesAccesos (eCodUsuario, tCodSeccion,  fhFecha) VALUES (".$_SESSION['sessionAdmin']['eCodUsuario'].",'".$_GET['tCodSeccion']."','".date('Y-m-d H:i:s')."')");
			//echo ($fichero);
			return include($fichero);
	}
   
	public function generarMenu()
	{
		$tMenu = '';
        $select = "SELECT * FROM CatTiposSecciones ORDER BY ePosicion ASC";
        $rsTiposSecciones = mysqli_query($this->conexion,$select);
        while($rTipoSeccion = mysqli_fetch_array($rsTiposSecciones))
        {
            /* ****** Cargamos las secciones ******** */
            $select = "	SELECT DISTINCT
						ss.tCodSeccion,
						ss.tTitulo,
						ss.tIcono,
                        ss.ePosicion,
                        ss.bSesion
					FROM SisSecciones ss".
					($_SESSION['sessionAdmin']['bAll'] ? "" : " INNER JOIN SisSeccionesPerfiles ssp ON ssp.tCodSeccion = ss.tCodSeccion").
					" WHERE
					ss.eCodEstatus = 3 ".
					//" AND ss.tCodPadre = 'sis-dash-con' ".
                    " AND ss.tCodTipoSeccion='".$rTipoSeccion{'tCodTipoSeccion'}."' ".
					($_SESSION['sessionAdmin']['bAll'] ? "" :
					" AND
					ssp.eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']).
                    " ORDER BY ss.ePosicion ASC";
            
            print $select;

		        $rsMenus = mysqli_query($this->conexion,$select);
            
                $eMenus = (int)mysqli_num_rows($rsMenus);
            
                if($eMenus>0)
                { 
                    //$tMenu .= '<div class="pcoded-navigation-label">'.$rTipoSeccion{'tNombre'}.'</div> ';
                    $tMenu .= '<ul class="pcoded-item pcoded-left-item"> ';
                    if($eMenus>1)
                    {
                        $tMenu .= '    <li class="pcoded-hasmenu"> ';
                        $tMenu .= '        <a href="javascript:void(0)" class="waves-effect waves-dark"> ';
                        $tMenu .= '            <span class="pcoded-micon"><i class="'.($rTipoSeccion{'tIcono'}).'"></i><b>'.$rTipoSeccion{'tNombre'}.'</b></span> ';
                        $tMenu .= '            <span class="pcoded-mtext">'.$rTipoSeccion{'tNombre'}.'</span> ';
                        $tMenu .= '            <span class="pcoded-mcaret"></span> ';
                        $tMenu .= '        </a> ';
                        $tMenu .= '        <ul class="pcoded-submenu"> ';
                    }
                    
                    //$tMenu .= '<div class="pcoded-navigation-label">'.$rTipoSeccion{'tNombre'}.'</div>'; 
                    //$tMenu .= '<ul class="pcoded-item pcoded-left-item">';
                }
                  
		          while($rMenu = mysqli_fetch_array($rsMenus))
		          {
                        $url = $this->generarUrl($rMenu{'tCodSeccion'});
		          	    $activo = ($_GET['tCodSeccion']==$rMenu{'tCodSeccion'}) ? 'class="active"' : '';
		          	    $bArchivo = $url;
                      
                        $tMenu .= '<li class="'.$activo.'">';
                        $tMenu .= '    <a href="'.$this->url.$bArchivo.'" class="waves-effect waves-dark">';
                        $tMenu .= '        <span class="pcoded-micon"><i class="'.($rTipoSeccion{'tIcono'}).'"></i></span>';
                        $tMenu .= '        <span class="pcoded-mtext">'.($rMenu{'tTitulo'}).'</span>';
                        $tMenu .= '        <span class="pcoded-mcaret"></span>';
                        $tMenu .= '    </a>';
                        $tMenu .= '</li>';
		          }
            
                if($eMenus>0)
                { $tMenu .= '</ul></li></ul>'; }
                 
              
            /* ****** Cargamos las secciones ******** */
        }
		
		return $tMenu;
	}
	
	public function validarSeccion($seccion)
	{
		$select = 	"SELECT * FROM SisSeccionesPerfiles ".
					($_SESSION['sessionAdmin']['bAll'] ? "" : " WHERE eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']." AND tCodSeccion = '".$seccion."'");
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
		return $rSeccion{'tCodSeccion'} ? $rSeccion{'tCodSeccion'} : false;
	}
	
	public function tituloSeccion($seccion)
	{
		$select = 	"SELECT tTitulo FROM SisSecciones ".
					" WHERE tCodSeccion = '".$seccion."'";
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
		return $rSeccion{'tTitulo'} ? ($rSeccion{'tTitulo'}) : false;
	}
    
    public function breadCrumb($seccion)
	{
        $secciones = array();
        
        $select =   " SELECT ss.tTitulo FROM SisSecciones ss ".
                    " INNER JOIN SisSecciones sp ON sp.tCodPadre = ss.tCodSeccion ".
                    " WHERE sp.tCodSeccion = '".$seccion."' ";
        $rsSeccionPadre = mysqli_query($this->conexion,$select);
		$rSeccionPadre = mysqli_fetch_array($rsSeccionPadre);
        
        $secciones[] = ($rSeccionPadre{'tTitulo'});
        
		$select = 	"SELECT tTitulo,tCodPadre FROM SisSecciones ".
					" WHERE tCodSeccion = '".$seccion."'";
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
        
        $secciones[] = ($rSeccion{'tTitulo'});
        
		return implode(" &rang;&rang; ",$secciones);
	}
	
	public function validarEnlace($seccion)
	{
		$select = 	"SELECT * FROM SisSeccionesPerfiles ".
					($_SESSION['sessionAdmin']['bAll'] ? "" : " WHERE eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']." AND tCodSeccion = '".$seccion."'");
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		if(mysqli_num_rows($rsSeccion)<1)
		{
			return false;
		}
        else
        {
            return true;
        }
	}
	
	public function registrarUsuario()
    {
        $eCodUsuario = $_POST['eCodUsuario'] ? $_POST['eCodUsuario'] : false;
        $eCodPerfil = $_POST['eCodPerfil'] ? $_POST['eCodPerfil'] : false;
        $tNombre = $_POST['tNombre'] ? "'".utf8_encode($_POST['tNombre'])."'" : false;
        $tApellidos = $_POST['tApellidos'] ? "'".utf8_encode($_POST['tApellidos'])."'" : false;
        $tPasswordAcceso = $_POST['tPasswordAcceso'] ? "'".base64_encode($_POST['tPasswordAcceso'])."'" : false;
        $tPasswordOperaciones = $_POST['tPasswordOperaciones'] ? "'".base64_encode($_POST['tPasswordOperaciones'])."'" : false;
        $tCorreo = $_POST['tCorreo'] ? "'".$_POST['tCorreo']."'" : false;
        $bAll = $_POST['bAll'] ? 1 : 0;
        
        $fhFechaCreacion = "'".date('Y-m-d H:i:s')."'";
        
        if(!$eCodUsuario)
        {
            $insert = "INSERT INTO SisUsuarios (tNombre, tApellidos, tCorreo, tPasswordAcceso, tPasswordOperaciones,  eCodEstatus, eCodPerfil, fhFechaCreacion,bAll) VALUES ($tNombre, $tApellidos, $tCorreo, $tPasswordAcceso, $tPasswordOperaciones, 3, $eCodPerfil, $fhFechaCreacion,$bAll)";
        }
        else
        {
            $insert = "UPDATE SisUsuarios SET
            tPasswordAcceso = $tPasswordAcceso,
            tPasswordOperaciones = $tPasswordOperaciones,
            eCodPerfil = $eCodPerfil,
            bAll = $bAll
            WHERE
            eCodUsuario = $eCodUsuario";
        }
        
        $rsUsuario = mysqli_query($this->conexion,$insert);
        
        return $rsUsuario ? true : false;
    }
    
    public function actualizarPerfil()
    {
        $eCodUsuario = $_POST['eCodUsuario'] ? $_POST['eCodUsuario'] : false;
        $tPasswordAcceso = $_POST['tPasswordAcceso'] ? "'".base64_encode($_POST['tPasswordAcceso'])."'" : false;
        $tPasswordOperaciones = $_POST['tPasswordOperaciones'] ? "'".base64_encode($_POST['tPasswordOperaciones'])."'" : false;
        $tCorreo = $_POST['tCorreo'] ? "'".$_POST['tCorreo']."'" : false;
        
        $fhFechaCreacion = "'".date('Y-m-d H:i:s')."'";
        
            $insert = "UPDATE SisUsuarios SET
            tPasswordAcceso = $tPasswordAcceso,
            tPasswordOperaciones = $tPasswordOperaciones
            WHERE
            eCodUsuario = $eCodUsuario";
        
        
        $rsUsuario = mysqli_query($this->conexion,$insert);
        
        $this->cerrarSesion();
        
        return $rsUsuario ? true : false;
    }
	
	public function cerrarSesion()
	{
		$_SESSION = array();
		$_SESSION['sessionAdmin'] = NULL;
		session_destroy();
	}
    
	//Secciones
	public function validarPermiso($seccion)
	{
        unset($_SESSION['bAll']);
        
		$bAll = $_SESSION['sessionAdmin']['bAll'];
		$select = 	"SELECT * FROM SisSeccionesPerfiles ".
					($bAll ? "" : " WHERE eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']." AND tCodSeccion = '".$seccion."'");
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
		if($rSeccion{'bAll'} || $bAll)
		{
            $_SESSION['bAll'] = 1;
			return true;
		}
        else
        {
            $_SESSION['bAll'] = 0;
            return false;
        }
	}
    
    public function validarEliminacion($seccion)
	{
        unset($_SESSION['bDelete']);
		$bAll = $_SESSION['sessionAdmin']['bAll'];
		$select = 	"SELECT * FROM SisSeccionesPerfiles ".
					($bAll ? "" : " WHERE eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']." AND tCodSeccion = '".$seccion."'");
		
		$rsSeccion = mysqli_query($this->conexion,$select);
		$rSeccion = mysqli_fetch_array($rsSeccion);
		if($rSeccion{'bDelete'} || $bAll)
		{
            $_SESSION['bDelete'] = 1;
			return true;
		}
        else
        {
            $_SESSION['bDelete'] = 0;
            return false;
        }
	}
	
    public function base64toImage($data)
    {
        $fname = "inv/".uniqid().'.jpg';
        $data1 = explode(',', base64_decode($data));
        $content = base64_decode($data1[1]);
        //$img = filter_input(INPUT_POST, "image");
        //$img = str_replace(array('data:image/png;base64,','data:image/jpg;base64,'), '', base64_decode($data));
        //$img = str_replace(' ', '+', $img);
        //$img = base64_decode($img);
        
        //file_put_contents($fname, $img);
        
        $pf = fopen($fname,"w");
        fwrite($pf,$content);
        fclose($pf);
        
        return $fname;
    }
    
    public function generarUrl($seccion)
    {
        $base = explode('-',$seccion);
        $tAccion = $base[2];
        $tTipo = $base[0];
        $tSeccion = $base[1];
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tAccion."'";
        $rAccion = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tTipo."'";
        $rTipo = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        
        $select = "SELECT tNombre FROM SisSeccionesReemplazos WHERE tBase = '".$tSeccion."'";
        $rSeccion = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        
        $select = "SELECT * FROM SisSecciones WHERE tCodSeccion = '$seccion'";
        $rsUrlSeccion = mysqli_query($this->conexion,$select);
        $rUrlSeccion = mysqli_fetch_array($rsUrlSeccion);
        
        $select = "SELECT tTitulo FROM SisSecciones WHERE tCodSeccion = '$seccion'";
        $r = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        
        $titulo = strtolower(str_replace("+ ","",str_replace(array("á","é","í","ó","ú"),array("a","e","i","o","u"),$r{'tTitulo'})));
        
        
        //$url = 'apl/'.$rUrlSeccion{'tDirectorio'}.'/'.$seccion.'/'.$rAccion{'tNombre'}.'-'.$rTipo{'tNombre'}.'-'.$rSeccion{'tNombre'}.'/';
        $url = 'apl/'.$rUrlSeccion{'tDirectorio'}.'/'.$seccion.'/'.$titulo.'/';
        
        return str_replace(" ","-",$url);
    }
    
    public function seccionPadre($seccion)
    {
        $select = "SELECT tCodPadre FROM SisSecciones WHERE tCodSeccion = '$seccion'";
        $rsSeccion = mysqli_query($this->conexion,$select);
        $rSeccion = mysqli_fetch_array($rsSeccion);
        
        return $this->generarURL($rSeccion{'tCodPadre'});
    }
    
    public function variablesSistema($tVariable)
    {
        $variables = array();
        
        $select = " SELECT * FROM SisVariables WHERE tNombre = '$tVariable'";
        $r = mysqli_fetch_array(mysqli_query($this->conexion,$select));
        
        return $r{'tValor'};
    }
}



?>