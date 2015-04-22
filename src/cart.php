
<?php
if(isset($_SESSION["cart"])){

}else{
    $cart=Order::NewOrder($_SESSION["id"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["type"]=='delete') {
        $cart->removeItem($_POST["item_id"]);
        $_SESSION["cart"]=$cart;
    }
}

//* testing of cart




echo"<h1>Your Cart</h1>";
echo"<ul>";
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
        $total+=$names[$i][1];
        echo "<li>{$names[$i][0]} - $quan
            <form class='item' method='post' action=''>
            <input type='hidden' value='$item_id' name='item_id'>
            <input type='hidden' value='delete' name='type'>
            <button type='submit'>X</button></form>
            </li>";
        $i++;
    }
}
echo"</ul><div class='summary'><hr>";
echo"<span class='left'>TOTAL: </span> <span class='right'> $total $ </span><br><br> ";


echo"<a href='cart_summary'><button class='btn big-btn summary-btn'>Summary</button></a></div>";