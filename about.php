<?php
	include("template.php");

	$template = new Template();
	$template->title("Sobre Nosotros");
	
	echo "<legend>
		<ul class=\"nav nav-tabs nav-pills nav-justified\">
			<li><a href=\"index.php\"><span class=\"glyphicon glyphicon-home\">&nbsp;</span>Inicio</a></li>
			<li><a href=\"categories.php\">Productos</a></li>
			<li class=\"active\"><a href=\"about.php\">Sobre Nosotros</a></li>
		</ul>
	</legend>";

	$template->pagination("Sobre Nosotros");
?>
	<div class="row">
		<div class="container col-xs-4 "></div>
		<div class="thumbnail col-xs-4 text-justify">
			<h3 class="text-center">Sobre Nosotros</h3><br>
			<h4 class="text-center">Quienes somos</h4>

			<p>
				Somos una empresa dedicada al negocio de vender todo tipo de articulos en la web, 
			   buscando así satisfacer las necesidades de nuestros clientes con el  
			   mejor confort y con los más novedosos articulos al mejor precio.
			</p> <br>

			<h4 class="text-center">Visión</h4>

			<p>
				Buscamos ser una empresa pioneras brindando servicios de calidad a nuestros clientes, 
				con una disponibilidad y un personal altamente calificado, servicios las 24 horas del día
			    y los 7 días de la semana, con una amplia gama de articulos, con precios y ofertas inigualados.
			</p><br>

			<h4 class="text-center">Misión</h4>

			<p>
				Buscar satisfacer las necesidades de nuestros clientes, 
				dándoles nuestros mejores precios y las mejores ofertas  
				creando clima de confianza y seguridad a la hora de elegirnos.
			</p><br>
		</div>
	</div>