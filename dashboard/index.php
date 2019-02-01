<?php

session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/base.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Dashboard",$_SESSION['refroll_sahilices'],'');

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "";

$plural = "";

$eliminar = "";

$insertar = "";

//$tituloWeb = "Gestión: Talleres";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////


if ($_SESSION['idroll_sahilices'] == 3) {
	$idcliente = $_SESSION['idcliente'];
	$resCliente = $serviciosReferencias->traerClientesPorId($idcliente);
} else {
	$cabeceras 		= "	<th>Apellido y Nombre</th>
					<th>Categoria</th>
					<th>Año</th>
					<th>Mes</th>";

	$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerArchivosGrid(),89);
}


///////////////////////////              fin                   ////////////////////////

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $tituloWeb; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <?php echo $baseHTML->cargarArchivosCSS('../'); ?>

	 <!-- CSS file -->
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">

	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../css/easy-autocomplete.themes.min.css">



	 <!-- Morris Chart Css-->
    <link href="../plugins/morrisjs/morris.css" rel="stylesheet" />

	 <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

	 <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />

	 <link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

    <style>
        .alert > i{ vertical-align: middle !important; }
    </style>

</head>

<body class="theme-indigo">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Cargando...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="Ingrese palabras...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <?php echo $baseHTML->cargarNAV($breadCumbs); ?>
    <!-- #Top Bar -->
    <?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], str_replace('..','../dashboard',$resMenu),'../'); ?>

    <section class="content" style="margin-top:-35px;">

		<div class="container-fluid">
			<!-- Widgets -->
			<div class="row clearfix">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php if ($_SESSION['idroll_sahilices'] == 1) { ?>
						<h3>Buscar Clientes</h3>
						<?php } else { ?>
						<h3>Cliente</h3>

						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php if ($_SESSION['idroll_sahilices'] == 1) { ?>
	        	<div class="form-group col-md-12">
                     <h4>Busqueda por Nombre Completo o CUIT</h4>


					<input id="lstjugadores" style="width:75%;">


					<div id="selction-ajax" style="margin-top: 10px;"></div>
                </div>

                <div class="form-group col-md-12">
                    <div class="cuerpoBox" id="resultadosJuagadores">

                    </div>

                    <div class="cuerpoBox" id="resultadosArchivos">

                    </div>
                </div>

                <div class="form-group col-md-12">
                	<div class="panel panel-primary">
					  <div class="panel-heading">Archivos</div>
					  <div class="panel-body">
						  <table id="example" class="display table " style="width:100%">
							  <thead>
								  <tr>
									  <th>Apellido y Nombre</th>
									  <th>Categoria</th>
									  <th>Año</th>
									  <th>Mes</th>
									  <th>Acciones</th>
								  </tr>
							  </thead>
							  <tfoot>
								  <tr>
									  <th>Apellido y Nombre</th>
									  <th>Categoria</th>
									  <th>Año</th>
									  <th>Mes</th>
									  <th>Acciones</th>
								  </tr>
							  </tfoot>
						  </table>
					  </div>
					</div>

                </div>
                <?php } else { ?>
                <ul class="list-group">
	              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Cliente - (<span style="color:#F00;">*</span> Datos No editables)</li>
	              <li class="list-group-item list-group-item-default">Apellido: <input type="text" class="form-control sinborde" name="apellido" id="apellido" value="<?php echo mysql_result($resCliente,0,'apellido'); ?>" /></li>
	              <li class="list-group-item list-group-item-default">Nombre: <input type="text" class="form-control sinborde" name="nombre" id="nombre" value="<?php echo mysql_result($resCliente,0,'nombre'); ?>" /></li>
	              <li class="list-group-item list-group-item-default"><span style="color:#F00;">*</span> DNI: <input type="text" class="form-control sinborde" name="cuit" id="cuit" value="<?php echo mysql_result($resCliente,0,'cuit'); ?>" /></li>

	              <li class="list-group-item list-group-item-default">Tel. Fijo: <input type="text" class="form-control sinborde" name="telefono" id="telefono" value="<?php echo mysql_result($resCliente,0,'telefono'); ?>" /></li>
	              <li class="list-group-item list-group-item-default">Tel. Movil: <input type="text" class="form-control sinborde" name="celular" id="celular" value="<?php echo mysql_result($resCliente,0,'celular'); ?>" /></li>
	              <li class="list-group-item list-group-item-default"><span style="color:#F00;">*</span> Email: <?php echo mysql_result($resCliente,0,'email'); ?></li>
	              <li class="list-group-item list-group-item-default">
	                <ul class="list-inline">
	                    <li>Modificar Cliente:</li>
	                    <li><button type="button" class="btn btn-warning" id="modificarCliente" style="margin-left:0px;">Modificar</button></li>
	                    <li id="mensaje"></li>
	                </ul>
	              </li>
	            </ul>

	            <div class="cuerpoBox" id="resultadosArchivos">

                </div>

                <?php } ?>
					</div>
				</div>

			</div>
		</div>


    </section>

	 <!-- ELIMINAR -->
		 <form class="formulario" role="form" id="sign_inEliminar">
			 <div class="modal fade" id="lgmEliminar" tabindex="-1" role="dialog">
				  <div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							 <div class="modal-header">
								  <h4 class="modal-title" id="largeModalLabel">ELIMINAR <?php echo strtoupper($singular); ?></h4>
							 </div>
							 <div class="modal-body">
										  <p>¿Esta seguro que desea eliminar el registro?</p>
										  <small>* Si este registro esta relacionado con algun otro dato no se podría eliminar.</small>
							 </div>
							 <div class="modal-footer">
								  <button type="button" class="btn btn-danger waves-effect eliminar">ELIMINAR</button>
								  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
							 </div>
						</div>
				  </div>
			 </div>
			 <input type="hidden" id="accion" name="accion" value="eliminarArchivos" />
			 <input type="hidden" name="ideliminar" id="ideliminar" value="0">
		 </form>


    <?php echo $baseHTML->cargarArchivosJS('../'); ?>

	 <script src="../js/jquery.easy-autocomplete.min.js"></script>

	 <script src="../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>



    <script>
        $(document).ready(function(){
			  var options = {

				url: "../json/jsbuscarclientes.php",

				getValue: function(element) {
					return element.apellido + ' ' + element.nombre + ' ' + element.cuit;
				},

				ajaxSettings: {
			        dataType: "json",
			        method: "POST",
			        data: {
			            busqueda: $("#lstjugadores").val()
			        }
			    },

			    preparePostData: function (data) {
			        data.busqueda = $("#lstjugadores").val();
			        return data;
			    },

				list: {
				    maxNumberOfElements: 15,
					match: {
						enabled: true
					},
					onClickEvent: function() {
						var value = $("#lstjugadores").getSelectedItemData().id;

						$("#selction-ajax").html('<button type="button" class="btn btn-warning varClienteModificar" id="' + value + '" style="margin-left:0px;"><span class="glyphicon glyphicon-pencil"></span> Modificar</button> \
							<button type="button" class="btn btn-info varClienteArchivos" id="' + value + '" style="margin-left:0px;"><span class="glyphicon glyphicon-download-alt"></span> Cargar Archivos</button> \
						<button type="button" class="btn btn-success varClienteDocumentaciones" id="' + value + '" style="margin-left:0px;"><span class="glyphicon glyphicon-file"></span> Archivos</button>');
					}
				},
				theme: "square"
			};

		$("#lstjugadores").easyAutocomplete(options);

		function traerArchivos(id) {
			$.ajax({
				data:  {id: id, accion: 'traerArchivosPorCliente'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {

				},
				success:  function (response) {
						$('#resultadosArchivos').html(response);

				}
			});
		}


		<?php if ($_SESSION['idroll_sahilices'] == 3) { ?>
		function modificarCliente(id, apellido, nombre, cuit, direccion, telefono, celular) {
			$.ajax({
				data:  {id: id,
						apellido: apellido,
						nombre: nombre,
						cuit: cuit,
						direccion: direccion,
						telefono: telefono,
						celular: celular,
						accion: 'modificarClientePorCliente'},
				url:   '../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {

				},
				success:  function (response) {
					if (response == '') {
						$('#mensaje').html('<span style="color:#05E98D;">Se actualizaron sus datos</span>');
					} else {
						$('#mensaje').html('<span style="color:#E90C05;">'+ response + '</span>');
					}


				}
			});
		}

		$('#modificarCliente').click(function() {
			modificarCliente(<?php echo $idcliente; ?>, $('#apellido').val(), $('#nombre').val(), $('#cuit').val(), $('#direccion').val(), $('#telefono').val(), $('#celular').val());
		});


			traerArchivos(<?php echo $idcliente; ?>);
		<?php } ?>

		function frmAjaxEliminar(id) {
			$.ajax({
				url: '../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarArchivos', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
						swal({
								title: "Respuesta",
								text: "Registro Eliminado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmEliminar').modal('toggle');
						table.ajax.reload();
					} else {
						swal({
								title: "Respuesta",
								text: data,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});

					}
				},
				//si ha ocurrido un error
				error: function(){
					swal({
							title: "Respuesta",
							text: 'Actualice la pagina',
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});

				}
			});

		}

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});


		$('#selction-ajax').on("click",'.varClienteDocumentaciones', function(){
		    usersid =  $(this).attr("id");
		    traerArchivos(usersid);
		});//fin del boton eliminar

		$('#selction-ajax').on("click",'.varClienteModificar', function(){
			  usersid =  $(this).attr("id");
			  if (!isNaN(usersid)) {

				url = "clientes/modificar.php?id=" + usersid;
				$(location).attr('href',url);
			  } else {
				alert("Error, vuelva a realizar la acción.");
			  }
		});//fin del boton eliminar

		$('#selction-ajax').on("click",'.varClienteArchivos', function(){
			  usersid =  $(this).attr("id");
			  if (!isNaN(usersid)) {

				url = "clientes/archivos.php?id=" + usersid;
				$(location).attr('href',url);
			  } else {
				alert("Error, vuelva a realizar la acción.");
			  }
		});//fin del boton eliminar




		var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];


		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../json/jstablasajax.php?tabla=archivos",
			"language": {
				"emptyTable":     "No hay datos cargados",
				"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
				"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
				"infoFiltered":   "(filtrados del total de _MAX_ filas)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Mostrar _MENU_ filas",
				"loadingRecords": "Cargando...",
				"processing":     "Procesando...",
				"search":         "Buscar:",
				"zeroRecords":    "No se encontraron resultados",
				"paginate": {
					"first":      "Primero",
					"last":       "Ultimo",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});

		$("#example").on("click",'.vardescargar', function(){
			usersid =  $(this).attr("id");

			url = "descargar.php?token=" + usersid;
			$(location).attr('href',url);

		});//fin del boton modificar

		$("#example").on("click",'.btnDescargar', function(){
			usersid =  $(this).attr("id");
			window.open("descargar.php?token=" + usersid ,'_blank');

		});//fin del boton modificar

   });
   </script>



</body>
<?php } ?>
</html>
