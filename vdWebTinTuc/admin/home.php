<?php
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
?>
<html>
    <body>
        <div>
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout</a></p>
            <h1>ADMIN PAGE</h1>
        </div>
        <div>
            <ul>
                <li><a href="<?= $router->createUrl('post/post')?>">Manage Post</a></li>
                <li><a href="<?= $router->createUrl('category/cate')?>">Manage Category</a></li>
                <li><a href="<?= $router->createUrl('user/users')?>">Manage Users</a></li>
            </ul>
        </div>
    </body>
</html>