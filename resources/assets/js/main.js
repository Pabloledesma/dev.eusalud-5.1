(function(){

	$('form[data-remote]').on('submit', function(e){

		var form 	= $(this),
			method 	= form.find('input[name="_method"]').val() || 'POST',
			url 	= form.prop('action');

		$.ajax({
			type: method,
			url: url,
			data: form.serialize(),
			contentType: "application/json; charset=utf-8",
            dataType: "json",
			success: function(results){
				console.log("Exito");
				console.log(results);
			}
		});

		e.preventDefault();

	});

})();