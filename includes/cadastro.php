<?php
global $obrigatorio;
if(isset($_POST['cadastrarClient']))
{
	$name = obrigatorio("name", $_POST['name']);
	$city = obrigatorio("city", $_POST['city']);
	$state = obrigatorio("state", $_POST['state']);
	$neighborhood = obrigatorio("neighborhood", $_POST['neighborhood']);
	$cep = obrigatorio("cep", $_POST['cep']);
	$phone = obrigatorio("phone", $_POST['phone']);
	$cellphone = obrigatorio("cellphone", $_POST['cellphone']);
	$email = obrigatorio("email", $_POST['email']);
	$address = obrigatorio("address", $_POST['address']);
	$birthday = obrigatorio("birthday", $_POST['birthday']);
	$login = obrigatorio("login", $_POST['login']);
	$password = obrigatorio("password", $_POST['password']);
	
	// criaSessao("name", $name);
	// criaSessao("city", $city);
	// criaSessao("state", $state);
	// criaSessao("neighborhood", $neighborhood);
	// criaSessao("cep", $cep);
	// criaSessao("phone", $phone);
	// criaSessao("cellphone", $cellphone);
	// criaSessao("email", $email);
	// criaSessao("address", $address);
	// criaSessao("birthday", $birthday);
	// criaSessao("login", $login);
	// criaSessao("password", $password);


	if(!isset($obrigatorio))
	{
		/* FORMATA DATA DE NASCIMENTO */
		$birthday_aux = explode('/', $birthday);
		$birthday = $birthday_aux[2] . "-" . $birthday_aux[1] . "-" . $birthday_aux[0];
		/* FORMATA DATA DE NASCIMENTO */

		if(verificaCadastro('clients', 'client_name', $name))
		{
			if(verificaCadastro('clients', 'client_login', $login))
			{
				$dados = array(
					"name" => $name,
					"city" => $city,
					"state" => $state,
					"neighborhood" => $neighborhood,
					"cep" => $cep,
					"phone" => $phone,
					"cellphone" => $cellphone,
					"email" => $email,
					"address" => $address,
					"birthday" => $birthday,
					"login" => $login,
					"password" => $password
				);
				if(cadastrarClient($dados))
				{
					$mensagem = "Cadastro efetuado com sucesso!";
				}
				else{
					$erro = "Não foi possível efetuar o cadastro";
				}
			}
			else
			{
				$erro = "Já existe um login com esse nome";
			}
		}
		else
		{
			$erro = "Já existe um cliente com esse nome";
		}

		
	}
	else
	{
		$erro = $obrigatorio;
	}
}
else
{

}
?>
<div id="cadastro" class="txt">
	<h1>Cadastro de Cliente</h1>
	<form action="" method="post" id="formularioCadastro">
		<label for="name">Nome:</label>
		<input type="text" name="name" id="name" /> *
		<label for="">Cidade</label>
		<input type="text" name="city" id="city" /> *
		<label for="">Estado</label>
		<input type="text" name="state" id="state" /> *
		<label for="">Bairro</label>
		<input type="text" name="neighborhood" id="neighborhood" /> *
		<label for="">CEP</label>
		<input type="text" name="cep" class="txt_field_menor" id="cep" /> *
		<label for="">Telefone</label>
		<input type="text" name="phone" class="txt_field_menor" id="phone" /> *
		<label for="">Celular</label>
		<input type="text" name="cellphone" class="txt_field_menor" id="cellphone" /> *
		<label for="">Email</label>
		<input type="text" name="email" class="txt_field" id="email" /> *
		<label for="">Endereço</label>
		<input type="text" name="address" class="txt_field_maior" id="address" /> *
		<label for="">Data de Nascimento</label>
		<input type="text" name="birthday" class="txt_field" id="birthday" /> *
		<label for="">Login</label>
		<input type="text" name="login" class="txt_field" id="login"/> *
		<label for="">Senha</label>
		<input type="password" name="password" class="txt_field" id="password"/> *

		<input type="submit" name="cadastrarClient" class="bt_submit" value="cadastrar"></input>
		<input type="button" id="limpar" name="limparCampos" class="bt_submit" value="limpar formulário"></input>
	</form>
	<div class="obrigatorio">* campos obrigatórios</div>
	<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
	<?php
		if(isset($erro))
		{
			echo '<br /><p>Por favor, Corrija os seguintes erros:</p><br />';
			if(is_array($erro))
			{
				foreach ($erro as $err) {
					if(!empty($err))
					{
						echo '<div class=erro>' . $err . '</div><br />';
					}
				}
			}
			else
			{
				echo '<div class=erro>' .$erro. '</div><br />';
			}
		}
		else
		{
			$erro = $obrigatorio;
		}
	?>

</div>