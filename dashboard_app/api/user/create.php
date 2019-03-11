<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Acces-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $user = new User($db);

  // Get raw posted Data
  $data = json_decode(file_get_contents("php://input"));

  $user->username = $data->username;
  $user->password = $data->password;
  $user->companyid = $data->companyid;
  $user->role = $data->role;

  // Create User
  if($user->create()){
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Created')
    );
  }

?>
