<?php
$id=$match["params"]["item_id"];
$item=Item::GetItem($id);
$pictures=$item->getPictures();

if(false!=$pictures){
    echo "<div id='owl-carousel'>";
    foreach($pictures as $picture){
        echo "<div class='item'><img src='../../Workshop2/{$picture['path_to_file']}' alt='picture of item'></div>";
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
    echo "<br><br><a id='sider' href='#sider'><button class='right btn'>Edit Item</button></a>";
    echo "</div>";
}