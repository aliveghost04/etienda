<div class="text-right">
	<div class="form-group nav navbar-nav">
		<form class="form-inline" role="form" action="login.php" method="post" onSubmit="return validarLogin();">
			<input type="hidden" name="url" value="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>"/>
			<label class="control-label" for="Usuario">Identif&iacute;quese</label>
			<input class="form-control" type="text" id="Usuario" name="Usuario" placeholder="Usuario"/>
			<input class="form-control" type="password" id="Password" name="Password" placeholder="Contrase&ntilde;a"/> 
			<input class="btn btn-primary" type="submit" value="Iniciar Sesi&oacute;n"/> <br>
			<div class="row">
				<div class="col-xs-6"></div>
				<div class="col-xs-6 text-center alert alert-danger <?php if (isset($_GET['login'])) { if ($_GET['login'] == "failed") echo 'show';} else echo 'hide';?>" id="infoLogin">*Usuario y/o Contrase&ntilde;a incorrectos</div>
			</div>
		</form>
	</div>
	<h5 class="text-right">
		No estas registrado ? <a href="register.php">Registrate</a>
	</h5>
</div>