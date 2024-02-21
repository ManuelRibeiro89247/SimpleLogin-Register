<?php

require_once "config.php";
require_once "session.php";

$success = ''; 
$error = '';
$registrationSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $registrationSuccess = false; 

    if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();
        if ($query->num_rows > 0) {
            $error .= '<p class= "error"> Email already in use! </p>';
        } else {
            if (strlen($password) < 8) {
                $error .= '<p class= "error"> Password has less than 8 characters! </p>';
            }
            if (empty($confirmpassword)) {
                $error .= '<p class="error"> Please insert the password a second time. </p>';
            } else {
                if (empty($error) && ($password != $confirmpassword)) {
                    $error .= '<p class="error">Passwords do not match!</p>';
                }
            }
            if (empty($error)) {
                $insertQuery = $db->prepare("INSERT INTO users (name, email,  password) VALUES (?, ?, ?);");
                $insertQuery->bind_param("sss", $name, $email, $password_hash);
                $result = $insertQuery->execute();
                if ($result) {
                    $success .= '<p class="success">Registration succesful! </p>';
                } else {
                    $error .= '<p class="error">Error! </p>';
                }
                
                    $insertQuery->close(); 
                

            }

        }
        $query->close(); 
    }
    mysqli_close($db);
}

if (!$registrationSuccess) {
    ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Sign Up</title>
            <link rel="icon" href="images/face_icon.png">
            <link href="css/style.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                  crossorigin="anonymous">
        </head>
        <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Register</h2>
                    <?php echo $success; ?>
                    <?php echo $error; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirmpassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary btn-black" value="Submit">
                        </div>
                        <p>Already have an account? <a href="login.php" class="dark-login">Login here!</a></p>
                    </form>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        Sign Up
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
                <h2>
                    Register
                </h2>
                <?php echo $success; ?>
                <?php echo $error; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary btn-black" value="Submit">
                    </div>
                    <p>
                        Already have an account? <a href="login.php" class="dark-login">Login here!</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

