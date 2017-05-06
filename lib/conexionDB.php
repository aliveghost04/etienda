<?php
	require("lib/configuration.php");

	class Conexion {
		
		private static $conexion = null;

		static function obtenerConexion() {
			
			self::$conexion == null ? self::$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or 
					exit ("<div class='alert alert-danger text-center'>Error con la base de datos</div>") : self::$conexion;

			return self::$conexion;
		}

		function __destruct() {
			mysqli_close(Conexion::obtenerConexion());
		}
	}
?>