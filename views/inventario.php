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
			<input type="text" id="busca" name="busca" id="check" value="<?php echo (!empty($_GET['busca']))?$_GET['busca']:''; ?>" placeholder="Digite o código de barras ou o nome do produto" style="width:100%;height:40px;font-size:18px;" />
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

<div class="checkall">
	<label for="selectAll" id="checar">Marcados</label>
	<input type="checkbox" name="MarcaTodos" id="selectAll" checked>
</div>

<form method="POST" id="forminv">
	<table border="1" width="100%">
		<tr>
			<th colspan="2" style="background-color: #BBB;">
			<input type="text" name="codinventario" style="background-color: #BBB; text-align: center" readonly="true" value="<?php echo rand(1, 100000) + rand(1, 100) + rand(1, 100000) + rand(1, 10000)?>">
			</th>
			<th colspan="6" style="background-color: #BBB; ">
			<?php echo $date; ?>
			</th>
			
		</tr>
		<tr>
			<th>OP</th>
			<th>CÓDIGO</th>
			<th>NOME DO PRODUTO</th>
			<th>QTD.</th>
			<th>QTD. MIN.</th>
			<th>DIFERENÇA</th>
		</tr>
		<?php foreach($list as $item): ?>
			<tr>
				<td style="display: none"><input type="text" name="id[]" value="<?php echo $item['id']; ?>"></td>
				<td><input type="checkbox" name="check[]" class="marcar" value="<?php echo $item['id']; ?>"  checked></td>
				<td><input class="borderinput" type="text" name="cod[]" readonly="true" value="<?php echo $item['cod']; ?>"></td>
				<td><input class="borderinput" type="text" name="name[]" readonly="true" value="<?php echo $item['name']; ?>"></td>
				<td><input class="borderinput quantidade" type="text" name="quantity[]" readonly="true" value="<?php echo number_format($item['quantity'],2, ',',''); ?>"></td>
				<td><input class="borderinput quantidade" type="text" name="min_quantity[]" readonly="true" value="<?php echo number_format($item['min_quantity'], 2 ,',', ''); ?>"></td>
				<td><input class="borderinput" type="text" name="difference[]" readonly="true" value="<?php echo number_format(floatval($item['quantity']) - floatval($item['min_quantity']), 2, ',', '.'); ?>"></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<th colspan="6">TOTAL DE PRODUTOS</th>
			</tr>
			<tr>
				<td colspan="6"><input class="borderinput" type="text" name="totalProducts" readonly="true" value="<?php echo count($list); ?>"></td>
			<tr>
	</table><br/><br/>	
</form>
<input type="submit" value="Abrir Inventário" class="btn_relatorio" onclick="confirmar();" >




<script type="text/javascript">
//Confirmação para salvar o inventário
function confirmar(){ 
	if(confirm("Tem certeza que deseja abrir o inventário?")){ 
		document.getElementById('forminv').submit(); 
	} 
}

//Função para marcar e desmarcar todos os checkbox do inventário
$('#selectAll').click(function(){
	if ($(this).prop("checked")) {
		$('#checar').text('Marcados');
		$('.marcar').prop("checked", true); 
	}
	else{
		$('#checar').text('Desmarcados');
		$('.marcar').prop("checked", false);
	}
});

</script>

