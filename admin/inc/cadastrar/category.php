<?php

if(isset($_POST['cadastrarCategoria']))
{
	$category = obrigatorio("Categoria", addslashes($_POST['categoria']));

	global $obrigatorio;

	if(empty($obrigatorio))
	{
		if(verificaCadastro("categories", "category_name", $category)) {
			if(cadastrarCategory($category)) {
				$mensagem = "Categoria cadastrada com sucesso!";
			}
			else
			{
				$erro = "Erro ao cadastrar categoria!";
			}
		}
		else {
			$erro = "Essa categoria já existe!";
		}
	}
	else
	{
		$erro = $obrigatorio;
	}
	
}


?>

<div class="formularioCadastro">
	<h2>: .CADASTRAR CATEGORIA.:</h2>

	<div class="form">
		<form action="" method="POST">

			<input type="text" name="categoria" class="txt_field"></input> *
			<label for="submit"></label>
			<input type="submit" name="cadastrarCategoria" class="bt_submit" value="cadastrar"></input>
		</form>
	</div>
	<div class="obrigatorio">* campos obrigatórios</div>
	
	<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
	<?php echo isset($erro) ? '<div class="erro">' .$erro.'</div>' : ""; ?>
</div>