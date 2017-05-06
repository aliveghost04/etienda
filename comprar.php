<?php 
	require("template.php");

	$template = new Template();
	$template->title("Comprar");

?>
	<li class='active'>Comprar</li>
	</ol>
	<h3 class="text-center">Procesando pedido...</h3>
	<div id="contbarrapro" class="progress progress-striped active">
		<div id="barrapro" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">Esperando...</div>
	</div>
	<?php 
		if (isset($_POST['usuario_vende']) && isset($_POST['usuario_compra']) && isset($_POST['id_producto']) && isset($_POST['cantidad']) && isset($_POST['total'])) {
			echo "<script>document.getElementById('barrapro').innerHTML = 'Espere...'</script>";
			$resultado = mysqli_query($conexion, "SELECT cantidad FROM productos WHERE id = '$_POST[id_producto]'");
			$row = mysqli_fetch_array($resultado);
			$cantidad = $row['cantidad'];
			$cantidad = $cantidad - $_POST['cantidad'];
			$resultado = mysqli_query($conexion, "SELECT id FROM usuarios WHERE usuario = '$_POST[usuario_compra]'");
			$row = mysqli_fetch_array($resultado);
			$usuariocompra = $row['id'];

			if ($cantidad >= 0) {
				$query = "set AUTOCOMMIT=0;";
				mysqli_query($conexion, $query);

				$query = "INSERT INTO transacciones VALUES(NULL, '$_POST[usuario_vende]', 
						  										 '$usuariocompra', 
						  										 '$_POST[id_producto]', 
						  										  now(),
						  										  now(), 
						  										 '$_POST[cantidad]', 
						  										 '$_POST[total]', 
						  										 '0')";
				
				mysqli_query($conexion, $query);
				$lastid = mysqli_insert_id($conexion);

				$query = "UPDATE productos SET cantidad ='$cantidad' WHERE id = '$_POST[id_producto]';";
				$resultado = mysqli_query($conexion, $query);
				
				if ($resultado) {
					$query = "COMMIT;";
					mysqli_query($conexion, $query);
				}  else {
					$query = "ROLLBACK;";
					mysqli_query($conexion, $query);
				}
				$query = "set AUTOCOMMIT=1;";
				mysqli_query($conexion, $query);

				echo "<div class='row'>
					  	<div class='col-xs-3'></div>
						  <div class='col-xs-6 text-center alert alert-success'>
							<p>Producto Comprado satisfactoriamente. Gracias por realizar su compra.</p>
							Puede ver mas detalles <a href='details.php?id=$lastid'>Aqui</a> o si desea puede <a href='index.php'>realizar otra compra.</a>
						  </div>
						</div>
					  </div>
					  <script>
					  		document.getElementById('barrapro').innerHTML = 'Finalizado';
					  		document.getElementById('contbarrapro').className = 'progress';
					  		document.getElementById('barrapro').className = 'progress-bar progress-bar-success';
					  </script>";

			} else {
				echo "<div class='row'>
					<div class='col-xs-4'></div>
					<div class='alert alert-danger text-center'>Error al realizar la transaccion<br>Intente nuevamente</div>
				<div>
				<div class='text-center' style='color: #FF0000;'>Seras redireccionado automaticamente, sino haz clic <a href='$_GET[url]&fab=$_GET[fab]&id=$_GET[id]'>aqu&iacute;</a></div><br>";

				header("refresh:10; url=$_GET[url]&fab=$_GET[fab]&id=$_GET[id]");
			}

		} else { 

			$query = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, p.descripcion, precio, 
					  cantidad, fecha_publicacion, u.nombre as nombrevendedor, u.apellido, u.id as usuariovende, imagen, c.nombre 
					  FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) JOIN usuarios u ON (p.id_usuario_vende = u.id)
					  WHERE p.id = '$_GET[id]'";

			$resultado = mysqli_query(Conexion::obtenerConexion(), $query);

			if ($row = mysqli_fetch_array($resultado)) imprimirProducto($row);
		}
		function imprimirProducto($row) {
			$total = $row['precio'] * $_GET['cant'];
			echo "<div class='container'>
					<h3>$row[nombreproducto]</h3>
					<div class='row'>
						<img class='thumbnail col-xs-4' src='$row[imagen]'>
						<div class='col-xs-5'>
							<h5><strong>Estado del articulo:</strong> $row[estado]</h5>
							<p><strong>Descripci&oacute;n:</strong> $row[descripcion]</p>
							<p><strong>Autor: </strong>$row[fabricante]</p>
							<p><strong>Vendedor: </strong> $row[nombrevendedor] $row[apellido]</p>
							<p>&nbsp;</p>
							<div class='row'>
								<div class='col-xs-6 form-inline'>
									<strong>Cantidad: </strong>
									<span class='form-control' style='width: 50px;'>$_GET[cant]</span>
								</div>
								<div class='col-xs-6'><strong>Precio Total: </strong>RD$ $total</div>
							</div>
							<form action='' method='post'>
								<input type='hidden' name='total' value='$total'>
								<input type='hidden' name='cantidad' value='$_GET[cant]'>
								<input type='hidden' name='id_producto' value='$_GET[id]'>
								<input type='hidden' name='usuario_compra' value='$_SESSION[user]'>
								<input type='hidden' name='usuario_vende' value='$row[usuariovende]'>
								<div class='text-center'>
									<p>&nbsp;</p>
									<input class='btn btn-success' type='submit' value='Procesar Pedido'>
									<p>&nbsp;</p>
								</div>
							</form>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
						</div>
					</div>
				  </div>";
		}
	?>