<?php
$orders=Order::GetAllOrders();
echo "<div class='promoted'><br><br><br>";
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