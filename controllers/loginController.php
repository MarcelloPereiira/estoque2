<?php
class loginController extends Controller {

	/** Função para autenticar o usuário  */
	public function index() {
		$data = array(
			'msg' => ''
		);

		$filters = new FiltersHelper();

		if(!empty($_POST['number'])) {
			$unumber = $filters->filter_post_cpf('number');
			$upass = $_POST['password'];

			$users = new Users();

			if($users->verifyUser($unumber, $upass)) {
				$token = $users->createToken($unumber);
				$_SESSION['token'] = $token;

				header("Location: ".BASE_URL);
				exit;
			} else {
				$data['msg'] = 'CPF e/ou senha errado(s)!';
			}
		}

		$this->loadView('login', $data);
	}
	/** Função para encerrar a sessão(sair da conta)  */
	public function sair() {
		unset($_SESSION['token']);
		header("Location: ".BASE_URL."login");
		exit;
	}

}