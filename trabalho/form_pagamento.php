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
		$tabelas[0][0] = "pagamento";
		$tabelas[0][1] = null;
		$ordenacao = null;
		$condicao = null;
		$condicao = $_POST["id"];
		$stmt = $c->seleionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_resultado = $linha["ID_PAGAMENTO"];
		$value_id_resultado = $linha["FORMA_PGT"];
		$value_id_resultado = $linha["VALOR"];
		$value_id_resultado = $linha["DATE"];
		$value_id_resultado = $linha["NOME_CLIENTE"];
		$value_id_resultado = $linha["NOME_MEDICO"];


		$action = "altera.php?tabela=pagamento";
	}
	else{
		$value_id_pagamento = null;
		$value_forma_pgt = null;
		$value_valor = null;
		$value_date = null;
		$value_cpf = null;
		$value_crm = null;
		$action = "insere.php?tabela=pagamento";
	}

	//seleção dos valores que irão criar o <select> de CLIENTE//////
	$select = "SELECT CPF AS value, NOME_CLIENTE AS texto FROM cliente ORDER BY NOME_CLIENTE";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_cliente[] = $linha;
	}

	////////////////////////////////////////////////////

	//seleção dos valores que irão criar o <select> de MEDICO//////
	$select = "SELECT CRM AS value, NOME_MEDICO AS texto FROM medico ORDER BY NOME_MEDICO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_medico[] = $linha;
	}

	////////////////////////////////////////////////////	
	$v = array("action"=>"insere.php?tabela=pagamento","method"=>"post");
	$f = new Form($v);
	$v = array("type"=>"text","name"=>"FORMA_PGT","placeholder"=>"FORMA DE PAGAMENTO...");
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"VALOR","placeholder"=>"VALOR DO PAGAMENTO...");
    $f->add_input($v);
	$v = array("type"=>"date","name"=>"DATA_PAGAMENTO","placeholder"=>"DATA DO PAGAMENTO...");
    $f->add_input($v);
  
	$v = array("name"=>"CPF","label"=>"cliente");
	$f->add_select($v,$matriz_cliente);
	$v = array("name"=>"CRM","label"=>"medico");
	$f->add_select($v,$matriz_medico);

	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir Pagamentos</h3>
<hr />
<?php
	$f->exibe();
?>
<script>
$(function(){
	$("button").click(function(){
		$.ajax({
			url: "insere.php?tabela=pagamento",
			type: "post",
			data: {
				ID_PAGAMENTO: $("input[name='ID_PAGAMENTO']").val(),
				FORMA_PGT: $("input[name='FORMA_PGT']").val(),
				VALOR: $("input[name='VALOR']").val(),
				CPF: $("input[name='CPF']").val(),
				CRM: $("input[name='CRM']").val(),
			},
			beforerSend:function(){
				$("button").attr("disabled",true);
			}
			sucess: function(d){
				$("button").attr("disabled",false);
				if(d=='1'){
					$("#status").html("Pagamento inserido com sucesso!");
				}
				else{
					$("#status").html ("Pagamento nao inserido!");
					$("#status").html ("color","red");
				}
			}
		});
	});
});
</script>
</body>
</html>