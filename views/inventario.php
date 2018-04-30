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
$date = date('d/m/Y \- \H\o\r\a\: H\h:i\m\i\n');
//$horas = date('H\h:i\m\i\n');
 ?>
<?php $total = 0;?>
<h1>Inventário</h1>

<table border="1" width="100%">
	<tr>
		<th colspan="4" style="background-color: #BBB; ">
		<?php echo "Data: ".$date; ?>
		</th>
	</tr>
	<tr>
		<th>Nome do Produto</th>
		<th>Qtd.</th>
		<th>Qtd. Min.</th>
		<th>Diferença</th>
	</tr>
	<?php foreach($list as $item): ?>
		<tr>
			<td><?php echo $item['name']; ?></td>
			<td><?php echo number_format($item['quantity'], 0, '', '.'); ?></td>
			<td><?php echo number_format($item['min_quantity'], 0, '', '.'); ?></td>
			<td><?php echo number_format(floatval($item['min_quantity']) - floatval($item['quantity']), 0, '', '.'); ?></td>
		</tr>
		<?php $total += $item['quantity']; ?>
	<?php endforeach; ?>
		<tr>
			<th>Total</th>
			<th>Total</th>
		</tr>
		<tr>
			<td><?php echo count($list); ?></td>
			<td><?php echo $total; ?></td>
		<tr>
</table><br/><br/>
<a href="<?php echo BASE_URL; ?>"><input type="submit" value="Voltar" class="btn_relatorio" /></a>

<input class="btn_relatorio" type="submit" value="Imprimir" onclick="window.print()" />
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