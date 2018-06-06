<?php
class Users extends Model {

	private $info;
	private $token;
	private $nivel;

	/** A variável $s é uma variável para busca, recebe o nome do usuário ou o número do usuário(CPF) */
	/** Pega os usuários ativos e retorna um array com esse usuários. */
	public function getUsers($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM users WHERE id_status = 1 AND nome LIKE :nome OR user_number LIKE :user_number";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", '%'.$s.'%');
			$sql->bindValue(":user_number", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM users WHERE id_status = 1 ORDER BY nome";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	/** A variável $s é uma variável para busca, recebe o nome do usuário ou o número do usuário(CPF) */
	/** Pega os usuários inativos e retorna um array com esse usuários. */
	public function getUsersInativos($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM users WHERE id_status = 2 AND nome LIKE :nome OR user_number LIKE :user_number";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", '%'.$s.'%');
			$sql->bindValue(":user_number", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM users WHERE id_status = 2 ORDER BY nome";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	/** A variável $number recebe o número do usuário(CPF) e a variável $pass recebe a senha do usuário*/
	/** A função verifyUser verifica se o usuário e a senha estão corretos e se o usuário está ativo ou não */
	public function verifyUser($number, $pass) {

		$sql = "SELECT * FROM users WHERE user_number = :unumber AND user_pass = :upass";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":unumber", $number);
		$sql->bindValue(":upass", md5($pass));
		$sql->execute();

		if($sql->rowCount() > 0) {
			$status = $sql->fetch();

			if ($status['id_status'] == 1) {
				return true;	
			} 
				else {
					return false;
			}
		} 
			else {
				return false;
		}

	}

	/** A variável $user_number recebe o número do usuário(CPF) e a variável $id recebe o id do usuário*/
	/** A função verifyUserEdit verifica se o usuário e o identificador estão corretos e se o usuário está ativo ou não para que possa ser editado, caso esteja tudo correto*/
	public function verifyUserEdit($user_number, $id) {

		$sql = "SELECT * FROM users WHERE user_number = :user_number";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":user_number", $user_number);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
			if ($id == $array['id']) {
				return true;
			} else{
				return false;
			} 

		} else {
			return true;
		}

	}

	/** A variável $ununber recebe o número do usuário(CPF) */
	/** A função createToken cria um novo token a cada vez que o usuário logar (um número aleatório), para que somente um usuário log na mesma conta */
	public function createToken($unumber) {
		$token = md5(time().rand(0,9999).time().rand(0,9999));

		$sql = "UPDATE users SET user_token = :token WHERE user_number = :unumber";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":token", $token);
		$sql->bindValue(":unumber", $unumber);
		$sql->execute();


		return $token;
	}


	/** A função checkLogin verifica se o token do usuário condiz com o token que foi salvo na sessão. Se tiver mais de uma pessoa logada na mesma conta, uma sessão será encerrada, pois a cada usuário que entra o token é atualizado no banco de dados */
	public function checkLogin() {
		if(!empty($_SESSION['token'])) {
			$token = $_SESSION['token'];

			$sql = "SELECT * FROM users WHERE user_token = :token";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":token", $token);
			$sql->execute();

			if($sql->rowCount() > 0) {
				$this->info = $sql->fetch();

				return true;
			}
		}

		return false;
	}


	/** A variável $user_number recebe o número do usuário(CPF) */
	/** A função verifyUsuario verifica se já existe algum usuário existente com o mesmo número de usuário, caso existe ela retornará falso */	
	public function verifyUsuario($user_number) {

		$sql = "SELECT * FROM users WHERE user_number = :user_number";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":user_number", $user_number);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	/** A variável $user_number recebe o número do usuário(CPF), a variável $user_pass recebe a senha do usuário,
	a variável $nivel recebe o nível do usuário(administrador, operacional ou caixa), a variável $nome recebe o nome do usuário */
	/** A função addUsuario adiciona uma nova conta de usuário */
	public function addUsuario($user_number, $user_pass, $nivel, $nome) {
		/*Passa o número do usuário para a função verifyUsuario para verificar se existe algum usuário existente, se existir, não será adicionado um novo usuário*/
		if($this->verifyUsuario($user_number)) {

			$sql = "INSERT INTO users (user_number, user_pass, nivel, nome) VALUES (:user_number, :user_pass, :nivel, :nome)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":user_number", $user_number);
			$sql->bindValue(":user_pass", $user_pass);
			$sql->bindValue(":nivel", $nivel);
			$sql->bindValue(":nome", $nome);
			$sql->execute();

			return true;

		} else {

			return false;
		}
	}

	public function setUsuario($token){
		$this->token = $token;

		$sql = "SELECT * FROM users WHERE user_token = :token";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":token", $token);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$sql = $sql->fetch();

			$this->nivel = array($sql['nivel']);
			//$this->nivel = explode(',', $sql['nivel']);
		}

	}

	public function getNivel() {
		return $this->nivel;
	}

	public function hasPermission($p){
		if (in_array($p, $this->nivel)) {
			return true;
		} else{
			return false;
		}
	}

	public function getNome(){
		$array = array();
		$token = $_SESSION['token'];

		$sql = "SELECT * FROM users WHERE user_token = :token";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":token", $token);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}
		return $array;
	}

	public function getUser($id) {
		$array = array();

		$sql = "SELECT * FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

	public function editUser($user_number, $user_pass, $nivel, $nome, $id) {

		if($this->verifyUserEdit($user_number, $id)) {

			$sql = "UPDATE users SET user_number = :user_number, user_pass = :user_pass, nivel = :nivel, nome = :nome WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":user_number", $user_number);
			$sql->bindValue(":user_pass", $user_pass);
			$sql->bindValue(":nivel", $nivel);
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":id", $id);
			$sql->execute();

			return true;

		} else {
			return false;
		}

	}




	public function upStatus($id_status, $id) {
		$id_status = $id_status['id_status'];
		if($id_status == 1) {
			$id_status = 2;

			$sql = "UPDATE users SET id_status = :id_status WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_status", $id_status);
			$sql->bindValue(":id", $id);
			$sql->execute();

			return true;
		} else if($id_status == 2){
			$id_status = 1;
			
			$sql = "UPDATE users SET id_status = :id_status WHERE id = :id";
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


















