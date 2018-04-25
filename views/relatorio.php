<h1>Relatório</h1>

<table border="1" width="500">
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
	<?php endforeach; ?>
</table><br/><br/>
<a href="<?php echo BASE_URL; ?>"><input type="submit" value="Voltar" class="btn_relatorio" /></a>
<script type="text/javascript">
window.print();
</script>