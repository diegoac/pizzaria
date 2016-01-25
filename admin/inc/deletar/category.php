<?php
unset($_SESSION);

if(isset($_GET['id']))
{
	try{
		if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
		{
			$id = $_GET['id'];

			$idPizza = pegarPeloId('pizzas', 'pizza_categories', $id);

			if(empty($idPizza))
			{
				$erro = "Nenhuma pizza cadastrada para essa categoria";
			}
			else
			{
				$foto = pegarPeloId('pizzas', 'pizza_id', $idPizza['pizza_id']);
				$fotosPastas = array();
			
				if(empty($foto))
				{
					$erro = "Pizza já deletada";
				}
				else
				{
					// DELETAR FOTOS DO BANCO
					if(deletarFoto($foto['pizza_foto_inicio'], $foto['pizza_foto_detalhes'], '../../fotos'))
					{
						// DELETAR PIZZA
						if(deletar("pizzas", "pizza_id", $idPizza['pizza_id']))
						{
							// DELETAR CATEGORIA
							if(deletar("categories", "category_id", $id))
							{
								$mensagem = "Categoria deletada com sucesso";
							}
							else
							{
								$erro = "Erro ao deletar categoria";
							}
						}
						else
						{
							$erro = "Erro ao deletar pizza";
						}
						
					}
					else
					{
						$erro = "Erro ao deletar as fotos";
					}
				}
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
	<h2>:. DELETAR CATEGORIA .:</h2>
	

	<table width="600">
		<?php

		$categories = listar("categories");
		if(!empty($categories))
		{
		?>
			<tr class="cabecalho">
				<td>Nome</td>
				<td>Deletar</td>
			</tr>

			<?php
			$params = array(
			    'mode'       => 'Jumping',
			    'perPage'    => 10,
			    'delta'      => 5,
			    'itemData'   => $categories
			);
			$pager = @Pager::factory($params);
			$data  = $pager->getPageData();
			//var_dump($data);
			if(!empty($categories))
			{

				foreach ($categories as $c)
				{
				?>

				<tr>
					<td><?php echo $c['category_name'];?></td>
					<td align="center"><a href="?p=deletar_category&id=<?php echo $c['category_id'];?>">Deletar</a></td>
				</tr>

				<?php
				}
				?>
			<?php
			}
			?>

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
		<?php
		}
		else
		{
		?>
		<td colspan='2' align="center">Nenhuma categoria cadastrada</td>
		<?php
		}
		?>
	</table>

</div>