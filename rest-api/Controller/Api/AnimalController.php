<?php
class AnimalController extends BaseController {

    // Add the 'read' action to fetch all animals
    public function readAction() {
        $message = '';

        if (strtoupper($_SERVER["REQUEST_METHOD"]) == 'GET') {  
            try {
<<<<<<< HEAD
                global $conn; // Assuming $conn is your database connection
                $sql = "SELECT * FROM animals"; // Query all animals from the database
                $result = $conn->query($sql);
                
                // Check if there are any results
                if ($result->num_rows > 0) {
                    $animals = [];
                    while ($row = $result->fetch_assoc()) {
                        $animals[] = $row; // Add each animal to the array
                    }
                    // Return the animals as JSON
                    $responseData = json_encode($animals);
                } else {
                    $message = 'No animals found';
                    $responseData = json_encode([]);
                }
=======
                global $conn;

                $animalModel = new AnimalModel();
                $value = $animalModel->getPurchases();
                $responseData = json_encode($value);
>>>>>>> 37c2a579aed0c2b898f8496829f430b43e0a8560
            } catch (Error $e) {
                $message = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
            
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

<<<<<<< HEAD
        // Send output 
=======

        // send output 
>>>>>>> 37c2a579aed0c2b898f8496829f430b43e0a8560
        if (!$message) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $message)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
<<<<<<< HEAD
}
=======


    public function createAction() {
        $message = '';

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'POST') {    
            try{   
                global $conn;

                $input = json_decode(file_get_contents("php://input"), true);
                $username = $input['username'];
                $animal = $input['animal'];

                $animalModel = new AnimalModel();
                $sql = $animalModel->createPurchase($username, $animal);
                $responseData = json_encode($sql);
            } catch (Error $e) {
                $message = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$message) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $message)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    
    public function deleteAction() {
        $message = '';

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'DELETE') {    
            try{
                global $conn;

                $input = json_decode(file_get_contents("php://input"), true);
                $purchase_id = $input['purchase_id'];

                $animalModel = new AnimalModel();
                $value = $animalModel->deletePurchase($purchase_id);
                $responseData = json_encode($value);
            } catch (Error $e) {
                $message = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        if (!$message) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $message)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function updateAction() {
        $message = '';

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'PATCH') {    
            try{
                global $conn;
        
                $input = json_decode(file_get_contents("php://input"), true);
                $purchase_id = $input['purchase_id'];
                $animal = $input['animal'];
                
                $animalModel = new AnimalModel();
                $value = $animalModel->updatePurchase( $purchase_id, $animal);
                $responseData = json_encode($value);
            } catch (Error $e) {
                $message = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$message) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $message)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}


>>>>>>> 37c2a579aed0c2b898f8496829f430b43e0a8560
