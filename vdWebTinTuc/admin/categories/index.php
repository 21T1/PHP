<?php
/**
 * Categories List
 */
    $categories = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $query = $categories->buildQueryParams(["OTHER"=>"ORDER BY created_time DESC"])->select();
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
            <h1>MANAGE CATEGORIES</h1>
            <a href="<?= $router->createUrl('categories/detail')?>">Add new</a>
        </div>
        <div class="show-data" style="font-family: vPoppinsR;">
            <table style="width: 100%">
                <tr id="column">
                    <td>Id</td>
                    <td>Name</td>
                    <td>Created Time</td>
                    <td>Delete</td>
                </tr>
                <?php 
                    foreach($query as $row){
                    ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td id="name" onclick="location.href='<?= $router->createUrl('categories/detail', ['id'=>$row['id']])?>'">
                                <?= $row['name']?>
                            </td>
                            <td><?= $row['created_time']?></td>
                            <td id="del" onclick="location.href='<?= $router->createUrl('categories/delete', ["id"=>$row['id']])?>'"><i class="fa-solid fa-xmark"></i></td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>