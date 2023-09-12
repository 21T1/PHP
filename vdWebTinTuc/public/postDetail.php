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
        <?php include 'navbar.php'?>
        <style type="text/css">
            .detail{
                margin-top: 30px;
                display: flex;
                justify-content: center;
                flex-direction: column;
                background-color: var(--light-color);
                padding: 10px;
            }
            .detail p{
                margin-bottom: 0px;
            }
            #name{
                font-size: 20px;
                font-weight: bold;
            }
            #desc{
                font-style: italic;
                border-bottom: 1px solid var(--border-color);
            }
        </style>
        
    </head>
    <body>
        <div class="detail">
            <p id="name"><?= $postDetail['name']?></p>
            <p id="info">Post by: <?= $postDetail['cate_name']?> at <?= $postDetail['created_time']?></p>
            <p id="desc"><?= $postDetail['description']?></p>
            <p id="cont"><?= $postDetail['content']?></p>
        </div>
    </body>
</html>
