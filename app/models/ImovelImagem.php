<?php

use Phalcon\Mvc\Model;

class ImovelImagem extends Model
{
    /* Dica: Olhar Schema do Banco de dados para criar os atributos e relacionamentos corretamente */
    public $id;

    public function initialize()
    {
        $this->setSource("imovel_imagem");
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
