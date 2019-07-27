<?php
  include_once('database.php');
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
     $details = $row['details'];
     $product_list .= "<tr>
       <td width='40%'>
           <img src='images/$id.jpg' alt='' height='250px' width='100%'>
       </td>
       <td width='60%' >
           <h2>Product Name : $product_name</h2>
           <h2>Product Price: $price</h2>
           <h2>Product Details: $details</h2>
       </td>
     </tr>";
 }
}else {
 $product_list = "<h3>You do not have any items</h3>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
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

    <div class="content">
      <table border="2px solid black" style="width:100% ;  height: 500px">
          <tr>
            <td width="25%" style="background-color: blue">

            </td>
            <td width="50%">
              <table border="1px solid blue" width="100%" height="250px">
                  <!-- <tr>
                    <td width='40%'>
                        <img src='images/3.jpg' alt='' height='250px' width='100%'>
                    </td>
                    <td width='60%' >
                        <h2>Product Name</h2>
                        <h2>Product Price</h2>
                        <h2>Product Details</h2>
                    </td>
                  </tr> -->
                  <?php echo $product_list ?>
              </table>

            </td>
            <td width="25%"  style="background-color: blue">

            </td>

          </tr>

      </table>

    </div>

    <p>&nbsp;</p>  <p>&nbsp;</p>

  <footer style="height: 100px; width: 100%; background-color: black">

  </footer>

  </body>
</html>
