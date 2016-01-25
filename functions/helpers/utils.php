<?php

function verificaCadastro($tabela, $nomeCampo, $cadastro)
{
	// echo $nomeCampo;
	// echo $cadastro;
	$pdo = conectar();
	try{

		$verificaCadastro = $pdo->prepare("SELECT * FROM $tabela WHERE $nomeCampo = :cadastro");
		$verificaCadastro->bindValue(":cadastro", $cadastro);
		$verificaCadastro->execute();

		if($verificaCadastro->rowCount() == 1)
		{
			return false;
		}
		else
		{
			return true;
		}
	} catch(PDOException $e){
		echo "Erro ao verificar registro cadastrado" . $e->getMessage();
	}
	
}

function obrigatorio($nomeCampo, $campo = null)
{
	// $obrigatorio = array();
	global $obrigatorio;
	if($campo !== null)
	{
		if(empty($campo))
		{
			$obrigatorio = "O campo $nomeCampo é obrigatório!";
		}
		else
		{
			$valor = filter_var($campo, FILTER_SANITIZE_SPECIAL_CHARS);
			return trim($valor);
		}
	}
}


function validarCep($cep)
{
	global $validou;

	if(preg_match("/^[0-9]{5}-[0-9]{3}$/i", $cep))
	{
		return true;
	}
	else
	{
		$validou = "O formato do cep não foi aceito.";
	}
}

function validarTelefone($phone)
{
	global $validou;

	if(preg_match("/^[(][0-9]{2}[)][0-9]{4}-[0-9]{4}$/i", $phone))
	{
		return true;
	}
	else
	{
		
		$validou = "O formato do telefone não foi aceito.";
	}
}

function criaSessao($sessao, $valorSessao) {

	if(empty($valorSessao))
	{
		return $_SESSION[$sessao] = "";
	}
	else
	{
		return $_SESSION[$sessao] = $valorSessao;
	}
}

function listar($tabela, $parametros = null)
{
	$pdo = conectar();
	try {

		if(is_null($parametros))
		{
			$listar = $pdo->prepare("SELECT * FROM ". $tabela);
			$listar->execute();
		}
		else
		{
			$listar = $pdo->prepare("SELECT * FROM " . $tabela . " " . $parametros);
			$listar->execute();
		}
		

		if($listar->rowCount() > 0)
		{
			$dados = $listar->fetchAll(PDO::FETCH_OBJ);
			return $dados;
		}
		else
		{
			return false;
		} 
	} catch(PDOException $e) {
		echo "Erro: " . $e->getMessage();
	}
}

function listarBusca($tabela, $campoBusca, $busca )
{
	$pdo = conectar();

	try {
		$listarBusca = $pdo->prepare("SELECT * FROM  $tabela WHERE $campoBusca LIKE :b");
		$listarBusca->bindValue(":b", $busca.'%');
		$listarBusca->execute();

		if($listarBusca->rowCount() > 0)
		{
			$dados = $listarBusca->fetchAll(PDO::FETCH_ASSOC);
			return $dados;
		}
		else
		{
			return false;
		}
	}catch(PDOException $e)
	{
		echo "Erro: " . $e->getMessage();
	}
}

function pegarPeloId($tabela, $campoTabela, $id)
{

	$pdo = conectar();

	try {
		$listar = $pdo->prepare("SELECT * FROM " .$tabela." WHERE ". $campoTabela ." = :id");
		$listar->bindValue(":id", $id);

		$listar->execute();

		if($listar->rowCount() > 0)
		{
			$dados = $listar->fetch(PDO::FETCH_ASSOC);
			return $dados;
		}
		else
		{
			return false;
		}
	}catch(PDOException $e)
	{
		echo "Erro: " . $e->getMessage();
	}

}

function deletar($tabela, $campoTabela, $id)
{
	$pdo = conectar();
	try {
		$deletar = $pdo->prepare("DELETE FROM $tabela WHERE $campoTabela = :id");
		$deletar->bindValue(":id", $id);
		$deletar->execute();

		if($deletar->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}catch(PDOException $e){
		echo "Erro: " . $e->getMessage();
	}
}
/* NÃO FUNCIONANDO! */
function enviarEmail($nome, $email, $assunto, $telefone, $mensagem )
{
	require_once "admin/bibliotecas/PHPMailer/PHPMailerAutoload.php";
	try{

		//Create a new PHPMailer instance
		$mail = new PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->Mailer = "smtp";
		$mail->SMTPSecure = "ssl";
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		

		$mail->Username = "diegoaraujo9@gmail.com";
		$mail->Password = '$d228810';
		$mail->IsHTML(true);



		// EMAIL DE QUEM ESTÁ ENVIANDO

		$mail->SetFrom($email);

		// NOME PRINCIPAL QUE APARECE AO RECEBER EMAIL
		$mail->FromName = $nome;

		// ENVIAR UMA CÓPIA PARA
		$mail->AddAddress($email, $nome);
		// $mail->AddAddress();

		// ASSUNTO DO EMAIL APARECE LOGO ABAIXO DO NOME PRINCIPAL
		$mail->Subject = $assunto;

		// MENSAGEM  DO EMAIL
		$mensagemEnviada = "<p>Telefone: $telefone</p>";
		$mensagemEnviada .= "<p>Email: $email</p>";
		$mensagemEnviada .= $mensagem;

		$mail->Body = $mensagemEnviada;

		//send the message, check for errors
		if (!$mail->send()) {
		    echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		    echo "Message sent!";
		}
		 $errors[] = "Send mail successfully";
	}catch (phpmailerException $e) {
    $errors[] = $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    $errors[] = $e->getMessage(); //Boring error messages from anything else!
}
	
}
