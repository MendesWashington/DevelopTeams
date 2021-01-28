<?php 
use Livro\Control\Page;
use Livro\Widgets\Base\Image;

class ExemploImageControl extends Page{
	
	public function __construct(){
		parent::__construct();

		$img = new Image('App/Imagens/ubuntu.png');
		$img->style  = 'margin:20px;';
		$img->style .= 'width:50%;';
		parent::add($img);
	}
}