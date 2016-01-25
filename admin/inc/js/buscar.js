$(document).ready(function(){

	var txt_busca = $("#txt_busca");
	var carregar = $("#carregar");
	var form_busca = $("#form_busca");

	txt_busca.keyup(function(){

		if(txt_busca == "")
		{

		}
		else
		{
			// CARREGA NA PÁGINA INICIAL
			$.ajax({
				type: 'POST',
				url: 'buscar.php',
				data: form_busca.serialize(),
				success: function(data) {
					carregar.html(data);
				}
			});
		}

	});

});