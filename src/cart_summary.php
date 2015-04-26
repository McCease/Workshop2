<?php
if(isset($_SESSION["cart"])){
    $cart=$_SESSION["cart"];
}else{
    $cart=Order::NewOrder($_SESSION["id"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["type"]=='delete') {
        $cart->removeItem($_POST["item_id"]);
        $_SESSION["cart"]=$cart;
    }
    if($_POST["type"]=='purchase'){
        if (!null == $cart->items){
            $items=$cart->items;
            foreach($items as $item_id => $quan){
                $quan=$_POST[$item_id];
                $cart->changeQuantity($item_id, $quan);
            }
            $cart->submitOrder();
            var_dump($cart);
            header("Location: http://localhost/Workshop2/");
            unset($_SESSION["cart"]);
            die();
        }
    }

}


echo "<div class='container'>";
echo "<h1>Your Order</h1>";
echo"<form method='post' action=''><ul>";
$total=0;
if (!null == $cart->items){
    $items=$cart->items;
    $str='(';
    foreach($items as $item_id => $quan){
        $str.=$item_id . ',';
    }

    $str=chop($str,",");
    $str.=')';
    $names=Item::GetItemsNames($str);
    $i=0;
    ksort($items);
    foreach($items as $item_id => $quan){
        $item_cost=($names[$i][1]*$quan);
        $total+=$item_cost;
        echo "<li>{$names[$i][0]}
            <span class='right'>
            <input type='number' name='$item_id' value='$quan'>
            <span class='item_price'>$item_cost  $</span></span></li>";
        $i++;
    }
}
echo"</ul><div class='summary'><hr>";
echo"<span class='left'>TOTAL: </span> <span class='right'> $total $ </span><br><br> ";

echo "<input type='hidden' value='purchase' name='type'>";
echo "<button type='submit' class='btn big-btn summary-btn right'>Proceed Your Order</button></div></form>";
echo "</div>";