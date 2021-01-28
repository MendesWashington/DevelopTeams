<?php

use Livro\Database\Transaction;
use Livro\Control\Page;

class TwigSampleControl extends Page{
	public function __construct(){
		parent::__construct();
		require_once'Lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$loader    = new Twig_Loader_Filesystem('App/Resouces');
		$twgi      = new Twig_Environment($loader);
		$template  = $twgi->loadTemplate('form.html');

		$replaces = array();
		$replaces['title'] = 'Form Ronaldo PHP';
		$replaces['action'] = 'index.php?class=TwigSampleControl&method=onGravar';
		$replaces['nome'] = 'Washington Mendes dos Santos';
		$replaces['endereco'] = 'Rua da glória';
		$replaces['telefone'] = '(71)98822-1520';

		$content = $template->render($replaces);
		echo $content;
	}
	public function onGravar(){
		echo "<pre>";
			var_dump($_POST);
		echo "</pre>\n";
	}
}
?>