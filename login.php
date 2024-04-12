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
    $email = $_POST["email"]; // Corrected field name
    $password = $_POST["password"]; // Corrected field name
    
    // Check if email and password are provided
    if (!empty($email) && !empty($password)) {
        // Search for the user in MongoDB
        $user = $userCollection->findOne(["email" => $email]);

        if ($user && password_verify($password, $user['password'])) {
            // User found and password matches, login successful
            $_SESSION['user'] = $user['_id'];
            $_SESSION['user_name'] = ucfirst($user['full_name']);
            if ($user['full_name'] == "admin") {
                header("Location: user.php");
            } else {
                header("Location: user.php");
            }
            exit; // Added to stop further execution
        } else {
            // User not found or invalid credentials
            $_SESSION['register'] = "invalid";
            header("Location: signup.php");
            exit; // Added to stop further execution
        }
    } else {
        echo "Both email and password are required.";
    }
}