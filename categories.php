<?php
	include("template.php");

	if(isset($_GET['cat'])) {
		$title = $_GET['cat']; 
	} else {
		$title = "Categorias";
	}

	if (isset($_GET['id'])) {
		$sql = "SELECT nombre FROM productos WHERE id = '{$_GET['id']}'";
		echo $sql. '<br>';
		$result = mysqli_query(Conexion::obtenerConexion(), $sql) or die(mysqli_error(Conexion::obtenerConexion()));
		$title = mysqli_fetch_array($result)[0];
	}
	
	$template = new Template();
	$template->title($title);
	?>
	<legend>
		<ul class="nav nav-tabs nav-pills nav-justified">
			<li><a href="<?php echo SITE_URL;?>index/"><span class="glyphicon glyphicon-home">&nbsp;</span>Inicio</a></li>
			<li class="active"><a href="<?php echo SITE_URL;?>categories">Productos</a></li>
			<li><a href="<?php echo SITE_URL;?>about">Sobre Nosotros</a></li>
		</ul>
	</legend>
<?php
	$template->pagination("Categorias");
?>
	<div class="row form-group">
		<div class="dropdown col-xs-4">
			<button class="dropdown-toggle btn-default btn col-xs-8" data-toggle="dropdown">Categorias <span class="glyphicon glyphicon-chevron-down"></span></button>
			<ul class="dropdown-menu">
				<?php
					$sql = "SELECT nombre FROM categorias";
					$resultado = mysqli_query(Conexion::obtenerConexion(), $sql);
					while ($row = mysqli_fetch_array($resultado)) {
						echo "<li><a href=\"categories.php?cat={$row['nombre']}\">{$row['nombre']}</a></li>";
					}
				?>
			</ul>
		</div>
		<?php 
		if (isset($_GET['cat'])){
			echo 
		"<div class=\"col-xs-5 form-inline\">
			 <div class=\"form-group\">
				<div class=\"form-group\">
					<div class=\"form-group has-feedback\">
						<label for=\"fab\">Autor: </label>
						<input class=\"form-control\" type=\"text\" id=\"fab\" name=\"fab\" value=\"";
							if (isset($_GET['fab'])) echo $_GET['fab']; 
							
							echo "\" placeholder=\"Filtrar por Autor\">
						<span class=\"glyphicon glyphicon-user form-control-feedback\"></span>
					</div>
					<div class=\"alert-danger\" id=\"infoFiltro\"></div>
				</div>
				<div class=\"form-group\">
					<a class=\"btn btn-info\" onClick=\"redireccionarAutor('$template->url');\">Aplicar Filtro</a>
				</div>
			</div>
		</div>";
		}?>
		
	</div>

	<?php
		if (isset($_GET['cat']) || isset($_GET['search'])) {

			if (isset($_GET['cat'])) $cat = $_GET['cat'];
			else $cat = "";
			if (isset($_GET['fab'])) $fab = $_GET['fab'];
			else $fab = "";
			if (isset($_GET['search'])) $search = $_GET['search'];
			else $search = "";
			
			if (isset($_GET['id'])) {
				$query = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, p.descripcion, precio, 
						  cantidad, fecha_publicacion, u.nombre as nombrevendedor, u.apellido, imagen, c.nombre 
						  FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) JOIN usuarios u ON (p.id_usuario_vende = u.id)
						  WHERE c.nombre like '%$cat%' and fabricante like '%$fab%' and p.id = '$_GET[id]'";

				$resultado = mysqli_query(Conexion::obtenerConexion(), $query);
				echo "<div class='row'>";
				if ($row = mysqli_fetch_array($resultado)) {
					imprimirDetallesProductos($row, $template->url);
				} else echo "<div class='alert alert-danger'>El producto no fue encontrado</div>";
				echo "</div>";

			} else {
				$query = "SELECT p.id, p.nombre as nombreproducto, fabricante, estado, precio, imagen, c.nombre 
						  FROM productos p JOIN categorias c ON ( p.id_categoria = c.id ) 
						  WHERE c.nombre like '%$cat%' and fabricante like '%$fab%' and p.nombre like '%$search%'";

				$resultado = mysqli_query(Conexion::obtenerConexion(), $query);
				echo "<div class='row'>";
				if ($row = mysqli_fetch_array($resultado)) {
					$template->imprimirProductosCategoria($row);
					while ($row = mysqli_fetch_array($resultado)) $template->imprimirProductosCategoria($row);
				} else echo "<div class='alert alert-danger'>No hay productos de este tipo</div>";
				echo "</div>";
			}

		} else {
			$query = "SELECT nombre, descripcion FROM  categorias";
			$resultado = mysqli_query(Conexion::obtenerConexion(), $query);
			echo "<div class='row'>";
			if ($row = mysqli_fetch_array($resultado)) {
				imprimirCategorias($row);
				while ($row = mysqli_fetch_array($resultado)) imprimirCategorias($row);
			} else echo "<div class='alert alert-danger'>No hay categorias de productos</div>";
			echo "</div>";
		}

		function imprimirCategorias($row) {
			echo "<div class='col-sm-6 col-md-4'>
				    <div class='thumbnail text-center'>
				      <a href='categories.php?cat=$row[nombre]'><h4>$row[nombre]</h4></a>
				      <p>$row[descripcion]</p>
				    </div>
			      </div>";
		}

		function imprimirDetallesProductos($row, $url) {
			$tmpurl = urlencode($url);
			echo "<div class='row container'>
					<h3>$row[nombreproducto]</h3>
					<div class='row'>
						<img class='thumbnail col-xs-4' src='$row[imagen]'>
						<div class='col-xs-5'>
							<div class='row'>
								<span class='col-xs-4'><span class='form-inline form-group'><strong>Cantidad: </strong>
								<span class='form-control' style='width: 50px;'>$row[cantidad]</span></span></span>
								<span class='col-xs-8'><strong>Fecha de publicaci&oacute;n: </strong>$row[fecha_publicacion]</span>
							</div>
							<h5><strong>Estado del articulo:</strong> $row[estado]</h5>
							<p><strong>Descripci&oacute;n:</strong> $row[descripcion]</p>
							<p><strong>Autor: </strong>$row[fabricante]</p>
							<p><strong>Vendedor: </strong> $row[nombrevendedor] $row[apellido]</p>
							<div class='row'>
								<div class='col-xs-6'></div>
								<div class='col-xs-6'><strong>Precio: </strong>RD$ $row[precio]</div>
							</div>
							<p>&nbsp;</p>
							<div class='row'>
								<div class='col-xs-5 form-inline'>
									<strong>Cantidad: </strong>
									<select style='width: 70px;' id='cantidad' name='cantidad' class='form-control'>
										<script>rellenarSelect($row[cantidad]);</script>
									</select>
								</div>
								<div class='col-xs-4'>
									<a onClick='return validarCantidad();' class='btn btn-success' id='comprar' style='width: 200px;' href='cart.php?id={$row['id']}'>A&ntilde;adir al carrito</a>
									<p>&nbsp;</p>
									<p>&nbsp;</p>
								</div>
							</div>
						</div>
					</div>
				  </div>";
		}
?>