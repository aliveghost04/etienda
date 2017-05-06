<?php 
	require("template.php");
	$template = new Template();
	$title = $_SESSION['fname'] ." ". $_SESSION['lname'] . " (" . $_SESSION['user'] . ") ";
	$template->title($title);
	$template->navigation();
	$template->pagination($title);
	
	$lastbuy = false;
	if (isset($_GET['id'])) {
		$query = "SELECT p.id, t.id as tranid, p.nombre as nombreproducto, fabricante, estado, p.descripcion, t.total, t.fecha_venta, t.hora_venta,
				  t.cantidad, t.estado_entrega, fecha_publicacion, u.nombre as nombrevendedor, u.apellido, u.id as usuariovende, imagen, c.nombre as categoria
				  FROM transacciones t JOIN usuarios u ON ( t.id_usuario_compra = u.id ) JOIN productos p ON (p.id = t.id_producto)
				  JOIN categorias c ON (p.id_categoria = c.id) WHERE t.id_usuario_compra = '$userid' and t.id = '$_GET[id]'";
		$lastbuy = true; 
	} else {
		$query = "SELECT p.id, t.id as tranid, p.nombre as nombreproducto, fabricante, estado, p.descripcion, t.total, t.fecha_venta, t.hora_venta,
				  t.cantidad, t.estado_entrega, fecha_publicacion, u.nombre as nombrevendedor, u.apellido, u.id as usuariovende, imagen, c.nombre as categoria
				  FROM transacciones t JOIN usuarios u ON ( t.id_usuario_compra = u.id ) JOIN productos p ON (p.id = t.id_producto)
				  JOIN categorias c ON (p.id_categoria = c.id) WHERE t.id_usuario_compra = '{$template->userid}'";
	}

	$resultado = mysqli_query(Conexion::obtenerConexion(), $query);
	if (mysqli_num_rows($resultado) == 1 && $lastbuy) {
		echo "<script>
				document.getElementById('title').innerHTML = 'Detalles de la ultima compra realizada por el usuario <small>$_SESSION[fname] $_SESSION[lname]</small> (' + 
				'<a href=details.php>Ver todas</a>)';
			  </script>";
		imprimirProductos(mysqli_fetch_array($resultado), $userid);
	} else if (mysqli_num_rows($resultado) == 1) {
		imprimirProductos(mysqli_fetch_array($resultado), $userid);
	}

	if (mysqli_num_rows($resultado) > 1) {
		while ($row = mysqli_fetch_array($resultado)) imprimirProductos($row, $template->userid);
	} else if (mysqli_num_rows($resultado) == 0){
		echo "<div class='alert alert-info text-center'>Al parecer no has comprado ningun producto aun... Mira algunos de nuestros fabulosos especiales <a href='index.php'><h4>aqui</h4></a></div>";
	}

	function imprimirProductos($row, $userid) {
		echo 	"<div class='row'>
					<div class='thumbnail'>
						<div class='row'>
							<div class='col-xs-3'>
								<a href='categories.php?cat=$row[categoria]&fab=$row[fabricante]&id=$row[id]'>
									<img class='img-responsive thumbnail' src='$row[imagen]' title='$row[nombreproducto]' alt='$row[nombreproducto]'>
								</a>
							</div>
							<div class='col-xs-9'>
								<div class='row'>
									<a href='categories.php?cat=$row[categoria]&fab=$row[fabricante]&id=$row[id]'><h3 class='text-center'>$row[nombreproducto]</h3></a>
									<div class='col-xs-6'>
										<p><strong>Fecha de publicacion:</strong> $row[fecha_publicacion]</p>
										<div class='form-inline form-group'><strong>Cantidad de articulos comprados: </strong><span class='form-control'>$row[cantidad]</span></div>
										<p><strong>Estado del articulo: </strong>$row[estado]</p>
										<p><strong>Descripci&oacute;n: </strong>$row[descripcion]</p>
										<p><strong>Autor: </strong>$row[fabricante]</p>
										<p><strong>Vendedor: </strong>$row[nombrevendedor] $row[apellido]</p>
										<p><strong>Total de la compra: </strong> RD$ $row[total]</p>
									</div>
									<div class='col-xs-6'>
										<p><strong>Fecha Compra:</strong> $row[fecha_venta] a las $row[hora_venta]</p>";
										if ($row["estado_entrega"] == 0) echo "
										<form action='feedback.php' method='post'>
											<input type='hidden' name='transid' value='$row[tranid]'>
											<input type='hidden' name='usuario_recibe' value='$row[usuariovende]'>
											<input type='hidden' name='usuario_envia' value='$userid'>
											<input class='btn btn-success' type='submit' value='Reportar articulo recibido'>
										</form>"; 
							  echo "</div>
								</div>
							</div>
						</div>
					</div>
				 </div>";
	}
?>