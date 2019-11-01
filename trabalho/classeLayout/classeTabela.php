<?php
	require_once("classForm/InterfaceExibicao.php");
	
	class Tabela implements Exibicao{
		private $matriz;
		private $tabela;
		
		public function __construct($matriz,$tabela){
			$this->matriz = $matriz;
			$this->tabela = $tabela;
		}
		
		public function exibe(){
			echo "<table border='1'>";
			
			foreach($this->matriz as $i=>$v){
				if($i==0){
					echo "<thead>";
					echo "<tr>";
					foreach($v as $j=>$d){
						echo "<th>".$j."</th>";
					}
					echo "<th>Ação</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
				}
					echo "<tr>";
					foreach($v as $j=>$d){
						echo "<td>".$d."</td>";
					}
					echo "<td>
							<form method='post' action='remover.php'>
								<input type='hidden' name='tabela' value='".$this->tabela."' />
								<input type='hidden' name='id'  value='".$v["ID"]."' />
								<button>Remover</button>
							</form>
							</td>";
					echo "</tr>";
			}
			echo "</tbody>";
			
			echo "</table>";
		}
		
	}
?>