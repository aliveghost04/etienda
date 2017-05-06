function rellenarSelect(cantidad) {
	if (cantidad == 0) {
		document.write("<option>Articulo agotado</option>");
	} else {
		document.write("<option value='0'>Seleccione</option>");
		for (var x = 1; x <= cantidad; x++) 
				if (x == 1) document.write("<option value='" + x + "' selected>" + x + "</option>");
				else document.write("<option value='" + x + "'>" + x + "</option>");
	}
}