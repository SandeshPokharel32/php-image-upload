<?php
$fileId = $_GET['id'];

$sql = "SELECT data FROM files WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $fileId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($fileData);
$stmt->fetch();

header("Content-type: image/jpeg"); // Adjust the content type based on the file type
echo $fileData;
?>