<?php
/** Classe para os produtos */
class Products extends Model {
	/** Função para pegar e retornar os produtos ativos por 'Nome' ou 'Código de barras' e por 'Categoria' */
	/** A variável $s recebe o Nome ou Código de Barras do produto. A variável $c recebe a categoria do produto*/
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

	/** Função para pegar e retornar os produtos inativos por 'Nome' ou 'Código de barras' e por 'Categoria' */
	/** A variável $s recebe o 'Nome' ou 'Código de Barras' do produto. A variável $c recebe a 'categoria' do produto*/
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

	/** Função para verificar se já existe o 'código do produto' que foi passado como parâmetro no banco de dados. Se existir retorna falso, caso contrário retorna verdadeiro */
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

	/** Função para insertir um novo produto no banco banco de dados*/
	public function addProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories) {

		/** Envia o código do produto para a função verifyProduct */
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

	/** Função para atualizar um produto no banco de dados */
	public function editProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories, $id) {

		if(!empty($name)) {

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

	/** Função para pegar e retornar um produto do banco de dados da tabela products, que tenha o mesmo id que foi passado como parâmetro */
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


	/** Função para pegar e retornar um produto do banco de dados da tabela products, onde o id_categories do produto seja igual o id passado como parâmetro e que esteja ativo (id_status = 1) */
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

	/** Função para pegar e retornar um produto do banco de dados da tabela products, onde a quantidade do produto seja menor ou igual a quantidade mínima do produto e que esteja ativo (id_status = 1) */
	public function getLowQuantityProducts() {
		$array = array();

		$sql = "SELECT * FROM products WHERE quantity <= min_quantity AND id_status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	
	/** Função para atualizar um produto do banco de dados da tabela products, somando a quantidade atual do produto com a quantidade ($quantity) que foi passado como parâmetro, o id do produto seja igual o id que foi passado como parâmetro */
	/** Função de entrada de notas fiscais (entrada do produto) */
	public function entradaProduto($quantity, $id) {

			$sql = "UPDATE products SET quantity = quantity + :quantity WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":quantity", $quantity);
			$sql->bindValue(":id", $id);
			$sql->execute();

			return true;

	}
	/** Função para atualizar um produto do banco de dados da tabela products, somando a quantidade atual do produto com a quantidade ($quantity) que foi passado como parâmetro, o codigo do produto seja igual o codigo que foi passado como parâmetro */
	/** Função de entrada de notas fiscais (entrada do produto) */
	public function entradaProdutoPorCod($quantity, $cod) {

			$sql = "UPDATE products SET quantity = quantity + :quantity WHERE cod = :cod";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":quantity", $quantity);
			$sql->bindValue(":cod", $cod);
			$sql->execute();

			return true;

	}


	

	/** Função para insertir uma nova categoria no banco de dados */
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

	/** Função para pegar e retornar todas as categorias ativas (id_status = 1) do banco de dados da tabela categories */
	public function getCategories() {
		$array = array();

		$sql = "SELECT * FROM categories WHERE id_status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

	/** Função para pegar e retornar todas as categorias inativas (id_status = 2) do banco de dados da tabela categories */
	public function getCategoriesInativos() {
		$array = array();

		$sql = "SELECT * FROM categories WHERE id_status = 2";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {

			$array = $sql->fetchAll();

		}

		return $array;
	}

	/** Função para pegar e retornar (buscar) as categorias ativas (id_status = 1) por 'Nome' */
	/** A variável $s recebe o Nome da categoria.*/
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

	/** Função para pegar e retornar (buscar) as categorias inativas (id_status = 2) por 'Nome' */
	/** A variável $s recebe o Nome da categoria.*/
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

	/** Função para atualizar (editar) uma categoria, onde id da categoria seja o mesmo que foi passado como parâmetro */
	/** variável $nome é o nome da categoria.*/
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

	/** Função para pegar e retornar uma categoria, onde o id da categoria for igual o id passado como parâmetro */
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

	/** Função para pegar e retornar uma categoria ativa (id_status = 1), onde o id da categoria for igual o id passado como parâmetro */
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

	/** Função para atualizar (editar) o status do produto ou seja, se o produto estiver ativo (id_status = 1) a função irá inativar, se o produto estiver inativo (id_status = 2) a função irá ativar */
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

	/** Função para atualizar (editar) o status da categoria ou seja, se a categoria estiver ativa (id_status = 1) a função irá inativar, se a categoria estiver inativa (id_status = 2) a função irá ativar */
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



















