<?php

require_once 'dbConfig.php';
require_once 'validate.php';



// Adds an activity to the logs
function addActivity($pdo, $activity, $fname, $lname, $assigned_sub, $username, $date_added, $last_updated) {
    $checkActSQL = "SELECT * FROM activity_logs WHERE 
        fname = ? AND 
        lname = ? AND 
        assigned_sub = ? AND 
        username = ? AND 
        date_added = ?";
    $statement = $pdo->prepare($checkActSQL);
    $statement->execute([$fname, $lname, $assigned_sub, $username, $date_added]);

    if ($statement->rowCount() == 0) {
        // Activity doesn't exist, insert a new record
        $addActSQL = "INSERT INTO activity_logs (activity, fname, lname, assigned_sub, username, date_added, last_updated) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($addActSQL);
        $executeQuery = $statement->execute([$activity, $fname, $lname, $assigned_sub, $username, $date_added, $last_updated]);

        if ($executeQuery) {
            return true;
        } else {
            return false;
        }
    } else {
        // Activity already exists, update the last_updated timestamp
        $updateActSQL = "UPDATE activity_logs SET activity = ?, last_updated = NOW() WHERE fname = ? AND lname = ? AND assigned_sub = ? AND username = ? AND date_added = ?";
        $statement = $pdo->prepare($updateActSQL);
        $executeQuery = $statement->execute([$activity, $fname, $lname, $assigned_sub, $username, $date_added]);

        if ($executeQuery) {
            return true;
        } else {
            return false;
        }
    }
}

// Get all registered applicants
function getAllActivity($pdo){
    $getQuery = "SELECT * FROM activity_logs";
    $statement = $pdo -> prepare($getQuery);
    $executeQuery = $statement -> execute();

   if($executeQuery){
       return $statement -> fetchAll();
   }

}

// Search for specific activity logs
function searchActivity($pdo, $search){
    $query = "SELECT * FROM activity_logs WHERE activity LIKE ? OR fname LIKE ? OR lname LIKE ? OR assigned_sub LIKE ? OR
    username LIKE ? OR date_added LIKE ? OR last_updated LIKE ?";
    $statement = $pdo->prepare($query);

    $executeQuery = $statement -> execute([$search, $search, $search, $search, $search, $search, $search]);

    if($executeQuery){
        $searchResults = $statement -> fetchAll();
        return $searchResults;
    } else {
        echo "Failed to search activity";
    }
 }

// Logins account
function loginAccount($pdo, $username, $password){
    $checkQuery = "SELECT * FROM accounts WHERE username = ?";
    $statement = $pdo -> prepare($checkQuery);
 
    if($statement -> execute([$username])){
        $accountInfo = $statement -> fetch();
        $usernameDB = $accountInfo['username'];
        $passwordDB = $accountInfo['password'];
 
        if($password == $passwordDB){
            $_SESSION['username'] = $usernameDB;
            $_SESSION['message'] = "Login successful!";
            $_SESSION['code'] = 200;
            return true;
        } else {
            $_SESSION['message'] = "Username/Password Invalid!";
            $_SESSION['code'] = 400;
        }
 
        if($statement -> rowCount() == 0){
            $_SESSION['message'] = "Username/Password Invalid!";
            $_SESSION['code'] = 400;
        }
    }
 }

// Registers account to database
function createAccount($pdo, $username, $password){
    $checkQuery = "SELECT * FROM accounts WHERE username = ?";
    $statement = $pdo -> prepare($checkQuery);
    $statement -> execute([$username]);
 
    if($statement -> rowCount() == 0){
 
        $insertQuery = "INSERT INTO accounts (username, password) VALUES
        (?, ?)";
        $statement = $pdo -> prepare($insertQuery);
        $executeQuery = $statement -> execute([$username, $password]);
 
        if($executeQuery){
            $_SESSION['message'] = "User successfully inserted!";
            return true;
        } else {
            $_SESSION['message'] = "An error occurred!";
        }
    } else {
        $_SESSION['message'] = "User already exists!";
    }
 }

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
 function deleteApplicant($pdo, $applicant_id) {
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
            return true;
        } else {
            $_SESSION['message'] = "Applicant unsuccesfully deleted!";
            $_SESSION['code'] = 400;
            return false;
        }
    } else {
        $_SESSION['message'] = "Applicant not found!";
        $_SESSION['code'] = 404;
        return false;
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
