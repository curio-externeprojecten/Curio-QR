<?php
require __DIR__ . './../backend/init.php';
// $id = $_SESSION['userId'];



// if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
//     header('Location: ../../index.php');
//     exit();
//     }
    
$id = $_GET['id'];
$user = selectOne("SELECT * FROM users WHERE id = :id", [
    ':id' => $id]);

?>
<body>
    <header>
        <?php
        require("header.php");
        ?>

    </header>
    <h2>Gebruiker Aanpassen</h2>
    <h3>Huidige Info:</h3>
    <div>
        <label for="user">Gebruikersnaam:</label>
        <?=$user['username']?>
    </div>
    <div>
        <label for="email">Email:</label>
        <?=$user['email']?>
    </div>
    <div>
        <label for="status">Admin Status:</label>
        <?=$user['rank']?>
    </div>
<p>==============================================================</p>
<!-- =========================================================== -->


    <form action="../backend/controllers/userController.php" method="post" id="form2">
    <input type="hidden" name="formType" value="edit">
    <input type="hidden" name="id" value="<?= $user['id']?>">
    <div>
        <label for="user">Gebruikersnaam:</label>
        <input type="text" name="username" value="<?= $user['username']?>">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $user['email']?>">
    </div>
    <div>
        <label for="status">Admin Status:</label>
        <select name="user_rank" id="rank" form="form2">
        <option value="" disabled selected>Rank</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
        <option value="superadmin">Super-Admin</option>
        </select>
    </div>
    <div>
    <input type="submit" value="Gebruiker aanpassen">
    </div>
    </form>

    <footer>
        <?php
        require("footer.php");
        ?>
    </footer>
</body>