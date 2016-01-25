<?php

function alterarCategory($category, $id)
{
	$pdo = conectar();
	try {
		
		$alterarCat = $pdo->prepare("UPDATE categories SET category_name = :name WHERE category_id = :id");

		$alterarCat->bindValue(":name", $category);
		$alterarCat->bindValue(":id", $id);

		$alterarCat->execute();

		if($alterarCat->rowCount() == 1)
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