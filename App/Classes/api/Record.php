<?php
	class Record{
		protected $data; //Array contendo os dados do objeto

		public function __construct($id = NULL){
			if($id){//Se o id for informado
				$object = $this->load($id);//Carrega o objeto correspondente
				if($object){
					$this->fromArray($object->toArray());
				}
			}
		}
		public function __clone(){
			unset($this->data['id']);
		}
		public function __set($prop, $value){
			if(method_exists($this, '__set'.$prop)){
				//Execulta o método set_<propriedade>
				call_user_func(array($this,'__set'.$prop),$value);
			}else{
				if($value === NULL){
					unset($this->data[$prop]);
				}else{
					$this->data[$prop] = $value;//Atribue o valor da propriedade
				}
			}
		}
		public function __get($prop){
			if(method_exists($this,'__get'.$prop)){
				//Execulta o método get_<propriedade>
				call_user_func(array($this,'__get'.$prop),$value);
			}else{
				if(isset($this->data[$prop])){
					return $this->data[$prop];
				}
			}
		}
		public function __isset($prop){
			return isset($this->data[$prop]);
		}
		private function getEntity(){
			$class = get_class($this);//Obtem o nome da classe
			//Retorna a constante de classe TABLENAME
			return constant("{$class}::TABLENAME");
		}
		public function fromArray($data){
			$this->data = $data;
		}
		public function toArray(){
			return $this->data;
		}

		public function store(){
			$prepared = $this->prepare($this->data);

			//Verifica se tem ID ou se existe na base de dados
			if(empty($this->data['id']) or (!$this->load($this->id))){
				//Incremente o ID
				if(empty($this->data['id'])){
					$this->id = $this->getLast()+1;
					$prepared['id'] = $this->id;
				}
				//Cria uma instrução de insert
				$sql = "INSERT INTO {$this->getEntity()} ".
				'('.implode(', ', array_keys($prepared)) . ')'.
				' VALUES '.
				'('.implode(', ',array_values($prepared)).')';
			}else{
				//Mostra a String de UPDATE
				$sql = "UPDATE {$this->getEntity()} ";
				//Monta os pares: coluna = valor,...
				if($prepared){
					foreach ($prepared as $column => $value) {
						if($column !== 'id'){
							$set[] = "{$column} = {$value}";
						}
					}
				}
				$sql .= ' SET '.implode(', ', $set);
				$sql .= ' WHERE id = '.(int) $this->data['id'];
			}
			//Obtém a transação ativa
			if($conn = Transaction::get()){
				print "$sql <br>\n";
				Transaction::log($sql);
				$result = $conn->exec($sql);
				return $result;
			}else{
				throw new Exception('Não há transação ativa!!');
				
			}
		}
		public function load($id){
			//Monta a instrução de SELECT
			$sql  = "SELECT * FROM {$this->getEntity()} ";
			$sql .= ' WHERE id='.(int) $id;
			//Obtém  as trasações ativa
			if($conn = Transaction::get()){
				//Cria a mensagem de log e execulta a consulta
				Transaction::log($sql);
				$result = $conn->query($sql);
				//Se retornou algum dado
				if($result){
					//Retorna os dados em forma de objeto
					$object = $result->fetchObject(get_class($this));
				}
				return $object;
			}else{
				throw new Exception('Não há transação ativa!!');
				
			}

		}
		public function delete($id = NULL){
			//O id é o parâmetro ou a propriedade id
			$id = $id ? $id : $this->id;

			//Mostra a String de UPDATE
			$sql  = "DELETE FROM {$this->getEntity()} ";
			$sql .= 'WHERE id'.(int) $this->data['id'];

			//Obtém a transação ativa
			if($conn = Transaction::get()){
				//Faz o log e execulta o sql
				Transaction::log($sql);
				$result = $conn->exec($sql);
				return $result;//Retorna o resultado
			}else{
				throw new Exception('Não há transação ativa!');
			}
		}
		public static function find($id){
			$calassName = get_called_class();
			$ar = new $calassName;
			return $ar->load($id);
		}
		private function getLast(){
			if($conn = Transaction::get()){
				$sql = "SELECT max(id) FROM {$this->getEntity()} ";

				//Cria log e execulta uma instrução sql
				Transaction::log($sql);
				$result = $conn->query($sql);

				//Retornaos dados do banco
				$row = $result->fetch();
				return $row[0];
			}else{
				throw new Exception('Não há transação ativa!');
			}
		}
		public function prepare($data){
			$prepared = array();
			foreach ($data as $key => $value) {
				if(is_scalar($value)){
					$prepared[$key] = $this->escape($value);
				}
			}
			return $prepared;
		}
		public function escape($value){
			if(is_string($value) and (!empty($value))){
				//Adiciona \ em aspas
				$value = addslashes($value);
				return "'$value'";
			}else if(is_bool($value)){
				return $value ? 'TRUE':'FALSE';
			}else if($value !== ''){
				return $value;
			}else{
				return "NULL";
			}
		}

	}