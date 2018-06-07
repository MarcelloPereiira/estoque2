<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>
<?php
/** Restrição de usuários. Só tem acesso a esta página os administradores */
if ($users->hasPermission("ADM") == false) {
	header("Location: index.php");
	exit;
} 
?>
<h1>Editar Usuário</h1>
<form method="POST" class="formLogin">
	Nome:<br/>
	<input type="text" name="nome" class="letras" maxlength="70" value="<?php echo $info['nome']; ?>" required /><br/><br/>

	CPF:<br/>
	<input type="text" class="cpf" name="user_number" maxlength="11" value="<?php echo $info['user_number']; ?>" required /><br/><br/>

	Senha:<br/>
	<input type="password" name="user_pass" maxlength="20" required /><br/><br/>
	<div class="flexlogin">
		<div>
			<input type="radio" name="enviarNivel" value="ADM" id="adm" required />
			<label for="adm">ADMINISTRADOR</label>
		</div>
		<div>
			<input type="radio" name="enviarNivel" value="OP" id="op" required />
			<label for="op">OPERACIONAL</label>
		</div>
		<div>
			<input type="radio" name="enviarNivel" value="CX" id="cx" required />
			<label for="cx">CAIXA</label><br/><br/>
		</div>
	</div>

	<input type="submit" value="Salvar" />

</form>

<?php if(!empty($msg)): ?>
<h2><?php echo $msg; ?></h2>
<?php endif; ?>	


