<?php
function cadastrarMeta($type, $texto) {
	$pdo = conectar();

	try {
		$cadastrarMeta = $pdo->prepare("INSERT INTO metas (
			meta_type,
			meta_text

			)
			VALUES (
			:type,
			:texto
			)"
		);

		$cadastrarMeta->bindValue(":type", $type);
		$cadastrarMeta->bindValue(":texto", $texto);


		$cadastrarMeta->execute();

		if($cadastrarMeta->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	} catch(PDOException $e) {
		echo "Erro ao cadastrar meta ", $e->getMessage();
	}
}