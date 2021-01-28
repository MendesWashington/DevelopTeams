<?php
use Livro\Control\Page;
use Livro\Widgets\Datagrid\Datagrid;
use Livro\Widgets\Datagrid\DatagridColumn;
use Livro\Widgets\Datagrid\DatagridAction;
use Livro\Widgets\Dialog\Message;

class ControlActionList extends Page{

	//Listagem
	private $datagrid;

	public function __construct(){
		parent::__construct();

		//Instancia o Objeto Datagrid
		$this->datagrid = new Datagrid();
		$this->datagrid->border = 1;

		//Instancia as colunas da Datagrid
		$codigo  = new DatagridColumn('id', 'Código', 'center', 80);
		$nome 	 = new DatagridColumn('nome', 'Nome', 'left', 200);
		$email   = new DatagridColumn('email', 'E-mail', 'left', 150);
		$assunto = new DatagridColumn('assunto', 'Assunto', 'left', 230);

		//Adiciona as colunas a Datagrid
		$this->datagrid->addColumn($codigo);
		$this->datagrid->addColumn($nome);
		$this->datagrid->addColumn($email);
		$this->datagrid->addColumn($assunto);

		$nome->setTransformer(array($this, 'converteParaMaiuscula'));
		

		//Instancia duas ações da Datagrid
		$action1 = new DatagridAction(array($this, 'onVisualiza'));
		$action1->setLabel('Visualizar');
		$action1->setImage('lupa2.png');
		$action1->setField('nome');

		$this->datagrid->addAction($action1);

		//Cria o modele de Datagrid, montando sua estrutura
		$this->datagrid->createModel();

		//Adiciona a Datagrid a pagina
		parent::add($this->datagrid);
	}

	public function converteParaMaiuscula($value){
		return strtoupper($value);
	}

	public function onVisualiza($param){
		new Message('info','Você clicou sobre o registro: '.$param['nome']);
	}

	function onReload(){
		$this->datagrid->clear();

		$m1 		 = new stdClass;
		$m1->id 	 = 1;
		$m1->nome 	 = 'Wahington Mendes dos Santos';
		$m1->email   = 'washington@gmail.com';
		$m1->assunto = 'Testando classe Datagrid';
		$this->datagrid->addItem($m1);

		$m2 		 = new stdClass;
		$m2->id 	 = 2;
		$m2->nome 	 = 'Alexandre Mangabeira';
		$m2->email   = 'alexandre@gmail.com';
		$m2->assunto = 'Testando classe Datagrid';
		$this->datagrid->addItem($m2);

		$m3 		 = new stdClass;
		$m3->id 	 = 3;
		$m3->nome 	 = 'Maria da Silva';
		$m3->email   = 'maria@gmail.com';
		$m3->assunto = 'Testando classe Datagrid';
		$this->datagrid->addItem($m3);

		$m4 		 = new stdClass;
		$m4->id 	 = 4;
		$m4->nome 	 = 'Predro Cardoso';
		$m4->email   = 'pedro@gmail.com';
		$m4->assunto = 'Testando classe Datagrid';
		$this->datagrid->addItem($m4);

		$m5 		 = new stdClass;
		$m5->id 	 = 5;
		$m5->nome 	 = 'João Periera';
		$m5->email   = 'joao@gmail.com';
		$m5->assunto = 'Testando classe Datagrid';
		$this->datagrid->addItem($m5);
	}

	function show(){
		$this->onReload();
		parent::show();
	}
}