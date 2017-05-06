<?php
	require("lib/conexionDB.php");
	
?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<title>**E-Tienda** Tu tienda favorita</title>
	<?php include("lib/head.php"); ?>
</head>
<header>
	<?php include("lib/header.php");?>
	<legend>
		<ul class="nav nav-tabs nav-justified nav-pills">
			<li class="active"><a href="#"><span class="glyphicon glyphicon-home">&nbsp;</span>Inicio</a></li>
			<li><a href="categories.php">Productos</a></li>
			<li><a href="about.php">Sobre Nosotros</a></li>
		</ul>
	</legend>
</header>
<body class="container">
	<?php 	
		include("lib/search.php");
	?>
	<ol class="breadcrumb">
		<li class="active">E-Tienda</li>
	</ol>
	
	<br>
	<?php
		$query = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, precio, imagen, c.nombre 
				  FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) LIMIT 0, 9";

		$resultado = mysqli_query($conexion, $query) or exit(mysqli_error($conexion));
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
		echo '</div>';
	?>
</body>
	<?php 
		include("lib/footer.php");
	?>
</html>