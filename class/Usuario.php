<?php

class Usuario {
	private $idusuario, $deslogin, $dessenha, $dtcadastro;

	public function getIdUsuario() {
		return $this->idusuario;
	}

	public function setIdUsuario($value) {
		$this->idusuario = $value;
	}

	public function getLogin() {
		return $this->deslogin;
	}

	public function setLogin($value) {
		$this->deslogin = $value;
	}

	public function getSenha() {
		return $this->dessenha;
	}

	public function setSenha($value) {
		$this->dessenha = $value;
	}

	public function getDtCadastro() {
		return $this->dtcadastro;
	}

	public function setDtCadastro($value) {
		$this->dtcadastro = $value;
	}

	public function loadById($id) {
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));

		if (isset($results[0])) {
			$this->setData($results[0]);
		}
	}

	public static function getList() {
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}

	public static function search($login) {
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH'=>"%".$login."%"));
	}

	public function login($login, $password){
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(":LOGIN"=>$login, ":PASSWORD"=>$password));

		if (isset($results[0])) {
			$this->setData($results[0]);
		} else {
			throw new Exception("Login e/ou senha inválidos");
			
		}
	}

	public function setData($data) {
		$this->setIdUsuario($data['idusuario']);
		$this->setLogin($data['deslogin']);
		$this->setSenha($data['dessenha']);
		$this->setDtCadastro(new DateTime($data['dtcadastro']));
	}

	public function insert() {
		$sql = new Sql();
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(':LOGIN'=>$this->getLogin(), ':PASSWORD'=>$this->getSenha()));

		if (isset($results[0])) {
			$this->setData($results[0]);
		}
	}

	public function update($login, $password) {
		$this->setLogin($login);
		$this->setSenha($password);		

		$sql = new Sql();
		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getLogin(), 
			':PASSWORD'=>$this->getSenha(), 
			':ID'=>$this->getIdUsuario()
		));
	}

	public function delete() {
		$sql = new Sql();
		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=>$this->getIdUsuario()
		));

		$this->setIdUsuario(0);
		$this->setLogin("");
		$this->setSenha("");
		$this->setDtCadastro(new DateTime());
	}

	public function __construct($login = "", $password = "") {
		$this->setLogin($login);
		$this->setSenha($password);
	}

	public function __toString() {
		return json_encode(array(
			"idusuario"=>$this->getIdUsuario(),
			"deslogin"=>$this->getLogin(),
			"dessenha"=>$this->getSenha(),
			"dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}
}

?>