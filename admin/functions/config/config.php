<?php

function carregaIncludes($includes = null, $modo = null) {

	if($modo != null)
	{
		if($modo == "login")
		{
			define("PATH_INCLUDE", "functions/");
		}
		else if($modo == "admin"){
			define("PATH_INCLUDE", "../functions/");
		}
	}
	else
	{
		throw new Exception("O parâmetro modo não pode ser nulo!");
	}
	set_include_path(PATH_INCLUDE . "conexao/" . PATH_SEPARATOR .
		PATH_INCLUDE . "login/" . PATH_SEPARATOR .
		PATH_INCLUDE . "url/" . PATH_SEPARATOR .
		PATH_INCLUDE . "cadastrar/" . PATH_SEPARATOR .
		PATH_INCLUDE . "alterar/" . PATH_SEPARATOR .
		PATH_INCLUDE . "helpers/" . PATH_SEPARATOR .
		PATH_INCLUDE . "../bibliotecas/Pager" . PATH_SEPARATOR .
		PATH_INCLUDE . "bibliotecas/Pager" . PATH_SEPARATOR .
		PATH_INCLUDE . "../bibliotecas/Pager/Pager" . PATH_SEPARATOR .
		PATH_INCLUDE . "bibliotecas/Pager/Pager" . PATH_SEPARATOR .
		PATH_INCLUDE . "../bibliotecas/Pager/Pager/Pager" . PATH_SEPARATOR .
		PATH_INCLUDE . "bibliotecas/Pager/Pager/Pager"
	);
	

	//echo get_include_path();
	$pastas = explode(PATH_SEPARATOR, get_include_path());
	$caminhos = count($pastas);
	//echo $caminhos;
	//print_r($pastas);

	if(!is_null($includes))
	{
		if(is_array($includes))
		{	
			foreach($includes as $inc)
			{
				for($i=0; $i < $caminhos; $i++)
				{
					if(file_exists($pastas[$i]. $inc .".php"))
					{
						//echo $pastas[$i] . $inc . ".php<br />";
						include_once($pastas[$i] . $inc .".php");
					}
				}
				include_once ($inc . ".php");
			}
		}
		else
		{
			throw new Exception('O parâmetro passado não é array');
		}
	}
	else
	{
		throw new Exception('Nenhum parâmetro foi passado para a função');
	}

}