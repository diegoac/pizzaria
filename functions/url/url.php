<?php
set_include_path('includes/');
function carregaUrlAmigavel($url)
{
	// A pasta includes deve conter todas as páginas públicas do site.
	$pasta = 'includes/';
	if(substr_count($url, "/") > 0)
	{
		$explodeUrl = explode("/", $url);
		//print_r($explodeUrl);
		if(is_file($pasta.$explodeUrl[0].".php"))
		{
			include_once $pasta.$explodeUrl[0].".php";
		}
		else
		{
			//include_once "includes/404.php";
		}
		
		//include_once $url . ".php";
	}
	else
	{
		if(is_file($pasta.$url.".php"))
		{
			include_once ($pasta.$url.".php");
		}
		else
		{
			//include_once "includes/404.php";
		}
	}
}