<?php
require("header.php");

// if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
// header('Location: ../index.php');
// exit();} 

    require __DIR__.'/backend/init.php';
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
<body class="background">
<style>
.background
{
     background-image: url("https://m.wsj.net/video/20170914/09142017_mw_studentdebthistory/09142017_mw_studentdebthistory_960x540.jpg");
     background-repeat: no-repeat;
     background-position: center;
     background-size: cover;
}
.editform {
    margin: 15% 30% 15% 30%;
    padding: 50px 0px 50px 0px;
    border-radius: 15px;
    background: rgb(7, 24, 103);
    background: linear-gradient(0deg, rgb(3,53,124, 1) 0%, rgba(3, 157, 200, 1) 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 1.2rem;
    font-weight: bold;
}
.titledit
{
    width: 200px;
    margin-bottom: 50px;
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
        </form>
    </div>
    <div class="discedit">
        <form method="POST" action="backend/controllers/edit.php">
            <div>
                <label value="<?= $description ?>" for="discription">beschrijving veranderen</label>
            </div>
            <div>
                <input type="text" name="description">
            </div>
            <div>
                <input type="submit" value="Verander Beschrijving">
            </div>
        </form>
    </div>
</div>
</body>
<?php
require('footer.php');
?>