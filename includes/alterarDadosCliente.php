<script src="http://localhost/treinos/php/siteCompleto/js/jquery.js"></script>
<script src="http://localhost/treinos/php/siteCompleto/js/validate.js"></script>
<script src="http://localhost/treinos/php/siteCompleto/js/jquery.mask.min.js"></script>
<script src="http://localhost/treinos/php/siteCompleto/js/maskInputs.js"></script>
<script src="http://localhost/treinos/php/siteCompleto/js/alterarDadosCliente.js"></script>

<!-- BOTAO SAIR QUE APARECE AO CLICAR EM ALTERAR DADOS CLIENTE -->
<div id="sairAlterar"><img id="botaoSair" src="http://localhost/treinos/php/siteCompleto/images/icons/delete.png" width="16" height="16" /></div>
<!-- BOTAO SAIR QUE APARECE AO CLICAR EM ALTERAR DADOS CLIENTE -->
<?php
include_once '../functions/conexao/conexao.php';
include_once '../functions/helpers/utils.php';

/* LISTAGEM DOS DADOS DO CLIENTE */
	$dadosCliente = pegarPeloId("clients", "client_id", $_POST['id']);
	$d = new ArrayIterator($dadosCliente);
	if(isset( $d['client_birthday']))
	{
		$birthday_aux = explode('-', $d['client_birthday']);
		$client_birthday = $birthday_aux[2] . "/" . $birthday_aux[1] . "/" . $birthday_aux[0];
	}
	
?>
<form action="" method="post" id="formularioCadastro">
	<input type="hidden" name="id" id="name" value="<?php echo $d['client_id'];?>" />
	<label for="name">Nome:</label>
	<input type="text" name="name" id="name" value="<?php echo $d['client_name'];?>" /> *
	<label for="">Cidade</label>
	<input type="text" name="city" id="city" value="<?php echo $d['client_city'];?>"/> *
	<label for="">Estado</label>
	<input type="text" name="state" id="state" value="<?php echo $d['client_state'];?>"/> *
	<label for="">Bairro</label>
	<input type="text" name="neighborhood" id="neighborhood" value="<?php echo $d['client_neighborhood'];?>"/> *
	<label for="">CEP</label>
	<input type="text" name="cep" class="txt_field_menor" id="cep" value="<?php echo $d['client_cep'];?>"/> *
	<label for="">Telefone</label>
	<input type="text" name="phone" class="txt_field_menor" id="phone" value="<?php echo $d['client_phone'];?>"/> *
	<label for="">Celular</label>
	<input type="text" name="cellphone" class="txt_field_menor" id="cellphone" value="<?php echo $d['client_cellphone'];?>"/> *
	<label for="">Email</label>
	<input type="text" name="email" class="txt_field" id="email" value="<?php echo $d['client_email'];?>"/> *
	<label for="">Endereço</label>
	<input type="text" name="address" class="txt_field_maior" id="address" value="<?php echo $d['client_address'];?>"/> *
	<label for="">Data de Nascimento</label>
	<input type="text" name="birthday" class="txt_field" id="birthday" value="<?php echo $client_birthday;?>"/> *
	<label for="">Login</label>
	<input type="text" name="login" class="txt_field" id="login" value="<?php echo $d['client_login'];?>"/> *
	<label for="">Senha</label>
	<input type="password" name="password" class="txt_field" id="password" value="<?php echo $d['client_password'];?>"/> *
	<input type="submit" name="cadastrarClient" class="bt_submit" value="cadastrar"></input>
</form>