<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $user = new User($db);

  // Get ID
  $user->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get single user
  $user->read_single();

  // Create array
  $user_arr = array(
    'id' => $user->id,
    'name' => $user->username,
    'company_name' => $user->company_name
  );

  // Make Json
  print_r(json_encode($user_arr));

?>
