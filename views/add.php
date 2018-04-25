<h1>Adicionar Produto</h1>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<form method="POST" class="form">

	Código de Barras:<br/>
	<input type="text" name="cod" required /><br/><br/>

	Nome do Produto:<br/>
	<input type="text" name="name" required /><br/><br/>

	Preço do Produto:<br/>
	<input type="text" class="dinheiro" name="price" required /><br/><br/>

	Quantidade:<br/>
	<input type="text" class="inteiro" name="quantity" required /><br/><br/>

	Qtd. Minima:<br/>
	<input type="text" class="inteiro" name="min_quantity" required /><br/><br/>

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

	<input type="submit" value="Adicionar Produto" />

</form>



