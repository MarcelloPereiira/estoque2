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

    /** Funções da página HOME */
    public function index() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);

        /** Menu do usuário administrador*/
        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }

        /** Menu do usuário operacional */
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        /** Menu do usuário Caixa */
        else if ($users->hasPermission("CX")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        
        $p = new Products();
        

        $s = '';
        $c = '';
        /** Condição de Busca por nome/código ou por categorias */
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
        	$s = $_GET['busca'];
            $c = $_GET['category'];
        }else if (empty($_GET['category'])) {
            $_GET['category'] = '';
        }

        /** Pega os produtos ativos */
        $data['list'] = $p->getProducts($s, $c);

        /** Enviando o nome e o tipo de usuário para mostrar a mensagem de boas-vindas na página Home */
        $data['nome'] = $users->getNome();

        /** Mostrar a categoria de cada produto */
        $data['listcategory'] = $p->getCategories();
        $this->loadTemplate('home', $data);
    }
    /** Fim da Função da página HOME */


     /** Função para Inativar os produtos Ativos*/
     public function editarStatusProducts($id) {
        
        $p = new Products();

        /** Envia o id que foi passado como parâmentro para a função getProducts dentro da Classe Products */
        /** id_produto recebe os dados do produto que tem o mesmo id que foi passado com parâmetro  */
        $id_produto = $p->getProduct($id);

        /** Envia o id da categoria do produto que foi recebido na variável id_produto para a função getCategoryStatus que está dentro da Classe Products */
        /** id_produto recebe os dados do produto que tem o mesmo id que foi passado com parâmetro  */
        $categoria = $p->getCategoryStatus($id_produto['id_categories']);
        if (empty($categoria)) {
            echo "<script>alert('A categoria deste produto está desativada.');</script>";
            echo "<script>location.href='../../home';</script>";
            exit;
        } else{
            /** Envia os dados para função getStatus dentro da Classe Products*/
            $data['info'] = $p->upStatus($id_produto, $id, $categoria);

            header("Location: ../../home");   
            exit;
        }
        
    }


    /** Função da página de Lista de Produtos Inativos */
        /** Função para Ativar os produtos Inativos */
    public function inativoproducts() {
        
        $users = new Users();
        $users->setUsuario($_SESSION['token']);

        /** Menu do usuário administrador */
        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        /** Menu do usuário operacional */
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }


        $p = new Products();
        

        $s = '';
        $c = '';
        /** Condição de Busca por nome/código ou por categorias */
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
            $s = $_GET['busca'];
            $c = $_GET['category'];
        }else if (empty($_GET['category'])) {
            $_GET['category'] = '';
        }

        /** Pega os produtos inativos */
        $data['list'] = $p->getProductsInativos($s, $c);

        /** Pega a categoria dos produtos inativos */
        $data['listcategory'] = $p->getCategoriesInativos();

        /** Envia os produtos inativos */
        $this->loadTemplate('inativoproducts', $data);
    }


    /** Função da página de ADICIONAR PRODUTOS */
    public function add() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
    	
        /** Menu do usuário administrador*/
        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        /** Menu do usuário operacional */
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }/** Fim da função da página ADICIONAR PRODUTOS */

    	$p = new Products();
        $filters = new FiltersHelper();


    	if(!empty($_POST['cod'])) {
            /** Recebe os dados enviados pelo usuário */
            $cod = filter_input(INPUT_POST, 'cod', FILTER_SANITIZE_STRING);
            $name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');

            if (!empty($_POST['id'])) {
                $id_categories = addslashes($_POST['id']);    
                        

                if($cod && $name && $price && $quantity && $min_quantity && $id_categories) {
            		if($p->addProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories)){
                        $data['sucess'] = 'Cadastrado com sucesso.';
                    } else{
                        $data['warning'] = 'O produto já existe.';
                    }

                } else {
                    $data['warning'] = 'Digite os campos corretamente.';
                }

            }   else {
                    $data['warning'] = 'Digite os campos corretamente.';
                }

    	} 
        $data['list'] = $p->getCategories();
    	$this->loadTemplate('add', $data);
    }

    /** Função da página EDITAR PRODUTOS*/
    public function edit($id) {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        
        /** Menu do usuário administrador*/
        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        /** Menu do usuário operacional*/
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }


    	$p = new Products();
        $filters = new FiltersHelper();


    	if(!empty($_POST['cod'])) {
            /** Recebe os dados enviados pelo usuário */
            $cod = filter_input(INPUT_POST, 'cod', FILTER_SANITIZE_STRING);
    		$name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            $price = $filters->filter_post_money('price');
            $quantity = $filters->filter_post_money('quantity');
            $min_quantity = $filters->filter_post_money('min_quantity');
            if (!empty($_POST['id'])) {
                $id_categories = addslashes($_POST['id']);
             

                if($cod && $name && $price && $quantity && $min_quantity) {
                    /** Envia os dados para a função editProducts dentro da Classe Products para editar os dados do produto */
            		$p->editProduct($cod, $name, $price, $quantity, $min_quantity, $id_categories, $id);

                    $data['sucess'] = 'Editado com sucesso.';
            		
                } else {
                    $data['warning'] = 'Digite os campos corretamente.';
                }

            }  else {
                    $data['warning'] = 'Digite os campos corretamente.';
                }
    	}
        /** Pega os dados do produto a partir do id do produto, o produto que usuário escolheu para editar */
    	$data['info'] = $p->getProduct($id);
        $data['list'] = $p->getCategories();

    	$this->loadTemplate('edit', $data);
    }/** Fim da função da página EDITAR PRODUTOS*/

    

    /** Função da página ADICIONAR USUÁRIO */
    public function addUsuario() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        /** Menu */
        /** Somente os usuários que são administradores que podem acessar a página de ADICIONAR USUÁRIO */
        $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/listausuarios' => 'LISTA',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        

        $f = new Users();
        

        if((!empty($_POST['user_number']) && !empty($_POST['user_pass'])) && isset($_POST['enviarNivel']) && !empty($_POST['nome'])) {
            /** Recebe os dados enviadas pelo usuário */
            $user_number = addslashes($_POST['user_number']);
            $user_pass = md5(addslashes($_POST['user_pass']));
            $nivel = addslashes($_POST['enviarNivel']);
            $nome = mb_strtoupper(addslashes($_POST['nome']));

            if($user_number && $user_pass && $nivel && $nome) {
                    /** Envia os dados para a função addUsuario dentro da Classe Users */
                if ($f->addUsuario($user_number, $user_pass, $nivel, $nome)) {
                    $data['msg'] = 'Cadastrado com sucesso.';   
                } else{
                    $data['msg'] = 'O usuário já existe.';
                }

            } else {
                $data['msg'] = 'Digite os campos corretamente.';
            }
        }


        $this->loadTemplate('addUsuario', $data);
    }


    /** Função da página Lista de Usuários Ativos */
    public function listausuarios() {
        /** Menu */
        /** Somente os usuários que são administradores que podem acessar a página Lista de Usuários Ativos */
         $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );
        $u = new Users();

        $s = '';

        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        /** Pega a lista de usuários ativos */
        $data['list'] = $u->getUsers($s);

        $this->loadTemplate('listausuarios', $data);
    }


    /** Função da página Editar Usuário */
     public function editarUsuario($id) {
        /** Menu */
        /** Somente os usuários que são administradores que podem acessar a página de Editar Usuário */
         $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/listausuarios' => 'LISTA',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );
        $f = new Users();
        

        if(!empty($_POST['nome'])) {
            /** Recebe os dados enviadas pelo usuário */
            $user_number = addslashes($_POST['user_number']);
            $user_pass = md5(addslashes($_POST['user_pass']));
            $nivel = addslashes($_POST['enviarNivel']);
            $nome = mb_strtoupper(addslashes($_POST['nome']));

             if($user_number && $user_pass && $nivel && $nome) {
                    /** Envia para a função editUser dentro da Classe Users */
                if ($f->editUser($user_number, $user_pass, $nivel, $nome, $id)) {
                    $data['msg'] = 'Editado com sucesso.';   
                } else{
                    $data['msg'] = 'O usuário já existe.';
                }

            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }

        /** Pega os dados do usuário cadastrado a partir do id, o usuário escolhido para editar */
        $data['info'] = $f->getUser($id);

        $this->loadTemplate('editarusuario', $data);
    }

     public function editarStatusUser($id) {
        
        $u = new Users();

        $id_status = $u->getUser($id);
        $data['info'] = $u->upStatus($id_status, $id);

        header("Location: ../listausuarios");
    }

    /** Função da página Lista de Usuários Inativos  */
    public function inativousers() {
        /** menu  */
        /** Somente os usuários que são administradores que podem acessar a página Lista de Usuários Inativos */
         $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/listausuarios' => 'LISTA',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );
        $u = new Users();

        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        /** Pega os usuário inativos  */
        $data['list'] = $u->getUsersInativos($s);

        $this->loadTemplate('inativousers', $data);
    }
    
    /** Função da página Entrada de Nota Fiscal  */
    public function entrada() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        
        /** menu do usuário Administrador  */
         if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        /** menu do usuário Operacional */
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        $p = new Products();
        $filters = new FiltersHelper();


        if(!empty($_POST['quantity'])){
            /** A variável quantity recebe os dados enviados pelo usuário, antes o dado é passado para a função filter_post_money dentro da Classe FiltersHelper */
            $quantity = $filters->filter_post_money('quantity');
            $id = $_POST['id'];

            if($quantity && $id) {
                /** Envia os dados para a função entradaProduto dentro da Classe Products */
                $p->entradaProduto($quantity, $id);
                $data['sucess'] = 'Entrada de Produto com sucesso.';
                    
            } else{
                   $data['warning'] = 'Não foi possível dar entrada.';
              }
        }

        /** Pega os produtos ativos e envia para a página */
        $data['list'] = $p->getProducts();
        $this->loadTemplate('entrada', $data);
    }


    /** Função da página Cadastro de Categoria */
    public function addCategoria() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        /** Menu do usuário administrador */
         if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'home/addUsuario' => 'CADASTRAR USUÁRIO',
                BASE_URL.'login/sair' => 'SAIR'
                
            )
        );

        }
        /** Menu do usuário Operacional */
        else if ($users->hasPermission("OP")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }


        $p = new Products();
        

        if(!empty($_POST['nome'])) {
            /** A variável $nome recebe o dado enviado pelo usuário */
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

    public function listacategorias() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        
          if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
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
                BASE_URL => 'HOME',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }



        $p = new Products();


        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        $data['list'] = $p->getCategory($s);

        $this->loadTemplate('listacategorias', $data);
    }

    public function editarCategory($id) {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
        
          if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
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
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        $p = new Products();
        

        if(!empty($_POST['name_categories'])) {
            $name_categories = ucwords(mb_strtolower(addslashes($_POST['name_categories'])));

            if($name_categories) {
                $p->editarCategoria($name_categories, $id);

                $data['sucess'] = 'Editado com sucesso.';
                //header("Location: ".BASE_URL);
                //exit;
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }

        $data['info'] = $p->getCategoryEdit($id);

        $this->loadTemplate('editcategory', $data);
    }

     public function editarStatusCategory($id) {
        
        
        $p = new Products();

        $id_status = $p->getCategoryEdit($id);
        $produto = $p->getProductCat($id);
        if (!empty($produto)) {
             echo "<script>alert('Existem produtos ativos relacionados a esta categoria. Não foi possível Inativar.');</script>";
             echo "<script>location.href='listacategorias';</script>";
             exit;
        } else{
            $data['info'] = $p->upStatusCategory($id_status, $id, $produto);
            header("Location: ../listacategorias");
            exit;
        }
        
    }

    public function inativocategories() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);
    

          if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
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
                BASE_URL => 'HOME',
                BASE_URL."home/listacategorias" => "LISTA",
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }

        $p = new Products();
        
        

        $s = '';
        
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
            $s = $_GET['busca'];
        }

        $data['list'] = $p->getCategoryInativos($s);


        $this->loadTemplate('inativocategories', $data);
    }

    
    

}








