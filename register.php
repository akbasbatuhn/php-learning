<?php
require "config.php";
 
$usernameError = "";
$passwordError = "";
$confirmPasswordError = "";
$smthWentWrong = "Something went wrong! Please try again.";
$username = "";
$password = "";
$confirmPassword = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $usernameError = "Username can contain numbers, letters, and underscores.";
    }
    elseif(empty(trim($_POST["username"]))){
        $usernameError = "Please enter an username.";
    }
    else{
        $user_sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $user_sql)){

            mysqli_stmt_bind_param($stmt, "s", $usernameParameter);
            $usernameParameter = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $usernameError = "This username is already taken!";
                }
                else{
                    $username = trim($_POST["username"]);
                }
            }
            else{
                echo $smthWentWrong;
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $passwordError = "Please enter a password.";     
    }
    elseif(strlen(trim($_POST["password"])) < 6){
        $passwordError = "Password must have atleast 6 characters.";
    }
    else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPasswordError = "Please confirm your password.";     
    }
    else{
        $confirmPassword = trim($_POST["confirmPassword"]);

        if(($password != $confirmPassword) && empty($passwordError)){
            $confirmPasswordError = "Password wrong!";
        }
    }
    
    // Inserting in database
    if(empty($passwordError) && empty($confirmPasswordError) && empty($usernameError)){
        $user_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $user_sql)){
            mysqli_stmt_bind_param($stmt, "ss", $usernameParameter, $passwordParameter);
            $usernameParameter = $username;
            $passwordParameter = password_hash($password, PASSWORD_DEFAULT);
            
            if(mysqli_stmt_execute($stmt)){
                header("location: user-login.php");
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
    <title>Sign-Up</title>
    
    <style>
        body{ font: 18px "Times New Roman"; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>

<body>

    <div class="wrapper">
        <h2>Sign-Up</h2>
        <p>Please fill this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $usernameError; ?></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $passwordError; ?></span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPasswordError)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirmPassword; ?>">
                <span class="invalid-feedback"><?php echo $confirmPasswordError; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            
            <p>Already have an account?<a href="user-login.php">Login here</a></p>
        </form>

    </div> 

</body>

</html>