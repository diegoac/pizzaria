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

		$this->link = mysqli_connect($this->host, $this->user, $this->password, $this->database);

		if(!($this->link)){
			$this->status = false;
			die('Could not connect: ' . mysqli_error());
		}
		else
		{
			$this->status = true;
			//echo "ok";
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