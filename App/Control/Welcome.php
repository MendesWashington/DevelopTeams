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

class Welcome extends Page{
	public function __construct(){
		parent::__construct();
		$card = new Card('Bem vindo!','bg-danger text-white','border-top-0 border border-danger');
        $card->add("<center><p><b>Bem vindo senhor (a) administrador.</b></p><center>");

        parent::add($card);
	}
}