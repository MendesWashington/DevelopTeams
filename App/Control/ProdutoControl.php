<?php 
use Livro\Database\Transaction;
use Livro\Database\Repository;
use Livro\Database\Criteria;

class ProdutoControl{
	public function listar(){
		try {
			Transaction::open('estoque');
			$criteria = new Criteria;
			//$criteria->setProperty('order', 'id');

			$repository = new Repository('Produto');
			$produtos = $repository->load($criteria);

			if($produtos){
				foreach ($produtos as $produto) {
					print "{$produto->id} - {$produto->descricao}<br>";
				}
			}
			Transaction::close();
		} catch (Exception $e) {
			print "Aqui ".$e->getMessage();
		}
	}

	public function show($param){
		if($param['method'] == 'listar'){
			$this->listar();
		}
	}
}