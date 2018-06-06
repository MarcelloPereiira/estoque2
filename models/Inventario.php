<?php
class Inventario extends Model {

	/** A variável $array recebe os dados do produto */
	/** Função para atualizar(editar) a quantidade e a quantidade mínima de cada produto passado como parâmetro */
	public function editProductsByInventario($array) {

		if(!empty($array)) {
			for ($i=0; $i < count($array['name']); $i++) {

				 $id = $array['id_products'][$i];
				 $cod = $array['cod'][$i];
				 $name = $array['name'][$i];
				 $quantity = $array['quantity'][$i];
				 $min_quantity = $array['min_quantity'][$i];
				 $difference = $array['difference'][$i];


				$sql = "UPDATE products SET quantity = :quantity, min_quantity = :min_quantity WHERE id = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":quantity", $quantity);
				$sql->bindValue(":min_quantity", $min_quantity);
				$sql->bindValue(":id", $id);
				$sql->execute();
			}
			return true;

		} else {
			return false;
		}

	}

	/** A variável $total recebe a contagem total de todos os produtos escolhido pelo usuário, a variável $codinventario recebe um número aleatório que será o identificador do iventário para facilitar que o usuário identifique melhor os inventários salvos  */
	/** Função para addConjunct salva a o valor total dos produtos, o identificador do iventário e a data em que o inventário foi salvo, é salvo na tabela conjunct */
	public function addConjunct($total, $codinventario) {

		if (!empty($total)) {

			$sql = "INSERT INTO conjunct(cod_inventario, data_conjunct, total_conjunct) VALUES(:codinventario ,NOW(), :total_conjunct)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":total_conjunct", $total);
			$sql->bindValue(":codinventario", $codinventario);
			$sql->execute();	
		 
			return true;

		}
			else{
				return false;
			}
		
	}

	/** A variável $array recebe os dados do produto e a diferença entre a quantidade e a quantidade mínima, a variável $id_conjunct recebe o id dos dados que foram salvos por último na tabela conjunct */
	/** A função addInventario salva todos os dados atuais dos produtos que foram passados como parâmetro */
	public function addInventario($array, $id_conjunct) {
		$id_conjunct = $id_conjunct[0];
		if($array && $id_conjunct) {
			for ($i=0; $i < count($array['name']); $i++) {
				$id = $array['id'][$i];
				if (in_array($id, $array['check'])) {
					 $id_products = $id;
					 $cod = $array['cod'][$i];
					 $name_products = $array['name'][$i];
					 $quantity = $array['quantity'][$i];
					 $min_quantity = $array['min_quantity'][$i];
					 $difference = $array['difference'][$i];
				 
					$sql = "INSERT INTO inventario (id_products, cod, name_products, quantity, min_quantity, difference, id_conjunct) VALUES (:id_products, :cod, :name_products, :quantity, :min_quantity, :difference, :id_conjunct)";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":id_products", $id_products);
					$sql->bindValue(":cod", $cod);
					$sql->bindValue(":name_products", $name_products);
					$sql->bindValue(":quantity", $quantity);
					$sql->bindValue(":min_quantity", $min_quantity);
					$sql->bindValue(":difference", $difference);
					$sql->bindValue(":id_conjunct", $id_conjunct);
					$sql->execute();
				} 

			}

			return true;

		} else {
			return false;
		}
	}

	/** A variável $array recebe os dados do produto e a diferença entre a quantidade e a quantidade mínima (recebe os dados dos últimos produtos salvos na tabela inventário), a variável $id_conjunct recebe o id dos dados que foram salvos por último na tabela conjunct */
	/** A função addInventarioFechar salva todos os dados depois da contagem dos produtos do estoque que foram passados como parâmetro */
	public function addInventarioFechar($array, $id_conjunct) {
		$id_conjunct = $id_conjunct[0];
		if($array && $id_conjunct) {
			for ($i=0; $i < count($array['name']); $i++) {
					 $id_products = $array['id_products'][$i];
					 $cod = $array['cod'][$i];
					 $name_products = $array['name'][$i];
					 $quantity = $array['quantity'][$i];
					 $min_quantity = $array['min_quantity'][$i];
					 $difference = $array['difference'][$i];
				 
					$sql = "INSERT INTO inventario (id_products, cod, name_products, quantity, min_quantity, difference, id_conjunct) VALUES (:id_products, :cod, :name_products, :quantity, :min_quantity, :difference, :id_conjunct)";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":id_products", $id_products);
					$sql->bindValue(":cod", $cod);
					$sql->bindValue(":name_products", $name_products);
					$sql->bindValue(":quantity", $quantity);
					$sql->bindValue(":min_quantity", $min_quantity);
					$sql->bindValue(":difference", $difference);
					$sql->bindValue(":id_conjunct", $id_conjunct);
					$sql->execute();
				

			}

			return true;

		} else {
			return false;
		}
	}



/** A função getConjunct retorna a última informação salva na tabela conjunct */
public function getConjunct() {
		$array = array();

		$sql = "SELECT id FROM conjunct ORDER BY id DESC LIMIT 1";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

	/** A função getDateConjunct retorna todos os dados da tabela conjunct ordenado pela data de forma decrescente */
	public function getDateConjuct() {
		$array = array();

		$sql = "SELECT * FROM conjunct ORDER BY data_conjunct DESC";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}
	/** A variável $c recebe a data do inventário */
	/** A função getInventarioProducts lista todos os dados salvo no inventário junto com a inforção salva na tabela conjunct em uma seleção, para que o usuário possa escolher a opção e visualizar os dados dos produtos que foram salvos no inventário */
	public function getInventarioProducts($c='') {
		$array = array();
			if(!empty($c)) {
				$sql = "SELECT conjunct.data_conjunct, conjunct.total_conjunct, inventario.cod, inventario.name_products, inventario.quantity, inventario.min_quantity, inventario.difference 
				FROM conjunct
				INNER JOIN inventario
				ON conjunct.id = inventario.id_conjunct 
				WHERE conjunct.id = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id", $c);
				$sql->execute();


				if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
			}
							
	}

	public function getProductsConjunct($id_conjunct) {
		$array = array();
		$id = $id_conjunct['id'];

		$sql = "SELECT inventario.id, inventario.id_products, inventario.cod, inventario.name_products, inventario.quantity, inventario.min_quantity, inventario.difference, inventario.id_conjunct, conjunct.cod_inventario
				FROM inventario 
				INNER JOIN conjunct
				on inventario.id_conjunct = conjunct.id
				WHERE id_conjunct = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

}






















