<?php
	include("classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");

	require_once("classeLayout/classForm/interfaceExibicao.php");
	require_once("classeLayout/classForm/classeInput.php");
	require_once("classeLayout/classForm/classeSelect.php");
	require_once("classeLayout/classForm/classeOption.php");
	require_once("classeLayout/classForm/classeButton.php");
	require_once("classeLayout/classForm/classeForm.php");
	include("conexao.php");
	
	if(isset($_POST["id"])){
		require_once("classeControllerBD.php");
		$c = new ControllerBD($conexao);
		$colunas = array("*");
		$tabelas[0][0] = "agendamento_consulta";
		$tabelas[0][1] = null;
		$ordenacao = null;
		$condicao = null;
		$condicao = $_POST["id"];
		$stmt = $c->seleionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_resultado = $linha["ID_CONSULTA"];
		$value_id_resultado = $linha["DATE"];
		$value_id_resultado = $linha["HORA"];
		$value_id_resultado = $linha["DESCRICAO"];
		$value_id_resultado = $linha["EMERGENCIA"];
		$value_id_resultado = $linha["CPF"];


		$action = "altera.php?tabela=agendamento_consulta";
	}
	else{
		$value_id_consulta = null;
		$value_date = null;
		$value_hora = null;
		$value_descricao = null;
		$value_emergencia = null;
		$value_cpf = null;
		$action = "insere.php?tabela=agendamento_consulta";
	}

	//seleção dos valores que irão criar o <select> de FUNCAO//////
	$select = "SELECT CPF AS value, NOME_CLIENTE AS texto FROM cliente ORDER BY NOME_CLIENTE";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_cliente[] = $linha;
	}	
	////////////////////////////////////////////////////
	
	$v = array("action"=>"insere.php?tabela=agendamento_consulta","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"date","name"=>"DATA_AGENDAMENTO","placeholder"=>"DATA MARCADA...");
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"HORA_MARCADA","placeholder"=>"HORA MARCADA...");
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"DESCRICAO","placeholder"=>"DESCRIÇÃO...");
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"EMERGENCIA","placeholder"=>"EMERGENCIAL...");
	$f->add_input($v);

	$v = array("name"=>"CPF","select"=>$value_cpf);

	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir Agendamento de Consultas</h3>
<hr />
<?php
	$f->exibe();
?>
<script>
$(function(){
	$("button").click(function(){
		$.ajax({
			url: "insere.php?tabela=agendamento_consulta",
			type: "post",
			data: {
				EMERGENCIA: $("input[name='DATA_AGENDAMENTO']").val(),
				EMERGENCIA: $("input[name='HORA_MARCADA']").val(),
				EMERGENCIA: $("input[name='DESCRICAO']").val(),
				EMERGENCIA: $("input[name='EMERGENCIA']").val(),
				DATA_HORA: $("input[name='NOME_CLIENTE']").val()	
			},
			beforerSend:function(){
				$("button").attr("disabled",true);
			}
			sucess: function(d){
				$("button").attr("disabled",false);
				if(d=='1'){
					$("#status").html("Consulta inserida com sucesso!");
				}
				else{
					$("#status").html ("Consulta nao inserida!");
					$("#status").html ("color","red");
				}
			}
		});
	});
});
</script>
</body>
</html>