<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/QueryBuilder.php";
  require_once __DIR__ . "/../buffer/Buffer.php";
  
  class Query {
    protected string $string;
    
    public function string (): string {
      return $this->string;
    }
    
    protected Buffer $params;
  
    public function params (): Buffer {
      return $this->params;
    }
    
    
    
    public function __construct (string $string, Buffer $params) {
      $this->string = $string;
      $this->params = $params;
    }
    
    
    
    public static function build (): QueryBuilder {
      return new QueryBuilder();
    }



    /**
     * To be able to use this function you need to use ***named params*** in query
     *
     * @param NamedPrimitiveParam $param
     * @return bool Returns false if the param's name is not present in query
     */
    function set (NamedPrimitiveParam $param): bool {
      if ($this->params->exists($param->name())) {
          return false;
      }

      $this->params->set($param->name, $param);

      return true;
    }
  }