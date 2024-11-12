<?php 

require_once 'core/dbConfig.php';
require_once 'core/models.php';
require_once 'core/handleForms.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>
</head>
<body>
<?php 
    if(isset($_SESSION['message']) && $_SESSION['code'] == 400){ ?>
        <h3 style="color: red">[<?php echo $_SESSION['code'] ?>] <?php echo $_SESSION['message']; ?></h3>
    <?php }
    unset($_SESSION['message']);
    unset($_SESSION['code']); ?>
    <h1>Job Application System</h1>
    <form action="core/handleForms.php" method="POST">
        <label for="fname">First Name</label>
        <input type="text" name="fname">
        <br><br>
        <label for="lname">Last Name</label>
        <input type="text" name="lname">
        <br><br>
        <label for="subject">Subject</label>
        <input type="text" name="subject">
        <br><br>
        <input type="submit" value="Submit" name="registerApplicantBtn">
    </form>
    <br><br>
    <button><a href="core/unset.php" style="text-decoration: none; color: black;">Reset</a></button>
</body>
</html>