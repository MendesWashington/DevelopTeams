<?php
use Livro\Control\Page;
use Livro\Database\Transaction;
use Livro\Database\Repository;
use Livro\Database\Criteria;

	class CidadeControl extends Page{
		public function listar(){
			try {
				Transaction::open('estoque');
				$criteria = new Criteria();
				//$criteria->setProperty('order', 'id');

				$repository = new Repository('Cidade');
				$cidades = $repository->load($criteria);

				if($cidades){
					foreach($cidades as $cidade){
						print "{$cidade->id} - {$cidade->nome}<br>\n";
					}
				}
				Transaction::close();
			} catch (Exception $erro) {
				print $erro->getMessage()."<br>";
			}
		}
	}
?>