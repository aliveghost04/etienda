function validarLogin() {
	var usuario = document.getElementById('Usuario').value;
	var password = document.getElementById('Password').value;

	if (usuario.length == 0 && password.length == 0) {
		document.getElementById('infoLogin').innerHTML = "<div class='alert alert-danger'>*Debe llenar los campos</div>";
		return false;
	}

	if (usuario.length == 0) {
		document.getElementById('infoLogin').innerHTML = "<div class='alert alert-danger'>*Campo usuario vacio</div>";
		return false;
	} else {
		document.getElementById('infoLogin').innerHTML = "";
	}

	if (password.length == 0) {
		document.getElementById('infoLogin').innerHTML = "<div class='alert alert-danger'>*Campo contraseña vacio</div>";
		return false;
	} else {
		document.getElementById('infoLogin').innerHTML = "";
	}

	return true;
}

function validarPagLogin() {
	var usuario = document.getElementById('UsuarioP').value;
	var password = document.getElementById('PasswordP').value;

	if (usuario.length == 0 && password.length == 0) {
		document.getElementById('infoLoginP').innerHTML = "<div class='alert alert-danger'>*Debe llenar los campos</div>";
		return false;
	}

	if (usuario.length == 0) {
		document.getElementById('infoLoginP').innerHTML = "<div class='alert alert-danger'>*Campo usuario vacio</div>";
		return false;
	} else {
		document.getElementById('infoLoginP').innerHTML = "";
	}

	if (password.length == 0) {
		document.getElementById('infoLoginP').innerHTML = "<div class='alert alert-danger'>*Campo contraseña vacio</div>";
		return false;
	} else {
		document.getElementById('infoLoginP').innerHTML = "";
	}

	return true;
}

function validarCantidad() {
	var cantidad = document.getElementById('cantidad').value;

	if (cantidad == "0") {
		alert("Seleccione la cantidad del articulos deseado");
		return false;
	}

	document.getElementById('comprar').href += "&cant=" + cantidad;
	return true;
}

function validarBusqueda() {
	var busqueda = document.getElementById('search').value;

	if(busqueda.length == 0) {
		return false;
	} 

	return true;
}

function validarRegistro() {

	var fname = document.getElementById('fname').value;
	var lname = document.getElementById('lname').value;
	var phone = document.getElementById('phone').value;
	var address = document.getElementById('address').value;
	var user = document.getElementById('user').value;
	var password = document.getElementById('password').value;
	var confirmPassword = document.getElementById('confirmPassword').value;

	if (fname.length == 0 && lname.length == 0 && address.trim().length == 0 && phone.length == 0 && user.length == 0 && password.length == 0 && confirmPassword.length == 0) {
		document.getElementById('infoGeneral').innerText = "*Debe llenar todos los campos";
		return false;
	} else {
		document.getElementById('infoGeneral').innerText = "";
	}

	if (fname.length == 0) {
		document.getElementById('infoFname').innerText = "*Debe introducir su nombre";
		return false;
	} else {
		document.getElementById('infoFname').innerText = "";
	}

	if (lname.length == 0) {
		document.getElementById('infoLname').innerText = "*Debe introducir su apellido";
		return false;
	} else {
		document.getElementById('infoLname').innerText = "";
	}

	if (phone.length == 0) {
		document.getElementById('infoPhone').innerText = "*Debe introducir un telefono";
		return false;
	} else {
		document.getElementById('infoPhone').innerText = "";
	}

	if (address.trim().length == 0) {
		document.getElementById('infoAddress').innerText = "*Debe introducir su direccion";
		return false;
	} else {
		document.getElementById('infoAddress').innerText = "";
	}

	if (user.length == 0) {
		document.getElementById('infoUser').innerText = "*Debe introducir un nombre de usuario";
		return false;
	} else {
		document.getElementById('infoUser').innerText = "";
	}

	if (password.length == 0) {
		document.getElementById('infoPassword').innerText = "*Debe introducir una contraseña";
		return false;
	} else {
		document.getElementById('infoPassword').innerText = "";
	}

	if (confirmPassword.length == 0) {
		document.getElementById('infoConfirmPassword').innerText = "*Debe repetir tu contraseña";
		return false;
	} else {
		document.getElementById('infoConfirmPassword').innerText = "";
	}

	if (password != confirmPassword) {
		document.getElementById('infoConfirmPassword').innerText = "*Las contraseñas no coinciden";
		return false;
	} else {
		document.getElementById('infoConfirmPassword').innerText = "";
	}

	if (password.length < 6) {
		document.getElementById('infoPassword').innerText = "*La contraseña debe tener al menos 6 caracteres";
		return false;
	} else {
		document.getElementById('infoPassword').innerText = "";
	}

	return true;
}

function redireccionar() {
	var ubicacion = document.getElementById('categories').value;
	
	if (ubicacion == "Seleccione") {
		return false;
	}

	location.href="categories.php?cat=" + ubicacion;
}

function redireccionarAutor(url) {
	var ubicacion = document.getElementById('fab').value;
	
	if (url.indexOf("&fab") != -1) {
		url = url.substring(0, url.indexOf("&fab"));
	}

	if (ubicacion == "") {
		document.getElementById('infoFiltro').innerText = "*Debe escribir el nombre del autor";	
		return false;
	}

	location.href = url + "&fab=" + ubicacion;
}

function validarTelefono() {
	if ((event.keyCode < 48) || (event.keyCode > 57)) 
		event.returnValue = false;
}

function validarArticulo() {
	
}