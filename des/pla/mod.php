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
require_once("../cls/cls-nav.php");
include("../inc/cot-clc.php");

$clSis = new clSis();
$clNav = new clNav();

$conexion = $clSis->conectarBD();

session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

$errores = array();

$eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
$fecha = "'".date('Y-m-d H:i:s')."'";
$fhFecha = "'".date('Y-m-d H:i:s')."'";
$hoy = "'".date('Y-m-d H:i:s')."'";

$data = json_decode( file_get_contents('php://input') );

$tTipoRecurso = $_GET['tTipoRecurso'];
$tRecurso = $_GET['tRecurso'];

include("../".$tTipoRecurso."/".$tRecurso.".php");
?>