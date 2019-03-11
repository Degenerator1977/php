<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');


include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB
$database = new Database();
$db = $database->connect();

// Instantiate user object
$user = new User($db);

// Get raw posted Data
$data = json_decode(file_get_contents("php://input"));

// Get data
$user->username = htmlspecialchars($data->username);
$user->password = htmlspecialchars($data->password);
$user->company = htmlspecialchars($data->company);


// Check required fields
if(!empty($user->username)  && !empty($user->password) && !empty($user->company)) {

    // Set property values
    $username = $user->username;
    $password = $user->password;
    $company = $user->company;

    // Check if username exists
    if($user->login()){



    } else {

        http_response_code(401);

        echo json_encode(array
            (
                "message" => "Failed Login."
            )
        );

    }
} else {

    // Failed to fill in all form fields
    http_response_code(401);

    echo json_encode(array
        (
            "message" => "Missing login details."
        )
    );
}

?>
