<?php
use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Form\Form;
use Livro\Widgets\Form\Entry;
use Livro\Widgets\Form\Password;
use Livro\Widgets\Form\Button;
use Livro\Widgets\Wrapper\DatagridWrapper;
use Livro\Widgets\Wrapper\FormWrapper;
use Livro\Widgets\Container\Panel;
use Livro\Widgets\Container\Card;
use Livro\Widgets\Dialog\Message;

use Livro\Session\Session;

/**
 * Formulário de Login
 */
class LoginForm extends Page
{
    private $form; // formulário
    
    /**
     * Construtor da página
     */
    public function __construct()
    {
        parent::__construct();

        // instancia um formulário
        $this->form = new FormWrapper(new Form('form_login'));
        
        $login      = new Entry('login');
        $password   = new Password('password');
        
        $login->placeholder    = 'admin';
        $password->placeholder = '*****';
        
        $this->form->addField('Login',    $login,    '100%');
        $this->form->addField('Senha',    $password, '100%');
        $this->form->addAction('Logar', new Action(array($this, 'onLogin')));
        
        $card = new Card('Login do Sistema','bg-danger text-white','border-top-0 border border-danger');
        $card->add($this->form);
        
        // adiciona o formulário na página
        parent::add($card);
    }
    
    /**
     * Login
     */
    public function onLogin($param)
    {
        $data = $this->form->getData();
        
        if($data->login == ''){

            new Message('danger', "Preencha todos os campus, Login está vazio");


        }else if($data->password == ''){
             $this->form->setData($data);
            new Message('danger', "Preencha todos os campus, Password está vazio");
        
        }else{

            if ($data->login == 'admin' AND $data->password == 'admin')
            {
                Session::setValue('logged', TRUE);
                echo "<script language='JavaScript'> window.location = 'index.php?class=Welcome'; </script>";
            
            }else{
                 $this->form->setData($data);
                new Message('warning',"Usuário não encontado!");
            }

        }

    }
    
    /**
     * Logout
     */
    public function onLogout($param)
    {
        Session::setValue('logged', FALSE);
        echo "<script language='JavaScript'> window.location = 'index.php'; </script>";
    }
}