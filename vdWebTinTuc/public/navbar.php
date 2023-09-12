<?php
$router = new apps_libs_router();

$categories = new apps_models_categories();
//Count Category
$limitCate = $categories->buildQueryParams([
            'SELECT' => "COUNT(*)"
        ])->select()[0]["COUNT(*)"];
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/public.css">
        <title>Website</title>
        <?php include '../admin/head.php'?>
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
    </body>
</html>
