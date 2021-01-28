<?php

namespace Livro\Widgets\Container;

use Livro\Widgets\Base\Element;

class Panel extends Element{
	
	private $body;
	
	public function __construct($painel_title = NULL, $classPanel = 'panel panel-default'){
		parent::__construct('div');
		$this->class = $classPanel;
			if($painel_title){
				$head = new Element('div');
				$head->class = 'panel-heading';
				$label = new Element('h4');
				$label->add($painel_title);
				$title = new Element('div');
				$title->class = 'panel-title';
				$title->add($label);
				$head->add($title);
				parent::add($head);
			}
		$this->body = new Element('div');
		$this->body->class = 'panel-body';
		parent::add($this->body);
	}

	public function add($content){
		$this->body->add($content);
	}
}