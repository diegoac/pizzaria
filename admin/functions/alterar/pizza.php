<?php

function alterarPizza(Array $dadosPizza)
{
	
	$pdo = conectar();
	$dadosPizza['url'] = limpaCaracteresEspeciais($dadosPizza['name']);
	try {
		
		$alterarPizza = $pdo->prepare("UPDATE pizzas SET pizza_name = :name, pizza_categories = :category,  pizza_price = :price, pizza_description = :description, pizza_name_url = :url WHERE pizza_id = :id");

		//$alterarPizza = $pdo->prepare("UPDATE administrador SET administrador_name = 'Antonio', administrador_login = 'ant123', administrador_password ='123456' WHERE administrador_id = '13'");
		var_dump($dadosPizza);
		foreach($dadosPizza as $k => $value)
		{	echo $value;
			$alterarPizza->bindValue(":$k", $value);
		}
		$alterarPizza->execute();

		if($alterarPizza->rowCount() == 1)
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

function listarPizzas()
{
	$pdo = conectar();
	try {
		$listar = $pdo->prepare("SELECT * FROM ". $tabela);
		$listar->execute();

		if($listar->rowCount() > 0)
		{
			$dados = $listar->fetchAll(PDO::FETCH_ASSOC);
			return $dados;
		}
		else
		{
			return false;
		} 
	} catch(PDOException $e) {
		echo "Erro: " . $e->getMessage();
	}
}

?>