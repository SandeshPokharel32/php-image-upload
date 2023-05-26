<!DOCTYPE html>
<html>
<head>
  <title>User Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .profile {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .profile img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-right: 20px;
      float: left;
    }

    .profile h2 {
      margin-top: 0;
      margin-bottom: 10px;
      color: #333;
    }

    .profile p {
      margin: 0;
      color: #666;
    }
  </style>
</head>
<body>
  <?php
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

  // Retrieve the ID from the URL
  $id = $_GET['id'];

  // Prepare and execute the SQL query to retrieve user information based on the ID
  $stmt = $conn->prepare("SELECT background, hobbies, profile, description FROM users WHERE id = ?");
    if($stmt){
        echo 'here'.$_SESSION['id'].'';
        $stmt->bind_param("i", intval($id));
        $stmt->execute();
        $stmt->bind_result($bg, $hobbies, $profile, $description);
        $stmt->fetch();
        // Close the statement and connection
        $stmt->close();
    }
    
  $conn->close();
  ?>

  <div class="profile">
    <img src="data:image/jpeg;base64,<?= base64_encode($profile) ?>" alt="Profile Picture">
    <h2>User Profile</h2>
    <p><strong>Description:</strong> <?= $description ?></p>
    <p><strong>Hobbies:</strong> <?= $hobbies ?></p>
  </div>

  <style>
    body {
      background-image:url('<?= $bg ?>');
      background-size: cover;
    }
  </style>
</body>
</html>