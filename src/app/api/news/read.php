<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/news.php';

// instantiate database and news object
$database = new Database();
$db = $database->getConnection();

// READ ONE NEWS
// $read_id = $_GET["id"]; // NOTE READme insert
// $read_users_id = $_GET["users_id"]; // NOTE READme insert

// initialize object
$news = new News($db); //, $read_id, $read_users_id);

/// query news
$stmt = $news->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
  // news array
  $news_arr = array(); // REVIEW
  
  // retrieve our table contents
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);

    $news_item = array(
      "id" => $id,
      "title" => $title,
      "summary" => $summary, // REVIEW
      "body" => $body,
      "date" => $date,
      "author" => $author,
      "users_id" => $users_id
    );
    
    array_push($news_arr,$news_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data in json format
  echo json_encode($news_arr, JSON_PRETTY_PRINT);
} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user no products found
  echo json_encode(
    array("message" => "No users found.")
  );
}
