<?php

require_once PROJECT_ROOT_PATH . "/Model/AnimalModel.php";

class AnimalController extends BaseController {

    // Add the 'read' action to fetch all animals
    public function readAction() {
        $message = '';

        if (strtoupper($_SERVER["REQUEST_METHOD"]) == 'GET') {  
            try {

                global $config;
                $animalModel = new AnimalModel();
                $value = $animalModel->getPurchases();
                $responseData = json_encode($value);
                
            } catch (Error $e) {
                $message = $e->getMessage().' Something went wrong! Please contact support.';
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
                global $config;

                $input = json_decode(file_get_contents("php://input"), true);
                $username = $input['username'] ?? null;
                $animal = $input['animal'] ?? null;

                $animalModel = new AnimalModel();
                $rowcount = "SELECT count(*) FROM animals";
                $result = $config->query($rowcount);
                $row = $result->fetch_assoc();
        
                $purchase_id = $row['count(*)'] + 1;
        
                $currentTimestamp = date('Y-m-d H:i:s');
                $sql = $animalModel->createPurchase($purchase_id, $username, $animal, $currentTimestamp);
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
                global $config;

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
                global $config;
        
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