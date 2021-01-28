<?php 
	require_once'App/Classes/api/Connection.php';
	require_once'App/Classes/api/Transaction.php';
	require_once'App/Classes/api/Logger.php';
	require_once'App/Classes/api/LoggerTXT.php';
	require_once'App/Classes/api/Record.php';
	require_once'App/Classes/model/Produto.php';
	//require_once'App/Classes';

	try{
		Transaction::open('estoque');
		Transaction::setLogger(new LoggerTXT('App/tmp/log_find.txt'));
		Transaction::log('Buscando um produto');
		$p1 = Produto::find(4);
		print('Descrição '.$p1->descricao.'<br>');
		Transaction::close();
	}catch(Exception $e){
		Transaction::rollback();
		print 'Erro na conexão com banco de dados: '.$e->getMessage();
	}