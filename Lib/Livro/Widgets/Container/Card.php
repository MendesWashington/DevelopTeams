<?php 

namespace Livro\Widgets\Container;

use Livro\Widgets\Base\Element;

class Card extends Element{
	private $body;

	public function __construct($card_title = NULL, $classCard, $bord){
		parent::__construct('div');
		//A class do card
		//$this->class = $bord;
		if($card_title){
			//Div para criar o cabeçalho do card
			$head = new Element('div');
			$head->class = 'card-header '.$classCard;
			
			//Nome que ficara dentro do cabeçalho
			$label = new Element('h4');
			$label->class = 'text-center';
			$label->add($card_title);

			$title = new Element('div');
			$title->class = 'card-title';
			//Adiciona a label ao titulo
			$title->add($label);
			//Adiciona o titulo ao cabeçalho
			$head->add($title);
			//Adiciona todo elemento
			parent::add($head);
		}
		$this->body = new Element('div');
		$this->body->class = 'card-body '.$bord;

		parent::add($this->body);
	}

	public function add($content){
		$this->body->add($content);
	}
}
