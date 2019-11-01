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
		$tabelas[0][0] = "denuncia";
		$tabelas[0][1] = null;
		$ordenacao = null;
		$condicao = null;
		$condicao = $_POST["id"];
		$stmt = $c->seleionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_resultado = $linha["ID_DENUNCIA"];
		$value_id_resultado = $linha["DESCRICAO"];
		$value_id_resultado = $linha["CPF"];

		$action = "altera.php?tabela=denuncia";
	}
	else{
		$value_id_denuncia = null;
		$value_descricao = null;
		$value_cpf = null;
		$action = "insere.php?tabela=denuncia";
	}

	//seleção dos valores que irão criar o <select> de FUNCAO//////
	$select = "SELECT CPF AS value, NOME_CLIENTE AS texto FROM cliente ORDER BY NOME_CLIENTE";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_cliente[] = $linha;
	}	
	////////////////////////////////////////////////////

	$v = array("action"=>"insere.php?tabela=denuncia","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"DESCRICAO","placeholder"=>"DESCRICAO...");
    $f->add_input($v);
	
	$v = array("name"=>"CPF","select"=>$value_cpf);

	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir resultado da denuncia</h3>
<hr />
<?php
	$f->exibe();
?>
<script>
$(function(){
	$("button").click(function(){
		$.ajax({
			url: "insere.php?tabela=denuncia",
			type: "post",
			data: {
				ID_DENUNCIA: $("input[name='ID_DENUNCIA']").val(),
				DESCRICAO: $("input[name='DESCRICAO']").val(),
                CPF: $("input[name='CPF']").val()
			},
			beforerSend:function(){
				$("button").attr("disabled",true);
			}
			sucess: function(d){
				$("button").attr("disabled",false);
				if(d=='1'){
					$("#status").html("denuncia cancelada inserida com sucesso!");
				}
				else{
					$("#status").html ("denuncia cancelada nao inserida!");
					$("#status").html ("color","red");
				}
			}
		});
	});
});
</script>
</body>
</html>