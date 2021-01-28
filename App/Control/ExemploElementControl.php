<?php 
use Livro\Control\Page;
use Livro\Widgets\Base\Element;

class ExemploElementControl extends Page{
	
	public function __construct(){
		parent::__construct();

		$div = new Element('div');
		$div->style  = 'text-align:center;';
		$div->style .= 'font-weiht:bold;';
		$div->style .= 'font-size:20pt;';

		$p = new Element('p');
		$p->add('Sport Club Vitoria');
		$p->style  = 'color:red;';
		$p->style .= 'font-family:verdana;';
		$div->add($p);

		$img = new Element('img');
		$img->src    = 'App/Imagens/vitoria.png';
		$img->style  = 'width:20%;';
		$div->add($img);

		$p = new Element('p');
		$p->add('Club do povo do Vitoria');
		$p->style  = 'color:red;';
		$p->style .= 'font-family:verdana;';
		$div->add($p);

		parent::add($div); 
	}
}