<?php
header('Content-type: text/html; charset=utf-8');

require 'src\AltoRouter.php';
require 'src\connection.php';

//ReDir
$router = new AltoRouter();
$router->setBasePath('/Workshop2');
$router->map('GET|POST','/', 'src\main.php');
$router->map('GET|POST','/admin', 'src\administrator.php');
$router->map('GET|POST', '/admin_panel', 'src\admin\admin_panel.php');
//if admin logged
if(isset($_SESSION["email"])){
    if($_SESSION["email"]=='ADMIN') {

        $router->map('GET|POST','/item/[i:item_id]', 'src\admin\admin_item.php');
        $router->map('GET|POST','/category/[i:category_id]', 'src\admin\admin_category.php');
    }else{
        $router->map('GET|POST','/cart', 'src\cart.php');
        $router->map('GET|POST','/item/[i:item_id]', 'src\item.php');
        $router->map('GET|POST','/category/[i:category_id]', 'src\category.php');
    }
}

/*
$router->map('GET|POST','/friends', 'friends.php');
$router->map('GET|POST','/users/[*:username]', 'users.php');
$router->map('GET|POST','/settings/[*:username]', 'settings.php');
$router->map('GET|POST','/logout', 'logout.php');
$router->map('GET|POST','/send_message_to/[*:username]', 'sending.php');
$router->map('GET|POST','/posts/[i:post_id]', 'post.php');
*/

$match = $router->match();
session_start();


echo "<HTML><HEAD>";
echo "<link rel='stylesheet' href='src/stylesheets/jquery.sidr.dark.css'>";
echo "<link rel='stylesheet' href='src/stylesheets/main.css'>";
echo "</HEAD><BODY>";

//Jesli uzytkownik jest zalogowany
if(isset($_SESSION["email"])){
    var_dump($_SESSION["email"]);
    //Jesli zalogowany jest admin
    if($_SESSION["email"]==='ADMIN'){
        require('src\admin\admin_header.php');
        echo "<div id='right_menu' class='hidden'>";
        require('src\cart.php');
        echo "</div>";

    }else{
        require('src\header.php');
        echo "<div id='right_menu' class='hidden'>";
        require('src\cart.php');
        echo "</div>";

    }
}else {
    require('src\header.php');
    echo "<div id='right_menu' class='hidden'>";
    require('src\login_register.php');
    echo "</div>";
}


$categories=Category::GetAllCategories();

echo "<div id='left_menu' class='hidden'><ul>";
foreach($categories as $category){
    $c_name=$category->getName();
    $c_id=$category->getId();
    echo "<li><a href='category/$c_id'> $c_name </a><ul>";
    $items=Item::GetItemsFrom($c_id);
    foreach($items as $item) {
        $i_vis=$item->getIsVisible();
        if($i_vis==0){
            $i_name=$item->getName();
            $i_id=$item->getId();
            echo "<li><a href='item/$i_id'> $i_name</a></li>";
        }
    }
    echo "</ul></li>";
}
echo "</ul></div>";




if($match) {
    require $match['target'];
}else{
    require('src\404.php');
}


$conn->close();
$conn = null;

?>

<a id="sider" href="#sider">Right Menu</a>
<a id="sider2" href="#sider2">Left Menu</a>

<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="src\jquery.sidr.js"></script>

<script>
    $(document).ready(function() {

        $('#sider').sidr({
            name: 'sidr_right',
            side: 'right',
            source: '#right_menu',
            displace: false

        });

        $('#sider2').sidr({
            name: 'sidr_left',
            side: 'left',
            source: '#left_menu',
            displace: true
        });



    });
</script>