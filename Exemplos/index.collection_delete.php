<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Collection</title>
	<meta charset="utf-8">
</head>
<body>
	<?php
		//Carreagar as classes necessárias
		require_once'App/Classes/api/Transaction.php';
		require_once'App/Classes/api/Connection.php';
		require_once'App/Classes/api/Expression.php';
		require_once'App/Classes/api/Criteria.php';
		require_once'App/Classes/api/Repository.php';
		require_once'App/Classes/api/Record.php';
		require_once'App/Classes/api/Filter.php';
		require_once'App/Classes/api/Logger.php';
		require_once'App/Classes/api/LoggerTXT.php';
		require_once'App/Classes/model/Produto.php';

		try {
			//Inicia a trasação necessária
			Transaction::open('estoque');

			//Define o arquivo para LOG
			Transaction::log(new LoggerTXT('App/tmp/log_collection_delete.txt'));

			//Define critério de seleção
			$criteria = new Criteria();
			$criteria->add(new Filter('descricao', 'like', '%Cerveja artesanal IPA%'),Expression::OR_OPERATOR);
			$criteria->add(new Filter('descricao', 'like', '%HD 120 GB%'),Expression::OR_OPERATOR);

			//Cria o repositório
			$repository = new Repository('Produto');
			//Exclui objetos, conforme o critério
			$repository->delete($criteria);

			print"Quantidade de objetos alterados : ".$repository->count($criteria);
			Transaction::close(); //Fecha a transação

		} catch (Exception $erro) {
			echo $erro->getMessage();
			Transaction::rollback();
		}

		

	?>
</body>
</html>