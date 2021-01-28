<?php 
	require_once'app/classes/Api/Connection.php';
	require_once'app/classes/Api/Transaction.php';
	require_once'app/classes/Api/Logger.php';
	require_once'app/classes/Api/LoggerTXT.php';
	require_once'app/classes/api/Record.php';
	require_once'app/classes/model/Produto.php';
	try{
		Transaction::open('estoque');
		Transaction::setLogger(new LoggerTXT('App/tmp/log_update.txt'));
		Transaction::log('Alterando um produto');
		
		$p1 = Produto::find(2);
		print $p1->estoque.'<br>';
		$p1->estoque += 10;
		print $p1->estoque.'<br>';
		$p1->data_cadastro = date('Y-m-d H:i:s');
		$p1->store();

		Transaction::close();
	}catch(Exception $erro){
		Transaction::rollback();
		print 'Erro ao se conectar com o banco de dados '.$erro->getMessage();
	}