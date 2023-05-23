<?php
require_once './auth.php';

session_start();
if (!$_SESSION['user_id']) {
    header("Location: login.php");
    exit();  
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'mysql';
    $user = 'root';
    $pass = 'rootpassword';
    $conn = new mysqli($host, $user, $pass, 'dbtest');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
   // Check if a file was uploaded
   if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Retrieve file information
    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    
    // Read the file data
    $fileData = file_get_contents($fileTmpName);
    
    // Copy the file to the target directory
    if (move_uploaded_file($fileTmpName, './'.$fileName)) {
        echo "File uploaded and copied successfully to: " . $targetFilePath . "<br>";
    } else {
        echo "Error copying file to: " . $targetFilePath . "<br>";
    }
    echo  "sdfesd".$_SESSION['user_id'];
    // Insert file information into the database
    $sql = "INSERT INTO files (name, type, size, data, users_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Handle the error if the prepare statement fails
        echo "Error: " . $conn->error;
    } else {
        // Bind the parameters and execute the statement
        $stmt->bind_param("ssisi", $fileName, $fileType, $fileSize, $fileData, intval($_SESSION['user_id']));
        
        if ($stmt->execute()) {
            echo "File uploaded and saved to the database successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    } else {
        echo "No file was uploaded or an error occurred.";
    }
    $conn->close();

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sliding Photo Gallery</title>
  <link rel="Stylesheet" href="./assets/style.css"></link>
  <style>
    .upload-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .upload-button {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .upload-button:hover {
            background-color: darkgreen;
        }
        
        /* Hide the file input */
        input[type="file"] {
            /* display: none; */
        }
  </style>
</head>

<body>
   <?php include 'nav.php'; ?>
  <div class="container">
  
    <h2>Save Image</h2>
    <form action="save.php" method="POST" enctype="multipart/form-data">
        <div class="upload-container">
            <label for="file" class="upload-button">Select image</label>
            <input type="file" id="file" name="file" accept="image/*">
        </div>
        <input type="submit" class="upload-button" value="Upload">
    </form>
  </div>
  <script src="./assets/script.js"></script>

</body>
</html>
