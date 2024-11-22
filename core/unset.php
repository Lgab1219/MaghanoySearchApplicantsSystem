<?php

include_once 'dbConfig.php';

session_start();

$deleteApplicantsQuery = "DELETE FROM applicants";
$resetApplicantsQuery = "ALTER TABLE applicants AUTO_INCREMENT = 1";
$deleteActLogsQuery = "DELETE FROM activity_logs";
$resetActLogsQuery = "ALTER TABLE activity_logs AUTO_INCREMENT = 1";

$deleteStatement = $pdo -> prepare($deleteApplicantsQuery);
$resetStatement = $pdo -> prepare($resetApplicantsQuery);
$deleteActLogsStatement = $pdo -> prepare($deleteActLogsQuery);
$resetActLogsStatement = $pdo -> prepare($resetActLogsQuery);

$executeQuery = $deleteStatement -> execute();
$executeQuery = $resetStatement -> execute();
$executeQuery = $deleteActLogsStatement -> execute();
$executeQuery = $resetActLogsStatement -> execute();

if($executeQuery){
    header("Location: ../index.php");
    return true;
}

session_unset();