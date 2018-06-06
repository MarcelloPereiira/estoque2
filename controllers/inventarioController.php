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

    /** Função da página Inventário */
    /** Função para listar os produtos ativos em uma tabela */
    /** Esse inventário é salvo antes da contagem dos produtos */
	public function index() {
        $users = new Users();
        $users->setUsuario($_SESSION['token']);

        /** Menu do usuário administrador */
        if ($users->hasPermission("ADM")) {
            $data = array(
            'menu' => array(
                BASE_URL => 'HOME',
                BASE_URL.'inventario/inventarioconsulta' => 'CONSULTA',
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
                BASE_URL.'inventario/inventarioconsulta' => 'CONSULTA',
                BASE_URL.'home/add' => 'ADICIONAR PRODUTO',
                BASE_URL.'inventario' => 'INVENTÁRIO',
                BASE_URL.'home/entrada' => 'ENTRADA',
                BASE_URL.'home/addCategoria' => 'CATEGORIAS',
                BASE_URL.'login/sair' => 'SAIR'
            )
        );

        }


		$i = new Inventario();
		$p = new Products();
		//$filters = new FiltersHelper();


		if(!empty($_POST['name'])) {
            if (!empty($_POST['check'])) {
                /** A variável $codinventario recebe um código aleatório a cada vez que é aberto o inventário, esse código identifica o inventário */
                $codinventario = $_POST['codinventario'];
                /** Recebe todos os dados dos produtos para montar o inventário */
                $array['check'] = $_POST['check'];
        		$array['id'] = $_POST['id'];
        		$array['cod'] = $_POST['cod'];
        		$array['name'] = $_POST['name'];
                $array['quantity'] = $_POST['quantity'];
                $array['min_quantity'] = $_POST['min_quantity'];
                $array['difference'] = $_POST['difference'];
                /** A variavel $total recebe a contagem de todos os checkbox que foram marcados e enviados pelo usuário */
                $total = count($_POST['check']);
                
                if($array && $total) {
                    /** Envia a variável $total e $codinventario para a função addConjunct dentro da Classe Inventario */
                	$i->addConjunct($total, $codinventario);
                    /** A variável $id_conjunct recebe o resultado(retorno) da função getConjunct */
                	$id_conjunct = $i->getConjunct();
                    /** Envia o array $array e a variável $id_conjunct para a função addInventario dentro da Classe Inventario */
            		$i->addInventario($array, $id_conjunct);
            		
                    /** Depois que o usuário clicar no botão "Abrir Inventário" vai ser redirecionado para a página Abertura de Inventário (aberturainventario) */
            		header("Location: ".BASE_URL.'inventario/aberturainventario');
            		exit;
                } else {
                    $data['warning'] = 'Não foi possível abrir o inventário.';
                    }
            }   
                else {
                    $data['warning'] = 'Escolha algum produto. Não foi possível abrir o inventário.';
                    }
    	}


        /** Variável de busca por nome ou por código de barras */
        $s = '';

        /** Variável de busca por categoria */
        $c = '';
        
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
        	$s = $_GET['busca'];
            $c = $_GET['category'];
        }else if (empty($_GET['category'])) {
            $_GET['category'] = '';
        }

        /** Pega os produtos ativos */
        $data['list'] = $p->getProducts($s, $c);

        /** Pega todas as categorias ativas */
        $data['listcategory'] = $p->getCategories();

		$this->loadTemplate('inventario', $data);
	}

    /** Função da página Abertura de Inventário */
    /** Função para listar os produtos em uma tabela que foram escolhidos pelo usuário no Inventário, onde poderá ser editado a quantidade e a quantidade mínima */
    /** Esse inventário é salvo depois da contagem dos produtos */
    public function aberturainventario() {

        $i = new Inventario();
        $p = new Products();
        //$filters = new FiltersHelper();


        if(!empty($_POST['name'])) {
            if (!empty($_POST['cod'])) {
                /** A variável $codinventario recebe o mesmo código que foi gerado aleatóriamente no Inventário a cada vez que é aberto o inventário, esse código identifica o inventário */
                $codinventario = $_POST['codinventario'];
                /** Recebendo todos os dados dos produtos para montar o inventário */
                $array['id_products'] = $_POST['id_products'];
                $array['cod'] = $_POST['cod'];
                $array['name'] = $_POST['name'];
                $array['quantity'] = $_POST['quantity'];
                $array['min_quantity'] = $_POST['min_quantity'];
                $array['difference'] = $_POST['difference'];
                $total = $_POST['totalProducts'];
                //$totalUni = $filters->filter_post_money('totalUni');
                
                if($array && $total) {
                    $i->addConjunct($total, $codinventario);
                    $id_conjunct = $i->getConjunct();
                    $i->editProductsByInventario($array);
                    $i->addInventarioFechar($array, $id_conjunct, $codinventario);
                    
                    echo "<script>alert('Contagem feita com sucesso.');</script>";
                    echo "<script>location.href='../home';</script>";
                    exit;
                } else {
                    $data['warning'] = 'Não foi possível salvar.';
                    }
            }   
                else {
                    $data['warning'] = 'Escolha algum produto. Não foi possível salvar.';
                    }
        }



        $id_conjunct = $i->getConjunct();
        $data['list'] = $i->getProductsConjunct($id_conjunct);

        $this->loadTemplate('aberturainventario', $data);
    }


	public function inventarioconsulta() {
		$data = array();
		$i = new Inventario();

		$c = '';
		if(!empty($_GET['data_conj'])) {
            $c = $_GET['data_conj'];
        }else if (empty($_GET['data_conj'])) {
            $_GET['data_conj'] = '';
        }

        $data['list'] = $i->getInventarioProducts($c);
		$data['listdate'] = $i->getDateConjuct();


		$this->loadTemplate('inventarioconsulta', $data);
	}

}