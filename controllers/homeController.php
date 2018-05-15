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
        $users = new Users();
        $users->setUsuario($_SESSION['token']);

        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'home/fornecedores' => 'FORNECEDOR',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'home/fornecedores' => 'FORNECEDOR',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        else if ($users->hasPermission("CX")) {
            $data = array(
            'menu' => array(
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        
        $p = new Products();
        

        $s = '';
        $c = '';
        
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
        	$s = $_GET['busca'];
            $c = $_GET['category'];
        }else if (empty($_GET['category'])) {
            $_GET['category'] = '';
        }

        $data['list'] = $p->getProducts($s, $c);
        $data['nome'] = $users->getNome();

        //$data['list'] = $p->getCategory($c);

        $data['listcategory'] = $p->getCategories();
        $this->loadTemplate('home', $data);
    }

    public function add() {
    	$data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
    	$p = new Products();
        $filters = new FiltersHelper();

        //$f = new Fornecedores();
        //$data['list'] = $f->getFornecedores();

    	if(!empty($_POST['cod'])) {
            $cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
            $name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');
            if (!empty($_POST['id'])) {
                $id_categories = addslashes($_POST['id']);
            }   else{
                    $id_categories = null;
                }  
            //$name_fornecedor = filter_input(INPUT_POST, 'name_fornecedor', FILTER_VALIDATE_INT);

            if($cod && $name && $price && $quantity && $min_quantity && $id_categories) {
        		if($p->addProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories)){
                    $data['sucess'] = 'Cadastrado com sucesso.';
                } else{
                    $data['warning'] = 'O produto já existe.';
                }

        		//header("Location: ".BASE_URL);
        		//exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
    	}
        $data['list'] = $p->getCategories();
    	$this->loadTemplate('add', $data);
    }

    public function edit($id) {
    	$data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
    	$p = new Products();
        $filters = new FiltersHelper();


    	if(!empty($_POST['cod'])) {
            $cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
    		$name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');
            if (!empty($_POST['id'])) {
                $id_categories = addslashes($_POST['id']);
            }   else{
                    $id_categories = null;
                }  

            if($cod && $name && $price && $quantity && $min_quantity) {
        		$p->editProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories, $id);

                $data['sucess'] = 'Editado com sucesso.';
        		//header("Location: ".BASE_URL);
        		//exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
    	}

    	$data['info'] = $p->getProduct($id);
        $data['list'] = $p->getCategories();

    	$this->loadTemplate('edit', $data);
    }


      public function fornecedores() {
        $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR',
                BASE_URL.'home/listafornecedores' => 'LISTA'
            )
        );
        $f = new Fornecedores();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $nome = ucwords(mb_strtolower(addslashes($_POST['nome'])));
            $endereco = ucwords(mb_strtolower(addslashes($_POST['endereco'])));
            $fone = addslashes($_POST['fone']);
            $cnpj = addslashes($_POST['cnpj']);

            if($nome && $endereco && $fone && $cnpj) {
                if($f->addFornecedores($nome, $endereco, $fone, $cnpj)){
                    $data['sucess'] = 'Cadastrado com sucesso.';
                }   else{
                    $data['warning'] = 'O fornecedor já existe.';
                }

                //header("Location: ".BASE_URL);
                //exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }


        $this->loadTemplate('fornecedores', $data);
    }

    public function editarFornecedor($id) {
        $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
        $f = new Fornecedores();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $nome = ucwords(mb_strtolower(addslashes($_POST['nome'])));
            $endereco = ucwords(mb_strtolower(addslashes($_POST['endereco'])));
            $fone = addslashes($_POST['fone']);
            $cnpj = addslashes($_POST['cnpj']);

            if($nome && $endereco && $fone && $cnpj) {
                $f->editarFornecedor($nome, $endereco, $fone, $cnpj, $id);

                $data['sucess'] = 'Editado com sucesso.';
                //header("Location: ".BASE_URL);
                //exit;
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
                BASE_URL => 'VOLTAR'
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
                BASE_URL => 'VOLTAR',
                BASE_URL.'home/listausuarios' => 'LISTA'
            )
        );
        $f = new Users();
        //$filters = new FiltersHelper();

        if((!empty($_POST['user_number']) && !empty($_POST['user_pass'])) && isset($_POST['enviarNivel']) && !empty($_POST['nome'])) {
            $user_number = addslashes($_POST['user_number']);
            $user_pass = md5(addslashes($_POST['user_pass']));
            $nivel = addslashes($_POST['enviarNivel']);
            $nome = mb_strtoupper(addslashes($_POST['nome']));

            if($user_number && $user_pass && $nivel && $nome) {
                
                if ($f->addUsuario($user_number, $user_pass, $nivel, $nome)) {
                    $data['msg'] = 'Cadastrado com sucesso.';   
                } else{
                    $data['msg'] = 'O usuário já existe.';
                }

                //header("Location: ".BASE_URL);
                //exit;
            } else {
                $data['msg'] = 'Digite os campos corretamente.';
            }
        }


        $this->loadTemplate('addUsuario', $data);
    }



    public function listausuarios() {
         $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
        $u = new Users();


        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        $data['list'] = $u->getUsers($s);

        $this->loadTemplate('listausuarios', $data);
    }



     public function editarUsuario($id) {
        $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
        $f = new Users();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $user_number = addslashes($_POST['user_number']);
            $user_pass = md5(addslashes($_POST['user_pass']));
            $nivel = addslashes($_POST['enviarNivel']);
            $nome = mb_strtoupper(addslashes($_POST['nome']));

             if($user_number && $user_pass && $nivel && $nome) {
                
                if ($f->editUser($user_number, $user_pass, $nivel, $nome, $id)) {
                    $data['msg'] = 'Editado com sucesso.';   
                } else{
                    $data['msg'] = 'O usuário já existe.';
                }

                //header("Location: ".BASE_URL);
                //exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }

        $data['info'] = $f->getUser($id);

        $this->loadTemplate('editarusuario', $data);
    }

    




    public function entrada() {
         $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );

         $p = new Products();
        

        if(!empty($_POST['quantity'])){
            $quantity = addslashes($_POST['quantity']);
            $id = addslashes($_POST['id']);

            if($quantity && $id) {
                $p->entradaProduto($quantity, $id);
                $data['sucess'] = 'Entrada de Produto com sucesso.';
                    
            } else{
                   $data['warning'] = 'Não foi possível dar entrada.';
              }
        }

        $data['list'] = $p->getProducts();
        $this->loadTemplate('entrada', $data);
    }


    public function addCategoria() {
        $data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR'
            )
        );
        $p = new Products();
        //$filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            $nome = ucwords(mb_strtolower(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING)));

            if($nome){
                if ($p->addCategoryProduct($nome)) {
                    $data['sucess'] = 'Cadastrado com sucesso.';   
                } else{
                    $data['warning'] = 'O usuário já existe.';
                }

                //header("Location: ".BASE_URL);
                //exit;
            } else {
                $data['msg'] = 'Digite os campos corretamente.';
            }
        }

        $this->loadTemplate('addCategoria', $data);
    }
    

}








