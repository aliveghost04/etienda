<?php
	require("lib/conexionDB.php");
	
	class Template {

		var $url;
		var $userid;

		function head($title) {
			?>
		    <!DOCTYPE html>
			<html>
			 	<head>
			 		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
			 		<meta charset="UTF-8">
			 		<title><?php echo $title;?> - **E-Tienda** Tu Tienda Favorita</title>
			 		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>css/bootstrap.css">
					<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL;?>css/bootstrap-theme.css">
			 		<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery-2.1.1.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL;?>js/Validaciones.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL;?>js/bootstrap.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL;?>js/codes.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL;?>js/javascripts.js"></script>
			 		<link rel="shortcut icon" href="<?php echo SITE_URL;?>images/favicon/shopping_cart.png">
			 	</head>
			<?php	
		}
		
		function __construct() {
			session_start();
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$this->url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			if (isset($_SESSION["userid"])) {
				$this->userid = $_SESSION["userid"];
			} else {
				$this->userid = 0;
			}
		}

		function requireIdentified() {
			if (!isset($_SESSION['loged'])) {
				$_SESSION['url'] = $this->url;
				header("location: login.php");
			}
		}

		function title($title) {
			$this->head($title);
			echo "<body class=\"container\">";
			$this->header();
		}

		function header() {
			echo "
			<header>
				<nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\">
				  <div class=\"container\">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class=\"navbar-header\">
				      <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">
				        <span class=\"sr-only\">Toggle navigation</span>
				        <span class=\"icon-bar\"></span>
				        <span class=\"icon-bar\"></span>
				        <span class=\"icon-bar\"></span>
				      </button>
				      <a class=\"navbar-brand\" href=\"index.php\">E-Tienda</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
				      <ul class=\"nav navbar-nav\">
				       <li class=\"dropdown\">
				          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <b class=\"caret\"></b></a>
				          <ul class=\"dropdown-menu\">
				            <li><a href=\"#\">Action</a></li>
				            <li><a href=\"#\">Another action</a></li>
				            <li><a href=\"#\">Something else here</a></li>
				            <li class=\"divider\"></li>
				            <li><a href=\"#\">Separated link</a></li>
				            <li class=\"divider\"></li>
				            <li><a href=\"#\">One more separated link</a></li>
				          </ul>
				        </li>
				      </ul>
				      <form action=\"categories.php\" class=\"navbar-form navbar-left\" role=\"search\" onSubmit=\"return validarBusqueda();\">
				        <div class=\"form-group has-feedback\">
				          <label class=\"\" for=\"search\">&nbsp;</label>
				          <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" placeholder=\"Busqueda\">
				          <span class=\"glyphicon glyphicon-search form-control-feedback\"></span>
				        </div>
				        <input id=\"searchb\" type=\"submit\" class=\"btn btn-info prueba\" value=\"Buscar\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"*Introduzca el articulo que desea buscar\">
				      </form>
				      <ul class=\"nav navbar-nav navbar-right\">
				        <li>";
				        if (isset($_SESSION["loged"])) {
				        	$this->identified();
				        } else {
				        	$this->notidentified();
				        }
				        echo"  
				        </li>
				      </ul>
				    </div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>

				<a href=\"index.php\"><h1 class=\"center-block\">E-Tienda <br> <small>Donde encuentras todo lo que necesitas</small></h1></a>
			</header>";
		}

		function identified() {
			echo "
			<div class=\"nav navbar-nav\"> 
				<h5>
					Usuario Identificado <strong>{$_SESSION['fname']} {$_SESSION['lname']}</strong>
					<span class=\"dropdown\">
						<button class=\"btn btn-primary has-feedback\" data-toggle=\"dropdown\" href=\"#\">
							( {$_SESSION['user']} )<span class=\"glyphicon glyphicon-chevron-down\"></span>
						</button>
						<ul class=\"dropdown-menu\">
							<li class=\"dropdown-header\">Compras</li>
							<li><a href=\"details.php\">Mis compras realizadas</a></li>
							<li><a href=\"user.php?id={$this->userid}\">Mis art&iacute;culos en venta</a></li>
							<li><a href=\"article.php\">Vender un art&iacute;culo</a></li>
							<li class=\"divider\"></li>
							<li class=\"dropdown-header\">Cuenta</li>
							<li><a href=\"logout.php?url={$this->url}\">Cerrar Sesi&oacute;n</a></li>
						</ul>
					</span>
					<a href=\"cart.php\">
						<div class=\"form-group btn btn-success\"> 
							Carrito de compras
							<span class=\"glyphicon glyphicon-shopping-cart\"></span>
						</div>
					</a>
				</h5>
			</div>";
		} 

		function notidentified() {
			$protocol = PROTOCOL;
			echo "
			<div class=\"text-right\">
				<div class=\"form-group nav navbar-nav\">
					<form class=\"form-inline\" role=\"form\" action=\"login.php\" method=\"post\" onSubmit=\"return validarLogin();\">
						<input type=\"hidden\" name=\"url\" value=\"$protocol{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}\"/>
						<label class=\"control-label\" for=\"Usuario\">Identif&iacute;quese</label>
						<input class=\"form-control\" type=\"text\" id=\"Usuario\" name=\"Usuario\" placeholder=\"Usuario\"/>
						<input class=\"form-control\" type=\"password\" id=\"Password\" name=\"Password\" placeholder=\"Contrase&ntilde;a\"/> 
						<input class=\"btn btn-primary\" type=\"submit\" value=\"Iniciar Sesi&oacute;n\"/> <br>
						<div class=\"row\">
							<div class=\"col-xs-6\"></div>
							<div class=\"col-xs-6 text-center alert alert-danger ";
							if (isset($_COOKIE['login'])) { 
								if ($_COOKIE['login'] == false) 
									echo 'show';
							} else {
								echo 'hide';
							}

							echo "\" id=\"infoLogin\">*Usuario y/o Contrase&ntilde;a incorrectos</div>
						</div>
					</form>
				</div>
				<h5 class=\"text-right\">
					No estas registrado ? <a href=\"register.php\">Registrate</a>
				</h5>
			</div>";
		}

		function __destruct() {
			echo
			"		<footer>
						<div class=\"text-center\">
							&copy; 2014 Todos los derechos reservados. <br>
							Creador <a href=\"http://facebook.com/erick.jimenez.eldiro\" target=\"_blank\">Erick Jim&eacute;nez</a> <br>
							Hosted by <a href=\"http://vlexofree.com\" target=\"_blank\">VlexoFree Hosting</a>
						</div>
					</footer>
				</body>
			 </html>";
		}

		function pagination($var) {
			if ($var == "Categorias") {
			echo "
			<ol class=\"breadcrumb\">
				<li><a href=\"index.php\">E-Tienda</a></li>";
				if (isset($_GET['id'])) {
					$resultado = mysqli_query(Conexion::obtenerConexion(), "SELECT nombre FROM productos WHERE id = '$_GET[id]'");
					if ($row = mysqli_fetch_array($resultado)) {
						$producto = $row['nombre'];
					} else $producto = "";
					echo "<li><a href='categories.php'>Categorias</a></li>
					      <li><a href='categories.php?cat={$_GET['cat']}'>$_GET[cat]</a></li>
					      <li><a href='categories.php?cat=$_GET[cat]&fab=$_GET[fab]'>$_GET[fab]</a></li>
					      <li class='active'>{$producto}</li>";
				} else if (isset($_GET['cat']) && !isset($_GET['fab']) && !isset($_GET['id'])) 
					echo "<li><a href='categories.php'>Categorias</a></li>
					      <li class='active'>{$_GET['cat']}</li>";
				else if (!isset($_GET['cat']))
					echo "<li class='active'>Categorias</li>";
				else if (isset($_GET['cat']) && isset($_GET['fab']) && !isset($_GET['id']))
					echo "<li><a href='categories.php'>Categorias</a></li>
					      <li><a href='categories.php?cat={$_GET['cat']}'>{$_GET['cat']}</a></li>
					      <li class='active'>{$_GET[fab]}</li>";
				echo "</ol>";
			} else if (is_array($var)) {
				if (isset($_GET['id'])) {
					
				}

			} else if($var != "Categorias" && $var != "Comprar") {
				echo "
					<ol class=\"breadcrumb\">
						<li><a href=\"index.php\">E-Tienda</a></li>
						<li class=\"active\">{$var}</li>
					</ol>
				";
			} else {
				echo "
					<ol class=\"breadcrumb\">
						<li class=\"active\"><a href=\"index.php\">E-Tienda</a></li>
					</ol>
				";
			}
		}

		function navigation() {
			echo "
			<legend>
				<ul class=\"nav nav-tabs nav-pills nav-justified\">
					<li><a href=\"index.php\"><span class=\"glyphicon glyphicon-home\">&nbsp;</span>Inicio</a></li>
					<li><a href=\"categories.php\">Productos</a></li>
					<li><a href=\"about.php\">Sobre Nosotros</a></li>
				</ul>
			</legend>
			";
		}

		function imprimirCarrito($row) {
			echo "<div class=\"row\">
					<div class=\"thumbnail col-xs-12\">
						<div class='col-xs-3'>
							<a href='categories.php?cat=$row[categoria]&fab=$row[fabricante]&id=$row[id_producto]'>
								<img class='thumbnail' src='$row[imagen]' title='$row[nombreproducto]' alt='$row[nombreproducto]'>
							</a>
						</div>
						<div class='col-xs-9'>
							<div class='row'>
								<a href='categories.php?cat=$row[categoria]&fab=$row[fabricante]&id=$row[id_producto]'><h3 class='text-center'>$row[nombreproducto]</h3></a>
								<div class='col-xs-6'>
									<p><strong>Fecha de agregaci&oacute;n:</strong> $row[fecha_agregado]</p>
									<div class='form-inline form-group'>
										<strong>Cantidad de articulos: </strong>
										<span class='form-control'>$row[cantidad]</span>
									</div>
									<p><strong>Precio: </strong> RD$ $row[precio_total]</p>
								</div>
							</div>
						</div>
					</div>
				  </div>";
		}

		function imprimirProductos($row) {
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
									<a class='btn btn-success' href='article.php?id=$row[id]'>Editar</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				 </div>";
		}

		function imprimirProductosCategoria($row) {
			echo "<div class='col-sm-6 col-md-4'>
			    <div class='thumbnail'>
			      <a href='categories.php?cat=$row[nombre]&fab=$row[fabricante]&id=$row[id]'><img src='$row[imagen]' style='height: 270px;'></a>
			      <div class='text-center'>
			        <h4>$row[nombreproducto]</h4>
			        <p>Estado: $row[estado]</p>
			        <p>Precio: RD$ $row[precio]</p>
			        <a href='categories.php?cat=$row[nombre]&fab=$row[fabricante]&id=$row[id]' class='btn btn-primary' role='button'>Mas detalles</a>
			      </div>
			    </div>
			  </div>";
		}

	}