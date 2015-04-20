<?php
header('Content-type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {


}

if($_SESSION["email"]!='ADMIN'){
    header("Location: http://localhost/workshop2/");
}

echo '<h1>PANEL ADMINISTRACYJNY</h1>';


echo "<br><h2>Kategorie</h2><ul>";
$categories=Category::GetAllCategories();
foreach($categories as $category){
    $id=$category->getId();
    $name=$category->getName();
    echo "<li><h3>$id $name</h3>";
    echo"<button type='submit' >Edit Category</button></li>";
}
echo "</ul>";


echo "<br><h2>Przedmioty</h2><ul>";
$items=Item::GetItemsFrom('all');
foreach($items as $item){
    $id=$item->getId();
    $name=$item->getName();
    $price=$item->getPrice();
    $description=$item->getDescription();
    $quantity=$item->getQuantity();
    $category_id=$item->getCategory_id();
    $is_visible=$item->getIsVisible();
    echo "<li><h3>$id $name -> $price bln$</h3>";
    echo"<button>Edit Item</button></li>";
}
echo "</ul>";


echo "<br><h2>Uzytkownicy</h2><ul>";
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
