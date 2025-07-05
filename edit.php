
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include 'db.php';
$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $Status = isset($_POST['Status']) ? $_POST['Status'] : 'available';

  $price = $_POST['price'];
  $discount_price = $_POST['discount_price'];
  $discount_price = is_numeric($discount_price) ? $discount_price : 'NULL';  // 👈 This line prevents the error

  if ($_FILES['image']['name']) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    $conn->query("UPDATE products SET name='$name', category='$category', price='$price', discount_price=$discount_price, image='$image', Status='$Status' WHERE id=$id");
  } else {
    $conn->query("UPDATE products SET name='$name', category='$category', price='$price', discount_price=$discount_price, Status='$Status' WHERE id=$id");
  }

  header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <style>
    body { font-family: Poppins, sans-serif; padding: 2rem; }
    input, select { width: 100%; padding: 0.5rem; margin: 0.5rem 0; }
    .btn { padding: 0.5rem 1rem; background: #000; color: white; border: none; border-radius: 5px; }
  </style>
</head>
<body>

<h2>Edit Product</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" value="<?= $product['name'] ?>" required>
  <select name="category">
    <option <?= $product['category'] == 'Jeans' ? 'selected' : '' ?>>Jeans</option>
    <option <?= $product['category'] == 'Kurti' ? 'selected' : '' ?>>Kurti</option>
    <option <?= $product['category'] == 'Tops' ? 'selected' : '' ?>>Tops</option>
    <option <?= $product['category'] == 'Dress' ? 'selected' : '' ?>>Dress</option>
  </select>
  <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01">
  <input type="number" name="discount_price" value="<?= $product['discount_price'] ?>" step="0.01">
   <h2>Stock</h2>
<select name="Status" required>
  <option value="available" <?= $product['Status'] == '' ? 'selected' : '' ?>>Available</option>
  <option value="soldout" <?= $product['Status'] == 'soldout' ? 'selected' : '' ?>>Sold Out</option>
</select>
  <input type="file" name="image">
  <button name="update" class="btn">Update</button>
</form>

</body>
</html>
