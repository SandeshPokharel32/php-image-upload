<?php
require_once './auth.php';

session_start();
if (!$_SESSION['user_id']) {
    header("Location: login.php");
    exit();  
}

  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $background = $_FILES['bg']['tmp_name'];
    $hobbies = $_POST['hobbies'];
    $profile = $_FILES['profile']['tmp_name'];
    $description = $_POST['description'];

    // Database connection parameters
    $host = 'mysql';
    $user = 'root';
    $pass = 'rootpassword';
    $dbname = "dbtest";

    // Create a connection to the database
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check if the connection is successful
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert data into the user table
    $stmt = $conn->prepare("UPDATE users SET background= ?, hobbies= ?, profile= ?, description= ? where id = ?;");

    if ($stmt) {
        $backgroundData = file_get_contents($background);
        $profileData = file_get_contents($profile);
        // Bind parameters and execute the query
        $stmt->bind_param("bsssi", $backgroundData, $hobbies, $profileData, $description, intval($_SESSION['user_id']));
        // Read the background and profile images as binary data
        
        // Execute the query
        if ($stmt->execute()) {
          echo "Data saved successfully.";
        } else {
          echo "Error: " . $stmt->error;
        }
  
        // Close the statement
        $stmt->close();
      } else {
        echo "Error: " . $conn->error;
      }
    $conn->close();
  }
  ?>

<!DOCTYPE html>
<html>
<head>
  <title>User Form</title>
</head>
<body>
  

  <h1>User Form</h1>

  <form method="post" enctype="multipart/form-data">
    <label for="background">Background Image:</label>
    <input type="file" name="bg" id="bg" accept="image/*" required><br><br>

    <label for="hobbies">Hobbies:</label>
    <input type="text" name="hobbies" id="hobbies" required><br><br>

    <label for="profile">Profile Image:</label>
    <input type="file" name="profile" id="profile" accept="image/*" required><br><br>

    <label for="description">Description:</label><br>
    <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>

    <input type="submit" value="Submit">
  </form>
</body>
</html>