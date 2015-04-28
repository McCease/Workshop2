<?php
echo "<div class='promoted'>";

$id=$match["params"]["order_id"];
$order=Order::GetOrder($id);
$date=$order->getDate();
$status=$order->getStatus();

echo "<div class='one_item'><h1 class='item_name2'>$id</h1>";
echo "<br>Date:<span class='right'>$date</span>";
echo "<br>Status:<span class='right'>$status</span>";
echo "<br><br><a id='sider' href='#sider'><button class='right btn'>Edit Order</button></a>";
echo "</div><br><br><br>";

if (!null == $order->items){
    $items=$order->items;
    $str='(';
    foreach($items as $item_id => $quan){
        $str.=$item_id . ',';
    }
    $str=chop($str,",");
    $str.=')';
    $names=Item::GetItemsNames($str);
    $i=0;
    ksort($items);
    $total=0;
    foreach($items as $item_id => $quan){
            $total+=($names[$i][1]*$quan);

        echo "<a href='/../Workshop2/item/$item_id'><div class='presented_item'><div class='item_name'>{$names[$i][0]}</div><br>";
        echo "<br>Price:<span class='right'>{$names[$i][1]}$</span>";
        echo "<br>Quantity:<span class='right'>$quan</span>";
        echo "</div></a>";
        $i++;
    }
}
echo "<hr><br>TOTAL:<span class='right'>$total $</span>";

