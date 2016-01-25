<?php

include_once "../functions/conexao/conexao.php";
include_once "../functions/helpers/utils.php";

$busca = $_POST['busca'];

$dados = listarBusca('pizzas', 'pizza_name', $busca);

if(empty($dados))
{
	echo "Nenhuma pizza encontrada";
}
else
{

?>

	<table>
		<thead>
			<tr>
				<td>Foto</td>
				<td>Nome</td>
				<td>Preço</td>
			</tr>
		</thead>
		<tbody>
		<?php
		$c = new ArrayIterator($dados);
		while($c->valid()){
			$d = $c->current();

		?>
			<tr>
				<td><img src="<?php echo "../../".$d['pizza_foto_inicio']; ?>"/> </td>
				<td><?php echo $d['pizza_name']; ?></td>
				<td><?php echo $d['pizza_price']; ?></td>
			</tr>
		<?php
		$c->next();
		}
		?>
		</tbody>
	</table>

<?php } ?>
