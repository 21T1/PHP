<?php
/**
 * Category Detail
 */
    $categories = new apps_models_categories();
    $user = new apps_libs_userIdentity();
    $router = new apps_libs_router();
    
    $id = intval($router->getGET("id"));
    
    //
    if($id){
        // SELECT * FROM categories WHERE id = $id LIMIT 1
        $cateDetail = $categories->buildQueryParams([
            "WHERE"=>"id=:id",
            "params"=>[":id"=>$id]
        ])->selectOne();
        if(!$cateDetail)
            $router->pageNotFound();
    }else
        $cateDetail = [
            "id"=>"",
            "name"=>""
        ];   
    //Add new category
    $checkName = true;
    if($router->getPOST("name")){
        $query = $categories->buildQueryParams(["OTHER"=>"ORDER BY name ASC"])->select();
        foreach($query as $row)
            if($router->getPOST("name") == $row['name']){
                $checkName = false;
                break;
            }
    }
    if($router->getPOST("submit") && $router->getPOST("name") && $checkName){
        $params = [
            ":name"=>$router->getPOST("name")
        ];
    
        $result = false;
        if($id){
            $params[':id'] = $id;
            $result = $categories->buildQueryParams([
                "value"=>"name=:name",
                "WHERE"=>"id=:id",
                "params"=>$params
            ])->update();
        } else
            $result = $categories->buildQueryParams([
                "field"=>"(name, created_by) VALUES (?, ?)",
                "value"=>[$params[":name"], $user->getId()]
            ])->insert();
    
        if($result)
            $router->redirect('categories/index');
        else
            $router->pageError('Cannot update db');
    }
?>
<html>
    <body>
        <div>
            <p>Hi <?= $user->getSESSION('username')?>,</p> 
            <p>Welcome to Demo, <a href="<?= $router->createUrl('logout')?>">Logout?</a></p>
            <h1><?= $id ? "View " : "Create New " ?>Category: <?= $cateDetail["name"]?></h1>
        </div>
        <!-- Detail of category's id = $id  -->
        <form action="<?php echo $router->createUrl('categories/detail', ["id"=>$cateDetail["id"]])?>" method="POST">
            <input type="text" name="name" value="<?= $cateDetail["name"]?>">
            <p style="display: inline"><?= $checkName ? "" : "ERROR: Category exists"?></p><br>
            <input type="submit" name="submit" value="Add">
            <input type="button" value="Cancel" onclick="window.location.href = '<?= $router->createUrl("categories/index")?>'">
        </form>
    </body>
</html>
