<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Company.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate company object
  $company = new Company($db);

  // Get ID
  $company->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get single user
  $company->read_single();

  // Create array
  $company_arr = array(
    'id' => $company->id,
    'name' => $company->name,
    'category' => $company->category
  );

  // Make Json
  print_r(json_encode($company_arr));

?>
