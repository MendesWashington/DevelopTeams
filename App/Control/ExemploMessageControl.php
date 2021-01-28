<?php

use Livro\Control\Page;
use Livro\Widgets\Dialog\Message;

class ExemploMessageControl extends Page {
	public function __construct(){
		parent::__construct();
		
		new Message('danger' , 'Mensagem código vermelho');
		new Message('warning','Mensagem código Laranja');
		new Message('info'   ,'Mensagem código Azul');
		new Message('success','Mensagem código Verde');
		new Message('default','Mensagem código Branco');
	}
}