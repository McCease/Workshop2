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
    <input type='file' name='fileToUpload'>
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
    echo "AAAAAAAAA";
}else{

}