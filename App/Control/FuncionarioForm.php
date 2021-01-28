<?php
use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Form\Number;
use Livro\Widgets\Form\Email;
use Livro\Widgets\Form\Label;
use Livro\Widgets\Form\Combo;
use Livro\Widgets\Form\Text;
use Livro\Widgets\Form\Range;
use Livro\Widgets\Form\DateTime;
use Livro\Widgets\Form\CheckGroup;
use Livro\Widgets\Form\RadioGroup;
use Livro\Widgets\Container\Card;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Wrapper\FormWrapper;
use Livro\Database\Transaction;



class FuncionarioForm extends Page{
	
	private $form;

	public function __construct(){
		parent::__construct();

		//Instacia um formulário
		$this->form = new FormWrapper(new Form('for_funcionario'));
		$this->form->setFormTitle('Cadastro de funcinário');
		$this->form->style = 'display:block; margin:20px; max-width:500px;';

		//Criando os campos do formulário
		$id 	  	   = new Number('id');
		$nome 	  	   = new Entry('nome');
		$endereco 	   = new Entry('endereco');
		$email    	   = new Email('email');
		$departamento  = new Combo('departamento');
		$idiomas 	   = new CheckGroup('idiomas');
		$contratacao   = new RadioGroup('contratacao');
		#$range 	   = new Range('range');
		#$data		   = new DateTime('data');

		$this->form->addField('Codigo', $id, '50');
		$this->form->addField('Nome', $nome, '100%');
		$this->form->addField('Endereço', $endereco, '100%');
		$this->form->addField('E-mail', $email, '100%');
		$this->form->addField('Departamento', $departamento, '100%');
		$this->form->addField('Idiomas', $idiomas, '100%');
		$this->form->addField('Contratacao', $contratacao, '100%');
		
		/*
		 *Testando novos componetes
		 *$this->form->addField('Slide', $range, '100%');
		 *$this->form->addField('Data', $data, '100%');
		*/

		$id->setEditable(FALSE);
		$idiomas->setLayout('horizontal');
		$contratacao->setLayout('horizontal');


		//Define alguns atributos
		$departamento->addItems(array('1' => 'RH', '2' => 'Atendimento', '3' => 'Engenharia', '4' => 'Produção', '5' => 'Laboratório'));

		//Define alguns atributos
		$idiomas->addItems(array('1' => 'Inglês', '2' => 'Espanhol', '3' => 'Alemão', '4' => 'Italiano', '5' => 'Francês'));

		//Define alguns atributos
		$contratacao->addItems(array('1' => 'Estagiário', '2' => 'Pessoa Jurídica', '3' => 'CLT', '4' => 'Sócio', '5' => 'Técnico'));


		$this->form->addAction('Salvar', new Action(array($this, 'onSave')));
		$this->form->addAction('Limpar', new Action(array($this, 'onClear')));

		$card = new Card('Cadastro de funcinário','bg-danger  text-white','border-top-0 border border-danger');
		$card->add($this->form);
		//Adiciona o formulárioa pagina
		parent::add($card);
	}
	public function onSave(){
		try {

			Transaction::open('livro');
			//Obtém os dados
			$dados = $this->form->getData();

			//Valida
			if(empty($dados->nome)){
				throw new Exception("O Campo do nome está vazio");
			}else if(empty($dados->email)){
				throw new Exception("O Campo de e-mail está vazio");
			}else if(empty($dados->endereco)){
				throw new Exception("O Campo do endereço está vazio");
			}

			//Mantém o formulário preenchido
			$this->form->setData($dados);

			$funcionario = new Funcionario();
			
			$funcionario->fromArray( (array) $dados );

			$funcionario->idiomas = implode(',',(array)$dados->idiomas);
			
			$funcionario->store();

			$dados->id = $funcionario->id;

			Transaction::close();

			//Mantém o formulário preenchido com id
			$this->form->setData($dados);

			new Message('info', 'Dados salvos com sucesso!');

		} catch (Exception $e) {
			new Message('warning', '<b>Erro</b> '.$e->getMessage());
		}
	}

	public function onClear(){

	}

	public function onEdit($param){
		try {
			Transaction::open('livro');

			$id = $param['id'];
			$funcionario = Funcionario::find($id);
			if($funcionario){
				if(isset($funcionario->idiomas)){
					$funcionario->idiomas = explode(',', $funcionario->idiomas);
				}
				$this->form->setData($funcionario);
			}
			Transaction::close();
		} catch (Exception $e) {
			new Message('error','<b>Erro: </b>'.$e->getMessage());
		}
	}
}