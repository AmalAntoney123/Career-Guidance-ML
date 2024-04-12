<?php
require 'vendor/autoload.php';
session_start();
// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$userCollection = $careerDb->user;

// Get field and value from POST data
$field = $_POST['field'];
$value = $_POST['value'];

// Update document in MongoDB
$result = $userCollection->updateOne(
  ['_id' => new MongoDB\BSON\ObjectID($_SESSION['user'])],
  ['$set' => [$field => $value]]
);

if ($result->getModifiedCount() > 0) {
  echo 'Success';
} else {
  echo 'Failed';
}

?>
