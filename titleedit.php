<?php
require("header.php");

// if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
// header('Location: ../index.php');
// exit();} 

    require __DIR__.'\backend/init.php';
    $id = $_SESSION['userId'];

$title = selectOne(
    "SELECT title FROM instructions WHERE id = :id",
    [":id" => $id]
);
$description = selectOne(
    "SELECT 'description' FROM instructions WHERE id = :id",
    [":id" => $id]
);
?>
<style>
    .editform {
        margin-left: 30%;
        margin-right: 30%;
        margin-top: 25%;
        padding: 50px 0px 50px 0px;
        border-radius: 15px;
        background: rgb(7, 24, 103);
        background: linear-gradient(0deg, rgba(7, 24, 103, 1) 0%, rgba(0, 157, 238, 1) 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>
<div class="editform">
    <div class="titledit">
        <form method="POST" action="backend/controllers/edit.php">
            <div>
                <label value="<?= $title ?>" for="title">Title veranderen</label>
            </div>
            <div>
                <input type="text" name="title">
            </div>
            <div>
                <input type="submit" value="Verander Title">
            </div>

            <div>
                <label value="<?=$title?>" for="title">Title veranderen</label>
            </div>

            <div>
                <label value="<?= $description ?>" for="discription">beschrijving veranderen</label>
            </div>
            <div>
                <input type="text" name="description">
            </div>
            <div>
                <input type="submit" value="Verander Beschrijving">
            </div>
            
        </div>
    </form>
</div>
<?php
require('footer.php');
?>