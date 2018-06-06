<?php
class FiltersHelper {
    //Filtra o valor passado como parâmetro e o retorna.
	public function filter_post_money($t) {
        $price = filter_input(INPUT_POST, $t);
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '.', $price);
        $price = filter_var($price, FILTER_VALIDATE_FLOAT);

        return $price;
    }
    //Filtra o valor passado como parâmetro e o retorna.
    public function filter_post_cpf($t) {
        $string = filter_input(INPUT_POST, $t);
        $string = str_replace('.', '', $string);
        $string = str_replace('-', '', $string);
        $string = filter_var($string, FILTER_SANITIZE_STRING);

        return $string;
    }
}