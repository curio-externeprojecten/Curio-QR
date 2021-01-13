<?php
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header('Location: ../index.php');
    exit();
    }

require __DIR__.'./../init.php';

if($_POST['formType'] == 'edit') {
    $id         = $_POST['id'];
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $rank       = $_POST['user_rank'];

    query("UPDATE users SET
                id          = :id,
                username    = :username,
                email       = :email,
                rank        = :user_rank
                WHERE id = :id",[
                    ':id'       => $id,
                    ':username' => $username,
                    ':email'    => $email,
                    ':user_rank'     => $rank
                ]);
            redirect("../../users/edit.php");
            exit();
}
if($_POST['formType'] == 'edit_acc') {
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    query("UPDATE users SET
                username    = :username,
                email       = :email,
                WHERE id = :id",[
                    ':username' => $username,
                    ':email'    => $email,
                ]);
            redirect("../../users/my_account.php");
            exit();
// not sure if this is good, need to check
}
if ($_POST['formType'] == 'delete') {
    $id = $_POST['id'];
    query("DELETE FROM users WHERE id = :id", [
        ':id' => $id
    ]);
    redirect("../../index.php");
}