<?php
class AnimalController extends BaseController {
    /** 
* "/user/list" Endpoint - Get list of users 
*/
    public function listAction() {
        $message = '';
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'GET') {
            try {
                $userModel = new UserModel();

                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $message = $e->getMessage().'Something went wrong! Please contact support.';
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


    public function createAction($username, $animal) {
        $message = '';
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'POST') {    
            global $conn;
        
            $rowcount = "SELECT COUNT(*) FROM animals";
            $result = $conn->query($rowcount);
            $row = $result->fetch_assoc();
        
            $purchase_id = $row['COUNT(*)'] + 1;
        
            $currentTimestamp = date('Y-m-d H:i:s');
        
            $sql = "INSERT INTO `animals` (`purchase_id`, `username`, `animal`, `time_date`) VALUES (?, ?, ?, ?)";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $purchase_id, $username, $animal, $currentTimestamp);
            if ($stmt->execute()) {
                return "Congratulations! You can now talk to " . $animal . "s!     Your purchase ID is: " . $purchase_id . "Thank you for shopping with us today!";
            } else {
                echo("Uh oh, we couldn't complete your purchase: " . $conn->error);
            }
    }
}

    public function deleteAction() {
        $message = '';
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'DELETE') {    
            global $conn;

            $input = json_decode(file_get_contents("php://input"), true);
            $purchase_id = $input['purchase_id'];
            $sql = "DELETE FROM `animals` WHERE purchase_id=?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $purchase_id);

            if ($stmt->execute()) {
                return "your purchase successfully refunded";
            } else {
                echo("uh oh, we couldn't delete you bc: " . $conn->error); }
        }
    }


    public function updateAction($purchase_id, $animal) {
        $message = '';
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($_SERVER["REQUEST_METHOD"]) == 'PATCH') {    

            global $conn;
        
            $input = json_decode(file_get_contents("php://input"), true);
            $purchase_id = $input['purchase_id'];
            $animal = $input['animal'];
            
            $sql = "UPDATE animals SET animal=? WHERE purchase_id=?";

        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $animal,  $purchase_id);
        
            if ($stmt->execute()) {
                return "Your purchase has successfully been updated";
            } else {
                echo("Uh oh, we couldn't delete you because: " . $conn->error);
            }
    
        }
    }

}


