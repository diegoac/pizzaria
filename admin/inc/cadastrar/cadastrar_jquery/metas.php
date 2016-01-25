
<?php

include "../../../functions/conexao/conexao.php";

$pdo = conectar();
$type = $_POST['escolhido'];



/* PEGA ID NO BD DO TIPO DE META ESCOLHIDO*/
// $pegaId = $pdo->prepare("SELECT meta_type_id FROM meta_types WHERE meta_type_name='$type'");
// $pegaId->execute();
// $metaTypeId = $pegaId->fetch(PDO::FETCH_ASSOC);



try {
	$verificarCadastro = $pdo->prepare("SELECT * FROM metas INNER JOIN meta_types
									   ON metas.meta_type = meta_types.meta_type_id
									   WHERE meta_type_name = :type");

	$verificarCadastro->bindValue(":type", $type);
	$result = $verificarCadastro->execute();

	if($verificarCadastro->rowCount() == 1)
	{
		echo "Já existe uma meta para esse campo!";
	}
	else
	{
		switch($type)
		{
			case "description":
				$type = 1;
			case "keywords":
				$type = 2;
		}
	?>
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny_mce/tinymce.min.js"></script>
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny.js"></script>

	
	<form action="" method="POST">
		<textarea name="metas"></textarea>
		<input type="hidden" name="meta" value="<?php echo $type;?>" />
		
		<input type="submit" name="cadastrarMeta" class="bt_submit" value="cadastrar">

	</form>
	
	<?php		
	}

} catch(PDOException $e){
	echo "Erro ao verificar cadastro das metas: " . $e->getMessage();
}

?>