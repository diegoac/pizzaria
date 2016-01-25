<?php

//include_once '../functions/conexao/conexao.php';

function exibeMetas($type) {

	$pdo =  conectar();

	try {

		$listarMetas = $pdo->prepare("SELECT * FROM metas WHERE meta_type = :type");
		$listarMetas->bindValue(":type", $type);

		//var_dump($listarMetas);
		$listarMetas->execute();
		$dados = $listarMetas->fetch(PDO::FETCH_ASSOC);
		// var_dump($dados);

		return strip_tags($dados['meta_text']);
	}catch(PDOException $e) {
		echo "Erro ao listar metas";
	}

}

?>