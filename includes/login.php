

<?php
if(isset($_POST['logar']))
{

	if(logarCliente($_POST['login'], $_POST['password']))
	{
		header('location:http://localhost/treinos/php/siteCompleto');
	}
	else
	{

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
