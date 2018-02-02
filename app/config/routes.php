<?php
use Phalcon\Mvc\Router;
$router = new Router(false);
$router->removeExtraSlashes(true);
$router->notFound(['controller' => 'Error', 'action' => 'error404']);
$router->add('/',       ['controller' => 'Index', 'action' => 'index'])->setName('site.inicio');


$router->add('/imoveis',                        ['controller' => 'Imovel', 'action' => 'listar'])       ->setName('site.imovel.listar');
$router->add('/imoveis/adicionar',              ['controller' => 'Imovel', 'action' => 'adicionar'])       ->setName('site.imovel.adicionar');
$router->add('/imoveis/editar/:params',        	['controller' => 'Imovel', 'action' => 'editar', 'params' => 1])       ->setName('site.imovel.editar');
$router->add('/imoveis/remover/:params',        ['controller' => 'Imovel', 'action' => 'remover', 'params' => 1])       ->setName('site.imovel.remover');
$router->add('/imoveis/atualizar/:params',      ['controller' => 'Imovel', 'action' => 'atualizar', 'params' => 1])       ->setName('site.imovel.atualizar');
$router->add('/imoveis/listarbairros',			['controller' => 'Imovel', 'action' => 'listarbairros'])	->setName('site.imovel.listarbairros');
$router->add('/imoveis/validarcodigo',			['controller' => 'Imovel', 'action' => 'validarcodigo'])	->setName('site.imovel.validarcodigo');
$router->add('/imoveis/cadastrar',				['controller' => 'Imovel', 'action' => 'cadastrar'])	->setName('site.imovel.cadastrar');
$router->add('/imoveis/visualizar',				['controller' => 'Imovel', 'action' => 'visualizar'])	->setName('site.imovel.visualizar');
return $router;