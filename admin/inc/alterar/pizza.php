<?php
unset($_SESSION);
require_once "../bibliotecas/lib/WideImage.php";

if($_SERVER['REQUEST_METHOD'] == "POST" AND isset($_POST['alterarPizza']))
{
	//var_dump($_POST);
	echo $_POST['category_pizza'];
	$namePizza = obrigatorio("nome", addslashes($_POST['name_pizza']));
	$categoryPizza = obrigatorio("categoria", addslashes($_POST['category_pizza']));
	$descriptionPizza = addslashes(obrigatorio("descrição", $_POST['description_pizza']));
	$pricePizza = obrigatorio("preço", addslashes($_POST['price_pizza']));
	$id =  obrigatorio("id", $_POST['id']);
	//$fotoPizza = obrigatorio("foto", $_FILES['foto_pizza']['name']);
	

	criaSessao("namePizza", $namePizza);
	criaSessao("categoryPizza", $categoryPizza);
	criaSessao("pricePizza", $pricePizza);
	criaSessao("descriptionPizza", $descriptionPizza);

	global $obrigatorio;

	if(empty($obrigatorio))
	{
		
		if(alterarPizza($dadosPizza = array(
			"name" => $namePizza,
			"category" => $categoryPizza,
			"price" => $pricePizza,
			"description" => $descriptionPizza,
			"id" => $id
			)
		))
		{
			$msg = "";
			$msg = "Pizza alterada com sucesso";
		}
		else
		{
			$erro = "Erro ao alterar pizza";
		}
				
	}
	else
	{
		$erro = $obrigatorio;
	}
}

/* PARA LIMPAR FORMULÁRIO */
if(isset($_POST['limparCampos']))
{
	unset($_SESSION);
}

?>

<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny.js"></script>

<div class="formularioAlterar">
	<h2>:. ALTERAR PIZZA .:</h2>
	<?php
	// require_once '../bibliotecas/Pager/Pager/Pager.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Common.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Jumping.php';


	$listarPizzas = listar("pizzas", $parametros = ' INNER JOIN categories ON pizzas.pizza_categories = categories.category_id');
	?>

	<table width="600">
		<tr class="cabecalho">
			<td>Nome</td>
			<td>Categoria</td>
			<td>Preço</td>
			<td width="100">Descrição</td>
			<td>Alterar</td>
		</tr>

		<?php
		$params = array(
		    'mode'       => 'Jumping',
		    'perPage'    => 10,
		    'delta'      => 5,
		    'itemData'   => $listarPizzas
		);
		$pager = @Pager::factory($params);
		$data  = $pager->getPageData();
		//var_dump($data);


		foreach ($data as $d) {
		?>

		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $d['pizza_id'];?>">
			<tr>
				<td><input type="text" name="name_pizza" value="<?php echo $d['pizza_name'];?>" class="txt_field" /> </td>
				<input type="hidden" name="url">
				<td>
					<?php
					// LISTAGEM DAS CATEGORIAS
						$cat = listar('categories');
						//var_dump($cat);
					?>
					<select name="category_pizza" class="select_field">
						<?php foreach($cat as $c) { ?>	

						<option value="<?php echo $c['category_id'];?>" <?php echo $c['category_name'] == $d['category_name'] ? "selected='selected'" : $c['category_name'];?>>
							<?php echo $c['category_name']; ?>
						</option>
						<?php } ?>
					</select>
				</td>
				<td><input type="text" name="price_pizza" value="<?php echo $d['pizza_price'];?>" class="txt_field" /> </td>
				<td>
					<textarea name="description_pizza">
						<?php echo $d['pizza_description'];?>
					</textarea>
				</td>
				
				<td class="buttons"><input type="submit" name="alterarPizza" value="alterar" class="input_button"/></td>
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