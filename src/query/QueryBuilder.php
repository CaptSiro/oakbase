<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/../buffer/ParamBuffer.php";
  require_once __DIR__ . "/../buffer/QueryBuffer.php";
  
  class QueryBuilder {
    private array $temp;
    private Buffer $params;
    
    
    
    public function __construct() {
      $this->temp = ParamBuffer::get()->dump();
      $this->params = new QueryBuffer();
    }
    
    
    
    public function use(string $query): Query {
      $this->params->load(
        ParamBuffer::get()->dump()
      );
      
      ParamBuffer::get()->load($this->temp);
      
      return new Query($query, $this->params);
    }
  }