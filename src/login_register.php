<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (sizeof($_POST) > 2) {
        $e = $_POST["email"];
        $n = $_POST["name"];
        $s = $_POST["surname"];
        $p = $_POST["phone"];
        $a = $_POST["address"];
        $pass = $_POST["password1"];
        $pass = $_POST["password2"];

        $user=User::RegisterUser($e, $n, $s, $a, $p, $pass);
        $_SESSION["email"]=$user->getEmail();
        $_SESSION["id"]=$user->getId();
    }else{
        $e = $_POST["email"];
        $pass = $_POST["password"];

        $user=User::AuthenticateUser($e,$pass);
        $_SESSION["email"]=$user->getEmail();
        $_SESSION["id"]=$user->getId();
    }
}

?>
<br>
<form class="form-signin" name="registration" method="post" action="" >

    <input type="email" value="" name="email" required placeholder="E-mail"><br>
    <input type="password" value="" name="password1" required placeholder="Password"><br>
    <input type="password" value="" name="password2" required placeholder="Rewrite Password"><br>
    <input type="text" value="" name="name" required placeholder="Name"><br>
    <input type="text" value="" name="surname" required placeholder="Surname"><br>
    <input type="text" value="" name="address" placeholder="Address"><br>
    <input type="text" value="" name="phone" placeholder="Phone number"><br>

    <button type="submit">Sign Up</button>
</form>
<br>
<form class="form-signin" name="login" method="post" action="">
    <input type="text" value="" name="email" required placeholder="E-mail"><br>
    <input type="password" value="" name="password" required placeholder="Password"><br>

    <button type="submit">Sign In</button>
</form>