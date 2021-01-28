<?php
namespace Livro\Widgets\Form;

use Livro\Widgets\Base\Element;

abstract class Field implements FormElementInterface
{
    protected $name;
    protected $size;
    protected $value;
    protected $editable;
    protected $tag;
    protected $formLabel;

    public function __construct($name)
    {
        // define algumas características iniciais
        self::setEditable(true);
        self::setName($name);
        self::setSize(200);
        
        // cria uma tag HTML do tipo <input>
        $this->tag = new Element('input');
        $this->tag->class = 'field';		  // classe CSS
    }
    

    public function __set($name, $value)
    {
        // Somente valores escalares
        if (is_scalar($value))
        {              
            // Armazena o valor da propriedade
            $this->setProperty($name, $value);
        }
    }
    
    public function __get($name)
    {
        return $this->getProperty($name);
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setLabel($label)
    {
        $this->formLabel = $label;
    }
    
    public function getLabel()
    {
        return $this->formLabel;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setEditable($editable)
    {
        $this->editable= $editable;
    }
    
    public function getEditable()
    {
        return $this->editable;
    }
    
    public function setProperty($name, $value)
    {
        // define uma propriedade de $this->tag
        $this->tag->$name = $value;
    }
    
    public function getProperty($name)
    {
        return $this->tag->$name;
    }
    
    public function setSize($width, $height = NULL)
    {
        $this->size = $width;
    }
}
