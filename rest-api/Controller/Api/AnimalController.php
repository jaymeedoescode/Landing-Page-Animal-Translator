<?php
class AnimalController extends BaseController {

    // Add the 'read' action to fetch all animals
    public function readAction() {
        $message = '';
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($_SERVER["REQUEST_METHOD"]) == 'GET') {  
            try {
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
            } catch (Error $e) {
                $message = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $message = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // Send output 
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
