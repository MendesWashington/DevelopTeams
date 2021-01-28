<?php 

use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Datagrid\Datagrid;
use Livro\Widgets\Datagrid\DatagridColumn;
use Livro\Widgets\Datagrid\DatagridAction;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Dialog\Question;
use Livro\Database\Transaction;
use Livro\Database\Repository;
use Livro\Database\Criteria;
use Livro\Widgets\Wrapper\DatagridWrapper;
use Livro\Widgets\Base\Element;

class FuncionarioList extends Page{

	//Listagem
	private $datagrid;
	private $loaded;

	public function __construct(){
		parent::__construct();

		//Instancia o Objeto Datagrid
		$this->datagrid = new DatagridWrapper(new Datagrid());
		$this->datagrid->border = 1;
		$this->datagrid->style = 'max-width:1000px';

		//Instancia as colunas da Datagrid
		$codigo     = new DatagridColumn('id',   	 'Código', 	 'center',   80);
		$nome 	    = new DatagridColumn('nome', 	 'Nome', 	 'left', 	300);
		$endereco   = new DatagridColumn('endereco', 'Endereço', 'left', 	250);
		$email 		= new DatagridColumn('email', 	 'E-mail', 	 'left', 	200);

		//Adiciona as colunas à Datagrid
		$this->datagrid->addColumn($codigo);
		$this->datagrid->addColumn($nome);
		$this->datagrid->addColumn($endereco);
		$this->datagrid->addColumn($email);

		//Instancia duas ações da Datagrid
		$action1 = new DatagridAction(array( new FuncionarioForm, 'onEdit'));
		$action1->setLabel('Editar');
		$action1->setImage('ico_edit.png');
		$action1->setField('id');

		$action2 = new DatagridAction(array($this, 'onDelete'));
		$action2->setLabel('Deletar');
		$action2->setImage('ico_delete.png');
		$action2->setField('id');

		//Adiciona as ações a Datagrid
		$this->datagrid->addAction($action1);
		$this->datagrid->addAction($action2);

		//Cria o modelo da Datagride, montando sua estrutura
		$this->datagrid->createModel();
		
		$div = new ELement('div');
		$div->class = 'table-responsive';
		$div->add($this->datagrid);
		parent::add($div);

	}

	public function onReload(){
		
		//Inicia a transação com o banco de dados
		Transaction::open('livro');
		$repository = new Repository('Funcionario');

		//Cia um critério de seleção de dados
		$criteria = new Criteria();
		$criteria->setProperty('order', 'id');

		//Carregam os produtos que sasifazem os criterios
		$funcionarios = $repository->load($criteria);
		$this->datagrid->clear();

		if($funcionarios){
			foreach ($funcionarios as $funcionario) {
				//Adiciona o objeto a Datagrid
				$this->datagrid->addItem($funcionario);
			}
		}

		//Finaliza a transação
		Transaction::close();
		$this->loaded = true;
	}

	public function onDelete($param){
		
		//Obtem o parametro id
		$id = $param['id'];
		$action1 = new Action(array($this, 'Delete'));
		$action1->setParameter('id',$id);
		new Question('Deseja realmente excluir o registro<br>', $action1);
	}

	public function Delete($param){
		try {
			//Obtem o parametro id
			$id = $param['id'];
			Transaction::open('livro');//Inicia a trazação com o banco de dados
			$funcionario = Funcionario::find($id);//Busca objeto funcionário
			
			if($funcionario){
				$funcionario->delete();//Deleta objeto do banco de dados
			}
			Transaction::close();//Finaliza a tranzação		
			$this->onReload();//Recarrega a Datagrid
			new Message('info', 'Registro excluido com sucesso!');

		} catch (Exception $e) {
			//new Message('danger', $e->getMessage());
		}

	}


	public function onEdite($param){

	}

	public function show(){
		//Sea listagem ainda não foi carregada
		if(!$this->loaded){
			$this->onReload();	
		}

		parent::show();
	}
}