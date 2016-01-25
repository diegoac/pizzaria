<?php
unset($_SESSION);

if(isset($_GET['id']))
{
	try{
		if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
		{
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

			// DELETAR REGISTRO DO BANCO
			if(deletar("clients", "client_id", $id))
			{
				$mensagem = "Cliente deletado com sucesso";
			}
			else
			{
				$erro = "Erro ao deletar cliente";
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
	<h2>:. DELETAR CLIENTE .:</h2>
	

		<table width="600">
			<?php

			$clients = listar("clients");
			if(!empty($clients))
			{
			?>
			<tr class="cabecalho">
				<td>Nome</td>
				<td>Cidade</td>
				<td>Deletar</td>
			</tr>

			<?php
			$params = array(
			    'mode'       => 'Jumping',
			    'perPage'    => 10,
			    'delta'      => 5,
			    'itemData'   => $clients
			);
			$pager = @Pager::factory($params);
			$data  = $pager->getPageData();
			//var_dump($data);
			if(!empty($clients))
			{

				foreach ($clients as $c) {
				?>

				<tr>
					<td><?php echo $c['client_name'];?></td>
					<td><?php echo $c['client_city'];?></td>
					<td align="center"><a href="?p=deletar_client&id=<?php echo $c['client_id'];?>">Deletar</a></td>
				</tr>

				<?php } ?>
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
	<td colspan='2' align="center">Nenhum cliente cadastrado</td>
	<?php } ?>
	</table>

</div>