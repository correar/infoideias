{% extends "layouts/template.volt" %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>Ultimos Imóveis Cadastrados</h3>
        </div>
    </div>
	<table class="table table-hover">
		<tr>
			<th>Código</th>
			<th>Tipo do Imóvel</th>
			<th>Filial</th>
			<th>Logradouro</th>
			<th>Número</th>
			<th>Tipo do Negócio</th>
			<th>Valor</th>
			<th>Dormitorios</th>
			<th>Área do Terreno</th>
			<th>Banheiros</th>
			<th>Vagas</th>
			<th>Título</th>
			<th>Descrição</th>
			<th>Publicado</th>
			<th>Data Expiração</th>
			<th>Foto</th>
		</tr>
		{% for imovel in imoveis %}
		<tr>
			<td>{{ imovel.codigo }}</td>
			<td>{{ imovel.tipo_imovel }}</td>
			<td>{{ imovel.filial_nome }}</td>
			<td>{{ imovel.logradouro_tipo}} {{ imovel.logradouro_nome }}, {{ imovel.bairro_nome }}</td>
			<td>{{ imovel.numero }}</td>
			<td>{{ imovel.tipo_negocio }}</td>
			<td>{% if imovel.tipo_negocio === 'Venda' %} {{ imovel.valor_venda }} {% else %} {{ imovel.valor_aluguel }} {% endif %}</td>
			<td>{{ imovel.dormitorios }}</td>
			<td>{{ imovel.area_terreno }}</td>
			<td>{{ imovel.banheiros }}</td>
			<td>{{ imovel.vagas_garagem }}</td>
			<td>{{ imovel.titulo_imovel }}</td>
			<td>{{ imovel.descricao }}</td>
			<td>{{ imovel.publicado }}</td>
			<td>{% if imovel.publicado === 'S' %} {{ imovel.data_expiracao }} {% endif %}</td>
			<td>{% if imovel.caminho is defined %} {{ image(imovel.caminho, "class":"img-responsive") }} {% endif %}</td>
		</tr>
		{% endfor %}
	</table>
</div>
{% endblock %}
