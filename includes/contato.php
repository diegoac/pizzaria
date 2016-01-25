<?php

require_once "admin/bibliotecas/PHPMailer/class.phpmailer.php";
require_once "admin/bibliotecas/PHPMailer/class.phpmailer.php";
require_once "admin/bibliotecas/PHPMailer/PHPMailerAutoload.php";

global $obrigatorio;
if(isset($_POST['enviarContato']))
{

	$name = obrigatorio("name", $_POST['name']);
	$email = obrigatorio("email", $_POST['email']);
	$phone = obrigatorio("phone", $_POST['phone']);
	$city = obrigatorio("city", $_POST['city']);
	$assunto = obrigatorio("assunto", $_POST['assunto']);
	$msg = obrigatorio("msg", $_POST['msg']);

	if(!isset($obrigatorio))
	{
		/* ENVIAR EMAIL */
		if(enviarEmail($name, $email, $assunto, $phone, $msg))
		{
			$mensagem = "Email enviado com sucesso!";
		}
		else
		{
			$erro = "Erro ao enviar email";
		}
	}
	else
	{
		$erro = $obrigatorio;
	}
}

?>

<div id="contato" class="txt">
	<h1>Contato</h1>
	<form action="" method="post">
		<label for="name">Nome:</label>
		<input type="text" name="name" />
		<label for="">Email</label>
		<input type="text" name="email" />
		<label for="">Telefone</label>
		<input type="text" name="phone" class="txt_field_menor" />
		<label for="">Cidade</label>
		<input type="text" name="city" class="txt_field" />
		<label for="">Assunto</label>
		<input type="text" name="assunto" class="txt_field_maior" />
		<label for="">Mensagem</label>
		<textarea name="msg" id="msg"></textarea>
		<input type="submit" name="enviarContato" class="bt_submit" value="cadastrar"></input>
		<input type="submit" name="limparCampos" class="bt_submit" value="limpar campos"></input>
	</form>
	<div class="obrigatorio">* campos obrigatórios</div>
	<?php echo isset($mensagem) ? '<div class="mensagem">' .$mensagem.'</div>' : ""; ?>
	<?php
		if(isset($erro))
		{
			echo '<br /><p>Por favor, Corrija os seguintes erros:</p><br />';
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
				echo '<div class=erro>' .$erro. '</div><br />';
			}
		}
		else
		{
			$erro = $obrigatorio;
		}
	?>

	</div>
</div>