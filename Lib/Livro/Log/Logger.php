<?php
namespace Livro\Database;
	abstract class Logger{
		protected $fileName;//Local do arquivo do log
		
		public function __construct($fileName){
			$this->fileName = $fileName;
			file_put_contents($fileName, '');//Limpa o conteudo do arquivo
		}
		
		abstract function write($message);//Define o metodo write como obrigatorio
	}