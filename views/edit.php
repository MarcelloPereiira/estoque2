<h1>Editar Produto</h1>

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
	<input type="text" class="" name="quantity" value="<?php echo $info['quantity']; ?>" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="" name="min_quantity" value="<?php echo $info['min_quantity']; ?>" required /><br/><br/>

	<input type="submit" value="Salvar" />

</form>