<?php
require_once './auth.php';
session_start();
if (!$_SESSION['user_id']) {
    header("Location: login.php");
    exit();  
}
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass, 'dbtest');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT f.*, u.username FROM files f
        JOIN users u ON f.users_id = u.id";
$result = mysqli_query($conn, $sql);
if($result){
    $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Files List</title>
    <style>
        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .card img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .card h4 {
            margin: 0;
            margin-bottom: 10px;
        }
        
        .card p {
            margin: 0;
            color: #888;
        }
        
        .no-files {
            text-align: center;
            color: #888;
        }
    </style>
    <link rel="Stylesheet" href="./assets/style.css"></link>
</head>
<body>
    <?php include 'nav.php'; ?>
    <h2>Files List</h2>
   <div>
   <?php if (!empty($files)) { ?>
        <?php foreach ($files as $file) { ?>
            <div class="card">
                <img src="<?php echo $file['name']; ?>" alt="File Image">
                <h4><?php echo $file['name']; ?></h4>
                <p>Uploaded by: <?php echo $file['username']; ?></p>
                <p>Date Uploaded: <?php echo $file['date_uploaded']; ?></p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="no-files">No files found.</p>
    <?php } ?>
   </div>
</body>
</html>