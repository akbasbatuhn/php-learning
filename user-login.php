<?php
session_start();
 
// if user is already logged in
if(isset($_SESSION["log-in"]) && $_SESSION["log-in"] === true){
    header("location: user-welcome.php");
    exit;
}

require_once "config.php";

$username = "";
$password = "";
$usernameError = "";
$passwordError = "";
$loginError = "";
$smthWentWrong = "Something went wrong! Please try again.";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $usernameError = "Please enter your username.";
    }
    else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $passwordError = "Please enter your password.";
    }
    else{
        $password = trim($_POST["password"]);
    }
    
    // Info
    if(empty($usernameError) && empty($passwordError)){
        $user_sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $user_sql)){
            mysqli_stmt_bind_param($stmt, "s", $usernameParam);
            
            $usernameParam = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashedPassword);
                    if(mysqli_stmt_fetch($stmt)){
                        
                        if(password_verify($password, $hashedPassword)){
                            $_SESSION["log-in"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            header("location: user-welcome.php");
                        }
                        else{
                            $loginError = "Invalid username or password.";
                        }
                    }
                }
                else{
                    $loginError = "Invalid username or password.";
                }
            }
            else{
                echo $smthWentWrong;
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>

<head>
    <title>Login</title>
    
    <style>
        body{ font: 14px "Times New Roman", Times; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>

<body>

    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your info to login.</p>

        <?php 
        if(!empty($loginError)){
            echo '<div class="alert alert-danger">' . $loginError . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $usernameError; ?></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $passwordError; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
            <p>Don't have an account? <a href="register.php">Sign up</a>.</p>
        </form>

    </div>

</body>

</html>