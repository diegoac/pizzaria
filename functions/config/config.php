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
	set_include_path(PATH_INCLUDE . "conexao/" 
	);
	

	if(!is_null($includes))
	{
		if(is_array($includes))
		{	
			foreach($includes as $inc)
			{
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