<?php
class News
{

  // database connection and table name
  private $conn;
  // private $read_id;
  // private $read_users_id;


  // object properties
  public $id;
  public $title;
  public $summary;
  public $body;
  public $date;
  public $author;
  public $users_id;

  // constructor with $db as database connection
  public function __construct($db) //, $read_id, $read_users_id)
  {
    $this->conn = $db;
    // $this->$read_id = $read_id;
    // $this->$read_users_id = $read_users_id;
  }
  // read products
  function read()
  {
    // $where = "WHERE";
    // if ($this->$read_id){
    //   $where = $where . "id = " . $this->$read_id;
    // } if ($this->$read_users_id) {
    //   $where = $where . "users_id = " . $this->$read_users_id;
    // }
    // select all query
    $query = "SELECT
              id, title, summary, body, date, author, users_id
          FROM
              news
              ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }


  function readOne()
  {

    // query to read single record
    $query = "SELECT
              id, title, summary, body, date, author, users_id
          FROM
              news
          WHERE
              id = ?
          ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->id = $row['id'];
    $this->title = $row['title'];
    $this->summary = $row['summary'];
    $this->body = $row['body'];
    $this->date = $row['date'];
    $this->author = $row['author'];
    $this->users_id = $row['users_id'];
  }
}
