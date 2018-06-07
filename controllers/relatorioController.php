<?php
class relatorioController extends Controller {

	/** Construtor */
	public function __construct() {
		parent::__construct();
		/** Verificação de login(Somente os usuários logados poderam ter acesso) */
		$this->user = new Users();
		if(!$this->user->checkLogin()) {
			header("Location: ".BASE_URL."login");
			exit;
		}		
	}
	/** Função para listar os dados dos produtos em uma tabela quando a quantidade estiver abaixo da quantidade mínima */
	public function index() {
		$data = array();
		$p = new Products();

		$data['list'] = $p->getLowQuantityProducts();

		$this->loadTemplate('relatorio', $data);
	}

}