<?php
	require("template.php");	

	$template = new Template();
	$template->title("Registro");
	$template->navigation();
	$template->pagination("Registro");

	if(isset($_SESSION['loged'])) {
		header("location: index.php");
	}

	if (!empty($_POST['user']) && !empty($_POST['password'])) {
		$password = md5($_POST['password']);
		$sql = "INSERT INTO usuarios VALUES( null,
											'$_POST[fname]',
											'$_POST[lname]',
											'$_POST[phone]',
											'$_POST[user]',
											'$password',
											'2')";
		mysqli_query(Conexion::obtenerConexion(), $sql) or exit(mysqli_error(Conexion::obtenerConexion()));
		header("location: login.php");
	}

?>
<form method="post" onSubmit="return validarRegistro();">
	<fieldset>
		<legend class="text-center"><h2>Registro</h2></legend>
		<div class='row'>
			<div class='col-xs-4'></div>
			<div class="col-xs-4 form-group text-center">
				<div class="form-group">
					<label for="fname">Nombre</label>
					<input class="form-control" type="text" id="fname" name="fname" placeholder="Escribe tu nombre"/>
					<div class='alert-danger' id="infoFname"></div>
				</div>
				<div class="form-group">
					<label for="lname">Apellido</label>
					<input class="form-control" type="text" id="lname" name="lname" placeholder="Escribe tu apellido"/>
					<div class='alert-danger' id="infoLname"></div>
				</div>
				<div class="form-group">
					<label for="phone">Tel&eacute;fono</label>
					<input class="form-control" type="text" id="phone" name="phone" placeholder="Escribe tu telefono" onKeyPress="validarTelefono();"/>
					<div class='alert-danger' id="infoPhone"></div>
				</div>
				<div class="form-group">
					<label for="address">Direcci&oacute;n</label>
					<input class="form-control" type="text" id="address" name="address" placeholder="Escribe tu direccion"/>
					<div class='alert-danger' id="infoAddress"></div>
				</div>
				<div class="form-group">
					<label for="user">Usuario</label>
					<input class="form-control" type="text" id="user" name="user" placeholder="Escribe tu usuario"/>
					<div class='alert-danger' id="infoUser"></div>
				</div>
				<div class="form-group">
					<label for="password">Contrase&ntilde;a</label>
					<input class="form-control" type="password" id="password" name="password" placeholder="Escribe tu contrase&ntilde;a"/>
					<div class='alert-danger' id="infoPassword"></div>
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirma tu Contrase&ntilde;a</label>
					<input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Repite tu contrase&ntilde;a"/>
					<div class='alert-danger' id="infoConfirmPassword"></div>
				</div>
				<div class="form-group">
					<input class="btn btn-success" type="submit" value="Registrarse"/> 
				</div>
				<div class='alert-danger' id="infoGeneral"></div>
			</div>
		</div>
	</fieldset>
</form>