<?php
  include_once('database.php');
  ?>
<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('location:admin_login.php');
    exit();
  }
 ?>
 <?php
  //Add items to Inventory
  if (isset($_POST['product_name'])) {
        $product_name = mysqli_real_escape_string($dbcon, $_POST['product_name']);
        $price = mysqli_real_escape_string($dbcon, $_POST['price']);
        $category =  mysqli_real_escape_string($dbcon, $_POST['category']);
        $details = mysqli_real_escape_string($dbcon, $_POST['details']);
  //Check if product name already exists
        $sql = "SELECT * FROM products WHERE product_name = '$product_name'";
        $result = mysqli_query($dbcon, $sql);
        $product_exists = mysqli_num_rows($result);
        if ($product_exists > 0) {
          echo "Product Name already exists";
          exit();
        }
//Insert Product data to database
        $sql = "INSERT INTO products (product_name, price, category, details)
          VALUES ('$product_name', '$price', '$category', '$details')";
        $result = mysqli_query($dbcon, $sql);
//Assign product id as image name
        $pid = mysqli_insert_id($dbcon);
        $imagename = "$pid.jpg";
        move_uploaded_file($_FILES['image']['tmp_name'], "images/$imagename");
        header('location:admin_index.php');
        exit();
  }

  ?>
 <?php
  //Display Inventory items
  $product_list = "";
  $sql = "SELECT * FROM products ";
  $result = mysqli_query($dbcon, $sql);
  $product_count = mysqli_num_rows($result);
  if ($product_count > 0) {
    while ($row = mysqli_fetch_array($result)) {
      $id = $row['id'];
      $product_name = $row['product_name'];
      $price = $row['price'];
      $product_list .= "<h3> $id : $product_name : $.$price &nbsp;
      &bull; <a href='admin_index.php?deleteID=$id'>Delete</a> &bull; <a href ='edit_inventory.php?editID=$id'>Edit</a></h3>";
  }
}else {
  $product_list = "<h3>You do not have any items</h3>";
}
?>
<?php
//Delete Inventory items
    if (isset($_GET['deleteID'])) {
      echo "<h3>Do you really want to delete this item : ". $_GET['deleteID'] ." ?
       <a href='admin_index.php?confirmDelete=".$_GET['deleteID']."'>Yes</a> || <a href='admin_index.php'>No</a></h3>";
    }
    if (isset($_GET['confirmDelete'])) {
      $idToDelete = $_GET['confirmDelete'];
      $del = "DELETE FROM products WHERE id = '$idToDelete' ";
      $delresult = mysqli_query($dbcon, $del);

  //Unlinking and deleting images
      $picToDelete = ("images/".$idToDelete.".jpg");
      if (file_exists($picToDelete)) {
        unlink($picToDelete);
      }
      header('location:admin_index.php');
      exit();
    }
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="navbar">
      <h1 class="brand"><a href="index.php">OnlineShop</a></h1>
      <ul>
        <li>
            <input class="search" type="search" name="search" value="" placeholder="search Store">
        </li>
        <li><a href="#">About</a></li>
        <li><a href="admin_index.php">Admin</a></li>
      </ul>
    </div>
    <h1>Manage Inventory</h1>
    <table width="100%" border="2px solid black">

      <tr >
        <td width="70%">
          <div class="inventory_list">
              <h2>Inventory List</h2>
                <?php echo $product_list ?>
          </div>
        </td>

        <td width = "30%">



            <div class="Inventory_form">
                <h2><a href="#">Add Inventory</a></h2>
              <form class="add_inventory" action="admin_index.php" method="post" enctype="multipart/form-data">

                <label for="product_name">Product Name</label><br>
                <input type="text" name="product_name"  placeholder="Product Name" value="" required><br>

                <label for="Price">Price</label><br>
                <input type="text" name="price" placeholder="Product Price" value="" required><br>

                <label for="category">Category</label><br>
                <select class="" name="category">
                  <option value="">Select Category</option>
                  <option value="clothing">Chlothing</option>
                  <option value="electronics">Electronics</option>
                  <option value="computing">Computing</option>
                  <option value="hobby">Hobby</option>
                  <option value="cars">Cars</option>
                </select><br>

                <label for="details">Product Description</label><br>
                <textarea name="details"  placeholder="Product Details"></textarea><br>

                <label for="image">Choose File image</label><br>
                <input type="file" name="image" value="">
                <p>&nbsp;</p>
                <input type="submit" name="add" value="Add Inventory">
              </form>
            </div>
      </td>
    </tr>
  </table>

    <p>&nbsp;</p>  <p>&nbsp;</p>

  <footer style="height: 100px; width: 100%; background-color: black">

  </footer>
  </body>
</html>
