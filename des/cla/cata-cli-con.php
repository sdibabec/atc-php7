




<?php






session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

$errores = array();



/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;


$eCodCliente = $data->eCodCliente ? $data->eCodCliente : false;
$eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;

$terms = explode(" ",$data->tNombres);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND cc.tNombres like '%".$terms[$i]."%' ";
    }

$terms2 = explode(" ",$data->tApellidos);
    
    $termino2 = "";
    
    for($i=0;$i<sizeof($terms2);$i++)
    {
        $termino2 .= " AND cc.tApellidos like '%".$terms2[$i]."%' ";
    }

$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodCliente';

switch($accion)
{
    case 'D':
        $select = "SELECT * FROM BitEventos WHERE eCodCliente = ".$_GET['eCodCliente'];
            $rs = mysqli_query($conexion,$select);
            
            if(mysqli_num_rows($rs)>0)
            {
                $insert = "UPDATE CatClientes SET eCodEstatus=7 WHERE eCodCliente = ".$codigo;
            }
            else
            {
                $insert = "DELETE FROM CatClientes WHERE eCodCliente = ".$codigo;
            }
        break;
    case 'F':
        $insert = "UPDATE CatClientes SET eCodEstatus = 8 WHERE eCodCliente = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th>Código</th>'.
		'<th>E</th>'.
        '<th>Nombre</th>'.
        '<th>Apellidos</th>'.
        '<th class="text-left">Correo</th>'.
        '<th class="text-left">Teléfono</th>'.
		'<th class="text-left">Promotor</th>'.
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select = "SELECT * FROM (SELECT 
		cc.*, 
		ce.tIcono as estatus,
		su.tNombre as promotor
		FROM
			CatClientes cc
		INNER JOIN CatEstatus ce ON cc.eCodEstatus = ce.eCodEstatus
		LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario
        WHERE 1=1".
        ($_SESSION['sessionAdmin']['bAll'] ? "" : " AND cc.eCodEstatus<> 7").
		($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
        ($eCodCliente ? " AND cc.eCodCliente = ".$eCodCliente : "").
        ($data->tNombres    ?   $termino    :   "").
        ($data->tApellidos  ?   $termino2   :   "").
        " ORDER BY cc.$rdOrden $bOrden".
        " LIMIT 0, $eLimit ".
		")N0 ";
		
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
            //imprimimos
       $tHTML .=    '<tr>'.
        '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodCliente'},'cata-cli-con').'</td>'.
        '<td><i class="'.$rConsulta{'estatus'}.'"></i></td>'.
        '<td>'.utf8_encode($rConsulta{'tTitulo'}).''.utf8_encode($rConsulta{'tNombres'}).'</td>'.
		'<td>'.utf8_encode($rConsulta{'tApellidos'}).'</td>'.
		'<td>'.utf8_encode($rConsulta{'tCorreo'}).'</td>'.
		'<td>'.utf8_encode($rConsulta{'tTelefonoFijo'}).'</td>'.
		'<td>'.utf8_encode($rConsulta{'promotor'}).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        $tHTML .= '</tbody>'.
            '</table>';
        break;
}
        
if($accion=="D" || $accion=="F")
{      
    $rs = mysqli_query($conexion,$insert);

    if(!$rs)
    {
        $errores[] = 'Error al efectuar la operacion '.mysqli_error($conexion);
    }

    if(!sizeof($errores))
    {
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el cliente código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML,"select",$select));

?>