<?php
require_once './auth.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();  
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform login validation
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (authenticateUser($username, $password)) {
        loginUser($username);
        exit();
    } else {
        echo "Invalid username or password!";
    }
}else{
    $username = getCurrentUsername();
}
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
     <h2>Sliding Photo Gallery</h2>
    <div class="gallery">
        <?php
            $host = 'mysql';
            $user = 'root';
            $pass = 'rootpassword';
            $conn = new mysqli($host, $user, $pass, 'dbtest');
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            // SQL query to fetch the file information
            $sql = "SELECT name, type, size FROM files";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $fileName = $row["name"];
                    $fileType = $row["type"];
                    $fileData = $row["data"];
                    // Generate the base64 image source
                    $base64Image = 'data:' . $fileType . ';base64,' . base64_encode($fileData);
                    echo  "<img src='".$fileName."' alt='".$fileName."'><br>";
                }
            } else {
                echo "No files found in the database.";
            }
            $conn->close();
        ?>
     
      <img src="photo2.jpg" alt="Photo 2">
      <img src="photo3.jpg" alt="Photo 3">
    </div>

    <div class="gallery-controls">
      <button onclick="prevPhoto()">Previous</button>
      <button onclick="nextPhoto()">Next</button>
    </div>
  </div>
  <script src="./assets/script.js"></script>

</body>
</html>