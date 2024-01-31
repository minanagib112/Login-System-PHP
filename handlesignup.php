<?php
if (empty($_POST['name'])) {
    die("Name is required");
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST['psw']) < 8) {
    die("Password must be at least 8 characters");
}
if (!preg_match("/[a-z]/i", $_POST['psw'])) {
    die("Password must contain at least one letter");
}
if (!preg_match("/[0-9]/", $_POST['psw'])) {
    die("Password must contain at least one number");
}
$password_hash = password_hash($_POST['psw'], PASSWORD_DEFAULT);

$mysqli = require("database.php");

$sql = "INSERT INTO users (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = mysqli_stmt_init($mysqli);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL: " . mysqli_error($mysqli));
}
$name = $_POST['name'];
$email = $_POST['email'];

mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password_hash);

if (mysqli_stmt_execute($stmt)) {
    header("Location: signupsuccess.html");
    exit;
} else {
    die("SQL: " . mysqli_error($mysqli));
}
