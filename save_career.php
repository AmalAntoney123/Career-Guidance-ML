<?php
session_start(); 
require 'vendor/autoload.php';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$careerCollection = $careerDb->career;

// Get the selected career and user ID from the AJAX request
$selectedCareer = $_POST['career'];
$userId = new MongoDB\BSON\ObjectId($_POST['user_id']);

// Save the career to the MongoDB collection
$result = $careerCollection->insertOne(['user_id' => $userId, 'career' => $selectedCareer]);

if ($result->getInsertedCount() > 0) {
    header('Location:career_view.php');
} else {
    http_response_code(500);
    echo "Error saving career.";
}
