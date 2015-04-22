<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"]=='register') {
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
    }
    if($_POST["type"]=='login'){
        $e = $_POST["email"];
        $pass = $_POST["password"];

        $user=User::AuthenticateUser($e,$pass);
        if (!is_null($user)) {
            $_SESSION["email"]=$user->getEmail();
            $_SESSION["id"]=$user->getId();
            header("Location: http://localhost/Workshop2/");
            die();
        } else {
            echo "<script>alert('WRONG LOGIN DATA!')</script>";
        }
    }
}
?>
<h1>Sign Up</h1>
<br>
<form class="form-signin" name="registration" method="post" action="#" >

    <input type="email" value="" name="email" required placeholder="E-mail"><br>
    <input type="password" value="" name="password1" required placeholder="Password"><br>
    <input type="password" value="" name="password2" required placeholder="Rewrite Password"><br>
    <input type="text" value="" name="name" required placeholder="First Name"><br>
    <input type="text" value="" name="surname" required placeholder="Last Name"><br>
    <input type="text" value="" name="address" placeholder="Address"><br>
    <input type="text" value="" name="phone" placeholder="Phone number"><br>
    <input type="hidden" value="register" name="type">

    <button class='btn big-btn' type="submit">Sign Up</button>
</form>
<br>
<h1>Sign In</h1>
<br>
<form class="form-signin" name="login" method="post" action="#">
    <input type="text" value="" name="email" required placeholder="E-mail"><br>
    <input type="password" value="" name="password" required placeholder="Password"><br>
    <input type="hidden" value="login" name="type">

    <button class='btn big-btn' type="submit">Sign In</button>
</form>