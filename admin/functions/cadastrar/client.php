<?php

function cadastrarClient(Array $valores) {
	$pdo = conectar();

	try {
		$cadastrarClient = $pdo->prepare("INSERT INTO clients (
										client_name,
										client_city,
										client_state,
										client_neighborhood,
										client_cep,
										client_phone,
										client_cellphone,
										client_address,
										client_login,
										client_password
										)
										VALUES (
										:name,
										:city,
										:state,
										:neighborhood,
										:cep,
										:phone,
										:cellphone,
										:address,
										:login,
										:password)"
										);

		foreach($valores as $key => $value)
		{
			$cadastrarClient->bindValue(":$key", $value);
		}

		$cadastrarClient->execute();

		if($cadastrarClient->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	} catch(PDOException $e) {
		echo "Erro ao cadastrar cliente ", $e->getMessage();
	}
}