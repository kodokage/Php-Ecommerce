<?php
include_once('database.php');
 ?>
<?php
  session_start();
  if (isset($_SESSION['admin'])) {
    header('location:admin_index.php');
    exit();
  }
 ?>
<?php
//On submission of the form
  if (isset( $_POST['username']) && ($_POST['password'])) {
    $admin = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['username']);//filtering values
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['password']); //filtering values

    //Selecting values from database
    $sql = "SELECT * FROM admin WHERE username ='$admin' && password = '$password' ";
    $result = mysqli_query($dbcon, $sql);
    $exist_count = mysqli_num_rows($result);
    //returning users with password and username
    if ($exist_count == 1) {
      while ($row == mysqli_fetch_array($result)) {
        $id = $row['id'];
      }
      //Assigning admin login data to session variables
      $_SESSION['id'] = $id;
      $_SESSION['admin'] = $admin;
      $_SESSION['password'] = $password;
      header('location:admin_index.php');
      exit();
    }else{
      echo "Details are incorrect";
    }
  }
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="navbar">
      <h1 class="brand"><a href="index.php">OnlineShop</a></h1>
      <ul>
        <li><a href="#">About</a></li>
        <li><a href="admin_index.php">Admin</a></li>
      </ul>
    </div>

    <div class="login">
      <h2>Admin Login : Enter Your Data</h2>
        <form class="login_form" action="admin_login.php" method="post">
          <input type="text" name="username" value="" placeholder="Username" required><br>
          <input type="password" name="password" value="" placeholder="Password" required><br>
          <input type="submit" name="submit" value="Login">
        </form>
    </div>
    <p>&nbsp;</p>  <p>&nbsp;</p>

  <footer style="height: 100px; width: 100%; background-color: black">

  </footer>

  </body>
</html>
