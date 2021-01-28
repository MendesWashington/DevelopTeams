<?php

use Livro\Database\Connection;
use Livro\Database\Transaction;
use Livro\Database\Record;
use Livro\Control\Page;

class TwigSampleControlProduto extends Page{
	public function __construct(){
		parent::__construct();

		try {
			Transaction::open('estoque');
			$p1 = Produto::find(1);
			

			require_once'Lib/Twig/Autoloader.php';
			Twig_Autoloader::register();

			$loader    = new Twig_Loader_Filesystem('App/Resouces');
			$twgi      = new Twig_Environment($loader);
			$template  = $twgi->loadTemplate('produto.html');

			$replaces = array();
			$replaces['title'] = 'Dados do Banco';
			$replaces['action'] = 'index.php?class=TwigSampleControlProduto&method=onGravar';
			$replaces['descricao'] = $p1->descricao;
			$replaces['estoque'] = $p1->estoque;
			$replaces['preco_custo'] = $p1->preco_custo;
			$replaces['preco_venda'] = $p1->preco_venda;
			$replaces['codigo_barra'] = $p1->codigo_barra;
			$replaces['data_cadastro'] = $p1->data_cadastro;
			$replaces['origem'] = $p1->origem;

			$content = $template->render($replaces);
			echo $content;

			Transaction::close();
		} catch (Exception $e) {
			Transaction::rollback();
			print 'Erro ao se conectar com o banco de dados '.$erro->getMessage();
		}
		
	}

	public function onGravar(){
		echo "<pre>";
			var_dump($_POST);
		echo "</pre>\n";
	}
}
?>