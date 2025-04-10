<?php
class UserController extends BaseController {
    /** 
* "/user/list" Endpoint - Get list of users 
*/
    public function listAction() {
        $message = '';

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'GET') {
            try {
                global $conn;

                $animalModel = new AnimalModel();
                $value = $animalModel->getPurchases();
                $responseData = json_encode($value);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
            
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }


        // send output 
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
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
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
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
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
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
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


