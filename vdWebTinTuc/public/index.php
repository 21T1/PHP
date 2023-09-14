<?php
$router = new apps_libs_router();

$page = $router->getGET("page") ? intval($router->getGET("page")) : 1;

$currentCateId = "cate_id=".$router->getGET("cate_id");
if($page!==1 &&  strpos($_SERVER['HTTP_REFERER'],$currentCateId) == false)
        $page = 1;
$posts = new apps_models_posts();
$numPost = count($posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : ""])->select());
$numPage = intval(ceil($numPost / 6));
$listPost = $posts->buildQueryParams([
            'WHERE' => $router->getGET('cate_id') ? "cate_id = " . intval($router->getGET('cate_id')) : "",
            'OTHER' => "LIMIT 6 OFFSET " . (intval($page) - 1) * 6
        ])->select();
?>
<html>
    <head>
        <?php include 'navbar.php'?>
        <style>
            .link a{
                color: currentColor;
                padding: 0 10px;
                font-size: 20px;
            }
            .link a:hover{
                background-color: var(--effect-color);
            }
            #postDesc{
                margin-top: 30px;
                padding: 10px;
            }
            #postDesc img{
                float: left;
                width: 20%;
                aspect-ratio: 1 / 1;
                padding-right: 10px;
                object-fit: cover;
            }
            #postDesc p{
                padding: 0;
                margin: 0;
                text-align: justify;
            }
            #time{
                float: right;
            }
        </style>
    </head>
    <body>
        <!--Post List-->
        <ul class="list">
        <?php
        foreach ($listPost as $row) {
            ?>
            <li><a href="<?= $router->createUrl('../public/postDetail', ['id' => $row['id']]) ?>">
            <?= $row['name'] ?></a>
                <div id="postDesc">
                    <?php
                        $url = "http://localhost".$router->createUrl('../public/postDetail', ['id' => $row['id']]);
                        $htmlString = file_get_contents($url);
                        $htmlDom = new DOMDocument;
                        @$htmlDom->loadHTML($htmlString);

                        $imageTags = $htmlDom->getElementsByTagName('img');

                        $extractedImages = array();
                        foreach($imageTags as $imageTag){
                            $imgSrc = $imageTag->getAttribute('src');
                            break;
                        }
                    ?>
                    <img src="<?=$imgSrc?>" alt="img">
                    <p><?= $row['description'] ?></p>
                </div>
                <p id="time"><?= $row['created_time']?></p>    
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
