<?php

require_once 'models.php';
require_once 'dbConfig.php';
require_once 'validate.php';


// Button to search for specific activity
if (isset($_POST['searchActQueryBtn'])) {
    $search = $_POST['search'];

    $searchResults = searchActivity($pdo, $search);

    // Store the search results in the session
    $_SESSION['searchResults'] = $searchResults;

    header("Location: ../viewActLogs.php");
    exit;
}

// Logout account
if(isset($_GET['logout'])){
    unset($_SESSION['username']);
    $_SESSION['message'] = "";
    header('Location: ../loginAccount.php');
    }

// Logins account
if(isset($_POST['loginUserBtn'])){
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
 
    if(!empty($username) && !empty($password)){
        $loginQuery = loginAccount($pdo, $username, $password);
 
        if($loginQuery){
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../loginAccount.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty fields!";
        $_SESSION['code'] = 400;
        header("Location: ../loginAccount.php");
    }
 }

// Registers an account to the database
if(isset($_POST['createUserBtn'])){
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
 
    if(!empty($username) && !empty($password)){
 
        $insertQuery = createAccount($pdo, $username, $password);
 
        if($insertQuery){
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty fields!";
        header("Location: ../loginAccount.php");
    }
 }

// Button adds an applicant to the list
if(isset($_POST['registerApplicantBtn'])){
    $fname = sanitizeInput($_POST['fname']);
    $lname = sanitizeInput($_POST['lname']);
    $assigned_sub = sanitizeInput($_POST['subject']);

    if(!empty($fname) && !empty($lname) && !empty($assigned_sub)){
        $addUserQuery = addApplicant($pdo, $fname, $lname, $assigned_sub);

        if($addUserQuery) {
            $activity = "Applicant Added";
            addActivity($pdo, $activity, $fname, $lname, $assigned_sub, $_SESSION['username'], $_SESSION['date_added'], $_SESSION['last_updated']);
            header("Location: ../viewUser.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['message'] = "Please don't leave out empty fields in the form!";
        $_SESSION['code'] = 400;
        header("Location: ../index.php");
    }
}

// Button updates applicant information
if(isset($_POST['updateApplicantBtn'])){
    $query = updateApplicants($pdo, $_POST['fname'], $_POST['lname'], $_POST['subject'], $_POST['applicant_id']);
    $applicant_id = $_POST['applicant_id'];

    if ($query) {
        $activity = "Applicant Updated";
        $updatedApplicant = getApplicantByID($pdo, $applicant_id);
    
        if ($updatedApplicant) {
            addActivity($pdo, $activity, $updatedApplicant['fname'], $updatedApplicant['lname'], $updatedApplicant['assigned_sub'], $_SESSION['username'], $updatedApplicant['date_added'], $_SESSION['last_updated']);
            header("Location: ../viewUser.php");
        } else {
            // Handle the case where the applicant is not found
            $_SESSION['message'] = "Applicant not found.";
            $_SESSION['code'] = 404;
            header("Location: ../index.php");
        }
    }

   exit();
}

// Button deletes selected applicant
// Button deletes selected applicant
if (isset($_POST['deleteApplicantBtn'])) {
    $applicant_id = $_POST['applicant_id'];

    // Get applicant details before deletion
    $applicantData = getApplicantByID($pdo, $applicant_id);

    if ($applicantData) {
        // Log the deletion activity
        $activity = "Applicant Deleted";
        addActivity($pdo, $activity, $applicantData['fname'], $applicantData['lname'], $applicantData['assigned_sub'], $_SESSION['username'], $applicantData['date_added'], date('Y-m-d H:i:s'));

        // Delete the applicant
        $query = "DELETE FROM applicants WHERE applicant_id = ?";
        $statement = $pdo->prepare($query);
        $executeQuery = $statement->execute([$applicant_id]);

        if ($executeQuery) {
            $_SESSION['message'] = "Applicant successfully deleted!";
            $_SESSION['code'] = 200;
            header("Location: ../viewUser.php");
        } else {
            $_SESSION['message'] = "Applicant unsuccesfully deleted!";
            $_SESSION['code'] = 400;
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['message'] = "Applicant not found!";
        $_SESSION['code'] = 404;
        header("Location: ../index.php");
    }

    exit();
}

// Button to search for specific applicant
if (isset($_POST['searchQueryBtn'])) {
    $search = $_POST['search'];

    $searchResults = searchApplicant($pdo, $search);

    // Store the search results in the session
    $_SESSION['searchResults'] = $searchResults;

    header("Location: ../viewUser.php");
    exit;
}