<?php
require_once './auth.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();  
}
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass, 'dbtest');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Check if a file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Retrieve file information
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        echo $fileTmpName;
        // Read the file data
        $fileData = file_get_contents($fileTmpName);

        // Copy the file to the target directory
        if (move_uploaded_file($fileTmpName, './'.$fileName)) {
            echo "File uploaded and copied successfully to: " . $targetFilePath . "<br>";
        } else {
            echo "Error copying file to: " . $targetFilePath . "<br>";
        }

        // Insert file information into the database
        $sql = "INSERT INTO files (name, type, size, data) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $fileName, $fileType, $fileSize, $fileData);

        if ($stmt->execute()) {
            echo "File uploaded and saved to the database successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No file was uploaded or an error occurred.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sliding Photo Gallery</title>
  <link rel="Stylesheet" href="./assets/style.css"></link>
</head>

<body>
   <?php include 'nav.php'; ?>
  <div class="container">
  
    <h2>Save Image</h2>
    <form action="save.php" method="POST" enctype="multipart/form-data">
        <label for="img">Select image:</label>
        <input type="text" id="name" name="name" >
        <input type="file" id="file" name="file" accept="image/*">
        <input type="submit">
    </form>
  </div>
  <script src="./assets/script.js"></script>

</body>
</html>
