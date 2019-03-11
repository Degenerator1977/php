<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Acces-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Company.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $company = new Company($db);

  // Get raw posted Data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $company->id = $data->id;

  $company->name = $data->name;
  $company->category = $data->category;

  // Create User
  if($company->update()){
    echo json_encode(
      array('message' => 'Company Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Company Not Updated')
    );
  }

?>
