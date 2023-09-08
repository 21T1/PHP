<?php
/**
 * Users List
 */
    $users = new apps_models_users();
    $user = new apps_libs_userIdentity();
    $query = $users->buildQueryParams(["OTHER"=>"ORDER BY created_time DESC"])->select();
    $router = new apps_libs_router();
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1>MANAGE USERS</h1>
            <a href="<?= $router->createUrl('users/detail')?>">+ Add new</a>
        </div>
        <div class="show-data">
            <table style="width: 100%" border="1">
                <tr>
                    <td>Id</td>
                    <td>Username</td>
                    <td>Password</td>
                    <td>Created Time</td>
                    <td>Delete</td>
                </tr>
                <?php 
                    foreach($query as $row){
                    ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td><a href="<?= $router->createUrl('users/detail', ['id'=>$row['id']])?>">
                                <?= $row['username']?>
                                </a>
                            </td>
                            <td><?= $row['password']?></td>
                            <td><?= $row['created_time']?></td>
                            <td><a href="<?= $router->createUrl('users/delete', ["id"=>$row['id']])?>">Delete</a></td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>