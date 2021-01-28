<?php

use Livro\Control\Page;
use Livro\Widgets\Container\Panel;
use Livro\Widgets\Container\VBox;

class ExemploVBoxControl extends Page{
	public function __construct(){
		parent::__construct();

		$panel1 = new Panel('Painel 1','');
		$panel1->style = 'margin: 10px';
		$panel1->class = 'panel panel-success';
		$panel1->add(str_repeat('Washington Mendes dos Santos<br>', 10));

		$panel2 = new Panel('Painel 2');
		$panel2->style = 'margin: 10px;';
		$panel2->add(str_repeat('Washington Mendes dos Santos<br>', 10));

		$box = new VBox();
		$box->add($panel1);
		$box->add($panel2);
		$box->show();
	}
}