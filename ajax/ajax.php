<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/validadores.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosValidador        = new serviciosValidador();


$accion = $_POST['accion'];

$resV['error'] = '';
$resV['mensaje'] = '';



switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
		break;
   case 'registrarme':
      registrarme($serviciosUsuarios, $serviciosReferencias, $serviciosValidador);
   break;

   case 'eliminarUsuarios':
      eliminarUsuarios($serviciosUsuarios, $serviciosReferencias);
   break;


   case 'insertarClientes':
      insertarClientes($serviciosReferencias, $serviciosValidador, $serviciosUsuarios);
   break;
   case 'modificarClientes':
      modificarClientes($serviciosReferencias, $serviciosValidador, $serviciosUsuarios);
   break;
   case 'eliminarClientes':
      eliminarClientes($serviciosReferencias);
   break;
   case 'traerClientes':
      traerClientes($serviciosReferencias);
   break;
   case 'traerClientesPorId':
      traerClientesPorId($serviciosReferencias);
   break;


case 'insertarArchivos':
insertarArchivos($serviciosReferencias);
break;
case 'modificarArchivos':
modificarArchivos($serviciosReferencias);
break;
case 'eliminarArchivos':
eliminarArchivos($serviciosReferencias);
break;

case 'traerArchivosPorCliente':
	traerArchivosPorCliente($serviciosReferencias);
	break;

	case 'insertarCategorias':
	insertarCategorias($serviciosReferencias);
	break;
	case 'modificarCategorias':
	modificarCategorias($serviciosReferencias);
	break;
	case 'eliminarCategorias':
	eliminarCategorias($serviciosReferencias);
	break;
   case 'modificarClientePorCliente':
	modificarClientePorCliente($serviciosReferencias);
	break;


   case 'frmAjaxModificar':
      frmAjaxModificar($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios);
   break;
   case 'frmAjaxNuevo':
      frmAjaxNuevo($serviciosFunciones, $serviciosReferencias);
   break;

   case 'verificarSemaforos':
      verificarSemaforos($serviciosReferencias, $serviciosNotificaciones, $serviciosUsuarios);
   break;
   case 'traerNotificacionesPorRol':
      traerNotificacionesPorRol($serviciosReferencias, $serviciosNotificaciones, $serviciosUsuarios);
   break;


/* Fin */

}
/* Fin */


function modificarClientePorCliente($serviciosReferencias) {
	$id = $_POST['id'];
	$apellido = $_POST['apellido'];
	$nombre = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];

	if (($apellido == '') || ($nombre == '')) {
		echo 'Hubo un error al modificar datos, los campos Apellido, Nombre y CUIT son obligatorios';
	} else {
		$res = $serviciosReferencias->modificarClientePorCliente($id,$apellido,$nombre,$telefono,$celular);

		if ($res == true) {
			echo '';
		} else {
			echo 'Hubo un error al modificar datos';
		}
	}
}

function eliminarUsuarios($serviciosUsuarios, $serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarUsuarios($id);

   if ($res == true) {
		echo '';
	} else {
		echo 'Hubo un error al modificar datos';
	}
}


function insertarCategorias($serviciosReferencias) {
	$categoria = $_POST['categoria'];

	$res = $serviciosReferencias->insertarCategorias($categoria);

	if ((integer)$res > 0) {
		echo '';
	} else {
		echo 'Hubo un error al insertar datos';
	}
}


function modificarCategorias($serviciosReferencias) {
	$id = $_POST['id'];
	$categoria = $_POST['categoria'];

	$res = $serviciosReferencias->modificarCategorias($id,$categoria);

	if ($res == true) {
		echo '';
	} else {
		echo 'Hubo un error al modificar datos';
	}
}


function eliminarCategorias($serviciosReferencias) {
	$id = $_POST['id'];

	$res = $serviciosReferencias->eliminarCategorias($id);

   if ($res == true) {
		echo '';
	} else {
		echo 'Hubo un error al modificar datos';
	}
}



