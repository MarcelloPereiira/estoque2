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

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>
<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<h1>Editar Categoria</h1>
<form method="POST" class="form">
	Nome:<br/>
	<input type="text" name="name_categories" value="<?php echo $info['name_categories'] ?>" required /><br/><br/>

	<input type="submit" value="Salvar" />

</form>


