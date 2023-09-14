<?php
    $router = new apps_libs_router();

    $categories = new apps_models_categories();
    $listCate = $categories->buildQueryParams()->select();
    $posts = new apps_models_posts();
    
    $id = intval($router->getGET("id"));
    if($id){
        $postDetail = $posts->buildQueryParams([
            "SELECT"=>"posts.id, posts.name, posts.description, posts.content, posts.created_time, categories.name as cate_name, users.username",
            "WHERE"=>"posts.id=:id",
            "params"=>[":id"=>$id],
            "JOIN"=>"INNER JOIN categories ON categories.id = posts.cate_id"
                ." INNER JOIN users ON users.id = posts.created_by"
        ])->selectOne();
        if(!$postDetail)
            $router->pageNotFound();
    }
    var_dump($_SERVER["HTTP_REFERER"]);
?>
<html>
    <head>
        <title>Website</title>
        <?php include 'navbar.php'?>
        <style>
            .container{
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .detail{
                margin-top: 30px;
                display: flex;
                justify-content: center;
                flex-direction: column;
                background-color: var(--light-color);
                padding: 10px;
                width: 100vh;
            }
            .detail p{
                margin-bottom: 0px;
            }
            #name{
                font-size: 20px;
                font-weight: bold;
            }
            #info{
                display: flex;
                justify-content: space-between;
            }
            #desc{
                font-style: italic;
                border-bottom: 1px solid var(--border-color);
            }
        </style>
        
    </head>
    <body>
        <div class="container">
            <div class="detail">
                <p id="name"><?= $postDetail['name']?></p>
                <div id="info">
                    <p>Category: <?= $postDetail['cate_name']?></p>
                    <p>Post by: <?= $postDetail['username']?> at <?= $postDetail['created_time']?></p>
                </div>
                <p id="desc"><?= $postDetail['description']?></p>
                <p id="cont"><?= $postDetail['content']?></p>
            </div>
        </div>   
    </body>
</html>
