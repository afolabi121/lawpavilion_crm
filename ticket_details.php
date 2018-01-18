<?php
session_start();
if(!$_SESSION['Login']){
    header("location:index.php");
    die;
}
else {
    include_once ('config.php');
    $id = $_POST['id'];

    $query = "SELECT tbl_contact.name as Client, tbl_ticket.title, tbl_ticket.message, tbl_user.name as Assigned, tbl_ticket.date_issued, tbl_ticket.date_due, tbl_ticket.date_completed, tbl_ticket.id
    FROM tbl_ticket
    INNER JOIN tbl_contact ON tbl_ticket.client_id = tbl_contact.id INNER JOIN tbl_user ON tbl_ticket.user_id = tbl_user.id
    WHERE tbl_ticket.id = '{$id}'" ;
    $result = mysqli_query($connect, $query);
    $output = mysqli_fetch_assoc($result);
    echo json_encode(array("data"=>$output));
}