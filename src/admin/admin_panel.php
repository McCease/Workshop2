<?php
header('Content-type: text/html; charset=utf-8');

if($_SESSION["email"]!='ADMIN'){
    header("Location: http://localhost/workshop2/");
}
echo "<div class='promoted'><h1>Welcome to Administators Panel of Your shop.</h1>On left menu You can choose categories or items You wish to edit. Press the button below to add new category.";
echo "<br><br><a id='sider' href='#sider'><button class='btn big-btn right'>Add New Category</button></a></div>";

?>
