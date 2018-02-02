{% extends "layouts/template.volt" %}




{% block content %}

<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Listar Imóveis</h1>
        </div>
    </div>
    <div class="row">
        
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Buscar</h3>
                </div>
                <div class="panel-body">
                    
                        <div class="row">
                            <div class="col-xs-12 col-sm-3" class="input-group">
                                {{ text_field("info", "size": 11) }}
                            </div>
                            <div class="col-xs-12 col-sm-3" class="input-group">
                               {{ select("tipo_imovel_id", tipoimoveis, 'using': ['id', 'nome'], "useEmpty" : true, "emptyText" : "Escolha um tipo de Imóvel...") }}
                            </div>
                            <div class="col-xs-12 col-sm-3">
							<button class="btn btn-success" id="buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>
							</div>
                        </div>
                    
                </div>
            </div>
        </div>

        <div class="col-xs-12 text-center">
                <hr>
				{{ link_to(["for": "site.imovel.adicionar", "name": "adImovel"], " Adiconar", "class": "glyphicon glyphicon-plus btn btn-primary btn-lg") }}
            
            <hr>
        </div>

        <div class="col-xs-12" id="busca">
            <table class="table table-striped">
                <tr>
                    <th>Código</th>
                    <th>Tipo de Imóvel</th>
                    <th>Valor do Imóvel</th>
                    <th>Ações</th>
                </tr>
				
				{% for imovel in imoveis %}
                <tr>
                    <td>{{ imovel.codigo }}</td>
                    <td>{{ imovel.tipo_imovel }}</td>
                    <td>{% if  imovel.tipo_negocio  == 'V' %} {{ imovel.valor_venda }} {% else %} {{ imovel.valor_aluguel }} {% endif %}</td>
                    <td>
					<button type="button" id="editar" onclick="window.location.href = '/imoveis/editar/{{ imovel.id }}'" class="btn btn-info">
						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</button>
					<button type="button" onclick="window.location.href = '/imoveis/remover/{{ imovel.id }}'" class="btn btn-danger">
					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
					</button>
					</td>
                </tr>
				
                {% endfor %}
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#buscar').on('click',function(evt, params){
	var info = $('#info').val();
	var tipo_imovel_id = $('#tipo_imovel_id').val();
	
	$.ajax({
		method: "POST",
		url: "<?php echo $this->url->get('imoveis/visualizar'); ?>",
		data: {info : info, tipo_imovel_id: tipo_imovel_id},
		success: function(data){
		
			
				
				$("#busca").html(data);
			
			
		},
	});
});
</script>
{% endblock %}


