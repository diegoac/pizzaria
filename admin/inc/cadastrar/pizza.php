<?php
unset($_SESSION);
require_once "../bibliotecas/lib/WideImage.php";

if($_SERVER['REQUEST_METHOD'] == "POST" AND isset($_POST['cadastrarPizza']))
{
	// var_dump($_SESSION);
	$categoryPizza = obrigatorio("categoria", addslashes($_POST['category']));
	$namePizza = obrigatorio("nome", addslashes($_POST['name']));
	$pricePizza = obrigatorio("preço", addslashes($_POST['price']));
	$fotoPizza = obrigatorio("foto", $_FILES['foto_pizza']['name']);
	$descriptionPizza = addslashes(obrigatorio("descrição", $_POST['description']));

	criaSessao("namePizza", $namePizza);
	criaSessao("pricePizza", $pricePizza);
	criaSessao("descriptionPizza", $descriptionPizza);

	global $obrigatorio;

	if(empty($obrigatorio))
	{
		$foto = $_FILES['foto_pizza']['name'];
		$temp = $_FILES['foto_pizza']['tmp_name'];

		/* RENOMEAR FOTO */
		$str = explode(".", $fotoPizza);
		$extensao = end($str);
		$novoNome = uniqid() . "." . $extensao;

		try{
			$fotos = WideImage::load($temp);
			$redimensionar = $fotos->resize(105, 80, "fill");
			$redimensionar->saveToFile("../../fotos/". $novoNome);

			if(verificaCadastro("pizzas", "pizza_name", $_POST['name']))
			{
				
				if($redimensionar->isValid())
				{
					$redimensionar = $fotos->resize(270, 210, "fill");
					$redimensionar->saveToFile("../../detalhes/" . $novoNome);

					if(cadastrarPizza($dadosPizza = array(
						"category" => $_POST['category'],
						"name" => $namePizza,
						"price" => $_POST['price'],
						"description" => $_POST['description'],
						"fotoInicio" => "fotos/" . $novoNome,
						"fotoDetalhes" => "detalhes/" . $novoNome
						)
					))
					{
						$msg = "";
						$msg = "Pizza cadastrada com sucesso";
					}
					else
					{
						$erro = "Erro ao cadastrar pizza";
					}
				}
				else
				{
					throw new Exception ("Não foi possível redimensionar a foto");
				}
			}
			else
			{
				$erro = "Já existe uma pizza cadastrada com esse nome";
			}
			
		}catch(WideImage_InvalidImageSourceException $e) {
			echo "Erro: " . $e->getMessage();
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

<div class="formulario_cadastro">
	<div class="formCadastro">
		<form action="" method="post" enctype="multipart/form-data">
			<!-- enctype -> pegar os dados das fotos -->
			<label for="category">Categoria:</label>
			<select name="category">
				<option value="" selected="selected">Escolha  uma categoria:</option>
				<?php
					$dados = listar("categories");
					if($dados)
					{
						var_dump($dados);
						foreach($dados as $d)
						{
						?>
						<option value="<?php echo $d['category_id'];?>"><?php echo $d['category_name'];?></option>
						<?php
						}
					}
					else
					{
						?>
						<option value="" selected="selected">Nenhuma categoria cadastrada</option>
						<?php
					}
				?>
				
			</select>
			<label for="name">Nome da Pizza:</label>
			<input type="text" name="name" class="txt_field" value="<?php echo isset($_SESSION['namePizza']) ? $_SESSION['namePizza'] : ""; ?>"/>
			<input type="hidden" name="url">
			<label for="price">Preço:</label>
			<input type="text" name="price" class="txt_field" value="<?php echo isset($_SESSION['pricePizza']) ? $_SESSION['pricePizza'] : ""; ?>"/>

			<label for="pic">Foto:</label>
			<input type="file" name="foto_pizza" />

			<label for="description">Descrição:</label>
			<textarea name="description"><?php echo isset($_SESSION['descriptionPizza']) ? $_SESSION['descriptionPizza'] : ""; ?></textarea>

			<label for="submit"></label>
			<input type="submit" name="cadastrarPizza" class="bt_submit" value="cadastrar"></input>
			<input type="reset" name="limparCampos" class="bt_submit" value="limpar campos"></input>
		</form>
	</div>
</div>

<div class="obrigatorio">* campos obrigatórios</div>
	<?php echo isset($msg) ? '<div class="mensagem">' .$msg.'</div>' : ""; ?>
	<?php
		if(isset($erro))
		{
			echo '<br /><p>Por favor, Corrija os seguintes erros:</p><br />';
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
	?>