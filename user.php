<?php
	require("template.php");

	if(isset($_GET['edit'])) 
		$title = "Editando Usuario "; 
	else $title = "Mostrando Usuario";

	$template = new Template();
	$template->title($title);
	$template->requireIdentified();
	

	if (isset($_GET['permission']) && isset($_GET['url'])) {
		if ($_GET['permission'] == "none" ) 
			echo "<div class='text-center alert alert-danger'><strong>Usted no tiene permiso para editar este articulo</strong><br>
					Si no eres redireccionado automaticamente, haz clic <a href='$_GET[url]'><strong>aqu&iacute;</strong></a>
				 </div>";
		header("refresh:5; url=$_GET[url]");
	} else if (isset($_GET['id'])) {
		$query = "SELECT p.id, p.nombre as nombreproducto, p.cantidad, fabricante, estado, p.precio, p.descripcion, fecha_publicacion, 
				  u.nombre as nombrevendedor, u.apellido, u.id as usuariovende, imagen, c.nombre as categoria
			  FROM productos p JOIN usuarios u ON ( p.id_usuario_vende = u.id ) JOIN categorias c ON (p.id_categoria = c.id) 
			  WHERE p.id_usuario_vende = '$_GET[id]'";
		$resultado = mysqli_query(Conexion::obtenerConexion(), $query);
		while ($row = mysqli_fetch_array($resultado)) imprimirProductos($row, $_GET['id'], $template->url);
	}

	function imprimirProductos($row, $userid, $url) {
		echo "<div class='row'>
				<div class='thumbnail'>
					<div class='row'>
						<div class='col-xs-3'>
							<a href='categories.php?cat=$row[categoria]&fab=$row[fabricante]&id=$row[id]'><img class='thumbnail' src='$row[imagen]' title='$row[nombreproducto]' alt='$row[nombreproducto]' style='width: 100%; height: 300px'></a>
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
									<p><strong>Precio: </strong> RD$ $row[precio]</p>
								</div>
								<div class='col-xs-6'>
								<a class='btn btn-success' href='article.php?id=$row[id]&url=$url'>Editar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			 </div>";
	}
?>