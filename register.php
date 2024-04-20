<?php
session_start();
require 'vendor/autoload.php';

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$userCollection = $careerDb->user;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST["name"]; // Corrected field name
    $email = $_POST["email"]; // Corrected field name
    $password = $_POST["password"]; // Corrected field name
    $age = $_POST["age"]; // Corrected field name
    $gender = $_POST["gender"]; // Corrected field name
    $place = $_POST["place"]; // Corrected field name
    $educationLevel = $_POST["education_level"]; // Corrected field name

    // Check if all fields are provided
    if (!empty($fullName) && !empty($email) && !empty($password) && !empty($age) && !empty($gender) && !empty($place) && !empty($educationLevel)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare document to insert into MongoDB
        $document = [
            "full_name" => $fullName,
            "email" => $email,
            "password" => $hashedPassword, // Store hashed password
            "age" => $age,
            "gender" => $gender,
            "place" => $place,
            "education_level" => $educationLevel,
            "status" => "active",
            "timestamp" => new MongoDB\BSON\UTCDateTime()
        ];

        // Insert document into MongoDB collection
        $insertOneResult = $userCollection->insertOne($document);

        // Check if insertion was successful
        if ($insertOneResult->getInsertedCount() === 1) {
            $_SESSION['register'] = "success";
            header("Location: index.php");
            exit; // Added to stop further execution
        } else {
            echo "Error occurred while registering.";
        }
    } else {
        echo "All fields are required.";
    }
}
