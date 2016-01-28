<?php
//include_once "http://localhost/treinos/php/siteCompleto/functions/logar/logar.php";
session_start();
if(isset($_POST['logar']))
{
	// $pdo = conectar();
	// $buscarCliente = $pdo->prepare("SELECT * FROM clients WHERE client_login = :login");
	// $buscarCliente->bindValue(":login", $_POST['login']);
	// $buscarCliente->execute();
	$dados = logarCliente($_POST['login'], $_POST['password']);
	if(!empty($dados))
	{
		$_SESSION['logado_cliente'] = true;
		$_SESSION['nome_cliente'] = $dados['client_name'];
		$_SESSION['id_cliente'] = $dados['client_id'];
		//header('location:http://localhost/treinos/php/siteCompleto');
	}
	else
	{
		echo "Usuário ou senha inválidos.";
	}
}
if(!isset($_SESSION['logado_cliente']))
{
	//var_dump($_GET);
	// APRESENTA PÁGINA DE LOGIN
	echo 	'<form action="" method="post">';
	echo	'<label>Login: </label>';
	echo	'<input type="text" name="login" />';
	echo	'<label>Senha: </label>';
	echo	'<input type="password" name="password" />';
	echo	'<input type="submit" name="logar" />';
	echo    '</form>';
}

// verificação do login feita no index.php
?>

<!-- PÁGINA DE LOGIN -->
