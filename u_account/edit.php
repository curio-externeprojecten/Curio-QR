<?php
require __DIR__ . './../backend/init.php';


// if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
//     header('Location: ../../index.php');
//     exit();
//     }

$id = $_GET['id'];
$user = selectOne("SELECT * FROM users WHERE id = :id", [
    ':id' => $id
]);

?>

<body>
    <header>
        <?php
        require("../users_admin/header.php");
        ?>
    </header>
    <div class="twobanner">
        <h1 class="size">Mijn Account:</h1>
    </div>
    <div class="pink">
        <div class="twocontainer size">
            <div class="card">
                <form action="../backend/controllers/userController.php" method="post" id="form3">
                    <input type="hidden" name="formType" value="edit_acc">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div>
                        <label for="user" class="align">Gebruikersnaam:</label>
                        <input type="text" name="username" value="<?= $user['username'] ?>">
                    </div>
                    <div>
                        <label for="email" class="align">Email:</label>
                        <input type="email" name="email" value="<?= $user['email'] ?>">
                    </div>
                    <div>
                        <input class="edit-button" type="submit" value="Account Wijzingen">
                    </div>
                    <div class="toedit-button">
                        <a  href="../titleedit.php">QR Code Wijzigen</a>
                    </div>
                </form>
                <form action="../backend/controllers/userController.php">
                    <input type="hidden" name="formType" value="delete_acc">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div>
                        <input class="delete-button delete-card" type="submit" value="Account Verwijderen">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <?php
        require("../users_admin/footer.php");
        ?>
    </footer>
</body>