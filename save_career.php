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

// Check if a career already exists for the user
$existingCareer = $careerCollection->findOne(['user_id' => $userId]);

if ($existingCareer) {
    // Update the existing career
    $result = $careerCollection->updateOne(
        ['user_id' => $userId],
        ['$set' => ['career' => $selectedCareer]]
    );

    if ($result->getModifiedCount() > 0) {
        header('Location:career_view.php');
    } else {
        http_response_code(500);
        echo "Error saving career.";
    }
} else {
    // Save the new career to the MongoDB collection
    $result = $careerCollection->insertOne(['user_id' => $userId, 'career' => $selectedCareer]);

    if ($result->getInsertedCount() > 0) {
        header('Location:career_view.php');
    } else {
        http_response_code(500);
        echo "Error saving career.";
    }
}