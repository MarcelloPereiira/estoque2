<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>

<?php
if ($users->hasPermission("ADM") == false) {
	header("Location: index.php");
	exit;
} 
?>

<h1>Lista de Producos Inativos</h1>

<form method="GET" class="flexbuscador">
	<fieldset>
			<input type="text" id="busca" name="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o código de barras ou o nome do produto" style="width:100%;height:40px;font-size:18px;" />
	</fieldset>

	<select name="category" class="homeselect">
		<option value="">Todas as Categorias</option>
		<?php foreach($listcategory as $item): ?>
		<option value="<?php echo $item['id_categories']; ?>" <?php echo (($_GET['category']) == $item['id_categories'])?'selected="select"':''; ?>> 
			<?php echo $item['name_categories']; ?>					
		</option>
		<?php endforeach; ?>	
	</select>

	<input type="image" src="../assets/images/seach.png" class="botao">
</form>

<br/>


<table border="0" width="100%">
	<tr>
		<th>CÓDIGO</th>
		<th>NOME</th>
		<th>CATEGORIA</th>
		<th>PREÇO UN.</th>
		<th>QTD.</th>
		<?php if ($users->hasPermission('ADM')): ?>
			<th>AÇÕES</th>
			<th>STATUS</th>
		<?php endif; ?>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>
			<td><?php echo $item['cod']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td><?php echo $item['name_categories']; ?></td>
			<td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
			<?php if ($item['quantity'] <= $item['min_quantity'] && $item['quantity'] > 0): ?>
				<td class="min"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
			<?php elseif($item['quantity'] == 0): ?>
				<td class="esgotado"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
			<?php else: ?>
				<td class="ok"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
			<?php endif; ?>
			<?php if ($users->hasPermission('ADM')): ?>
				<td>
					<a class="edit" href="<?php echo BASE_URL; ?>home/edit/<?php echo $item['id']; ?>">Editar</a>
				</td>
				<td>
					<a href="<?php echo BASE_URL; ?>home/editarStatusProducts/<?php echo $item['id']; ?>">
						<?php
						if ($item['id_status'] == 1) {
						 	echo "<div class='ativo'>Ativo</div>";
						 } else{
						 	echo "<div class='inativo'>Inativo</div>";
						 }
							
						 ?>	
					</a>
				</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
</table>

<script type="text/javascript">
document.getElementById("busca").focus();
</script>
