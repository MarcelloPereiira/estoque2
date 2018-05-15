<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>
<?php
if ($users->hasPermission("ADM") == false && $users->hasPermission("OP") == false) {
	header("Location: index.php");
	exit;
} 
?>

<h1>Relatório</h1>

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
	<?php endforeach; ?>
</table><br/><br/>
<a href="<?php echo BASE_URL; ?>"><input type="submit" value="Voltar" class="btn_relatorio noprint" /></a>
<input type="submit" value="Imprimir" onclick="window.print()" class="btn_relatorio noprint" />
<script type="text/javascript">
window.print();
</script>

<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
</style>