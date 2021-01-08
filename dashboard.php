<?php

    require __DIR__.'./backend/init.php';

    $id = $_SESSION['userId'];


    // if ( !isset($_SESSION['id'])) {
    //     header("Location: login.php?msg= Log eerst in!");
    // }

    $user = selectOne("SELECT * FROM users WHERE id = :id",
         [ ':id'    => $id]);
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
     <?php
     require("header.php");
     ?> 
    </header>
    <main>
        <div class="banner">
            <div class="container">
                <div class="bannertext">
                    <h1>Hi <?php echo($user['username']) ?></h1>
                    <h2>Welkom op het dashboard!</h2>
                </div>
             </div>
         </div>
    </main>
    <footer>
        <?php
          require('footer.php');
        ?>
    </footer>
</body>
</html>