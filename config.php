<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crm.lawpavilionplus.com";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname) or
die ("check your server connection");
