<?php
class homeController extends Controller {

	private $user;

	public function __construct() {
		parent::__construct();

		$this->user = new Users();
		if(!$this->user->checkLogin()) {
			header("Location: ".BASE_URL."login");
			exit;
		}		
	}

    public function index() {
        $data = array(
            'menu' => array(
                BASE_URL.'home/add' => 'Adicionar Produto',
                BASE_URL.'relatorio' => 'Relatório',
                BASE_URL.'home/fornecedores' => 'Fornecedores',
                BASE_URL.'home/addUsuario' => 'Cadastrar Usuários',
                BASE_URL.'login/sair' => 'Sair'
            )
        );
        $p = new Products();


        $s = '';
        
        if(!empty($_GET['busca'])) {
        	$s = $_GET['busca'];
        }

        $data['list'] = $p->getProducts($s);

        $this->loadTemplate('home', $data);
    }

    public function add() {
    	$data = array(
            'menu' => array(
                BASE_URL => 'Voltar'
            )
        );
    	$p = new Products();
        $filters = new FiltersHelper();

    	if(!empty($_POST['cod'])) {
            $cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');

            if($cod && $name && $price && $quantity && $min_quantity) {
        		$p->addProduct($cod, $name, $price, $quantity, $min_quantity);

        		header("Location: ".BASE_URL);
        		exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
    	}


    	$this->loadTemplate('add', $data);
    }

    public function edit($id) {
    	$data = array(
            'menu' => array(
                BASE_URL => 'Voltar'
            )
        );
    	$p = new Products();
        $filters = new FiltersHelper();

    	if(!empty($_POST['cod'])) {
            $cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
    		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');

            if($cod && $name && $price && $quantity && $min_quantity) {
        		$p->editProduct($cod, $name, $price, $quantity, $min_quantity, $id);

        		header("Location: ".BASE_URL);
        		exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
    	}

    	$data['info'] = $p->getProduct($id);

    	$this->loadTemplate('edit', $data);
    }


      public function fornecedores() {
        $data = array(
            'menu' => array(
                BASE_URL => 'Voltar',
                BASE_URL.'home/listafornecedores' => 'Lista'
            )
        );
        $f = new Fornecedores();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $endereco = addslashes($_POST['endereco']);
            $fone = addslashes($_POST['fone']);
            $cnpj = addslashes($_POST['cnpj']);

            if($nome && $endereco && $fone && $cnpj) {
                $f->addFornecedores($nome, $endereco, $fone, $cnpj);

                header("Location: ".BASE_URL);
                exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }


        $this->loadTemplate('fornecedores', $data);
    }

    public function editarFornecedor($id) {
        $data = array(
            'menu' => array(
                BASE_URL => 'Voltar'
            )
        );
        $f = new Fornecedores();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $endereco = addslashes($_POST['endereco']);
            $fone = addslashes($_POST['fone']);
            $cnpj = addslashes($_POST['cnpj']);

            if($nome && $endereco && $fone && $cnpj) {
                $f->editarFornecedor($nome, $endereco, $fone, $cnpj, $id);

                header("Location: ".BASE_URL);
                exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }

        $data['info'] = $f->getFornecedor($id);

        $this->loadTemplate('editarFornecedor', $data);
    }

    public function listafornecedores() {
         $data = array(
            'menu' => array(
                BASE_URL => 'Voltar'
            )
        );
        $f = new Fornecedores();


        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        $data['list'] = $f->getFornecedores($s);

        $this->loadTemplate('listafornecedores', $data);
    }

    public function addUsuario() {
        $data = array(
            'menu' => array(
                BASE_URL => 'Voltar'
            )
        );
        $f = new Users();
        //$filters = new FiltersHelper();

        if(!empty($_POST['user_number']) || !empty($_POST['user_pass'])) {
            $user_number = addslashes($_POST['user_number']);
            $user_pass = md5(addslashes($_POST['user_pass']));

            if($user_number && $user_pass) {
                $f->addUsuario($user_number, $user_pass);

                header("Location: ".BASE_URL);
                exit;
            } else {
                $data['msg'] = 'Digite os campos corretamente.';
            }
        }


        $this->loadTemplate('addUsuario', $data);
    }

     public function getProductAdd($id) {
        
        $p = new Products();

        if(!empty($_POST['id'])) {
            $id = addslashes($_POST['id']);
            $nome = addslashes($_POST['nome']);

            if($id && $nome) {
                $p->getProductAdd($id, $nome);

                header("Location: ".BASE_URL);
                exit;
            }
        }

        $data['info'] = $p->getProductAdd($nome);

        $this->loadTemplate('add', $data);
    }



}








