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

<h1>Adicionar Produto</h1>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>
<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<form method="POST" class="form">

	Código de Barras:<br/>
	<input type="text" name="cod" maxlength="40" required /><br/><br/>

	Nome do Produto:<br/>
	<input type="text" name="name" maxlength="100" required /><br/><br/>

	Preço do Produto:<br/>
	<input type="text" class="dinheiro" name="price" required /><br/><br/>

	Quantidade:<br/>
	<input type="text" class="dinheiro" name="quantity" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="dinheiro" name="min_quantity" required /><br/><br/>

	Categoria:
	<select name="id">
		<option></option>
		<?php foreach($list as $item): ?>
		<option value="<?php echo $item['id_categories']; ?>">
			<?php echo $item['name_categories']; ?>
		</option>
		<?php endforeach; ?>	
	</select><br/><br/>	

	<input type="submit" value="Adicionar Produto" />	

</form>



