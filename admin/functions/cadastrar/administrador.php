<?php

function cadastrarAdministrador(Array $valores) {
	$pdo = conectar();

	try {
		$cadastrarAdministrador = $pdo->prepare("INSERT INTO administrador (administrador_name, administrador_login, administrador_password)
												VALUES (:name, :login, :password)");

		foreach($valores as $key => $value)
		{
			$cadastrarAdministrador->bindValue(":$key", $value);
		}

		$cadastrarAdministrador->execute();

		if($cadastrarAdministrador->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	} catch(PDOException $e) {
		echo "Erro ao cadastrar administrador ", $e->getMessage();
	}
}