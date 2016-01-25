<h2>Página inicial do sistema administrativo</h2>

<div id="bemVindo">
	<p>
		<?php $id = pegaIdAdministrador($_SESSION['administrador']); ?>
		
		<span id="ultimoLogin">
			<?php
			$dataLogin = ultimoLogin($id);
			if(empty($dataLogin)){
				echo "Esse é o seu primeiro login.";
			}
			else {
				
				echo 'Bem vindo, ' . $_SESSION['administrador'] . ', seu último login foi em: ' . date("d/m/Y h:i:s", strtotime(ultimoLogin($id))); 
				//echo date("d/m/Y h:i:s", strtotime(ultimoLogin($id)));
			}
			?>
		</span>
	</p>

</div>
