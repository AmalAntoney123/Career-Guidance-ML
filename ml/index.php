<?php
// Ensure that the POST data you're passing is properly sanitized
// For demonstration purposes, I'm using htmlspecialchars to prevent XSS attacks
$value1 = htmlspecialchars("hello");
$value2 = htmlspecialchars("world");
// Add more variables as needed

// Construct the command with POST values as arguments to the Python script
$command = escapeshellcmd('python ml_recommend.py ' . escapeshellarg($value1) . ' ' . escapeshellarg($value2));
// Add more arguments as needed

// Execute the command
$output = shell_exec($command);

// Output the result
echo $output;

