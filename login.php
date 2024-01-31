<?php
$is_valid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require "database.php";

    $sql = sprintf(
        "SELECT * FROM users
            WHERE email = '%s'",
        $mysqli->real_escape_string(
            $_POST["email"]
        )
    );
    $result = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();
            session_regenerate_id(); //prevent session fixation
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        }
    }
    $is_valid = true;
}


?>



<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;

        }

        * {
            box-sizing: border-box
        }

        form {
            border: 3px solid #f1f1f1;
            width: 500px;
            margin: 50px auto;
            border-radius: 10px;

        }

        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            border-radius: 5px;
        }

        input[type=email]:focus,
        input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px;
            border: none;
            cursor: pointer;
            width: fit-content;
            border-radius: 5px;
            opacity: 0.9;
            text-align: center;

        }

        .clearfix {
            text-align: center;
        }

        button:hover {
            opacity: 1;
        }

        .container {
            padding: 16px;
            position: relative;
        }

        .error {
            color: red;
            position: absolute;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;

        }
    </style>
    <title>Login</title>
</head>

<body>
    <form method="POST">
        <h1 style="text-align: center;">Login Form</h1>

        <div class="container">
            <?php if ($is_valid) : ?>
                <em class="error">Invalid login</em>
            <?php endif; ?>
            <label><b>Email</b></label>
            <input type="email" placeholder="Enter Username" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" name="email">

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password">

            <div class="clearfix">
                <button type="submit" name="submit">Login</button>
            </div>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <span class="psw">You dont have an account? <a href="signup.html">Sign up here</a></span>
        </div>
    </form>

</body>