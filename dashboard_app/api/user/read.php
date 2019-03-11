<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Acces-Control-Allow-Methods: GET');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $user = new User($db);

  // User query
  $result = $user->read();
  // Get row Count
  $num = $result->rowCount();

  // Check if any users
  if($num > 0) {

    // Create user array
    $users_arr = array();
    $users_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
          'id' => $id,
          'name' => $username,
          'company_name' => $company_name
        );

    // Push to 'data' in users_arr
    array_push($users_arr['data'], $user_item);
    }

    // Convert to JSON output
    echo json_encode($users_arr);

  } else {
    // No users
    echo json_encode(
        array('message' => 'No users found')
      );
  }

 ?>
