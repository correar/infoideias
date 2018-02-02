<?php
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;


class ImovelController extends Controller
{

	public function listarAction()
	{
		$this->view->tipoimoveis = TipoImovel::find();
		$imovel = imovel::query()
				->columns("Imovel.id, codigo, valor_aluguel, valor_venda, tipo_negocio, tipoImovel.nome as tipo_imovel")
				->innerJoin("tipoImovel","tipo_imovel_id = tipoImovel.id")
				->where("ativo = 'S'")
				->order("Imovel.id")
				->execute();
		
		
		for($j = 0; $j < count($imovel); $j++){	
		
			$imovelAtual[$j] = $imovel->current($imovel[$j]->id);
			
			$dezenaV = strchr($imovelAtual[$j]->valor_venda ,".");
			if($dezenaV){
				$imovelAtual[$j]->valor_venda = str_replace(".",",",$imovelAtual[$j]->valor_venda);
				$valor_venda = explode(",",$imovelAtual[$j]->valor_venda);
				$venda_cnt = strlen($valor_venda[0]);
				$imovelAtual[$j]->valor_venda = "R$ ";
				for($i = 0; $i <= $venda_cnt; $i++){
					if((($venda_cnt-$i)%3 == 0) and ($i<>$venda_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_venda .= ".";
					}
					$imovelAtual[$j]->valor_venda .= substr($valor_venda[0], $i, 1);
				}
				if(strlen($valor_venda[1]) == 1){
					$valor_venda[1] = $valor_venda[1]."0";
				}
				$imovelAtual[$j]->valor_venda .= ",".$valor_venda[1];
			}
			else{
				$valor_venda = $imovelAtual[$j]->valor_venda;
				$venda_cnt = strlen($valor_venda);
				$imovelAtual[$j]->valor_venda = "R$ ";
				for($i = 0; $i <= $venda_cnt; $i++){
					if((($venda_cnt-$i)%3 == 0) and ($i<>$venda_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_venda .= ".";
					}
					$imovelAtual[$j]->valor_venda .= substr($valor_venda, $i, 1);
				}
				$imovelAtual[$j]->valor_venda .= ",00";
			}
			
			$dezenaA = strchr($imovelAtual[$j]->valor_aluguel ,".");
			if($dezenaA){
				$imovelAtual[$j]->valor_aluguel = str_replace(".",",",$imovelAtual[$j]->valor_aluguel);
				$valor_aluguel = explode(",",$imovelAtual[$j]->valor_aluguel);
				$aluguel_cnt = strlen($valor_aluguel[0]);
				$imovelAtual[$j]->valor_aluguel = "R$ ";
				for($i = 0; $i <= $aluguel_cnt; $i++){
					if((($aluguel_cnt-$i)%3 == 0) and ($i<>$aluguel_cnt)){
						$imovelAtual[$j]->valor_aluguel .= ".";
					}
					$imovelAtual[$j]->valor_aluguel .= substr($valor_aluguel[0], $i, 1);
				}
				if(strlen($valor_aluguel[1]) == 1){
					$valor_aluguel[1] = $valor_aluguel[1]."0";
				}
				$imovelAtual[$j]->valor_aluguel .= ",".$valor_aluguel[1];
			}
			else{
				$valor_aluguel = $imovelAtual[$j]->valor_aluguel;
				$aluguel_cnt = strlen($valor_aluguel);
				$imovelAtual[$j]->valor_aluguel = "R$ ";
				for($i = 0; $i <= $aluguel_cnt; $i++){
					if((($aluguel_cnt-$i)%3 == 0) and ($i<>$aluguel_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_aluguel .= ".";
					}
					$imovelAtual[$j]->valor_aluguel .= substr($valor_aluguel, $i, 1);
				}
				$imovelAtual[$j]->valor_aluguel .= ",00";
			}
			
			
			
		}
		
		
		$this->view->imoveis = $imovelAtual;
    }
    

    public function adicionarAction()
	{
		$this->view->tipoimoveis = TipoImovel::find();
		$this->view->filiais = Filial::find();
		$this->view->logradouros = Logradouro::query()
									->columns('id, CONCAT(tipo, " ", nome) AS logradouro')
									->execute();
		
    }
    
    public function editarAction($id)
	{
		
		$imoveis = imovel::findFirst($id);
		$this->view->tipoimoveis = TipoImovel::find();
		$this->tag->setDefault("tipo_imovel_id",$imoveis->tipo_imovel_id);
		
		$this->view->filiais = Filial::find();
		$this->tag->setDefault("filial_id",$imoveis->filial_id);
		
		$this->view->logradouros = Logradouro::query()
									->columns('id, CONCAT(tipo, " ", nome) AS logradouro')
									->execute();
		$this->tag->setDefault("logradouro_id",$imoveis->logradouro_id);
		
		$this->tag->setDefault("tipo_negocio",$imoveis->tipo_negocio);
		
		$this->view->imagens = imovelImagem::findFirst(
			[
				"conditions" => "imovel_id =".$imoveis->id,
				"columns" => "caminho, id",
			]
		);
		if($imoveis->publicado === 'S'){
			$this->tag->setDefault("publicado",$imoveis->publicado);
			$this->tag->setDefault("data_expiracao", date('Y-m-d',strtotime($imoveis->data_expiracao)));
		}
		$this->view->imoveis = $imoveis;
    }
    
    public function removerAction($id)
	{
		$imovel = new Imovel();
		//$imovel->skipAttributes(['codigo', 'tipo_imovel_id', 'filial_id', 'logradouro_id', 'tipo_negocio', 'publicado' ]);
		$imovelAtual = imovel::findFirst($id);
		
		
		$imovel->setId($id);
		$imovel->codigo = $imovelAtual->codigo;
		$imovel->ativo = 'N';
		$imovel->save();
		$this->response->redirect("/imoveis");
    }
    
    public function visualizarAction()
	{
		$info = $this->request->getPost("info");
		$tipo_imovel_id = $this->request->getPost("tipo_imovel_id");
		
		if($tipo_imovel_id){
			$imovel = imovel::query()
				->columns("Imovel.id, codigo, valor_aluguel, valor_venda, tipo_negocio, tipoImovel.nome as tipo_imovel")
				->innerJoin("tipoImovel","tipo_imovel_id = tipoImovel.id")
				->where("ativo = 'S'")
				->andwhere("codigo LIKE '%".$info."%'")
				->andwhere("tipo_imovel_id = ".$tipo_imovel_id)
				->order("Imovel.id")
				->execute();
		}else{
			$imovel = imovel::query()
				->columns("Imovel.id, codigo, valor_aluguel, valor_venda, tipo_negocio, tipoImovel.nome as tipo_imovel")
				->innerJoin("tipoImovel","tipo_imovel_id = tipoImovel.id")
				->where("ativo = 'S'")
				->andwhere("codigo LIKE '%".$info."%'")
				->order("Imovel.id")
				->execute();
		}
		
		for($j = 0; $j < count($imovel); $j++){	
				
			$imovelAtual[$j] = $imovel->current($imovel[$j]->id);
			
			$dezenaV = strchr($imovelAtual[$j]->valor_venda ,".");
			if($dezenaV){
				$imovelAtual[$j]->valor_venda = str_replace(".",",",$imovelAtual[$j]->valor_venda);
				$valor_venda = explode(",",$imovelAtual[$j]->valor_venda);
				$venda_cnt = strlen($valor_venda[0]);
				$imovelAtual[$j]->valor_venda = "R$ ";
				for($i = 0; $i <= $venda_cnt; $i++){
					if((($venda_cnt-$i)%3 == 0) and ($i<>$venda_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_venda .= ".";
					}
					$imovelAtual[$j]->valor_venda .= substr($valor_venda[0], $i, 1);
				}
				if(strlen($valor_venda[1]) == 1){
					$valor_venda[1] = $valor_venda[1]."0";
				}
				$imovelAtual[$j]->valor_venda .= ",".$valor_venda[1];
			}
			else{
				$valor_venda = $imovelAtual[$j]->valor_venda;
				$venda_cnt = strlen($valor_venda);
				$imovelAtual[$j]->valor_venda = "R$ ";
				for($i = 0; $i <= $venda_cnt; $i++){
					if((($venda_cnt-$i)%3 == 0) and ($i<>$venda_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_venda .= ".";
					}
					$imovelAtual[$j]->valor_venda .= substr($valor_venda, $i, 1);
				}
				$imovelAtual[$j]->valor_venda .= ",00";
			}
					
			$dezenaA = strchr($imovelAtual[$j]->valor_aluguel ,".");
			if($dezenaA){
				$imovelAtual[$j]->valor_aluguel = str_replace(".",",",$imovelAtual[$j]->valor_aluguel);
				$valor_aluguel = explode(",",$imovelAtual[$j]->valor_aluguel);
				$aluguel_cnt = strlen($valor_aluguel[0]);
				$imovelAtual[$j]->valor_aluguel = "R$ ";
				for($i = 0; $i <= $aluguel_cnt; $i++){
					if((($aluguel_cnt-$i)%3 == 0) and ($i<>$aluguel_cnt)){
						$imovelAtual[$j]->valor_aluguel .= ".";
					}
					$imovelAtual[$j]->valor_aluguel .= substr($valor_aluguel[0], $i, 1);
				}
				if(strlen($valor_aluguel[1]) == 1){
					$valor_aluguel[1] = $valor_aluguel[1]."0";
				}
				$imovelAtual[$j]->valor_aluguel .= ",".$valor_aluguel[1];
			}
			else{
				$valor_aluguel = $imovelAtual[$j]->valor_aluguel;
				$aluguel_cnt = strlen($valor_aluguel);
				$imovelAtual[$j]->valor_aluguel = "R$ ";
				for($i = 0; $i <= $aluguel_cnt; $i++){
					if((($aluguel_cnt-$i)%3 == 0) and ($i<>$aluguel_cnt) and ($i <> 0)){
						$imovelAtual[$j]->valor_aluguel .= ".";
					}
					$imovelAtual[$j]->valor_aluguel .= substr($valor_aluguel, $i, 1);
				}
				$imovelAtual[$j]->valor_aluguel .= ",00";
			}
					
					
					
		}
				
		
		$this->view->imoveis = $imovelAtual;
		
		
	}
	
	public function listarbairrosAction()
	{
			$logradouroId = $this->request->getPost("logradouro");
			if($logradouroId){
				$bairroId = Logradouro::find(
					[
						"conditions" => "id = ".$logradouroId[0],
						"columns" => "bairro_id",
					]
				);
				
				$this->view->bairros = 	Bairro::find(
					[
						"conditions" => "id = ".$bairroId[0]->bairro_id,
					]
				);
		
			}
			else{
				$this->view->disable();
			}
		
		
	}
	
	public function validarcodigoAction()
	{
		$codigo = $this->request->getPost("codigo");
		$acao = $this->request->getPost("acao");
		$id = $this->request->getPost("id");
		if($codigo){
			if($acao = "editar"){
				$result = Imovel::find(
					[
						"conditions" => "codigo = '".$codigo."'",
						"columns" => "id, codigo",
					]
				);
				try{
					if(($result[0]->codigo) and ($result[0]->id <> $id)){
						echo 'Código Existente!';
					}
				}catch (Exception $e){
					
				}
			}else{
				
				$result = Imovel::find(
					[
						"conditions" => "codigo = '".$codigo."'",
						"columns" => "codigo",
					]
				);
				try{
					if($result[0]->codigo){
						echo 'Código Existente!';
					}
				}catch (Exception $e){
					
				}
			}
			
		}
		else{
				$this->view->disable();
		}
	}

	public function cadastrarAction()
	{
		
		$imovel = new Imovel();
		$response = new Response();

		
		$imovel->codigo = $this->request->getPost("codigo");
		$imovel->tipo_imovel_id = $this->request->getPost("tipo_imovel_id");
		$imovel->filial_id = $this->request->getPost("filial_id");
		$imovel->logradouro_id = $this->request->getPost("logradouro_id");
		$imovel->numero = $this->request->getPost("numero");
		$imovel->tipo_negocio = $this->request->getPost("tipo_negocio");
		$imovel->dormitorios = $this->request->getPost("dormitorios");
		$imovel->area_terreno = $this->request->getPost("area_terreno");
		$imovel->banheiros = $this->request->getPost("banheiros");
		$imovel->vagas_garagem = $this->request->getPost("vagas_garagem");
		
		$imovel->titulo_imovel = $this->request->getPost("titulo_imovel");
		$imovel->descricao = $this->request->getPost("descricao");
		
		$imovel->data_expiracao = $this->request->getPost("data_expiracao");
		
		$valorVenda = explode(" ",$this->request->getPost("valor_venda"));
		$valorAluguel = explode(" ",$this->request->getPost("valor_aluguel"));
		$publicado = $this->request->getPost("publicado");
		
		$valorVendas = str_replace('.', '', $valorVenda[1]);
		
		$imovel->valor_venda = str_replace(',', '.',$valorVendas);
		
		$valorAlugueis = str_replace('.', '', $valorAluguel[1]);
		
		$imovel->valor_aluguel = str_replace(',', '.',$valorAlugueis);
		if($publicado){
			$imovel->publicado = 'S';
		}else{
			$imovel->publicado = 'N';
		}
		
		
		
		$success = $imovel->save();
		
		
		if($success){
			
			if ($this->request->hasFiles() == true) {
				$baseLocation = 'files/';

				// Print the real file names and sizes
				foreach ($this->request->getUploadedFiles() as $file) {
					$imovel_Imagem = new ImovelImagem();         
					
					$result = Imovel::find(
						[
							"conditions" => "codigo = '".$imovel->codigo."'",
							"columns" => "id",
						]
					);
					$imovel_Imagem->imovel_id = $result[0]->id;
					$imovel_Imagem->caminho = $baseLocation . $file->getName();
					$imovel_Imagem->save();
					

					//Move the file into the application
					$file->moveTo($baseLocation . $file->getName());
				}
				
				$this->response->redirect();
			}
		}else {
			echo "Não foi possível fazer o registro: ";
			$messages = $imovel->getMessages();
			foreach($messages as $message){
				echo $message->getMessage(), "<br/>";
			}
		}
		
		$this->view->disable();
		
	}
	
	public function atualizarAction()
	{
		$imovel = new Imovel();
		$response = new Response();
		$imovel->setId($this->request->getPost("id"));
		$imovel->codigo = $this->request->getPost("codigo");
		$imovel->tipo_imovel_id = $this->request->getPost("tipo_imovel_id");
		$imovel->filial_id = $this->request->getPost("filial_id");
		$imovel->logradouro_id = $this->request->getPost("logradouro_id");
		$imovel->numero = $this->request->getPost("numero");
		$imovel->tipo_negocio = $this->request->getPost("tipo_negocio");
		$imovel->dormitorios = $this->request->getPost("dormitorios");
		$imovel->area_terreno = $this->request->getPost("area_terreno");
		$imovel->banheiros = $this->request->getPost("banheiros");
		$imovel->vagas_garagem = $this->request->getPost("vagas_garagem");
		
		$imovel->titulo_imovel = $this->request->getPost("titulo_imovel");
		$imovel->descricao = $this->request->getPost("descricao");
		
		$imovel->data_expiracao = $this->request->getPost("data_expiracao");
		
		$valorVenda = explode(" ",$this->request->getPost("valor_venda"));
		$valorAluguel = explode(" ",$this->request->getPost("valor_aluguel"));
		
		
		$valorVendas = str_replace('.', '', $valorVenda[1]);
		
		$imovel->valor_venda = str_replace(',', '.',$valorVendas);
		
		$valorAlugueis = str_replace('.', '', $valorAluguel[1]);
		
		$imovel->valor_aluguel = str_replace(',', '.',$valorAlugueis);
		
		$publicado = $this->request->getPost("publicado");
		if($publicado){
			$imovel->publicado = 'S';
		}else{
			$imovel->publicado = 'N';
		}
		$imovel->ativo = 'S';
		
		$success = $imovel->save();
		
		if($success){
			if ($this->request->hasFiles() == true) {
				$baseLocation = 'files/';

				// Print the real file names and sizes
				foreach ($this->request->getUploadedFiles() as $file) {
					$imovel_Imagem = new ImovelImagem();         
					
					$result = Imovel::find(
						[
							"conditions" => "codigo = '".$imovel->codigo."'",
							"columns" => "id",
						]
					);
					$imovel_Imagem->imovel_id = $result[0]->id;
					$imovel_Imagem->caminho = $baseLocation . $file->getName();
					if($file->getName()){
						$imovel_Imagem->save();
					}
					

					//Move the file into the application
					$file->moveTo($baseLocation . $file->getName());
				}
				
				$this->response->redirect();
			}
		}else {
			echo "Não foi possível fazer o registro: ";
			$messages = $imovel->getMessages();
			foreach($messages as $message){
				echo $message->getMessage(), "<br/>";
			}
		}
	}
}
