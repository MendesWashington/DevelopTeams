<?php
	final class Transaction{
		private static $conn;//Conexão ativa
		private static $logger;//Objeto de logger

		private function __construct(){}
		
		public static function open($database){
			if(empty(self::$conn)){
				self::$conn = Connection::open($database);
				self::$conn->beginTransaction();//Inicia a transação
				self::$logger = NULL;//Desliga o logger de sql
			}
		}
		
		public static function get(){
			return self::$conn;//Retorna a conexão ativa
		}
		
		public static function rollback(){
			if(self::$conn){
				self::$conn->rollback();//Desfaz as operações realizadas
				self::$conn = NULL;
			}
		}
		
		public static function close(){
			if(self::$conn){
				self::$conn->commit();//Aplica as operaçõesrelaizadas
				$conn = NULL;
			}
		}

		public static function setLogger(Logger $logger){
			self::$logger = $logger;
		}

		public static function log($message){
			if(self::$logger){
				self::$logger->write($message);
			}
		}
	}