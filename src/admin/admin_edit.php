<button type="button" class="btn open-btn" onclick="$.sidr('close', 'sidr_right');">Close Menu</button>


<?php
if(strpos($_SERVER['REQUEST_URI'], 'item')!==false) {
    $id = $match["params"]["item_id"];
    $item = Item::GetItem($id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["type"] == 'update_item') {
            $id = $match["params"]["item_id"];
            $item = Item::GetItem($id);
            $item->setName($_POST["name"]);
            $item->setPrice($_POST["price"]);
            $item->setDescription($_POST["description"]);
            $item->setCategory_id($_POST["category_id"]);
            $item->setIsVisible($_POST["is_visible"]);
            $item->setIsPromoted($_POST["is_promoted"]);
        }
        var_dump($_POST);
        var_dump($_FILES['fileToUpload']['type']);
        if ($_POST["type"] == 'image') {
            if($_FILES['fileToUpload']['type'] == 'image/gif' ||
                $_FILES['fileToUpload']['type'] == 'image/png' ||
                $_FILES['fileToUpload']['type'] == 'image/jpg' ||
                $_FILES['fileToUpload']['type'] == 'image/jpeg') {
                $id = $match["params"]["item_id"];
                $tmpname = $_FILES['fileToUpload']['tmp_name'];
                $filename=$id . '_';
                $filename.=$_FILES['fileToUpload']['name'];
                $item->addPicture($filename,$tmpname);
                echo "AAAAAAAAAAAAAAAAAAAAA";
            }
        }
        if ($_POST["type"] == 'delete') {
            $id = $match["params"]["item_id"];
            $pictures_to_delete=$_POST["img_id"];
            foreach($pictures_to_delete as $key=>$picture_id){
                $item->deletePicture($picture_id);
            }

        }
    }

    $pictures = $item->getPictures();
    $name = $item->getName();
    $price = $item->getPrice();
    $description = $item->getDescription();
    $quantity = $item->getQuantity();
    $category_id = $item->getCategory_id();
    $is_visible = $item->getIsVisible();
    $is_promoted = $item->getIsPromoted();

    echo "<div class='container'>";
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='type' value='update_item'>";
    echo "<br>Item id: <span class='right'>$id</span><br>";
    echo "<br>Name: <span class='right'><input type='text' name='name' value='$name'></span><br>";
    echo "<br>Price: <span class='right'><input type='number' step='0.01' name='price' value='$price'></span><br>";
    echo "<br>Desription: <br><textarea maxlength='255' cols='50' rows='6' name='description'>$description</textarea><br>";
    echo "<br>Category ID: <span class='right'><input type='number' name='category_id' value='$category_id'></span><br>";
    if($is_promoted==true){
        echo "<br>Is item promoted?
            <span class='right'>Yes <input type='radio' name='is_promoted' value='true' checked> No <input type='radio' name='is_promoted' value='false'></span>";
    }else{
        echo "<br>Is item promoted?
            <span class='right'>Yes <input type='radio' name='is_promoted' value='true'> No <input type='radio' name='is_promoted' value='false checked'></span>";
    }
    if($is_visible==true){
        echo "<br>Should it be shown?
            <span class='right'>Yes <input type='radio' name='is_visible' value='true' checked> No <input type='radio' name='is_visible' value='false'></span>";
    }else{
        echo "<br>Should it be shown?
            <span class='right'>Yes <input type='radio' name='is_visible' value='true'> No <input type='radio' name='is_visible' value='false checked'></span>";
    }
    echo "<br><button class='btn submit-btn' type='submit'>Sumbit Your Changes</button>";
    echo"</form>";
    echo "<br><form method='post' action='' enctype='multipart/form-data'>
    <input type='hidden' name='type' value='image'>
    <div class='upload'><input type='file' class='btn' name='fileToUpload'></div>
    <span class='right'><button class='btn' type='submit'>Upload Picture</button></form></span>";

    if(false!=$pictures){
        echo "<br>Current pictures - check to delete<br><form method='post' action=''><input type='hidden' name='type' value='delete'>";
        foreach($pictures as $picture){
            echo "<label><input type='checkbox' name='img_id[]' value='{$picture['id']}' type='delete'><img height='100px' src='../../Workshop2/{$picture['path_to_file']}' alt='picture of item'>   </label>";
        }
        echo "<br><span class='right'><button class='btn ' type='submit'>Delete Pictures</button></span></form>";
    }
    echo "</div>";
}elseif(strpos($_SERVER['REQUEST_URI'], 'category')!==false){
    $id = $match["params"]["category_id"];
    $cat = Category::GetCategory($id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["type"]=='update_category'){
            $name=$_POST["name"];
            $cat->setName($name);
            $cat->saveToDb();
        }

        if($_POST["type"]=='delete_category'){
            $cat->deleteCategory();
        }

        if($_POST["type"]=='add_item'){
            $n=$_POST["name"];
            $p=$_POST["price"];
            $d=$_POST["description"];
            $c_id=$id;
            $is=$_POST["is_visible"];
            $is_p=$_POST["is_promoted"];
            Item::addItem($n, $p, $d, $q, $c_id, $is, $is_p);
        }
    }

    $name = $cat->getName();
    $parent_id = $cat->getParent_id();

    echo "<div class='container'>";
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='type' value='update_category'>";
    echo "<br>Category id: <span class='right'>$id</span><br>";
    echo "<br>Name: <span class='right'><input type='text' name='name' value='$name'></span><br>";
    echo "<br>Parent id: <span class='right'>$parent_id</span><br>";
    echo "<br><button class='btn submit-btn' type='submit'>Sumbit Your Changes</button>";
    echo "</form><form><input type='hidden' name='type' value='delete_category'><button class='btn big-btn' type='submit'>Delete Category</button>";
    echo "</form>";


    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='type' value='add_item'>";
    echo "<br>Name: <span class='right'><input type='text' name='name' value=''></span><br>";
    echo "<br>Price: <span class='right'><input type='number' step='0.01' name='price' value=''></span><br>";
    echo "<br>Desription: <br><textarea maxlength='255' cols='50' rows='6' name='description'>Description...</textarea><br>";
    echo "<br>Category ID: <span class='right'>$id</span><br>";
    echo "<br>Is item promoted?
            <span class='right'>Yes <input type='radio' name='is_promoted' value='true' checked> No <input type='radio' name='is_promoted' value='false'></span>";
    echo "<br>Should it be shown?
            <span class='right'>Yes <input type='radio' name='is_visible' value='true' checked> No <input type='radio' name='is_visible' value='false'></span>";
    echo "<br><button class='btn submit-btn' type='submit'>Add Item to Category</button>";
    echo"</form></div>";
}elseif(strpos($_SERVER['REQUEST_URI'], 'admin_panel')!==false){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["type"]=='new_category'){
            $p=0;
            $n=$_POST["name"];
            Category::AddCategory($n, $p);
        }
    }
    echo "<div class='container'><div class='container'>";
    echo "<form method='post' action=''>";
    echo "<br>Name: <span class='right'><input type='text' name='name' value=''></span><br>";
    echo "<input type='hidden' name='type' value='add_category'><button class='btn submit-btn' type='submit'>Add Category</button>";
    echo "</form></div></div>";
}elseif(strpos($_SERVER['REQUEST_URI'], 'order/')!==false){
    $id = $match["params"]["order_id"];
    $order=Order::GetOrder($id);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["type"]=='edit_order'){
            $order->setStatus($_POST["status"]);
        }
    }

    $date=$order->getDate();
    $status=$order->getStatus();

    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='type' value='edit_order'>";
    echo "<br>Order ID: <span class='right'>$id</span><br>";
    echo "<br>Date: <span class='right'>$date</span><br>";
    if($status=='realisation'){
        echo "<br>Order Status
            <span class='right'>Realisation <input type='radio' name='status' value='realisation' checked> Realized <input type='radio' name='status' value='realized'> Canceled<input type='radio' name='status' value='canceled'></span>";
    }elseif($status=='realized'){
        echo "<br>Order Status
            <span class='right'>Realisation <input type='radio' name='status' value='realisation'> Realized <input type='radio' name='status' value='realized'  checked> Canceled<input type='radio' name='status' value='canceled'></span>";
    }elseif($status=='canceled'){
        echo "<br>Order Status
            <span class='right'>Realisation <input type='radio' name='status' value='realisation'> Realized <input type='radio' name='status' value='realized'> Canceled<input type='radio' name='status' value='canceled' checked></span>";
    }
    echo "<br><button class='btn submit-btn' type='submit'>Sumbit Your Changes</button>";
    echo"</form>";

    echo"<ul>";
    $total=0;
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
        foreach($items as $item_id => $quan){
            $total+=($names[$i][1]*$quan);
            echo "<li>{$names[$i][0]} -<div class='right'>$quan

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
            </div>
            </li>";
            $i++;
        }
    }
    echo"</ul><hr>";
    echo"<span class='left'>TOTAL: </span> <span class='right'> $total $ </span><br><br>";
}