function traerArchivosPorCliente($serviciosReferencias) {
	$id = $_POST['id'];

	$res = $serviciosReferencias->traerArchivosPorCliente($id);

	$cad3 = '';
	//////////////////////////////////////////////////////busquedajugadores/////////////////////
	$cad3 = $cad3.'
				<div class="col-md-12">
				<div class="panel panel-info">
                                <div class="panel-heading">
                                	<h3 class="panel-title">Archivos Encontrados</h3>

                                </div>
                                <div class="panel-body-predio" style="padding:5px 20px;">
                                	';
	$cad3 = $cad3.'
	<div class="row">
                	<table id="example" class="table table-responsive table-striped" style="font-size:1.2em; padding:2px;">
						<thead>
                        <tr>
                        	<th>Observacion</th>
                        	<th>Fecha Creación</th>
							<th>Descargar</th>
                        </tr>
						</thead>
						<tbody id="resultadosProd">';
	while ($rowJ = mysql_fetch_array($res)) {
		$cad3 .= '<tr>
					<td>'.($rowJ['observacion']).'</td>
					<td>'.($rowJ['fechacreacion']).'</td>
					<td><a href="descargar.php?token='.$rowJ['token'].'" target="_blank"><img src="../imagenes/download-2-icon.png" style="width:8%;"></a></td>
				 </tr>';
	}

	$cad3 = $cad3.'</tbody>
                                </table></div>
                            </div>
						</div>';

	echo $cad3;
}

function insertarArchivos($serviciosReferencias) {
	$refclientes = $_POST['refclientes'];
	$token = $_POST['token'];
	//$imagen = $_POST['imagen'];
	$observacion = $_POST['observacion'];

	$refcategorias = $_POST['refcategorias'];
	$anio = $_POST['anio'];
	$mes = $_POST['mes'];

	if ($_FILES['imagen']['tmp_name'] != '') {
		$res = $serviciosReferencias->subirArchivo('imagen',$refclientes,$serviciosReferencias->obtenerNuevoId('dbarchivos'),$token,$observacion, $refcategorias, $anio, $mes);

		if ($res == '') {
			echo '';
		} else {
			echo 'Hubo un error al insertar datos';
		}
	} else {
		echo 'Debe seleccionar un archivo';
	}
}


function modificarArchivos($serviciosReferencias) {
	$id = $_POST['id'];
	$refclientes = $_POST['refclientes'];
	$token = $_POST['token'];
	$imagen = $_POST['imagen'];
	$type = $_POST['type'];
	$observacion = $_POST['observacion'];

	$res = $serviciosReferencias->modificarArchivos($id,$refclientes,$token,$imagen,$type,$observacion);

	if ($res == true) {
		echo '';
	} else {
		echo 'Hubo un error al modificar datos';
	}
}


function eliminarArchivos($serviciosReferencias) {
	$id = $_POST['id'];

   $res = $serviciosReferencias->eliminarArchivos($id);

   if ($res == true) {
		echo '';
	} else {
		echo 'Hubo un error al modificar datos';
	}
}



