<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/news.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare news object
$news = new News($db);

// set ID property of record to read
$news->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of news to be edited
$news->readOne();

if ($news->id != null) {
  var_dump($news);
  die();
  // create array
  $news_arr = array(
    "id" => $news->$id,
    "title" => $news->$title,
    "summary" => $news->$summary, // REVIEW
    "body" => $news->$body,
    "date" => $news->date,
    "author" => $news->$author,
    "users_id" => $news->$users_id

  );

  //array_push($news_arr,$news_item);

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($news_arr, JSON_PRETTY_PRINT);
} else {
  // set response code - 404 Not found
  http_response_code(404);

  // tell the user news does not exist
  echo json_encode(array("message" => "News does not exist."));
}
