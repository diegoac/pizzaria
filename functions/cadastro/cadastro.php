<?php

function cadastrarClient($dados = Array()){

	$pdo = conectar();
	try {
		$cadastrarClient = $pdo->prepare("INSERT INTO clients(
			client_name,
			client_city,
			client_state,
			client_neighborhood,
			client_cep,
			client_phone,
			client_cellphone,
			client_email,
			client_address,
			client_birthday,
			client_login,
			client_password)
			VALUES(
			:name,
			:city,
			:state,
			:neighborhood,
			:cep,
			:phone,
			:cellphone,
			:email,
			:address,
			:birthday,
			:login,
			:password
			)
			");

		foreach($dados as $key => $value)
		{
			$cadastrarClient->bindValue(":$key", $value);	
		}
		// $birthday = explode('/', $dados['birthday']);
		// $cadastrarClient->bindValue(":birthday", $birthday);
		$cadastrarClient->execute();

		if($cadastrarClient->rowCount() > 0)
		{
			//$cadastrarCliente = $cadastrarCliente->fetch(PDO::FETCH_ASSOC);
			return $dados;
		}
		else
		{
			return false;
		}
	}catch(PDOException $e)
	{
		echo "Erro: " . $e->getMessage();
	}
}
