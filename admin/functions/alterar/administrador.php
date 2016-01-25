<?php

function alterarAdministrador(Array $dadosAdmin)
{
	$pdo = conectar();
	try {
		
		$alterarAdmin = $pdo->prepare("UPDATE administrador SET
			administrador_name = :name,
			administrador_login = :login,
			administrador_password = :password
			WHERE administrador_id = :id");

		//$alterarAdmin = $pdo->prepare("UPDATE administrador SET administrador_name = 'Antonio', administrador_login = 'ant123', administrador_password ='123456' WHERE administrador_id = '13'");
		//var_dump($alterarAdmin);
		foreach($dadosAdmin as $k => $value)
		{
			$alterarAdmin->bindValue(":$k", $value);
		}
		$alterarAdmin->execute();

		if($alterarAdmin->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}catch(PDOException $e)
	{
		$erro = "Erro ao tentar alterar administrador";
	}
}

?>