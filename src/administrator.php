<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin=Admin::AuthenticateAdmin($_POST["email"], $_POST["password"]);
   if(!is_null($admin)){

       $_SESSION["email"] = 'ADMIN';
       $_SESSION["id"] = $admin->getId();

       header('Location: http://localhost/Workshop2/admin_panel');
       die;


   }else{
       echo "<script>alert('WRONG LOGIN DATA!')</script>";
   }


}
?>
    <form name="login" method="post" action="">

        <input type="email" value="" name="email" required placeholder="Administrator e-mail"><br>
        <input type="password" value="" name="password" required placeholder="Password"><br>

        <button type="submit">Log in</button>
    </form>
