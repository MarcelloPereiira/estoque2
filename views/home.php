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

<a href="<?php echo BASE_URL.'relatorio' ?>" class="monitorar">MONITORAR</a><br/><br/>

<table border="0" width="100%">
	<tr>
		<th>CÓDIGO</th>
		<th>NOME</th>
		<th>PREÇO UN.</th>
		<th>QTD.</th>
		<?php if ($users->hasPermission('ADM')): ?>
			<th>AÇÕES</th>
		<?php endif; ?>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>
			<td><?php echo $item['cod']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
			<td><?php echo number_format($item['quantity'], 2, ',', '.'); ?></td>
			<?php if ($users->hasPermission('ADM')): ?>
				<td>
					<a href="<?php echo BASE_URL; ?>home/edit/<?php echo $item['id']; ?>">Editar</a>
				</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
</table>

<script type="text/javascript">
document.getElementById("busca").focus();
</script>
