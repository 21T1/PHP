<?php
$router = new apps_libs_router();

$page = $router->getGET("page") ? intval($router->getGET("page")) : 1;

$posts = new apps_models_posts();
$numPost = count($posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : ""])->select());
$numPage = intval(ceil($numPost / 5));
$listPost = $posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : "",
            'OTHER' => "LIMIT 5 OFFSET " . (intval($page) - 1) * 5
        ])->select();
?>
<html>
    <head>
        <?php include 'navbar.php'?>
    </head>
    <body>
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
