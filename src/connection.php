<?php
require_once("classes/users.php");
require_once("classes/categories.php");
require_once("classes/items.php");
require_once("classes/admins.php");
require_once("classes/orders.php");

$configDB = array(
    'servername' => "localhost",
    'username' => "user1",
    'password' => "passwd",
    'baseName' => "Workshop2"
);


$conn = new mysqli($configDB['servername'], $configDB['username'], $configDB['password'], $configDB['baseName']);

if ($conn->connect_error) {
    die("Connection Failed. Error: " . $conn->connect_error."<br>");
}


//setting connections for clases
User::SetConnection($conn);
Item::SetConnection($conn);
Admin::SetConnection($conn);
Category::SetConnection($conn);
Order::SetConnection($conn);
?>