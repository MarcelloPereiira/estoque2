<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>
<?php
/** Restrição de usuários. Só tem acesso a esta página os administradores e os operacionais */
if ($users->hasPermission("ADM") == false && $users->hasPermission("OP") == false) {
	header("Location: index.php");
	exit;
} 
?>

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y \- \H\o\r\a\: H\h:i\m\i\n');
//$horas = date('H\h:i\m\i\n');
 ?>
<?php $total = 0;?>
<h1>Consulta de Inventário</h1>

<form method="GET" class="flexbuscador noprint">
	<select style="padding-left: 50px; " name="data_conj" class="homeselect">
		<option value="">SELECIONE UMA DATA</option>
		<?php foreach($listdate as $item): ?>
		<option value="<?php echo $item['id']; ?>" <?php echo (($_GET['data_conj']) == $item['id'])?'selected="select"':''; ?>> 
			<?php echo "Cod: ".$item['cod_inventario']." -- Data: ".date("d/m/Y \- H:i:s", strtotime($item['data_conjunct'])); ?>
		</option>
		<?php endforeach; ?>	
	</select>

	<input type="image" src="../assets/images/seach.png" class="botao">
</form>
<form method="POST">
	<?php if (!empty($list)): ?>
		<table border="1" width="100%">
			<tr>
				<th colspan="5" style="background-color: #BBB; ">
				<?php foreach($list as $item): ?>
					<?php echo date("d/m/Y \- H:i:s", strtotime($item['data_conjunct'])); break;?>
				<?php endforeach; ?>
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
					<td><?php echo $item['cod']; ?></td>
					<td><?php echo $item['name_products']; ?></td>
					<td><?php echo number_format($item['quantity'], 0, '', '.'); ?></td>
					<td><?php echo number_format($item['min_quantity'], 0, '', '.'); ?></td>
					<td><?php echo number_format(floatval($item['quantity']) - floatval($item['min_quantity']), 0, '', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<th colspan="5">TOTAL DE PRODUTOS</th>
				</tr>
				<tr>
					<td colspan="5"><?php echo count($list); ?></td>
				<tr>
		</table>
	<?php else: ?>
		<div class="avisoinv"><h1>SEM RESULTADO</h1></div>
	<?php endif; ?>
	<br/><br/>
	
</form>
<a href="../inventario" class="noprint"><input type="submit" value="Voltar"></a>
<?php if (!empty($list)): ?>
	<a href="" target="_blank" id="i" class="noprint"><input type="submit" value="Nova Aba"></a>
	<a href="" onclick="window.print()" class="noprint"><input type="submit" value="Imprimir"></a>
<?php endif; ?>

<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
</style>
