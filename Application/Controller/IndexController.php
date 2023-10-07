<?php
    namespace Controller;

    use model\classes\Query;

    class IndexController
    {
        public function __construct(private object $dbcon)
        {
                        
        }
       
        /**
         * Retrieves all records from the "platos" table and returns them as a
         * JSON-encoded string.
         * 
         * @return string a JSON-encoded string representation of the "platos" data.
         */
        public function index(): void
        {                                      
            $query = new Query();

            $platos = $query->selectAll("platos", $this->dbcon);

            echo json_encode($platos);            
        }
    }    
?>  
