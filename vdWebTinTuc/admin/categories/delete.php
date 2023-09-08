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
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1>Do you want to delete <?= $cateDetail["name"]?></h1>
        </div>
        <form action="<?php echo $router->createUrl('categories/delete', ["id"=>$id])?>" method="POST">
            <input type="submit" name="submit" value="Yes">
            <input type="button" value="No" onclick="window.location.href = '<?= $router->createUrl("categories/index")?>'">
        </form>
    </body>
</html>
