
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

function verificaCadastroAlterar($tabela, $nomeCampo, $cadastro, $campoId, $id)
{

	$pdo = conectar();
	try{
		// Verifique se existe um administrador com o mesmo nome que foi passado pelo usuário
		// ao enviar o formulário.
		// Se existe, interrompa o processo de alteração dos dados.
		$verificaCadastro = $pdo->prepare("SELECT * FROM $tabela WHERE $nomeCampo = :cadastro
											AND ".$campoId." != :id");
		$verificaCadastro->bindValue(":cadastro", $cadastro);
		$verificaCadastro->bindValue(":id", $id);
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
	$obrigatorio = array();
	global $obrigatorio;
	if($campo !== null)
	{
		if(empty($campo))
		{
			$obrigatorio[] = "$nomeCampo";
		}
		else
		{
			return $campo;
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
			$listar = $pdo->prepare("SELECT * FROM " . $tabela . $parametros);
			$listar->execute();
		}
		

		if($listar->rowCount() > 0)
		{
			$dados = $listar->fetchAll(PDO::FETCH_ASSOC);
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
		$listar = $pdo->prepare("SELECT * FROM " .$tabela." WHERE ". $campoTabela ." = ".$id);
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

function deletarFoto($fotoInicial, $fotoDetalhes, $dir)
{
	global $erro;

	$fotoInicio = explode("/", $fotoInicial);
	$fotoD = explode("/", $fotoDetalhes);
	
	//$dir = "../../fotos";

	$d = new DirectoryIterator($dir);
	while($d->valid())
	{
		if($d->isFile())
		{
			$fotosPastas[] = $d->getFilename();
		}
		$d->next();
	}
	// var_dump($fotoInicio);
	// var_dump($fotoD);
	// var_dump($fotosPastas);

	if(in_array($fotoInicio[1], $fotosPastas) AND in_array($fotoD[1], $fotosPastas))
	{
		if(unlink("../../fotos/" .$fotoInicio[1]))
		{
			if(unlink("../../detalhes/" .$fotoD[1]))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$erro = "Erro ao deletar foto inicial";
		}
	}
}

function limpaCaracteresEspeciais($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}