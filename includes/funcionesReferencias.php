<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {


function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));

	}

	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from images where idfoto =".$id;

		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);
		}
		return $res;
	}


	function existeArchivo($id,$nombre,$type) {
		$sql		=	"select * from images where refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);

			   if(mysql_num_rows($resultado)>0){

				   return mysql_result($resultado,0,0);

			   }

			   return 0;
	}

	function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    $string = str_replace(
        array('(', ')', '{', '}',' '),
        array('', '', '', '',''),
        $string
    );



    return $string;
}

function crearDirectorioPrincipal($dir) {
	if (!file_exists($dir)) {
		mkdir($dir, 0777);
	}
}


	function obtenerNuevoId($tabla) {
        //u235498999_aif
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES
                WHERE TABLE_SCHEMA = 'riderz'
                AND TABLE_NAME = '".$tabla."'";
        $res = $this->query($sql,0);
        return mysql_result($res, 0,0);
    }


	function subirArchivo($file,$carpeta,$id,$token,$observacion, $refcategorias, $anio, $mes) {


		$dir_destino_padre = '../archivos/'.$carpeta.'/';
		$dir_destino = '../archivos/'.$carpeta.'/'.$id.'/';
		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));

		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$id.'/'.'index.php';

		//die(var_dump($dir_destino));
		if (!file_exists($dir_destino_padre)) {
			mkdir($dir_destino_padre, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}


		if(!is_writable($dir_destino)){

			echo "no tiene permisos";

		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					//la carpeta de libros solo los piso
					if ($carpeta == 'galeria') {
						$this->eliminarFotoPorObjeto($id);
					}
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {

						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];

						$filename = $dir_destino.'descarga.zip';
						$zip = new ZipArchive();

						if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
						exit('cannot open <$filename>\n');
						}

						$zip->addFile($dir_destino.$archivo, $archivo);

						$zip->close();

						$this->insertarArchivos($carpeta,$token,str_replace(' ','',$archivo),$tipoarchivo, $observacion, $refcategorias, $anio, $mes);

						echo "";

						copy($noentrar, $nuevo_noentrar);

					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}
	}



	function TraerFotosRelacion($id) {
		$sql    =   "select 'galeria',s.idproducto,f.imagen,f.idfoto,f.type
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}


	function eliminarFoto($id)
	{

		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);

		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}

	function eliminarLibro($id)
	{

		$sql		=	"update dblibros set ruta = '' where idlibro =".$id;
		$res		=	$this->query($sql,0);

		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}


	function eliminarFotoPorObjeto($id)
	{

		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo,f.idfoto
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto =".$id;
		$resImg		=	$this->query($sql,0);

		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo(mysql_result($resImg,0,1),mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}

/* fin archivos */



function zerofill($valor, $longitud){
 $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
 return $res;
}

function existeDevuelveId($sql) {

	$res = $this->query($sql,0);

	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);
	}
	return 0;
}


function descargar($token) {
	session_start();

	if (isset($_SESSION['usua_predio'])) {

		$res = $this->traerArchivosPorToken($token);

		if (mysql_num_rows($res)>0) {
		    $file = '../archivos/'.mysql_result($res, 0,'refcliente').'/'.mysql_result($res, 0,'idarchivo').'/'.mysql_result($res, 0,'imagen');

		    header('Content-type: application/x-rar-compressed');
		    header('Content-length: ' . filesize($file));
		    readfile($file);
		} else {
			echo 'No existe el archivo o fue borrado';
		}

	} else {

	    echo 'No tienes permiso para la descarga';
	}
}



/* PARA Archivos */
function insertarArchivos($refclientes,$token,$imagen,$type,$observacion,$refcategorias,$anio,$mes) {
$sql = "insert into dbarchivos(idarchivo,refclientes,token,imagen,type,observacion, refcategorias, anio, mes)
values ('',".$refclientes.",'".($token)."','".($imagen)."','".($type)."','".($observacion)."',".$refcategorias.",".$anio.",".$mes.")";
$res = $this->query($sql,1);
return $res;
}


