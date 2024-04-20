<?php
session_start(); // Start the session to access $_SESSION['user']
require 'vendor/autoload.php';
// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$userCollection = $careerDb->user;

// Get the user ID and new status from the AJAX request
$userId = $_POST['userId'];
$isActive = $_POST['isActive'] === 'true';

// Update the document in the MongoDB collection
$updateResult = $userCollection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($userId)],
    ['$set' => ['isActive' => $isActive]]
);

// Return a response
if ($updateResult->getModifiedCount() > 0) {
    echo 'Status updated successfully';
} else {
    echo 'Error updating status';
}
?>