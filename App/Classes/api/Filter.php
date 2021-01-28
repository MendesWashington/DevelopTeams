<?php 
	class Filter extends Expression{
		private $variable;//Variavel
		private $operator;//Operador
		private $value;//Valor

		public function __construct($variable,$operator,$value){
			//Armazena as propriedades
			$this->variable = $variable;
			$this->operator = $operator;

			//Transfoma o valorde acordo com certas regras de tipo
			$this->value = $this->transform($value);
		}

		private function transform($value){
			//Caso sejá uma array
			if(is_array($value)){
				foreach($value as $x){
					if(is_integer($x)){
						$foo[] = $x;
					}else if(is_string($x)){
						$foo[] = "'$x'";
					}
				}
				//Converte o array emstring separado por " , "
				$result = '('.implode(',', $foo).')';
			}else if(is_string($value)){
				$result = "'$value'";
			}else if(is_null($value)){
				$result = 'NULL';
			}else if(is_bool($value)){
				$result = $value ? 'TRUE' :'FALSE';
			}else{
				$result = $value;
			}
			//Retornao valor
			return $result;
		}
		public function dump(){
			//Concatena a expressão
			return "{$this->variable} {$this->operator} {$this->value}";
		}
	}