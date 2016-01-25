<?php

if(isset($_POST['alterarClient']))
{
	//var_dump($_POST);

	$nameClient = obrigatorio("nome", addslashes($_POST['cliName']));
	$stateClient = obrigatorio("estado", addslashes($_POST['cliState']));
	$cityClient = obrigatorio("cidade", addslashes($_POST['cliCity']));
	$neighborhoodClient = obrigatorio("bairro", addslashes($_POST['cliNeighborhood']));
	$cepClient = obrigatorio("cep",addslashes( $_POST['cliCep']));
	$phoneClient = obrigatorio("telefone", addslashes($_POST['cliPhone']));
	$cellphoneClient = obrigatorio("celular", addslashes($_POST['cliCellphone']));
	$addressClient = obrigatorio("address", addslashes($_POST['cliAddress']));
	$loginClient = obrigatorio("login", addslashes($_POST['cliLogin']));
	$passwordClient = obrigatorio("senha", addslashes($_POST['cliPassword']));
	$id = (int) $_POST['id'];


	global $obrigatorio;

	if(empty($obrigatorio))
	{

		if(verificaCadastroAlterar("clients", "client_name", $nameClient, "client_id", $_POST['id']))
		{
			if(verificaCadastroAlterar("clients", "client_login", $loginClient, "client_id", $_POST['id']))
			{
				$dadosClient = pegarPeloId('clients', 'client_id', $id);
				$senhaDoBanco = $dadosClient['client_password'];

				
				if($senhaDoBanco === $passwordClient)
				{
					$passwordClient = $senhaDoBanco;
				}
				else
				{
					$passwordClient = md5($passwordClient);
				}
				
				if(alterarClient($dadosClient = array(
					"name" => $nameClient,
					"city" => $cityClient,
					"state" => $stateClient,
					"neighborhood" => $neighborhoodClient,
					"cep" => $cepClient,
					"phone" => $phoneClient,
					"cellphone" => $cellphoneClient,
					"address" => $addressClient,
					"login" => $loginClient,
					"password" => $passwordClient,
					"id" => $id
				)))
				{
					$mensagem = "";
					$mensagem = "Cliente alterado com sucesso!";
				}
				else
				{
					$erro = "Erro: Não foi possível alterar o cliente.";
				}
			}
			else
			{
				$erro = "Já existe um cliente com esse login";
			}

		}
		else
		{
			$erro = "Já existe um cliente com esse nome";
		}	
	}
	else
	{
		$erro = $obrigatorio;
	}
}

?>

<div class="formularioAlterar">
<h2>: .ALTERAR CLIENTE .:</h2>
<?php
// require_once '../bibliotecas/Pager/Pager/Pager.php';
// require_once '../bibliotecas/Pager/Pager/Pager/Common.php';
// require_once '../bibliotecas/Pager/Pager/Pager/Jumping.php';


$dadosClient = listar("clients");

?>

<table width="600">
	<tr class="cabecalho">
		<td>Nome</td>
		<td>Cidade</td>
		<td>UF</td>
		<td>Bairro</td>
		<td>CEP</td>
		<td>Tel</td>
		<td>Cell</td>
		<td>Endereço</td>
		<td>Login</td>
		<td>Senha</td>
		<td>Alterar</td>
	</tr>

	<?php
	$params = array(
	    'mode'       => 'Jumping',
	    'perPage'    => 10,
	    'delta'      => 5,
	    'itemData'   => $dadosClient
	);
	$pager = @Pager::factory($params);
	$data  = $pager->getPageData();
	//var_dump($data);
	foreach ($data as $d) {
	?>

	<form action="" method="post">
		<tr>
			<input type="hidden" name="id" value="<?php echo $d['client_id'];?>">
			<td><input type="text" name="cliName" value="<?php echo $d['client_name'];?>"  class="txt_field"/></td>
			<td><input type="text" name="cliCity" value="<?php echo $d['client_city'];?>"  class="txt_field"/></td>
			<td><input type="text" name="cliState" value="<?php echo $d['client_state'];?>" class="txt_field_menor" /></td>
			<td><input type="text" name="cliNeighborhood" value="<?php echo $d['client_neighborhood'];?>"  class="txt_field"/></td>
			<td><input type="text" name="cliCep" value="<?php echo $d['client_cep'];?>"  class="txt_field"/></td>
			<td><input type="text" name="cliPhone" value="<?php echo $d['client_phone'];?>"  class="txt_field_menor"/></td>
			<td><input type="text" name="cliCellphone" value="<?php echo $d['client_cellphone'];?>"  class="txt_field_menor"/></td>
			<td><input type="text" name="cliAddress" value="<?php echo $d['client_address'];?>"  class="txt_field"/></td>
			<td><input type="text" name="cliLogin" value="<?php echo $d['client_login'];?>"  class="txt_field_menor"/></td>
			<td><input type="text" name="cliPassword" value="<?php echo $d['client_password'];?>"  class="txt_field_menor"/></td>
			<td><input type="submit" name="alterarClient" value="alterar" class="input_button"/></td>
		</tr>

	</form>
	<?php } ?>

	<tr>
		<td colspan="11" align="center">
			<?php
				$links = $pager->getLinks();
				echo $links['all'];
			?>
		</td>
	</tr>

	<tr>
		
		
		<td colspan="11" align="center">
		<?php
			if(isset($erro))
			{
				//echo '<td colspan="10" align="center" class="erro">';
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
				//echo '</td>';
			}
		?>
		</td>
	</tr>	

</table>
<td colspan="11" align="center">
<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
</td>
</div>