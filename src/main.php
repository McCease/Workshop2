<?php

$pictures=Item::GetPicturesCarousel();

if(false!=$pictures){
    echo "<div id='owl-carousel'>";
    foreach($pictures as $item_id=>$path_to_file){
        echo "<div class='item'><a href='../Workshop2/item/$item_id'><img src='../Workshop2/$path_to_file alt='picture of item'>TEKSTZASTEPCZY</a></div>";
    }
echo "</div>";
}

$items=Item::GetPromotedItems();
if($items!=false){
    echo "<div class='promoted'>";
    foreach($items as $item){
        $id=$item->getId();
        $name=$item->getName();
        $price=$item->getPrice();
        $description=$item->getDescription();
        $quantity=$item->getQuantity();
        $category_id=$item->getCategory_id();
        $is_visible=$item->getIsVisible();
        $description = substr($description,0,50).'...';
        echo "<a href='../Workshop2/item/$id'><div class='presented_item'><div class='item_name'>$name</div><br>";
        echo "<i>$description</i><br>Price: <span class='right'>$price $</span>";
        echo "</div></a>";
    }
    echo "</div>";
}
?>


