<?php

function cadastrarCategory($category) {
	$pdo = conectar();

	try {
		$cadastrarCategory = $pdo->prepare("INSERT INTO categories(category_name)VALUES(:category)");
		$cadastrarCategory->bindValue(":category", $category);
		$cadastrarCategory->execute();

		if($cadastrarCategory->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	} catch(PDOException $e) {
		echo "Erro ao cadastrar categoria".$e->getMessage();
	}
}

?>