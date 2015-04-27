<?php
$users=User::GetAllUsers();
if($users!=false){
    echo "<div class='promoted'>";
    foreach($users as $user){
        $id=$user->getId();
        $name=$user->getName();
        $surname=$user->getSurname();
        $email=$user->getEmail();
        echo "<a href='/../Workshop2/user/$id'><div class='presented_item'><div class='item_name'>$id. $name $surname</div><br>";
        echo "<i>$email</i>";
        echo "</div></a>";
    }

    echo "</div>";
}