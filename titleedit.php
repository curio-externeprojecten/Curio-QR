<?php
    require("header.php");

        // if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
        // header('Location: ../index.php');
        // exit();} 

    require __DIR__.'\backend/init.php';
    $id = $_GET['id'];

    $title = selectOne("SELECT title FROM instructions WHERE id = :id",
    [":id" => $id]);
?>

<form action="POST">
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
<?php
    require('footer.php');
?>