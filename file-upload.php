<!DOCTYPE html>
<html lang="en">

<head> 
    <title>Image Upload</title>
    
    <style>
        body{ 
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            font: 40px "Times New Roman"; }
    </style>
    
</head>

<body>
    <h2>Upload image</h2>

    <a href="user-welcome.php" class="btn btn-danger ml-3">Main Page</a>
    <a href="view.php" class="btn btn-danger ml-3">Uploaded Files</a>
    

    <?php if (isset($_GET['error'])): ?>
        <p><?php echo $_GET['error']; ?></p>
    <?php endif ?>
    
    <form action="upload.php"
        method="post"
        enctype="multipart/form-data">

        <input type="file" name="my_image">
        
        <input type="submit" name="submit" value="Upload">

    </form>

</body>

</html>