function frmAjaxModificar($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   session_start();

   switch ($tabla) {
      case 'tbcategorias':
         $modificar = "modificarCategorias";
         $idTabla = "idcategoria";

         $lblCambio	 	= array();
         $lblreemplazo	= array();

         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();
         break;

      case 'dbclientes':
         $modificar = "modificarClientes";
         $idTabla = "idcliente";

         $lblCambio	 	= array('telefono','celular','aceptaterminos','cuit');
         $lblreemplazo	= array('Tel. Fijo','Tel. Movil','Acepta Terminos y condiciones','DNI');

         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();
         break;
      case 'dbusuarios':
         $resultado = $serviciosReferencias->traerUsuariosPorId($id);

         $modificar = "modificarUsuarios";
         $idTabla = "idusuario";

         $lblCambio	 	= array('nombrecompleto','refclientes');
         $lblreemplazo	= array('Nombre Completo','Cliente');

         $refClientes = $serviciosReferencias->traerClientesPorId(mysql_result($resultado,0,'refclientes'));
         $cadRef2 = $serviciosFunciones->devolverSelectBox($refClientes,array(1,2,3),' ');

         if ($_SESSION['idroll_sahilices'] != 1) {
         	$resRoles 	= $serviciosUsuarios->traerRolesSimple();
         } else {
         	$resRoles 	= $serviciosUsuarios->traerRoles();
         }

         $cadRef = $serviciosFunciones->devolverSelectBox($resRoles,array(1),'');

         $refdescripcion = array(0 => $cadRef, 1=>$cadRef2);
         $refCampo 	=  array("refroles","refclientes");
         break;


      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo $formulario;
}


function frmAjaxNuevo($serviciosFunciones, $serviciosReferencias) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   switch ($tabla) {
      case 'dbplantas':

         $insertar = "insertarPlantas";
         $idTabla = "idplanta";

         $lblCambio	 	= array("reflientes");
         $lblreemplazo	= array("Cliente");

         $resVar1 = $serviciosReferencias->traerClientesPorId($id);
         $cadRef1 	= $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),'', $id);

         $refdescripcion = array(0=>$cadRef1);
         $refCampo 	=  array('refclientes');
         break;

      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo $formulario;
}


/* PARA Unidadesnegocios */

