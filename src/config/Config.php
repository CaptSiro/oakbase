<?php
  
  namespace OakBase;
  
  interface Config {
    /**
     * Getter for HOST parameter for database connection string
     *
     * @return string
     */
    function host(): string;
  
  
  
    /**
     * Getter for PORT parameter for database connection string
     *
     * @return string
     */
    function port(): string;
  
  
  
    /**
     * Getter for DBNAME parameter for database connection string
     *
     * @return string
     */
    function database_name(): string;
  
  
  
    /**
     * Getter for CHARSET parameter for database connection string
     *
     * @return string
     */
    function charset(): string;
  
  
  
    /**
     * Getter for USER argument for PDO constructor
     *
     * @return string
     */
    function user(): string;
  
  
  
    /**
     * Getter for PASSWORD argument for PDO constructor
     *
     * @return string
     */
    function password(): string;
  }