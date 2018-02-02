<?php

use Phalcon\Mvc\Controller;
use App\Models;

class IndexController extends Controller
{

	public function indexAction()
	{
		// Dica: Se a View tiver o mesmo nome da Action, nao precisa chamar ela explicitamente
		
		$imovel = imovel::query()
				->columns("Imovel.id, codigo, numero, valor_aluguel, valor_venda, tipo_negocio, dormitorios, area_terreno, banheiros, vagas_garagem, titulo_imovel, descricao, publicado, data_expiracao, tipoImovel.nome as tipo_imovel, filial.nome as filial_nome, logradouro.nome as logradouro_nome, logradouro.tipo as logradouro_tipo, bairro.nome as bairro_nome")
				->innerJoin("tipoImovel","tipo_imovel_id = tipoImovel.id")
				->innerJoin("filial","filial_id = filial.id")
				->innerJoin("logradouro","logradouro_id = logradouro.id")
				->innerJoin("bairro","logradouro.bairro_id = bairro.id")
				->where("ativo = 'S'")
				->order("Imovel.id DESC")
				->limit("10")
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
			
			$imovelAtual[$j]->data_expiracao = date('d/m/Y',strtotime($imovelAtual[$j]->data_expiracao));
		
			if($imovelAtual[$j]->tipo_negocio == "V"){
				$imovelAtual[$j]->tipo_negocio = "Venda";
			} else if ($imovelAtual[$j]->tipo_negocio == "A") {
				$imovelAtual[$j]->tipo_negocio = "Aluguel";
			}
			
			$imagem = imovelImagem::findFirst(["conditions" => "imovel_id =".$imovel[$j]->id, "columns" => "caminho"]);
			if($imagem->caminho){
				$imovelAtual[$j]->caminho = $imagem->caminho;
			}
			
		}
		
		
		
		$this->view->imoveis = $imovelAtual;
	}

}
