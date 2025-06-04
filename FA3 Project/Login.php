



<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password for XAMPP
$dbname = "fa3";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password']; // Do not hash the password here

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT Password FROM registrations WHERE Username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, now verify the password
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the hashed password
        if (password_verify($pass, $hashedPassword)) {
            // Successful login
            echo "Login successful! Welcome, " . htmlspecialchars($user) . ".";
            // Redirect to a welcome page or user dashboard
            // header("Location: welcome.php");
        } else {
            // Incorrect password
            echo "Invalid password. Please try again.";
        }
    } else {
        // User does not exist
        echo "User does not exist. Please create an account.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>