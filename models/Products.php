<?php
class Products extends Model {

	public function getProducts($s='', $c='') {
		$array = array();

		if(!empty($s) && empty($c)) {
			$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity,
					categories.name_categories, products.id_status FROM products
					INNER JOIN categories
					on categories.id_categories = products.id_categories WHERE (products.cod = :cod OR products.name LIKE :name) 
					AND products.id_status = 1";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":cod", $s);
			$sql->bindValue(":name", '%'.$s.'%');
			$sql->execute();
		} 
			else if(empty($s) && !empty($c)) {
				$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity,
						categories.name_categories, products.id_status FROM products
						INNER JOIN categories
						on categories.id_categories = products.id_categories WHERE products.id_categories = :id_categories 
						AND products.id_status = 1";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id_categories", $c);
				$sql->execute();
			}
				else if(!empty($s) && !empty($c)) {
					$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity,
							categories.name_categories, products.id_status FROM products
							INNER JOIN categories
							on categories.id_categories = products.id_categories WHERE (products.cod = :cod OR products.name LIKE :name) 
							AND products.id_categories = :id_categories AND products.id_status = 1";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":cod", $s);
					$sql->bindValue(":name", '%'.$s.'%');
					$sql->bindValue(":id_categories", $c);
					$sql->execute();
				}

					else {
						$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity, categories.name_categories, products.id_status FROM products
								INNER JOIN categories
								on categories.id_categories = products.id_categories
						 		WHERE products.id_status = 1";
						$sql = $this->db->query($sql);
					}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getProductsInativos($s='', $c='') {
		$array = array();

		if(!empty($s) && empty($c)) {
			$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity, categories.name_categories, products.id_status FROM products
					INNER JOIN categories
					on categories.id_categories = products.id_categories WHERE (products.cod = :cod OR products.name LIKE :name) 
					AND products.id_status = 2";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":cod", $s);
			$sql->bindValue(":name", '%'.$s.'%');
			$sql->execute();
		} 
			else if(empty($s) && !empty($c)) {
				$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity, categories.name_categories, products.id_status FROM products
						INNER JOIN categories
						on categories.id_categories = products.id_categories WHERE products.id_categories = :id_categories 
						AND products.id_status = 2";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id_categories", $c);
				$sql->execute();
			}
				else if(!empty($s) && !empty($c)) {
					$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity, categories.name_categories, products.id_status FROM products
						INNER JOIN categories
						on categories.id_categories = products.id_categories WHERE (products.cod = :cod OR products.name LIKE :name) 
						AND products.id_categories = :id_categories AND products.id_status = 2";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":cod", $s);
					$sql->bindValue(":name", '%'.$s.'%');
					$sql->bindValue(":id_categories", $c);
					$sql->execute();
				}

					else {
						$sql = "SELECT products.id, products.cod, products.name, products.price, products.quantity, products.min_quantity, categories.name_categories, products.id_status FROM products
								INNER JOIN categories
								on categories.id_categories = products.id_categories
						 		WHERE products.id_status = 2";
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



	public function getProductCat($id) {
		$array = array();

		$sql = "SELECT * FROM products WHERE id_categories = :id AND id_status = 1";
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

		$sql = "SELECT * FROM products WHERE quantity <= min_quantity AND id_status = 1";
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

		$sql = "SELECT * FROM categories WHERE id_status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

	public function getCategoriesInativos() {
		$array = array();

		$sql = "SELECT * FROM categories WHERE id_status = 2";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

	public function getCategory($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM categories WHERE name_categories LIKE :name_categories AND id_status = 1";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":name_categories", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM categories WHERE id_status = 1 ORDER BY name_categories";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getCategoryInativos($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM categories WHERE name_categories LIKE :name_categories AND id_status = 2";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":name_categories", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM categories WHERE id_status = 2 ORDER BY name_categories";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function editarCategoria($nome, $id) {

		if(!empty($nome)) {

			$sql = "UPDATE categories SET name_categories = :name_categories WHERE id_categories = :id_categories";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":name_categories", $nome);
			$sql->bindValue(":id_categories", $id);
			$sql->execute();

			return true;

		} else {
			return false;
		}

	}

	public function getCategoryEdit($id) {
		$array = array();

		$sql = "SELECT * FROM categories WHERE id_categories = :id_categories";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_categories", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

	public function getCategoryStatus($id) {
		$array = array();

		$sql = "SELECT * FROM categories WHERE id_categories = :id_categories_products AND id_status = 1";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_categories_products", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

	public function upStatus($id_status, $id, $categoria) {
		$id_status = $id_status['id_status'];
			if($id_status == 1) {
				$id_status = 2;

				$sql = "UPDATE products SET id_status = :id_status WHERE id = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id_status", $id_status);
				$sql->bindValue(":id", $id);
				$sql->execute();

				return true;
			} else if($id_status == 2){
				if (!empty($categoria)) {
					$id_status = 1;
					
					$sql = "UPDATE products SET id_status = :id_status WHERE id = :id";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(":id_status", $id_status);
					$sql->bindValue(":id", $id);
					$sql->execute();

					return true;
				} else {
					return false;
				}

			} else{
				return false;
			}

	}

	public function upStatusCategory($id_status, $id, $produto) {
		$id_status = $id_status['id_status'];
		if (empty($produto)) {
			if($id_status == 1) {
				$id_status = 2;

				$sql = "UPDATE categories SET id_status = :id_status WHERE id_categories = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id_status", $id_status);
				$sql->bindValue(":id", $id);
				$sql->execute();

				return true;
			} else if($id_status == 2){
				$id_status = 1;
				
				$sql = "UPDATE categories SET id_status = :id_status WHERE id_categories = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":id_status", $id_status);
				$sql->bindValue(":id", $id);
				$sql->execute();

				return true;

			} else{
				return false;
			}
		}

	}

}



















