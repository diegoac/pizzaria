$().ready(function() {

	var botaoLimpar = $("#cadastro").find("#limpar");

	// validate signup form on keyup and submit
	$("#formularioCadastro").validate({


		rules: {
			name: "required",
			city: "required",
			state: {
				required: true,
				maxlength: 2
			},

			neighborhood: "required",
			cep: "required",
			phone: {
				digits: true,
				required: true
			},

			cellphone: {
				digits: true,
				required: true
			},

			address: {
				digits: true,
				required: true
			},

			birthday: "required",

			email: {
				required: true,
				email: true
			},
			login: "required",
			password: "required"

		},
		messages: {
			name: "<span>Por favor, digite o seu nome</span>",
			city: "<span>Por favor, preencha o campo cidade</span>",
			state: "<span>Por favor, preencha o campo estado</span>",
			neighborhood: "<span>Por favor, preencha o campo bairro</span>",
			cep: "<span>Por favor, preencha o campo CEP</span>",
			phone: "<span>Por favor, preencha o campo telefone</span>",
			cellphone: "<span>Por favor, preencha o campo celular</span>",
			address: "<span>Por favor, preencha o campo endereço</span>",
			birthday: "<span>Por favor, preencha o campo data de nascimento</span>",
			email: "<span>Por favor, digite um email válido</span>",
			login: "<span>Por favor, digite o campo login</span>",
			password: "<span>Por favor, digite o campo senha</span>"
		}

	});

	botaoLimpar.on('click', function(event){
		event.preventDefault();
		limparFormularioCadastro();
	})
	var limparFormularioCadastro = function(){
		$("#name").val('');
		$("#city").val('');
		$("#state").val('');
		$("#neighborhood").val('');
		$("#cep").val('');
		$("#phone").val('');
		$("#cellphone").val('');
		$("#email").val('');
		$("#address").val('');
		$("#birthday").val('');
		$("#login").val('');
		$("#password").val('');
	}
});