$('.chosen-select').chosen({ no_results_text: "Resultado não encontrado", max_selected_options: 1}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});

$('input[type=radio]').on("click",function(){
	$("#vvenda").hide();
	$("#valuguel").hide();
	$("#valor_venda").val("");
	$("#valor_aluguel").val("");
	$("#v" + $("input:checked").attr('id')).show();
	
});

$(document).ready(function(){
	$("#vvenda").hide();
	$("#valuguel").hide();
	
	$("#v" + $("input[type=radio]:checked").attr('id')).show();
	
	if($('input[type=checkbox]').is(':checked')){
		$("#dExpiracao").show();
	}
});



$('input[type=checkbox]').on("click",function(){
	if(this.checked){
		$("#dExpiracao").show();
	}
	else{
		$('#data_expiracao').val('');
		$("#dExpiracao").hide();
	}
	
});

$('#data_expiracao').change(function(){
	var d = new Date();
	var mes = d.getMonth()+1;
	var dia = d.getDate();
	var ano = d.getFullYear();
	var data = ano + '-' + (mes<10 ? '0' : '') + mes + '-' + (dia<10 ? '0' : '') + dia;
	var data2 = dia + '/' + (mes<10 ? '0' : '') + mes + '/' + ano;
	var dataSelecionada = $('#data_expiracao').val();
	var arr = dataSelecionada.split('-');
	var dataSelecionada2 = arr[2]+'/'+arr[1]+'/'+arr[0];
	if( dataSelecionada <= data){
		$('#data_expiracao').val('');
		$('#erroDataExpiracao').show();
		$('#alertMessage').html('<strong>Erro!</strong> A data selecionada <strong>'+dataSelecionada2+'</strong> deve ser maior que a data atual <strong>'+data2+'</strong>');
	}else{
		$('#erroDataExpiracao').hide();
	}
})

$('#close').on("click", function(){
	$('#erroDataExpiracao').hide();
	
});

$('#closeCodigo').on("click", function(){
	$('#erroCodigo').hide();
	$('#codigo').val('');
});

$('#imagem').change(function(){
	var fileName = $("#imagem").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            $("img").attr('src','');
			$('#erroImagem').hide();
        }else{
			$('#erroImagem').show();
            $('#imagemMessage').html('<strong>Erro!</strong> Apenas permitidos arquivos JPG, JPEG ou PNG');
			$("#imagem").val('');
        }   
	
});

$('#closeImagem').on("click", function(){
	$('#erroImagem').hide();
});
