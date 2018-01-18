<?php
if(!empty($_SESSION['id']))
{
   $session_uid=$_SESSION['id'];
   include('process.php');
   $userClass = new userClass();
}
if(empty($session_uid))
{
   $url='login.php';
   header("Location: $url");
}
