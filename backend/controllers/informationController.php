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
    //code
}
if($_POST['formtype'] == ''){//remove project
    //code
    //delete instructions then project

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