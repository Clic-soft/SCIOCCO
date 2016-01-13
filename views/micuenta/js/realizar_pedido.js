$(document).ready(function() {

    if ($('#domicilio').val() == 1) {
        $('#direc').show();
        $('#direccion').show();
        $('#centro').hide();
        $('#cc').hide();
		$('#ciu').show();
		$('#ciudad').show();
    } else if ($('#domicilio').val() == 2) {
        $('#direc').hide();
        $('#direccion').hide();
        $('#centro').hide();
        $('#cc').hide();
		$('#ciu').show();
		$('#ciudad').show();
    } else if ($('#domicilio').val() == 3) {
        $('#direc').show();
        $('#direccion').show();
        $('#centro').show();
        $('#cc').show();
		$('#ciu').show();
		$('#ciudad').show();
    } else {
        $('#direc').hide();
        $('#direccion').hide();
        $('#centro').hide();
        $('#cc').hide();
		$('#ciu').show();
		$('#ciudad').show();
    }
    
    $('#domicilio').change(function() {
        if ($('#domicilio').val() == 1) {
            $('#direc').show();
        	$('#direccion').show();
        	$('#centro').hide();
        	$('#cc').hide();
			$('#ciu').show();
		$('#ciudad').show();
        } else if ($('#domicilio').val() == 2) {
            $('#direc').hide();
        	$('#direccion').hide();
        	$('#centro').hide();
        	$('#cc').hide();
			$('#ciu').show();
		$('#ciudad').show();
        } else if ($('#domicilio').val() == 3) {
            $('#direc').show();
        	$('#direccion').show();
        	$('#centro').show();
        	$('#cc').show();
			$('#ciu').show();
		$('#ciudad').show();
        } else {
            $('#direc').hide();
        	$('#direccion').hide();
        	$('#centro').hide();
        	$('#cc').hide();
			$('#ciu').show();
		$('#ciudad').show();
        }

    });

});