<?php
require_once "../bibliotecas/lib/WideImage.php";

if(isset($_POST['alterarFoto']))
{

	if(isset($_POST['id']))	
	{
		$id = (int) $_POST['id'];
		$foto = obrigatorio("foto", $_FILES['novaFoto']['name']);
		global $obrigatorio;

		if(!isset($obrigatorio))
		{
			$id = (int) $_POST['id'];
			$dados = pegarPeloId("pizzas", "pizza_id", $id);

			$fotoInicio = $dados['pizza_foto_inicio'];
			$fotoDetalhes = $dados['pizza_foto_detalhes'];

			/* RENOMEAR FOTO */
			$str = explode(".", $foto);
			$extensao = end($str);
			$novoNome = uniqid() . "." . $extensao;

			try {

				if(is_file("../../" . $fotoInicio))
				{
					if(is_file("../../" . $fotoDetalhes))
					{
						if(unlink("../../" . $fotoInicio))
						{
							if(unlink("../../" . $fotoDetalhes))
							{
								/* PEGAR FOTO PARA UPDATE */
								$temp = $_FILES['novaFoto']['tmp_name'];

								/*UPLOAD DA FOTO */
								try{
									/* PASTA FOTOS/ */
									$fotos = WideImage::load($temp);
									$redimensionar = $fotos->resize(105, 80, "fill");
									$redimensionar->saveToFile("../../fotos/" . $novoNome);
									if($redimensionar->isValid())
									{
										/* PASTA DETALHES/ */
										$redimensionarFotoDetalhes = $fotos->resize(270, 210, "fill");
										$redimensionarFotoDetalhes->saveToFile("../../detalhes/" . $novoNome);
										if($redimensionarFotoDetalhes->isValid())
										{
											/* ALTERAR FOTO NO BANCO */
											if(alterarFoto($novoNome, $id))
											{
												$mensagem = "Foto alterada com sucesso";
											}
											else
											{
												$erro = "Erro ao alterar foto";
											}
										}
										else
										{
											throw new WideImage_Exception("Erro ao fazer upload da foto detalhes");
										}

									}
									else
									{
										throw new WideImage_Exception("Erro ao fazer upload da foto inicial");
									}
								} catch(WideImage_Exception $e){
									echo "Erro ".$e->getMessage();
								}
								
							}
							else
							{
								throw new Exception("Erro ao deletar foto inicial");
							}
						}
						else
						{
							throw new Exception("Erro ao deletar foto detalhes");
						}
					}
					else
					{
						throw new Exception("Erro: A foto detalhes não existe mais!");
					}
				}
				else
				{
					throw new Exception("Erro: A foto inicial não existe mais!");
				}
				
			}catch(Exception $e)
			{
				echo $e->getMessage();
				die;
			}
			
		} // obrigatório
		else
		{
			$erro = $obrigatorio;
		}
	} // se isset post_id
	else
	{
		$erro = "Não foi possível pegar o ID da pizza";
	}
} // se clicou em alterar


?>


<div class="formularioAlterar">
	<h2>:. ALTERAR FOTO .:</h2>
	<?php
	// require_once '../bibliotecas/Pager/Pager/Pager.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Common.php';
	// require_once '../bibliotecas/Pager/Pager/Pager/Jumping.php';


	$listarPizzas = listar("pizzas", $parametros = ' INNER JOIN categories ON pizzas.pizza_categories = categories.category_id');
	?>

	<table width="600">
		<tr class="cabecalho">
			<td width="130">Nome</td>
			<td width="130">Categoria</td>
			<td width="80">Foto</td>
			<td width="200">Arquivo</td>
			<td width="80">Alterar</td>
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
			<tr>
				<input type="hidden" name="id" value="<?php echo $d['pizza_id'];?>">
				<td><?php echo $d['pizza_name'];?> </td>
				<td><?php echo $d['category_name'];?></td>
				<td><img src="<?php echo "../../".$d['pizza_foto_inicio'];?>" style="width: 200px; height: 150px;"></td>
				<td><input type="file" name="novaFoto"  class="txt_field_completo"/></td>
				<td class="buttons"><input type="submit" name="alterarFoto" value="alterar" class="input_button"/></td>
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