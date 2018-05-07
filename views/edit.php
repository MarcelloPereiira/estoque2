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

<h1>Editar Produto</h1>

<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<form method="POST" class="form">

	Código de Barras:<br/>
	<input type="text" name="cod" value="<?php echo $info['cod']; ?>" required /><br/><br/>

	Nome do Produto:<br/>
	<input type="text" name="name" value="<?php echo $info['name']; ?>" required /><br/><br/>

	Preço do Produto:<br/>
	<input type="text" class="dinheiro" name="price" value="<?php echo number_format($info['price'], 2, ',', '.'); ?>" required /><br/><br/>

	Quantidade:<br/>
	<input type="text" class="dinheiro" name="quantity" value="<?php echo number_format($info['quantity'], 2, ',', '.'); ?>" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="dinheiro" name="min_quantity" value="<?php echo number_format($info['min_quantity'], 2, ',', '.'); ?>" required /><br/><br/>

	Categoria:
	<select name="id">
		<option value=""></option>
		<?php foreach($list as $item): ?>
		<option value="<?php echo $item['id_categories']; ?>">
			<?php echo $item['name_categories']; ?>
		</option>
		<?php endforeach; ?>	
	</select><br/><br/>	

	<input type="submit" value="Salvar" />

</form>