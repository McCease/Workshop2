
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
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["type"]=='subst') {
        $item_id=$_POST["item_id"];
        if($cart->items[$item_id]==1){
            $cart->removeItem($item_id);
        }else{
            $cart->items[$item_id]=$cart->items[$item_id]-1;
        }

        $_SESSION["cart"]=$cart;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == 'addItem') {
        $cart->addItem($_POST["item_id"]);
        $_SESSION["cart"] = $cart;
    }
}


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
        $total+=($names[$i][1]*$quan);
        echo "<li>{$names[$i][0]} - $quan
            <form class='item' method='post' action=''>
            <input type='hidden' value='$item_id' name='item_id'>
            <input type='hidden' value='addItem' name='type'>
            <button type='submit' class='btn-small'>+</button></form>
            <form class='item' method='post' action=''>
            <input type='hidden' value='$item_id' name='item_id'>
            <input type='hidden' value='subst' name='type'>
            <button type='submit' class='btn-small'>-</button></form>
            <form class='item' method='post' action=''>
            <input type='hidden' value='$item_id' name='item_id'>
            <input type='hidden' value='delete' name='type'>
            <button type='submit' class='btn-small'>x</button></form>
            </li>";
        $i++;
    }
}
echo"</ul><div class='summary'><hr>";
echo"<span class='left'>TOTAL: </span> <span class='right'> $total $ </span><br><br> ";


echo"<a href='cart_summary'><button class='btn big-btn summary-btn'>Summary</button></a></div>";