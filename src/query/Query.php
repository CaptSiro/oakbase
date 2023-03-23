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
  }