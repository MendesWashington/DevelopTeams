<?php 
	require_once'app/classes/Api/Connection.php';
	require_once'app/classes/Api/Transaction.php';
	require_once'app/classes/Api/Logger.php';
	require_once'app/classes/Api/LoggerTXT.php';
	require_once'app/classes/api/Record.php';
	require_once'app/classes/model/Produto.php';

	try {
		if($_Request['Buscar']){
		$artisra =isset($_Request['artista']);
		$album =isset($_Request['album']);
		$gravadora =isset($_Request['gravadora']);
		$sql ="";
		}
	} catch (Exception $e) {
		throw new Exception("Erro ao acessar a pagina ");
	}
				