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
	<input type="text" name="cod" required /><br/><br/>

	Nome do Produto:<br/>
	<input type="text" name="name" required /><br/><br/>

	Preço do Produto:<br/>
	<input type="text" class="dinheiro" name="price" required /><br/><br/>

	Quantidade:<br/>
	<input type="text" class="dinheiro" name="quantity" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="dinheiro" name="min_quantity" required /><br/><br/>

	<input type="submit" value="Adicionar Produto" />

</form>



