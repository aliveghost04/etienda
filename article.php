<?php
	require("lib/conexionDB.php");
	require("lib/identity.php");

	if (isset($_GET['id']) && isset($_GET['url'])) {

		$query = "SELECT * FROM productos WHERE id = '$_GET[id]'";
		$row = mysqli_fetch_array(mysqli_query($conexion, $query));

		$query = "SELECT id FROM usuarios WHERE usuario = '$_SESSION[user]'";
		$row2 = mysqli_fetch_array(mysqli_query($conexion, $query));
		$tmpurl = urlencode($_GET["url"]);
		echo "<form action='article.php?edit=true' id='formulario' method='post'>
				<input type='hidden' name='url' value='$tmpurl'>
				<input type='hidden' name='name' value='$row[nombre]'>
				<input type='hidden' name='condition' value='$row[estado]'>
				<input type='hidden' name='description' value='$row[descripcion]'>
				<input type='hidden' name='fab' value='$row[fabricante]'>
				<input type='hidden' name='clasificacion' value='$row[clasificacion]'>
				<input type='hidden' name='price' value='$row[precio]'>
				<input type='hidden' name='quantity' value='$row[cantidad]'>
				<input type='hidden' name='userid_vendor' value='$row[id_usuario_vende]'>
				<input type='hidden' name='pubdate' value='$row[fecha_publicacion]'>
				<input type='hidden' name='category' value='$row[id_categoria]'>
			  </form>
			  <script>document.getElementById('formulario').submit();</script>";
	}

	$query = "SELECT id FROM usuarios WHERE usuario = '$_SESSION[user]'";
	$row = mysqli_fetch_array(mysqli_query($conexion, $query));
	
	if (isset($_POST['userid_vendor']) && isset($_POST['url'])) {
		if ($row["id"] != $_POST["userid_vendor"]) {
			header("location: user.php?permission=none&url=$_POST[url]");
		}
	} else if (isset($_POST['type'])) {

		$query = "SELECT nombre FROM categorias WHERE id = '$_POST[category]'";
		$row2 = mysqli_fetch_array(mysqli_query($conexion, $query));

		$nombre = $_FILES["img"]["name"];

		if ($_POST['type'] == "add") {
			$ruta = "categories/$row2[nombre]/$nombre";
			move_uploaded_file($_FILES['img']['tmp_name'], $ruta );
			$query = "INSERT INTO productos VALUES (null, '$_POST[name]', '$_POST[condition]', '$_POST[description]', '$_POST[fab]', '$_POST[clasificacion]', 
													'$_POST[price]', '$_POST[quantity]', now(), '$row[id]', '$_POST[category]', '$ruta')";
			mysqli_query($conexion, $query) or exit (mysqli_error($conexion));
		} else if ($_POST['type'] == "edit" && $_POST['id']) {
			
			if (isset($_FILES['img'])) {
				$ruta = "categories/$row2[nombre]/$nombre";
				$query = "UPDATE productos SET nombre = '$_POST[name]', estado = '$_POST[condition]', descripcion = '$_POST[description]', 
											fabricante = '$_POST[fab]', clasificacion = '$_POST[clasification]', precio = '$_POST[price]', 
											cantidad = '$_POST[quantity]', fecha_publicacion = '$_POST[pubdate]', id_usuario_vende = '$row[id]', 
											id_categoria = '$_POST[category]', imagen = '$ruta' WHERE id = '$_POST[id]')";
			} else {
				$query = "UPDATE productos SET nombre = '$_POST[name]', estado = '$_POST[condition]', descripcion = '$_POST[description]', 
											fabricante = '$_POST[fab]', clasificacion = '$_POST[clasification]', precio = '$_POST[price]', 
											cantidad = '$_POST[quantity]', fecha_publicacion = '$_POST[pubdate]', id_usuario_vende = '$row[id]', 
											id_categoria = '$_POST[category]' WHERE id = '$_POST[id]')";
			}

			mysqli_query($conexion, $query) or exit (mysqli_error($conexion));
		
		}
		header("location: categories.php");
	}
 ?>
 <html>
 <head>
 	<title><?php if(isset($_GET['edit'])) echo "Editando Articulo "; else echo "Agregar Articulo ";?> - **E-Tienda** Tu tienda favorita</title>
 	<?php include("lib/head.php");?>
 </head>
 <body class="container">
 	<header>
 		<?php include("lib/header.php");
 			include("lib/nav.php");
 		?>
 	</header>
 	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4">
		 	<h2><?php if(isset($_GET['edit'])) echo "Editando Articulo"; else echo "Agregar Articulo";?></h2>
		 	<?php ?>
		 	<form method="post" enctype="multipart/form-data">
		 		<input type="hidden" name="type" value="<?php if(isset($_GET['edit'])) echo "edit"; else echo "add";?>">
		 		<input type="hidden" name="id" value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>">
		 		<input class="form-control" type="text" id="name" name="name" placeholder="Nombre del Articulo" value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>"><br>
		 		<input class="form-control" type="text" id="condition" name="condition" placeholder="Condicion del Articulo" value="<?php if(isset($_POST["condition"])) echo $_POST["condition"];?>"><br>
		 		<input class="form-control" type="text" id="fab" name="fab" placeholder="Fabricante del Articulo" value="<?php if(isset($_POST["fab"])) echo $_POST["fab"];?>"><br>
		 		<input class="form-control" type="text" id="clasificacion" name="clasificacion" placeholder="Clasificacion del Articulo" value="<?php if(isset($_POST["clasificacion"])) echo $_POST["clasificacion"];?>"><br>
		 		<input class="form-control" type="text" id="price" name="price" placeholder="Precio del Articulo" onKeyPress="validarTelefono();" value="<?php if(isset($_POST["price"])) echo $_POST["price"];?>"><br>
		 		<input class="form-control" type="text" id="quantity" name="quantity" placeholder="Cantidad del Articulo" value="<?php if(isset($_POST["quantity"])) echo $_POST["quantity"];?>"><br>
		 		<input class="form-control" type="date" id="pubdate" name="pubdate" placeholder="Fecha Publicacion" value="<?php if(isset($_POST["pubdate"])) echo $_POST["pubdate"];?>" <?php if(!isset($_POST["pubdate"])) echo "disabled";?>><br>
		 		<select class="form-control" name="category">
		 			<option value="-1">Seleccione</option>
		 			<?php
		 				$resultado = mysqli_query($conexion, "SELECT id, nombre FROM categorias");
		 				while($row = mysqli_fetch_array($resultado)) {
		 					if (isset($_POST["category"]) == $row['id'])
		 						echo "<option value='$row[id]' selected>$row[nombre]</option>"; 
		 					else echo "<option value='$row[id]'>$row[nombre]</option>";
		 				}
		 				
		 			?>
		 		</select><br>
		 		<input class="form-control" type="file" id="img" name="img"><br>
		 		<textarea rows="5" cols="60" id="description" name="description" placeholder="Escribe una breve descripcion del articulo"><?php if(isset($_POST["description"])) echo $_POST["description"];?></textarea><br><br>
		 		<input class="btn" type="submit" value="<?php if(isset($_GET['edit'])) echo "Editar Articulo"; else echo "Agregar Articulo";?>">
		 	</form>
		 </div>
	</div>
 	<?php include("lib/footer.php");?>
 </body>
 </html>