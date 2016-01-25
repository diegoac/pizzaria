<?php
define("USER", "root");
define("PASS", "");
define("HOST", "localhost");
define("DBNAME", "pizzaria");

function conectar() {

	$dsn = "mysql:host=".HOST.";dbname=".DBNAME."";

	try{
		$conectar = new PDO($dsn, USER, PASS);
		$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	}catch(PDOException $e){
		echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
	}
	
	return $conectar;
}

?>