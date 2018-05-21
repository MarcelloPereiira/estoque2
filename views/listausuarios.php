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

<h1>Lista de Usuários Ativos</h1>

<fieldset>
	<form method="GET">
		<input type="text" id="busca" name="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o nome ou o número do usuário" style="width:100%;height:40px;font-size:18px;" />
	</form>
</fieldset>
<br/><br/>

<a href="<?php echo BASE_URL.'home/inativousers' ?>" class="btninativos">INATIVOS</a><br/><br/>

<table border="0" width="100%">
	<tr>
		<th>NOME</th>
		<th>NIVEL</th>
		<th>NÚMERO</th>
		<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
			<th>AÇÕES</th>
			<th>STATUS</th>
		<?php endif; ?>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>

			<td><?php echo $item['nome']; ?></td>
			<td><?php echo $item['nivel']; ?></td>
			<td><?php echo $item['user_number']; ?></td>
			<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
				<td>
					<a class="edit" href="<?php echo BASE_URL; ?>home/editarusuario/<?php echo $item['id']; ?>">Editar</a>
				</td>
				<td>
					<a href="<?php echo BASE_URL; ?>home/editarStatusUser/<?php echo $item['id']; ?>">
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