function modificarArchivos($id,$refclientes,$token,$imagen,$type,$observacion,$refcategorias,$anio,$mes) {
$sql = "update dbarchivos
set
refclientes = ".$refclientes.",token = '".($token)."',imagen = '".($imagen)."',type = '".($type)."',observacion = '".($observacion)."' ,refcategorias = ".$refcategorias.",anio = ".$anio.",mes = ".$mes."
where idarchivo =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarArchivos($id) {
$sql = "delete from dbarchivos where token = '".$id."'";
$res = $this->query($sql,0);
return $res;
}


function traerArchivos() {
$sql = "select
a.idarchivo,
a.refclientes,
a.token,
a.imagen,
a.type,
a.observacion
from dbarchivos a
order by 1";
$res = $this->query($sql,0);
return $res;
}



function traerArchivosajax($length, $start, $busqueda) {

	$where = '';

	$busqueda = str_replace("'","",$busqueda);
	if ($busqueda != '') {
		$where = "where concat(c.apellido, ' ', c.nombre) like '%".$busqueda."%' or cat.categoria like '%".$busqueda."%' or a.anio like '%".$busqueda."%' or a.mes like '%".$busqueda."%'";
	}

	$sql = "select
   a.token,
   concat(c.apellido, ' ', c.nombre) as apyn,
   cat.categoria,
   a.anio,
   a.mes,
   a.refclientes,
   a.token,
   a.imagen,
   a.type,
   a.observacion
   from dbarchivos a
   inner join dbclientes c on c.idcliente = a.refclientes
   inner join tbcategorias cat on cat.idcategoria = a.refcategorias
	".$where."
	order by a.anio, a.mes
	limit ".$start.",".$length;

	$res = $this->query($sql,0);
	return $res;
}


function traerArchivosGrid() {
$sql = "select
a.token,
concat(c.apellido, ' ', c.nombre) as apyn,
cat.categoria,
a.anio,
a.mes,
a.refclientes,
a.token,
a.imagen,
a.type,
a.observacion
from dbarchivos a
inner join dbclientes c on c.idcliente = a.refclientes
inner join tbcategorias cat on cat.idcategoria = a.refcategorias
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerArchivosPorId($id) {
$sql = "select idarchivo,refclientes,token,imagen,type,observacion from dbarchivos where idarchivo =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerArchivosPorToken($token) {
$sql = "select
a.idarchivo,
a.refclientes,
a.token,
a.imagen,
a.type,
a.observacion,
cat.categoria,
a.anio,
a.mes,
c.apellido,
c.nombre
from dbarchivos a
inner join dbclientes c on c.idcliente = a.refclientes
inner join tbcategorias cat on cat.idcategoria = a.refcategorias
where a.token = '".$token."'";
$res = $this->query($sql,0);
return $res;
}

function traerArchivosPorCliente($idcliente) {
	$sql = "select
a.idarchivo,
cat.categoria,
a.anio,
a.mes,
a.observacion,
a.imagen,
a.refclientes,
a.token,
a.fechacreacion,
a.type
from dbarchivos a
inner join dbclientes c on c.idcliente = a.refclientes
inner join tbcategorias cat on cat.idcategoria = a.refcategorias
where refclientes = ".$idcliente;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* PARA Archivos */


/* PARA Clientes */

function existeCliente($cuit, $modifica = 0, $id = 0) {
   if ($modifica == 1) {
      $sql = "select * from dbclientes where cuit = '".$cuit."' and idcliente <> ".$id;
   } else {
      $sql = "select * from dbclientes where cuit = '".$cuit."'";
   }

	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return true;
	} else {
		return false;
	}
}

function insertarClientes($apellido,$nombre,$cuit,$telefono,$celular,$email,$aceptaterminos,$subscripcion,$activo) {
$sql = "insert into dbclientes(idcliente,apellido,nombre,cuit,telefono,celular,email,aceptaterminos,subscripcion, activo)
values ('','".($apellido)."','".($nombre)."','".($cuit)."','".($telefono)."','".($celular)."','".($email)."',".$aceptaterminos.",".$subscripcion.",".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarClientes($id,$apellido,$nombre,$cuit,$telefono,$celular,$email,$aceptaterminos,$subscripcion, $activo) {
$sql = "update dbclientes
set
apellido = '".($apellido)."',nombre = '".($nombre)."',cuit = '".($cuit)."',telefono = '".($telefono)."',celular = '".($celular)."',email = '".($email)."',aceptaterminos = ".$aceptaterminos.",subscripcion = ".$subscripcion.",activo = ".$activo."
where idcliente =".$id;
$res = $this->query($sql,0);
return $res;
}


function modificarClientePorCliente($id,$apellido,$nombre,$telefono,$celular) {
$sql = "update dbclientes
set
apellido = '".($apellido)."',nombre = '".($nombre)."',telefono = '".($telefono)."',celular = '".($celular)."'
where idcliente =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarClientes($id) {
$sql = "delete from dbclientes where idcliente =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerClientesajax($length, $start, $busqueda) {

	$where = '';

	$busqueda = str_replace("'","",$busqueda);
	if ($busqueda != '') {
		$where = "where c.apellido like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.cuit like '%".$busqueda."%' or c.telefono like '%".$busqueda."%' or c.celular like '%".$busqueda."%' or c.email like '%".$busqueda."%'";
	}

	$sql = "select
   c.idcliente,
   c.apellido,
   c.nombre,
   c.cuit,
   c.telefono,
   c.celular,
   c.email,
   (case when c.aceptaterminos = 1 then 'Si' else 'No' end) as aceptaterminos,
   (case when c.subscripcion = 1 then 'Si' else 'No' end) as subscripcion,
   (case when c.activo = 1 then 'Si' else 'No' end) as activo
   from dbclientes c
	".$where."
	order by c.apellido, c.nombre
	limit ".$start.",".$length;

	$res = $this->query($sql,0);
	return $res;
}


function traerClientes() {
$sql = "select
c.idcliente,
c.apellido,
c.nombre,
c.cuit,
c.telefono,
c.celular,
c.email,
c.aceptaterminos,
c.subscripcion,
(case when c.activo = 1 then 'Si' else 'No' end) as activo
from dbclientes c
order by c.apellido, c.nombre";
$res = $this->query($sql,0);
return $res;
}

function traerClientesActivos() {
$sql = "select
c.idcliente,
c.apellido,
c.nombre,
c.cuit,
c.telefono,
c.celular,
c.email,
c.aceptaterminos,
c.subscripcion,
(case when c.activo = 1 then 'Si' else 'No' end) as activo
from dbclientes c
where c.activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerClientesPorId($id) {
$sql = "select idcliente,apellido,nombre,cuit,telefono,celular,email,aceptaterminos,subscripcion,(case when activo = 1 then 'Si' else 'No' end) as activo from dbclientes where idcliente =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* PARA Clientes */




/* PARA Images */

function insertarImages($refproyecto,$refuser,$imagen,$type,$principal) {
$sql = "insert into images(idfoto,refproyecto,refuser,imagen,type,principal)
values ('',".$refproyecto.",".$refuser.",'".($imagen)."','".($type)."',".$principal.")";
$res = $this->query($sql,1);
return $res;
}


function modificarImages($id,$refproyecto,$refuser,$imagen,$type,$principal) {
$sql = "update images
set
refproyecto = ".$refproyecto.",refuser = ".$refuser.",imagen = '".($imagen)."',type = '".($type)."',principal = ".$principal."
where idfoto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarImages($id) {
$sql = "delete from images where idfoto =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerImages() {
$sql = "select
i.idfoto,
i.refproyecto,
i.refuser,
i.imagen,
i.type,
i.principal
from images i
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerImagesPorId($id) {
$sql = "select idfoto,refproyecto,refuser,imagen,type,principal from images where idfoto =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: images*/


function nuevoBuscador($busqueda) {
$sql = "select
c.idcliente,
c.apellido,
c.nombre,
c.cuit
from dbclientes c
where concat(c.apellido,' ',c.nombre,' ',c.cuit) like '%".$busqueda."%'
order by c.apellido,c.nombre
limit 15";
$res = $this->query($sql,0);
return $res;
}



/* PARA Usuarios */

function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refclientes) {
$sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto,activo,refclientes)
values ('','".($usuario)."','".($password)."',".$refroles.",'".($email)."','".($nombrecompleto)."',".$activo.",".$refclientes.")";
$res = $this->query($sql,1);
return $res;
}


function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refclientes) {
$sql = "update dbusuarios
set
usuario = '".($usuario)."',password = '".($password)."',refroles = ".$refroles.",email = '".($email)."',nombrecompleto = '".($nombrecompleto)."',activo = ".$activo." ,refclientes = ".($refclientes)."
where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarUsuarios($id) {
$sql = "update dbusuarios set activo = 0 where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerUsuarios() {
$sql = "select
u.idusuario,
u.usuario,
u.password,
u.refroles,
u.email,
u.nombrecompleto,
u.refpersonal
from dbusuarios u
inner join tbroles rol ON rol.idrol = u.refroles
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerUsuariosPorId($id) {
$sql = "select idusuario,usuario,password,refroles,email,nombrecompleto,(case when activo = 1 then 'Si' else 'No' end) as activo,refclientes from dbusuarios where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbusuarios*/




/* PARA Predio_menu */

function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso) {
$sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso)
values ('','".($url)."','".($icono)."','".($nombre)."',".$Orden.",'".($hover)."','".($permiso)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso) {
$sql = "update predio_menu
set
url = '".($url)."',icono = '".($icono)."',nombre = '".($nombre)."',Orden = ".$Orden.",hover = '".($hover)."',permiso = '".($permiso)."'
where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPredio_menu($id) {
$sql = "delete from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menu() {
$sql = "select
p.idmenu,
p.url,
p.icono,
p.nombre,
p.Orden,
p.hover,
p.permiso
from predio_menu p
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menuPorId($id) {
$sql = "select idmenu,url,icono,nombre,Orden,hover,permiso from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: predio_menu*/



/* PARA Roles */

function insertarRoles($descripcion,$activo) {
$sql = "insert into tbroles(idrol,descripcion,activo)
values ('','".($descripcion)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarRoles($id,$descripcion,$activo) {
$sql = "update tbroles
set
descripcion = '".($descripcion)."',activo = ".$activo."
where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarRoles($id) {
$sql = "delete from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerRoles() {
$sql = "select
r.idrol,
r.descripcion,
r.activo
from tbroles r
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerRolesPorId($id) {
$sql = "select idrol,descripcion,activo from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbroles*/



/* PARA Categorias */

function insertarCategorias($categoria) {
$sql = "insert into tbcategorias(idcategoria,categoria)
values ('','".($categoria)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCategorias($id,$categoria) {
$sql = "update tbcategorias
set
categoria = '".($categoria)."'
where idcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCategorias($id) {
$sql = "delete from tbcategorias where idcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCategoriasajax($length, $start, $busqueda) {

	$where = '';

	$busqueda = str_replace("'","",$busqueda);
	if ($busqueda != '') {
		$where = "where c.categoria like '%".$busqueda."%'";
	}

	$sql = "select
   c.idcategoria,
   c.categoria
   from tbcategorias c
	".$where."
	order by c.categoria
	limit ".$start.",".$length;

	$res = $this->query($sql,0);
	return $res;
}


function traerCategorias() {
$sql = "select
c.idcategoria,
c.categoria
from tbcategorias c
order by c.categoria";
$res = $this->query($sql,0);
return $res;
}


function traerCategoriasPorId($id) {
$sql = "select idcategoria,categoria from tbcategorias where idcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* PARA Categorias */

/* PARA Configuracion */

function insertarConfiguracion($razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
$sql = "insert into tbconfiguracion(idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email)
values ('','".($razonsocial)."','".($empresa)."','".($sistema)."','".($direccion)."','".($telefono)."','".($email)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarConfiguracion($id,$razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
$sql = "update tbconfiguracion
set
razonsocial = '".($razonsocial)."',empresa = '".($empresa)."',sistema = '".($sistema)."',direccion = '".($direccion)."',telefono = '".($telefono)."',email = '".($email)."'
where idconfiguracion =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarConfiguracion($id) {
$sql = "delete from tbconfiguracion where idconfiguracion =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerConfiguracion() {
$sql = "select
c.idconfiguracion,
c.razonsocial,
c.empresa,
c.sistema,
c.direccion,
c.telefono,
c.email
from tbconfiguracion c
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerConfiguracionPorId($id) {
$sql = "select idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email from tbconfiguracion where idconfiguracion =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbconfiguracion*/



function query($sql,$accion) {



		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];

		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

		mysql_select_db($database);

		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}

}

?>
