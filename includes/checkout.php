<?php

/*
*
* 1- verificar se existe pedidos no carrinho
* 2- verificar se cliente está logado
* 3- colocar opção de pagamento
*/
session_start();

if(isset($_POST['fecharPedido']))
{
	$cep = obrigatorio("cep", $_POST['cep']);
	$pagamento = $_POST['pagamento'];

	if(!isset($obrigatorio))
	{

	}
	else
	{
		$erro = $obrigatorio;
	}
}
if(isset($_SESSION['logado_cliente']))
{
	if(!empty($_SESSION['pedido']))
	{
	?>
	<!-- TABELA DA LISTAGEM DOS PEDIDOS -->
	<form action="" method="post">
	<table width="800" cellspacing="0">
		<tr>
			<td colspan="5" align="center" id="cabecalho_pedido">Seu pedido de hoje</td>

		</tr>
	<?php
		// Fazer o pedido
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
		<tr>
			<td>
				<input type="submit" name="fecharPedido" value="fazer pedido" class="botaoCliente"><br />
				<input type="radio" name="pagamento" value="entregar" checked="checked">Pagar ou receber a pizza<br /><br />
				<input type="radio" name="pagamento" value="buscar">Pagar ao buscar a pizza<br />
				CEP <input type="text" name="cep" />
			</td>
		</tr>
		</table>
		<!-- TABELA DA LISTAGEM DOS PEDIDOS -->
		<?php
	}
	else
	{
		$erro = "Escolha ao menos uma pizza para fechar o pedido.";
	}
}
else
{
	$erro = "Você deve estar logado para fechar o pedido.";
}

?>

<?php
	if(isset($erro))
	{
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