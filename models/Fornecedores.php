<?php
class Fornecedores extends Model {

	public function getFornecedores($s='') {
		$array = array();

		if(!empty($s)) {
			$sql = "SELECT * FROM fornecedores WHERE nome LIKE :nome OR cnpj LIKE :cnpj";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", '%'.$s.'%');
			$sql->bindValue(":cnpj", '%'.$s.'%');
			$sql->execute();
		} else {
			$sql = "SELECT * FROM fornecedores";
			$sql = $this->db->query($sql);
		}

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	private function verifyFornecedores($cnpj) {
		$sql = "SELECT * FROM fornecedores WHERE cnpj = :cnpj";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":cnpj", $cnpj);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function addFornecedores($nome, $endereco, $fone, $cnpj) {

		if($this->verifyFornecedores($cnpj)) {

			$sql = "INSERT INTO fornecedores (nome, endereco, fone, cnpj) VALUES (:nome, :endereco, :fone, :cnpj)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":endereco", $endereco);
			$sql->bindValue(":fone", $fone);
			$sql->bindValue(":cnpj", $cnpj);
			$sql->execute();

		} else {
			return false;
		}
	}

	public function editarFornecedor($nome, $endereco, $fone, $cnpj, $id) {

		if($this->verifyFornecedores($nome)) {

			$sql = "UPDATE fornecedores SET nome = :nome, endereco = :endereco, fone = :fone, cnpj = :cnpj WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":endereco", $endereco);
			$sql->bindValue(":fone", $fone);
			$sql->bindValue(":cnpj", $cnpj);
			$sql->bindValue(":id", $id);
			$sql->execute();

		} else {
			return false;
		}

	}

	public function getFornecedor($id) {
		$array = array();

		$sql = "SELECT * FROM fornecedores WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$array = $sql->fetch();

		}

		return $array;
	}

}



















