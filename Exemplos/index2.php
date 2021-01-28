<?php
	require_once'app/classes/Api/Connection.php';
	require_once'app/classes/Api/Transaction.php';
	require_once'app/classes/Api/Logger.php';
	require_once'app/classes/Api/LoggerTXT.php';
	require_once'app/classes/api/Record.php';
	require_once'app/classes/model/Produto.php';
	try{
		Transaction::open('estoque');
		Transaction::setLogger(new LoggerTXT('App/tmp/log.txt'));
		Transaction::log('Inserindo produto novo');
		
		$p1 = new Produto;
		$p1->descricao 	   = 'Pendriver 512Mb';
		$p1->estoque  	   =  10.0; 
		$p1->preco_custo   =  20.0;
		$p1->preco_venda   =  40.0;
		$p1->codigo_barra  = '0000000001'; 
		$p1->data_cadastro = date('Y-m-d');
		$p1->origem		   = 'N';
		$p1->store();

		$p2 = new Produto;
		$p2->descricao 	   = 'HD 120 GB';
		$p2->estoque  	   =  20.0; 
		$p2->preco_custo   =  100.0;
		$p2->preco_venda   =  180.0;
		$p2->codigo_barra  = '0000000002'; 
		$p2->data_cadastro = date('Y-m-d');
		$p2->origem		   = 'N';
		$p2->store();
	
		Transaction::close();
	}catch(Exception $erro){
		Transaction::rollback();
		print "Erro na database ".$erro->getMessage();
	}