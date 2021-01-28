<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Collection</title>
	<meta charset="utf-8">
</head>
<body>
	<?php
		//Carreagar as classes necessárias
		require_once'Lib/Livro/Database/Transaction.php';
		require_once'Lib/Livro/Database/Connection.php';
		require_once'Lib/Livro/Database/Expression.php';
		require_once'Lib/Livro/Database/Criteria.php';
		require_once'Lib/Livro/Database/Repository.php';
		require_once'Lib/Livro/Database/Record.php';
		require_once'Lib/Livro/Database/Filter.php';
		
		require_once'Lib/Livro/Log/Logger.php';
		require_once'Lib/Livro/Log/LoggerTXT.php';
		
		require_once'App/Model/Produto.php';

		try {
			//Inicia a trasação necessária
			Transaction::open('estoque');

			//Define o arquivo para LOG
			Transaction::log(new LoggerTXT('App/tmp/log_collection_update.txt'));

			//Define critério de seleção
			$criteria = new Criteria();
			$criteria->add(new Filter('preco_venda', '<=', 20));
			$criteria->add(new Filter('origem', '=', 'N'));

			//Cria o repositório
			$repository = new Repository('Produto');
			//Carrega os objetos, conforme o critério
			$produtos = $repository->load($criteria);

			if($produtos){
				echo"Produtos <br>\n";
				//Percorre todos os objetos
				foreach($produtos as $produto){
					$produto->preco_venda *= 1.3;
					$produto->store();
				}
			}
			
			print"Quantidade de objetos alterados : ".$repository->count($criteria);
			Transaction::close(); //Fecha a transação

		} catch (Exception $erro) {
			echo $erro->getMessage();
			Transaction::rollback();
		}

		

	?>
</body>
</html>