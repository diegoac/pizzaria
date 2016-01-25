<div id="areaCliente">

<?php
session_start();
// $_SESSION = array();
//session_destroy();
/* LIMPAR PEDIDO */

if(isset($_GET['ac']) == 'l')
{
	echo "Limpar";
}

/* VERIFICA SE CLIENTE ESTÁ LOGADO */

// if(isset($_SESSION['logado_cliente']))
// {
	// exemplo
	//session_destroy($_SESSION);
	// $_SESSION = array();
	// $_SESSION['pedido']['name'] = 10;
	//
	if(!empty($_SESSION['pedido']))
	{
		?>

		<h2>Pedidos de Hoje:</h2>
		<table width="800" cellspacing="0">
			<thead>
				<tr>
					<td>Nome</td>
					<td>Preço</td>
					<td>Quantidade</td>
					<td>Subtotal</td>
				</tr>
			</thead>
			<tbody>
				<form action="" method="post"></form>
				<?php
				$total = "";
				$d = new ArrayIterator($_SESSION['pedido']);
				// var_dump($_SESSION);
				//var_dump($d);
				while($d->valid())
				{
					//var_dump($d->key());
					var_dump($d->current());
					//echo $d->current();
					$pedido = pegarPeloId('pizzas', 'pizza_id', $d->current());
					var_dump($pedido);
				?>
				<tr>
					<td><?php echo $pedido['pizza_name'];?></td>
					<td>R$ <?php echo number_format($pedido['pizza_price'],2,",","."); ?></td>
					<td><?php echo $d->current();?></td>
					<td>R$ <?php echo number_format($d->current() * $pedido['pizza_price'],2,",","."); ?></td>
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
						<a href="http://localhost/treinos/php/siteCompleto/clientes/&ac=l" class="botaoCliente">Limpar Pedido</a>
					</td>
				</tr>
			</tfoot>
		</table>

		<?php
	}
	else
	{
		echo "Você ainda não fez nenhum pedido hoje!";
	}
//}
// else
// {
// 	echo "Você não tem permissão para acessar essa área!";
// }


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