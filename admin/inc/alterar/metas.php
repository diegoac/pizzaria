<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny_mce/tinymce.min.js"></script>
<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny.js"></script>

<?php
if(isset($_POST['update_metas']))
{
	var_dump($_POST);
	$texto = obrigatorio("texto", $_POST['meta_text']);

	global $obrigatorio;

	if(!isset($obrigatorio))
	{
		$id = $_POST['id'];

		if(alterarMeta(trim($texto), $id))
		{
			$mensagem = "Meta atualizada com sucesso";
		}
		else
		{
			$erro = "Erro ao atualizar meta, tente novamente";
		}
	}
	else
	{
		$erro = $obrigatorio;
	}
}
?>
<div class="formularioAlterar">

	<h2> .: ALTERAR METAS :. <h2>

	<table width="800">
		<tr>
			<td>Descrição</td>
			<form action="" method="POST">
				<td align="center">
				
					<?php
					$dadosMetas = pegarPeloId('metas', 'meta_type', 1); 
					?>
					<input type="hidden" name="id" value="<?php echo $dadosMetas['meta_id'];?>">
					<textarea name="meta_text">
						<?php echo $dadosMetas['meta_text'];?>
					</textarea>	
				</td>
				<td>
					<input type="submit" name="update_metas" value="Atualizar" class="input_button">
				</td>
			</form>
		</tr>
		<tr>
			<td>Keywords</td>
			<form action="" method="POST">
				<td align="center">>
					
					<?php $dadosMetas = pegarPeloId('metas', 'meta_type', 2);?>
					<input type="hidden" name="id" value="<?php echo $dadosMetas['meta_id'];?>">
					<textarea name="meta_text">
						<?php echo $dadosMetas['meta_text'];?>
					</textarea>
					
				</td>
				<td>
					<input type="submit" name="update_metas" value="Atualizar" class="input_button">
				</td>
			</form>
		</tr>
		<tr>
			<td colspan="3" align="center">
			<?php
			if(isset($erro))
			{
				//echo '<td colspan="10" align="center" class="erro">';
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
				//echo '</td>';
			}
			?>
			<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
			</td>
		</tr>
	</table>

</div>