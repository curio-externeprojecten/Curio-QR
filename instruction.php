<?php
require __DIR__.'\backend/init.php';

if(!isset($_GET['id'])){
    exit();
}
$id = decrypt($_GET['id']);

$instructions = select(
    "SELECT type, content, instruction_order FROM instructions_data
    WHERE instruction_id = :id
    ORDER BY instruction_order", 
    [":id" => $id]);
if($instructions == false){
    exit();
}
if(isset($_SESSION['userId'])){
    $user = selectOne(
        "SELECT id, rank FROM users WHERE id = :id",
        [":id" => decryptUser($_SESSION['userId'])]
    );
}else{
    $user = false;
}
function userCheck($user, $id){
    if($user == false){
        return false;
    }
    $userCheck = selectOne("SELECT rank FROM instructions_users where instruction_id = :id AND user_id = :userid", [":id" => $id, ":userid" => $user['id']]);
    if($userCheck['rank'] == "admin" || $userCheck['rank'] == "superadmin"){
        return true;
    }
    if($user['rank'] == "admin" || $user['rank'] == "superadmin"){
        return true;
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Quicksand:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<script>
    function openAdd(){
        document.getElementById('overlay').style.display = "block";
    }
    function closeAdd(){
        document.getElementById('overlay').style.display = "none";
    }
    function select(){
        const select = document.querySelector('#submitSelect');
        if(select.selectedIndex == 0){
            document.getElementById('area').style.display = "block";
            document.getElementById('file').style.display = "none";
            document.getElementById('video').style.display = "none";

            document.getElementById('areaLabel').style.display = "inline";
            document.getElementById('fileLabel').style.display = "none";
            document.getElementById('videoLabel').style.display = "none";
        }
        if(select.selectedIndex == 1){
            document.getElementById('area').style.display = "none";
            document.getElementById('file').style.display = "block";
            document.getElementById('video').style.display = "none";

            document.getElementById('areaLabel').style.display = "none";
            document.getElementById('fileLabel').style.display = "inline";
            document.getElementById('videoLabel').style.display = "none";
        }
        if(select.selectedIndex == 2){
            document.getElementById('area').style.display = "none";
            document.getElementById('file').style.display = "none";
            document.getElementById('video').style.display = "block";

            document.getElementById('areaLabel').style.display = "none";
            document.getElementById('fileLabel').style.display = "none";
            document.getElementById('videoLabel').style.display = "inline";
        }
    }
</script>
<?php
foreach($instructions as $data):
    echo "<div class='instruction'>";
    if(userCheck($user, $id)):
    ?>
    <div class="controlContainer">
        <form class="control" action="backend/controllers/informationController.php" method="post">
            <input type="hidden" name="formtype" value="move" required/>
            <input type="hidden" name="id" value="<?= $_GET['id']?>" required>
            <input type="hidden" name="ordernumber" value="<?= $data['instruction_order']?>" required>
            <input type="submit" name="Move" value="▲">
            <input type="submit" name="Move" value="▼">
        </form>
        <form class="control" action="backend/controllers/informationController.php" method="post">
            <input type="hidden" name="formtype" value="remInstruct" required/>
            <input type="hidden" name="id" value="<?= $_GET['id']?>" required>
            <input type="hidden" name="ordernumber" value="<?= $data['instruction_order']?>" required>
            <input type="submit" value="X">
        </form>
    </div>
    <?php
    endif;
    if ($data['type'] == "text") {
        echo '<p>'.$data['content'].'</p>';
    }
    if ($data['type'] == "image") {
        echo '<img src="data:image/png;base64, '.$data['content'].'">';
    }
    if ($data['type'] == "video") {
        echo '<iframe src="https://www.youtube.com/embed/'. $data['content'] .'" frameborder="0"></iframe>';
    }
    echo "</div>"; 
endforeach;
if(userCheck($user, $id)):
?>
    <div class="addInstruction">
        <button onclick="openAdd()">voeg instructie toe</button>
    </div>
<div class="overlay" id="overlay">
    <div class="addWindow">
        <button onclick="closeAdd()">X</button>
        <form action="backend/controllers/informationController.php" id="submitForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="formtype" value="addInstruct" required>
            <input type="hidden" name="id" value="<?= $_GET['id']?>" required>
            <select onchange="select()" form="submitForm" name="type" id="submitSelect" required>
                <option value="text">tekst</option>
                <option value="image">foto</option>
                <option value="video">video</option>
            </select>
            <label style="display:inline;" for="submitText" id="areaLabel">Tekst:</label>
            <textarea form="submitForm" name="submitText" id="area" cols="30" rows="10"></textarea>
            <label for="submitFile" id="fileLabel">Foto:</label>
            <input type="file" name="submitFile" id="file">
            <label for="submitVideo" id="videoLabel">Youtube Video Link:</label>
            <input type="text" name="submitVideo" id="video">
            <input type="submit" value="voeg toe" required>
        </form>
    </div>
</div>
<?php
endif;
?>
</body>
</html>
