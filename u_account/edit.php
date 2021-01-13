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
        require("../users/header.php");
        ?>

    </header>
<form action="../backend/controllers/userController.php" method="post" id="form3">
    <input type="hidden" name="formType" value="edit_acc">
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
    <input type="submit" value="Wijzingen">
    </div>
    </form>

    <footer>
        <?php
        require("../users/footer.php");
        ?>
    </footer>
</body>