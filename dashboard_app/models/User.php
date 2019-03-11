<?php

header('Content-Type: application/json');

// Require the JWT package
include_once '../../vendor/autoload.php';
use Firebase\JWT\JWT;

  class User {
    //DB Stuff
    private $conn;
    private $table = 'users';

    // User properties
    public $id;
    public $username;
    public $password;
    public $companyid;

    // Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get users
    public function read() {

      // Create Query
      $query = 'SELECT
            c.name as company_name,
            u.id,
            u.username
          FROM
          ' .$this->table. ' u
          LEFT JOIN
            companys c ON u.companyid = c.id
          ORDER BY
            u.id ASC';

      // Prepared statement
      $stmt = $this->conn->prepare($query);

      // Execute statement
      $stmt->execute();

      return $stmt;
    }

    // Get single user
    public function read_single() {

      // Create Query
      $query = 'SELECT
            c.name as company_name,
            u.id,
            u.username
          FROM
          ' .$this->table. ' u
          LEFT JOIN
            companys c ON u.companyid = c.id
          WHERE
            u.id= ?
          LIMIT 0,1';

      // Prepared statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute statement
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->username = $row['username'];
      $this->company_name = $row['company_name'];
    }

    // Create User
    public function create() {

      // Create query
      $query = 'INSERT INTO ' . $this->table .'
        SET
          username = :username,
          password = :password,
          companyid = :companyid,
          role = :role';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->password = md5($this->password);
      $this->companyid = htmlspecialchars(strip_tags($this->companyid));
      $this->role = htmlspecialchars(strip_tags($this->role));

      // Bind data
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':companyid', $this->companyid);
      $stmt->bindParam(':role', $this->role);

      // Execute statement
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update User
    public function update() {

      // Create query
      $query = 'UPDATE ' . $this->table .'
        SET
          username = :username,
          password = :password,
          companyid = :companyid
        WHERE
          id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->password = htmlspecialchars(stripslashes($this->password));
      $this->companyid = htmlspecialchars(strip_tags($this->companyid));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':companyid', $this->companyid);
      $stmt->bindParam(':id', $this->id);

      // Execute statement
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

  // Delete User
  public function delete() {

    // Create Query
    $query = 'DELETE FROM ' . $this->table .' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute statement
    if($stmt->execute()){
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // User login
  public function login() {

    // Create query
    $query = 'SELECT * FROM ' . $this->table .' WHERE username = :username';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->password = md5($this->password);

    // Bind data
    $stmt->bindParam(':username', $this->username);

    // Execute statement
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return true if username exists, false otherwise
    if($row > 0) {

      // Check password matches
      if($this->password == $row['password']) {

        // Set variables for returned JWT
        $id = $row['id'];
        // Set exp time for token to current time stamp + 60 minutes
        $expTime = time() + 60*60;
        $serverKey = 'pineapple';

        // Package JWT
        $payloadArray = array();
        $payloadArray['id'] = $id;
        $payloadArray['exp'] = $expTime;
        $token = JWT::encode($payloadArray, $serverKey);

        // Return JWT
        $returnArray = array('code' => '200', 'status' => 'Success', 'message' => 'Valid login credentials', 'token' => $token);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        echo $jsonEncodedReturnArray;

        return true;

      } else {

        return false;
      }

    }

  }

  // Auth for API queries
  public function auth() {

  }

}

?>
