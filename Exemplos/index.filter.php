<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		require_once'app/classes/Api/Expression.php';
		require_once'app/classes/Api/Filter.php';
		
		//Criar filtro por data
		$filter1 = new Filter('Data','=','2017-16-02');
		print $filter1->dump()."<br>\n";
		//Criar filtro por salário (integer)
		$filter2 = new Filter('Salário','>','3000');
		print $filter2->dump()."<br>\n";
		//Criar um filtro por genero (array)
		$filter3 = new Filter('Genero','IN',array('M','F'));
		print $filter3->dump()."<br>\n";
		//Criar filtro por contato (NULL)
		$filter4 = new Filter('Contatos','IS NOT',NULL);
		print $filter4->dump()."<br>\n";
		//Crriar filtro por ativo (boolean)
		$filter5 = new Filter('Ativo','=',TRUE);
		print $filter5->dump()."<br>\n";

	 ?>
</body>
</html>