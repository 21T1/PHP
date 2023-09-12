<?php
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    if(!$user->isLogin()){
        $user->logout();
        $router->loginPage();
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/home.css">
        <title>Admin Page</title>
    </head>
    <body>
        <?php include("head.php"); ?>
        <h1>Admin Page</h1>
        <div class="list">
            <ul>
                <li onclick="location.href='<?= $router->createUrl('../public/index')?>'">Home Page</li>
                <li onclick="location.href='<?= $router->createUrl('posts/index')?>'">Manage Post</li>
                <li onclick="location.href='<?= $router->createUrl('categories/index')?>'">Manage Category</li>
                <li onclick="location.href='<?= $router->createUrl('users/index')?>'">Manage User</li>
            </ul>
        </div>
    </body>
</html>