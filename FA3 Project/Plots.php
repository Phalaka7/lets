<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property_title = $_POST['property_title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handling file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["property_image"]["name"]);
    // move_uploaded_file($_FILES["property_image"]["tmp_name"], $target_file);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'tickethub');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert property into the database
    $sql = "INSERT INTO plots (title, location, price, description, image) 
            VALUES ('$property_title', '$location', '$price', '$description', '$target_file')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Plot added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
