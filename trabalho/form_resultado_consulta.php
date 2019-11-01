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
		$tabelas[0][0] = "resultado_consulta";
		$tabelas[0][1] = null;
		$ordenacao = null;
		$condicao = null;
		$condicao = $_POST["id"];
		$stmt = $c->seleionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_resultado = $linha["ID_RESULTADO"];
		$value_id_resultado = $linha["DIAGNOSTICO"];
		$value_id_resultado = $linha["SINTOMAS"];
		$value_id_resultado = $linha["CRM"];


		$action = "altera.php?tabela=resultado_consulta";
	}
	else{
		$value_id_resultado = null;
		$value_diagnostico = null;
		$value_sintomas = null;
		$value_crm = null;
		$action = "insere.php?tabela=resultado_consulta";
	}

	//seleção dos valores que irão criar o <select> de FUNCAO//////
	$select = "SELECT CRM AS value, NOME_MEDICO AS texto FROM medico ORDER BY NOME_MEDICO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_medico[] = $linha;
	}	
	////////////////////////////////////////////////////

	$v = array("action"=>"insere.php?tabela=resultado_consulta","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"DIAGNOSTICO","placeholder"=>"DIAGNOSTICO...");
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"SINTOMAS","placeholder"=>"SINTOMAS...");
	$f->add_input($v);
	
	$v = array("name"=>"CRM","select"=>$value_crm);

	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir resultado da consulta</h3>
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
				ID_RESULTADO: $("input[name='ID_RESULTADO']").val(),
				DIAGNOSTICO: $("input[name='DIAGNOSTICO']").val(),
                SINTOMAS: $("input[name='SINTOMAS']").val(),
                NOME_MEDICO: $("input[name='NOME_MEDICO']").val()
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