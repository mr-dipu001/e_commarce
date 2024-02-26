<?php
// Include the database connection file
include 'database_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $username = $password = "";
    
    // Processing form data when form is submitted
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Validate credentials
    $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_username);
        
        // Set parameters
        $param_username = $username;
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();
            
            // Check if username exists, if yes then verify password
            if ($stmt->num_rows == 1) {                    
                // Bind result variables
                $stmt->bind_result($user_id, $username, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["username"] = $username;
                        
                        // Redirect user to welcome page
                        header("location: welcome.php");
                    } else {
                        // Display an error message if password is not valid
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                $login_err = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
}
?>
