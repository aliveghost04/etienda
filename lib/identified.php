<?php 
	$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
	$url = urlencode($url);
	$resultado = mysqli_fetch_array(mysqli_query($conexion, "SELECT id FROM usuarios WHERE usuario = '$_SESSION[user]'"));
	$userid = $resultado['id'];
?>

<div class="nav navbar-nav"> 
	<h5>
		Usuario Identificado <strong> <?php echo $_SESSION['fname'].' '.$_SESSION['lname']?> </strong>
		<span class="dropdown">
			<button class="btn btn-primary has-feedback" data-toggle="dropdown" href="#">
				<?php echo ' ( '.$_SESSION['user'].' ) ';?><span class="glyphicon glyphicon-chevron-down"></span>
			</button>
			<ul class="dropdown-menu">
				<li class="dropdown-header">Compras</li>
				<li><a href="details.php">Mis compras realizadas</a></li>
				<li><a href="user.php?id=<?php echo $userid;?>">Mis art&iacute;culos en venta</a></li>
				<li><a href="article.php">Vender un art&iacute;culo</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo "logout.php?url=$url";?>">Cerrar Sesi&oacute;n</a></li>
			</ul>
		</span>
	</h5>
</div>