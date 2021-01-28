<?php 

use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Database\Transaction;
use Livro\Database\Repository;
use Livro\Database\Criteria;
use Livro\Database\Filter;
use Livro\Widgets\Base\Element;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Container\Card;
use Livro\Widgets\Datagrid\Datagrid;
use Livro\Widgets\Datagrid\DatagridColumn;
use Livro\Widgets\Datagrid\DatagridAction;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Dialog\Question;
use Livro\Widgets\Wrapper\DatagridWrapper;
use Livro\Widgets\Wrapper\FormWrapper;


class FuncionarioBuscaList extends Page{

	//Listagem
	private $form;
	private $datagrid;
	private $loaded;

	public function __construct(){
		parent::__construct();

		//Instancia o formulário
		$this->form = new FormWrapper(new Form('Form_busca_funcionario'));

		//
		$nome = new Entry('nome');
		$departamento = new Entry('departamento');
		$this->form->addField('Nome', $nome, 100);
		$this->form->addField('Departamento', $departamento, 100);
		$this->form->addAction('Buscar', new Action(array($this, 'onReload')));
		$this->form->addAction('Novo', new Action(array(new FuncionarioForm, 'onClear')));
		$this->form->style = 'display:block; margin:20px; max-width:500px;';

		//Instancia o Objeto Datagrid
		$this->datagrid = new DatagridWrapper(new Datagrid);
		$this->datagrid->border = 1;
		$this->datagrid->style = 'max-width:1000px';

		//Instancia as colunas da Datagrid
		$codigo     = new DatagridColumn('id',   	 'Código', 	 'center',    80);
		$nome 	    = new DatagridColumn('nome', 	 'Nome', 	 'left', 	300);
		$endereco   = new DatagridColumn('endereco', 'Endereço', 'left', 	350);
		$email 		= new DatagridColumn('email', 	 'E-mail', 	 'left', 	230);

		$codigo_order = new Action(array($this, 'onReload'));
		$codigo_order->setParameter('order', 'id'); 
		$codigo->setAction($codigo_order);

		$nome_order = new Action(array($this, 'onReload'));
		$nome_order->setParameter('order', 'nome');
		$nome->setAction($nome_order);

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



		//Monta a pagina por meio de uma caixa	
		$scroll = new Element('div');
		$scroll->class = 'table-responsive';
		$scroll->{'data-spy'}    = "scroll";
		$scroll->{'data-offset'} = 50;
		$scroll->style = ' height: 300px;';
		$scroll->add($this->datagrid);
		
		$card = new Card('Sistema para busca','bg-danger text-white','border-top-0 border border-danger ');
		$card->style = 'whidth: 400px;';
		$card->add($this->form);
		$card->add($scroll);

		parent::add($card);
	}

	public function onReload($param){
		
		Transaction::open('livro');//Inicia uma transação com o BD
		$repository = new Repository('Funcionario');

		//Cia um critério de seleção de dados
		$criteria = new Criteria(); 
		$criteria->setProperty('order', isset($param['order'])? $param['order']:'id');

		//Obtem os formulários de busca
		$dados = $this->form->getData();

		//Verifica se o usuário preencheu o formulário
		if($dados->nome){
			//Filtra pelo nome da pessoa
			$criteria->add(new Filter('nome', 'like', "%{$dados->nome}%"));
		}else if($dados->departamento){
			$criteria->add(new Filter('departamento', 'like', "%{$dados->departamento}%"));
		}

		//Carrega os produtos que satisfazem o critério
		$funcionarios = $repository->load($criteria);
		$this->datagrid->clear();

		if($funcionarios){
			foreach ($funcionarios as $funcionario) {
				//Adiciona o objeto à datagrid
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
			$this->onReload($param);//Recarrega a Datagrid
			new Message('info', 'Registro excluido com sucesso!');

		} catch (Exception $e) {
			new Message('danger', $e->getMessage());
		}

	}


	public function onEdite($param){

	}

	public function show(){
		//Sea listagem ainda não foi carregada
		if(!$this->loaded){
			$this->onReload($param='');
		}

		parent::show();
	}
}