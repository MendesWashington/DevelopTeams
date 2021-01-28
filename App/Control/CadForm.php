<?php 
use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Form\Email;
use Livro\Widgets\Form\Password;
use Livro\Widgets\Form\Button;
use Livro\Widgets\Wrapper\DatagridWrapper;
use Livro\Widgets\Wrapper\FormWrapper;
use Livro\Widgets\Container\Panel;
use Livro\Widgets\Container\Card;

class CadForm extends Page{
	public function __construct(){
		parent::__construct();
		
		 // instancia um formulário
        $this->form = new FormWrapper(new Form('form_cadastro'));
        
        $nome        = new Entry('nome');
        $email       = new Email('email');
        $password1   = new Password('password1');
        $password2   = new Password('password2');
        
        $nome->placeholder      = 'Digite seu nome';
        $email->placeholder     = 'Digite seu e-mail';
        $password1->placeholder = '*****';
        $password2->placeholder = '*****';
        
        $this->form->addField('Nome', $nome,'100%');
        $this->form->addField('Email', $email,'100%');
        $this->form->addField('Senha', $password1,'100%');
        $this->form->addField('Confirmar Senha', $password2,'100%');
        $this->form->addAction('Cadastrar', new Action(array($this, 'onCadastro')));
        
        $card = new Card('Cadastro do Sistema','bg-danger','border-top-0 border border-danger');
        $card->add($this->form);
        
        // adiciona o formulário na página
        parent::add($card);
    }

    public function onCadastro ($param){
    	$data = $this->form->getData();
    	echo "<pre>";
    		var_dump($data);
    	echo "</pre>";
    }
}
