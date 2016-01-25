<?php

if(isset($_POST['alterarCategory']))
{
	$nameCategory = obrigatorio("name", $_POST['categoryName']);
	$id = (int) $_POST['id'];
	global $obrigatorio;

	if(empty($obrigatorio))
	{

		if(verificaCadastroAlterar("categories", "category_name", $nameCategory, "category_id", $id))
		{
			if(alterarCategory($nameCategory, $id))
			{
				$mensagem = "";
				$mensagem = "Categoria alterada com sucesso!";
			}
			else
			{
				$erro = "Erro: Não foi possível alterar a categoria.";
			}
		}
		else
		{
			$erro = "Já existe uma categoria com esse nome.";
		}	
	}
	else
	{
		$erro = $obrigatorio;
	}
}
else
{

}

?>

<div class="formularioAlterar">
	<h2>: .ALTERAR CATEGORIA .:</h2>
	<?php
	// require_once '../bibliotecas/Pager/Pager/Pager.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Common.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Jumping.php';


	$dadosCategoria = listar("categories");

	?>

	<table width="300">
		<tr class="cabecalho">
			<td class="cell_pequena">Nome</td>
			<td>Alterar</td>
		</tr>

		<?php
		$params = array(
		    'mode'       => 'Jumping',
		    'perPage'    => 10,
		    'delta'      => 5,
		    'itemData'   => $dadosCategoria
		);
		$pager = @Pager::factory($params);
		$data  = $pager->getPageData();
		//var_dump($data);
		foreach ($data as $d) {
		?>

		<form action="" method="post">
			<tr>
				<input type="hidden" name="id" value="<?php echo $d['category_id'];?>">
				<td><input type="text" name="categoryName" value="<?php echo $d['category_name'];?>"  class="txt_field_completo"/></td>
				<td><input type="submit" name="alterarCategory" value="alterar" class="input_button" /></td>
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

		<div class="obrigatorio">* campos obrigatórios</div>
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