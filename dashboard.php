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
         <div class="maincontent">
             <div class="container">
                 <h3>Wat kan je hier doen?</h3>
                 <div class="articles">
                     <div class="article">
                         <img src="backend/img/qr3.gif" alt="qr-code">
                         <h4>Qr informatie pagina</h4>
                         <p>Hier leggen we de werking uit van met maken van een nieuwe qr code, en leggen we uit hoe met maken van de pagina in elkaar zit.</p>
                         <a href="">Naar de pagina ></a>
                     </div>
                     <div class="article">
                         <img src="backend/img/qr2.gif" alt="qr-code">
                         <h4>Qr pagina maken</h4>
                         <p>Hier kan je dan ook daadwerkelijk een nieuwe qr pagina aanmaken als je de informatie hebt gelezen. Of als je die niet nodig hebt.</p>
                         <a href="">Naar de pagina ></a>
                     </div>
                     <div class="article">
                         <img src="backend/img/qr5.png" alt="People buying stuff">
                         <h4>Admin Pagina</h4>
                         <p>Deze pagina kan je alleen gebruiken als je een van de hogere admins bent. Hier kan je andere accounts beheren en andere account hogere admins maken. Ook kun je de Qr pagina's hier beheren</p>
                         <?="<a href='users_admin/edit.php?id=${user['id']}'>Naar de pagina ></a>"?>
                     </div>
                     <div class="article">
                         <img src="backend/img/qr4.jpg" alt="Person at front desk">
                         <h4>Mijn Account</h4>
                         <p>Hier kan je jou accountgegevens zien en aanpassen wanneer gewenst.</p>
                         <?="<a href='u_account/my_account.php?id=${user['id']}'>Naar de pagina ></a>"?>
                     </div>
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