<?php
echo "<header>
    <div class='container'>
        <span class='left'><a id='sider2' href='#sider2'><button class='open-btn'>Menu</button></a></span>
        <a href='/Workshop2/'><img class='logo' src='../../Workshop2/src/logo.png' alt='ABC logo'></a> <span class='slogan'>of Your needs!</span>
        <span class='right'>";
    if(isset($_SESSION["email"])){
        echo"<a href='../../Workshop2/logout'><button class='open-btn'>Logout</button></a><a href='../../Workshop2/user/{$_SESSION['id']}'><button class='open-btn'>Your Account</button></a>";
    }

echo "<a id='sider' href='#sider'><button class='open-btn'>Cart</button></a></span>
    </div>
</header>";