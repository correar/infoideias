

<div class="form-group">
	<label for="bairro" class="col-sm-2 control-label">Bairro</label>
	{{ select("bairro", bairros, 'using': ['id', 'nome']) }}
</div>
