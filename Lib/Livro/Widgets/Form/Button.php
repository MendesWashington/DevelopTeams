<?php
namespace Livro\Widgets\Form;

use Livro\Control\Action;
use Livro\Control\ActionInterface;

class Button extends Field implements FormElementInterface{

    private $action;
    private $label;
    private $formName;
    
    /**
     * Define a ação do botão (função a ser executada)
     * @param $action = ação do botão
     * @param $label    = rótulo do botão
     */
    public function setAction(ActionInterface $action, $label){

        $this->action = $action;
        $this->label = $label;
    }
    
    /**
     * Define o nome do formulário para a ação botão
     * @param $name = nome do formulário
     */
    public function setFormName($name){

        $this->formName = $name;
    }
    
    public function show(){
        
        $url = $this->action->serialize();
        // define as propriedades do botão
        $this->tag->name    = $this->name;    // nome da TAG
        $this->tag->type    = 'button';       // tipo de input
        $this->tag->value   = $this->label;   // rótulo do botão
        //$this->tag->class = 'btn btn-dark';       
        // define a ação do botão
        $this->tag->onclick ="document.{$this->formName}.action='{$url}'; "." document.{$this->formName}.submit()";
        // exibe o botão
        $this->tag->show();
    }
}