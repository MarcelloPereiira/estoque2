<?php
class Inventario extends Model {

	private function verifyInventario($cod) {
		$sql = "SELECT * FROM products WHERE cod = :cod";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":cod", $cod);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function editInventario($array) {

		if(!empty($array)) {
			for ($i=0; $i < count($array['name']); $i++) {

				 $id = $array['id'][$i];
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

	public function addConjunct($total) {

		if (!empty($total)) {
			$total_conjunct = $total[0];

			$sql = "INSERT INTO conjunct(data_conjunct, total_conjunct) VALUES(NOW(), :total_conjunct)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":total_conjunct", $total_conjunct);
			$sql->execute();	
		 
			return true;

		}
			else{
				return false;
			}
		
	}

	public function addInventario($array, $id_conjunct) {
		
		if(!empty($array)) {
			for ($i=0; $i < count($array['name']); $i++) {

				 $cod = $array['cod'][$i];
				 $name = $array['name'][$i];
				 $quantity = $array['quantity'][$i];
				 $min_quantity = $array['min_quantity'][$i];
				 $difference = $array['min_quantity'][$i] - $array['quantity'][$i];
				 $id_conjunct = $id_conjunct[0];
				 

					$sql = "INSERT INTO inventario (cod, name_products, quantity, min_quantity, difference, id_conjunct) VALUES (:cod, :name, :quantity, :min_quantity, :difference, :id_conjunct)";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":cod", $cod);
					$sql->bindValue(":name", $name);
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





public function getConjunct() {
		$array = array();

		$sql = "SELECT id FROM conjunct ORDER BY data_conjunct DESC LIMIT 1";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

	public function getDateConjuct() {
		$array = array();

		$sql = "SELECT * FROM conjunct";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

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

}






















