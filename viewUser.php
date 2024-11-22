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
    <link rel="stylesheet"  href="css/styles.css">
    <title>View Applicants</title>
</head>
<body>
    <?php 
    // Check if search results are available in the session
    $searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];

    // Fetch all applicants if no search results are found
    $applicants = empty($searchResults) ? getApplicants($pdo) : $searchResults;

    ?>

    <h1>Job Application System</h1>
    <h2>View Registered Applicants List</h2>

    <form action="core/handleForms.php" method="POST">
        <input type="text" name="search" placeholder="Search for applicant:">
        <input type="submit" value="Search" name="searchQueryBtn">
    </form>

    <br><br>

    <table class="applicantsTable">
        <tr>
            <th style="border: 2px solid black; padding: 5px;">Last Name</th>
            <th style="border: 2px solid black; padding: 5px;">First Name</th>
            <th style="border: 2px solid black; padding: 5px;">Assigned Subject</th>
            <th style="border: 2px solid black; padding: 5px;">Date Added</th>
            <th style="border: 2px solid black; padding: 5px;">Actions</th>
        </tr>

        <?php foreach ($applicants as $applicant): ?>
            <tr>
                <td style="border: 2px solid black; padding: 5px;"><?php echo $applicant['lname']; ?></td>
                <td style="border: 2px solid black; padding: 5px;"><?php echo $applicant['fname']; ?></td>
                <td style="border: 2px solid black; padding: 5px;"><?php echo $applicant['assigned_sub']; ?></td>
                <td style="border: 2px solid black; padding: 5px;"><?php echo $applicant['date_added']; ?></td> 
                <td style="border: 2px solid black; padding: 5px;">
                    <button><a href="editUser.php?applicant_id=<?php echo $applicant['applicant_id']; ?>" style="text-decoration: none; color: black;">Update</a></button>
                    <button><a href="deleteUser.php?applicant_id=<?php echo $applicant['applicant_id']; ?>" style="text-decoration: none; color: black;">Delete</a></button>
                </td> 
            </tr>
        <?php endforeach; ?>

    </table>

    <br><br>
    <button><a href="index.php" style="text-decoration: none; color: black;">Return To Index</a></button>
</body>
</html>