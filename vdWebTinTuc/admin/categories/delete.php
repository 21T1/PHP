<?php
/**
 * Delete Category
 */
    $categories = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    $cateDetail = $categories->buildQueryParams([
        "WHERE"=>"id=:id",
        "params"=>[":id"=>$id]
    ])->selectOne();
    if(!$cateDetail)
        $router->pageNotFound();
    if($id && $router->getPOST("submit"))
        if($categories->delete('id=:id', ["id"=>$id]))
                $router->redirect('categories/index');
        else
            $router->pageError("Cannot delete this category")
?>
<html>
    <head>
        <link rel="stylesheet" href="../CSS/delete.css">
        <title>Delete Category</title>
        <?php include 'head.php'?>
    </head>
    <body>
        <div>
            <h1>Do you want to delete&ensp;<i><?= $cateDetail["name"]?></i></h1>
        </div>
        <div class="form">
            <form action="<?php echo $router->createUrl('categories/delete', ["id"=>$id])?>" method="POST">
                <input id='btn' type="submit" name="submit" value="Yes">
                <input id='btn' type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("categories/index")?>'">
            </form>
        </div>
    </body>
</html>
