<?php

if(isset($_POST['cadastrarAdministrador']))
{
	$name = obrigatorio("Nome", addslashes($_POST['name']));
	$login = obrigatorio("Login", addslashes($_POST['login']));
	$password = obrigatorio("Senha", addslashes(md5($_POST['password'])));

	global $obrigatorio;
	print_r($obrigatorio);
	if(empty($obrigatorio))
	{
		if(verificaCadastro("administrador", "administrador_name", $name)) 
		{
			if(verificaCadastro("administrador", "administrador_login", $login)) 
			{
				if(cadastrarAdministrador(array("name" => $name, "login" => $login, "password" => $password))) 
				{
					$mensagem = "Administrador cadastrado com sucesso!";
				}
				else
				{
					$erro = "Erro ao cadastrar administrador!";
				}
			}
			else
			{
				$erro = "Esse login de administrador já existe!";
			}
		}
		else
		{
			$erro = "Esse nome de administrador já existe!";
		}
	}
	else
	{
		$erro = $obrigatorio;
	}
	
}

?>
<div class="formularioCadastro">
	<h2>: .CADASTRAR ADMINISTRADOR.:</h2>

	<div class="formCadastro">
		<form action="" method="POST">
			<label for="name">Nome:</label>
			<input type="text" name="name" class="txt_field"></input> *
			<label for="login">Login:</label>
			<input type="text" name="login" class="txt_field"></input> *
			<label for="password">Senha:</label>
			<input type="text" name="password" class="txt_field"></input> *
			<label for="submit"></label>
			<input type="submit" name="cadastrarAdministrador" class="bt_submit" value="cadastrar"></input>
		</form>
	</div>



	<div class="obrigatorio">* campos obrigatórios</div>
	<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
	<?php
		if(isset($erro))
		{
			echo '<br /><p>Por favor, preencha os seguintes campos:</p><br />';
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
				echo $erro;
			}
		}
	?>
