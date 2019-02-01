<?php

date_default_timezone_set('America/Buenos_Aires');

class appconfig {

function conexion() {

		$hostname = "localhost";
		$database = "riderz";
		$username = "root";
		$password = "";

/*
		$hostname = "localhost";
		$database = "u235498999_rider";
		$username = "u235498999_rider";
		$password = "rhcp7575RD";
		//u235498999_kike usuario
*/

		$conexion = array("hostname" => $hostname,
						  "database" => $database,
						  "username" => $username,
						  "password" => $password);

		return $conexion;
}

}




?>
