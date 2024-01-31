<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require "database.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: arial;
            background-color: #f5f5f5;
            padding: 50px;
        }

        button {
            display: block;
            margin: auto;
            font-size: 15px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid black;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        button:hover {
            background-color: #e6e6e6;
        }

        img {
            display: block;
            margin: 50px auto;
            width: 50%;
            border-radius: 10px;
            border: 1px solid black;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

        }
    </style>
</head>

<body>
    <?php if (isset($user)) : ?>
        <h1>Home Page</h1>
        <p>Hello <?= htmlspecialchars($user["name"])?>, You are logged in</p>
        <button><a href="logout.php">Logout</a></button>
        <img src="indexPage.jpg" alt="Home Page">
    <?php else : ?>
        <h1>Home Page</h1>
        <p>You are not logged in</p>

        <p><a href="login.php">Login</a> or <a href="signup.html">Register</a></p>

    <?php endif; ?>
</body>

</html>