<?php
session_start();

if(isset($_SESSION))
{
	//$_SESSION = array();
	//session_destroy();
}
if(isset($_POST['pedir']))
{
	// var_dump($_POST);
	$dados_login = verificaLogado("diegoac");
	if(!empty($dados_login))
	{
		var_dump($_POST);
		$qtd = obrigatorio('quantidade', trim($_POST['qtd']));
		$id = $_POST['id'];
		$pizza = $_POST['pizza'];

		global $obrigatorio;

		if(!isset($obrigatorio))
		{	
			if(!isset($_SESSION['pedido']))
			{
				echo "inicializando variável de sessão<br />";
				$_SESSION = array();
			}

			if(empty($_SESSION['pedido']['name']))
			{

				echo "armazenando valor da quantidade de pizzas<br />";
				$_SESSION['pedido']['id'] = $id;
				$_SESSION['pedido']['name'] = $pizza;
				$_SESSION['pedido']['qtd'] = $qtd;
			}
			else
			{
				if(!empty($qtd))
				{
					$_SESSION['pedido']['qtd'] += $qtd;
				}
				else
				{
					$_SESSION['pedido']['qtd'] += 1;
				}
			}
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

<div id="logarCliente">
	<?php

	if(!isset($_SESSION['logado_cliente']))
	{
		

		//header('location:http://localhost/treinos/php/siteCompleto/login');
	}
	else
	{
		echo "Seja bem vindo, " . $_SESSION['nome_cliente'];
	?>
	<a href="?ac=logout">Sair</a>
	<?php
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
			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $pizzaEscolhida['pizza_id'];?>"/>
				<input type="hidden" name="pizza" value="<?php echo $pizzaEscolhida['pizza_name'];?>"/>
				<label for="quantidade">Quantidade</label>
				<input type="text" id="txt_qtd" name="qtd" />
				<input type="submit" id="txt_qtd" name="pedir" value="adicionar pedido" />
			</form>
		</div>
<?php
	}
	else
	{
		include_once 'includes/404.php';
	}
?>
</div>
