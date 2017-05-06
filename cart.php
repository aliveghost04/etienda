<?php 
	require("template.php");

	$template = new Template();
	$template->title("Carrito");
	$template->requireIdentified();
	$template->navigation();
	$name = $_SESSION['fname'] ." ". $_SESSION['lname'] ." (". $_SESSION['user'] .") ";
	$array = array($name, "Carrito", "Agregar");
	$template->pagination("arreglar");
	
	if (!empty($_POST['id_producto']) && !empty($_POST['cantidad'])) {
		
		$sql = "SELECT precio FROM productos WHERE id='{$_POST['id_producto']}'";
		$precio = mysqli_fetch_array(mysqli_query(Conexion::obtenerConexion(), $sql))[0];
		$precio = $precio * $_POST['cantidad'];
		
		$sql = "INSERT INTO carrito VALUES('$template->userid',
										   '$_POST[id_producto]',
										   '$_POST[cantidad]',
										    now(),
										   '$precio')";

		mysqli_query(Conexion::obtenerConexion(), $sql);
		$_SESSION['exito'] = true;
		header("location: cart.php");
	}

	if (!isset($_GET['id']) && !isset($_GET['cant'])) {
		if (isset($_SESSION['exito'])) {
			echo 
			"<div class=\"alert alert-success\">
				Producto agregado con exito
			</div>";
			unset($_SESSION['exito']);
		}
		echo "<div class=\"panel panel-info\">
		<div class=\"panel-heading text-center\">
			<h4>
				<strong>Carrito de {$name}</strong>
			</h4>
		</div>
		<div class=\"panel-body\">";

		$sql = "SELECT c.id_producto, p.nombre as nombreproducto, p.fabricante, ca.nombre categoria, p.imagen, c.cantidad, c.fecha_agregado, c.precio_total 
				FROM carrito c JOIN productos p ON(p.id = c.id_producto) JOIN categorias ca ON(ca.id = p.id_categoria)
				WHERE c.id_usuario = '{$template->userid}'";
				 
		$resultado = mysqli_query(Conexion::obtenerConexion(), $sql);
		while ($row = mysqli_fetch_array($resultado))
				$template->imprimirCarrito($row);
		// imprimir las cosas del carrito
		echo "</div>
		</div>";
	}

	if (!isset($_GET['cant'])) {
		return;
	}
	
	
?>
<div class="panel panel-success">
	<div class="panel-heading">
		<h4>¿Desea agregar el siguiente art&iacute;culo a su carrito?</h4>
	</div>
	<div class="panel-body">
		<article>
		<?php
		$sql = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, p.descripcion, precio, 
			    cantidad, fecha_publicacion, u.nombre as nombrevendedor, u.apellido, u.id as usuariovende, imagen, c.nombre 
			    FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) JOIN usuarios u ON (p.id_usuario_vende = u.id)
			    WHERE p.id = '$_GET[id]'";

		$row = mysqli_fetch_array(mysqli_query(Conexion::obtenerConexion(), $sql));
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
							<div class='row'>
								<div class='col-xs-6 form-inline'>
									<strong>Cantidad: </strong>
									<span class='form-control' style='width: 50px;'>$_GET[cant]</span>
								</div>
								<div class='col-xs-6'><strong>Precio Total: </strong>RD$ {$total}</div>
							</div>
						</div>
					</div>
				  </div>";
		?>
	</article>
	</div>
	<div class="panel-footer">
		<form method='post'>
			<input type='hidden' name='cantidad' value='<?php echo $_GET['cant']?>'>
			<input type='hidden' name='id_producto' value='<?php echo $_GET['id']?>'>
			<input type='hidden' name='usuario_compra' value='<?php echo $_SESSION['user']?>'>
			<input type='hidden' name='usuario_vende' value='<?php echo $row['usuariovende']?>'>
			<div class='text-right'>
				<input class='btn btn-success' type='submit' value='Confirmar'>
				<a class="btn btn-danger" href="categories.php?cat=<?php echo $row['nombre'] . "&fab=". $row['fabricante'] . "&id={$_GET['id']}"?>">Cancelar</a>
			</div>
		</form>
	</div>
</div>