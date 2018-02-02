<?php

use Phalcon\Mvc\Model;

class Imovel extends Model
{
    /* Dica: Olhar Schema do Banco de dados para criar os atributos e relacionamentos corretamente */
    public $id;
    
    public function initialize()
    {
        $this->setSource("imovel");
		$this->useDynamicUpdate(true);
		$this->skipAttributes([ 'tipo_imovel_id', 'filial_id', 'logradouro_id', 'tipo_negocio', 'publicado' ]);
		
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
	

	
}
