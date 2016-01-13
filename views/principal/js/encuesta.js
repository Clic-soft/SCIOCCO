
	function realizar_votacion(idrespuesta){		
		var votores = '&votores=' + idrespuesta;
		
        $.post(_ruta_ + 'principal/realizarvotacion', votores , function(data) {
			
            $("#zonaencuesta").html('');
            $("#zonaencuesta").html(data);
        });
	}