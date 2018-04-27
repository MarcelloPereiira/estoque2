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

<fieldset>
	<form method="GET">
		<input type="text" id="busca" name="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o nome do fornecedor ou o CNPJ" style="width:100%;height:40px;font-size:18px;" />
	</form>
</fieldset>
<br/><br/>

<table border="0" width="100%">
	<tr>
		<th>Nome</th>
		<th>Endereço</th>
		<th>Telefone</th>
		<th>CNPJ</th>
		<?php if ($users->hasPermission('EDIT')): ?>
			<th>Ações</th>
		<?php endif; ?>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>

			<td><?php echo $item['nome']; ?></td>
			<td><?php echo $item['endereco']; ?></td>
			<td><?php echo $item['fone']; ?></td>
			<td><?php echo $item['cnpj']; ?></td>
			<?php if ($users->hasPermission('EDIT')): ?>
				<td>
					<a href="<?php echo BASE_URL; ?>home/editarFornecedor/<?php echo $item['id']; ?>">Editar</a>
				</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
</table>

