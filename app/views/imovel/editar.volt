{% extends "layouts/template.volt" %}

{% block content %}


<link type="text/css" rel="stylesheet" href="/less/bootstrap-chosen.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Editar Imovel</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
			{{ form("imoveis/atualizar", "method": "post", 'enctype': 'multipart/form-data') }}
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Dados Básicos</h3>
                </div>
                <div class="panel-body">
					<div class="form-group">
						<label for="codigo" class="col-sm-2 control-label">Código</label>
						{{ text_field("codigo", "size": 10, "value": imoveis.codigo ) }} 
					</div>
					<div class="alert alert-warning alert-dismissible" id="erroCodigo" role="alert" style="display:none">
					  <button type="button" class="close" id="closeCodigo" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div id="codigoMensagem">
						</div>
					</div>
					<div class="form-group">
						<label for="tipo_imovel_id" class="col-sm-2 control-label">Tipo de Imóvel</label>
						{{ select("tipo_imovel_id", tipoimoveis, 'using': ['id', 'nome']) }}
					</div>
					<div class="form-group">
						<label for="filial_id" class="col-sm-2 control-label">Filial</label>
						{{ select("filial_id", filiais, 'using': ['id', 'nome']) }}
					</div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Localizacao</h3>
                </div>
                <div class="panel-body">
					<div class="form-group">
						<label for="logradouro_id" class="col-sm-2 control-label">Logadouro</label>
						{{ select("logradouro_id", logradouros, 'using': ['id', 'logradouro'], "id" : "logradouro_id", "data-placeholder" : "Escolha um logradouro_id..." , "class" : "chosen-select", "multiple style" : "width:350px;", "tabindex" : "4") }}
					</div>
					<div class="form-group" id="listarBairros">
					</div>
					<div class="form-group">
						<label for="numero" class="col-sm-2 control-label">Número</label>
						{{ text_field("numero", "size": 11, "value" : imoveis.numero) }}
					</div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Valores</h3>
                </div>
                <div class="panel-body">
					<div class="form-group">
						<label for="tipo_negocio" class="col-sm-2 control-label">Tipo de Negócio</label>
						Venda {{ radio_field("tipo_negocio", 'value': 'V', 'id':'venda') }}
						Aluguel {{ radio_field("tipo_negocio", 'value': 'A', 'id':'aluguel') }}
					</div>
					<div class="form-group" id="vvenda" style="display:none">
						<label for="valor_venda" class="col-sm-2 control-label">Valor de Venda</label>
						{{ text_field("valor_venda", "size": 20, "value" : imoveis.valor_venda) }}
					</div>
					<div class="form-group" id="valuguel" style="display:none">
						<label for="valor_aluguel" class="col-sm-2 control-label">Valor do Aluguel</label>
						{{ text_field("valor_aluguel", "size": 20, "value" : imoveis.valor_aluguel) }}
					</div>
                </div>
            </div>

            <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Imagem</h3>
                    </div>
                    <div class="panel-body">
						{{ file_field("imagem", "accept":"image/jpg, image/jpeg, image/png") }}
						
						{% if imagens.caminho is defined %}
							{{ image(imagens.caminho, "id" : "foto", "class":"img-responsive", "width" : "250px", "height" : "250px") }}
						{% endif %}
                    </div>
					<div class="alert alert-warning alert-dismissible" id="erroImagem" role="alert" style="display:none">
					  <button type="button" class="close" id="closeImagem" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <div id="imagemMessage">
					  
					  </div>
					</div>
                </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalhes</h3>
                </div>
                <div class="panel-body">
					<div class="form-group">
						<label for="dormitorios" class="col-sm-2 control-label">Qtd de dormitorios</label>
						{{ numeric_field("dormitorios", "size": 10, "value": imoveis.dormitorios) }}
					</div>
					<div class="form-group">
						<label for="area_terreno" class="col-sm-2 control-label">Área do Terreno</label>
						{{ numeric_field("area_terreno", "size": 10, "value": imoveis.area_terreno) }} m²
					</div>
					<div class="form-group">
						<label for="banheiros" class="col-sm-2 control-label">Banheiros</label>
						{{ numeric_field("banheiros", "size": 10, "value": imoveis.banheiros) }} 
					</div>
					<div class="form-group">
						<label for="vagas_garagem" class="col-sm-2 control-label">Vagas de Garagem</label>
						{{ numeric_field("vagas_garagem", "size": 10, "value": imoveis.vagas_garagem) }} 
					</div>
					<div class="form-group">
						<label for="titulo_imovel" class="col-sm-2 control-label">Título do Imóvel</label>
						{{ text_field("titulo_imovel", "size": 50, "value": imoveis.titulo_imovel) }}
					</div>
					<div class="form-group">
						<label for="descricao" class="col-sm-2 control-label">Descrição</label>
						{{ text_area("descricao", "cols": 50, "rows": 4, "value": imoveis.descricao) }}
					</div>
					<div class="form-group">
						<label for="publicado" class="col-sm-2 control-label">Publicado</label>
						{{ check_field("publicado") }}
					</div>
					<div class="form-group" id="dExpiracao" style="display:none">
						<label for="data_expiracao" class="col-sm-2 control-label">Data Expiração</label>
						{{ date_field("data_expiracao") }}
					</div>
					<div class="alert alert-warning alert-dismissible" id="erroDataExpiracao" role="alert" style="display:none">
					  <button type="button" class="close" id="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <div id="alertMessage">
					  
					  </div>
					</div>
                    {{ hidden_field("id", "value" : imoveis.id) }}
                </div>
            </div>

            <div class="text-center">
				{{ submit_button("Salvar", "class": "btn btn-success") }}
            </div>
			{{ endForm() }}
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/adicionarjs.js"></script>
<script type="text/javascript" src="/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
	$("#valor_venda").inputmask( 'currency',{"autoUnmask": true,
            radixPoint:",",
            groupSeparator: ".",
            allowMinus: false,
            prefix: 'R$ ',            
            digits: 2,
            digitsOptional: false,
            rightAlign: true,
            unmaskAsNumber: true
    });
	$("#valor_aluguel").inputmask( 'currency',{"autoUnmask": true,
            radixPoint:",",
            groupSeparator: ".",
            allowMinus: false,
            prefix: 'R$ ',            
            digits: 2,
            digitsOptional: false,
            rightAlign: true,
            unmaskAsNumber: true
    });
$('.chosen-select').on('change', function(evt, params){
	
	
	$.ajax({
		method: "POST",
		url: "<?php echo $this->url->get('imoveis/listarbairros'); ?>",
		data: {logradouro : $('.chosen-select').val()},
		success: function(data){
			$("#listarBairros").html(data);
		},
	});
	
});

$('#codigo').change(function(){
	var codigo = $('#codigo').val();
	var id = $('#id').val();
	$.ajax({
		method: "POST",
		url: "<?php echo $this->url->get('imoveis/validarcodigo'); ?>",
		data: {codigo : codigo, acao : "editar", id : id},
		success: function(data){
			if(data){
				$("#erroCodigo").show();
				$("#codigoMensagem").html(data);
			}else{
				$('#erroCodigo').hide();
			}
		},
	});
});
</script>
{% endblock %}
