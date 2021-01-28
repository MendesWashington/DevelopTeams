<?php 

namespace Livro\Widgets\Container;

use Livro\Widgets\Base\Element;

class Table extends Element{
	
	public function __construct(){
		parent::__construct('table');		
	}

	public function addRow(){
		//Instancia objeto linha
		$row = new TableRow();

		//Armazena array de linhas
		parent::add($row);
		return $row;
	}
}