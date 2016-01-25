<?php
unset($_SESSION);

if(isset($_GET['id']))
{
	try{
		if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
		{
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

			// DELETAR REGISTRO DO BANCO
			if(deletar("administrador", "administrador_id", $id))
			{
				$mensagem = "Cliente deletado com sucesso";
			}
			else
			{
				$erro = "Erro ao deletar administrador";
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
	<h2>:. DELETAR ADMINISTRADOR .:</h2>
	

		<table width="600">
			<?php

			$admin = listar("administrador");
			if(!empty($admin))
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
			    'itemData'   => $admin
			);
			$pager = @Pager::factory($params);
			$data  = $pager->getPageData();
			//var_dump($data);
			if(!empty($admin))
			{

				foreach ($admin as $c) {
				?>

				<tr>
					<td><?php echo $c['administrador_name'];?></td>
					<td align="center"><a href="?p=deletar_administrador&id=<?php echo $c['administrador_id'];?>">Deletar</a></td>
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
	<td colspan='2' align="center">Nenhum administrador cadastrado</td>
	<?php } ?>
	</table>

</div>