<?php

function cadastrarPizza(Array $valores) {
	$pdo = conectar();
	
	// limpa os caracteres especiais do nome, para montar a url adequadamente
	$valores['url'] = limpaCaracteresEspeciais($valores['name']);
	var_dump($valores);
	try {
		$cadastrarPizza = $pdo->prepare("INSERT INTO pizzas(
			pizza_categories,
			pizza_name,
			pizza_price,
			pizza_description,
			pizza_foto_inicio,
			pizza_foto_detalhes,
			pizza_name_url
			)
			VALUES (
			:category,
			:name,
			:price,
			:description,
			:fotoInicio,
			:fotoDetalhes,
			:url
			)"
		);

		foreach($valores as $key => $value)
		{
			$cadastrarPizza->bindValue(":$key", $value);
		}

		$cadastrarPizza->execute();

		if($cadastrarPizza->rowCount() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	} catch(PDOException $e) {
		echo "Erro ao cadastrar pizza", $e->getMessage();
	}
}