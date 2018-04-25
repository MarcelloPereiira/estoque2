<?php $total = 0;?>
<h1>Inventário</h1>

<table border="1" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Qtd.</th>
		<th>Qtd. Min.</th>
		<th>Diferença</th>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>
			<td><?php echo $item['name']; ?></td>
			<td><?php echo number_format($item['quantity'], 0, '', '.'); ?></td>
			<td><?php echo number_format($item['min_quantity'], 0, '', '.'); ?></td>
			<td><?php echo number_format(floatval($item['min_quantity']) - floatval($item['quantity']), 0, '', '.'); ?></td>
		</tr>
		<?php $total += $item['quantity']; ?>
	<?php endforeach; ?>
		<tr>
			<th>Total</th>
			<th>Total</th>
		</tr>
		<tr>
			<td><?php echo count($list); ?></td>
			<td><?php echo $total; ?></td>
		<tr>
</table><br/><br/>
<a href="<?php echo BASE_URL; ?>"><input type="submit" value="Voltar" class="btn_relatorio" /></a>

<input class="btn_relatorio" type="submit" value="Imprimir" onclick="window.print()" />
<script type="text/javascript">

</script>