<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../index.php');
    exit();
}

require __DIR__ . './../init.php';

if ($_POST['formType'] == 'edit') {
    $id            = $_POST['id'];
    $title         = $_POST['title'];
    $description   = $_POST['description'];

    query("UPDATE insturctions SET
                id          = :id,
                title    = :title,
                'description'  = ':description' 
                WHERE id = :id", [
        ':id'       => $id,
        ':title' => $title,
        ':description' => $description
    ]);
    redirect("../../u_account/my_account.php");
    exit();}
?>