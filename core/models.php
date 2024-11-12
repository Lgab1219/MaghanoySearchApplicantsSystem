<?php

require_once 'dbConfig.php';

// Adds an applicant to the table
function addApplicant($pdo, $fname, $lname, $assigned_sub){
    $checkUserSQL = "SELECT * FROM applicants WHERE fname = ? AND lname = ?";
    $statement = $pdo -> prepare($checkUserSQL);
    $statement -> execute([$fname, $lname]);

    if($statement -> rowCount() == 0){
        $addUserSQL = "INSERT INTO applicants (fname, lname, assigned_sub) VALUES (?, ?, ?)";
        $statement = $pdo -> prepare($addUserSQL);
        $executeQuery = $statement -> execute([$fname, $lname, $assigned_sub]);

        if($executeQuery){
            // Return status message and status code if insert query was successful
            $_SESSION['message'] = "Applicant successfully registered!";
            $_SESSION['code'] = 200;
            return true;
        } else {
            // Return status message and status code if insert query was not successful
            $_SESSION['message'] = "Applicant registration failed!";
            $_SESSION['code'] = 400;
        }
    } else {
        $_SESSION['message'] = "User already exists!";
        $_SESSION['code'] = 400;
    }
}

// Get all registered applicants
function getApplicants($pdo){
    $getQuery = "SELECT * FROM applicants";
    $statement = $pdo -> prepare($getQuery);
    $executeQuery = $statement -> execute();

   if($executeQuery){
       return $statement -> fetchAll();
   }

}

// Get registered applicant by ID from the database
function getApplicantByID($pdo, $applicant_id){

    $query = "SELECT * FROM applicants WHERE applicant_id = ?";
 
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$applicant_id]);
 
    if($executeQuery){
        return $statement -> fetch();
    }
 
 }


// Update applicant information
function updateApplicants($pdo, $fname, $lname, $assigned_sub, $applicant_id){
    $query = "UPDATE applicants
    SET fname = ?,
    lname = ?,
    assigned_sub = ?
    WHERE applicant_id = ?";
 
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([
        $fname,
        $lname,
        $assigned_sub,
        $applicant_id
    ]);
 
    if ($executeQuery) {
        return true;
    }
 }


 // Deletes an applicant from the database
function deleteApplicant($pdo, $applicant_id){
    $query = "DELETE FROM applicants WHERE applicant_id = ?";
 
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$applicant_id]);
 
    if($executeQuery){
        return true;
    }
 }

 
 function searchApplicant($pdo, $search){
    $query = "SELECT * FROM applicants WHERE fname LIKE ? OR lname LIKE ? OR assigned_sub LIKE ?";
    $statement = $pdo->prepare($query);

    $executeQuery = $statement -> execute([$search, $search, $search]);

    if($executeQuery){
        $searchResults = $statement -> fetchAll();
        return $searchResults;
    } else {
        echo "Failed to search applicant";
    }
 }