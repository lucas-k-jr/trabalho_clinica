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
		$tabelas[0][0] = "consulta_cancelada";
		$tabelas[0][1] = null;
		$ordenacao = null;
		$condicao = null;
		$condicao = $_POST["id"];
		$stmt = $c->seleionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_resultado = $linha["ID_CANCELAMENTO"];
		$value_id_resultado = $linha["DESCRICAO"];
		$value_id_resultado = $linha["NOME_CLIENTE"];

		$action = "altera.php?tabela=consulta_cancelada";
	}
	else{
		$value_id_resultado = null;
		$value_id_consulta = null;
		$value_cpf = null;
		$action = "insere.php?tabela=consulta_cancelada";
	}
	
	//seleção dos valores que irão criar o <select> de AGENDAMENTO_CONSULTA//////
	$select = "SELECT ID_CONSULTA AS value, DESCRICAO AS texto FROM agendamento_consulta ORDER BY DESCRICAO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_consulta[] = $linha;
	}	
	////////////////////////////////////////////////////

	//seleção dos valores que irão criar o <select> de CLIENTE//////
	$select = "SELECT CPF AS value, NOME_CLIENTE AS texto FROM cliente ORDER BY NOME_CLIENTE";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_consulta[] = $linha;
	}

	///////////////////////////////////////////////////////
		
	$v = array("action"=>"insere.php?tabela=consulta_cancelada","method"=>"post");
	$f = new Form($v);
	
	$v = array("name"=>"ID_CONSULTA","label"=>"consulta");
	$f->add_select($v,$matriz_consulta);
	$v = array("name"=>"CPF","label"=>"cliente");
	$f->add_select($v,$matriz_cliente);
	
	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir Consultas canceladas</h3>
<hr />
<?php
	$f->exibe();
?>
<script>
$(function(){
	$("button").click(function(){
		$.ajax({
			url: "insere.php?tabela=consulta_cancelada",
			type: "post",
			data: {
				ID_CANCELAMENTO: $("input[name='ID_CANCELAMENTO']").val(),
				ID_CONSULTA: $("input[name='ID_CONSULTA']").val(),
				CPF: $("input[name='CPF']").val()	
			},
			beforerSend:function(){
				$("button").attr("disabled",true);
			}
			sucess: function(d){
				$("button").attr("disabled",false);
				if(d=='1'){
					$("#status").html("Consulta cancelada inserida com sucesso!");
				}
				else{
					$("#status").html ("Consulta cancelada nao inserida!");
					$("#status").html ("color","red");
				}
			}
		});
	});
});
</script>
</body>
</html>