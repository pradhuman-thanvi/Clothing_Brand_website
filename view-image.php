<?php
require 'db.php'; // make sure this connects to your DB

$id = $_GET['id'] ?? null;

if (!$id) {
    die("No product ID provided.");
}

$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

if (!$image) {
    die("Image not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Image</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #f9f9f9;
        }
        .image-container {
            width: 500px;
            height: 700px;
            border: 2px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            border-radius: 10px;
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="uploads/<?= htmlspecialchars($image) ?>" alt="Product Image">
    </div>
</body>
</html>