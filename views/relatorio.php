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
			<td><?php echo $item['quantity']; ?></td>
			<td><?php echo $item['min_quantity']; ?></td>
			<td><?php echo (floatval($item['min_quantity']) - floatval($item['quantity'])); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
<a href="<?php echo BASE_URL; ?>"><input type="submit" value="Voltar" style="border: 0; margin-top: 20px;
 padding: 5px 10px;  border-radius: 5px; background-color: #CBCBCB; box-shadow: 2px 2px 0px #888;" /></a>
<script type="text/javascript">
window.print();
</script>