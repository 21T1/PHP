<?php
    $router = new apps_libs_router();
    
    $categories = new apps_models_categories();
    $listCate = $categories->buildQueryParams()->select();
    
    $page = $router->getGET("page") ? intval($router->getGET("page")) : 1;

    $posts = new apps_models_posts();
    $listPost = $posts->buildQueryParams([
        'WHERE'=>$router->getGET('cate_id') 
                ? "cate_id = ".intval($router->getGET('cate_id'))
                : "",
        'OTHER'=>"LIMIT 10 OFFSET ".(intval($page)-1)*10
    ])->select();
    
    $numPage = ceil(count($listPost)/10);    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Website</title>
        <style type="text/css">
            .tag{
                width: 100%;
                height: 50px;
                background-color: lightgray;
                display: flex;
                align-items: center;
            }
            .tag a, #home{
                font-size: 20px;
                padding: 15px;
            }
            #home{
                margin-left: 50px;
            }
            .list{
                font-size: 15px;
            }
        </style>
        
    </head>
    <body>
        <h1>WEBSITE TIN TUC</h1>
        <div class="tag">
            <a href="<?= $router->createUrl('../public/index')?>" id='home'>Home</a>
            <?php
                foreach($listCate as $row){
                ?>
                    <a href="<?= $router->createUrl('../public/index', ["cate_id"=>$row["id"], "page"=>$page])?>"><?= $row["name"]?></a>
                <?php
                }
            ?>
        </div>
        <ul class="list">
            <?php
                foreach($listPost as $row){
                ?>
                <li><a href="<?= $router->createUrl('../public/postDetail', ['id'=>$row['id']])?>">
                    <?= $row['name']?></a>
                    <p><?= $row['description']?></p>
                </li>
                <?php
                }
            ?>
        </ul>
        <div class="link">
            <?php
                for($i = 1; $i <= $numPage; $i++){
                ?>
                    <a href="<?= $router->createUrl('../public/index', ["cate_id"=>$router->getGET('cate_id'), "page"=>$i])?>"><?= $i?></a>
                <?php
                }
            ?>
        </div>
    </body>
</html>
