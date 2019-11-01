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
	
	//seleção dos valores que irão criar o <select> de FUNCAO//////
	$select = "SELECT ID_FUNCAO AS value, TITULO_FUNCAO AS texto FROM funcao ORDER BY TITULO_FUNCAO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_funcao[] = $linha;
	}	
	////////////////////////////////////////////////////
	
	
	while($linha=$stmt->fetch()){
		$matriz_gerente[] = $linha;
	}	
	////////////////////////////////////////////////////	
	////////////////////////////////////////////////////
	
	while($linha=$stmt->fetch()){
		$matriz_departamento[] = $linha;
	}	
	////////////////////////////////////////////////////	
	$v = array("action"=>"insere.php?tabela=cliente","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"NOME","placeholder"=>"NOME...");
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"EMAIL","placeholder"=>"EMAIL...");
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"TELEFONE","placeholder"=>"TELEFONE...");
	$f->add_input($v);
	$v = array("type"=>"date","label"=>"DATA NASCIMENTO: ", "name"=>"DATA_NASCIMENTO","placeholder"=>"DATA NASCIMENTO...");
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"CPF: ", "name"=>"CPF","placeholder"=>"CPF...");
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"ESTADO: ", "name"=>"ESTADO","placeholder"=>"ESTADO...");
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"CIDADE","placeholder"=>"CIDADE...");
	$f->add_input($v);
    $v = array("type"=>"text","name"=>"BAIRRO: ", "name"=>"BAIRRO","placeholder"=>"BAIRRO...");
    $f->add_input($v);
    $v = array("type"=>"number","name"=>"NUMERO: ", "name"=>"NUMERO","placeholder"=>"NUMERO...");
	$f->add_input($v);
    $v = array("type"=>"text","name"=>"COMPLEMENTO: ", "name"=>"COMPLEMENTO","placeholder"=>"COMPLEMENTO...");
    $f->add_input($v);
	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>
<h3>Formulário - Inserir Cliente</h3>
<hr />
<?php
	$f->exibe();
?>
<script>
$(function(){
	$("button").click(function(){
		$.ajax({
			url: "insere.php?tabela=cliente",
			type: "post",
			data: {
				NOME: $("input[name='NOME']").val(),
                EMAIL: $("input[name='EMAIL']").val(),
				TELEFONE: $("input[name='TELEFONE']").val(),
                DATA_NASCIMENTO: $("input[name='DATA_NASCIMENTO']").val(),
                CPF: $("input[name='CPF']").val(),	
                ESTADO: $("input[name='ESTADO']").val(),
                CIDADE: $("input[name='CIDADE']").val(),	
				NUMERO: $("input[name='NUMERO']").val(),
                COMPLEMENTO: $("input[name='COMPLEMENTO']").val(),			
			},
			beforerSend:function(){
				$("button").attr("disabled",true);
			}
			sucess: function(d){
				$("button").attr("disabled",false);
				if(d=='1'){
					$("#status").html("Cliente inserido com sucesso!");
				}
				else{
					$("#status").html ("Cliente nao inserido!");
					$("#status").html ("color","red");
				}
			}
		});
	});
});
</script>
</body>
</html>