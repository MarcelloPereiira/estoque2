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

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y \- H:i:s');
//$horas = date('H\h:i\m\i\n');
 ?>
<?php $total = 0;?>
<h1>Abertura de Inventário</h1>
<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<form method="POST" id="forminv">
	<table border="1" width="100%">
		<tr>
			<th colspan="1" style="background-color: #BBB;">
			<input type="text" name="codinventario" style="background-color: #BBB; text-align: center" readonly="true" value="<?php echo $list[0]['cod_inventario'] ?>">
			</th>
			<th colspan="5" style="background-color: #BBB; ">
			<?php echo $date; ?>
			</th>
		</tr>
		<tr>
			<th>CÓDIGO</th>
			<th>NOME DO PRODUTO</th>
			<th>QTD.</th>
			<th>QTD. MIN.</th>
			<th>DIFERENÇA</th>
		</tr>
		<?php foreach($list as $item): ?>
			<tr>
				<td style="display: none"><input type="text" name="id_products[]" value="<?php echo $item['id_products']; ?>"></td>
				<td><input class="borderinput" type="text" name="cod[]" readonly="true" value="<?php echo $item['cod']; ?>"></td>
				<td><input class="borderinput" type="text" name="name[]" readonly="true" value="<?php echo $item['name_products']; ?>"></td>
				<td><input class="borderinput2" type="text" name="quantity[]" value="<?php echo number_format($item['quantity'], 0, '', '.'); ?>"></td>
				<td><input class="borderinput2" type="text" name="min_quantity[]" value="<?php echo number_format($item['min_quantity'], 0, '', '.'); ?>"></td>
				<td><input class="borderinput" type="text" name="difference[]" readonly="true" value="<?php echo number_format(floatval($item['min_quantity']) - floatval($item['quantity']), 0, '', '.'); ?>"></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<th colspan="5">TOTAL DE PRODUTOS</th>
			</tr>
			<tr>
				<td colspan="5"><input class="borderinput" type="text" name="totalProducts" readonly="true" value="<?php echo count($list); ?>"></td>
			<tr>
	</table><br/><br/>	
</form>
<input type="submit" value="Fechar Inventário" class="btn_relatorio" onclick="confirmar();" >




<script type="text/javascript">
//Confirmação para salvar o inventário
function confirmar(){ 
	if(confirm("Tem certeza que deseja fechar o inventário?")){ 
		document.getElementById('forminv').submit(); 
	} 
}
</script>


