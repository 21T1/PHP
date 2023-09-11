<?php
$router = new apps_libs_router();

$categories = new apps_models_categories();
$page = $router->getGET("page") ? intval($router->getGET("page")) : 1;

$posts = new apps_models_posts();
$numPost = count($posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : ""])->select());
$numPage = intval(ceil($numPost / 5));
$listPost = $posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : "",
            'OTHER' => "LIMIT 5 OFFSET " . (intval($page) - 1) * 5
        ])->select();
//Count Category
$limitCate = $categories->buildQueryParams([
            'SELECT' => "COUNT(*)"
        ])->select()[0]["COUNT(*)"];
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
                font-family: Arial;
                overflow: hidden;
            }
            #home, .tag a, .dropdown #btn{
                font-size: 20px;
                color: blue;
                text-decoration: none;
                padding: 15px;
            }
            #home{
                margin-left: 50px;
            }
            .list{
                font-size: 15px;
            }
            .dropdown {
                overflow: hidden;
            }
            #btn {
                border: none;
                outline: none;
                background-color: inherit;
            }
            .dropdown-content {
                display: none;
                position: absolute;
                z-index: 1;
                background-color: lightgray;
            }

            .dropdown-content a {
                float: none;
                text-decoration: none;
                display: block;
                text-align: left;
            }
            .dropdown:hover .dropdown-content{
                display: block;
            }
            .dropdown-content a:hover{
                background-color: rgba(0, 0, 0, 0.1);
            }
        </style>

    </head>
    <body>
        <h1>WEBSITE TIN TUC</h1>
        <div class="tag">
            <a href="<?= $router->createUrl('../public/index') ?>" id='home'>Home</a>
            <!-- Navbar -->
            <?php
            foreach ($categories->buildQueryParams([
                'OTHER' => "LIMIT 5"
            ])->select() as $row) {
                ?>
                <a href="<?= $router->createUrl('../public/index', ["cate_id" => $row["id"], "page" => $page]) ?>"><?= $row["name"] ?></a>
                <?php
            }
            ?>
            <!--More Category-->
            <div class="dropdown">
                <button id="btn">More</button>
                <div class="dropdown-content">
                    <?php
                    foreach ($categories->buildQueryParams([
                        'OTHER' => "LIMIT $limitCate OFFSET 5"
                    ])->select() as $row) {
                        ?>
                        <a href="<?= $router->createUrl('../public/index', ["cate_id" => $row["id"], "page" => $page]) ?>"><?= $row["name"] ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--Post List-->
        <ul class="list">
        <?php
        foreach ($listPost as $row) {
            ?>
            <li><a href="<?= $router->createUrl('../public/postDetail', ['id' => $row['id'], "page" => $page]) ?>">
            <?= $row['name'] ?></a>
            <p><?= $row['description'] ?></p>
            </li>
            <?php
        }
        ?>
        </ul>
        <!-- Page list -->
        <div class="link">
            <?php
            if($numPage == 0){
                ?><p>Post's Number = 0</p><?php
            }else{
                for ($i = 1; $i <= $numPage; $i++) {
                ?>
                <a href="<?= $router->createUrl('../public/index', ["cate_id" => $router->getGET('cate_id'), "page" => $i]) ?>"><?= $i ?></a>
                <?php
            }}
            ?>
        </div>
    </body>
</html>
