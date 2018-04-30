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

<h1>Cadastra Fornecedor</h1>

<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<form method="POST" class="form">
	
	Nome:<br/>
	<input type="text" name="nome" required /><br/><br/>

	Endereço:<br/>
	<input type="text" name="endereco" required /><br/><br/>

	Telefone:<br/>
	<input type="text" class="inteiro" name="fone" required /><br/><br/>

	CNPJ:<br/>
	<input type="text" class="inteiro" name="cnpj" required /><br/><br/>

	<input type="submit" value="Cadastrar" /><br/><br/>
</form>