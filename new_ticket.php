<?php
session_start();
if(!$_SESSION['Login']){
    header("location:index.php");
    die;
}
else {
    include_once ('config.php');
    $title = $_POST['title'];
    $user = $_POST['user'];
    $due_date = $_POST['due_date'];
    $message = $_POST['message'];
    $client_id = $_POST['clientID'];

    $query = "INSERT INTO tbl_ticket (title, message, date_due, user_id, client_id)
              VALUES ('{$title}', '{$message}', '{$due_date}', {$user}, {$client_id})";
    $result = mysqli_query($connect, $query);
    if ($result){
        echo ("true");
    }
    else {
        echo ("false");
    }
}?>