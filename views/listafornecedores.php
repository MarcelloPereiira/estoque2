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
		<th>Ações</th>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>

			<td><?php echo $item['nome']; ?></td>
			<td><?php echo $item['endereco']; ?></td>
			<td><?php echo $item['fone']; ?></td>
			<td><?php echo $item['cnpj']; ?></td>
			<td>
				<a href="<?php echo BASE_URL; ?>home/editarFornecedor/<?php echo $item['id']; ?>">Editar</a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

