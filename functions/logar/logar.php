

<?php
// http://shiflett.org/articles/storing-sessions-in-a-database

function verificaLogado($login)
{
	$pdo = conectar();
	$erro = "";
	try{
		$clienteLogado = $pdo->prepare('SELECT * FROM sessions WHERE session_data = :login');
		$clienteLogado->bindValue(':login', $login);
		$clienteLogado->execute();

		if($clienteLogado->rowCount() == 1)
		{
			$dados = $clienteLogado->fetch(PDO::FETCH_ASSOC);
			return $dados;
			//$id = $dados['session_id'];
			//var_dump($id);

			// $result = _read($pdo, $id);

			// //var_dump($result);
			// if(!empty($result))
			// {
			// 	//var_dump($result);
			// 	return $result;
			// }
			// else
			// {
			// 	return false;
			// }
			// header('location:' . $url);
			
		}
		else
		{
			return '';
		}
	}catch(PDOException $e){
		 	echo 'Erro: '.$e->getMessage();
	}
}
function logarCliente($login, $password)
{
	$pdo = conectar();
	$erro = "";
	try{
		$logarCliente = $pdo->prepare('SELECT * FROM clients WHERE client_login = :login AND client_password = :password');
		$logarCliente->bindValue(':login', $login);
		$logarCliente->bindValue(':password', $password);
		$logarCliente->execute();
		$dados = '';
		if($logarCliente->rowCount() == 1)
		{
			$dados = $logarCliente->fetch(PDO::FETCH_ASSOC);
			
			// $_SESSION['logado_cliente'] = true;
			// $_SESSION['nome_cliente'] = $dados['client_name'];
			// $_SESSION['id_cliente'] = $dados['client_id'];
			//$id = $dados['client_id'];
			//var_dump($id);

			//$result = _write($pdo, $id, $login);

			//var_dump($result);
			// header('location:' . $url);
		}

		return $dados;
		
	}catch(PDOException $e){
		 	echo 'Erro: '.$e->getMessage();
	}
	

	// $pdo = conectar();
	// $erro = "";
	// try{
	// 	$logarCliente = $pdo->prepare('SELECT * FROM clients WHERE client_login = :login AND client_password = :password');
	// 	$logarCliente->bindValue(':login', $login);
	// 	$logarCliente->bindValue(':password', $password);
	// 	$logarCliente->execute();

	// 	if($logarCliente->rowCount() == 1)
	// 	{
	// 		$dados = $logarCliente->fetch(PDO::FETCH_ASSOC);

	// 		$sql = 'INSERT INTO sessions ("session_id", "session")VALUES ()';

	// 		$_SESSION['logado_cliente'] = true;
	// 		$_SESSION['nome_cliente'] = $dados['client_name'];
	// 		$_SESSION['id_cliente'] = $dados['client_id'];
	// 		return $erro;
	// 	}
	// 	else
	// 	{
	// 		//throw new Exception("Erro ao logar!");
	// 		$erro = "Usuário ou senha inválidos";
	// 		return $erro;
	// 	}

	// }catch(PDOException $e){
	// 	echo 'Erro: '.$e->getMessage();
	// }
}

/* SESSION SET SAVE HANDLER */

// desnecessário
// function _open()
// {
//     global $_sess_db;
 
//     if ($_sess_db = conectar()) {
//         return $_sess_db;
//     }
 
//     return false;
// }

function _read($_sess_db, $id)
{
    //$id = mysqli_real_escape_string($_sess_db, $id);
 
   $buscarSessao = $_sess_db->prepare("SELECT session_data
            FROM   sessions
            WHERE  session_id = '$id'");

    $result = $buscarSessao->execute();
    //var_dump($result);
    if($buscarSessao->rowCount() == 1)
    {
    	$dados = $buscarSessao->fetch(PDO::FETCH_ASSOC);
    	var_dump($dados);
    	return $dados['session_data'];
   //  	if (mysqli_num_rows($result)) {
   //          $record = mysqli_fetch_assoc($result);
			// echo "Sessão inserida com sucesso!";
   //          return $record['session_data'];
   //      }
    	
    }

    // if ($result = mysqli_query($sql, $_sess_db)) {
    //     if (mysqli_num_rows($result)) {
    //         $record = mysqli_fetch_assoc($result);
 
    //         return $record['session_data'];
    //     }
    // }
 
    return '';
}

function _write($_sess_db, $id, $data)
{
    $access = time();
 
    // $id = mysqli_real_escape_string($_sess_db, $id);

    // $access = mysqli_real_escape_string($_sess_db, $access);
    // $data = mysqli_real_escape_string($_sess_db, $data);
 
    $criarSessao = $_sess_db->prepare('REPLACE
            INTO    sessions
            VALUES  (:id, :access, :data)');

    $criarSessao->bindValue(':id', $id);
    $criarSessao->bindValue(':access', $access);
    $criarSessao->bindValue(':data', $data);

    $result = $criarSessao->execute();
    //var_dump($result);
    if($criarSessao->rowCount() == 1)
    {
    	echo "Sessão inserida com sucesso!";
    }
    else
    {
    	//echo "Parece que você já possui uma sessão aberta.";
    }
    // $sql = "REPLACE
    //         INTO    sessions
    //         VALUES  ('$id', '$access', '$data')";
 
    // return mysql_query($sql, $_sess_db);
}
 
function _close()
{
    global $_sess_db;
 
    return mysqli_close($_sess_db);
}

function _destroy($_sess_db, $id)
{
 
    $id = mysqli_real_escape_string($_sess_db, $id);
 
    $sql = "DELETE
            FROM   sessions
            WHERE  session_id = '$id'";
 
    return mysqli_query($sql, $_sess_db);
}

function _clean($max)
{
    global $_sess_db;
 
    $old = time() - $max;
    $old = mysql_real_escape_string($old);
 
    $sql = "DELETE
            FROM   sessions
            WHERE  session_access < '$old'";
 
    return mysql_query($sql, $_sess_db);
}

function apresentaPaginaLogin()
{
	echo 	'<form action="" method="post">';
	echo	'<label>Login: </label>';
	echo	'<input type="text" name="login" />';
	echo	'<label>Senha: </label>';
	echo	'<input type="password" name="password" />';
	echo	'<input type="submit" name="logar" />';
	echo    '</form>';		
}

function logout()
{
	session_start();
	if(isset($_SESSION['logado_cliente']))
	{
		session_destroy();
		header('location:http://localhost/treinos/php/siteCompleto/');
	}


	//$_SESSION['logado_cliente'] = false;
	// if(isset($_SESSION['session_data']))
	// {
	// 	$pdo = conectar();
	// 	$destruirSessao = _destroy($pdo, $_SESSION['session_id']);
	// 	// var_dump($destruirSessao);
	// 	var_dump($_SESSION);
	// 	session_destroy($_SESSION['session_id']);
	// 	// session_destroy($_SESSION['logado_cliente']);
	// 	//header('location:http://localhost/treinos/php/siteCompleto/');
	// }
	// else
	// {
	// 	echo "sessão não definida";
	// }
	// // if(isset($_SESSION['logado_cliente']))
	// // {
	// // 	session_destroy();
	// // 	header('location:http://localhost/treinos/php/siteCompleto/');
	// // }
}

?>