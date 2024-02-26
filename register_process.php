<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input (you can add more validation as needed)
    $username = htmlspecialchars(trim($username));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Example: Save data to a database
    // Replace this with your actual database connection and query
    $servername = "localhost";
    $db_username = "your_username";
    $db_password = "your_password";
    $dbname = "your_database";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
