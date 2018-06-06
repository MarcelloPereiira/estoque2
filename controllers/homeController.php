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

    /** Função da página HOME */
    /** Função para listar os produtos ativos em uma tabela */
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
        
        /** Variável de busca por nome ou por código de barras */
        $s = '';
        /** Variável de busca por categoria */
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

        /** Pega todas as categorias ativas */
        $data['listcategory'] = $p->getCategories();
        $this->loadTemplate('home', $data);
    }
    


     /** Função para Inativar os produtos Ativos*/
     public function editarStatusProducts($id) {
        
        $p = new Products();

        /** Envia o id que foi passado como parâmentro para a função getProducts dentro da Classe Products */
        /** id_produto recebe os dados do produto que tem o mesmo id que foi passado com parâmetro  */
        $id_produto = $p->getProduct($id);

        /** Envia o id da categoria do produto que foi recebido na variável id_produto para a função getCategoryStatus que está dentro da Classe Products */
        /** id_produto recebe os dados do produto que tem o mesmo id que foi passado com parâmetro  */
        $categoria = $p->getCategoryStatus($id_produto['id_categories']);
        /** Se a categoria deste produto estiver inativada, vai dar um alert dizendo que não pode ativar o produto */
        if (empty($categoria)) {
            echo "<script>alert('A categoria deste produto está desativada. Não foi possível ativar o produto');</script>";
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
        /** Função para listar os produtos inativos em uma tabela */
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
        
        /** Variável de busca por nome ou por código de barras */
        $s = '';
        /** Variável de busca por categorias */
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

        /** Pega todas as categorias inativas */
        $data['listcategory'] = $p->getCategoriesInativos();

        /** Envia os produtos inativos */
        $this->loadTemplate('inativoproducts', $data);
    }


    /** Função da página de ADICIONAR PRODUTOS */
    /** Função para adicionar um novo produto */
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
    /** Função para editar um produto */
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
    }

    

    /** Função da página ADICIONAR USUÁRIO */
    /** Função para adicionar um novo usuário */
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
        $filters = new FiltersHelper();
        

        if((!empty($_POST['user_number']) && !empty($_POST['user_pass'])) && isset($_POST['enviarNivel']) && !empty($_POST['nome'])) {
            /** Recebe os dados enviadas pelo usuário */
            $user_number = $filters->filter_post_cpf('user_number');
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
    /** Função para listar os usuário ativos em uma tabela */
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

        /** Variável de busca por nome ou por CPF */
        $s = '';

        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        /** Pega a lista de usuários ativos */
        $data['list'] = $u->getUsers($s);

        $this->loadTemplate('listausuarios', $data);
    }


    /** Função da página Editar Usuário */
    /** Função para editar um usuário */
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
        $filters = new FiltersHelper();

        if(!empty($_POST['nome'])) {
            /** Recebe os dados enviadas pelo usuário */
            $user_number = $filters->filter_post_cpf('user_number');
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

    /** Função para editar o status do usuário (ativar ou inativar) */
     public function editarStatusUser($id) {
        
        $u = new Users();

        $id_status = $u->getUser($id);
        $data['info'] = $u->upStatus($id_status, $id);

        header("Location: ../listausuarios");
    }

    /** Função da página Lista de Usuários Inativos  */
    /** Função para listar os usuário inativos em uma tabela */
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

        /** Variável de busca por nome ou por CPF */
        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

        /** Pega os usuário inativos  */
        $data['list'] = $u->getUsersInativos($s);

        $this->loadTemplate('inativousers', $data);
    }
    
    /** Função da página Entrada de Nota Fiscal  */
    /** Função para dar entrada nos produtos */
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
            $cod = $_POST['cod'];

            if (!empty($cod)) {
                if($cod && $quantity) {
                    /** Envia os dados para a função entradaProduto dentro da Classe Products */
                    $p->entradaProdutoPorCod($quantity, $cod);
                    $data['sucess'] = 'Entrada de Produto com sucesso.';
                        
                } else{
                       $data['warning'] = 'Não foi possível dar entrada.';
                  }

            } else{

                if($quantity && $id) {
                    /** Envia os dados para a função entradaProduto dentro da Classe Products */
                    $p->entradaProduto($quantity, $id);
                    $data['sucess'] = 'Entrada de Produto com sucesso.';
                        
                } else{
                       $data['warning'] = 'Não foi possível dar entrada.';
                  }

            }
        }

        /** Pega os produtos ativos e envia para a página */
        $data['list'] = $p->getProducts();
        $this->loadTemplate('entrada', $data);
    }


    /** Função da página Cadastro de Categoria */
    /** Função para adicionar uma nova categoria */
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

        /** Função da página Lista de Categorias */
        /** Função para listar as categorias ativas em uma tabela */
    public function listacategorias() {
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

        /** Variável de busca por nome */
        $s = '';
        
        if(!empty($_GET['busca'])) {
            $s = $_GET['busca'];
        }

         /** envia a variável $s para a função getCategory dentro da Classe Products e a variável $data['list'] recebe o retorno */
        $data['list'] = $p->getCategory($s);

        $this->loadTemplate('listacategorias', $data);
    }

    /** Função da página Editar Categoria */
    /** Função para editar uma categoria */
    public function editarCategory($id) {
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
        /** Menu do usuário operacional */
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
            /** Recebe o dado enviado pelo usuário */
            $name_categories = ucwords(mb_strtolower(addslashes($_POST['name_categories'])));

            if($name_categories) {
                /** envia os dados para a função editarCategoria dentro da Classe Products */
                $p->editarCategoria($name_categories, $id);

                $data['sucess'] = 'Editado com sucesso.';
                
            } else {
                $data['warning'] = 'Digite os campos corretamente.';
            }
        }

        /** envia o id para a função getCategoryEdit e a variável $data['info'] recebe o resultado(retorno) */
        $data['info'] = $p->getCategoryEdit($id);

        $this->loadTemplate('editcategory', $data);
    }

     /** Função para ativar ou inativar as categorias */
     public function editarStatusCategory($id) {
        
        
        $p = new Products();

        /** Envia o id da categoria que foi passada como parâmetro para a função getCategoryEdit dentro da Classe Products e a variável $id_status recebe o resultado(retorno) */
        $id_status = $p->getCategoryEdit($id);
        /** Envia o id da categoria que foi passada como parâmetro para a função getProductCat dentro da Classe Products e a variável $produto recebe o resultado(retorno) */
        $produto = $p->getProductCat($id);

        /** Se tiver algum produto ativo desta categoria, vai dar um alert dizendo que a categoria não pode ser inativada */
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

    /** Função da página Lista de Categorias Inativas */    
    /** Função para listar as categorias inativas em uma tabela */
    public function inativocategories() {
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
        /** Menu do usuário operacional */
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
        
        
        /** Variável de busca por nome */
        $s = '';
        
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
            $s = $_GET['busca'];
        }

        /** envia a variável $s para a função getCategoryInativos e a variável $data['list'] recebe o resultado(retorno) */
        $data['list'] = $p->getCategoryInativos($s);


        $this->loadTemplate('inativocategories', $data);
    }

    
    

}








