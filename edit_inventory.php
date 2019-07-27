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
    //Display Current Inventory Data
    if (isset($_GET['editID'])) {

      $targetID = $_GET['editID'];
      $sql = "SELECT * FROM products WHERE id = '$targetID' ";
      $result = mysqli_query($dbcon, $sql);
      $product_count = mysqli_num_rows($result);
        if ($product_count > 0) {
          while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $product_name  = $row['product_name'];
            $price = $row ['price'];
            $category = $row['category'];
            $details = $row['details'];
          }
        }else {
          echo "Product does not exist";
          exit();
        }
    }
  ?>
  <?php
   //Update Inventory Items and images
   if (isset($_POST['product_name'])) {
         $pid = mysqli_real_escape_string($dbcon, $_POST['thisID']);
         $product_name = mysqli_real_escape_string($dbcon, $_POST['product_name']);
         $price = mysqli_real_escape_string($dbcon, $_POST['price']);
         $category =  mysqli_real_escape_string($dbcon, $_POST['category']);
         $details = mysqli_real_escape_string($dbcon, $_POST['details']);

 //Insert Product data to database
         $sql = "UPDATE products SET product_name = '$product_name', price = '$price', category ='$category'
          , details= '$details' WHERE id = '$pid'";
         $result = mysqli_query($dbcon, $sql);
         $product_match = mysqli_num_rows($result);
 //Assign product id as image name
            if ($_FILES['image']['tmp_name'] != "") {
              $newImageName = "$pid.jpg";
              move_uploaded_file($_FILES['image']['tmp_name'], "images/$newImageName");
            }
         header('location:admin_index.php');
         exit();
   }

   ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Inventory</title>
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


    <div class="Inventory_form" style="width: 600px; margin: 0 auto">
        <h2><a href="#">Add Inventory</a></h2>
      <form class="add_inventory" action="edit_inventory.php" method="post" enctype="multipart/form-data">

        <label for="product_name">Product Name</label><br>
        <input type="text" name="product_name"  placeholder="Product Name" value="<?php echo $product_name ?>" required><br>

        <label for="Price">Price</label><br>
        <input type="text" name="price" placeholder="Product Price" value="<?php echo $price ?>" required><br>

        <label for="category">Category</label><br>
        <select class="" name="category">
          <option value="<?php echo $category ?>"><?php echo $category ?></option>
          <option value="clothing">Chlothing</option>
          <option value="electronics">Electronics</option>
          <option value="computing">Computing</option>
          <option value="hobby">Hobby</option>
          <option value="cars">Cars</option>
        </select><br>

        <label for="details">Product Description</label><br>
        <textarea name="details"  placeholder="Product Details"><?php echo $details ?></textarea><br>

        <label for="image">Choose File image</label><br>
        <input type="file" name="image" value="">
        <p>&nbsp;</p>
         <input type="hidden" name="thisID" value="<?php echo $targetID ?>">
        <input type="submit" name="add" value="Save Changes">
      </form>
    </div>
    <p>&nbsp;</p>  <p>&nbsp;</p>

  <footer style="height: 100px; width: 100%; background-color: black">

  </footer>

  </body>
</html>
