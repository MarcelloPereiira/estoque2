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
	<input type="text" class="dinheiro" name="price" value="<?php echo $info['price']; ?>" required /><br/><br/>

	Quantidade:<br/>
	<input type="text" class="inteiro" name="quantity" value="<?php echo $info['quantity']; ?>" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="inteiro" name="min_quantity" value="<?php echo $info['min_quantity']; ?>" required /><br/><br/>

	Fornecedor:
	<select name="name_fornecedor">
		<option></option>
		<?php foreach($list as $item): ?>
		<option value="<?php echo $item['id']; ?>">
			NOME:
			<?php echo $item['nome']; ?>
			&nbsp;&nbsp; ENDEREÇO:
			<?php echo $item['endereco']; ?>
			&nbsp;&nbsp; TELEFONE:
			<?php echo $item['fone']; ?>
			&nbsp;&nbsp; CNPJ:
			<?php echo $item['cnpj']; ?>
		</option>
		<?php endforeach; ?>	
	</select><br/><br/>

	<input type="submit" value="Salvar" />

</form>