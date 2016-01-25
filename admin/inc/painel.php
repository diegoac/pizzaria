<?php
session_start();

include_once '../functions/config/config.php';

try {
	carregaIncludes(array("conexao", "login", "url", "categoria", "utils", "administrador", "client", "meta", "pizza", "Pager", "Common", "Jumping", "foto"), "admin");
} catch(Exception $e) {
	echo $e->getMessage();
}

verificaLogado('logado_admin');

?>

<html>
<head>
	<meta charset=utf-8>
	<meta name=description content="">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<title>Painel Administrativo</title>

	<link rel="stylesheet" type="text/css" href="/treinos/php/siteCompleto/admin/css/style_painel.css">
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/jquery.js"></script>
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/tiny_mce/tinymce.min.js"></script>
	<!-- <script type="text/javascript" src="localhost/treinos/php/siteCompleto/admin/inc/js/tiny.js"></script> -->
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/meta.js"></script>
	<script type="text/javascript" src="/treinos/php/siteCompleto/admin/inc/js/buscar.js"></script>
	

</head>
<body>
	<div id="container">
		<div id="header">
			<div id="logo">
				<a href="http://localhost/treinos/php/siteCompleto/admin/inc/painel.php">Pizzaria da net<br />
					<span id="sublogo">A melhor pizzaria da cidade</span>
				</a>
			</div> <!-- LOGO -->

			<div id="busca">
				<div id="lupa">
					<img src="../images/lupa.png" alt="" style="width:20px; height: 20px;">
				</div>
				<form action="" method="post" id="form_busca">
					<input type="text" name="busca" id="txt_busca" />
					<!-- <input type="submit" name="buscar" id="bt_busca" value="Enviar" /> -->
				</form>
			</div> <!-- BUSCA -->
		</div> <!-- HEADER -->

		<div id="content">
			<div id="menuLateral">
				<ul>
				    <li><a href="?p=cadastrar_pizza">Cadastrar Pizza</a></li>
				     <li><a href="?p=cadastrar_foto">Cadastrar Foto</a></li>
				    <li><a href="?p=cadastrar_client">Cadastrar Cliente</a></li>
				    <li><a href="?p=cadastrar_category">Cadastrar Categoria</a></li>
				    <li><a href="?p=cadastrar_administrador">Cadastrar Administrador</a></li>
				    <li><a href="?p=cadastrar_metas">Cadastrar Metas</a></li>
				</ul>
				<br />
				<ul>
				    <li><a href="?p=alterar_pizza">Alterar Pizza</a></li>
				    <li><a href="?p=alterar_foto">Alterar Foto</a></li>
				    <li><a href="?p=alterar_client">Alterar Cliente</a></li>
				    <li><a href="?p=alterar_categoria">Alterar Categoria</a></li>
				    <li><a href="?p=alterar_administrador">Alterar Administrador</a></li>
				    <li><a href="?p=alterar_metas">Alterar Metas</a></li>
				</ul>
				<br />
				<ul>
				    <li><a href="?p=deletar_pizza">Deletar Pizza</a></li>
				    <li><a href="?p=deletar_foto">Deletar Foto</a></li>
				    <li><a href="?p=deletar_client">Deletar Cliente</a></li>
				    <li><a href="?p=deletar_category">Deletar Categoria</a></li>
				    <li><a href="?p=deletar_administrador">Deletar Administrador</a></li>
				</ul>
				<br />
				<ul>
				    <li><a href="?p=cadastrar_pizza">Relatório dos Pedidos</a></li>
				    <li><a href="?p=cadastrar_pizza">Relatório dos Clientes</a></li>
				    <li><a href="?p=cadastrar_pizza">E-mails recebidos</a></li>
				    <li><a href="?p=cadastrar_pizza">Aniversariantes</a></li>
				</ul>
			</div>
			<div id="contentAdmin">
				<div id="carregar"></div>
				<?php
				if(isset($_GET['p']))
				{
					try{
						carregaUrls($_GET['p']);
					}catch(Exception $e){
						echo $e->getMessage();
					}
				}
				else
				{
					include_once "home.php";
				}
				?>
			</div>

			<div id="fix"></div>
		</div>

		<div id="footer">
			Pizzaria da net <?php echo date("Y"); ?> - Painel Administrativo
		</div> <!-- FOOTER -->
	</div> <!-- CONTAINER -->

</body>

</html>