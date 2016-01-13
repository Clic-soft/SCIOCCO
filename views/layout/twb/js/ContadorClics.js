function ContarClics(idseccion){

	var idseccion = '&idseccion=' + idseccion;

	
	$.post(_ruta_ + 'principal/Contador_Clics', idseccion , function(data) {

	});
}
