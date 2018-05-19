<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</head>
<body>
	<div class="loginarea">
		<form method="POST">
			CPF:<br/>
			<input type="text" name="number" class="inteiro" maxlength="11" required /><br/><br/>

			Senha:<br/>
			<input type="password" name="password" required /><br/><br/>

			<input type="submit" value="Entrar" />
		</form>

		<?php if(!empty($msg)): ?>
		<h2><?php echo $msg; ?></h2>
		<?php endif; ?>	
	</div>
</body>
</html>