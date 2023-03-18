<?php
  
  namespace OakBase;
  
  class SideEffect {
    private int $last_inserted_ID, $row_count;
    
    
    
    public function __construct (int $liID, int $rc) {
      $this->last_inserted_ID = $liID;
      $this->row_count = $rc;
    }
  
    
    
    /**
     * @return int
     */
    public function last_inserted_ID(): int {
      return $this->last_inserted_ID;
    }
  
    
    
    /**
     * @return int
     */
    public function row_count(): int {
      return $this->row_count;
    }
  }