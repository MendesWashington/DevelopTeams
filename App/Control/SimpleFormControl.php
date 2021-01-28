<?php

use Livro\Control\Page;
use Livro\Widgets\Form\SimpleForm;

class SimpleFormControl extends Page{
	public function __construct(){
		parent::__construct();

		$form = new SimpleForm('my_form');
		$form->setTitle('Form Junior');
		$form->addField('Nome', 'name', 'text', 'Maria', 'form-control');
		$form->addField('Sobre nome', 'sobre', 'text', 'Mendes', 'form-control');
		$form->addField('CPF', 'cpf', 'text', '859.578.405-13','form-control');
		$form->addField('Endereço', 'endereco', 'text', 'Rua das Flores','form-control');
		$form->addField('Telefone', 'fone', 'text', '(71)98822-1520','form-control');
		$form->addField('Nível de programador', 'nivel', 'text', '100%','form-control');
		$form->setAction('index.php?class=SimpleFormControl&method=onGravar');
		$form->show();
	}
	public function onGravar(){
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>\n";
	}
}