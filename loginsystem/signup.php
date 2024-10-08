<?php  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "tradetoken_db";

    $conn = mysqli_connect($server, $username, $password, $database);

    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check whether a user with this email exists
    $exists = false;
    $existSql = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        $exists = true;
        echo '<script>alert("User with this email already exists");</script>';
    } else {
        if ($password == $confirm_password) {
            $sql = "INSERT INTO `users` (`name`, `email`, `password`, `date`) VALUES ('$username', '$email', '$password', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<script>alert("Account has been created successfully");</script>';
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header("location: http://localhost/tokentrade/index.php");
            }
        } else {
            echo '<script>alert("Passwords do not match");</script>';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokentrade</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
    body {
        background-color: #151719;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        max-width: 350px;
        padding: 50px;
        border-radius: 20px;
        position: relative;
        background-color: #1a1a1a;
        color: #fff;
        border: 1px solid #333;
    }

    .title {
        font-size: 28px;
        font-weight: 600;
        letter-spacing: -1px;
        position: relative;
        display: flex;
        align-items: center;
        padding-left: 30px;
        color: #00bfff;
    }

    .title::before {
        width: 18px;
        height: 18px;
    }

    .title::after {
        width: 18px;
        height: 18px;
        animation: pulse 1s linear infinite;
    }

    .title::before,
    .title::after {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        border-radius: 50%;
        left: 0px;
        background-color: #00bfff;
    }

    .message,
    .signin {
        font-size: 14.5px;
        color: rgba(255, 255, 255, 0.7);
    }

    .signin {
        text-align: center;
    }

    .signin a:hover {
        text-decoration: underline royalblue;
    }

    .signin a {
        color: #00bfff;
    }

    .flex {
        display: flex;
        width: 100%;
        gap: 6px;
    }

    .form label {
        position: relative;
    }

    .form label .input {
        background-color: #333;
        color: #fff;
        width: 100%;
        padding: 20px 60px 05px 10px;
        outline: 0;
        border: 1px solid rgba(105, 105, 105, 0.397);
        border-radius: 10px;
    }

    .form label .input+span {
        color: rgba(255, 255, 255, 0.5);
        position: absolute;
        left: 10px;
        top: 0px;
        font-size: 0.9em;
        cursor: text;
        transition: 0.3s ease;
    }

    .form label .input:placeholder-shown+span {
        top: 12.5px;
        font-size: 0.9em;
    }

    .form label .input:focus+span,
    .form label .input:valid+span {
        color: #00bfff;
        top: 0px;
        font-size: 0.7em;
        font-weight: 600;
    }

    .input {
        font-size: medium;
    }

    .submit {
        border: none;
        outline: none;
        padding: 10px;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        transform: .3s ease;
        background-color: #00bfff;
    }

    .submit:hover {
        background-color: #00bfff96;
    }

    @keyframes pulse {
        from {
            transform: scale(0.9);
            opacity: 1;
        }

        to {
            transform: scale(1.8);
            opacity: 0;
        }
    }

    #main_comtainer {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 2.2%;

    }
    </style>
</head>

<body>

    <div class="w-100 text-center" id="main_comtainer">
        <form class="form" action="" method="post">
            <p class="title">Sign Up</p>
            <p class="message">Signup now and get full access. </p>
            <div class="flex">
                <label>
                    <input class="input" maxlength="20" type="text" name="username" id="name" placeholder="" required>
                    <span>Name</span>
                </label>
            </div>

            <label>
                <input class="input" type="email" name="email" id="email" placeholder="" required>
                <span>Email</span>
            </label>

            <label>
                <input class="input" type="password" minlength="6" maxlength="11" name="password" id="password" placeholder="" required>
                <span>Password</span>
            </label>
            <label>
                <input class="input" type="password" name="confirm_password" id="confirm_password" placeholder=""
                    required>
                <span>Confirm password</span>
            </label>
            <button class="submit" type="submit">Sign Up</button>
            <p class="signin">Already have an acount ? <a href="login.php">Login</a> </p>
        </form>
    </div>

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>


</body>

</html>