<?php
    $router = new apps_libs_router();

    $categories = new apps_models_categories();
    $listCate = $categories->buildQueryParams()->select();
    $posts = new apps_models_posts();
    
    $id = intval($router->getGET("id"));
    if($id){
        $postDetail = $posts->buildQueryParams([
            "SELECT"=>"posts.id, posts.name, posts.description, posts.content, posts.created_time, categories.name as cate_name",
            "WHERE"=>"posts.id=:id",
            "params"=>[":id"=>$id],
            "JOIN"=>"INNER JOIN categories ON categories.id = posts.cate_id"
        ])->selectOne();
        if(!$postDetail)
            $router->pageNotFound();
    }
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
            .detail p{
                margin-left: 20px;
                font-size: 15px;
            }
            #name{
                font-size: 20px;
                font-weight: bold;
            }
            #info{
                color: grey;
            }
            #desc{
                font-style: italic;
                border-bottom: 1px solid;
            }
        </style>
        
    </head>
    <body>
        <h1>WEBSITE TIN TUC</h1>
        <div class="tag">
            <a href="<?= $router->createUrl('home')?>" id='home'>Home</a>
            <?php
                foreach($listCate as $row){
                ?>
            <a href="<?= $router->createUrl('home', ["cate_id"=>$row["id"]])?>"><?= $row["name"]?></a>
                <?php
                }
            ?>
        </div>
        <div class="detail">
            <p id="name"><?= $postDetail['name']?></p>
            <p id="info">Post by: <?= $postDetail['cate_name']?> at <?= $postDetail['created_time']?></p>
            <p id="desc"><?= $postDetail['description']?></p>
            <p id="cont"><?= $postDetail['content']?></p>
        </div>
    </body>
</html>
