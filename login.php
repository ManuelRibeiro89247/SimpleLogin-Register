<?php

require_once "config.php";
require_once "session.php";

$success = ''; 
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $error .= '<p class= "error"> Please enter your email.</p>';
    }

    if (empty($password)) {
        $error .= '<p class= "error"> Please enter your password.</p>';
    }

    if (empty($error)) {
        if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            if ($row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION["user"] = $row;
                    header("location: https://manuel-ribeiro.com/");
                    exit;
                } else {
                    $error .= '<p class= "error"> Password not valid!</p>';
                }
            } else {
                $error .= '<p class= "error"> No user with this email address!</p>';
            }
            $query->close();
        }
        mysqli_close($db);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        Login
    </title>
    <link rel="icon" href="images/face_icon.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Login</h2>
                <?php echo $error; ?> <!-- Display error messages here -->
                <form action="" method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary btn-black" value="Submit">
                    </div>
                    <p>
                        Don't have an account? <a href="register.php" class="dark-login">Register here!</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>