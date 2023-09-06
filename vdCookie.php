<?php
    if(isset($_POST["username"]) && isset($_POST["password"])){
        var_dump($_COOKIE);
        //khoi tao
        $user = $_POST["username"];
        $pass = $_POST["password"];
        //gan gia tri tu form cho cookie
        setcookie($user, $pass);
    }
?>

<html>
    <form action="vdCookie.php" method="POST" enctype="multipart/form-data">
        Username:<input type="text" name="username"/>
        Password:<input type="password" name="password"/>
        <input type="submit"/>
    </form>
</html>