<?php
    namespace Controller;

    use PDO;
	use Controller\IndexController;
    use model\classes\Validate;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController
    {       
		public function __construct(private object $dbcon)
        {
                        
        }
		
        public function login(array $language = null): void
        {
            // recogemos los datos del formulario
            $fields = [
                $email = $_REQUEST['email'] ?? "",
			    $password = $_REQUEST['password'] ?? "",
            ];            
						
			if(!isset($_SESSION['id_user'])) {	
                $validate = new Validate();
                $ok = $validate->validate_form($fields);

				if($ok) {
					// hacemos la consulta a la DB				
					$query = "SELECT * FROM users  WHERE email = :val";

					try {
						$stm = $this->dbcon->pdo->prepare($query);
						$stm->bindValue(":val", $email);				
						$stm->execute();					

						// si encuentra el usuario en la DB
						if($stm->rowCount() == 1) {
							$result = $stm->fetch(PDO::FETCH_ASSOC);					
							
							// comprueba que la contraseña introducida coincide con la de la DB
							if(password_verify($password, $result['password'])) {												
								$_SESSION['id_user'] = $result['id'];						
								$_SESSION['user_name'] = $result['name'];
								//$_SESSION['role'] = $result['role'];												
								$stm->closeCursor();
																
								//header("Location: /");
                                echo json_encode($result);							
							}
							else {
								throw new \Exception("Tus credenciales no son correctas.", 1);                                												
							}			
						}
						else {		
							throw new \Exception("Comprueba tus credenciales.", 1);
                            																		
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
					}	
				}									
			}
			else {		
				//header("Location: /");
			}									
        }

        /* Unsetting the session variables and destroying the session. */
        public function logout(): void
        {
            unset($_SESSION['id_user']);
			unset($_SESSION['user_name']);
			unset($_SESSION['role']);			
		  
			$_SESSION = array();
		  
			session_destroy();
			setcookie('PHPSESSID', "0", time() - 3600);		  			            

			header("Location: /");	
        }
    }    
?>