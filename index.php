<?php
	include("template.php");
	$template = new Template();

	$template->title("Inicio");
	
	echo "
	<legend>
		<ul class=\"nav nav-tabs nav-pills nav-justified\">
			<li class=\"active\"><a href=\"index.php\"><span class=\"glyphicon glyphicon-home\">&nbsp;</span>Inicio</a></li>
			<li><a href=\"categories.php\">Productos</a></li>
			<li><a href=\"about.php\">Sobre Nosotros</a></li>
		</ul>
	</legend>
	";

	$template->pagination("");

	$query = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, precio, imagen, c.nombre 
			  FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) LIMIT 0, 9";

	$resultado = mysqli_query(Conexion::obtenerConexion(), $query) 
								or exit(mysqli_error(Conexion::obtenerConexion()));
	echo '<div class="row">';
	while ($row = mysqli_fetch_array($resultado)) {
		echo "<div class='col-sm-6 col-md-4'>
		    <div class='thumbnail'>
		      <a href='categories.php?cat=$row[nombre]&fab=$row[fabricante]&id=$row[id]'><img src='$row[imagen]' style='height: 270px;'></a>
		      <div class='text-center'>
		        <h4>$row[nombreproducto]</h4>
		        <p>Estado: $row[estado]</p>
		        <p>Tipo: $row[nombre]</p>
		        <p>Precio: RD$ $row[precio]</p>
		        <a href='categories.php?cat=$row[nombre]&fab=$row[fabricante]&id=$row[id]' class='btn btn-primary' role='button'>Mas detalles</a>
		      </div>
		    </div>
		  </div>";
	}
?>