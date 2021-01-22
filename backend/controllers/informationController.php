<?php
require __DIR__.'/../init.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: ../index.php');
	exit();
}

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){//should make this userid
    header('Location: ../index.php');
	exit();
}

function InstructionUserCheck($user, $id){
    $userCheck = selectOne("SELECT rank FROM instructions_users where instruction_id = :id AND user_id = :userid", [":id" => $id, ":userid" => $user]);
    $adminCheck = selectOne("SELECT rank FROM users WHERE id = :id", [':id' => $user ]);
    $allowed = false;
    if($userCheck['rank'] == "admin" || $userCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($adminCheck['rank'] == "admin" || $adminCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($allowed == false){
        header('Location: ../../instruction.php?id='. $_POST['id']);
        exit();
    }
}
if($_POST['formtype'] == 'Create'){//create project
    $projectTitle = $_POST['title'];
    $projectDesc = $_POST['desc'];
    $creator = $_SESSION['userId'];

    $return = query("INSERT INTO instructions (creator, title, description) VALUES(:creator, :title, :description)", 
    [':creator' => $creator, ':title' => $projectTitle, ':description' => $projectDesc]);

    
    require('../phpqrcode/qrlib.php');

    $url = "http://".$_SERVER['HTTP_HOST']."/instructions.php?id=";
    $table = selectone("SHOW TABLE STATUS FROM qr WHERE `name` LIKE 'instructions' ");
    $id = -1 + $table['Auto_increment'];
    $codeContents = $url . encrypt($id);

    ob_start();
    QRcode::png($codeContents, null, QR_ECLEVEL_L, 4);
    $png = base64_encode(ob_get_contents());
    ob_end_clean();

    $image = addslashes($png);
    query("UPDATE instructions SET code = :image WHERE id = :id", [':image' => $image, ':id' => $id]); 

    query("INSERT INTO instructions_users (user_id, instruction_id, rank) values (:user, :id, 'superadmin')", [':user' => $creator, 'id' => $id]);

    header('Location: ../../instructions.php?id='.  encrypt($id));
    exit();
}
if($_POST['formtype'] == 'Delete'){//remove project
    $user = $_SESSION['userId'];
    $id = decrypt($_POST['id']);

    //set to creator or superadmin

    $userCheck = selectOne("SELECT rank FROM instructions_users where instruction_id = :id AND user_id = :userid", [":id" => $id, ":userid" => $user]);
    $adminCheck = selectOne("SELECT rank FROM users WHERE id = :id", [':id' => $user ]);
    $allowed = false;
    if($userCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($adminCheck['rank'] == "admin" || $adminCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($allowed == false){
        header('Location: ../../instruction.php?id='. $_POST['id']);
        exit();
    }
    query("DELETE FROM instructions_data WHERE instruction_id = :id", [':id' => $id]);

    query("DELETE FROM instructions_users WHERE instruction_id = :id", [':id' => $id]);

    query("DELETE FROM instructions WHERE id =:id", [':id' => $id]);

    header('Location: ../../dashboard.php');
    exit();
}
if($_POST['formtype'] == ''){//edit project
    $creator = $_SESSION['userId'];
    $id = decrypt($_POST['id']);

    //change title
    //change description
}
if($_POST['formtype'] == 'addInstruct'){//add instruction
    $user = $_SESSION['userId'];
    $id = decrypt($_POST['id']);
    $type = $_POST['type'];
    
    InstructionUserCheck($user, $id);

    $amount = count(select('SELECT instruction_order FROM instructions_data WHERE instruction_id = :id', [':id' => $id]));//get latest in list

    if($type == "text"){
        $convertedContent = $_POST['submitText'];
    }else if($type == "image"){
        $image = $_FILES['submitFile']["tmp_name"];
        $check = getimagesize($image);
        if($check == false){
            header('Location: ../../instruction.php?id='. $_POST['id']);
            exit();
        }
        $convertedContent = base64_encode(file_get_contents($image));
    }else if($type == "video"){
        $content = $_POST['submitVideo'];
        if(strpos($content, "youtube")){
            $cut = strpos($content, "?") + 1;
            $cutStr = substr($content, $cut);
            $explStr = explode("&", $cutStr);
            foreach($explStr as $part){
                echo $part;
                if(strpos($part, "v=") !== false){
                    echo $part;
                    $convertedContent = substr($part, 2);
                    break;
                }
            }
            /*https://www.youtube.com/watch?v=Q_NB5luxtic&list=RDURTi98rJaLY&index=2*/
        }else if(strpos($content, "youtu.be")){
           /* https://youtu.be/Q_NB5luxtic*/
           $cutpos = strpos($content, "be/") + 3;
           $convertedContent = substr($content, $cutpos);
        }

    }
    if(!isset($convertedContent)){
        echo "no content error";
        exit();
    }
    query('INSERT INTO instructions_data (instruction_id, instruction_order, type, content) 
    VALUES (:instruction_id, :instruction_order, :type, :content)', 
    [':instruction_id' => $id, ':instruction_order' => $amount, ':type' => $type, ':content' => $convertedContent]);//insert 

    header('Location: ../../instruction.php?id='. $_POST['id']);
     exit();
}
if($_POST['formtype'] == 'remInstruct'){//remove instruction
    $user = $_SESSION['userId'];
    $id = decrypt($_POST['id']);
    $orderNumber = $_POST['ordernumber'];

    InstructionUserCheck($user, $id);

    $selection = select("SELECT id, instruction_order from instructions_data where instruction_id = :id order by instruction_order asc",[":id" => $id]);
    foreach($selection as $selected){
        if($selected['instruction_order'] == $orderNumber){//remove selected
            query("DELETE FROM instructions_data WHERE id = :id",[":id" => $selected['id']]);

        }else if($selected['instruction_order'] > $orderNumber){//move others
            $move =  -1 + $selected['instruction_order'];
            query("UPDATE instructions_data SET instruction_order = :instruction_order WHERE id = :id", [":id" => $selected['id'], ":instruction_order" => $move]);
        }
    }
    header('Location: ../../instruction.php?id='. $_POST['id']);
    exit();
}
if($_POST['formtype'] == 'move'){//move instruction
    $user = $_SESSION['userId'];
    $id = decrypt($_POST['id']);
    $orderNumber = $_POST['ordernumber'];
    $instruction = $_POST['Move'];

    InstructionUserCheck($user, $id);
    $selection = select("SELECT id, instruction_order from instructions_data where instruction_id = :id order by instruction_order asc",[":id" => $id]);
    if($instruction == '▲'){//move up other down
        if($orderNumber == 0){//cant go lower
            header('Location: ../../instruction.php?id='. $_POST['id']);
            exit();
        }
        $target = $orderNumber - 1;
        foreach($selection as $selected){
            if($selected['instruction_order'] == $target){
                query("UPDATE instructions_data SET instruction_order = :instruction_order WHERE id = :id",[":id" => $selected['id'], ":instruction_order" => $orderNumber]);
            }else if($selected['instruction_order'] == $orderNumber){
                query("UPDATE instructions_data SET instruction_order = :instruction_order WHERE id = :id",[":id" => $selected['id'], ":instruction_order" => $target]);
            }
        }
    }else if($instruction == '▼'){//move down other up
        if($orderNumber > count($selection)){//cant go higher
        header('Location: ../../instruction.php?id='. $_POST['id']);
        exit();
        }
        $target = $orderNumber + 1;
        foreach($selection as $selected){
            if($selected['instruction_order'] == $target){
                query("UPDATE instructions_data SET instruction_order = :instruction_order WHERE id = :id",[":id" => $selected['id'], ":instruction_order" => $orderNumber]);
            }else if($selected['instruction_order'] == $orderNumber){
                query("UPDATE instructions_data SET instruction_order = :instruction_order WHERE id = :id",[":id" => $selected['id'], ":instruction_order" => $target]);
            }
        }
    }
    header('Location: ../../instruction.php?id='. $_POST['id']);
    exit();
}
if($_POST['formtype'] == 'changeuser'){
    $user = $_SESSION['userId'];
    $id = decrypt($_POST['id']);
    $rank = $_POST['rank'];
    $selectedUser = $_POST['selecteduser'];

    $userCheck = selectOne("SELECT rank FROM instructions_users where instruction_id = :id AND user_id = :userid", [":id" => $id, ":userid" => $user]);
    $adminCheck = selectOne("SELECT rank FROM users WHERE id = :id", [':id' => $user ]);
    $allowed = false;
    if($userCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($adminCheck['rank'] == "admin" || $adminCheck['rank'] == "superadmin"){
        $allowed = true;
    }
    if($allowed == false){
        header('Location: ../../instruction.php?id='. $_POST['id']);
        exit();
    }
    $targetUser = selectOne("SELECT id FROM users WHERE email = :email", [":email" => $selectedUser]);
    $check = selectOne("SELECT rank, id FROM instructions_users WHERE user_id = :user and instruction_id = :id", [":user" => $targetUser['id'], ":id" => $id]);
    if($check == false){
        if($targetUser == false){
            header('Location: ../../instructions.php?id='. $_POST['id']);
            exit();
        }
        query("INSERT INTO instructions_users (user_id, instruction_id, rank) values (:user, :id, :rank)", [":user" => $targetUser['id'], ":id" => $id, ":rank" => $rank]);
        header('Location: ../../instructions.php?id='. $_POST['id']);
        exit();
    }else if($check != false){
        if($check['rank'] == "superadmin"){
            header('Location: ../../instructions.php?id='. $_POST['id']);
            exit();
        }else{
            $a = query("UPDATE instructions_users set rank = :rank WHERE id = :id ", [":id" => $check['id'], ":rank" => $rank]);
            header('Location: ../../instructions.php?id='. $_POST['id']);
            exit();
        }
    }
}
?>