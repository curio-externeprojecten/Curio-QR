<?php

//isloggedin check

//require'header';
require'backend/init.php';


$instruction = selectOne(
    "SELECT creator, title, description, username FROM instructions
    LEFT JOIN users on instructions.creator = users.id
    WHERE instructions.id = :id",
     [":id" => $_GET['id']]);
    
$instructions = select(
    "SELECT type, content FROM instructions_data
    WHERE instruction_id = :id
    ORDER BY instruction_order", 
    [":id" => $_GET['id']]);

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

<div class='container' style='display:flex;border:1px black solid;padding:10px;background:gray;'>

    <div class="instructions">
        <div>
            <!--instruction go here in div-->
            <?php
            foreach($instructions as $data){
                if($data['type'] == "text"):
                ?>    
                <div class='instruction'>
                    <p><?=$data['content'];?></p>
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

        <div class="controls" style='background:green;padding:20px;'>
            <!--if high rank see controlls-->
            <!--remove whole instruction-->
            <div class="remove" style='margin:auto;width:100px'>
                <button style='width:100px;height:50px;'>remove project</button>
                <button style='width:100px;height:50px;'>get qr</button>
            </div>
        </div>

    </div>
</div>

</body>
</html>