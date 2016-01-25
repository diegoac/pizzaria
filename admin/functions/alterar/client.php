<?php

function alterarClient(Array $dadosClient)
{
	$pdo = conectar();
	try {
		var_dump($dadosClient);
		$sql = "UPDATE clients SET client_name = :name,
									client_city = :city,
									client_state = :state,
									client_neighborhood = :neighborhood,
									client_cep = :cep,
									client_phone = :phone,
									client_cellphone = :cellphone,
									client_address = :address,
									client_login = :login,
									client_password = :password
							WHERE client_id = :id";
		// $dadosClientTest = array(
		// 	'name' => 'Pedro' ,
		// 	// 'city' =>  'Amazonas' ,
		// 	// 'state' =>  'AM' ,
		// 	// 'neighborhood' =>  'Novo Progresso',
		// 	// 'cep' =>  '31270-217' ,
		// 	// 'phone' =>  '(31)7568-7697',
		// 	// 'cellphone' =>  '316546',
		// 	// 'login' =>  'sergio123',
		// 	// 'password' =>  '123456',
		// 	'id' => $id
		// );
		//$sql = "UPDATE clients SET client_name = :name WHERE client_id = :id";
		$alterarCli = $pdo->prepare($sql);


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

?>