<?php
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    if(!$user->isLogin()){
        $user->logout();
        $router->loginPage();
    }
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1>ADMIN PAGE</h1>
        </div>
        <div>
            <ul>
                <li><a href="<?= $router->createUrl('public/index')?>">Home Page</a></li>
                <li><a href="<?= $router->createUrl('posts/index')?>">Manage Post</a></li>
                <li><a href="<?= $router->createUrl('categories/index')?>">Manage Category</a></li>
                <li><a href="<?= $router->createUrl('users/index')?>">Manage User</a></li>
            </ul>
        </div>
    </body>
</html>