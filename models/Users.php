<?php
class Users extends Model {

	private $info;
	private $token;
	private $nivel;


	public function verifyUser($number, $pass) {

		$sql = "SELECT * FROM users WHERE user_number = :unumber AND user_pass = :upass";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":unumber", $number);
		$sql->bindValue(":upass", md5($pass));
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function createToken($unumber) {
		$token = md5(time().rand(0,9999).time().rand(0,9999));

		$sql = "UPDATE users SET user_token = :token WHERE user_number = :unumber";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":token", $token);
		$sql->bindValue(":unumber", $unumber);
		$sql->execute();


		return $token;
	}

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

	public function addUsuario($user_number, $user_pass, $nivel, $nome) {
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

			$this->nivel = explode(',', $sql['nivel']);
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



}


















