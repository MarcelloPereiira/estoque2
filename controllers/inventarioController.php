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
        $users = new Users();
        $users->setUsuario($_SESSION['token']);

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
            //$cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
    		//$name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            if (!empty($_POST['check'])) {
                $codinventario = $_POST['codinventario'];
                $array['check'] = $_POST['check'];
        		$array['id'] = $_POST['id'];
        		$array['cod'] = $_POST['cod'];
        		$array['name'] = $_POST['name'];
                $array['quantity'] = $_POST['quantity'];
                $array['min_quantity'] = $_POST['min_quantity'];
                $array['difference'] = $_POST['difference'];
                $total = count($_POST['check']);
                //$totalUni = $filters->filter_post_money('totalUni');
                
                if($array && $total) {
                	$i->addConjunct($total, $codinventario);
                	$id_conjunct = $i->getConjunct();
            		$i->addInventario($array, $id_conjunct);
            		

                    //$data['sucess'] = 'Inventário salvo com sucesso.';
                    //$this->loadTemplate('aberturainventario', $data);
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


        $s = '';
        $c = '';
        
        if(!empty($_GET['busca']) || !empty($_GET['category'])) {
        	$s = $_GET['busca'];
            $c = $_GET['category'];
        }else if (empty($_GET['category'])) {
            $_GET['category'] = '';
        }

        $data['list'] = $p->getProducts($s, $c);

        $data['listcategory'] = $p->getCategories();

		$this->loadTemplate('inventario', $data);
	}

    public function aberturainventario() {

        $i = new Inventario();
        $p = new Products();
        //$filters = new FiltersHelper();


        if(!empty($_POST['name'])) {
            //$cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
            //$name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            if (!empty($_POST['cod'])) {
                $codinventario = $_POST['codinventario'];
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