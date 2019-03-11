<?php

  class Company {
    //DB Stuff
    private $conn;
    private $table = 'companys';

    // User properties
    public $id;
    public $name;
    public $category;

    // Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get companys
    public function read() {

      // Create Query
      $query = 'SELECT
            id,
            name,
            category
          FROM
          ' .$this->table. ' companys
          ORDER BY
            id ASC';

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
            id,
            name,
            category
          FROM
          ' .$this->table. ' companys
          WHERE
            id= ?
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
      $this->name = $row['name'];
      $this->category = $row['category'];
    }

    // Create Company
    public function create() {

      // Create query
      $query = 'INSERT INTO ' . $this->table .'
        SET
          name = :name,
          category = :category';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->category = htmlspecialchars(strip_tags($this->category));

      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':category', $this->category);

      // Execute statement
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Company
    public function update() {

      // Create query
      $query = 'UPDATE ' . $this->table .'
        SET
          name = :name,
          category = :category
        WHERE
          id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':id', $this->id);

      // Execute statement
      if($stmt->execute()){
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

  // Delete Company
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

}

 ?>
