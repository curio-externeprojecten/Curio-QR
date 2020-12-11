<?php
//require'header';
require'backend/init.php';

$id = decrypt($_GET['id']);

//logged in
if(isset($_SESSION['userId'])){
    $user = selectOne(
        //username
        //rank user/admin/superadmin
        "SELECT username, rank FROM users WHERE id = :id",
        [":id" => $_SESSION['userId']]
    );
}

$instruction = selectOne(
    "SELECT creator, title, description, username, code FROM instructions
    LEFT JOIN users on instructions.creator = users.id
    WHERE instructions.id = :id",
     [":id" => $id]);

if(!$instruction){
    header("Location: index.php"); 
}
$instructions = select(
    "SELECT type, content FROM instructions_data
    WHERE instruction_id = :id
    ORDER BY instruction_order", 
    [":id" => $id]);

$title = $instruction['title'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?=$title;?></title>
</head>
<body>


<head>
    
</head>

<div style='height:100px; background:black;'>
    <h1 style="color:white;display:inline">Fake header INC.</h1>
    <nav style='display:flex;justify-content:space-around;'>
        <h2 style="color:white;">dashboard</h2>
        <h2 style="color:white;">something</h2>
        <h2 style="color:white;">user</h2>
    </nav>
</div>

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

    </script>

    <div class="instructions">
        <div>
            <?php
            foreach($instructions as $data){
                if($data['type'] == "text"):
                ?>    
                    <div class='instruction'>
                        <p><?=$data['content'];?></p>
                    </div>
                <?php
                endif;
                if($data['type'] == "image"):
                ?>
                    <div class="instruction">
                        <img src="<?=$data['content'];?>">
                    </div>
                <?php
                endif;
                if($data['type'] == "video"):
                ?>
                    <div class="instruction">
                        <video src="<?=$data['content'];?>" controls></video>
                    </div>
                <?php
                endif;
            }
            ?>
        </div>
        <!--add instruction function-->
        <!--instructions are chunks of data text photo or video-->
        <div class="addInstruction">
            <button>add instruction</button>
        </div>
    </div>

    <div class="instructionsControls">
        <div class="instructionsInfo">
            <div class='instructionsTitle'>
                <h2><?=$title;?></h2>
            </div>
            <div class="instructionsCreator">
                <!--creator info-->
                <h3><?=$instruction['username'];?></h3>
                <p style='padding:25px;'>image</p>
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
                <button onclick="confirm()">Verwijder Instructies</button>
                <form action="backend/controllers/informationController.php" method="POST">
                    <input type="hidden" name="formType" value="Delete">
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <input id="removeInstruct" type="submit" value="VERWIJDER">
                </form>
                <button onclick="openqr()">genereer QRcode</button>
            </div>
            
            <div class="remove" id="qrBlock" style="display: none;">
                <img src="data:image/png;base64, <?=$instruction['code']?>" id="QRimage" alt="">
                <button id=download onclick="downloadQR()">Download</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>