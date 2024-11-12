<?php 

    require_once 'core/dbConfig.php';
    require_once 'core/models.php';

    // Check if 'applicant_id' exists in the URL
    if (isset($_GET['applicant_id'])) {
        $applicant_id = $_GET['applicant_id'];
        $getApplicantByID = getApplicantByID($pdo, $applicant_id);
    } else {
        // Handle the case where ownerID is not present in the URL
        echo "No owner specified for deletion.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Applicant</title>
</head>
<body>
    <h1>Job Application System</h1>
    <h2 style="color: red">Are you sure you want to delete applicant <?php echo $getApplicantByID['lname'] . ", " . $getApplicantByID['fname']; ?>?</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="applicant_id" value="<?php echo htmlspecialchars($applicant_id); ?>">
        <input type="submit" value="Submit" name="deleteApplicantBtn">
    </form>
</body>
</html>