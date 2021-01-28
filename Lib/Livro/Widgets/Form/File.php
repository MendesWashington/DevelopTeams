<?php
namespace Livro\Widgets\Form;

class File extends Field implements FormElementInterface{

    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name = $this->name;    // nome da TAG
        $this->tag->value = $this->value;  // valor da TAG
        $this->tag->type = 'file';         // tipo de input
        
        // se o campo não é editável
        if (!parent::getEditable()){
            
            // desabilita a TAG input
            $this->tag->readonly = "1";
        }
        // exibe a tag
        $this->tag->show();
    }
}
