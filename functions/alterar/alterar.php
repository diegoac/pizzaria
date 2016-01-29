<?php

function alterarClient(Array $dadosClient)
{
	$pdo = conectar();
	try {
		//var_dump($dadosClient);
		$alterarCli = $pdo->prepare("UPDATE clients SET client_name = :name,
			client_city = :city,
			client_state = :state,
			client_neighborhood = :neighborhood,
			client_cep = :cep,
			client_phone = :phone,
			client_cellphone = :cellphone,
			client_email = :email,
			client_address = :address,
			client_birthday = :birthday,
			client_login = :login,
			client_password = :password
			WHERE client_id = :id");

		foreach($dadosClient as $k => $value)
		{
			$alterarCli->bindValue(":$k", $value);
		}
		//var_dump($alterarCli);
		$alterarCli->execute();
		

		if($alterarCli->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}catch(PDOException $e)
	{
		$erro = "Erro ao tentar alterar cliente";
	}
}