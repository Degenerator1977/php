<?php

    class Admin {
    
      //DB Stuff
      private $conn;
      private $table = 'users';

      // Admin user properties
      public $id;
      public $username;
      public $password;
      public $companyid;
      public $role;

      // Constructor
      public function __construct($db) {
          $this->conn = $db;
    }

    // Admin login
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

          if($row['role'] == 1) {

            return true;

          } else {
              return false;
          }

        } else {

          return false;
        }

      }

    }

  }   

?>
