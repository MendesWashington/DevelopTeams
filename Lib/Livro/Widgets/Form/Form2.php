<?php
namespace Livro\Widgets\Form;

use Livro\Widgets\Base\Element;
use Livro\Widgets\Container\HBox;
use Livro\Widgets\Container\Table;
use Livro\Control\ActionInterface;


class Form extends Element{

	protected $fields;
	protected $actions;
	protected $table;
	private   $has_action;
	private   $actions_container;

	public function __construct($name = 'my_form'){
		parent::__construct('form');

		$this->enctype = "multipart/form-data";
		$this->method  = "post"; //método de transferência
		$this->setName($name);

		$this->table = new Table;
		$this->table->width = '100%';
		parent::add($this->table);
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setFormTitle($title){
		
		$row = $this->table->addRow();
		$this->{'class'} = 'form-title';
		$cell = $row->addCell($title);
		$cell->{'colspan'} = 2;
	}

	public function addField($label, FormElementInterface $object, $size = 200 ){
		$object->setSize($size, $size);
		$this->fields[$object->getName()] = $object;
		$object->setLabel($label);

		$row = $this->table->addRow();
		$label_field = new Label($label);

		if($object instanceof Hidden){
			$row->addCell('');
		}else{
			$row->addCell($label_field);
		}
		$row->addCell($object);
		return $row;
	}

	public function addAction($label, ActionInterface $action){
		$name   = strtolower(str_replace(' ', '_', $label));

		$button = new Button($name);
		//$button->class = 'bg-primary';
		$button->setFormName($this->nama);
		$button->setAction($action, $label);
		if(!$this->has_action){
			$this->actions_container = new HBox;

			$row = $this->table->addRow();
			$row->{'class'} = 'formaction';
			$cell = $row->addCell($this->actions_container);
			$cell->colspan = 2;
		}

		$this->actions_container->add($button);

		$this->has_action = TRUE;
		$this->actions[] = $button;
		return $button;
	}

	public function getFields(){
		return $this->fields;
	}

	public function getActions(){
		return $this->actions;
	}

	public function setData($object){
		foreach ($this->fields as $name => $field) {
			if ($name AND isset($object->$name)) {
				$field->setValue($object->$name);
			}
		}
	}

	public function getData($class = 'stdClass'){
		
		$object = new $class;

		foreach ($this->fields as $key => $fieldObject) {
			$var = isset($_POST[$key]) ? $_POST[$key] : '';
			if(!$fieldObject instanceof Button){
				$object->key = $val;
			}
		}

		foreach ($_FILES as $key => $content) {
			$object->key = $content['tmp_name'];
		}
		return $object;
	}
}