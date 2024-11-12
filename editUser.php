<?php 

require_once 'core/dbConfig.php';
require_once 'core/models.php';
require_once 'core/handleForms.php';

$applicant_id = $_GET['applicant_id'];

$getApplicantByID = getApplicantByID($pdo, $applicant_id);

if(!$getApplicantByID){
    echo "Applicant not found!";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant Information</title>
</head>
<body>
<?php 
    if(isset($_SESSION['message']) && $_SESSION['code'] == 400){ ?>
        <h3 style="color: red">[<?php echo $_SESSION['code'] ?>] <?php echo $_SESSION['message']; ?></h3>
    <?php }
    unset($_SESSION['message']);
    unset($_SESSION['code']); ?>
    <h1>Job Application System</h1>
    <h2>Update Your Information:</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="applicant_id" value="<?php echo htmlspecialchars($applicant_id); ?>">
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($getApplicantByID['fname']); ?>">
        <br><br>
        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($getApplicantByID['lname']); ?>">
        <br><br>
        <label for="subject">Subject</label>
        <input type="text" name="subject" value="<?php echo htmlspecialchars($getApplicantByID['assigned_sub']); ?>">
        <br><br>
        <input type="submit" value="Submit" name="updateApplicantBtn">
    </form>
</body>
</html>