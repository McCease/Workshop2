<?php
$id=$match["params"]["user_id"];
$user=User::GetUser($id);

$id=$user->getId();
$name=$user->getName();
$surname=$user->getSurname();
$email=$user->getEmail();
$phone=$user->getPhone();
$address=$user->getAddress();
$orders=Order::GetOrdersByUserId($id);

echo "<div class='one_item'><h1 class='item_name2'>$id. $name $surname</h1>";
echo "<br>Phone: $phone <span class='right'> Email: $email</span><br>";
echo "<br>Address: $address";
if(isset($_SESSION["email"])){
    echo "<br><br><a id='sider' href='#sider'><button class='right btn'>Edit User</button></a>";

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