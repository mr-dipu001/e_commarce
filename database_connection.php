<?php
$servername = "localhost"; // Change this to your server if it's hosted elsewhere
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "ecom"; // Change this to the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; // This is just for testing purposes, remove it in production
?>
