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

			/* BUSCAR AS FOTOS NO BANCO */
			$dados = pegarPeloId("pizzas", "pizza_id", $id);
			$fotoInicio = $dados['pizza_foto_inicio'];
			$fotoDetalhes = $dados['pizza_foto_detalhes'];

			/* RENOMEAR FOTO */
			$str = explode(".", $foto);
			$extensao = end($str);
			$novoNome = uniqid() . "." . $extensao;

			/* PEGAR FOTO PARA CADASTRAR NOVA FOTO */
			$temp = $_FILES['novaFoto']['tmp_name'];

			/* ARRAY PARA PEGAR AS FOTOS */
			$fotosCadastradas = array("fotos" => $fotoInicio, "detalhes" => $fotoDetalhes);

			foreach($fotosCadastradas as $k=>$v)
			{

				if(file_exists("../../".$v))
				{
					//Se arquivo existe, o usuário vai querer substituí-lo.
					//apague a foto com esse nome
					unlink("../../".$v);
				}

				$fotos = WideImage::load($temp);
				if($k == "fotos")
				{
					$redimensionar = $fotos->resize(105, 80, "fill");
					$redimensionar->saveToFile("../../$k/" . $novoNome);
				}
				else if($k == "detalhes")
				{
					$redimensionar = $fotos->resize(270, 210, "fill");
					$redimensionar->saveToFile("../../$k/" . $novoNome);
				}

			}

			/* CADASTRAR A FOTO NO BANCO DE DADOS*/
			if(alterarFoto($novoNome, $id))
			{
				$mensagem = "Foto cadastrada com sucesso";
			}
			else
			{
				$erro = "Erro ao cadastrar foto";
			}

		}
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
	<h2>:. CADASTRAR FOTO .:</h2>
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
			<td width="260">Arquivo</td>
			<td width="60">Alterar</td>
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