<?php
$id=$match["params"]["item_id"];
$item=Item::GetItem($id);
$pictures=$item->getPictures();

if(false!=$pictures){
    echo "<div id='owl-carousel'>";
    foreach($pictures as $picture){
        echo "<div class='item'><img src='../../Workshop2{$picture['path_to_file']}' alt='picture of item' height='150px'></div>";
    }
    echo "</div>";
}
$item_id=$item->getId();
$name=$item->getName();
$price=$item->getPrice();
$description=$item->getDescription();
$quantity=$item->getQuantity();
$category_id=$item->getCategory_id();
$is_visible=$item->getIsVisible();

echo "<div class='one_item'><h1 class='item_name2'>$name</h1>";
echo "<br>$description<br>";
echo "<br><hr>Price<span class='right'>$price $</span>";
if(isset($_SESSION["email"])){
    echo "<br><br><form method='post' action=''>
        <input type='hidden' value='$item_id' name='item_id'>
        <input type='hidden' value='addItem' name='type'><button type='submit' class='right btn'>Add to Cart</button></form>";
    echo "</div>";
}
