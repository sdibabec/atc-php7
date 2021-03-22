<?php

session_start();

$errores = array();



/*Preparacion de variables*/
$bAplicar = false;

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eCodUsuario;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodUsuario = $data->eCodUsuario ? $data->eCodUsuario : false;
$eCodTipoPublicacion = $data->eCodTipoPublicacion ? $data->eCodTipoPublicacion : false;
$tCodEstatus = $data->tCodEstatus ? "'".$data->tCodEstatus."'" : false;


    $terms = explode(" ",$data->tNombre);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND tNombre like '%".$terms[$i]."%' ";
    }

$fhFecha = $data->fhFechaInicio ? explode("/",$data->fhFechaInicio) : false;
$fhFecha2 = $data->fhFechaTermino ? explode("/",$data->fhFechaTermino) : false;

$fhFechaInicio = "'".$fhFecha[2]."-".$fhFecha[1]."-".$fhFecha[0]."'";
$fhFechaTermino = $fhFecha2 ? "'".$fhFecha2[2]."-".$fhFecha2[1]."-".$fhFecha2[0]."'" : "'".$fhFechaInicio."'";

$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodUsuario';

$eInicio = $data->eInicio ? (($data->eInicio * 15)-15) : 0;
$eTermino = ($eInicio>0 ? $eInicio : 1) * 15;

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$bBorrar = false;

switch($accion)
{
    case 'D':
        
        $insert = "UPDATE SisUsuarios SET eCodEstatus = 7 WHERE eCodUsuario = ".$codigo;
        $bBorrar = true;
        break;
    case 'F':
        $insert = "UPDATE SisUsuarios SET eCodEstatus = 7 WHERE eCodUsuario = ".$codigo;
        $bBorrar = true;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th>C&oacute;digo</th>'.
		'<th>E</th>'.
        '<th>Nombre</th>'.
        '<th>Correo</th>'.
        '<th>Perfil</th>'.
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
														
        $select1 =   "	SELECT 
															cc.*, 
															ce.tIcono as estatus,
															cp.tNombre as tPerfil
														FROM
															SisUsuarios cc
														LEFT JOIN CatEstatus ce ON cc.eCodEstatus = ce.eCodEstatus 
														LEFT JOIN SisPerfiles cp ON cp.eCodPerfil = cc.eCodPerfil".
										" WHERE 1=1 ".
										($_SESSION['sessionAdmin']['bAll'] ? "" : " AND cc.eCodEstatus <>7 ").
										($_SESSION['sessionAdmin']['bAll'] ? "" : " AND cc.eCodPerfil > 2 ").
										($eCodUsuario ?  " AND cc.eCodUsuario =  ".$eCodUsuario : "").
            " LIMIT 0, $eLimit ";
        
        $eFilas = mysqli_num_rows(mysqli_query($conexion,$select1));
        
        $ePaginas = round($eFilas / 15);
        
        $select = "SELECT * FROM ($select1) N0 ORDER BY $rdOrden $bOrden LIMIT $eInicio, $eTermino";
        
        $rsConsulta = mysqli_query($conexion,$select);
        while($rConsulta=mysqli_fetch_array($rsConsulta)){
         /* validamos si est獺 cargado */
           
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.$clNav->menuEmergenteJSON($rConsulta{'eCodUsuario'},'cata-usr-sis').'</td>'.
                    '<td><i class="'.$rConsulta{'estatus'}.'"></i></td>'.
                    '<td>'.utf8_decode($rConsulta{'tNombre'}.' '.$rConsulta{'tApellidos'}).'</td>'.
                    '<td>'.($rConsulta{'tCorreo'}).'</td>'.
                    '<td>'.($rConsulta{'tPerfil'}).'</td>'.
                    
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        if($ePaginas>1)
        {
        $tHTML .=   '<tr>'.
                    '<td colspan="4" align="right">';
        $tHTML .=   '<nav aria-label="Page navigation example">';
        $tHTML .=   '<ul class="pagination">';
        for($i=1;$i<=$ePaginas;$i++)
        {
            $activo = ($i==$data->eInicio ? 'active' : '');
            $tHTML .= '<li class="page-item '.$activo.'"><a class="page-link" href="#" onclick="asignarPagina(\''.$i.'\')">'.$i.'</a></li>';   
        }
        $tHTML .=   '</ul>';
        $tHTML .=   '</nav>';
        $tHTML .=   '</td>';
        $tHTML .=   '</tr>';
        }
        $tHTML .= '</tbody>'.
            '</table>';
        
        
        
        break;
}
        
 if(!sizeof($errores) && ($accion=="D" || $accion=="F"))
{       
        $rs = mysqli_query($conexion,$insert);

        if(!$rs)
        {
            $errores[] = 'Error al efectuar la operacion '.mysql_error();
        }
        else
        {
            if($bBorrar)
             { mysqli_query($conexion,"DELETE FROM BitNotificacionesDonaciones WHERE eCodUsuario = ".$codigo); }
        }
        

     if(!sizeof($errores))
     {
         $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el paquete código ".sprintf("%07d",$codigo);
         $tDescripcion = "'".utf8_encode($tDescripcion)."'";
         $fecha = "'".date('Y-m-d H:i:s')."'";
         $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
         mysqli_query($conexion,"INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
     }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysqli_num_rows($rsConsulta),"consulta"=>$tHTML,"query"=>$select));

?>