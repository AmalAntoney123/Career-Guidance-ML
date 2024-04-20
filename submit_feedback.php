<?php
session_start(); // Start the session to access $_SESSION['user']
require 'vendor/autoload.php';

$userid = $_SESSION['user'];
// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$feedbackCollection = $careerDb->feedback;

// Receive the feedback data from the AJAX request
$rating = isset($_POST['rating']) ? $_POST['rating'] : null;
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : null;
// Insert the feedback data into the MongoDB collection
$insertResult = $feedbackCollection->insertOne([
    'user_id' => $userid,
    'rating' => $rating,
    'feedback' => $feedback,
    'timestamp' => new MongoDB\BSON\UTCDateTime()
]);

// Return a success response
echo 'Feedback submitted successfully.';
?>