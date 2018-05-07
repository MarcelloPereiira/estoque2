<?php
class Products extends Model {

	public function getProducts($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM products WHERE cod = :cod OR name LIKE :name";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":cod", $s);
			$sql->bindValue(":name", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM products";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	private function verifyProduct($cod) {
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

	public function addProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories) {

		if($this->verifyProduct($cod)) {

			$sql = "INSERT INTO products (cod, name, price, quantity, min_quantity, id_categories) VALUES (:cod, :name, :price, :quantity, :min_quantity, :id_categories)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":cod", $cod);
			$sql->bindValue(":name", $name);
			$sql->bindValue(":price", $price);
			$sql->bindValue(":quantity", $quantity);
			$sql->bindValue(":min_quantity", $min_quantity);
			$sql->bindValue(":id_categories", $id_categories);
			$sql->execute();

			return true;

		} else {
			return false;
		}
	}

	public function editProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories, $id) {

		if($this->verifyProduct($name)) {

			$sql = "UPDATE products SET cod = :cod, name = :name, price = :price, quantity = :quantity, min_quantity = :min_quantity,id_categories = :id_categories WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":cod", $cod);
			$sql->bindValue(":name", $name);
			$sql->bindValue(":price", $price);
			$sql->bindValue(":quantity", $quantity);
			$sql->bindValue(":min_quantity", $min_quantity);
			$sql->bindValue(":id_categories", $id_categories);
			$sql->bindValue(":id", $id);
			$sql->execute();
			return true;

		} else {
			return false;
		}

	}

	public function getProduct($id) {
		$array = array();

		$sql = "SELECT * FROM products WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}


	public function getLowQuantityProducts() {
		$array = array();

		$sql = "SELECT * FROM products WHERE quantity < min_quantity";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getLowQuantityProductsRelario() {
		$array = array();

		$sql = "SELECT * FROM products";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function entradaProduto($quantity, $id) {

			$sql = "UPDATE products SET quantity = quantity + :quantity WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":quantity", $quantity);
			$sql->bindValue(":id", $id);
			$sql->execute();

			return true;

	}

	public function addCategoryProduct($nome) {

		if(!empty($nome)) {

			$sql = "INSERT INTO categories (name_categories) VALUES (:nome)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", $nome);
			$sql->execute();

			return true;

		} else {
			return false;
		}
	}

	public function getCategories() {
		$array = array();

		$sql = "SELECT * FROM categories";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

}



















