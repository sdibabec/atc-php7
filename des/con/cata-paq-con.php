<? header('Access-Control-Allow-Origin: *');  ?>
<? header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); ?>
<? header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE"); ?>
<? header("Allow: GET, POST, OPTIONS, PUT, DELETE"); ?>
<? header('Content-Type: application/json'); ?>
<?

if (isset($_SERVER{'HTTP_ORIGIN'})) {
        header("Access-Control-Allow-Origin: {$_SERVER{'HTTP_ORIGIN'}}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }


require_once("../cls/cls-sistema.php");
include("../inc/cot-clc.php");




$clSistema = new clSis();
$conexion = $clSistema->conectarBD();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

session_start();

$data = json_decode( file_get_contents('php://input') );


$fhFecha      = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFechaConsulta = $fhFecha ? $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0] : false;

$tHTML = '<table class="table table-striped"><tr><td><b>Nombre</b></td><td>Disponibles</td></tr>';

$select = " SELECT * FROM CatServicios ORDER BY tNombre ASC";
$rsProductos = mysqli_query($conexion,$select);

		while($rProducto = mysqli_fetch_array($rsProductos))
		{
            $eDisponibles = calcularPaquete($conexion,$rProducto{'eCodServicio'},$fhFechaConsulta);
            
            
            $tHTML .= '<tr>';
            $tHTML .= '<td>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>