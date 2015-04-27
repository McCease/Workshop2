<?php
$id=$match["params"]["category_id"];
echo "<br><br><a id='sider' href='#sider'><button class='btn right big-btn'>Edit Category</button></a><br>";
$items_cat=Item::GetItemsFrom($id);
if($items_cat!=false){
    echo "<div class='promoted'>";
    foreach($items_cat as $item){
        $id=$item->getId();
        $name=$item->getName();
        $price=$item->getPrice();
        $description=$item->getDescription();
        $quantity=$item->getQuantity();
        $category_id=$item->getCategory_id();
        $is_visible=$item->getIsVisible();
        $description = substr($description,0,50).'...';
        echo "<a href='/../Workshop2/item/$id'><div class='presented_item'><div class='item_name'>$name</div><br>";
        echo "<i>$description</i><br>Price: <span class='right'>$price $</span>";
        echo "</div></a>";
    }

    echo "</div>";
}