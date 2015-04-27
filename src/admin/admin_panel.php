<?php
header('Content-type: text/html; charset=utf-8');

if($_SESSION["email"]!='ADMIN'){
    header("Location: http://localhost/workshop2/");
}
echo "<div class='promoted'><h1>Welcome to Administators Panel of Your shop.</h1>On left menu You can choose categories or items You wish to edit. Press the button below to add new category.";
echo "<br><br><a id='sider' href='#sider'><button class='btn big-btn'>Add New Category</button></a></div>";
echo"<br><h2>Uzytkownicy</h2><ul>";
$users=User::GetAllUsers();
foreach($users as $user){
    $id=$user->getId();
    $name=$user->getName();
    $surname=$user->getSurname();
    $email=$user->getEmail();
    $phone=$user->getPhone();
    $address=$user->getAddress();
    echo "<li><h3>$id $name $surname</h3><br>";
    echo "<h4>$email $phone</h4><br>";
    echo "<h5>$address</h5>";
    echo"<button>Show Orders</button><button>Edit User</button></li>";
}
echo "</ul>";
?>
