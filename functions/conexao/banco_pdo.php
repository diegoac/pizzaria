<?php

class Banco{

	private $host;
	private $user;
	private $password;
	private $database;
	private $status;
	private $link;

	public function __construct(){
		$this->Conectar();
	}

	private function Conectar(){
		//echo "conectando.";
		$this->host = "localhost";
		$this->user = "root";
		$this->password = "";
		$this->database = "pizzaria";

		$dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . "";

		try{
			$this->link = new PDO($dsn, $this->user, $this->password);
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e) {
			echo "Erro ao conectar ao banco ".$e->getMessage();
		}

		if(!($this->link)){
			$this->status = false;
			die('Could not connect: ' . mysql_error());
		}
		else
		{
			$this->status = true;
		}

			
	}

	public function StatusConexao(){
		return $this->status;
	}

	public function GetLink(){
		return $this->link;
	}
}

?>