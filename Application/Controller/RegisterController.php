<?php
    namespace Controller;

    use model\classes\Query;
    use model\classes\Validate;

    /**
     * register a new user in the database. 
     */
    class RegisterController
    {        
        public function __construct(private object $dbcon)
        {
            
        }

        /* A method of the class `RegisterController` that is called when the user clicks on the
        register button. */
        public function register(): void
        {
            // Get values as elements of an array from register form
            $fields = [
                $name = $_REQUEST['name'] ?? "",
                $password = $_REQUEST['password'] ?? "",
                $password2 = $_REQUEST['password2'] ?? "",
                $email = $_REQUEST['email'] ?? "",
            ];
            
			try {
                $validate = new Validate();
                $ok = $validate->validate_form($fields);

				if ($ok) {
                    // Test that passwords are equals
                    $password !== $password2 ? throw new \Exception("Las contraseñas no coinciden", 1) : null;
                     
					$query = new Query();

					$rows = $query->selectAllBy("users", "email", $email, $this->dbcon);

					if ($rows) {
						throw new \Exception("El email '{$email}' ya está registrado", 1);																
					}
					else {
						$query = "INSERT INTO users (name, password, email) VALUES (:name, :password, :email)";                 
	
						$stm = $this->dbcon->pdo->prepare($query); 
						$stm->bindValue(":name", $name);
						$stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
						$stm->bindValue(":email", $email);              
						$stm->execute();       				
						$stm->closeCursor();						
		
						$success_msg = "El usuario se ha registrado correctamente";
						echo $success_msg;
					}										
				}
                else {
                    throw new \Exception("Todos los campos son requiridos", 1);                    
                }
				
			} catch (\Throwable $th) {			
				$error_msg = $th->getMessage();

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

				echo $error_msg;
				exit();
			}
        }
    }    
?>