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

<h1>Lista de Categorias Ativas</h1>

<fieldset>
	<form method="GET">
		<input type="text" id="busca" name="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o nome da categoria" style="width:100%;height:40px;font-size:18px;" />
	</form>
</fieldset>
<br/><br/>

<a href="<?php echo BASE_URL.'home/inativocategories' ?>" class="btninativos">INATIVOS</a><br/><br/>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<table border="0" width="100%">
	<tr>
		<th>NOME</th>
		<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
			<th>AÇÕES</th>
			<th>STATUS</th>
		<?php endif; ?>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>

			<td><?php echo $item['name_categories']; ?></td>
			<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
				<td>
					<a class="edit" href="<?php echo BASE_URL; ?>home/editarCategory/<?php echo $item['id_categories']; ?>">Editar</a>
				</td>
				<td>
					<a href="<?php echo BASE_URL; ?>home/editarStatusCategory/<?php echo $item['id_categories']; ?>">
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

