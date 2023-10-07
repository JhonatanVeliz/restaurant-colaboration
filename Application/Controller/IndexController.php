<?php
    namespace Controller;

    use model\classes\Query;
    use model\classes\Validate;

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

        /**
         * Inserts the values into 'platos' table, and echoes a message indicating that the data has
         * been saved.
         */
        function create() : void 
        {            
            // Create an object to validate inputs
            $validate = new Validate();            

            // Get values from form
            $fields = [
                "name"          => $validate->test_input($_POST['name']),
                "description"   => $validate->test_input($_REQUEST['description']),
                "price"         => $validate->test_input($_REQUEST['price']),
            ];
            
            $query = new Query();

            // Save values
            $query->insertInto('platos', $fields, $this->dbcon);

            echo "Saved successfully";           
        }
    }    
?>  
