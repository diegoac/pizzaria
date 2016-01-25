<?php

function alterarFoto($foto, $id)
{
	$pdo = conectar();

	try {
		$sql = "UPDATE pizzas SET
			pizza_foto_inicio = :fotoInicio,
			pizza_foto_detalhes = :fotoDetalhes
			WHERE pizza_id = :id";

		$alterarFoto = $pdo->prepare($sql);

		$alterarFoto->bindValue(":fotoInicio", "fotos/".$foto);
		$alterarFoto->bindValue(":fotoDetalhes", "detalhes/".$foto);
		$alterarFoto->bindValue(":id", $id);
		$alterarFoto->execute();
		
		if($alterarFoto->rowCount() == 1)
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