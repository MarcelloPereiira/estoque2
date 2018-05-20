<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>
<div class="flex">
	<p class="status"> BEM-VINDO, <?php echo $nome['nome']; ?></p>

	<?php if ($users->hasPermission('ADM')): ?>
		<p class="status">ADMINISTRADOR</p>
	<?php endif; ?>
	<?php if ($users->hasPermission('OP')): ?>
		<p class="status">OPERACIONAL</p>
	<?php endif; ?>
	<?php if ($users->hasPermission('CX')): ?>
		<p class="status">CAIXA</p>
	<?php endif; ?>
</div>


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

	<input type="image" src="assets/images/seach.png" class="botao">
</form>

<br/>
<div class="flexlinkhome">
	<?php if ($users->hasPermission('ADM')): ?>
		<a href="<?php echo BASE_URL.'home/inativoproducts' ?>" class="btninativos">INATIVOS</a><br/><br/>
	<?php endif; ?>
	<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
		<a href="<?php echo BASE_URL.'relatorio' ?>" class="monitorar">MONITORAR</a><br/><br/>
	<?php endif; ?>
</div>

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
				<td style="color: #F2A336"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
			<?php elseif($item['quantity'] == 0): ?>
				<td style="color: #BD1147"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
			<?php else: ?>
				<td style="color: #297542"><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>	
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
