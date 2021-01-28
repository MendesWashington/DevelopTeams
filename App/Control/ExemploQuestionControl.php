<?php

use Livro\Control\Page;
use Livro\Control\Action;
use Livro\Widgets\Dialog\Message;
use Livro\Widgets\Dialog\Question;


class ExemploQuestionControl extends Page{
	public function __construct(){
		parent::__construct();

		$action1 = new Action(array($this, 'onConfirmacao'));
		$action2 = new Action(array($this, 'onNegacao'));

		new Question('Você deseja confirmar a ação?', $action1, $action2);
	}

	public function onConfirmacao(){
		new Message('info', 'Você escolheu confirmar a questão');
	}

	public function onNegacao(){
		new Message('danger', 'Você escolheu negar a questão.');
	}
}