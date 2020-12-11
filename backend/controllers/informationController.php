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

$sql2 = "DELETE FROM instructions_data WHERE instruction_id = :id";
$sql = "DELETE FROM instructions WHERE id = :id"; 


if($_POST['formtype'] == ''){//create project
    $projectTitle = $_POST['title'];
    $projectDesc = $_POST['desc'];
    $creator = decryptUser($_SESSION['userId']);

    $return = query("INSERT INTO instructions (creator, title, description) VALUES(:creator, :title, :Description)", 
    [':creator' => $creator, ':title' => $projectTitle, ':description' => $projectDesc]);

    $id = $return['id'];

    include('backend/phpqrcode/qrlib.php');

    $url = "http://qr.test/instructions.php?id=";
    $table = selectone("SHOW TABLE STATUS FROM qr WHERE `name` LIKE 'instructions' ");
    $id = encrypt($table['Auto_increment'] - 1);
    $codeContents = $url . encrypt($id);

    ob_start();
    QRcode::png($codeContents, null, QR_ECLEVEL_L, 4);
    $png = base64_encode(ob_get_contents());
    ob_end_clean();

    $image = addslashes($png);
    $update = query("UPDATE instructions SET code = :image WHERE id = :id", [':image' => $image, ':id' => $id]); 

    header('Location: ../instructions.php?id='. $projectCode);
	exit();

}
if($_POST['formtype'] == 'Delete'){//remove project
    $creator = decryptUser($_SESSION['userId']);
    $id = decrypt($_POST['id']);

    $projectCreator = selectone("SELECT creator FROM instructions WHERE id = :id", ['id' => $id]);
    if($creator != $projectCreator['creator']){
        header('Location: ../index.php');
	    exit();
    }
    query("DELETE FROM instructions_data WHERE instruction_id = :id", [':id' => $id]);

    query("DELETE FROM instructions WHERE id =:id", [':id' => $id]);

}
if($_POST['formtype'] == ''){//edit project
    //code
}
if($_POST['formtype'] == ''){//add instruction
    //code
}
if($_POST['formtype'] == ''){//remove instruction
    //code
}
if($_POST['formtype'] == ''){//?move instruction
    //code
}
if($_POST['formtype'] == ''){//edit instruction
    //code
}
if($_POST['formtype'] == ''){//generate qr
    //code
}
?>