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
   <title>Register</title>
</head>
<body>
   <h1>Job Application System</h1>
   <br>
   <form action="core/handleForms.php" method="POST">
       <h1>Register</h1>
       <label for="username">Username</label>
       <input type="text" name="username">
       <br><br>
       <label for="password">Password</label>
       <input type="text" name="password">
       <br><br>
       <input type="submit" name="createUserBtn">
   </form>
</body>
</html>