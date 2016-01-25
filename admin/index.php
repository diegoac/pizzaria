<?php

session_start();

include_once 'functions/config/config.php';
try {
	carregaIncludes(array("conexao", "login"), "login");
} catch(Exception $e) {
	echo $e->getMessage();
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['logar']))
	{
		$login = addslashes($_POST['login']);
		$password = addslashes(md5($_POST['password']));

		if(logar($login, $password))
		{
			$_SESSION['logado_admin'] = true;
			header("Location: inc/painel.php");
		}
		else
		{
			$erro = "Usuário ou senha inválidos!";
		}
	}
}

?>

<html>
<head>
	<meta charset=utf-8>
	<title>Painel do Administrador</title>
	<link rel="stylesheet" type="text/css" href="css/style_login.css">
</head>
<body>

	<div id="container">
		<div id="login">
			<div id="titulo">
				Administrador - Pizzaria da Net
			</div>
			<div id="cadeado">
				<img src="images/cadeado2.png" title="login" alt="login administrador"/>
			</div> <!-- CADEADO -->
			<div id="form_login">
			<form action="" method="post">
				<label for="login_name">Login:</label>
				<input type="text" name="login" class="input_text_login"></input>

				<label for="password">Senha:</label>
				<input type="text" name="password" class="input_text_login"></input>
				<br />
				<input type="submit" id="botao_logar" name="logar" value="enviar"/>
				<br />
			</form>
		</div> <!-- LOGIN -->


		<div id="fix">
		</div>

		</div>

	</div>
	<div class="erro">
			<?php
				if(isset($erro))
				{
					if(!empty($erro))
					{
						echo $erro;
					}
				}
			?>
		</div>

</body>
</html>