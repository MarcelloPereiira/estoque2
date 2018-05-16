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
		$data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR',
                BASE_URL.'inventario/inventarioconsulta' => 'CONSULTA'
            )
        );
		$i = new Inventario();
		$p = new Products();
		$filters = new FiltersHelper();


		if(!empty($_POST['name'])) {
            //$cod = filter_input(INPUT_POST, 'cod', FILTER_VALIDATE_INT);
    		//$name = ucwords(mb_strtolower(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
            if (!empty($_POST['check'])) {

                $array['check'] = $_POST['check'];
        		$array['id'] = $_POST['id'];
        		$array['cod'] = $_POST['cod'];
        		$array['name'] = $_POST['name'];
                $array['quantity'] = $_POST['quantity'];
                $array['min_quantity'] = $_POST['min_quantity'];
                $array['difference'] = $_POST['difference'];
                $total = $_POST['totalProducts'];
                //$totalUni = $filters->filter_post_money('totalUni');
                
                if($array && $total) {
                	$i->addConjunct($total);
                	$id_conjunct = $i->getConjunct();
                	$i->editInventario($array);
            		$i->addInventario($array, $id_conjunct);
            		

                    $data['sucess'] = 'Inventário salvo com sucesso.';
            		//header("Location: ".BASE_URL);
            		//exit;
                } else {
                    $data['warning'] = 'Não foi possível salvar.';
                    }
            }   
                else {
                    $data['warning'] = 'Escolha algum produto. Não foi possível salvar.';
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


	public function inventarioconsulta() {
		$data = array(
            'menu' => array(
                BASE_URL => 'VOLTAR',
            )
        );
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