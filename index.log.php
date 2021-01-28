<!DOCTYPE html>
<html lang="pt-br">
<head>

	<title>Livro PHP PDO</title>
</head>
<body>
	<?php
	require_once'../App/classes/ar/ProdutoComTransacaoELogger.php';
	require_once'../App/classes/api/Connection.php';
	require_once'../App/classes/api/Transaction.php';
	require_once'../App/classes/api/Logger.php';
	require_once'../App/classes/api/LoggerTXT.php';
	echo "<meta charset=\"utf-8\">";
	try{
		Transaction::open('estoque');
		Transaction::setLogger(new LoggerTXT('App/tmp/log.txt'));
		Transaction::log('Inserindo produto novo');
		
		$p1 = new Produto();
		$p1->descricao 	   = 'Chocolate Junior';
		$p1->estoque  	   = 80; 
		$p1->preco_custo   =  4;
		$p1->preco_venda   =  7;
		$p1->codigo_barra  = '1465456456456465'; 
		$p1->data_cadastro = date('Y-m-d H:i:s');
		$p1->origem		   = 'J';
		$p1->save();

		$p2 = new Produto();
		$p2->descricao 	   = 'Chocolate Bruna';
		$p2->estoque  	   = 80; 
		$p2->preco_custo   =  4;
		$p2->preco_venda   =  7;
		$p2->codigo_barra  = '2465456456456465'; 
		$p2->data_cadastro = date('Y-m-d H:i:s');
		$p2->origem		   = 'B';
		$p2->save();

		Transaction::close();
	
	}catch(Exception $erro){
		Transaction::rollback();
		print "Erro na database ".$erro->getMessage();
	}
	?>
</body>
</html>