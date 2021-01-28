<?php

use Livro\Control\Page;
use Livro\Widgets\Container\Table;

class ExemploTableControl extends Page{
	public function __construct(){
		parent::__construct();

		//Constrói a matriz com os dados
		$dados[] = array(1, 'Washington dos Santos', 'http://www.Washington.com.br', 1200);
		$dados[] = array(2, 'Roanldo Nevez', 'http://www.Ronaldo.com.br',  800);
		$dados[] = array(3, 'Rafael Brito', 'http://www.Rafael.com.br', 1500);
		$dados[] = array(3, 'Felix Manguiado', 'http://www.Felix.com.br',  700);
		$dados[] = array(3, 'Isaias Namorador', 'http://www.Isaias.com.br', 2500);

		//Instancia objeto tabela e define algumas propriedades
		$table = new Table();
		$table->width = 600;
		$table->style = 'margin: 20pt;';

		//Instancia uma linha para o cabeçalho
		$cabecalho = $table->addRow();
		$cabecalho->style = 'background-color: #a0a0a0;';

		//Adiciona células de cabeçalho
		$cabecalho->addCell('Código');
		$cabecalho->addCell('Nome');
		$cabecalho->addCell('Site');
		$cabecalho->addCell('Salário');

		$i = 0;
		$total = 0;

		foreach ($dados as $dado) {
			//Verifica qual cor deve utilizar para o background
			$bgcolor =  ($i%2) == 0 ? '#d0d0d0' : '#ffffff';

			//Adiciona uma linha para os dados
			$linha = $table->addRow();
			$linha->style = "background-color:$bgcolor";

			//Adiciona as células
			$linha->addCell($dado[0]);
			$linha->addCell($dado[1]);
			$linha->addCell($dado[2]);

			$x = $linha->addCell($dado[3]);
			$x->align = 'right';
			$total += $dado[3];

			$i++;
		}

		//Instancia a linha para o totalizador
		$linha = $table->addRow();

		//Adiciona célula
		$celula = $linha->addCell('Total');
		$celula->style   = "backgrounf:whiteSmoke";
		$celula->colspan = 3;

		$celula = $linha->addCell($total);
		$celula->style = 'background-color: #FFF08C; text-align:right;';

		//Exibir tabela
		$table->show();
	}
}