<?php
require_once("interfaceExibicao.php");
class Select implements Exibicao{
	private $name;
	private $lista_option;
	private $label;
	private $select;
	
	public function __construct($vetor,$matriz){
		$this->name=$vetor["name"];
		$this->select=$vetor["select"];
		if(isset($vetor["label"])){
			$this->label=$vetor["label"];
		}
		else{
			$this->label = $vetor["name"];
		}
		foreach($matriz as $i=>$vetor){
			$this->lista_option[] = new Option($vetor,$this->select);
		}
	}
	
	public function exibe(){
		
		echo "<select name='$this->name'>
			  <option>::selecione $this->label::</option>";
		
		foreach($this->lista_option as $o){
			$o->exibe();
		}
			  
		echo "</select>";
	}
}
?>