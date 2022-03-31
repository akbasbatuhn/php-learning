<?php include "config.php"; ?>
<!DOCTYPE html>

<head>
    <title>User View</title>
    
    <style>
        body{ 
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            min-height: 50vh;
        }
        .alb{
            width: 300px;
            height: 200px;
            padding: 5px;
        }
        .alb img{
            width: 100%;
            height: 100%;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <a href="file-upload.php">&#8592;</a>
    <?php 
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $res = mysqli_query($link, $sql);

        if(mysqli_num_rows($res) > 0){
            while($images = mysqli_fetch_assoc($res)) { ?>
                
                <div class="alb">
                    <img src="uploads/<?=$images['image_url']?>">
                </div>

    <?php } }?>

</body>

</html>