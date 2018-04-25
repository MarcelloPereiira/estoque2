<?php
class inventarioController extends Controller {

	public function __construct() {
		parent::__construct();

		$this->user = new Users();
		if(!$this->user->checkLogin()) {
			header("Location: ".BASE_URL."login");
			exit;
		}		
	}

	public function index() {
		$data = array();
		$p = new Products();

		$data['list'] = $p->getLowQuantityProductsRelario();

		$this->loadTemplate('inventario', $data);
	}

}