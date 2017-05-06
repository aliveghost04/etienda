<?php
	
	include("template.php");

	$template = new Template();
	$template->title("Iniciar Sesión");
	
	if (isset($_SESSION['loged'])) {
		header("location: {$_SESSION['url']}");
	}

	if (isset($_POST['Usuario']) && isset($_POST['Password'])) {
		
		if (isset($_POST['url'])) $url = urldecode($_POST['url']);
		$user = $_POST["Usuario"];
		$password = md5($_POST["Password"]);
		$sql = "SELECT id, nombre, apellido, usuario, contrasena FROM usuarios WHERE usuario = '$user'";
		$resultado = mysqli_query(Conexion::obtenerConexion(), $sql);
		
		$row = mysqli_fetch_array($resultado);

		if ($row != null) {
			$userDB = $row['usuario'];
			$passwordDB = $row['contrasena']; 
		} else {
			$userDB = null;
			$passwordDB = null;
		}

		if ($user == $userDB && $password == $passwordDB) {
			
			$_SESSION["user"] = $user;
			$_SESSION["fname"] = $row['nombre'];
			$_SESSION["lname"] = $row['apellido'];
			$_SESSION["loged"] = true;
			$_SESSION["userid"] = $row['id'];
			if (isset($_SESSION['url']))
				header("location: {$_SESSION['url']}");
			else if (isset($url))
				header("location: {$url}");
			else header("location: index.php");
		} else {
			if (isset($_SESSION['url'])) {
				if ($_SESSION['url'] != null) {
					header("location: {$_SESSION['url']}");
					setcookie("login", false, time() + 10);
				} 
			} else if (isset($url)){
				header("location: {$url}");
				setcookie("login", false, time() + 10);
			} else {
				setcookie("login", false, time() + 10);
			}
		}
	} else if (isset($_SESSION['loged'])) header("location: index.php"); 

?>
<fieldset class="text-center">
	<legend><h3>Iniciar Sesi&oacute;n</h3></legend>
	<form class="form-horizontal" role="form" action="login.php" method="post" onSubmit="return validarPagLogin();">
		<div class="row">
			<div class="col-xs-4"></div>
			<div class="form-group col-xs-4">
				<div class="form-group">
					<label class="control-label" for="UsuarioP">Identif&iacute;quese</label>
					<input class="form-control" type="text" id="UsuarioP" name="Usuario" placeholder="Usuario"/>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" id="PasswordP" name="Password" placeholder="Contrase&ntilde;a"/> 
				</div>
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="Iniciar Sesi&oacute;n"/> <br>
				</div>
				<div class="row">
					<?php 
					echo "<div class=\"col-xs-12 text-center alert alert-danger ";
					if (isset($_COOKIE['login'])) { 
						if ($_COOKIE['login'] == false) 
							echo 'show';
					} else {
						echo 'hide';
					}

					echo "\" id=\"infoLogin\">*Usuario y/o Contrase&ntilde;a incorrectos</div>";
					?>
				</div>
			</div>
		</div>
	</form>
	<h5>No estas registrado ? <a href="register.php">Registrate</a></h5>
</fieldset>