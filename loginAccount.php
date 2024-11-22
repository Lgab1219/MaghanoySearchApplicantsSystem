<?php

require_once 'core/models.php';
require_once 'core/handleForms.php';
require_once 'core/dbConfig.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
</head>
<body>
   <h1>Job Application System</h1>
   <br>
   <?php
   if(isset($_SESSION['message'])) { ?>
   <h1><?php echo $_SESSION['message']; ?></h1>
   <?php } unset($_SESSION['message']); ?>

   <h1>Login</h1>
   <form action="core/handleForms.php" method="POST">
       <label for="username">Username</label>
       <input type="text" name="username">
       <br><br>
       <label for="password">Password</label>
       <input type="text" name="password">
       <br><br>
       <input type="submit" name="loginUserBtn">
   </form>
   <p>Don't have an account? Register <a href="registerAccount.php">here</a>!</p>
</body>
</html>