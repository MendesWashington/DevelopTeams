<?php
namespace Livro\Database;
	class LoggerXML extends Logger{
		
		public function write($message){
			
			date_default_timezone_set('America/Sao_Paulo');
			
			$time = date('Y-m-d H:i:s');
			$text  = "<log>\n";
			$text .= "<time>$time</time>";
			$text .= "<message>$message</message>";
			$text .= "</log>\n";
			
			//Adiciona ao final do arquivo
			$handler = fopen($this->fileName, 'a');
			
			fwrite($handler, $text);
			
			fclose($handler);
		}
	}