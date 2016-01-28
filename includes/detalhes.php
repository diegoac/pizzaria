<?php
session_start();
global $obrigatorio;
if(isset($_SESSION))
{
	//$_SESSION = array();
	//session_destroy();
}
if(isset($_POST['pedir']))
{
	// var_dump($_POST);
	//$dados_login = verificaLogado($_SESSION['nome_cliente']);
	if(isset($_SESSION['nome_cliente']))
	{
		//var_dump($_POST);
		$qtd = obrigatorio('quantidade', trim($_POST['qtd']));
		$id = $_POST['id'];
		$pizza = $_POST['pizza'];

		if(!isset($obrigatorio))
		{	
			if(!isset($_SESSION['pedido']))
			{
				$_SESSION['pedido'] = array();
			}

			if(empty($_SESSION['pedido'][$pizza]))
			{

				// echo "armazenando valor da quantidade de pizzas<br />";
				// $_SESSION['pedido']['id'] = $id;
				// $_SESSION['pedido']['name'] = $pizza;
				$_SESSION['pedido'][$pizza] = $qtd;
			}
			else
			{
				if(!empty($qtd))
				{
					$_SESSION['pedido'][$pizza] += $qtd;
				}
				else
				{
					$_SESSION['pedido'][$pizza] += 1;
				}
			}
			$totalDaPizza = $_SESSION['pedido'][$pizza];
		}
		else
		{
			$erro = $obrigatorio;
		}		
	}
	else
	{
		$erro = "Você precisa estar logado para fazer o pedido.";
	}
}


?>


	
	
</div>

<div id="detalhes">
<?php

	if(isset($_GET['p']))
	{
		$explodeUrl = explode('/', $_GET['p']);
		$pizza = $explodeUrl[1];


		// Recupere a row pela url
		$pizzaEscolhida = pegarPeloid("pizzas", "pizza_name_url", $pizza);
		//var_dump($pizzaEscolhida);
		?>
		<h1><?php echo $pizzaEscolhida['pizza_name'];?></h1>
		<div id="fotoPizzaDetalhes">
			<img src="../<?php echo $pizzaEscolhida['pizza_foto_detalhes'];?>" title="<?php echo $pizzaEscolhida['pizza_name'];?>">
		</div>
		<div id="detalhesPizza">
			<?php echo $pizzaEscolhida['pizza_description'];?>
			<br />
			<?php echo "R$ " .number_format($pizzaEscolhida['pizza_price'],2,",",".");?>
		</div>

		<div id="add_pedido">
			<!-- PEGAR ID DO CLIENTE -->
			<?php
			if(isset($_SESSION['nome_cliente']))
			{
				$id = pegarPeloid('clients', 'client_name', $_SESSION['nome_cliente']);
			}
			?>
			<!-- PEGAR ID DO CLIENTE -->
			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo isset($_SESSION['nome_cliente']) ? $id['client_id'] : '';?>"/>
				<input type="hidden" name="pizza" value="<?php echo $pizzaEscolhida['pizza_id'];?>"/>
				<label for="quantidade">Quantidade</label>
				<input type="text" id="txt_qtd" name="qtd" />
				<input type="submit" id="txt_qtd" name="pedir" value="adicionar pedido" />
			</form>
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
					echo '<div class=erro>' .$erro. '</div><br />';
				}
			}
			else
			{
				$erro = $obrigatorio;
			}

		?>
			<p>Pedidos dessa pizza: <?php echo isset($totalDaPizza)? $totalDaPizza : "0";	?>	</p>
		</div>
<?php
	}
	else
	{
		include_once 'includes/404.php';
	}
?>
</div>
