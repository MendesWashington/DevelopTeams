<?php 
	require_once'app/classes/Api/Connection.php';
	require_once'app/classes/Api/Transaction.php';
	require_once'app/classes/Api/Logger.php';
	require_once'app/classes/Api/LoggerTXT.php';
	require_once'app/classes/api/Record.php';
	require_once'app/classes/model/Produto.php';
	try{
		Transaction::open('estoque');
		Transaction::setLogger(new LoggerTXT('App/tmp/log_clone.txt'));
		Transaction::log('Clonado um produto');
		
		$p1 = Produto::find(2);
		$p2 = clone $p1;
		$p2->descricao .= ' (Clonado)';
		//Eu alterei o código do produto
		$p2->codigo_barra = '53523453234234';
		$p2->store(); 
		
		Transaction::close();
	}catch(Exception $erro){
		Transaction::rollback();
		print 'Erro ao se conectar ao banco de dados '.$erro->getMessage();
	}