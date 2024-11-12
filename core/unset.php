<?php

include_once 'dbConfig.php';

session_start();

$deleteApplicantsQuery = "DELETE FROM applicants";
$resetApplicantsQuery = "ALTER TABLE applicants AUTO_INCREMENT = 1";

$deleteStatement = $pdo -> prepare($deleteApplicantsQuery);
$resetStatement = $pdo -> prepare($resetApplicantsQuery);

$executeQuery = $deleteStatement -> execute();
$executeQuery = $resetStatement -> execute();

if($executeQuery){
    header("Location: ../index.php");
    return true;
}

session_unset();