<?php
    require("header.php");

        // if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
        // header('Location: ../index.php');
        // exit();} 

    require __DIR__.'\backend/init.php';
    $id = $_SESSION['userId'];

    $title = selectOne("SELECT title FROM instructions WHERE id = :id",
    [":id" => $id]);
    $description = selectOne("SELECT description FROM instructions WHERE id = :id",
    [":id" => $id]);
?>

<form method="POST">
    <div>
    <label value="<?=$title?>" for="title">Title veranderen</label>
    </div>
    <div>
    <input type="text" name="title">
    </div>    
    <div>
    <input type="submit" value="Verander Title">
    </div>
</form>
<form method="POST">
    <div>
    <label value="<?=$description?>" for="discription">beschrijving veranderen</label>
    </div>
    <div>
    <input type="text" name="description">
    </div>    
    <div>
    <input type="submit" value="Verander Beschrijving">
    </div>
</form>
<?php
    require('footer.php');
?>