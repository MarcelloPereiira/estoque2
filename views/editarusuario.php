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
<h1>Editar de Usuário</h1>
<form method="POST" class="formLogin">
	Nome:<br/>
	<input type="text" name="nome" value="<?php echo $info['nome']; ?>" required /><br/><br/>

	Número do Usuário:<br/>
	<input type="text" class="inteiro" name="user_number" value="<?php echo $info['user_number']; ?>" required /><br/><br/>

	Senha:<br/>
	<input type="password" class="inteiro" name="user_pass" required /><br/><br/>

	<input type="radio" name="enviarNivel" value="ADM" id="adm" required />
	<label for="adm">ADMINISTRADOR</label>

	<input type="radio" name="enviarNivel" value="OP" id="op" required />
	<label for="op">OPERACIONAL</label>

	<input type="radio" name="enviarNivel" value="CX" id="cx" required />
	<label for="cx">CAIXA</label><br/><br/>

	<input type="submit" value="Salvar" />

</form>

<?php if(!empty($msg)): ?>
<h2><?php echo $msg; ?></h2>
<?php endif; ?>	


