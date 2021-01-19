<?php
require __DIR__ . './../backend/init.php';

if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true) { //should make this userid
    header('Location: ../index.php');
    exit();
}

$id = $_GET['id'];
$user = selectOne("SELECT * FROM users WHERE id = :id", [
    ':id' => $id
]);
?>

    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <header>
            <?php
            require("header.php");
            ?>

        </header>
        <div class="twobanner">
            <h1 class="size">Admin Pagina</h1>
        </div>
        <div class="admincontainer">
            <div class="current_info size">
                <h2>Huidige Info:</h2>
                <div>
                    <label class="align" for="user">Gebruikersnaam:</label>
                    <?= $user['username'] ?>
                </div>
                <div>
                    <label class="align" for="email">Email:</label>
                    <?= $user['email'] ?>
                </div>
                <div>
                    <label class="align" for="status">Admin Status:</label>
                    <?= $user['rank'] ?>
                </div>
            </div>
            <br>
            <!-- =========================================================== -->

            <div class="card size">
                <form action="../backend/controllers/userController.php" method="post" id="form2">
                    <input type="hidden" name="formType" value="edit">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div>
                        <label class="align" for="user">Gebruikersnaam:</label>
                        <input type="text" name="username" value="<?= $user['username'] ?>">
                    </div>
                    <div>
                        <label class="align" class="adminLabel" for="email">Email:</label>
                        <input type="email" name="email" value="<?= $user['email'] ?>">
                    </div>
                    <div>
                        <label class="align" class="adminLabel" for="status">Admin Status:</label>
                        <select required class="cursor" name="user_rank" id="rank" form="form2">
                            <option value="" disabled selected>Status</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Super-Admin</option>
                        </select>
                    </div>
                    <input class="edit-button" type="submit" value="Gebruiker aanpassen">
                </form>
                <form action="../backend/controllers/userController.php" method="post" id="delete">
                    <input type="hidden" name="formType" value="delete_admin">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <input class="delete-button delete-card" type="submit" value="Gebruiker Verwijderen">
                </form>
            </div>




        </div>


        <footer>
            <?php
            require("footer.php");
            ?>
        </footer>
    </body>
