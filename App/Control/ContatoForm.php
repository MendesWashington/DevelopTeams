<?php
use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Form\Email;
use Livro\Widgets\Form\Label;
use Livro\Widgets\Form\Combo;
use Livro\Widgets\Form\Text;
use Livro\Widgets\Container\Card;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Wrapper\FormWrapper;

class ContatoForm extends Page{
	
	private $form;

	public function __construct(){
		parent::__construct();

		//Instacia um formulário
		$this->form = new FormWrapper(new Form('for_contato'));
		$this->form->setFormTitle('Formulário para Contato');
		$this->form->style = 'display:block; margin:20px;';

		//Criando os campos do formulário
		$nome 	  = new Entry('nome');
		$email    = new Email('email');
		$assunto  = new Combo('assunto');
		$mensagem = new Text('mensagem');

		$this->form->addField('Nome', $nome, '100%');
		$this->form->addField('E-mail', $email, '100%');
		$this->form->addField('Assunto', $assunto, '100%');
		$this->form->addField('Mensagem', $mensagem, '100%');

		//Define alguns atributos
		$assunto->addItems(array('1' => 'Sugestão', '2' => 'Reclamação', '3' => 'Suporte técnico', '4' => 'Cobrança', '5' => 'outros'));

		//Valor pré-definido
		//$assunto->setValue(2);

		$mensagem->setSize(300,80);

		$this->form->addAction('Enviar', new Action(array($this, 'onSend')));

		$card = new Card('Formulário para Contato', 'bg-danger text-white', 'border-top-0 border border-danger');
		$card->add($this->form);
		//Adiciona o formulárioa pagina
		parent::add($card);
	}
	public function onSend(){
		try {
			
			//Obtém os dados
			$dados = $this->form->getData();

			//Mantém o formulário preenchido
			$this->form->setData($dados);

			//Valida
			if(empty($dados->nome)){
				throw new Exception("O Campo nome está vazio");
			}else if(empty($dados->email)){
				throw new Exception("O Campo e-mail está vazio");
			}else if(empty($dados->assunto)){
				throw new Exception("O Campo assunto está vazio");
			}

			//Monta a mensagem
			$mensagem  = "Nome: {$dados->nome}<br>";
			$mensagem .= "E-mail: {$dados->email}<br>";
			$mensagem .= "Assunto: {$dados->assunto}<br>";
			$mensagem .= "Mensagem {$dados->mensagem}<br>";

			new Message('info',$mensagem, 'left');

		} catch (Exception $e) {
			new Message('warning', '<b>Erro</b> '.$e->getMessage());
		}
	}
}