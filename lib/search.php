<div class="row">
	<div class="col-xs-8">
		<div class="form-inline">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle col-md-3" type="button" data-toggle="dropdown">Categorias <span class="glyphicon glyphicon-chevron-down"></span></button>
				<ul class="dropdown-menu" role="menu">
					<?php 
						$resultado = mysqli_query($conexion, "SELECT nombre FROM categorias");
						while ($row = mysqli_fetch_array($resultado)) 
							echo "<li><a href='categories.php?cat=$row[nombre]'>$row[nombre]</a></li>";
					?>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-xs-4">
		<form class="form-inline" role="form" action="categories.php" method="get" onSubmit="return validarBusqueda();">
			<div class="form-group">
				<div class="form-group has-feedback">
					<input class="form-control" type="text" id="search" name="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']?>" placeholder="Escribe tu termino de busqueda">
					<div class="glyphicon glyphicon-search form-control-feedback"></div> 
				</div>
				<input class="btn btn-info" type="submit" value="Buscar"/>
			</div>
			<div id="infoSearch"></div>
		</form> <br>
	</div>
</div>