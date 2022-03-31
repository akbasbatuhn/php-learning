<?php
session_start();
 
// if logged in
if(!isset($_SESSION["log-in"]) || $_SESSION["log-in"] !== true){
    header("location: user-login.php");
    exit;
}
?>
 
<!DOCTYPE html>

<head>
    <title>Welcome!</title>
    <style>
        body{ font: 18px "Times New Roman"; text-align: center; }
    </style>
</head>

<body>
    <form>
    <div class="buttons">
        <ul style="list-style-type: none">
            <li>
                <button type="button" onclick="location.href='user-logout.php';">
                    Sign Out
                </button>
            </li>
            <li>
                <button type="button" onclick="location.href='file-upload.php';">
                    Upload File
                </button>
            </li>
        </ul>
    </div>
    </form>
</body>

</html>