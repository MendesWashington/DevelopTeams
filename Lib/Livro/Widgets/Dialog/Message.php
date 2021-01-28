<?php 

namespace Livro\Widgets\Dialog;

use Livro\Widgets\Base\Element;

class Message extends Element{
	public function __construct($type, $message, $align = 'center'){
		
		$div = new Element('div');
		if($align != ''){
			$div->style = 'text-align: '.$align.';';	
		}
		

		if($type == 'info'){
			$div->class = 'alert alert-info';
		}
		else if($type == 'success'){
			$div->class = 'alert alert-success';
		}
		else if($type == 'danger'){
			$div->class = 'alert alert-danger';
		}
		else if($type == 'warning'){
			$div->class = 'alert alert-warning';
		}
		else{
			$div->class = 'alert alert-default';
		}
		$div->add($message);
		$div->show();
	}
}
