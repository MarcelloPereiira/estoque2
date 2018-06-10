<?php 
$users = new Users();
$users->setUsuario($_SESSION['token']);
?>
<div class="flex">
	<p class="status"> BEM-VINDO, <?php echo $nome['nome']; ?></p>

	<?php if ($users->hasPermission('ADM')): ?>
		<p class="status">ADMINISTRADOR</p>
	<?php endif; ?>
	<?php if ($users->hasPermission('OP')): ?>
		<p class="status">OPERACIONAL</p>
	<?php endif; ?>
	<?php if ($users->hasPermission('CX')): ?>
		<p class="status">CAIXA</p>
	<?php endif; ?>
</div>


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

<br/>
<div class="flexlinkhome">
	<?php if ($users->hasPermission('ADM')): ?>
		<a href="<?php echo BASE_URL.'home/inativoproducts' ?>" class="btninativos">INATIVOS</a><br/><br/>
	<?php endif; ?>
	<?php if ($users->hasPermission('ADM') || $users->hasPermission('OP')): ?>
		<a href="<?php echo BASE_URL.'relatorio' ?>" class="monitorar">MONITORAR</a><br/><br/>
	<?php endif; ?>
</div>

<table border="0" width="100%">
	<thead>
		<tr>
			<th>CÓDIGO</th>
			<th>NOME</th>
			<th>CATEGORIA</th>
			<th>PREÇO UN.</th>
			<th>QTD.</th>
			<?php if ($users->hasPermission('ADM')): ?>
				<th>AÇÕES</th>
				<th>STATUS</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody id="dados">
	
	</tbody>
</table>

<script type="text/javascript">
document.getElementById("busca").focus();



/** Função para fazer uma busca sem refresh */
/** Autocomplete */
var dados = [
	<?php foreach($list as $item): ?>
		{
		  "Cod": "<?php echo $item['cod']; ?>",
		  "Name": "<?php echo $item['name']; ?>",
		  "Categorias": "<?php echo $item['name_categories']; ?>",
		  "Price": "<?php echo number_format($item['price'], 2, ',', '.'); ?>",
		  "Quantity": "<?php if ($item['quantity'] <= $item['min_quantity'] && $item['quantity'] > 0): ?><div style='color: #F2A336'><?php echo number_format($item['quantity'], 2, ',', '.'); ?></div><?php elseif($item['quantity'] == 0): ?><div style='color: #BD1147'><?php echo number_format($item['quantity'], 2, ',', '.'); ?></div><?php else: ?><div style='color: #297542'><?php echo number_format($item['quantity'], 2, ',', '.'); ?></div><?php endif; ?>",
		  "Edit": "<?php if ($users->hasPermission('ADM')): ?><a class='edit' href='<?php echo BASE_URL; ?>home/edit/<?php echo $item["id"]; ?>'>Editar</a><?php endif; ?>",
		  "Status": "<?php if ($users->hasPermission('ADM')): ?><a href='<?php echo BASE_URL; ?>home/editarStatusProducts/<?php echo $item["id"]; ?>'><div class='ativo'>Ativo</div></a><?php endif; ?>",
		  
		}
		,
	<?php endforeach; ?>
	];
	
	document.getElementById("busca").addEventListener("keyup", function() {
		
		var dadosCopy = dados.slice();
		const filterNome = this.value;
		
		
		var i = dadosCopy.length;
		while (i--) {
		
			var myRegex = new RegExp(filterNome, 'gi');			
			if(dadosCopy[i]['Name'].match(myRegex) ==  null && dadosCopy[i]['Cod'].match(myRegex) ==  null){
				dadosCopy.splice(i, 1); // Remove o elemento
			}
		}		
		
		popDados(dadosCopy);
	});	
	
	
	function popDados(myArr){
		var dadosTable = document.getElementById("dados");
		while (dadosTable.firstChild) {
			dadosTable.removeChild(dadosTable.firstChild);
		}
		
		for(var x = 0; x < myArr.length; x++){
			var trTable = document.createElement('tr');
			trTable.innerHTML = '<td>'+  myArr[x]['Cod'] +'</td>' + '<td>'+ myArr[x]['Name'] +'</td>' + '<td>'+ myArr[x]['Categorias'] +'</td>' + '<td>'+ myArr[x]['Price'] +'</td>' + '<td>'+ myArr[x]['Quantity'] +'</td>' + '<td>'+ myArr[x]['Edit'] +'</td>' + '<td>'+ myArr[x]['Status'] +'</td>';
			
			document.getElementById("dados").appendChild(trTable);
		}
	}
	
	//Logo ao iniciar o DOM
	popDados(dados);
</script>
