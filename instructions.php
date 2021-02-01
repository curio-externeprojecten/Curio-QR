<?php
require __DIR__.'/./header.php';
require __DIR__.'/./backend/init.php';

$id = $_GET['id'];

//logged in
if(isset($_SESSION['userId'])){
    $user = selectOne(
        //username
        //rank user/admin/superadmin
        "SELECT `id`, `username`, `rank` FROM users WHERE id = :id",
        [":id" => $_SESSION['userId']]
    );
}else{
    $user = false;
}

$instruction = selectOne(
    "SELECT `creator`, `title`, `description`, `username`, `code` FROM instructions
    LEFT JOIN users on `instructions`.`creator` = `users`.`id`
    WHERE `instructions`.`id` = :id",
     [":id" => $id]);

if(!$instruction){
   header("Location: index.php"); 
}
?>
<head>
    <title><?= $instruction['title']?></title>
</head>
<div class='instructionContainer'>
    <script>
        function openqr(){
            document.getElementById("qrBlock").style.display = "flex";
        }
        function downloadQR(){
            var link = document.createElement('a');
            link.href = "data:image/png;base64, " + "<?=$instruction['code']?>";
            link.download = "QRcode.png"

            link.click();
            link.remove();
        }
        function confirm(){
            document.getElementById("removeInstruct").style.display = "block";
        }
        
        function changeUser(){
            document.getElementById("userchanger").style.display = "block";
        }
        function closeChangeUser(){
            document.getElementById("userchanger").style.display = "none";
        }
    </script>

    <div class="instructionsControls">
        <div class="instructionsInfo">
            <div class='instructionsTitle'>
                <h2><?=$instruction['title'];?></h2>
            </div>
            <div class="instructionsCreator">
                <!--creator info-->
                <h3><?=$instruction['username'];?></h3>
            </div>
            <div class="infoDetails">
                <!--instruction details-->
                <p><?=$instruction['description'];?></p>
            </div>
        </div>
        
        <div class="controls">
            <!--if high rank see controlls-->
            <!--remove whole instruction-->
            <div class="remove">
                <?php
                $isAdmin = false;
                $isLocalAdmin = false;
                $isLocalSuperuser = false;

                if($user != false){
                    $userCheck = selectOne("SELECT rank FROM instructions_users where instruction_id = :id AND user_id = :userid", [":id" => $id, ":userid" => $user['id']]);
                    if($userCheck['rank'] == "admin"){
                        $isLocalAdmin = true;
                    }
                    if($userCheck['rank'] == "superadmin"){
                        $isLocalSuperuser = true;
                    }
                    if($user['rank'] == "admin" || $user['rank'] == "superadmin"){
                        $isAdmin = true;
                    }
                }
                if($isAdmin || $isLocalSuperuser):
                ?>
                    <button onclick="changeUser()">verander gemachtigde gebruiker</button>
                    <div class="addWindow userchanger" id="userchanger">
                        <button onclick="closeChangeUser()">X</button>
                        <form id="userform"action="backend/controllers/informationController.php" method="POST">
                        <input type="hidden" name="formtype" value="changeuser">
                        <input type="hidden" name="id" value="<?=$_GET['id']?>">
                        <select name="rank" form="userform" >
                            <option value="user">gebruiker</option>
                            <option value="admin">admin</option>
                        </select>
                        <label for="selecteduser">gebruikers email: </label>
                        <input type="text" name="selecteduser" required>
                        <input type="submit" value="verander gebruiker">
                        </form>
                    </div>
                <?php
                endif;
                if($isAdmin || $isLocalSuperuser):
                ?>
                    <button onclick="confirm()">Verwijder Instructies</button>
                    <form action="backend/controllers/informationController.php" method="POST">
                        <input type="hidden" name="formtype" value="Delete">
                        <input type="hidden" name="id" value="<?=$_GET['id']?>">
                        <input id="removeInstruct" type="submit" value="VERWIJDER">
                    </form>
                <?php
                endif;
                ?>
                <button onclick="openqr()">genereer QRcode</button>
            </div>
            
            <div class="remove" id="qrBlock" style="display: none;">
                <img src="data:image/png;base64, <?=$instruction['code']?>" id="QRimage" alt="">
                <button id=download onclick="downloadQR()">Download</button>
            </div>
        </div>
    </div>
    <div class="instructions">
        <iframe src="instruction.php?id=<?=$_GET['id']?>" frameborder="0" allowfullscreen>
            
        </iframe>
    </div>
</div>
<?php
require __DIR__.'/./footer.php';
?>
