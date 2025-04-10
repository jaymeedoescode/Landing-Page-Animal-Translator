<?php
class UserController extends BaseController {
    /** 
* "/user/list" Endpoint - Get list of users 
*/
    public function listAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();

                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    public function createAction($username, $animal) {
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
                die("Uh oh, we couldn't complete your purchase: " . $conn->error);
            }
    }

    public function deleteAction($purchase_id) {
        global $conn;

        $sql = "DELETE FROM `animals` WHERE purchase_id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $purchase_id);

        if ($stmt->execute()) {
            return "your purchase successfully refunded";
        } else {
            die("uh oh, we couldn't delete you bc: " . $conn->error); }
    }


    public function updateAction($purchase_id, $animal) {

        global $conn;
    
        $sql = "UPDATE (animal) FROM animals WHERE purchase_id=?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $animal,  $purchase_id);
    
        if ($stmt->execute()) {
            return "Your purchase has successfully been updated";
        } else {
            die("Uh oh, we couldn't delete you because: " . $conn->error);
        }
    
    }

}


