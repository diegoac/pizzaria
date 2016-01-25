<?php

if(isset($_POST['cadastrarMeta']))
{
	var_dump($_POST);
	if(verificaCadastro("metas", "meta_type", $_POST['meta']))
	{
		if(cadastrarMeta($_POST['meta'], $_POST['metas']))
		{
			$mensagem = "";
			$mensagem = "Meta cadastrada com sucesso";
		}
		else
		{
			$erro = "Erro ao cadastrar meta";
		}
	}
	else
	{
		$erro = "Já existe uma meta cadastrada para esse campo";
	}
}

?>
<!-- <script type="text/javascript" src="js/meta.js"></script> -->
<div class="formularioCadastro">
	<h2>: .CADASTRAR META-TAGS. :</h2>
	<p>Escolha qual metatag você quer alterar:</p>
	<div id="metas">
		<form action="" method="POST">
			<label for="description">description</label>
			<input type="radio" name="meta" value="description"></input>

			<label for="keywords">Keywords</label>
			<input type="radio" name="meta" value="keywords"></input>
		</form>
	</div>

	<div id="resposta">
		resposta
	</div>
</div>
<div class="obrigatorio">* campos obrigatórios</div>
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
					echo '<div class="erro">' . $err . '</div><br />';
				}
			}
		}
		else
		{
			echo $erro;
		}
	}
?>