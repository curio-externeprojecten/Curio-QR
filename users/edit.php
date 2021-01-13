<?php
require __DIR__.'./../backend/init.php';

// $id = $_SESSION['userId'];

// if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
//         header('Location: ../../index.php');
//         exit();
//         }

$users = select("SELECT * FROM users");
?>
<body>
  <header>
     <?php
     require("header.php");
     ?> 
 </header>
<h1>Users Aanpassen</h1>

<h4>Geregistreerde gebruikers:</h4>
        <ul>
        <?php foreach ($users as $user)
        {
            echo "<li><a href='detail.php?id=${user['id']}'>${user['username']}</a></li>";
            }?>
        </ul>
<footer>
    <?php 
    require("footer.php");
    ?>
</footer>
</body>

