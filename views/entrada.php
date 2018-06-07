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

<h1>Entrada de Nota Fiscal</h1>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>
<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<form method="POST" class="form">

	Produto:
	<select name="id">
		<option></option>
		<?php foreach($list as $item): ?>
		<option value="<?php echo $item['id']; ?>">
			<?php echo $item['name']; ?>
			&nbsp;&nbsp;
			CÓD.:
			<?php echo $item['cod']; ?>
			&nbsp;&nbsp;
		</option>
		<?php endforeach; ?>	
	</select><br/><br/>	

	Código de Barras:
	<input type="text" name="cod" maxlength="40" /><br/><br/>
	Quantidade:<br/>
	<input type="text" class="dinheiro" name="quantity"  required /><br/><br/>

	<input type="submit" value="Salvar" />

</form>

