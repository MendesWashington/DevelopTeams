<?php 
	class Criteria Extends Expression{

		private $expressions; //Armazena a lista de expreções
		private $operattors; //Armazana a lista de operações
		private $properties; //Propriedade do critério

		function __construct(){
			$this->expressions = array();
			$this->operators = array();
		}
		public function add(Expression $expression, $operator = self::AND_OPERATOR){
			//Na primeira vez, não precisa concatenar
			if(empty($this->expressions)){
				$operator = NULL;
			}
			//Agrega o resultado da expressão.A listade expressões
			$this->expressions[] = $expression;
			$this->operators[] = $operator;

		}
		public function dump(){
			//Concatena a lista de expressões
			if(is_array($this->expressions)){
				if(count($this->expressions) > 0){
					$result = '';
					foreach ($this->expressions as $i => $expression) {
						$operator = $this->operators[$i];
						//Concatena os operadores com as respectivas expressões
						$result .= $operator.' '.$expression->dump() . ' ';
					}
					$result = trim($result);
					return "({$result})";
				}
			}
		}
		public function setProperty($property, $value){
			if (isset($value)) {
				$this->properties[$property] = $value;
			} else {
				$properties[$property] = NULL;
			}

		}
		public function getProperty($property){
			if(isset($this->properties[$property])){
				return $this->properties[$property];
			}
		}
	}