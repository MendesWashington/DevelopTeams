<?php 
use Livro\Control\Page;

class TwigSampleControlList extends Page{
	public function __construct(){
		parent::__construct();
		require_once'Lib/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader    = new Twig_Loader_Filesystem('App/Resouces');
		$twig     = new Twig_Environment($loader);
		$template = $twig->loadTemplate('list.html');

		$repleces = array();
		$repleces['titulo']  = 'Lista de Pessoas';
		$repleces['pessoas'] = array(
									array('codigo'=> '1', 'nome'=> 'Washington Santos', 'endereco'=>'Rua da Glória'),
									array('codigo'=> '2', 'nome'=> 'Anita Linda', 'endereco'=>'Rua dos Anjos'),
									array('codigo'=> '3', 'nome'=> 'Paula Fernades', 'endereco'=>'Rua da Bleza'));
		
		$content = $template->render($repleces);
		echo $content;
	}
}