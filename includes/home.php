<script src="http://localhost/treinos/php/siteCompleto/js/jquery.js"></script>
<script src="http://localhost/treinos/php/siteCompleto/plugins/coin-slider/js/coin-slider.min.js"></script>
<?php
if(isset($_SESSION))
{
	//var_dump($_SESSION);
}
?>
<!-- DESTAQUES DA SEMANA -->
<div id="destaques_semana">
	<div id='coin-slider'>
	<?php
	$dados = listar("pizzas", "ORDER BY pizza_id DESC LIMIT 4");
	$d = new ArrayIterator($dados);

	while($d->valid())
	{
	?>
		<a href="http://localhost/treinos/php/siteCompleto/detalhes/<?php  echo strtolower(urlencode($d->current()->pizza_name)); ?>">
			<img src='<?php echo $d->current()->pizza_foto_detalhes; ?>' >
			<span style="width: 270;">
				<?php echo $d->current()->pizza_name; ?>
			</span><br />
		</a>
		<?php $d->next(); ?>
	<?php } ?>
	</div>
</div>
<!--  FIM DESTAQUES DA SEMANA -->
<div id="pizzas_amostra">
	<h1>Conheça nossas pizzas!</h1>
	<?php
	$dados = listar("pizzas", "ORDER BY RAND() DESC LIMIT 6");
	$d = new ArrayIterator($dados);

	while($d->valid())
	{
	?>
	<div class="pizzas">
		<a href="http://localhost/treinos/php/siteCompleto/detalhes/<?php echo strtolower(urlencode($d->current()->pizza_name_url)); ?>">
			<img src='<?php echo $d->current()->pizza_foto_inicio; ?>' >
			<span class="namePizza">
				<?php echo $d->current()->pizza_name; ?>
			</span><br />
			<span class="namePizza">
				<?php echo "R$ " .number_format($d->current()->pizza_price, 2,",","."); ?>
			</span>
		</a>
		<?php $d->next(); ?>
	</div>
	<?php } ?>

</div>