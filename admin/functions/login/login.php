<?php
// include_once '../functions/conexao/banco_pdo.php';
// include_once 'conexao.php';
//include_once 'functions/login/login.php';

function gravarLogin($administrador) {

/* ALTERA A DATA PARA A DO LOCALHOST*/
	//date_default_timezone_get("BRASIL/EAST");
	$pdo = conectar();
	try {
		$gravarLogin = $pdo->prepare("INSERT INTO dados_login_administrador(dados_login_administrador, dados_login_administrador_date) VALUES (:administrador, :data)");
		$gravarLogin->bindValue(":administrador", $administrador);
		$gravarLogin->bindValue(":data", date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s")) - 60 * 60 * 3));
		$gravarLogin->execute();

		// SE CADASTROU NO BD O LOGIN DO ADMINISTRADOR
		if($gravarLogin->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	} catch(PDOException $e) {
		echo "Erro ao gravar dados de login";
	}
}

function gravarDados($arquivo)
{
	/* ALTERA A DATA PARA A DO LOCALHOST*/
	date_default_timezone_get("BRASIL/EAST");

	/* VERIFICA O TIPO DE ARQUIVO PARA GERAR MENSAGEM */
	if($arquivo == "functions/login/sucesso.txt")
	{
		$str = 'O administrador (' . $_SESSION['client'] . 'logou com sucesso com o IP ' . $_SERVER['REMOTE_ADDR'] . ' na data ' . date("d/m/y h:i:s") . "\n";
	}
	else
	{
		$str = 'Erro ao logar com o login ' . $_SERVER['REMOTE_ADDR'] . ' na data ' . 'às ' . date("d/m/y h:i:s") . "\n";
	}

	/* GRAVA OS DADOS EM UM ARQUIVO TXT */
	if(file_exists($arquivo))
	{
		$file = fopen($arquivo, "a");
		if($file)
		{
			fputs($file, $str);
		}
	}
}

function logar($login, $password)
{
	$pdo = conectar();

	try{

		$logar = $pdo->prepare("SELECT * FROM administrador WHERE administrador_login = :login AND administrador_password = :password");
		$logar->bindValue(":login", $login);
		$logar->bindValue(":password", $password);
		$logar->execute();
		$dadosLogin = $logar->fetch(PDO::FETCH_ASSOC);

		if($logar->rowCount() == 1)
		{
			// SE LOGOU, CRIA AS SESSÕES
			$_SESSION['administrador'] = $dadosLogin['administrador_name'];
			$_SESSION['administrador_id'] = $dadosLogin['administrador_id'];
			$_SESSION['logado_admin'] = true;

			// GRAVA OS DADOS DE LOGIN NO BANCO DE DADOS
			if(gravarLogin($dadosLogin['administrador_id'])) 
			{
				// GRAVA EM UM ARQUIVO TXT
				gravarDados("functions/login/sucesso_login.txt");
				return true;
			}
			
		}
		else {
			gravarDados("functions/login/erro_login.txt");
			return false;
		}
	}catch(PDOException $e) {
		echo "Erro ao tentar logar no sistema" . $e->getMessage();
	}
}

function verificaLogado($sessao)
{
	if(!isset($_SESSION[$sessao]))
	{
		header("Location: ../index.php");
	}
}

function pegaIdAdministrador($name = null)
{
	$pdo = conectar();
	try{
		$pegaId = $pdo->prepare("SELECT * FROM administrador WHERE administrador_name = :administrador");
		$pegaId->bindValue(":administrador", $name);
		$pegaId->execute();
		$dados = $pegaId->fetch(PDO::FETCH_ASSOC);
		return $dados['administrador_id'];
	}catch(PDOException $e) {
		echo "Erro ao pegar ID do administrador" . $e->getMessage();
	}
}

function ultimoLogin($id)
{
	$pdo = conectar();
	/* ALTERA A DATA PARA A DO LOCALHOST*/
	date_default_timezone_get("BRASIL/EAST");
	try {

		$ultimoLogin = $pdo->prepare("SELECT * FROM dados_login_administrador WHERE dados_login_administrador = :id ORDER BY dados_login_administrador_date DESC Limit 1,1");
		$ultimoLogin->bindValue(":id", $id);
		$ultimoLogin->execute();
		$dados = $ultimoLogin->fetch(PDO::FETCH_ASSOC);
	
		return $dados['dados_login_administrador_date'];
	}catch(PDOException $e) {
		echo "Erro ao pegar ID do administrador " . $e->getMessage();
	}
}