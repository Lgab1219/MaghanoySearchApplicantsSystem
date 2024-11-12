<?php

require_once 'dbConfig.php';
require_once 'models.php';
require_once 'validate.php';

// Button adds an applicant to the list
if(isset($_POST['registerApplicantBtn'])){
    $fname = sanitizeInput($_POST['fname']);
    $lname = sanitizeInput($_POST['lname']);
    $assigned_sub = sanitizeInput($_POST['subject']);

    if(!empty($fname) && !empty($lname) && !empty($assigned_sub)){
        $addUserQuery = addApplicant($pdo, $fname, $lname, $assigned_sub);

        if($addUserQuery){
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

   if($query){
       $_SESSION['message'] = "Applicant information successfully updated!";
       $_SESSION['code'] = 200;
       header("Location: ../viewUser.php");
   } else {
    $_SESSION['message'] = "Applicant information failed to update!";
    $_SESSION['code'] = 400;
   }

   exit();
}

// Button deletes selected applicant
if(isset($_POST['deleteApplicantBtn'])){
    $applicant_id = $_POST['applicant_id'];

    $query = deleteApplicant($pdo, $applicant_id);

    if ($query) {
        $_SESSION['message'] = "Applicant successfully deleted!";
        $_SESSION['code'] = 200;
        header("Location: ../viewUser.php");
    } else {
        $_SESSION['message'] = "Applicant unsuccesfully deleted!";
        $_SESSION['code'] = 400;
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