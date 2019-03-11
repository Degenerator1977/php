<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Company.php';

  // Instantiate DB
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $company = new Company($db);

  // Company query
  $result = $company->read();
  // Get row Count
  $num = $result->rowCount();

  // Check if any companys
  if($num > 0) {

    // Create company array
    $companys_arr = array();
    $companys_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $company_item = array(
          'id' => $id,
          'name' => $name,
          'category' => $category
        );

    // Push to 'data' in companys_arr
    array_push($companys_arr['data'], $company_item);
    }

    // Convert to JSON output
    echo json_encode($companys_arr);

  } else {
    // No companys
    echo json_encode(
        array('message' => 'No companys found')
      );
  }

 ?>
