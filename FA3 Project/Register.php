<?php
// /php/register.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fa3";

$conn = new mysqli($servername, $username, $password, $dbname);

//access
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);




    // Check if the username or email already exists
    $checkStmt = $conn->prepare("SELECT * FROM registrations WHERE Username = ? OR Email = ?");
    $checkStmt->bind_param("ss", $user, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Proceed with registration
        $stmt = $conn->prepare("INSERT INTO registrations (Username, Email, Password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $email, $pass);

        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>