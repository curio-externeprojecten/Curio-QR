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
//add <?= "<a href='my_account.php?id=${user['id']}'</a>" to dashboard "Jouw Account" link. 
?>
<body>
    <header>
        <?php
        require("../users/header.php");
        ?>

    </header>
    <h2>Mijn Account:</h2>
    <div>
        <label for="user">Gebruikersnaam:</label>
        <?=$user['username']?>
    </div>
    <div>
        <label for="email">Email:</label>
        <?=$user['email']?>
    </div>
    <div>
        <input type="submit" value="Wijzingen">
    </div>
    <div>
    <label for="qr">Mijn QR Code's:</label>
    </div>
    <div>
    <label for="delete">Account verwijderen</label>
    <input type="hidden" name="formType" value="delete">
    <input type="hidden" name="id" value="<?= $user['id']?>">
    <!-- Need to check if this input is correct -->
    </div>

<footer>
<?php
require("../users/footer.php")
?>
</footer>
</body>