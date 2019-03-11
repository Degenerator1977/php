<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Acces-Control-Allow-Methods: DELETE');
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

  // Set ID to update
  $user->id = $data->id;

  // Delete User
  if($user->delete()){
    echo json_encode(
      array('message' => 'User Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Deleted')
    );
  }

?>
