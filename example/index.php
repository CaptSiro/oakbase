<?php
  
  use OakBase\BasicConfig;
  use OakBase\Database;
  use OakBase\PrimitiveParam;
  
  require_once __DIR__ . "/../src/Database.php";
  require_once __DIR__ . "/../src/config/BasicConfig.php";
  require_once __DIR__ . "/../src/parameter/PrimitiveParam.php";
  require_once __DIR__ . "/../src/parameter/NamedPrimitiveParam.php";
  
  Database::configure(new BasicConfig(
    "localhost",
    "database",
    "root",
    "pass_1234"
  ));
  
  
  
  $id = new PrimitiveParam(7);
  
  var_dump(Database::get()->fetch_all("
    SELECT *
    FROM table
    WHERE id >= $id
  ")); // stdClass used as default
  
  
  
  
  // used custom class as a result type
  
  class Article {}
  
  $name = new PrimitiveParam("title; INSERT INTO table (title) VALUE ('not wanted query')");
  
  var_dump(Database::get()->fetch_all("
    SELECT *
    FROM table
    WHERE `table`.title = $name
  ", Article::class));
  
  
  
  $title = new PrimitiveParam("insert");
  $content = new PrimitiveParam(NULL);
  $number = new PrimitiveParam(69);
  
  var_dump(Database::get()->statement("
    INSERT INTO table (title, content, number) VALUE ($title, $content, $number)
  "));