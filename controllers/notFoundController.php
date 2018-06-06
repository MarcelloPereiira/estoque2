<?php
class notFoundController extends Controller {

	/** Função para mostrar que a página não foi encontrada, caso ocorra alguma irregularidade que faça o sistema não encontrar a página  */
    public function index() {
        $data = array();
        
        $this->loadView('404', $data);
    }

}