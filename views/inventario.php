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

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('d/m/Y \- H:i:s');
//$horas = date('H\h:i\m\i\n');
 ?>
<?php $total = 0;?>
<h1>Inventário</h1>
<?php if(!empty($sucess)): ?>
<div class="sucess"><?php echo $sucess; ?></div>
<?php endif; ?>

<?php if(!empty($warning)): ?>
<div class="warning"><?php echo $warning; ?></div>
<?php endif; ?>

<form method="GET" class="flexbuscador">
	<fieldset>
			<input type="text" id="busca" name="busca" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o código de barras ou o nome do produto" style="width:100%;height:40px;font-size:18px;" />
	</fieldset>

	<select name="category" class="homeselect">
		<option value="">Todas as Categorias</option>
		<?php foreach($listcategory as $item): ?>
		<option value="<?php echo $item['id_categories']; ?>" <?php echo (($_GET['category']) == $item['id_categories'])?'selected="select"':''; ?>> 
			<?php echo $item['name_categories']; ?>					
		</option>
		<?php endforeach; ?>	
	</select>

	<input type="image" src="assets/images/seach.png" class="botao">
</form>
<form method="POST">
	<table border="1" width="100%">
		<tr>
			<th colspan="5" style="background-color: #BBB; ">
			<?php echo $date; ?>
			</th>
		</tr>
		<tr>
			<th>Código</th>
			<th>Nome do Produto</th>
			<th>Qtd.</th>
			<th>Qtd. Min.</th>
			<th>Diferença</th>
		</tr>
		<?php foreach($list as $item): ?>
			<tr>
				<td style="display: none"><input type="text" name="id[]" value="<?php echo $item['id']; ?>"></td>
				<td><input type="text" name="cod[]" value="<?php echo $item['cod']; ?>"></td>
				<td><input type="text" name="name[]" value="<?php echo $item['name']; ?>"></td>
				<td><input type="text" name="quantity[]" value="<?php echo number_format($item['quantity'], 0, '', '.'); ?>"></td>
				<td><input type="text" name="min_quantity[]" value="<?php echo number_format($item['min_quantity'], 0, '', '.'); ?>"></td>
				<td><input type="text" name="difference[]" value="<?php echo number_format(floatval($item['min_quantity']) - floatval($item['quantity']), 0, '', '.'); ?>"></td>
			</tr>
			<?php $total += $item['quantity']; ?>
		<?php endforeach; ?>
			<tr>
				<th colspan="5">Total de Produtos</th>
			</tr>
			<tr>
				<td colspan="5"><input type="text" name="totalProducts" value="<?php echo count($list); ?>"></td>
			<tr>
	</table><br/><br/>
	<input type="submit" value="Salvar" class="btn_relatorio" >
	
</form>



<!-- <input class="btn_relatorio" type="submit" value="Imprimir" onclick="window.print()" />-->
<script type="text/javascript">

</script>
<br><br><br><br>


<br><br>
 <?php


$dia_hora_atual = strtotime(date("Y-m-d H:i:s")); //aqui o dia atual
$dia_hora_evento = strtotime(date("2018-05-12 08:00:00")); // aqui o dia que o vip vai acaba

#Achamos a diferença entre as datas...
$diferenca = $dia_hora_evento - $dia_hora_atual;

#Fazemos a contagem...
$dias = intval($diferenca / 86400);
$marcador = $diferenca % 86400;
$hora = intval($marcador / 3600);
$marcador = $marcador % 3600;
$minuto = intval($marcador / 60);
$segundos = $marcador % 60;

#Exibimos o resultado
echo $dias." dia(s) ".$hora." hora(s) ".$minuto." minuto(s)";// aqui o resultando que dia que vai acaba
if ($dias < 31) {
	echo "<br>Faltam ".$dias." dia(s) para o vencimento deste produto!";// aqui o resultando que dia que vai acaba
}
?>