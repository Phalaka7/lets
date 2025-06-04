<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fa3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $names = $_POST['names'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (name, email, messages) VALUES (?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sss", $names, $email, $message);
    
        if ($stmt->execute()) {
            echo "Data Added Successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close(); 
    } else {
        echo "Prepare Error: " . $conn->error;
    }
    

    $conn->close();
}
?>
