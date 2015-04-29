<?php
$id=$match["params"]["user_id"];
$user=User::GetUser($id);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == 'update_user') {
        $user->setName($_POST["name"]);
        $user->setSurame($_POST["surname"]);
        $user->setPhone($_POST["phone"]);
        $user->setAddress($_POST["address"]);
    }
}
if($_SESSION["id"]!=$id){
    header("Location: http://localhost/Workshop2/");
    die();
}

$id=$user->getId();
$name=$user->getName();
$surname=$user->getSurname();
$email=$user->getEmail();
$phone=$user->getPhone();
$address=$user->getAddress();
$orders=Order::GetOrdersByUserId($id);

echo "<br><br><div class='one_item'>First Name, Last Name: <span class='right'><input type='text' name='name' value='$name'><input type='text' name='surname' value='$surname'></span><br>";
echo "<br>Phone Number: <input type='text' name='phone' value='$phone'> <span class='right'> Email: $email</span><br>";
echo "<br>Address:<br> <textarea height='6' width='100' maxlength='255'>$address</textarea> ";
if(isset($_SESSION["email"])){
    echo "<br><br><a id='sider' href='#sider'><button class='right btn'>Submit Changes</button></a>";

}



echo "</div><div class='promoted'><br><br><br>";
if($orders!=false){
    foreach($orders as $order){
        $order_id=$order->getId();
        $date=$order->getDate();
        $status=$order->getStatus();
        echo "<a href='/../Workshop2/order/$order_id'><div class='presented_item'><div class='item_name'>$order_id</div><br>";
        echo "<i>$date</i><br>Status:<span class='right'>$status</span>";
        echo "</div></a>";
    }
}
echo "</div>";