function insertarClientes($serviciosReferencias, $serviciosValidador, $serviciosUsuarios) {
   $error = '';

   $apellido = ( $serviciosValidador->validaRequerido( trim($_POST['apellido']) ) == true ? trim($_POST['apellido']) : $error .= 'El campo Apellido es obligatorio
   ');

   $nombre = ( $serviciosValidador->validaRequerido( trim($_POST['nombre']) ) == true ? trim($_POST['nombre']) : $error .= 'El campo Nombre es obligatorio
   ');

   $cuit = ( $serviciosValidador->validaRequerido( str_replace('_','',trim($_POST['cuit'])) ) == true ? trim($_POST['cuit']) : $error .= 'El campo DNI es obligatorio
   ');

   if (isset($_POST['aceptaterminos'])) {
      $aceptaterminos = 1;
   } else {
      $aceptaterminos = 0;
   }

   if (isset($_POST['subscripcion'])) {
      $subscripcion = 1;
   } else {
      $subscripcion = 0;
   }

   $email = $_POST['email'];
   $telefono = $_POST['telefono'];
   $celular = $_POST['celular'];

   $pass = trim($_POST['pass']);

   $existeEmail = $serviciosUsuarios->existeUsuario($email);
   $existeCliente = $serviciosReferencias->existeCliente($cuit);

   if ($existeEmail == 1) {
      $error .= 'El Email ingresado ya existe!
      ';
   }

   if ($existeCliente == 1) {
      $error .= 'El DNI ingresado ya existe!
      ';
   }

   if ($error != '') {
      echo $error;
   } else {
      $res = $serviciosReferencias->insertarClientes($apellido,$nombre,$cuit,$telefono,$celular,$email,$aceptaterminos,$subscripcion, 1);



      if ((integer)$res > 0) {
         $sql = "INSERT INTO dbusuarios
      				(idusuario,
      				usuario,
      				password,
      				refroles,
      				email,
      				nombrecompleto,
      				activo,
      				refclientes)
      			VALUES
      				('',
      				'".$apellido.' '.$nombre."',
      				'".$pass."',
      				3,
      				'".$email."',
      				'".$apellido.' '.$nombre."',
      				1,
      				$res)";

      	$resUsuario = $serviciosReferencias->query($sql,1);
         echo '';
      } else {
         echo 'Huvo un error al insertar datos';
      }
   }

}

function modificarClientes($serviciosReferencias, $serviciosValidador) {
   $error = '';

   $id = $_POST['id'];
   $apellido = ( $serviciosValidador->validaRequerido( trim($_POST['apellido']) ) == true ? trim($_POST['apellido']) : $error .= 'El campo Apellido es obligatorio
   ');

   $nombre = ( $serviciosValidador->validaRequerido( trim($_POST['nombre']) ) == true ? trim($_POST['nombre']) : $error .= 'El campo Nombre es obligatorio
   ');

   $cuit = ( $serviciosValidador->validaRequerido( str_replace('_','',trim($_POST['cuit'])) ) == true ? trim($_POST['cuit']) : $error .= 'El campo DNI es obligatorio
   ');

   if (isset($_POST['aceptaterminos'])) {
      $aceptaterminos = 1;
   } else {
      $aceptaterminos = 0;
   }

   if (isset($_POST['subscripcion'])) {
      $subscripcion = 1;
   } else {
      $subscripcion = 0;
   }

   $email = $_POST['email'];
   $telefono = $_POST['telefono'];
   $celular = $_POST['celular'];

   $existeEmail = $serviciosUsuarios->existeUsuario($email);
   $existeCliente = $serviciosReferencias->existeCliente($cuit,1,$id);

   if ($existeEmail == 1) {
      $error .= 'El Email ingresado ya existe!
      ';
   }

   if ($existeCliente == 1) {
      $error .= 'El DNI ingresado ya existe!
      ';
   }

   if ($error != '') {
      echo $error;
   } else {
      $res = $serviciosReferencias->modificarClientes($id,$apellido,$nombre,$cuit,$telefono,$celular,$email,$aceptaterminos,$subscripcion, 1);

      if ($res == true) {
         echo '';
      } else {
         echo 'Huvo un error al modificar datos';
      }
   }

}

function eliminarClientes($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarClientes($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Huvo un error al modificar datos';
   }
}

function traerClientes($serviciosReferencias) {
   $res = $serviciosReferencias->traerClientes();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
   array_push($ar, $row);
   }
   $resV['datos'] = $ar;
   header('Content-type: application/json');
   echo json_encode($resV);
}




/* Fin */

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];

	echo $serviciosUsuarios->login($email,$pass);
}

function registrarme($serviciosUsuarios, $serviciosReferencias, $serviciosValidador) {
   $error = '';

   $email      = trim($_POST['email']);
   $pass       = trim($_POST['pass']);
   $apellido   = trim($_POST['apellido']);
   $nombre     = trim($_POST['nombre']);
   $telefono   = trim($_POST['telefono']);
   $celular    = trim($_POST['celular']);
   $cuit       = trim($_POST['cuit']);

   $aceptaterminos   = $_POST['aceptaterminos'];
   $subscripcion     = $_POST['subscripcion'];

   $existeEmail = $serviciosUsuarios->existeUsuario($email);
   $existeCliente = $serviciosReferencias->existeCliente($cuit);

   if ($existeEmail == 1) {
      $error .= 'El Email ingresado ya existe!
      ';
   }

   if ($existeCliente == 1) {
      $error .= 'El DNI ingresado ya existe!
      ';
   }

   if ($aceptaterminos == 0) {
      $error .= 'Debe Aceptar los Terminos y Condiciones
      ';
   }

   if ($error == '') {
      // todo ok
      $res = $serviciosReferencias->insertarClientes($apellido,$nombre,$cuit,$telefono,$celular,$email,$aceptaterminos,$subscripcion,0);

      // empiezo la activacion del usuarios
      $resActivacion = $serviciosUsuarios->registrarSocio($email, $pass, $apellido, $nombre, $res);

      if ((integer)$resActivacion > 0) {

         echo '';
      } else {
         echo 'Huvo un error al insertar datos ';
      }
   } else {
      // error
      echo $error;
   }
}


function devolverImagen($nroInput) {

	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }

	  $datos = getimagesize($tmp_name);

	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);
}


?>
