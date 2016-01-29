<div id="areaCliente">

<?php
	include_once 'functions/alterar/alterar.php';
	session_start();
	// Cadastrar cliente (via ajax)
	if(isset($_POST['cadastrarClient']))
	{
		// ALTERAR DADOS DO CLIENTE (AlterarDadosCliente)
		$name = obrigatorio("Nome", addslashes($_POST['name']));
		$city = obrigatorio("Cidade", addslashes($_POST['city']));
		$state = obrigatorio("Estado", addslashes($_POST['state']));
		$neighborhood = obrigatorio("Bairro", addslashes($_POST['neighborhood']));
		$cep = obrigatorio("CEP", addslashes($_POST['cep']));
		validarCep($_POST['cep']);
		$phone = obrigatorio("Telefone", addslashes($_POST['phone']));
		validarTelefone($phone);
		$cellphone = obrigatorio("Celular", addslashes($_POST['cellphone']));
		//validarCelular($celular);
		$email = obrigatorio("Email", addslashes($_POST['email']));
		$address = obrigatorio("Endereço", addslashes($_POST['address']));
		$birthday = obrigatorio("Nascimento", addslashes($_POST['birthday']));
		$login = obrigatorio("Login", addslashes($_POST['login']));
		$password = obrigatorio("Senha", addslashes($_POST['password']));
		$id = $_POST['id'];

		if(!isset($obrigatorio))
		{
			/* FORMATA DATA DE NASCIMENTO */
			$birthday_aux = explode('/', $birthday);
			$birthday = $birthday_aux[2] . "-" . $birthday_aux[1] . "-" . $birthday_aux[0];
			/* FORMATA DATA DE NASCIMENTO */
			$dados = array(
				"name" => $name,
				"city" => $city,
				"state" => $state,
				"neighborhood" => $neighborhood,
				"cep" => $cep,
				"phone" => $phone,
				"cellphone" => $cellphone,
				"email" => $email,
				"address" => $address,
				"birthday" => $birthday,
				"login" => $login,
				"password" => $password,
				"id" => $id
			);

			if(alterarClient($dados))
			{
				$mensagem = "Dados alterados com sucesso!";
			}
			else
			{
				$erro = "Erro ao alterar os dados. Por favor, tente novamente.";
			}
		}
		else
		{
			$erro = $obrigatorio;
		}
	}
	


// DELETAR PIZZAS E PEDIDOS
if(substr_count($_GET['p'], '/') > 0)
{
	$pagina = explode('/', $_GET['p']);
	if($pagina[2] == 'pedido')
	{
		echo "Deletar pedido";
	}
	elseif($pagina[2] == 'pizza')
	{
		$id = filter_var($pagina[3], FILTER_SANITIZE_NUMBER_INT);
		$idDaPizza = filter_var($id, FILTER_VALIDATE_INT);
		if($idDaPizza)
		{
			unset($_SESSION['pedido'][$idDaPizza]);
		}
		else
		{
			$erro = "Essa pizza não existe ou não foi adicionada ao pedido";
		}
	}
	
}


// $idPizzaDeletar = explode('/', $_GET['p']);
// $idPizzaDeletar[3] = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
// $idDaPizza = filter_var($id, FILTER_VALIDATE_INT);

// if($idDaPizza)
// {
// 	unset($_SESSION['pedido'][$idDaPizza]);
// }
// else
// {
// 	$erro = "Essa pizza não existe ou não foi adicionada ao pedido";
// }
// $_SESSION = array();
//session_destroy();
/* LIMPAR PEDIDO */

// if(isset($_GET['ac']))
// {
// 	if($_GET['ac'] == 'l')
// 	{
// 		if(!empty($_SESSION['pedido']))
// 		{
// 			unset($_SESSION['pedido']);
// 		}
// 		else
// 		{
// 			echo "Não existe nenhum pedido ainda";
// 		}
// 	}
// 	if($_GET['ac'] == 'del')
// 	{
// 		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
// 		$idDaPizza = filter_var($id, FILTER_VALIDATE_INT);
// 		if($idDaPizza)
// 		{
// 			unset($_SESSION['pedido'][$idDaPizza]);
// 		}
// 		else
// 		{
// 			$erro = "Essa pizza não existe ou não foi adicionada ao pedido";
// 		}
		
// 	}
// }

/* VERIFICA SE CLIENTE ESTÁ LOGADO */

if(isset($_SESSION['logado_cliente']))
{
	
	
	?>
	<!-- ALTERAR DADOS DO CLIENTE (VIA AJAX: js/alterarDadosCliente.js -->
	<div id="alterarDadosCliente">
		<h2>Alterar dados:</h2>
		<a href="#" id="alterar" name="<?php echo $_SESSION['id_cliente'];?>">Alterar meus dados</a>
	</div>
	<!-- ALTERAR DADOS DO CLIENTE -->
	<div id="dadosCliente">
	</div>

	<?php
	

	/* LISTAGEM DO PEDIDO DE HOJE */
	if(!empty($_SESSION['pedido']))
	{
		?>
		<form action="http://localhost/treinos/php/siteCompleto/checkout" method="post">
			<table width="800" cellspacing="0">
				<thead>
					<tr>
						<td>Nome</td>
						<td>Preço</td>
						<td>Quantidade</td>
						<td>Subtotal</td>
						<td>Excluir</td>
					</tr>
				</thead>
				<tbody>
					
						<?php
						$total = "";
						$d = new ArrayIterator($_SESSION['pedido']);
						// var_dump($_SESSION);
						//var_dump($d);
						while($d->valid())
						{
							// var_dump($d->key());
							//var_dump($d->current());
							//echo $d->current();
							$pedido = pegarPeloId('pizzas', 'pizza_id', $d->key());
							//var_dump($pedido);
						?>
						<tr>
							<td><?php echo $pedido['pizza_name'];?></td>
							<td>R$ <?php echo number_format($pedido['pizza_price'],2,",","."); ?></td>
							<td><?php echo $d->current();?></td>
							<td>R$ <?php echo number_format($d->current() * $pedido['pizza_price'],2,",","."); ?></td>
							<td align="center"><a href="http://localhost/treinos/php/siteCompleto/clientes/deletar/pizza/<?php echo $pedido['pizza_id']?>"><img src="http://localhost/treinos/php/siteCompleto/images/icons/delete.png" width="16" heigth="16"></a></td>
						</tr>
						<?php
							$total += $d->current()*$pedido['pizza_price'];
							$d->next();
						}
						?>
					
				</tbody>
				<tfoot>
					<tr>
						<td>Total do pedido: R$ <?php echo $total;?></td>
						<td colspan="1">
							<input type="submit" name="fechar" id="botaoFecharPedido" value="Fechar pedidos" class="botaoCliente"></input>
						</td>
						<td colspan="2">
							<a href="http://localhost/treinos/php/siteCompleto/clientes/deletar/pedido" class="botaoCliente">Limpar Pedido</a>
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
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
		<?php
	}
	else
	{
		echo "Você ainda não fez nenhum pedido hoje!";
	}
	?>
	<!-- RELATÓRIO DOS PEDIDOS -->
	<div id="relatorioPedidos">
		<h2>Relatório dos Pedidos</h2>
	</div>
	<!-- RELATÓRIO DOS PEDIDOS -->
	<?php
}

else
{
	header('location:http://localhost/treinos/php/siteCompleto/login');
}


// $result = verificaLogado("diegoac");
// var_dump($result);
// if(empty($result))
// {
// 	echo 'nao logado';
// 	header('location:http://localhost/treinos/php/siteCompleto/login');
// }
// else
// {

// }

?>

</div>