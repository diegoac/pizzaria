<?php

if(isset($_POST['alterarAdmin']))
{
	$nameAdministrador = obrigatorio("name", $_POST['adminName']);
	$loginAdministrador = obrigatorio("login", $_POST['adminLogin']);
	$passwordAdministrador = obrigatorio("password", $_POST['adminPassword']);

	global $obrigatorio;

	if(empty($obrigatorio))
	{
		// $result = pegarPeloId("administrador", "administrador_id", $_POST['id']);
		// var_dump($result);
		if(verificaCadastroAlterar("administrador", "administrador_name", $nameAdministrador, "administrador_id", $_POST['id']))
		{
			if(verificaCadastroAlterar("administrador", "administrador_login", $loginAdministrador, "administrador_id", $_POST['id']))
			{
				var_dump($_POST);
				$dados = pegarPeloId("administrador", "administrador_id", $_POST['id']);
				// Se a senha cadastrada no banco é a mesma que foi enviada pelo formulário, mantenha ela inalterada(sem ser criptografada).
				if($dados['administrador_password'] == $passwordAdministrador)
				{
					$passwordAdmin = $dados['administrador_password'];
				}
				// Se o campo da senha foi alterado pelo usuário, execute a criptografia da mesma.
				else
				{
					$passwordAdmin = md5($passwordAdministrador);
				}

				if(alterarAdministrador($dadosAdministrador = array(
					'name' => $_POST['adminName'],
					'login' => $_POST['adminLogin'],
					'password' => $passwordAdmin,
					'id' => $_POST['id']
				)))
				{
					$mensagem = "";
					$mensagem = "Administrador alterado com sucesso!";
				}
				else
				{
					$erro = "Erro ao alterar administrador";
				}
			}
			else
			{
				$erro = "Já existe um administrador com esse login";
			}
		}
		else
		{
			$erro = "Já existe um administrador com esse nome";
		}	
	}
	else
	{
		$erro = $obrigatorio;
	}
}


?>


<div class="formularioAlterar">
<h2>: .ALTERAR ADMINISTRADOR.:</h2>
<?php
// require_once '../bibliotecas/Pager/Pager/Pager.php';
// require_once '../bibliotecas/Pager/Pager/Pager/Common.php';
// require_once '../bibliotecas/Pager/Pager/Pager/Jumping.php';


$dadosAdministrador = listar("administrador");

?>

<table width="600">
	<tr class="cabecalho">
		<td class="txt_field">Nome</td>
		<td class="txt_field">Usuário</td>
		<td class="txt_field">Senha</td>
		<td>Alterar</td>
	</tr>

	<?php
	$params = array(
	    'mode'       => 'Jumping',
	    'perPage'    => 2,
	    'delta'      => 5,
	    'itemData'   => $dadosAdministrador
	);
	$pager = @Pager::factory($params);
	$data  = $pager->getPageData();
	//var_dump($data);
	foreach ($data as $d) {
	?>

	<form action="" method="post">
		<tr>
			<input type="hidden" name="id" value="<?php echo $d['administrador_id'];?>">
			<td><input type="text" name="adminName" value="<?php echo $d['administrador_name'];?>"  class="txt_field_menor"/></td>
			<td><input type="text" name="adminLogin" value="<?php echo $d['administrador_login'];?>"  class="txt_field"/></td>
			<td><input type="text" name="adminPassword" value="<?php echo $d['administrador_password'];?>"  class="txt_field_maior"/></td>
			<td class="buttons"><input type="submit" name="alterarAdmin" value="alterar" class="input_button"/></td>
		</tr>

	</form>
	<?php } ?>

	<tr>
		<td colspan="4" align="center">
			<?php
				$links = $pager->getLinks();
				echo $links['all'];
			?>
		</td>
	</tr>

	<tr>
		<td colspan="4" align="center">
		<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
		<?php
			if(isset($erro))
			{
				echo '<br /><p>Por favor, preencha os seguintes campos:</p><br />';
				if(is_array($erro))
				{
					foreach ($erro as $err) {
						if(!empty($err))
						{
							echo '<div class=erro>' . $err . '</div><br />';
						}
					}
				}
				else
				{
					echo $erro;
				}
			}
		?>
		</td>
	</tr>


	

</table>
</div>