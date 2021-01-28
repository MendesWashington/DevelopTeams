<?php 
use Livro\Control\Page;
use Livro\Widgets\Container\Panel;

class ExemploPanelControl extends Page{
	public function __construct(){
		parent::__construct();
		$panel = new Panel('Painel com Bootstrap');
		$panel->style = 'margin:20px; width: 15%;';
		$panel->add(str_repeat('Ronal o técnico da hora.<br>', 10));
		$panel->show();
	}
}