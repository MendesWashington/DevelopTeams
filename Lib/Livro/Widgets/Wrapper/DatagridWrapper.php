<?php
namespace Livro\Widgets\Wrapper;
use Livro\Widgets\Datagrid\Datagrid;
use Livro\Widgets\Base\Element;

/**
 * Decora datagrids no formato Bootstrap
 */
class DatagridWrapper{

    private $decorated;
    /**
     * Constrói o decorator
     */
    public function __construct(Datagrid $datagrid){

        $this->decorated = $datagrid;
        $this->decorated->class = 'table table-dark table-hover';    
    }
    
    /**
     * Redireciona chamadas para o objeto decorado
     */
    public function __call($method, $parameters){

        return call_user_func_array(array($this->decorated, $method),$parameters);
    }
    
    /**
     * Redireciona alterações em atributos
     */
    public function __set($attribute, $value){

        $this->decorated->$attribute = $value;
    }
}