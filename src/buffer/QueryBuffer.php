<?php
  
  namespace OakBase;
  
  require_once __DIR__ . "/Buffer.php";
  require_once __DIR__ . "/BufferDefault.php";
  
  class QueryBuffer implements Buffer {
    use BufferDefault;
  }