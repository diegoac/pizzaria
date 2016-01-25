<?php
unset($_SESSION);
require_once "../bibliotecas/lib/WideImage.php";

if(isset($_GET['id']))
{
	try{
		if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
		{
			// PEGAR FOTO PELO ID
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			//echo $id;
			$foto = PegarPeloId('pizzas', 'pizza_id', $id);
			$fotosPastas = array();

			if(empty($foto))
			{
				$erro = "Foto já deletada";
			}
			else
			{
				$fotoInicial = $foto['pizza_foto_inicio'];
				$fotoInicio = explode("/", $fotoInicial);

				$fotoDetalhes = $foto['pizza_foto_detalhes'];
				$fotoD = explode("/", $fotoDetalhes);
				
				$dir = "../../fotos";

				//$directories = array("../../fotos", "../../detalhes");

				// foreach($directories as $dir)
				// {
				$d = new DirectoryIterator("../../fotos");
				while($d->valid())
				{
					if($d->isFile())
					{
						$fotosPastas[] = $d->getFilename();
					}
					$d->next();
				}

				if(in_array($fotoInicio[1], $fotosPastas) AND in_array($fotoD[1], $fotosPastas))
				{
					if(unlink("../../fotos/" .$fotoInicio[1]))
					{
						if(unlink("../../detalhes/" .$fotoD[1]))
						{
							$mensagem = "Foto deletada com sucesso";
						}
						else
						{
							$erro = "Erro ao deletar foto detalhes";
						}
					}
					else
					{
						$erro = "Erro ao deletar foto inicial";
					}
				}
				//}			
			}

			
		}
		else
		{
			throw new Exception("O numero passado pela url deve ser inteiro");
		}
	}catch(Exception $e){
		echo "Erro: " . $e->getMessage();
	}
}
?>

<div class="formularioDeletar">
	<h2>:. DELETAR FOTO .:</h2>
	

		<table width="600">
			<?php

			$pizzas = listar("pizzas", $parametros = ' INNER JOIN categories ON pizzas.pizza_categories = categories.category_id');
			if(!empty($pizzas))
			{
			?>
			<tr class="cabecalho">
				<td>Foto</td>
				<td>Nome</td>
				<td>Deletar</td>
			</tr>

			<?php
			$params = array(
			    'mode'       => 'Jumping',
			    'perPage'    => 10,
			    'delta'      => 5,
			    'itemData'   => $pizzas
			);
			$pager = @Pager::factory($params);
			$data  = $pager->getPageData();
			//var_dump($data);

			foreach ($pizzas as $p) {
			?>

			<tr>
				<td align="center">
					<img src="<?php echo "../../" . $p['pizza_foto_inicio'];?>">
				</td>
				<td><?php echo $p['pizza_name'];?></td>
				<td align="center"><a href="?p=deletar_foto&id=<?php echo $p['pizza_id'];?>">Deletar</a></td>
			</tr>

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
							foreach ($erro as $err)
							{
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

		
	<?php } else {?>
	<td colspan='2' align="center">Nenhuma pizza cadastrada</td>
	<?php } ?>
	</table>

</div>