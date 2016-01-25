<?php

function alterarMeta($texto, $id)
{
	$pdo = conectar();
	try {
		
		$sql = "UPDATE metas SET meta_text = :texto WHERE meta_id = :id";

		$alterarMet = $pdo->prepare($sql);
		$alterarMet->bindValue(":texto", $texto);	
		$alterarMet->bindValue(":id", $id);

		$alterarMet->execute();
		

		if($alterarMet->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}catch(PDOException $e)
	{
		$erro = "Erro ao tentar alterar metae";
	}
}

?>