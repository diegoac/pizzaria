<?php
include_once "functions/metas/metas.php";
include_once 'functions/config/config.php';
include_once 'functions/url/url.php';
include_once 'functions/helpers/utils.php';
include_once 'functions/logar/logar.php';
include_once 'functions/cadastro/cadastro.php';

try {
	carregaIncludes(array("conexao"), "login");
} catch(Exception $e) {
	echo $e->getMessage();
}

/* LOGIN CLIENTE */

if(isset($_POST['logar']))
{
	
	try{
		$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
		$erro = logarCliente($login, $password);
	} catch(Exception $e){
		echo "Erro: " . $e->getMessage();
	}
}

/* FIM LOGIN CLIENTE */


/* LOGOUT CLIENTE*/
if(isset($_GET['ac']))
{
	if($_GET['ac'] == 'logout')
	{
		logout();
	}
}


/* FIM LOGOUT CLIENTE*/
if(isset($_SESSION))
{
	var_dump($_SESSION);
}
?>

<html>
	<head>
		<title>Pizzaria da Net</title>
		<meta charset=utf-8>
		<meta name=description content="<?php echo exibeMetas(1);?>">
		<meta name=keywords content="<?php echo exibeMetas(2);?>">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="http://localhost/treinos/php/siteCompleto/css/style.css">
		<link rel="stylesheet" type="text/css" href="http://localhost/treinos/php/siteCompleto/plugins/coin-slider/css/coin-slider-styles.css">

		<script src="http://localhost/treinos/php/siteCompleto/js/jquery.js"></script>
		<!-- javascript com falhas -->
		<!-- <script src="http://localhost/treinos/php/siteCompleto/js/login.js"></script> -->
		<script src="http://localhost/treinos/php/siteCompleto/plugins/coin-slider/js/coin-slider.min.js"></script>
		<script src="http://localhost/treinos/php/siteCompleto/js/coinSliderInit.js"></script>
		<script src="http://localhost/treinos/php/siteCompleto/js/validate.js"></script>
		<!-- <script src="http://localhost/treinos/php/siteCompleto/js/validarCadastro.js"></script> -->
		
		<script src="http://localhost/treinos/php/siteCompleto/js/jquery.mask.min.js"></script>
		<script src="http://localhost/treinos/php/siteCompleto/js/maskInputs.js"></script>

		
	</head>
	<body>

		<div id="container">
			<div id="header">
				Aqui vai o topo do site
				<div id="logo"><img src="images/logo.png" title="Pizzaria da Net" alt="Logo pizzaria da net"></div>
				<div id="busca">
					<form action="" method="post">
						<label for="busca">Busca</label>
						<input type="text" id="txt_busca" name="buscar_pizza" value="buscar..."/>
						<select id="select_busca" name="categories">
							<option select="selected">Escolha uma categoria</option>
						</select>
						<input type="submit" id="bt_busca" name="buscar_pizza_categories" value="ok"></input>
					</form>
				</div> <!-- BUSCA -->
			</div> <!-- HEADER-->

			<div id="menu">
				<ul>
				    <li><a href="http://localhost/treinos/php/siteCompleto">Home</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/empresa">A Empresa</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/clientes">Área do Cliente</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/cadastro">Cadastro</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/contato">Contato</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/pizzas">Pizzas</a></li>
				    <li><a href="http://localhost/treinos/php/siteCompleto/logout">Logout</a></li>
				    <!-- <li><a href="http://localhost/treinos/php/siteCompleto/login" id="login">Login</a></li> -->
				</ul>
			</div> <!-- MENU -->


			<div id="content">

				<?php
				if(isset($_GET['p']))
				{
					carregaUrlAmigavel($_GET['p']);
				}
				else
				{
					include_once "includes/home.php";
				}
				 ?>
				<div id="fix"></div> <!-- FIX -->
			</div><!--	CONTEÚDO -->

			<div id="footer">
					Pizzaria da Net: <?php echo date("Y") . " - Todos os direitos reservados"; ?>
			</div> <!-- FOOTER -->
		</div> <!--	CONTAINER -->

	</body>

</html>