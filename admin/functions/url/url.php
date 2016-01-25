<?php

function carregaUrls($url)
{
	$caminho = str_replace('_', '/', $url);
	if(is_file($caminho . ".php"))
	{
		include_once $caminho . ".php";
	}
	else
	{
		throw new Exception("Essa página não existe");
	}
}

?>