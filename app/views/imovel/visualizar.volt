			<table class="table table-striped">
                <tr>
                    <th>Código</th>
                    <th>Tipo de Imóvel</th>
                    <th>Valor do Imóvel</th>
                    <th>Ações</th>
                </tr>
				{% if imoveis is defined %}
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
				{% else %}
					<tr>
						<td colspan="4">
							<div class="alert alert-danger" role="alert">Resultado da busca não encontrado!</div>
						</td>
					</tr>
				{% endif %}
            </table>
        