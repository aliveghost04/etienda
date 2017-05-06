<?php
	require("template.php");

	$template = new Template();
	$template->title("Feedback");
	$template->navigation();
	$template->pagination("Feedback");
		
	if(isset($_POST["usuario_recibe"]) && isset($_POST["usuario_envia"]) && isset($_POST["transid"])) {

		$sql = "SELECT nombre, apellido FROM usuarios WHERE id = '$_POST[usuario_recibe]'";
		$resultado = mysqli_fetch_array(mysqli_query(Conexion::obtenerConexion(), $sql));
		$name = $resultado["nombre"] . " " . $resultado["apellido"];

		echo "<form action='' method='post'>
				<input type='hidden' name='transid' value='$_POST[transid]'>
				<input type='hidden' name='u_recibe' value='$_POST[usuario_recibe]'>
				<input type='hidden' name='u_envia' value='$_POST[usuario_envia]'>
				<div class='container text-center'>
					<h3>Feedbak para el usuario <small>$name</small></h3>
					<div class='form-group form-inline'>
						<label for='calification'>Como calificas tu compra?</label>
						<select class='form-control' name='calification'>
							<option value='0'>Seleccione</option>
							<option value='Pesima'>P&eacute;sima</option>
							<option value='Mala'>Mala</option>
							<option value='Regular'>Regular</option>
							<option value='Buena'>Buena</option>
							<option value='Excelente'>Excelente</option>
						</select>
					</div>
					<div class='row'>
						<div class='col-xs-4'></div>
						<div class='col-xs-4 form-group'>
							<label for='comment'>Comentario</label>
							<textarea class='form-control' rows='5' cols='60' name='comment' id='comment' placeholder='Escribe un comentario' style='resize: none;'></textarea>
						</div>
					</div>
					<input class='btn btn-info' type='submit' value='Enviar Comentario'>
				</div>
			  </form>";

	} else if (isset($_POST["calification"]) && isset($_POST["comment"]) && isset($_POST["u_recibe"]) && isset($_POST["u_envia"]) && isset($_POST["transid"])) {
		
		$query = "set AUTOCOMMIT=0";
		mysqli_query($conexion, $query);

		$query = "UPDATE transacciones SET estado_entrega = '1' WHERE id = $_POST[transid]";
		mysqli_query($conexion, $query);

		$query = "INSERT INTO feedback VALUES (null, '$_POST[u_recibe]', '$_POST[u_envia]', '$_POST[calification]', '$_POST[comment]')";
		mysqli_query($conexion, $query);

		$query = "COMMIT";
		$resultado = mysqli_query($conexion, $query);

		if ($resultado) {
			echo "<div class='row'>
				<div class='col-xs-4'></div>
				<div class='col-xs-4 text-center alert alert-success'>Feedback enviado correctamente</div>
			  </div>";
		} else {
			echo "<div class='row'>
				<div class='col-xs-4'></div>
				<div class='col-xs-4 text-center alert alert-danger'>Error al intentar enviar el feedback</div>
				  </div>";
		}
		mysqli_query($conexion, "SET AUTOCOMMIT=1");
	} else {
		echo "<div class='row'>
				<div class='col-xs-4'></div>
				<div class='col-xs-4 text-center alert alert-danger'>Error al intentar enviar el feedback</div>
				  </div>";
	}