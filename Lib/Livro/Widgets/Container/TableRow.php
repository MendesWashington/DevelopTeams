<?php

namespace Livro\Widgets\Container;

use Livro\Widgets\Base\Element;

class TableRow extends Element{
	public function __construct(){
		parent::__construct('tr');
	}
	public function addCell($value){
		//Instancia objeto célula
		$cell = new TableCell($value);
		parent::add($cell);

		//Retorna objeto instanciado
		return $cell;
	}
}