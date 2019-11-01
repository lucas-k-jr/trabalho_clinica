<?php
	require_once("InterfaceExibicao.php");
	
	class Form implements Exibicao{
		private $method;
		private $action;
		private $name;
		private $lista_entradas = array();
		
		
		public function __construct($vetor){
			if(isset($vetor["action"])){
				$this->action=$vetor["action"];
			}
			if(isset($vetor["method"])){
				$this->method=$vetor["method"];
			}
			if(isset($vetor["name"])){
				$this->name=$vetor["name"];
			}
		}
		
		public function add_input($vetor){
			$this->lista_entradas[] = new input($vetor);
		}
		public function add_TextArea($vetor){
			$this->lista_entradas[] = new textArea($vetor);
		}
        
        public function add_Select($vetor,$matriz){
            $this->lista_entradas[] = new select($vetor,$matriz);
        }

		public function exibe(){
			echo "<form ";
			if($this->method!=null){
				echo "method='$this->method' ";
			}
			if($this->action!=null){
				echo "action='$this->action' ";
			}
			if($this->name!=null){
				echo "name='$this->name' ";
			}
			echo ">";
			
			foreach($this->lista_entradas as $i=>$e){
				echo "<div class='entrada'>";
				$e->exibe();
				echo "</div>";
			}
			
			echo "</form>";
		}
	}
?>