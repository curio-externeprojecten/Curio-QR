<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../index.php');
    exit();
}

require __DIR__ . './../init.php';

if ($_POST['formType'] == 'edit') {
    $id         = $_POST['id'];
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $rank       = $_POST['user_rank'];

    query("UPDATE users SET
                id          = :id,
                username    = :username,
                email       = :email,
                rank        = :user_rank
                WHERE id = :id", [
        ':id'       => $id,
        ':username' => $username,
        ':email'    => $email,
        ':user_rank'     => $rank
    ]);
    redirect("../../dashboard.php");
    exit();


} else if ($_POST['formType'] == 'edit_acc') {
    $id         = $_POST['id'];
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    query("UPDATE users SET
                id          = :id,
                username    = :username,
                email       = :email
                WHERE id = :id", [
        ':id'       => $id,
        ':username' => $username,
        ':email'    => $email,
    ]);
    redirect("../../dashboard.php");
    exit();


} else if ($_POST['formType'] == 'delete_admin') {
    $id = $_POST['id'];

    // query("DELETE FROM instructions_data WHERE user_id= :id", 
    // [':id'=> $id]);
    query("DELETE FROM instructions_users WHERE user_id= :id", 
    [':id'=> $id]);

    query("DELETE FROM instructions WHERE creator = :id",[
        ':id' => $id
    ]);
    
    query("DELETE FROM users WHERE id = :id", [
        ':id' => $id
    ]);
    redirect("../../dashboard.php");
    exit();


} else if ($_POST['formType'] == 'delete_acc') {
    
    $id = $_POST['id'];

    // query("DELETE FROM instructions_data WHERE user_id= :id", 
    // [':id'=> $id]);
    // query("DELETE FROM instructions_users WHERE user_id= :id", 
    // [':id'=> $id]);

    query("DELETE FROM instructions WHERE creator = :id",[
        ':id' => $id
    ]);
    
    query("DELETE FROM users WHERE id = :id", [
        ':id' => $id
    ]);
    redirect("../../index.php");
    exit();
}

