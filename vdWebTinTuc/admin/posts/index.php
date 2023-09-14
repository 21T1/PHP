<?php
/**
 * Posts List
 */
    $posts = new apps_models_posts();
    $user = new apps_libs_userIdentity();
    $list = $posts->buildQueryParams([
        "SELECT"=>"posts.id, posts.name, posts.description, posts.created_time, categories.name as cate_name",
        "OTHER"=>"ORDER BY created_time DESC",
        "JOIN"=>"INNER JOIN categories ON categories.id = posts.cate_id"
        ])->select();
    $router = new apps_libs_router();
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/index.css">
        <title>Manage Posts</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div class="title">        
            <h1>MANAGE POST</h1>
            <a href="<?= $router->createUrl('posts/detail')?>">+ Add new</a>
        </div>
        <div class="show-data">
            <table style="width: 100%">
                <tr id="column">
                    <td>Id</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Description</td>
                    <td>Created Time</td>
                    <td>Delete</td>
                </tr>
                <?php 
                    foreach($list as $row){
                    ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td id="name" onclick="location.href='<?= $router->createUrl('posts/detail', ['id'=>$row['id']])?>'">
                                <?= $row['name']?>
                            </td>
                            <td><i><?= $row['cate_name']?></i></td>
                            <td><?= $row['description']?></td>
                            <td><?= $row['created_time']?></td>
                            <td id="del" onclick="location.href='<?= $router->createUrl('posts/delete', ["id"=>$row['id']])?>'"><i class="fa-solid fa-xmark"></td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>

