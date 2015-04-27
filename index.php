<?php
header('Content-type: text/html; charset=utf-8');

require 'src\AltoRouter.php';
require 'src\connection.php';
session_start();
//ReDir
$router = new AltoRouter();
$router->setBasePath('/Workshop2');
$router->map('GET|POST','/', 'src\main.php');
$router->map('GET|POST','/admin', 'src\administrator.php');

//if admin logged
if(isset($_SESSION["email"])){
    if($_SESSION["email"]=='ADMIN') {
        $router->map('GET|POST', '/admin_panel', 'src\admin\admin_panel.php');
        $router->map('GET|POST', '/item/[i:item_id]', 'src\admin\admin_item.php');
        $router->map('GET|POST', '/category/[i:category_id]', 'src\admin\admin_category.php');
        $router->map('GET|POST', '/user/[i:user_id]', 'src\admin\admin_user.php');
        $router->map('GET|POST', '/user', 'src\admin\admin_users.php');
        $router->map('GET|POST', '/order/[i:order_id]', 'src\admin\admin_order.php');
        $router->map('GET|POST', '/order', 'src\admin\admin_orders.php');
    }else{
        $router->map('GET|POST', '/cart_summary', 'src\cart_summary.php');
        $router->map('GET|POST', '/user', 'src\user.php');
    }
}
$router->map('GET|POST', '/logout', 'src\logout.php');
$router->map('GET|POST', '/category/[i:category_id]', 'src\category.php');
$router->map('GET|POST', '/item/[i:item_id]', 'src\item.php');
/*
$router->map('GET|POST','/friends', 'friends.php');
$router->map('GET|POST','/users/[*:username]', 'users.php');
$router->map('GET|POST','/settings/[*:username]', 'settings.php');
$router->map('GET|POST','/logout', 'logout.php');
$router->map('GET|POST','/send_message_to/[*:username]', 'sending.php');
$router->map('GET|POST','/posts/[i:post_id]', 'post.php');
*/

$match = $router->match();



echo "<!DOCTYPE html><HTML><HEAD>";

echo "<link rel='stylesheet' href='/../Workshop2/src/stylesheets/jquery.sidr.dark.css'>";
echo "<link rel='stylesheet' href='/../Workshop2/src/stylesheets/owl.carousel.css'>";
echo "<link rel='stylesheet' href='/../Workshop2/src/stylesheets/owl.theme.css'>";
echo "<link rel='stylesheet' href='/../Workshop2/src/stylesheets/main.css'>";
echo "</HEAD><BODY>";

//Jesli uzytkownik jest zalogowany
if(isset($_SESSION["email"])){

    //Jesli zalogowany jest admin
    if($_SESSION["email"]=='ADMIN'){
        require('src\admin\admin_header.php');
        echo "<div id='right_menu' class='hidden'>";
        require('src\admin\admin_edit.php');
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
    echo "<li><a href='/../Workshop2/category/$c_id'> $c_name </a><ul>";
    $items=Item::GetItemsFrom($c_id);
    if($items!=false) {
        foreach ($items as $item) {
            $i_vis = $item->getIsVisible();
            if ($i_vis == 1) {
                $i_name = $item->getName();
                $i_id = $item->getId();
                echo "<li><a href='/../Workshop2/item/$i_id'> $i_name</a></li>";
            }
        }
    }
    echo "</ul></li>";
}
if (isset($_SESSION["email"]))
{
    if ($_SESSION["email"]=='ADMIN')
    {
        echo "<li><a href='/../Workshop2/user'> Users </a></li>";
        echo "<li><a href='/../Workshop2/order'> Orders </a></li>";
    }
}

echo "</ul></div>";

echo "<div class='container'>";
if($match) {
    require $match['target'];
}else{
    require('src\404.php');
}


$conn->close();
$conn = null;
/*
echo"<a id='sider' href='#sider'>Right Menu</a>
<a id='sider2' href='#sider2'>Left Menu</a>";
*/
echo "</div>";
?>


<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="../../Workshop2/src/jquery.sidr.js"></script>
<script src="../../Workshop2/src/owl.carousel.js"></script>
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
            displace: false
        });
        $.sidr('open', 'sidr_left');


<?php
if (isset($_SESSION["email"]))
{
    if ($_SESSION["email"]=='ADMIN') {
        echo "$.sidr('close', 'sidr_right');";
    }else{
        if(strpos($_SERVER['REQUEST_URI'], 'summary')!=false){
            echo "$.sidr('close', 'sidr_right');";
        }else{
            echo "$.sidr('open', 'sidr_right');";
        }
    }

}else{
 echo "$.sidr('open', 'sidr_right');";
}
?>
    });
</script>

<script>
    $(document).ready(function() {
        $("#owl-carousel").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items : 4,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [979,3]
        });

    });
</script>