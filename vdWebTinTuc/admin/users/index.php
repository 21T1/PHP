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
    <head>
        <link rel="stylesheet" href="../CSS/index.css">
        <title>Manage Categories</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div class="title">
            <h1>MANAGE USERS</h1>
            <a href="<?= $router->createUrl('users/detail')?>">+ Add new</a>
        </div>
        <div class="show-data">
            <table style="width: 100%">
                <tr id="column">
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
                            <td id="name" onclick="location.href='<?= $router->createUrl('users/detail', ['id'=>$row['id']])?>'">
                                <?= $row['username']?>
                            </td>
                            <td><?= $row['password']?></td>
                            <td><?= $row['created_time']?></td>
                            <td id="del" onclick="location.href='<?= $router->createUrl('users/delete', ["id"=>$row['id']])?>'"><i class="fa-solid fa-xmark"></td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>