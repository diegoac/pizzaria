<?php

unset($_SESSION);
if(isset($_POST['cadastrarClient']))
{

	$name = obrigatorio("Nome", addslashes($_POST['name']));
	$city = obrigatorio("Cidade", addslashes($_POST['city']));
	$state = obrigatorio("Estado", addslashes($_POST['state']));
	$neighborhood = obrigatorio("Bairro", addslashes($_POST['neighborhood']));
	$cep = obrigatorio("CEP", addslashes($_POST['cep']));
	validarCep($_POST['cep']);
	$phone = obrigatorio("Telefone", addslashes($_POST['phone']));
	validarTelefone($phone);
	$cellphone = obrigatorio("Celular", addslashes($_POST['cellphone']));
	//validarCelular($celular);
	$address = obrigatorio("Endereço", addslashes($_POST['address']));
	$login = obrigatorio("Login", addslashes($_POST['login']));
	$password = obrigatorio("Senha", addslashes($_POST['password']));

	criaSessao("name", $name);
	criaSessao("city", $city);
	criaSessao("state", $state);
	criaSessao("neighborhood", $neighborhood);
	criaSessao("cep", $cep);
	criaSessao("phone", $phone);
	criaSessao("cellphone", $cellphone);
	criaSessao("address", $address);
	criaSessao("login", $login);
	criaSessao("password", $password);

	global $validou;
	global $obrigatorio;

	if(empty($obrigatorio))
	{
		if(empty($validou))
		{
			if(verificaCadastro("clients", "client_name", $name)) 
			{
				if(verificaCadastro("clients", "client_login", $login)) 
				{
					if(cadastrarClient(array(
						"name" => $name,
						"city" => $city,
						"state" => $state,
						"neighborhood" => $neighborhood,
						"cep" => $cep,
						"phone" => $phone,
						"cellphone" => $cellphone,
						"address" => $address,
						"login" => $login,
						"password" => $password
					)))
					{
						$mensagem = "Cliente cadastrado com sucesso!";
					}
					else
					{
						$erro = "Erro ao cadastrar cliente!";
					}
				}
				else
				{
					$erro = "Esse login de cliente já existe!";
				}
			}
			else
			{
				$erro = "Esse nome de cliente já existe!";
			}		
		}
		else
		{
			$erro = $validou;
		}
	}
	else
	{
		$erro = $obrigatorio;	
	}
}

/* PARA LIMPAR CAMPOS */

if(isset($_POST['limparCampos']))
{
	unset($_SESSION);
}

?>
<div class="formularioCadastro">
	<h2>: .CADASTRAR CLIENTE.:</h2>

	<div class="formCadastro">
		<form action="" method="POST">

			<!-- Nome -->
			<label for="name">Nome:</label>
			<input type="text" name="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?>" class="txt_field"></input> *

			<!-- Cidade -->
			<label for="city">Cidade:</label>
			<input type="text" name="city" value="<?php echo isset($_SESSION['city']) ? $_SESSION['city'] : ""; ?>" class="txt_field"></input> *

			<!-- Estado -->
			<label for="state">Estado:</label>
			<input type="text" name="state" value="<?php echo isset($_SESSION['state']) ? $_SESSION['state'] : ""; ?>" class="txt_field_menor"></input> *

			<!-- Bairro -->
			<label for="neighborhood">Bairro:</label>
			<input type="text" name="neighborhood" value="<?php echo isset($_SESSION['neighborhood']) ? $_SESSION['neighborhood'] : ""; ?>" class="txt_field"></input> *

			<!-- CEP -->
			<label for="cep">CEP:</label>
			<input type="text" name="cep" value="<?php echo isset($_SESSION['cep']) ? $_SESSION['cep'] : ""; ?>" class="txt_field_menor"></input> *

			<!-- Telefone -->
			<label for="phone">Telefone:</label>
			<input type="text" name="phone" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ""; ?>" class="txt_field_menor"></input> *

			<!-- Celular -->
			<label for="cellphone">Celular:</label>
			<input type="text" name="cellphone" value="<?php echo isset($_SESSION['cellphone']) ? $_SESSION['cellphone'] : ""; ?>" class="txt_field_menor"></input> *

			<!-- Endereço -->
			<label for="address">Endereço:</label>
			<input type="text" name="address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : ""; ?>" class="txt_field_maior"></input> *

			<!-- Login -->
			<label for="login">Login:</label>
			<input type="text" name="login" value="<?php echo isset($_SESSION['login']) ? $_SESSION['login'] : ""; ?>" class="txt_field"></input> *

			<!-- Senha -->
			<label for="password">Senha:</label>
			<input type="text" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ""; ?>" class="txt_field"></input> *

			<label for="submit"></label>
			<input type="submit" name="cadastrarClient" class="bt_submit" value="cadastrar"></input>
			<input type="submit" name="limparCampos" class="bt_submit" value="limpar campos"></input>
		</form>
	</div>



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
	?>
